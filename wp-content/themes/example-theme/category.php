<?php
get_header();
?>

    <section class="hero">
        <div class="hero-text">
            <?php
            echo '<h1>' . single_cat_title('', false) . '</h1>';
            echo '<p>' . category_description() . '</p>';
            ?>
        </div>

        <?php
        $images = get_random_post_image(get_queried_object_id(), 3);
        $image_count = count($images);
        if (!empty($images)) {
            echo '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">';
            echo '<ol class="carousel-indicators">';
            for ($i = 0; $i < $image_count; $i++) {
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '"' . ($i === 0 ? ' class="active"' : '') . '></li>';
            }
            echo '</ol>';
            echo '<div class="carousel-inner">';
            foreach ($images as $index => $image) {
                echo '<div class="carousel-item' . ($index === 0 ? ' active' : '') . '">';
                echo '<img class="d-block w-100" src="' . $image . '" alt="product">';
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
        }
        ?>

    </section>
    <main>
        <section class="product-container">
            <h2><?php single_cat_title() ?></h2>
            <?php
            generate_article($wp_query);
            ?>
        </section>
    </main>

<?php
get_footer();