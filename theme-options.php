<?php

function ct_business_blog_register_theme_page() {
	add_theme_page( sprintf( esc_html__( '%s Dashboard', 'business-blog' ), wp_get_theme( get_template() ) ), sprintf( esc_html__( '%s Dashboard', 'business-blog' ), wp_get_theme( get_template() ) ), 'edit_theme_options', 'business-blog-options', 'ct_business_blog_options_content', 'ct_business_blog_options_content' );
}
add_action( 'admin_menu', 'ct_business_blog_register_theme_page' );

function ct_business_blog_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => get_home_url(),
			'return' => add_query_arg( 'page', 'business-blog-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$support_url = 'https://www.competethemes.com/documentation/business-blog-support-center/';
	?>
	<div id="business-blog-dashboard-wrap" class="wrap">
		<h2><?php printf( esc_html__( '%s Dashboard', 'business-blog' ), wp_get_theme( get_template() ) ); ?></h2>
		<?php do_action( 'ct_business_blog_theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php esc_html_e( 'Get Started', 'business-blog' ); ?></h3>
				<p><?php printf( esc_html__( 'Not sure where to start? The %1$s Support Center is filled with tutorials that will take you step-by-step through every feature in %1$s.', 'business-blog' ), wp_get_theme( get_template() ) ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/documentation/business-blog-support-center/"><?php esc_html_e( 'Visit Support Center', 'business-blog' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_business_blog_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php printf( esc_html__( 'Business Blog Pro', 'business-blog' ), wp_get_theme( get_template() ) ); ?></h3>
					<p><?php printf( esc_html__( 'Download the %s Pro plugin and unlock custom colors, new fonts, sliders, and more', 'business-blog' ), wp_get_theme( get_template() ) ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/business-blog-pro/"><?php esc_html_e( 'See Full Feature List', 'business-blog' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php esc_html_e( 'Leave a Review', 'business-blog' ); ?></h3>
				<p><?php printf( esc_html__( 'Help others find %s by leaving a review on wordpress.org.', 'business-blog' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/business-blog/reviews/"><?php esc_html_e( 'Leave a Review', 'business-blog' ); ?></a>
			</div>
			<div class="content content-presspad">
				<h3><?php esc_html_e( 'Turn Business Blog into a Mobile App', 'business-blog' ); ?></h3>
				<p><?php printf( esc_html__( '%s can be converted into a mobile app and listed on the App Store with the help of PressPad News. Read our tutorial to learn more.', 'business-blog' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/help/convert-mobile-app-business-blog/"><?php esc_html_e( 'Read Tutorial', 'business-blog' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php esc_html_e( 'Reset Customizer Settings', 'business-blog' ); ?></h3>
				<p>
					<?php printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'business-blog' ), esc_url( $customizer_url ), wp_get_theme( get_template() ) ); ?>
				</p>
				<form method="post">
					<input type="hidden" name="business_blog_reset_customizer" value="business_blog_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'business_blog_reset_customizer_nonce', 'business_blog_reset_customizer_nonce' ); ?>
						<?php submit_button( esc_html__( 'Reset Customizer Settings', 'business-blog' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'ct_business_blog_theme_options_after' ); ?>
	</div>
<?php }