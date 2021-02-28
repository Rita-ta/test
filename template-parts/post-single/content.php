<div class="post">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post__img">
            <?php the_post_thumbnail( 'test-post-thumb' ); ?>
        </div>
    <?php endif; ?>
    <div class="post__text">
        <?php the_content(); ?>
    </div>
</div>
