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
    <button id="close">Close</button>
    <article class="single" id="modal-content"></article>
</dialog>

<?php wp_footer(); ?>
</body>

</html>