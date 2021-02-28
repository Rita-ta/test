<?php
/**
 * This template is for displaying part of blog.
 *
 */
?>

<div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class( 'post' ); ?>>
    <div class="post__body">
        <div class="post__text">
            <?php the_title( '<h2 class="post__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
            <?php the_excerpt(); ?>
            <div class="post__bot">
                <div class="post__info">
                        <span><i><?php echo esc_html__( 'Category:', 'test' ); ?></i><?php echo test_get_post_terms( array( 'taxonomy' => 'category', 'items_wrap' => '%s' ) ); ?></span>
                        <?php
                        $target_audience = ! empty( $target_audience = get_post_meta( get_the_ID(), 'test_post_target', true ) ) ? $target_audience : '';
                        if ( $target_audience ) :
                        ?>
                        <span><i><?php echo esc_html__( 'Target audience:', 'test' ); ?></i><?php echo esc_html( $target_audience ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
