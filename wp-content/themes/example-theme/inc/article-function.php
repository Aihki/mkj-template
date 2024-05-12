<?php
function generate_article($products): void
{
    if ($products->have_posts()) :
        while ($products->have_posts()) :
            $products->the_post();
            $permalink = get_the_permalink();
            ?>

            <article class="product">
                <a href="<?php echo $permalink; ?>" style="display: block; color: inherit; text-decoration: none;">
                    <?php
                    the_post_thumbnail('thumbnail');
                    the_title('<h3>', '</h3>');
                    $excerpt = get_the_excerpt();
                    ?>
                    <p>
                        <?php
                        echo substr($excerpt, 0, 50);
                        ?>...
                    </p>
                </a>
                <a href="#" class="open-modal"  id="button" data-id="<?php echo get_the_ID(); ?>">Open in modal</a>
            </article>
        <?php
        endwhile;
    else :
        _e('Sorry, no posts matched your criteria.', 'vaikka');
    endif;
}