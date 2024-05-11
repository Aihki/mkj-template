<?php

/*
Plugin Name: Like Button
Description: Adds a like button to posts
Version: 1.0
Author: Aihki
*/

// Create table

function create_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'likes';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_id mediumint(9) NOT NULL,
        user_id mediumint(9) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'create_table' );

// Add like button
function like_button($atts) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'likes';

    $post_id = get_the_ID();

    if(!$post_id) {
        $post_id = $atts['post_id'];
    }

    // get all likes for count
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d", $post_id ) );

    $likes = count( $results );

    $user_id = get_current_user_id();

    // get user likes
    $user_like = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d AND user_id = %d", $post_id, $user_id ) );

    $icon = 'heart';
    if ( $user_like ) {
        $icon = 'heart-dislike';
    }

    $output = '<form id="like-form" method="post" action="' . admin_url( 'admin-post.php' ) . '">';
    $output .= '<input type="hidden" name="action" value="add_like">';
    $output .= '<input type="hidden" name="post_id" value="' . $post_id . '">';
    $output .= '<input type="hidden" name="user_id" value="' . $user_id . '">';
    $output .= '<button id="like-button" style="
										    border: 0;
										    background-color: rgba(0,0,0,0);
											">';
    $output .= '<ion-icon name="' . $icon . '" style="color: #e21212;"></ion-icon>';
    $output .= '</button>';
    $output .= '<span id="like-count">' . $likes . '</span>';
    $output .= '</form>';

    return $output;
}

add_shortcode( 'like_button', 'like_button' );

// Add like to database

function add_like() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'likes';

    $post_id = $_POST['post_id'];
    $user_id = get_current_user_id();

    $data = [
        'post_id' => $post_id,
        'user_id' => $user_id
    ];

    $format = [
        '%d',
        '%d'
    ];

    // check if user has already liked
    $like = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d AND user_id = %d", $post_id, $user_id ) );


    if ( $like ) {
        $wpdb->delete( $table_name, $data, $format );

        // get all likes for count
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d", $post_id ) );

        $likes = count( $results );
        header( 'Content-Type: application/json' );
        echo '{
			"likes": ' . $likes . ',
			"liked": false,
			"message": "Like removed",
			"user_id": ' . $user_id . '	
		}';
        // wp_redirect( $_SERVER['HTTP_REFERER'] );
        exit;
    }


    $success = $wpdb->insert( $table_name, $data, $format );

    // get all likes for count
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d", $post_id ) );

    $likes = count( $results );

    if ( $success ) {
        header( 'Content-Type: application/json' );
        echo '{
			"likes": ' . $likes . ',
			"liked": true,
			"message": "Like added",	
			"user_id": ' . $user_id . '	
		}';
    } else {
        header( 'HTTP/1.1 500 Internal Server Error');
    }


    // wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit;
}

add_action( 'wp_ajax_add_like', 'add_like' );
add_action( 'wp_ajax_nopriv_add_like', 'add_like' );

// add_action( 'admin_post_add_like', 'add_like' );

// enqueue icons
function setup_scripts(): void {
    // Load Ionicons font from CDN
    wp_enqueue_script( 'my-theme-ionicons', 'https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js', [], '7.1.0', true );
    wp_enqueue_script( 'like-button-script', plugin_dir_url( __FILE__ ) . 'like-button.js', [ 'jquery' ], '1.0', true );
    wp_localize_script( 'like-button-script', 'like_button', [
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ] );
}

add_action( 'wp_enqueue_scripts', 'setup_scripts' );