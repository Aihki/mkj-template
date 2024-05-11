<?php
/*
Plugin Name: Comment Plugin
Description: Adds a comment system to posts
Version: 1.0
Author: Aihki
*/

register_activation_hook(__FILE__, 'create_comments_table');
function create_comments_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'custom_comments';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_id mediumint(9) NOT NULL,
        comment text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
function submit_comment()
{
    check_ajax_referer('submit-comment-nonce', 'nonce', true);

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $comment_content = isset($_POST['comment']) ? sanitize_text_field($_POST['comment']) : '';

    if (empty($post_id) || empty($comment_content)) {
        wp_send_json_error('Invalid data provided.');
    }

    $commentdata = array(
        'comment_post_ID' => $post_id,
        'comment_content' => $comment_content,
        // Add other comment data here
    );

    $comment_id = wp_new_comment($commentdata);

    if ($comment_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_comments';
        $wpdb->insert(
            $table_name,
            array(
                'post_id' => $post_id,
                'comment' => $comment_content,
            )
        );

        wp_send_json_success('Comment submitted successfully.');
    } else {
        wp_send_json_error('Failed to submit comment.');
    }
}


add_action('wp_ajax_submit_comment', 'submit_comment');
add_action('wp_ajax_nopriv_submit_comment', 'submit_comment');

function display_comments_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'post_id' => get_the_ID(),
    ), $atts);

    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_comments';
    $comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d ORDER BY id DESC", $atts['post_id']));

    $comments = get_comments(array(
        'post_id' => $atts['post_id'],
        'order' => 'DESC',
    ));

    ob_start();
    if ($comments) {
        foreach ($comments as $comment) {
            ?>
            <div class="comment">
                <h3><?php echo esc_html($comment->comment_author); ?></h3>
                <p><?php echo esc_html($comment->comment_content); ?></p>
                <p><?php echo esc_html($comment->comment_date); ?></p>
            </div>
            <?php
        }
    } else {
        echo '<p>No comments yet. Be the first to comment!</p>';
    }
    return ob_get_clean();
}
add_shortcode('display_comments', 'display_comments_shortcode');

function comment_form_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'post_id' => null,
    ), $atts);

    $nonce = wp_create_nonce('submit-comment-nonce');

    ob_start();
    ?>
    <form id="comment-form">
        <input type="hidden" id="submit-comment-nonce" value="<?php echo esc_attr($nonce); ?>">
        <input type="hidden" id="post_id" value="<?php echo esc_attr($atts['post_id']); ?>">
        <textarea id="comment" placeholder="Your comment" required></textarea><br>
        <input type="submit" value="Submit">
    </form>
    <div id="comments_container">
        <?php echo do_shortcode('[display_comments post_id="' . esc_attr($atts['post_id']) . '"]'); ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('comment_form', 'comment_form_shortcode');

function comment_plugin_scripts()
{
    wp_enqueue_script('comment-plugin', plugin_dir_url(__FILE__) . 'comment.js', array('jquery'), '1.0', true);
    wp_localize_script('comment-plugin', 'comment_plugin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

add_action('wp_enqueue_scripts', 'comment_plugin_scripts');

?>