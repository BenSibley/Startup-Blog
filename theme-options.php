<?php

function ct_business_blog_register_theme_page() {
	add_theme_page( __( 'Business_blog Dashboard', 'business-blog' ), __( 'Business_blog Dashboard', 'business-blog' ), 'edit_theme_options', 'business_blog-options', 'ct_business_blog_options_content', 'ct_business_blog_options_content' );
}
add_action( 'admin_menu', 'ct_business_blog_register_theme_page' );

function ct_business_blog_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => add_query_arg( 'page', 'business_blog-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	?>
	<div id="business_blog-dashboard-wrap" class="wrap">
		<h2><?php _e( 'Business_blog Dashboard', 'business-blog' ); ?></h2>
		<?php do_action( 'business_blog_theme_options_before' ); ?>
		<div class="content content-customization">
			<h3><?php _e( 'Customization', 'business-blog' ); ?></h3>
			<p><?php _e( 'Click the "Customize" link in your menu, or use the button below to get started customizing Business_blog', 'business-blog' ); ?>.</p>
			<p>
				<a class="button-primary"
				   href="<?php echo esc_url( $customizer_url ); ?>"><?php _e( 'Use Customizer', 'business-blog' ) ?></a>
			</p>
		</div>
		<div class="content content-support">
			<h3><?php _e( 'Support', 'business-blog' ); ?></h3>
			<p><?php _e( "You can find the knowledgebase, changelog, support forum, and more in the Business_blog Support Center", "business-blog" ); ?>.</p>
			<p>
				<a target="_blank" class="button-primary"
				   href="https://www.competethemes.com/documentation/business_blog-support-center/"><?php _e( 'Visit Support Center', 'business-blog' ); ?></a>
			</p>
		</div>
		<div class="content content-premium-upgrade">
			<h3><?php _e( 'Business_blog Pro', 'business-blog' ); ?></h3>
			<p><?php _e( 'Download the Business_blog Pro plugin and unlock custom colors, new layouts, sliders, and more', 'business-blog' ); ?>...</p>
			<p>
				<a target="_blank" class="button-primary"
				   href="https://www.competethemes.com/business_blog-pro/"><?php _e( 'See Full Feature List', 'business-blog' ); ?></a>
			</p>
		</div>
		<div class="content content-resources">
			<h3><?php _e( 'WordPress Resources', 'business-blog' ); ?></h3>
			<p><?php _e( 'Save time and money searching for WordPress products by following our recommendations', 'business-blog' ); ?>.</p>
			<p>
				<a target="_blank" class="button-primary"
				   href="https://www.competethemes.com/wordpress-resources/"><?php _e( 'View Resources', 'business-blog' ); ?></a>
			</p>
		</div>
		<div class="content content-review">
			<h3><?php _e( 'Leave a Review', 'business-blog' ); ?></h3>
			<p><?php _e( 'Help others find Business_blog by leaving a review on wordpress.org.', 'business-blog' ); ?></p>
			<a target="_blank" class="button-primary" href="https://wordpress.org/support/view/theme-reviews/business_blog"><?php _e( 'Leave a Review', 'business-blog' ); ?></a>
		</div>
		<div class="content content-delete-settings">
			<h3><?php _e( 'Reset Customizer Settings', 'business-blog' ); ?></h3>
			<p>
				<?php printf( __( "<strong>Warning:</strong> Clicking this button will erase the Business_blog theme's current settings in the <a href='%s'>Customizer</a>.", 'business-blog' ), esc_url( $customizer_url ) ); ?>
			</p>
			<form method="post">
				<input type="hidden" name="business_blog_reset_customizer" value="business_blog_reset_customizer_settings"/>
				<p>
					<?php wp_nonce_field( 'business_blog_reset_customizer_nonce', 'business_blog_reset_customizer_nonce' ); ?>
					<?php submit_button( __( 'Reset Customizer Settings', 'business-blog' ), 'delete', 'delete', false ); ?>
				</p>
			</form>
		</div>
		<?php do_action( 'business_blog_theme_options_after' ); ?>
	</div>
<?php }