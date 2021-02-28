<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header();
?>

<section class="section">
    <div class="container posts-container">
        <div class="post-filter">
            <div class="post-filter-block post-filter-cat">
                <p><?php echo esc_html__( 'Categories', 'test' ); ?></p>
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#" data-term-id="all"><?php echo esc_html__( 'All', 'test' ); ?></a></li>
                    <?php
                    $categories = get_categories();
                    if ( $categories ) :
                        foreach ( $categories as $category ) :
                            echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" data-term-id="' . esc_attr( $category->term_id ) . '">' . esc_html( $category->name ) . '</a></li>';
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            <div class="post-filter-block post-filter-target">
                <p><?php echo esc_html__( 'Target audience', 'test' ); ?></p>
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#" data-target="all"><?php echo esc_html__( 'All', 'test' ); ?></a></li>
                    <li><a href="#" data-target="man"><?php echo esc_html__( 'Man', 'test' ); ?></a></li>
                    <li><a href="#" data-target="woman"><?php echo esc_html__( 'Woman', 'test' ); ?></a></li>
                    <li><a href="#" data-target="children"><?php echo esc_html__( 'Children', 'test' ); ?></a></li>
                </ul>
            </div>
            <div class="post-filter-block post-filter-sort">
                <p><?php echo esc_html__( 'Sort by title', 'test' ); ?></p>
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#" data-sort="default"><?php echo esc_html__( 'Default', 'test' ); ?></a></li>
                    <li><a href="#" data-sort="ASC"><?php echo esc_html__( 'ASC', 'test' ); ?></a></li>
                    <li><a href="#" data-sort="DESC"><?php echo esc_html__( 'DESC', 'test' ); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="posts">
            <?php
            if ( have_posts() ) :

                // Start the Loop.
                while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/post/content' );

                endwhile;

            endif;

            the_posts_pagination();
            ?>
        </div>
    </div>
</section>

<?php get_footer();
