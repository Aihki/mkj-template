<?php
/*
Plugin Name: Rating Plugin
Description: Adds a rating system to posts
Version: 1.0
Author: Aihki
*/

// Create table
function create_rating_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'ratings';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_id mediumint(9) NOT NULL,
        user_id mediumint(9) NOT NULL,
        rating INT(1) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'create_rating_table' );

// Add rating form

function rating_form() {
    global $wpdb;

    $post_id = get_the_ID();
    $user_id = get_current_user_id();

    $table_name = $wpdb->prefix . 'ratings';

    // Check if the user has already rated the post
    $rating = $wpdb->get_var( "SELECT rating FROM $table_name WHERE post_id = $post_id AND user_id = $user_id" );

    if ( $rating ) {
        // If the user has already rated the post, display the rating
        return display_stars( $rating );
    } else {
        // If the user has not rated the post, display the form
        $nonce = wp_create_nonce( 'rating_form_nonce' );

        $output = '<form id="rating-form" method="post" action="' . admin_url( 'admin-ajax.php' ) . '">';
        $output .= '<input type="hidden" name="action" value="add_rating">';
        $output .= '<input type="hidden" name="rating_form_nonce" value="' . $nonce . '">';
        $output .= '<input type="hidden" name="post_id" value="' . $post_id . '">';

        // Add radio buttons for star rating
        for ($i = 1; $i <= 5; $i++) {
            $output .= '<input type="radio" name="rating" value="' . $i . '" required> ' . $i . ' ';
        }

        $output .= '<input type="submit" value="Submit Rating">';
        $output .= '</form>';

        return $output;
    }
}

add_shortcode( 'rating_form', 'rating_form' );

// Add rating to database
function add_rating() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'ratings';

    $post_id = $_POST['post_id'];
    $user_id = get_current_user_id();
    $rating = $_POST['rating'];

    $data = [
        'post_id' => $post_id,
        'user_id' => $user_id,
        'rating' => $rating
    ];

    $format = [
        '%d',
        '%d',
        '%d'
    ];

    $wpdb->insert( $table_name, $data, $format );

    // Return a JSON response
    header( 'Content-Type: application/json' );
    echo json_encode([
        'success' => true,
        'message' => 'Rating added successfully'
    ]);
    exit;
}

add_action( 'wp_ajax_add_rating', 'add_rating' );
add_action( 'wp_ajax_nopriv_add_rating', 'add_rating' );

// Calculate average rating
function get_average_rating($post_id) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'ratings';

    $average = $wpdb->get_var( "SELECT AVG(rating) FROM $table_name WHERE post_id = $post_id" );

    return round( $average, 1 );
}

// Display stars
function display_stars($rating) {
    $output = '';

    // Add full stars
    for ($i = 1; $i <= floor($rating); $i++) {
        $output .= '<i class="fas fa-star"></i>';
    }

    // Add half star if the rating is not a whole number
    if ($rating - floor($rating) >= 0.5) {
        $output .= '<i class="fas fa-star-half-alt"></i>';
    }

    // Add empty stars
    for ($i = ceil($rating); $i < 5; $i++) {
        $output .= '<i class="far fa-star"></i>';
    }

    return $output;
}

// Enqueue scripts
// Enqueue scripts
function setup_scripts2(): void {
    // Enqueue Ionicons
    error_log('setup_scripts2 is called');
    wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', [], '5.15.4' );

    wp_enqueue_script( 'rating-plugin-script', plugin_dir_url( __FILE__ ) . 'rating.js', [ 'jquery' ], '1.0', true );
    wp_localize_script( 'rating-plugin-script', 'rating_plugin', [
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ] );
}

add_action( 'wp_enqueue_scripts', 'setup_scripts2' );