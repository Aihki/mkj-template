<footer>
    <div class="footer-section">
        <nav>
            <h2>Links</h2>
            <?php wp_nav_menu(['container' => '', 'menu_class' => 'footer-nav', 'theme_location' => 'main-menu']); ?>
        </nav>
    </div>
    <div class="footer-section">
        <h2>About Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris.</p>
    </div>
</footer>
</div>

<dialog id="single-post">
    <article class="single-product" id="modal-content"></article>
    <button id="close">Close</button>
</dialog>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php wp_footer(); ?>
</body>

</html>