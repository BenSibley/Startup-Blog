<?php

require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );
foreach ( glob( trailingslashit( get_template_directory() ) . 'inc/*' ) as $filename ) {
	include $filename;
}

if ( ! function_exists( ( 'ct_startup_blog_set_content_width' ) ) ) {
	function ct_startup_blog_set_content_width() {
		if ( ! isset( $content_width ) ) {
			$content_width = 780;
		}
	}
}
add_action( 'after_setup_theme', 'ct_startup_blog_set_content_width', 0 );

if ( ! function_exists( ( 'ct_startup_blog_theme_setup' ) ) ) {
	function ct_startup_blog_theme_setup() {

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		// Support for infinite scroll in jetpack
		add_theme_support( 'infinite-scroll', array(
			'container' => 'loop-container',
			'footer'    => 'overflow-container',
			'render'    => 'ct_startup_blog_infinite_scroll_render'
		) );
		add_theme_support( 'custom-logo', array(
			'height'      => 60,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true
		) );

		register_nav_menus( array(
			'primary'   => esc_html__( 'Primary', 'startup-blog' ),
			'secondary' => esc_html__( 'Secondary', 'startup-blog' )
		) );

		load_theme_textdomain( 'startup-blog', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'ct_startup_blog_theme_setup', 10 );

if ( ! function_exists( ( 'ct_startup_blog_register_widget_areas' ) ) ) {
	function ct_startup_blog_register_widget_areas() {

		register_sidebar( array(
			'name'          => esc_html__( 'Primary Sidebar', 'startup-blog' ),
			'id'            => 'primary',
			'description'   => esc_html__( 'Widgets in this area will be shown in the sidebar next to the main content.', 'startup-blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'After Post Content', 'startup-blog' ),
			'id'            => 'after-post-content',
			'description'   => esc_html__( 'Widgets in this area will be shown on posts after the content.', 'startup-blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'After Page Content', 'startup-blog' ),
			'id'            => 'after-page-content',
			'description'   => esc_html__( 'Widgets in this area will be shown on pages after the content.', 'startup-blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
	}
}
add_action( 'widgets_init', 'ct_startup_blog_register_widget_areas' );

if ( ! function_exists( ( 'ct_startup_blog_customize_comments' ) ) ) {
	function ct_startup_blog_customize_comments( $comment, $args, $depth ) { ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php echo get_avatar( get_comment_author_email(), 44, '', get_comment_author() ); ?>
				<span class="author-name"><?php comment_author_link(); ?></span>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<span
						class="awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'startup-blog' ) ?></span>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<?php comment_reply_link( array_merge( $args, array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<i class="fa fa-reply" aria-hidden="true"></i>'
				) ) ); ?>
				<?php edit_comment_link(
					esc_html__( 'Edit', 'startup-blog' ),
					'<i class="fa fa-pencil" aria-hidden="true"></i>'
				); ?>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'ct_startup_blog_update_fields' ) ) {
	function ct_startup_blog_update_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . esc_html__( '(optional)', 'startup-blog' );
		$aria_req  = $req ? "aria-required='true'" : '';

		$fields['author'] =
			'<p class="comment-form-author">
	            <label for="author">' . esc_html__( "Name", "startup-blog" ) . esc_html( $label ) . '</label>
	            <input id="author" name="author" type="text" placeholder="' . esc_attr__( "Jane Doe", "startup-blog" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . esc_html( $aria_req ) . ' />
	        </p>';

		$fields['email'] =
			'<p class="comment-form-email">
	            <label for="email">' . esc_html__( "Email", "startup-blog" ) . esc_html( $label ) . '</label>
	            <input id="email" name="email" type="email" placeholder="' . esc_attr__( "name@email.com", "startup-blog" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . esc_html( $aria_req ) . ' />
	        </p>';

		$fields['url'] =
			'<p class="comment-form-url">
	            <label for="url">' . esc_html__( "Website", "startup-blog" ) . '</label>
	            <input id="url" name="url" type="url" placeholder="http://google.com" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
	            </p>';

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'ct_startup_blog_update_fields' );

if ( ! function_exists( 'ct_startup_blog_update_comment_field' ) ) {
	function ct_startup_blog_update_comment_field( $comment_field ) {

		$comment_field =
			'<p class="comment-form-comment">
	            <label for="comment">' . esc_html__( "Comment", "startup-blog" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

		return $comment_field;
	}
}
add_filter( 'comment_form_field_comment', 'ct_startup_blog_update_comment_field' );

if ( ! function_exists( 'ct_startup_blog_remove_comments_notes_after' ) ) {
	function ct_startup_blog_remove_comments_notes_after( $defaults ) {
		$defaults['comment_notes_after'] = '';
		return $defaults;
	}
}
add_action( 'comment_form_defaults', 'ct_startup_blog_remove_comments_notes_after' );

if ( ! function_exists( 'ct_startup_blog_excerpt' ) ) {
	function ct_startup_blog_excerpt() {
		if ( get_theme_mod( 'full_post' ) == 'yes' ) {
			return wpautop( get_the_content() );
		} else {
			return wpautop( get_the_excerpt() );
		}
	}
}
if ( ! function_exists( 'ct_startup_blog_custom_excerpt_length' ) ) {
	function ct_startup_blog_custom_excerpt_length( $length ) {

		$new_excerpt_length = get_theme_mod( 'excerpt_length' );

		if ( ! empty( $new_excerpt_length ) && $new_excerpt_length != 30 ) {
			return $new_excerpt_length;
		} elseif ( $new_excerpt_length === 0 ) {
			return 0;
		} else {
			return 30;
		}
	}
}
add_filter( 'excerpt_length', 'ct_startup_blog_custom_excerpt_length', 99 );

// add plain ellipsis for automatic excerpts (removes [])
if ( ! function_exists( 'ct_startup_blog_excerpt_ellipsis' ) ) {
	function ct_startup_blog_excerpt_ellipsis() {
		return '&#8230;';
	}
}
add_filter( 'excerpt_more', 'ct_startup_blog_excerpt_ellipsis', 10 );

if ( ! function_exists( 'ct_startup_blog_remove_more_link_scroll' ) ) {
	function ct_startup_blog_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_startup_blog_remove_more_link_scroll' );

if ( ! function_exists( 'ct_startup_blog_featured_image' ) ) {
	function ct_startup_blog_featured_image() {

		global $post;
		$featured_image = '';

		if ( has_post_thumbnail( $post->ID ) ) {

			if ( is_singular() ) {
				$featured_image = '<div class="featured-image">' . get_the_post_thumbnail( $post->ID, 'full' ) . '</div>';
			} else {
				$featured_image = '<div class="featured-image"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . get_the_post_thumbnail( $post->ID, 'full' ) . '</a></div>';
			}
		}

		$featured_image = apply_filters( 'ct_startup_blog_featured_image', $featured_image );

		if ( $featured_image ) {
			echo $featured_image;
		}
	}
}

if ( ! function_exists( 'ct_startup_blog_social_array' ) ) {
	function ct_startup_blog_social_array() {

		$social_sites = array(
			'twitter'       => 'startup_blog_twitter_profile',
			'facebook'      => 'startup_blog_facebook_profile',
			'instagram'     => 'startup_blog_instagram_profile',
			'linkedin'      => 'startup_blog_linkedin_profile',
			'pinterest'     => 'startup_blog_pinterest_profile',
			'google-plus'   => 'startup_blog_googleplus_profile',
			'youtube'       => 'startup_blog_youtube_profile',
			'email'         => 'startup_blog_email_profile',
			'email-form'    => 'startup_blog_email_form_profile',
			'500px'         => 'startup_blog_500px_profile',
			'amazon'        => 'startup_blog_amazon_profile',
			'bandcamp'      => 'startup_blog_bandcamp_profile',
			'behance'       => 'startup_blog_behance_profile',
			'codepen'       => 'startup_blog_codepen_profile',
			'delicious'     => 'startup_blog_delicious_profile',
			'deviantart'    => 'startup_blog_deviantart_profile',
			'digg'          => 'startup_blog_digg_profile',
			'dribbble'      => 'startup_blog_dribbble_profile',
			'etsy'          => 'startup_blog_etsy_profile',
			'flickr'        => 'startup_blog_flickr_profile',
			'foursquare'    => 'startup_blog_foursquare_profile',
			'github'        => 'startup_blog_github_profile',
			'google-wallet' => 'startup_blog_google_wallet_profile',
			'hacker-news'   => 'startup_blog_hacker-news_profile',
			'meetup'        => 'startup_blog_meetup_profile',
			'paypal'        => 'startup_blog_paypal_profile',
			'podcast'       => 'startup_blog_podcast_profile',
			'quora'         => 'startup_blog_quora_profile',
			'qq'            => 'startup_blog_qq_profile',
			'ravelry'       => 'startup_blog_ravelry_profile',
			'reddit'        => 'startup_blog_reddit_profile',
			'rss'           => 'startup_blog_rss_profile',
			'skype'         => 'startup_blog_skype_profile',
			'slack'         => 'startup_blog_slack_profile',
			'slideshare'    => 'startup_blog_slideshare_profile',
			'snapchat'      => 'startup_blog_snapchat_profile',
			'soundcloud'    => 'startup_blog_soundcloud_profile',
			'spotify'       => 'startup_blog_spotify_profile',
			'steam'         => 'startup_blog_steam_profile',
			'stumbleupon'   => 'startup_blog_stumbleupon_profile',
			'telegram'      => 'startup_blog_telegram_profile',
			'tencent-weibo' => 'startup_blog_tencent_weibo_profile',
			'tumblr'        => 'startup_blog_tumblr_profile',
			'twitch'        => 'startup_blog_twitch_profile',
			'vimeo'         => 'startup_blog_vimeo_profile',
			'vine'          => 'startup_blog_vine_profile',
			'vk'            => 'startup_blog_vk_profile',
			'wechat'        => 'startup_blog_wechat_profile',
			'weibo'         => 'startup_blog_weibo_profile',
			'whatsapp'      => 'startup_blog_whatsapp_profile',
			'xing'          => 'startup_blog_xing_profile',
			'yahoo'         => 'startup_blog_yahoo_profile',
			'yelp'          => 'startup_blog_yelp_profile'
		);

		return apply_filters( 'ct_startup_blog_social_array_filter', $social_sites );
	}
}

if ( ! function_exists( 'ct_startup_blog_social_icons_output' ) ) {
	function ct_startup_blog_social_icons_output( $source = 'header' ) {

		$social_sites = ct_startup_blog_social_array();

		// store the site name and url
		foreach ( $social_sites as $social_site => $profile ) {

			if ( $source == 'header' ) {
				if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
					$active_sites[ $social_site ] = $social_site;
				}
			} elseif ( $source == 'author' ) {
				if ( strlen( get_the_author_meta( $profile ) ) > 0 ) {
					$active_sites[ $profile ] = $social_site;
				}
			}
		}

		if ( ! empty( $active_sites ) ) {

			echo "<ul class='social-media-icons'>";

			foreach ( $active_sites as $key => $active_site ) {

				if ( $active_site == 'email-form' ) {
					$class = 'fa fa-envelope-o';
				} else {
					$class = 'fa fa-' . $active_site;
				}

				echo '<li>';
				if ( $active_site == 'email' ) { ?>
					<a class="email" target="_blank"
					   href="mailto:<?php echo antispambot( is_email( get_theme_mod( $key ) ) ); ?>">
						<i class="fa fa-envelope" title="<?php esc_attr_e( 'email', 'startup-blog' ); ?>"></i>
					</a>
				<?php } elseif ( $active_site == 'skype' ) { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $key ), array( 'http', 'https', 'skype' ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"
						   title="<?php echo esc_attr( $active_site ); ?>"></i>
					</a>
				<?php } else { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $key ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"
						   title="<?php echo esc_attr( $active_site ); ?>"></i>
					</a>
					<?php
				}
				echo '</li>';
			}
			echo "</ul>";
		}
	}
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
if ( ! function_exists( 'ct_startup_blog_wp_page_menu' ) ) {
	function ct_startup_blog_wp_page_menu() {
		wp_page_menu( array(
				"menu_class" => "menu-unset",
				"depth"      => - 1
			)
		);
	}
}
if ( ! function_exists( 'ct_startup_blog_sticky_post_marker' ) ) {
	function ct_startup_blog_sticky_post_marker() {
		if ( is_sticky() && !is_archive() && !is_search() ) {
			echo '<div class="sticky-status"><span>' . esc_html__( "Featured", "startup-blog" ) . '</span></div>';
		}
	}
}
add_action( 'startup_blog_sticky_post_status', 'ct_startup_blog_sticky_post_marker' );

if ( ! function_exists( 'ct_startup_blog_reset_customizer_options' ) ) {
	function ct_startup_blog_reset_customizer_options() {

		if ( !isset( $_POST['startup_blog_reset_customizer'] ) || 'startup_blog_reset_customizer_settings' !== $_POST['startup_blog_reset_customizer'] ) {
			return;
		}

		if ( ! wp_verify_nonce( wp_unslash( $_POST['startup_blog_reset_customizer_nonce'] ), 'startup_blog_reset_customizer_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$mods_array = array(
			'slider_recent_posts',
			'slider_post_category',
			'slider_display',
			'slider_arrow_navigation',
			'slider_dot_navigation',
			'slider_button_text',
			'slider_sticky',
			'color_primary',
			'color_secondary',
			'color_background',
			'layout',
			'tagline',
			'post_byline_date',
			'post_byline_author',
			'author_avatars',
			'author_box',
			'sidebar',
			'full_post',
			'excerpt_length'
		);

		$social_sites = ct_startup_blog_social_array();

		// add social site settings to mods array
		foreach ( $social_sites as $social_site => $value ) {
			$mods_array[] = $social_site;
		}

		$mods_array = apply_filters( 'ct_startup_blog_mods_to_remove', $mods_array );

		foreach ( $mods_array as $theme_mod ) {
			remove_theme_mod( $theme_mod );
		}

		$redirect = admin_url( 'themes.php?page=startup-blog-options' );
		$redirect = add_query_arg( 'startup_blog_status', 'deleted', $redirect );

		// safely redirect
		wp_safe_redirect( $redirect );
		exit;
	}
}
add_action( 'admin_init', 'ct_startup_blog_reset_customizer_options' );

if ( ! function_exists( 'ct_startup_blog_delete_settings_notice' ) ) {
	function ct_startup_blog_delete_settings_notice() {

		if ( isset( $_GET['startup_blog_status'] ) ) {
			?>
			<div class="updated">
				<p><?php esc_html_e( 'Customizer settings deleted', 'startup-blog' ); ?>.</p>
			</div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'ct_startup_blog_delete_settings_notice' );

if ( ! function_exists( 'ct_startup_blog_body_class' ) ) {
	function ct_startup_blog_body_class( $classes ) {

		global $post;
		$full_post       = get_theme_mod( 'full_post' );
		$sidebar_display = get_theme_mod( 'sidebar' );
		$layout          = get_theme_mod( 'layout' );

		if ( $full_post == 'yes' ) {
			$classes[] = 'full-post';
		}
		if ( $sidebar_display == 'no' ) {
			$classes[] = 'hide-sidebar';
		}
		// don't add layout classes if PRO plugin is active
		if ( !defined( 'STARTUP_BLOG_PRO_FILE' ) ) {
			$classes[] = esc_attr( $layout );
		}

		return $classes;
	}
}
add_filter( 'body_class', 'ct_startup_blog_body_class' );

// add a shared class for post divs on archive and single pages
if ( ! function_exists( 'ct_startup_blog_post_class' ) ) {
	function ct_startup_blog_post_class( $classes ) {
		$classes[] = 'entry';
		return $classes;
	}
}
add_filter( 'post_class', 'ct_startup_blog_post_class' );

if ( ! function_exists( 'ct_startup_blog_svg_output' ) ) {
	function ct_startup_blog_svg_output( $type ) {

		$svg = '';
		if ( $type == 'toggle-navigation' ) {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="21" viewBox="0 0 30 21" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-265.000000, -78.000000)" fill="#333333"><g transform="translate(265.000000, 78.000000)"><rect x="0" y="0" width="30" height="3" rx="1.5"/><rect x="0" y="9" width="30" height="3" rx="1.5"/><rect x="0" y="18" width="30" height="3" rx="1.5"/></g></g></g></svg>';
		}
		return $svg;
	}
}
if ( ! function_exists( 'ct_startup_blog_add_meta_elements' ) ) {
	function ct_startup_blog_add_meta_elements() {

		$meta_elements = '';

		$meta_elements .= sprintf( '<meta charset="%s" />' . "\n", esc_attr( get_bloginfo( 'charset' ) ) );
		$meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

		$theme    = wp_get_theme( get_template() );
		$template = sprintf( '<meta name="template" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );
		$meta_elements .= $template;

		echo $meta_elements;
	}
}
add_action( 'wp_head', 'ct_startup_blog_add_meta_elements', 1 );

if ( ! function_exists( 'ct_startup_blog_infinite_scroll_render' ) ) {
	function ct_startup_blog_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'archive' );
		}
	}
}

/* Routing templates this way to follow DRY coding patterns
* (using index.php file only instead of duplicating loop in page.php, post.php, etc.)
*/
if ( ! function_exists( 'ct_startup_blog_get_content_template' ) ) {
	function ct_startup_blog_get_content_template() {

		if ( is_home() || is_archive() ) {
			get_template_part( 'content-archive', get_post_type() );
		} else {
			get_template_part( 'content', get_post_type() );
		}
	}
}

// allow skype URIs to be used
if ( ! function_exists( 'ct_startup_blog_allow_skype_protocol' ) ) {
	function ct_startup_blog_allow_skype_protocol( $protocols ) {
		$protocols[] = 'skype';
		return $protocols;
	}
}
add_filter( 'kses_allowed_protocols', 'ct_startup_blog_allow_skype_protocol' );

// Add class to primary menu if single tier so mobile menu items can be listed horizontally instead of vertically
if ( ! function_exists( 'ct_startup_blog_primary_dropdown_check' ) ) {
	function ct_startup_blog_primary_dropdown_check( $item_output, $item, $depth, $args ) {

		if ( $args->theme_location == 'primary' ) {

			if ( in_array( 'menu-item-has-children', $item->classes ) ) {
				if ( strpos( $args->menu_class, 'hierarchical' ) == false ) {
					$args->menu_class .= ' hierarchical';
				}
			}
		}
		return $item_output;
	}
}
add_filter( 'walker_nav_menu_start_el', 'ct_startup_blog_primary_dropdown_check', 10, 4 );

// Remove label that can't be edited with the_archive_title() e.g. "Category: Business" => "Business"
if ( ! function_exists( 'ct_startup_blog_modify_archive_titles' ) ) {
	function ct_startup_blog_modify_archive_titles( $title ) {

		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = get_the_author();
		} elseif ( is_month() ) {
			$title = single_month_title( ' ' );
		}
		// is_year() and is_day() neglected b/c there is no analogous function for retrieving the page title

		return $title;
	}
}
add_filter( 'get_the_archive_title', 'ct_startup_blog_modify_archive_titles' );

// add paragraph tags for author bio. the_archive_description includes them for category & tag descriptions only
if ( ! function_exists( 'ct_startup_blog_modify_archive_descriptions' ) ) {
	function ct_startup_blog_modify_archive_descriptions( $description ) {

		if ( is_author() ) {
			$description = wpautop( $description );
		}
		return $description;
	}
}
add_filter( 'get_the_archive_description', 'ct_startup_blog_modify_archive_descriptions' );

// Update the colors used throughout the site based on the user's Customizer selected color
if ( ! function_exists( 'ct_startup_blog_override_colors' ) ) {
	function ct_startup_blog_override_colors() {

		$color_css       = '';
		$primary_color   = get_theme_mod( 'color_primary' );
		$secondary_color = get_theme_mod( 'color_secondary' );
		$bg_color        = get_theme_mod( 'color_background' );

		if ( $primary_color == '' ) {
			$primary_color = '#20a4e6';
		}
		if ( $secondary_color == '' ) {
			$secondary_color = '#17e6c3';
		}
		if ( $bg_color == '' ) {
			$bg_color = '#f0f5f8';
		}
		// Update all instances of the default blue color being used
		if ( $primary_color != '#20a4e6' ) {
			$color_css .= "a,a:link,a:visited,.menu-primary-items a:hover,.menu-primary-items a:active,.menu-primary-items a:focus,.menu-primary-items li.current-menu-item > a,.menu-secondary-items li.current-menu-item a,.menu-secondary-items li.current-menu-item a:link,.menu-secondary-items li.current-menu-item a:visited,.menu-secondary-items a:hover,.menu-secondary-items a:active,.menu-secondary-items a:focus,.toggle-navigation-secondary:hover,.toggle-navigation-secondary:active,.toggle-navigation-secondary.open,.widget li a:hover,.widget li a:active,.widget li a:focus,.widget_recent_comments li a,.widget_recent_comments li a:link,.widget_recent_comments li a:visited,.post-comments-link a:hover,.post-comments-link a:active,.post-comments-link a:focus,.post-title a:hover,.post-title a:active,.post-title a:focus {
		  color: $primary_color;
		}";
			$color_css .= "@media all and (min-width: 50em) { .menu-primary-items li.menu-item-has-children:hover > a,.menu-primary-items li.menu-item-has-children:hover > a:after,.menu-primary-items a:hover:after,.menu-primary-items a:active:after,.menu-primary-items a:focus:after,.menu-secondary-items li.menu-item-has-children:hover > a,.menu-secondary-items li.menu-item-has-children:hover > a:after,.menu-secondary-items a:hover:after,.menu-secondary-items a:active:after,.menu-secondary-items a:focus:after {
		  color: $primary_color;
		} }";
			$color_css .= "input[type=\"submit\"],.comment-pagination a:hover,.comment-pagination a:active,.comment-pagination a:focus,.site-header:before,.social-media-icons a:hover,.social-media-icons a:active,.social-media-icons a:focus,.pagination a:hover,.pagination a:active,.pagination a:focus,.featured-image > a:after,.entry:before,.post-tags a,.widget_calendar #prev a:hover,.widget_calendar #prev a:active,.widget_calendar #prev a:focus,.widget_calendar #next a:hover,.widget_calendar #next a:active,.widget_calendar #next a:focus,.bb-slider .image-container:after,.sticky-status span,.overflow-container .hero-image-header:before {
			background: $primary_color;
		}";
			$color_css .= "@media all and (min-width: 50em) { .menu-primary-items ul:before,.menu-secondary-items ul:before {
			background: $primary_color;
		} }";
			$color_css .= "blockquote,.widget_calendar #today {
			border-color: $primary_color;
		}";
			$color_css .= ".toggle-navigation:hover svg g,.toggle-navigation.open svg g {
			fill: $primary_color;
		}";

			// Create translucent variation and apply to hovers
			$red   = hexdec( substr( $primary_color, 1, 2 ) );
			$green = hexdec( substr( $primary_color, 3, 2 ) );
			$blue  = hexdec( substr( $primary_color, 5, 2 ) );

			$primary_color_hover = "rgba($red, $green, $blue, 0.6)";

			$color_css .= ".site-title a:hover,.site-title a:active,.site-title a:focus
			color: $primary_color;
		}";
			$color_css .= "a:hover,a:active,a:focus,.widget_recent_comments li a:hover,.widget_recent_comments li a:active,.widget_recent_comments li a:focus {
		  color: $primary_color_hover;
		}";
			$color_css .= "input[type=\"submit\"]:hover,input[type=\"submit\"]:active,input[type=\"submit\"]:focus,.post-tags a:hover,.post-tags a:active,.post-tags a:focus {
		  background: $primary_color_hover;
		}";
		}
		// Update gradients if either color has changed
		if ( $primary_color != '#20a4e6' || $secondary_color != '#17e6c3' ) {

			$color_css .= ".site-header:before,.featured-image > a:after,.entry:before,.bb-slider .image-container:after,.overflow-container .hero-image-header:before {
		  background-image: -webkit-linear-gradient(left, $primary_color, $secondary_color);
		  background-image: linear-gradient(to right, $primary_color, $secondary_color);
		}";
			$color_css .= "@media all and (min-width: 50em) { .menu-primary-items ul:before,.menu-secondary-items ul:before {
		  background-image: -webkit-linear-gradient(left, $primary_color, $secondary_color);
		  background-image: linear-gradient(to right, $primary_color, $secondary_color);
		} }";
		}
		if ( $bg_color != '#f0f5f8' ) {
			$color_css .= "body {background: $bg_color;}";
		}
		// Add CSS if any one of the colors has changed
		if ( $primary_color != '#20a4e6' || $secondary_color != '#17e6c3' || $bg_color != '#f0f5f8' ) {
			wp_add_inline_style( 'ct-startup-blog-style', ct_startup_blog_sanitize_css( $color_css ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_startup_blog_override_colors', 20 );

// sanitize CSS and convert HTML character codes back into ">" character so direct descendant CSS selectors work
if ( ! function_exists( 'ct_startup_blog_sanitize_css' ) ) {
	function ct_startup_blog_sanitize_css( $css ) {
		$css = wp_kses( $css, '' );
		$css = str_replace( '&gt;', '>', $css );

		return $css;
	}
}

// Create and output the slider
if ( ! function_exists( 'ct_startup_blog_slider' ) ) {
	function ct_startup_blog_slider() {

		// Decide if slider should be displayed based on user's Customizer settings
		$display = get_theme_mod( 'slider_display' );
		if ( ( $display == 'homepage' || $display == '' ) && ! is_front_page() ) {
			return;
		}
		if ( $display == 'blog' && ! is_home() ) {
			return;
		}
		if ( $display == 'no' ) {
			return;
		}

		// Setup other variables needed
		$counter        = 1;
		$nav_counter    = 1;
		$display_arrows = get_theme_mod( 'slider_arrow_navigation' );
		$display_dots   = get_theme_mod( 'slider_dot_navigation' );
		$num_posts      = get_theme_mod( 'slider_recent_posts' );
		if ( $num_posts == '' ) {
			$num_posts = 5;
		}
		$args          = array( 'posts_per_page' => $num_posts );
		$post_category = get_theme_mod( 'slider_post_category' );
		if ( $post_category != '' && $post_category != 'all' ) {
			$args['cat'] = $post_category;
		}
		if ( get_theme_mod( 'slider_sticky' ) == 'no' ) {
			$args['ignore_sticky_posts'] = true;
		}

		$the_query = new WP_Query( $args );

		// Loop through posts
		if ( $the_query->have_posts() ) {
			echo '<div id="bb-slider" class="bb-slider">';
			echo '<ul id="bb-slide-list" class="slide-list">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$classes = 'slide slide-' . $counter;
				if ( $counter == 1 ) {
					$classes .= ' current';
				}
				// Getting template this way instead of using get_template_part() so variables are accessible
				include( locate_template( 'content-slide.php', false, false ) );
				$counter ++;
			}
			echo '</ul>';
			if ( $display_arrows != 'no' ) {
				echo '<div class="arrow-navigation">';
					echo '<a id="bb-slider-left" class="left slide-nav" href="#"><i class="fa fa-angle-left"></i></a>';
					echo '<a id="bb-slider-right" class="right slide-nav" href="#"><i class="fa fa-angle-right"></i></a>';
				echo '</div>';
			}
			if ( $display_dots != 'no' ) {
				echo '<ul id="dot-navigation" class="dot-navigation">';
				while ( $nav_counter <= $the_query->post_count ) {
					$dot_class = 'dot ' . $nav_counter;
					if ( $nav_counter == 1 ) {
						$dot_class .= ' current';
					}
					echo '<li class="' . esc_attr( $dot_class ) . '"><a href="#"></a></li>';
					$nav_counter ++;
				}
				echo '</ul>';
			}
			echo '</div>';
			wp_reset_postdata();
		}
	}
}

// provide a fallback title on the off-chance a post is untitled so it remains clickable on the blog
function ct_startup_blog_no_missing_titles( $title, $id = null ) {
	if ( $title == '' ) {
		$title = esc_html__( '(title)', 'startup-blog' );
	}
	return $title;
}
add_filter( 'the_title', 'ct_startup_blog_no_missing_titles', 10, 2 );