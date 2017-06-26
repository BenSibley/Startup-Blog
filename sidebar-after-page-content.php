<?php if ( is_active_sidebar( 'after-page-content' ) ) : ?>
	<aside class="sidebar sidebar-after-page-content" id="sidebar-after-page-content" role="complementary">
		<?php dynamic_sidebar( 'after-page-content' ); ?>
	</aside>
<?php endif;