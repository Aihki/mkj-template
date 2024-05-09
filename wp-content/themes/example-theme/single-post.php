<?php
get_header();
?>

    <Main class="full-width">
        <section class="products">
            <div class="single-content">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        the_title('<h1>', '</h1>');
                        the_content();
                    endwhile;
                else :
                    _e('Sorry, no posts matched your criteria.', 'vaikka');
                endif;
                ?>

                <div class="single-actions">
                    <div class ="rating">
                        <?php echo do_shortcode( '[rating_form]' ); ?>
                    </div>
                    <div class ="shortcodes">
                        <?php echo do_shortcode( '[like_button]' ); ?>
                    </div>
                </div>
                <div class="now">
                    <button>buy now</button>
                </div>
                <div class="center-content">
                    <?php echo do_shortcode('[comment_form]'); ?>
                </div>
            </div>
        </section>
        <div class="custom-title">
        <h2>You maybe like these</h2>
        </div>
        <section class="recommendation">
            <?php
            $current_category = get_queried_object();
            $args = array(
                //'category_name' => $current_category->slug,
                'posts_per_page' => 3,
                'orderby' => 'rand',
                'order' => 'DESC',
                'post__not_in' => array(get_the_ID()),
            );
            $new_products = new WP_Query($args);
            generate_recommendation($new_products);
            ?>
        </section>
    </main>
<?php
get_footer();
?>