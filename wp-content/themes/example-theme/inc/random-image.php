<?php


function get_random_post_image($category_id, $count = 3): array
{
    $args = [
        'post_type'      => 'post',
        'cat'            => $category_id,
        'posts_per_page' => $count,
        'orderby'        => 'rand',
    ];
    $random_posts = new WP_Query($args);
    $images = [];
    if($random_posts->have_posts()):
        while($random_posts->have_posts()):
            $random_posts->the_post();
            $featured_image_url = wp_get_attachment_url(get_post_thumbnail_id());
            if ($featured_image_url){
                $images[] = $featured_image_url;
            }
        endwhile;
    endif;
    wp_reset_postdata();
    return $images;
}

?>