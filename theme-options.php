<?php

//----------------------------------------------------------------------------------
// Add menu item for Startup Blog options page
//----------------------------------------------------------------------------------
/* TRT Note: wp_get_theme( get_template() ) is used extensively to remove "Startup Blog" from needing translation.
** Most strings of text are the same across all my themes, so more translations can be reused by taking out the theme name */
if ( ! function_exists( 'ct_startup_blog_register_theme_page' ) ) {
	function ct_startup_blog_register_theme_page() {
		// translators: %s = theme name
		add_theme_page( sprintf( esc_html__( '%s Dashboard', 'startup-blog' ), esc_attr( wp_get_theme( get_template() ) ) ), esc_attr( wp_get_theme( get_template() ) ), 'edit_theme_options', 'startup-blog-options', 'ct_startup_blog_options_content', 'ct_startup_blog_options_content' );
	}
}
add_action( 'admin_menu', 'ct_startup_blog_register_theme_page' );

//----------------------------------------------------------------------------------
// Output the markup for the theme options page
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_startup_blog_options_content' ) ) {
	function ct_startup_blog_options_content() {

		$customizer_url = add_query_arg(
			array(
				'url'    => get_home_url(),
				'return' => add_query_arg( 'page', 'startup-blog-options', admin_url( 'themes.php' ) )
			),
			admin_url( 'customize.php' )
		);
		$support_url    = 'https://www.competethemes.com/documentation/startup-blog-support-center/';
		?>
		<div id="startup-blog-dashboard-wrap" class="wrap">
			<h2>
				<?php
				// translators: %s = theme name
				printf( esc_html__( '%s Dashboard', 'startup-blog' ), esc_attr( wp_get_theme( get_template() ) ) );
				?>
			</h2>
			<?php do_action( 'ct_startup_blog_theme_options_before' ); ?>
			<div class="content-boxes">
				<div class="content content-support">
					<h3><?php esc_html_e( 'Get Started', 'startup-blog' ); ?></h3>
					<p>
						<?php
						// translators: %s = theme name
						printf( __( 'Not sure where to start? The <strong>%1$s Getting Started Guide</strong> will take you step-by-step through every feature in  %1$s.', 'startup-blog' ), esc_attr( wp_get_theme( get_template() ) ) );
						?>
					</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/help/getting-started-startup-blog/"><?php esc_html_e( 'Get Started', 'startup-blog' ); ?></a>
					</p>
				</div>
				<?php if ( ! function_exists( 'ct_startup_blog_pro_activation_notice' ) ) : ?>
					<div class="content content-premium-upgrade">
						<h3><?php printf( esc_html__( 'Startup Blog Pro', 'startup-blog' ), esc_attr( wp_get_theme( get_template() ) ) ); ?></h3>
						<p>
							<?php
							// translators: %s = theme name
							printf( esc_html__( 'Download the %s Pro plugin and unlock six new layouts, four post templates, advanced color controls, and more.', 'startup-blog' ), esc_attr( wp_get_theme( get_template() ) ) );
							?>
						</p>
						<p>
							<a target="_blank" class="button-primary"
							   href="https://www.competethemes.com/startup-blog-pro/"><?php esc_html_e( 'See Full Feature List', 'startup-blog' ); ?></a>
						</p>
					</div>
				<?php endif; ?>
				<div class="content content-review">
					<h3><?php esc_html_e( 'Leave a Review', 'startup-blog' ); ?></h3>
					<p>
						<?php
						// translators: %s = theme name
						printf( esc_html__( 'Help others find %s by leaving a review on wordpress.org.', 'startup-blog' ), esc_attr( wp_get_theme( get_template() ) ) );
						?>
					</p>
					<a target="_blank" class="button-primary"
					   href="https://wordpress.org/support/theme/startup-blog/reviews/"><?php esc_html_e( 'Leave a Review', 'startup-blog' ); ?></a>
				</div>
				<div class="content content-presspad">
					<h3><?php esc_html_e( 'Turn Startup Blog into a Mobile App', 'startup-blog' ); ?></h3>
					<p><?php printf( esc_html__( '%s can be converted into a mobile app and listed on the App Store and Google Play Store with the help of PressPad News. Read our tutorial to learn more.', 'startup-blog' ), wp_get_theme( get_template() ) ); ?></p>
					<a target="_blank" class="button-primary" href="https://www.competethemes.com/help/convert-mobile-app-startup-blog/"><?php esc_html_e( 'Read Tutorial', 'startup-blog' ); ?></a>
				</div>
				<div class="content content-delete-settings">
					<h3><?php esc_html_e( 'Reset Customizer Settings', 'startup-blog' ); ?></h3>
					<p>
						<?php
						// translators: %1$s = URL to theme page. %2$s = theme name
						printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'startup-blog' ), esc_url( $customizer_url ), esc_attr( wp_get_theme( get_template() ) ) );
						?>
					</p>
					<form method="post">
						<input type="hidden" name="startup_blog_reset_customizer"
						       value="startup_blog_reset_customizer_settings"/>
						<p>
							<?php wp_nonce_field( 'startup_blog_reset_customizer_nonce', 'startup_blog_reset_customizer_nonce' ); ?>
							<?php submit_button( esc_html__( 'Reset Customizer Settings', 'startup-blog' ), 'delete', 'delete', false ); ?>
						</p>
					</form>
				</div>
			</div>
			<?php do_action( 'ct_startup_blog_theme_options_after' ); ?>
		</div>
	<?php }
}