<?php

// Front-end scripts
function ct_ct_theme_name_load_scripts_styles() {

	wp_enqueue_style( 'ct-ct_theme_name-google-fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400|Raleway:400,700,400italic' );

	wp_enqueue_script( 'ct-ct_theme_name-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-ct_theme_name-js', 'objectL10n', array(
		'openMenu'       => __( 'open menu', 'ct_theme_name' ),
		'closeMenu'      => __( 'close menu', 'ct_theme_name' ),
		'openChildMenu'  => __( 'open dropdown menu', 'ct_theme_name' ),
		'closeChildMenu' => __( 'close dropdown menu', 'ct_theme_name' )
	) );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'ct-ct_theme_name-style', get_stylesheet_uri() );

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_ct_theme_name_load_scripts_styles' );

// Back-end scripts
function ct_ct_theme_name_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_ct_theme_name-options' ) {
		wp_enqueue_style( 'ct-ct_theme_name-admin-styles', get_template_directory_uri() . '/styles/admin.min.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'ct_ct_theme_name_enqueue_admin_styles' );

// Customizer scripts
function ct_ct_theme_name_enqueue_customizer_scripts() {
	wp_enqueue_script( 'ct-ct_theme_name-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'ct-ct_theme_name-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_ct_theme_name_enqueue_customizer_scripts' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_ct_theme_name_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-ct_theme_name-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );

}
add_action( 'customize_preview_init', 'ct_ct_theme_name_enqueue_customizer_post_message_scripts' );