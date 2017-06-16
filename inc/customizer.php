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

	/***** Ignite Plus Control *****/

	class ct_business_blog_slider_howto extends WP_Customize_Control {
		public function render_content() {
			echo '<span class="customize-control-title">' . __( "Tutorials", "business-blog") . '</span>';
			echo '<ul class="tutorial-list">';
				echo '<li><a href="#">' . __("How to create custom excerpts", "business-blog") . '</a></li>';
				echo '<li><a href="#">' . __("How to choose custom images for Posts", "business-blog") . '</a></li>';
			echo '</ul>';
		}
	}
	class ct_business_blog_slider_custom_howto extends WP_Customize_Control {
		public function render_content() {
			echo '<span class="customize-control-title">' . __( "Tutorials", "business-blog") . '</span>';
			echo '<ul class="tutorial-list">';
				echo '<li><a href="#">' . __("How to get the ID of a post/page", "business-blog") . '</a></li>';
				echo '<li><a href="#">' . __("How to create custom excerpts for Pages", "business-blog") . '</a></li>';
			echo '<li><a href="#">' . __("How to choose custom images for Pages", "business-blog") . '</a></li>';
			echo '</ul>';
		}
	}

	/********** Add Panels **********/

	// Add panel for colors
	if ( method_exists( 'WP_Customize_Manager', 'add_panel' ) ) {

		$wp_customize->add_panel( 'business_blog_slider_panel', array(
			'priority'    => 20,
			'title'       => __( 'Slider', 'business-blog' ),
			'description' => __( 'Setup the slider', 'business-blog' )
		) );
	}

	/***** Slider *****/

	// section
	$wp_customize->add_section( 'business_blog_slider_settings', array(
		'title'    => __( 'Settings', 'business-blog' ),
		'priority' => 1,
		'panel'    => 'business_blog_slider_panel'
	) );
	// setting
	$wp_customize->add_setting( 'slider_type', array(
		'default'           => 'recent-posts',
		'sanitize_callback' => 'ct_business_blog_sanitize_slider_type'
	) );
	// control
	$wp_customize->add_control( 'slider_type', array(
		'label'    => __( 'Slider type', 'business-blog' ),
		'section'  => 'business_blog_slider_settings',
		'settings' => 'slider_type',
		'type'     => 'radio',
		'choices'  => array(
			'recent-posts' => __( 'Recent Posts', 'business-blog' ),
			'custom'       => __( 'Custom', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_display', array(
		'default'           => 'homepage',
		'sanitize_callback' => 'ct_business_blog_sanitize_slider_display'
	) );
	// control
	$wp_customize->add_control( 'slider_display', array(
		'label'    => __( 'Display slider on:', 'business-blog' ),
		'section'  => 'business_blog_slider_settings',
		'settings' => 'slider_display',
		'type'     => 'radio',
		'choices' => array(
			'homepage'  => __( 'Homepage', 'business-blog' ),
			'blog'      => __( 'Blog', 'business-blog' ),
			'all-pages' => __( 'All Pages', 'business-blog' ),
			'no'        => __( 'Do not display', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_arrow_navigation', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_arrow_navigation', array(
		'label'    => __( 'Display arrow navigation?', 'business-blog' ),
		'section'  => 'business_blog_slider_settings',
		'settings' => 'slider_arrow_navigation',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_dot_navigation', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_business_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_dot_navigation', array(
		'label'    => __( 'Display dot navigation?', 'business-blog' ),
		'section'  => 'business_blog_slider_settings',
		'settings' => 'slider_dot_navigation',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'business-blog' ),
			'no'  => __( 'No', 'business-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_button_text', array(
		'default'           => __( 'Read more', 'business-blog'),
		'sanitize_callback' => 'ct_business_blog_sanitize_text'
	) );
	// control
	$wp_customize->add_control( 'slider_button_text', array(
		'label'    => __( 'Button text', 'business-blog' ),
		'section'  => 'business_blog_slider_settings',
		'settings' => 'slider_button_text',
		'type'     => 'text'
	) );
	// section
	$wp_customize->add_section( 'business_blog_slider_recent_posts', array(
		'title'    => __( 'Recent Posts', 'business-blog' ),
		'description'    => __( 'Select the "Recent Posts" slider type in Slider > Settings to use these options.', 'business-blog' ),
		'priority' => 1,
		'panel' => 'business_blog_slider_panel'
	) );
	// setting
	$wp_customize->add_setting( 'slider_recent_posts', array(
		'default'           => '5',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'slider_recent_posts', array(
		'label'    => __( 'Number of posts in slider', 'business-blog' ),
		'section'  => 'business_blog_slider_recent_posts',
		'settings' => 'slider_recent_posts',
		'type'     => 'number'
	) );
	// setting
	$wp_customize->add_setting( 'slider_post_category', array(
		'default'           => 'all',
		'sanitize_callback' => 'ct_business_blog_sanitize_post_categories'
	) );
	$categories_array = array( 'all' => 'All' );
	foreach ( get_categories() as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}
	// control
	$wp_customize->add_control( 'slider_post_category', array(
		'label'    => __( 'Post category', 'business-blog' ),
		'section'  => 'business_blog_slider_recent_posts',
		'settings' => 'slider_post_category',
		'type'     => 'select',
		'choices' => $categories_array
	) );
	// Setting
	$wp_customize->add_setting( 'slider_howto' );
	// Control
	$wp_customize->add_control( new ct_business_blog_slider_howto(
		$wp_customize, 'slider_howto', array(
			'section'  => 'business_blog_slider_recent_posts',
			'settings' => 'slider_howto'
		)
	) );
	// section
	$wp_customize->add_section( 'business_blog_slider_custom', array(
		'title'    => __( 'Custom', 'business-blog' ),
		'description'    => __( 'Select the "Custom" slider type in Slider > Settings to use these options.', 'business-blog' ),
		'priority' => 2,
		'panel' => 'business_blog_slider_panel'
	) );
	// setting
	$wp_customize->add_setting( 'slider_ids', array(
		'default'           => '',
		'sanitize_callback' => 'ct_business_blog_sanitize_text'
	) );
	// control
	$wp_customize->add_control( 'slider_ids', array(
		'label'    => __( 'Post/Page IDs', 'business-blog' ),
		'description'    => __( 'Comma separated list of IDs (ex. 9,23,7) ', 'business-blog' ),
		'section'  => 'business_blog_slider_custom',
		'settings' => 'slider_ids',
		'type'     => 'text'
	) );
	// Setting
	$wp_customize->add_setting( 'slider_howto_custom' );
	// Control
	$wp_customize->add_control( new ct_business_blog_slider_custom_howto(
		$wp_customize, 'slider_howto_custom', array(
			'section'  => 'business_blog_slider_custom',
			'settings' => 'slider_howto_custom'
		)
	) );
	
	/***** Colors *****/

	// section
	$wp_customize->add_section( 'business_blog_colors', array(
		'title'    => __( 'Colors', 'business-blog' ),
		'priority' => 20
	) );
	// setting
	$wp_customize->add_setting( 'color_primary', array(
		'default'           => '#20a4e6',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_primary', array(
			'label'       => __( 'Primary Color', 'business-blog' ),
			'section'     => 'business_blog_colors',
			'settings'    => 'color_primary',
			'priority'    => 10
		)
	) );
	// setting
	$wp_customize->add_setting( 'color_secondary', array(
		'default'           => '#17e6c3',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_secondary', array(
			'label'       => __( 'Secondary Color', 'business-blog' ),
			'section'     => 'business_blog_colors',
			'settings'    => 'color_secondary',
			'priority'    => 10
		)
	) );
	// setting
	$wp_customize->add_setting( 'color_background', array(
		'default'           => '#f0f5f8',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'color_background', array(
			'label'       => __( 'Background Color', 'business-blog' ),
			'section'     => 'business_blog_colors',
			'settings'    => 'color_background',
			'priority'    => 10
		)
	) );
	
	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_business_blog_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_business_blog_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'business-blog' ),
		'priority'    => 30,
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
		'priority' => 25
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
		'default'           => '30',
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

function ct_business_blog_sanitize_slider_type( $input ) {

	$valid = array(
		'recent-posts' => __( 'Recent Posts', 'business-blog' ),
		'custom'       => __( 'Custom', 'business-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_business_blog_sanitize_slider_display( $input ) {

	$valid = array(
		'homepage'  => __( 'Homepage', 'business-blog' ),
		'blog'      => __( 'Blog', 'business-blog' ),
		'all-pages' => __( 'All Pages', 'business-blog' ),
		'no'        => __( 'Do not display', 'business-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_business_blog_sanitize_post_categories( $input ) {

	$categories_array = array( 'all' => 'All' );
	foreach ( get_categories() as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}

	return array_key_exists( $input, $categories_array ) ? $input : '';
}
