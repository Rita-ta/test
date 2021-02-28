<?php
/**
 * The template ragistration/login form.
 *
 * Template Name: Register/Login
 *
 */

get_header();
?>

<section class="section">
    <div class="container">
        <?php
        if ( have_posts() ) :

            // Start the Loop.
            while ( have_posts() ) : the_post();

                the_content();

            endwhile;

        endif;
        ?>
    </div>
</section>

<?php get_footer();
