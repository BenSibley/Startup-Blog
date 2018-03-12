<?php if ( is_active_sidebar( 'footer-area' ) ) : 
  $widgets      = get_option( 'sidebars_widgets' );
	$widget_class = count( $widgets['footer-area'] );
  ?>
	<aside id="sidebar-footer-area" class="sidebar sidebar-footer-area active-<?php echo $widget_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'footer-area' ); ?>
	</aside>
<?php endif;