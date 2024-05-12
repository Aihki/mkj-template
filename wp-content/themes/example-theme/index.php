<?php
get_header();
?>

<?php
if (is_front_page()) {
    echo '<section class="hero">
        <div class="hero-text">';

    if (have_posts()) :
        while (have_posts()) :
            the_post();
            if (is_page('about-us')) {
                // Include 'about-us.php' file
                get_template_part('about-us');
            } else {
                // Display content for other pages
                the_title('<h1>', '</h1>');
                the_content();
            }
        endwhile;
    else :
        _e('Sorry, no posts matched your criteria.', 'vaikka');
    endif;

    echo '</div>';
    the_custom_header_markup();

    echo '</section>

    <main>

    <section class="product-container">
    
 <section class="categories">';
    $products_category = get_term_by('slug', 'products', 'category');
    if ($products_category) {
        $args = array('child_of' => $products_category->term_id);
        $categories = get_categories($args);
        foreach ($categories as $category) {
            $category_link = get_category_link($category->term_id);
            echo '<a class="category-button" href="' . esc_url($category_link) . '" title="' . $category->name . '">' . $category->name . '</a><br>';
        }
    } else {
        echo 'The "products" category does not exist.';
    }
    echo '</section>

        <h2>Owl choice</h2>';


    $args = array(
        'tag' => 'owl-choice',
        'posts_per_page' => 3,
        'orderby' => 'rand'
    );
    $products = new WP_Query($args);
    generate_article($products);

    echo '</section>


    </main>';
} elseif (is_page('tietoa-meista')) {
    echo '<section class="about-us">
        <div class="content">
            <h2>About Us</h2>
            <p>Here you can find information about our company.</p>
        </div>
        <div class="container">
            <div class="lef-side">
                <div class="info">
                    <h3>Our Story</h3>
                    <p>Our company was founded in 2020. We are a small team of professionals who are passionate about our work.</p>
                </div>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345096036!2d144.95373531531592!3d-37.81720997975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce6e0!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sfi!4v1630966294194!5m2!1sen!2sfi" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="form">
                <h3>Contact Us</h3>
                <form action="your_php_script.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>';
}
?>

<?php
get_footer();
?>
