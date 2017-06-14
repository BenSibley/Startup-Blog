<?php get_header(); ?>
    <div class="post-header search-header">
        <h1 class="post-title">
            <?php printf( __( 'Search Results for %s', 'business-blog' ), '<span>&ldquo;' . get_search_query() . '&rdquo;</span>' ); ?>
        </h1>
        <?php get_search_form(); ?>
    </div>
    <div id="loop-container" class="loop-container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'content', 'archive' );
            endwhile;
        endif;
        ?>
    </div>

<?php the_posts_pagination(); ?>

<div class="post-header search-header bottom">
    <p><?php _e( "Can't find what you're looking for?  Try refining your search:", "business-blog" ); ?></p>
    <?php get_search_form(); ?>
</div>

<?php get_footer();