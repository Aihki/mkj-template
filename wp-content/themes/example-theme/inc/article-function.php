<?php
function generate_article($products): void
{

    if ($products->have_posts()) :
        while ($products->have_posts()) :
            $products->the_post();
            ?>

            <article class="product">
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
                <a href="<?php the_permalink(); ?>">Read more</a>
                <a href="#" class="open-modal" data-id="<?php echo get_the_ID(); ?>">Open in modal</a>
            </article>
        <?php
        endwhile;
    else :
        _e('Sorry, no posts matched your criteria.', 'vaikka');
    endif;
}