<?php

// Front-end scripts
function ct_business_blog_load_scripts_styles() {

	wp_enqueue_style( 'ct-business_blog-google-fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400|Raleway:400,700,400italic' );

	wp_enqueue_script( 'ct-business_blog-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-business_blog-js', 'objectL10n', array(
		'openMenu'       => __( 'open menu', 'business-blog' ),
		'closeMenu'      => __( 'close menu', 'business-blog' ),
		'openChildMenu'  => __( 'open dropdown menu', 'business-blog' ),
		'closeChildMenu' => __( 'close dropdown menu', 'business-blog' )
	) );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'ct-business_blog-style', get_stylesheet_uri() );

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_business_blog_load_scripts_styles' );

// Back-end scripts
function ct_business_blog_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_business_blog-options' ) {
		wp_enqueue_style( 'ct-business_blog-admin-styles', get_template_directory_uri() . '/styles/admin.min.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'ct_business_blog_enqueue_admin_styles' );

// Customizer scripts
function ct_business_blog_enqueue_customizer_scripts() {
	wp_enqueue_script( 'ct-business_blog-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'ct-business_blog-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_business_blog_enqueue_customizer_scripts' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_business_blog_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-business_blog-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );

}
add_action( 'customize_preview_init', 'ct_business_blog_enqueue_customizer_post_message_scripts' );