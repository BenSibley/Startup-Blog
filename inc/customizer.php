<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_startup_blog_add_customizer_content' );

function ct_startup_blog_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'startup-blog' );
	}

	/***** Custom Controls *****/

	class ct_startup_blog_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/startup-blog-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . get_template_directory_uri() . "/assets/images/startup-blog-pro.png' srcset='" . get_template_directory_uri() . "/assets/images/startup-blog-pro-2x.png 2x' /></a>";
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%1$s">%2$s Pro</a> makes advanced customization simple - and fun too!', 'startup-blog'), $link, wp_get_theme( get_template() ) ) . "</p>";
			echo "<p>" . sprintf( esc_html_x('%s Pro adds the following features:', 'Startup Blog Pro adds the following features:', 'startup-blog'), wp_get_theme( get_template() ) ) . "</p>";
			echo "<ul>
					<li>" . esc_html__('6 new layouts', 'startup-blog') . "</li>
					<li>" . esc_html__('Custom colors', 'startup-blog') . "</li>
					<li>" . esc_html__('New fonts', 'startup-blog') . "</li>
					<li>" . esc_html__('+ 11 more features', 'startup-blog') . "</li>
				  </ul>";
			// translators: placeholder is "Startup Blog"
			echo "<p class='button-wrapper'><a target=\"_blank\" class='startup-blog-pro-button' href='" . $link . "'>" . sprintf( esc_html_x('View %s Pro', 'View Startup Blog Pro', 'startup-blog'), wp_get_theme( get_template() ) ) . "</a></p>";
		}
	}

	/***** Startup Blog Pro Section *****/

	// section
	$wp_customize->add_section( 'ct_startup_blog_pro', array(
		'title'    => sprintf( __( '%s Pro', 'startup-blog' ), wp_get_theme( get_template() ) ),
		'priority' => 1
	) );
	// setting
	$wp_customize->add_setting( 'startup_blog_pro', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new ct_startup_blog_pro_ad(
		$wp_customize, 'startup_blog_pro', array(
			'section'  => 'ct_startup_blog_pro',
			'settings' => 'startup_blog_pro'
		)
	) );

	/***** Slider *****/

	// section
	$wp_customize->add_section( 'startup_blog_slider_settings', array(
		'title'    => __( 'Recent Posts Slider', 'startup-blog' ),
		'priority' => 20
	) );
	// setting
	$wp_customize->add_setting( 'slider_recent_posts', array(
		'default'           => '5',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'slider_recent_posts', array(
		'label'    => __( 'Number of posts in slider', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_recent_posts',
		'type'     => 'number'
	) );
	// setting
	$wp_customize->add_setting( 'slider_post_category', array(
		'default'           => 'all',
		'sanitize_callback' => 'ct_startup_blog_sanitize_post_categories'
	) );
	$categories_array = array( 'all' => 'All' );
	foreach ( get_categories() as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}
	// control
	$wp_customize->add_control( 'slider_post_category', array(
		'label'    => __( 'Post category', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_post_category',
		'type'     => 'select',
		'choices' => $categories_array
	) );
	// setting
	$wp_customize->add_setting( 'slider_display', array(
		'default'           => 'homepage',
		'sanitize_callback' => 'ct_startup_blog_sanitize_slider_display'
	) );
	// control
	$wp_customize->add_control( 'slider_display', array(
		'label'    => __( 'Display slider on:', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_display',
		'type'     => 'radio',
		'choices' => array(
			'homepage'  => __( 'Homepage', 'startup-blog' ),
			'blog'      => __( 'Blog', 'startup-blog' ),
			'all-pages' => __( 'All Pages', 'startup-blog' ),
			'no'        => __( 'Do not display', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_arrow_navigation', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_arrow_navigation', array(
		'label'    => __( 'Display arrow navigation?', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_arrow_navigation',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_dot_navigation', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_dot_navigation', array(
		'label'    => __( 'Display dot navigation?', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_dot_navigation',
		'type'     => 'radio',
		'choices' => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'slider_button_text', array(
		'default'           => __( 'Read more', 'startup-blog'),
		'sanitize_callback' => 'ct_startup_blog_sanitize_text'
	) );
	// control
	$wp_customize->add_control( 'slider_button_text', array(
		'label'    => __( 'Button text', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_button_text',
		'type'     => 'text'
	) );
	// setting
	$wp_customize->add_setting( 'slider_sticky', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'slider_sticky', array(
		'label'    => __( 'Include "sticky" posts?', 'startup-blog' ),
		'section'  => 'startup_blog_slider_settings',
		'settings' => 'slider_sticky',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	
	/***** Colors *****/

	// section
	$wp_customize->add_section( 'startup_blog_colors', array(
		'title'    => __( 'Colors', 'startup-blog' ),
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
			'label'       => __( 'Primary Color', 'startup-blog' ),
			'section'     => 'startup_blog_colors',
			'settings'    => 'color_primary'
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
			'label'       => __( 'Secondary Color', 'startup-blog' ),
			'section'     => 'startup_blog_colors',
			'settings'    => 'color_secondary'
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
			'label'       => __( 'Background Color', 'startup-blog' ),
			'section'     => 'startup_blog_colors',
			'settings'    => 'color_background'
		)
	) );

	/***** Layout *****/

	// section
	$wp_customize->add_section( 'startup_blog_layout', array(
		'title'    => __( 'Layout', 'startup-blog' ),
		'priority' => 25,
		'description' => sprintf( __( 'Want more layouts? Check out the <a target="_blank" href="%1$s">%2$s Pro plugin</a>.', 'startup-blog' ), 'https://www.competethemes.com/startup-blog/', wp_get_theme( get_template() ) )
	) );
	// setting
	$wp_customize->add_setting( 'layout', array(
		'default'           => 'right-sidebar',
		'sanitize_callback' => 'ct_startup_blog_sanitize_layout'
	) );
	// control
	$wp_customize->add_control( 'layout', array(
		'label'    => __( 'Choose a Layout', 'startup-blog' ),
		'section'  => 'startup_blog_layout',
		'settings' => 'layout',
		'type'     => 'radio',
		'choices'  => array(
			'right-sidebar' => __( 'Right sidebar', 'startup-blog' ),
			'left-sidebar'  => __( 'Left sidebar', 'startup-blog' )
		)
	) );
	
	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_startup_blog_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_startup_blog_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'startup-blog' ),
		'priority'    => 30,
		'description' => __( 'Add the URL for each of your social profiles.', 'startup-blog' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_startup_blog_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'startup-blog' ),
				'section'  => 'ct_startup_blog_social_media_icons',
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
					'sanitize_callback' => 'ct_startup_blog_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'startup-blog' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_startup_blog_social_media_icons',
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
					'section'  => 'ct_startup_blog_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Show/Hide *****/

	// section
	$wp_customize->add_section( 'startup_blog_show_hide', array(
		'title'    => __( 'Show/Hide Elements', 'startup-blog' ),
		'priority' => 25
	) );
	// setting
	$wp_customize->add_setting( 'tagline', array(
		'default'           => 'header-footer',
		'sanitize_callback' => 'ct_startup_blog_sanitize_tagline_settings'
	) );
	// control
	$wp_customize->add_control( 'tagline', array(
		'label'    => __( 'Show the tagline?', 'startup-blog' ),
		'section'  => 'startup_blog_show_hide',
		'settings' => 'tagline',
		'type'     => 'radio',
		'choices'  => array(
			'header-footer' => __( 'Yes, in the header & footer', 'startup-blog' ),
			'header'        => __( 'Yes, in the header', 'startup-blog' ),
			'footer'        => __( 'Yes, in the footer', 'startup-blog' ),
			'no'            => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_byline_date', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_byline_date', array(
		'label'    => __( 'Show date in post byline?', 'startup-blog' ),
		'section'  => 'startup_blog_show_hide',
		'settings' => 'post_byline_date',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'post_byline_author', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'post_byline_author', array(
		'label'    => __( 'Show author name in post byline?', 'startup-blog' ),
		'section'  => 'startup_blog_show_hide',
		'settings' => 'post_byline_author',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_avatars', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_avatars', array(
		'label'    => __( 'Show post author avatars?', 'startup-blog' ),
		'section'  => 'startup_blog_show_hide',
		'settings' => 'author_avatars',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'author_box', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'author_box', array(
		'label'    => __( 'Show author box after posts?', 'startup-blog' ),
		'section'  => 'startup_blog_show_hide',
		'settings' => 'author_box',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'sidebar', array(
		'default'           => 'after',
		'sanitize_callback' => 'ct_startup_blog_sanitize_sidebar_settings'
	) );
	// control
	$wp_customize->add_control( 'sidebar', array(
		'label'    => __( 'Show sidebar on mobile devices?', 'startup-blog' ),
		'section'  => 'startup_blog_show_hide',
		'settings' => 'sidebar',
		'type'     => 'radio',
		'choices'  => array(
			'after'  => __( 'Yes, after main content', 'startup-blog' ),
			'before' => __( 'Yes, before main content', 'startup-blog' ),
			'no'     => __( 'No', 'startup-blog' )
		)
	) );

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'startup_blog_blog', array(
		'title'    => __( 'Blog', 'startup-blog' ),
		'priority' => 50
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_startup_blog_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'startup-blog' ),
		'section'  => 'startup_blog_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'startup-blog' ),
			'no'  => __( 'No', 'startup-blog' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '30',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'startup-blog' ),
		'section'  => 'startup_blog_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
}

/***** Custom Sanitization Functions *****/

function ct_startup_blog_sanitize_email( $input ) {
	return sanitize_email( $input );
}

// sanitize yes/no settings
function ct_startup_blog_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'startup-blog' ),
		'no'  => __( 'No', 'startup-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_startup_blog_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_startup_blog_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_startup_blog_sanitize_tagline_settings( $input ) {

	$valid = array(
		'header-footer' => __( 'Yes, in the header & footer', 'startup-blog' ),
		'header'        => __( 'Yes, in the header', 'startup-blog' ),
		'footer'        => __( 'Yes, in the footer', 'startup-blog' ),
		'no'            => __( 'No', 'startup-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_startup_blog_sanitize_sidebar_settings( $input ) {

	$valid = array(
		'after'  => __( 'Yes, after main content', 'startup-blog' ),
		'before' => __( 'Yes, before main content', 'startup-blog' ),
		'no'     => __( 'No', 'startup-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_startup_blog_sanitize_slider_display( $input ) {

	$valid = array(
		'homepage'  => __( 'Homepage', 'startup-blog' ),
		'blog'      => __( 'Blog', 'startup-blog' ),
		'all-pages' => __( 'All Pages', 'startup-blog' ),
		'no'        => __( 'Do not display', 'startup-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_startup_blog_sanitize_post_categories( $input ) {

	$categories_array = array( 'all' => 'All' );
	foreach ( get_categories() as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}

	return array_key_exists( $input, $categories_array ) ? $input : '';
}

function ct_startup_blog_sanitize_layout( $input ) {

	$valid = array(
		'right-sidebar' => __( 'Right sidebar', 'startup-blog' ),
		'left-sidebar'  => __( 'Left sidebar', 'startup-blog' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}
