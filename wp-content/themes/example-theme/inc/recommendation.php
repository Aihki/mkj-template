<?php
function generate_recommendation($products): void
{
    if ($products->have_posts()) :
        while ($products->have_posts()) :
            $products->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="product-link">
                <article class="product-recommendation">
                    <?php
                    the_post_thumbnail('thumbnail');
                    the_title('<h3>', '</h3>');
                    $excerpt = get_the_excerpt();
                    ?>
                </article>
            </a>
        <?php
        endwhile;
    else :
        _e('Sorry, no posts matched your criteria.', 'vaikka');
    endif;
}
