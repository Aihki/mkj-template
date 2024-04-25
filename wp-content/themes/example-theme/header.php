<!DOCTYPE html>
<html lang= <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>

</head>

<body>
<div class="container">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
            <?php the_custom_logo(); ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php wp_nav_menu(['container' => '', 'menu_class' => 'navbar-nav ml-auto', 'theme_location' => 'main-menu']); ?>
        </div>
    </nav>
    <section class="breadcrumbs">
        <?php if (function_exists('bcn_display')) {
            bcn_display();
        } ?>
    </section>