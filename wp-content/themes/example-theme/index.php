<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        the_title(before:'<h1>', after:'</h1>');
        the_content();
    endwhile;
else :
    _e( 'Sorry, no posts matched your criteria.', 'vaikka' );
endif;
?>