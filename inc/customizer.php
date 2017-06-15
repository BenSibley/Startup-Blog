<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_business_blog_add_customizer_content' );

function ct_business_blog_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 1;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'business-blog' );
	}

	/***** Add PostMessage Support *****/

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_business_blog_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_business_blog_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'business-blog' ),
		'priority'    => 25,
		'description' => __( 'Add the URL for each of your social profiles.', 'business-blog' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_business_blog_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'business-blog' ),
				'section'  => 'ct_business_blog_social_media_icons',
				'priority' => $priority
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $social_site == 'rss' ) {
				$label = 'RSS';
			} elseif ( $social_site == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $social_site == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $social_site == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $social_site == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $social_site == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $social_site == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $social_site == 'qq' ) {
				$label = 'QQ';
			} elseif ( $social_site == 'vk' ) {
				$label = 'VK';
			} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			} elseif ( $social_site == 'paypal' ) {
				$label = 'PayPal';
			} elseif ( $social_site == 'email-form' ) {
				$label = 'Contact Form';
			} elseif ( $social_site == 'google-wallet' ) {
				$label = 'Google Wallet';
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_business_blog_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'business-blog' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_business_blog_social_media_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label,
					'section'  => 'ct_business_blog_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Show/Hide *****/

	// section
	$wp_customize->add_section( 'business_blog_show_hide', array(
		'title'    => __( 'Show/Hide Elements', 'business-blog' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'tagline', array(
		'default'           => 'header-footer',
		'sanitize_callback' => 'ct_business_blog_sanitize_tagline_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline', array(
		'label'    => __( 'Show the tagline?', 'business-blog' ),
		'section'  => 'business_blog_show_hide',
		'settings' => 'tagline',
		'type'     => 'radio',
		'choices'  => array(
			'header-footer' => __( 'Yes, in the header & footer', 'business-blog' ),
			'header'        => __( 'Yes, in the header', 'business-blog' ),
			'footer'        => __( 'Yes, in the footer', 'business-blog' ),
			'no'            => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_byline_date', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_byline_date', array(
		'label'    => __( 'Show date in post byline?', 'business-blog' ),
		'section'  => 'business_blog_show_hide',
		'settings' => 'post_byline_date',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_byline_author', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_byline_author', array(
		'label'    => __( 'Show author name in post byline?', 'business-blog' ),
		'section'  => 'business_blog_show_hide',
		'settings' => 'post_byline_author',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_avatars', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_avatars', array(
		'label'    => __( 'Show post author avatars?', 'business-blog' ),
		'section'  => 'business_blog_show_hide',
		'settings' => 'author_avatars',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_box', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_box', array(
		'label'    => __( 'Show author box after posts?', 'business-blog' ),
		'section'  => 'business_blog_show_hide',
		'settings' => 'author_box',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'sidebar', array(
		'default'           => 'after',
		'sanitize_callback' => 'ct_business_blog_sanitize_sidebar_settings'
	) );
	// control
	$wp_customize->add_control( 'sidebar', array(
		'label'    => __( 'Show sidebar on mobile devices?', 'business-blog' ),
		'section'  => 'business_blog_show_hide',
		'settings' => 'sidebar',
		'type'     => 'radio',
		'choices'  => array(
			'after'  => __( 'Yes, after main content', 'business-blog' ),
			'before' => __( 'Yes, before main content', 'business-blog' ),
			'no'     => __( 'No', 'business-blog' )
		)
	) );

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'business_blog_blog', array(
		'title'    => __( 'Blog', 'business-blog' ),
		'priority' => 50
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'business-blog' ),
		'section'  => 'business_blog_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'business-blog' ),
		'section'  => 'business_blog_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_business_blog_sanitize_show_hide( $input ) {

	$valid = array(
		'show' => __( 'Show', 'business-blog' ),
		'hide' => __( 'Hide', 'business-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_business_blog_sanitize_email( $input ) {
	return sanitize_email( $input );
}

// sanitize yes/no settings
function ct_business_blog_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'business-blog' ),
		'no'  => __( 'No', 'business-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_business_blog_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_business_blog_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_business_blog_sanitize_tagline_settings( $input ) {

	$valid = array(
		'header-footer' => __( 'Yes, in the header & footer', 'business-blog' ),
		'header'        => __( 'Yes, in the header', 'business-blog' ),
		'footer'        => __( 'Yes, in the footer', 'business-blog' ),
		'no'            => __( 'No', 'business-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_business_blog_sanitize_sidebar_settings( $input ) {

	$valid = array(
		'after'  => __( 'Yes, after main content', 'business-blog' ),
		'before' => __( 'Yes, before main content', 'business-blog' ),
		'no'     => __( 'No', 'business-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/***** Helper Functions *****/

function ct_business_blog_customize_preview_js() {

	$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"https://www.competethemes.com/business_blog-pro/\" target=\"_blank\">" . __( 'View the Business_blog Pro Plugin', 'business-blog' ) . " <span>&rarr;</span></a></div>')</script>";
	echo apply_filters( 'ct_business_blog_customizer_ad', $content );
}

add_action( 'customize_controls_print_footer_scripts', 'ct_business_blog_customize_preview_js' );