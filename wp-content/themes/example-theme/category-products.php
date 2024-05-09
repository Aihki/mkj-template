<?php
get_header();
?>


    <main>
        <div class="book-categories">
            <h1>Book Categories</h1>
            <p>Here you can find all the products we offer.
                Click on a category to see the products in that category.</p>
        </div>
        <section class="categories">
            <?php
            $subcategories = get_categories([
                'child_of' => get_queried_object_id(),
                'hide_empty' => true,
            ]);
            foreach ($subcategories as $subcategory):
                echo '<div class="category-box">';
                echo '<h2><a href="' . get_category_link($subcategory->term_id) . '">' . $subcategory->name . '</a></h2>';
                echo '</div>';
            endforeach;
            ?>
        </section>
        <div class="custom-title">
            <h2>Newly Added Products</h2>
        </div>
        <section class="new-products">
            <?php
            $args = array(
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $new_products = new WP_Query($args);
            generate_article($new_products);
            ?>
        </section>
    </main>

<?php
get_footer();