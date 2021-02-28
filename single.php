<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();
?>

<section class="section">
    <div class="container">
        <?php

        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/post-single/content' );

        endwhile;

        ?>
    </div>
</section>

<?php get_footer();
