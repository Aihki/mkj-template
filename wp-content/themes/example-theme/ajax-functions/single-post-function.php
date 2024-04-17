<?php
function single_post(): void {
    header( 'Content-Type: application/json');
    $post_id = $_POST['post_id'];
    $post = get_post( $post_id );
    echo json_encode( $post );
    wp_die();
}

add_action( 'wp_ajax_single_post', 'single_post' );