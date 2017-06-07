<?php

if ( ! isset( $content_width ) ) {
	$content_width = 891;
}

if ( ! function_exists( ( 'ct_business_blog_theme_setup' ) ) ) {
	function ct_business_blog_theme_setup() {

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
		add_theme_support( 'infinite-scroll', array(
			'container' => 'loop-container',
			'footer'    => 'overflow-container',
			'render'    => 'ct_business_blog_infinite_scroll_render'
		) );

		require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );
		foreach ( glob( trailingslashit( get_template_directory() ) . 'inc/*' ) as $filename ) {
			include $filename;
		}

		register_nav_menus( array(
			'primary'   => __( 'Primary', 'business-blog' ),
			'secondary' => __( 'Secondary', 'business-blog' )
		) );

		load_theme_textdomain( 'business-blog', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'ct_business_blog_theme_setup', 10 );

function ct_business_blog_register_widget_areas() {

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'business-blog' ),
		'id'            => 'primary',
		'description'   => __( 'Widgets in this area will be shown in the sidebar next to the main post content', 'business-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
}
add_action( 'widgets_init', 'ct_business_blog_register_widget_areas' );

if ( ! function_exists( ( 'ct_business_blog_customize_comments' ) ) ) {
	function ct_business_blog_customize_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
				echo get_avatar( get_comment_author_email(), 36, '', get_comment_author() );
				?>
				<span class="author-name"><?php comment_author_link(); ?></span>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'business-blog' ) ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<span class="comment-date"><?php comment_date(); ?></span>
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => __( 'Reply', 'business-blog' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				) ) ); ?>
				<?php edit_comment_link( __( 'Edit', 'business-blog' ) ); ?>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'ct_business_blog_update_fields' ) ) {
	function ct_business_blog_update_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . __( '(optional)', 'business-blog' );
		$aria_req  = $req ? "aria-required='true'" : '';

		$fields['author'] =
			'<p class="comment-form-author">
	            <label for="author">' . __( "Name", "business-blog" ) . $label . '</label>
	            <input id="author" name="author" type="text" placeholder="' . __( "Jane Doe", "business-blog" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . $aria_req . ' />
	        </p>';

		$fields['email'] =
			'<p class="comment-form-email">
	            <label for="email">' . __( "Email", "business-blog" ) . $label . '</label>
	            <input id="email" name="email" type="email" placeholder="' . __( "name@email.com", "business-blog" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . $aria_req . ' />
	        </p>';

		$fields['url'] =
			'<p class="comment-form-url">
	            <label for="url">' . __( "Website", "business-blog" ) . '</label>
	            <input id="url" name="url" type="url" placeholder="http://google.com" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
	            </p>';

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'ct_business_blog_update_fields' );

if ( ! function_exists( 'ct_business_blog_update_comment_field' ) ) {
	function ct_business_blog_update_comment_field( $comment_field ) {

		$comment_field =
			'<p class="comment-form-comment">
	            <label for="comment">' . __( "Comment", "business-blog" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

		return $comment_field;
	}
}
add_filter( 'comment_form_field_comment', 'ct_business_blog_update_comment_field' );

if ( ! function_exists( 'ct_business_blog_remove_comments_notes_after' ) ) {
	function ct_business_blog_remove_comments_notes_after( $defaults ) {
		$defaults['comment_notes_after'] = '';
		return $defaults;
	}
}
add_action( 'comment_form_defaults', 'ct_business_blog_remove_comments_notes_after' );

if ( ! function_exists( 'ct_business_blog_excerpt' ) ) {
	function ct_business_blog_excerpt() {

		global $post;
		$show_full_post = get_theme_mod( 'full_post' );
		$read_more_text = get_theme_mod( 'read_more_text' );
		$ismore         = strpos( $post->post_content, '<!--more-->' );

		if ( ( $show_full_post == 'yes' ) && ! is_search() ) {
			if ( $ismore ) {
				// Has to be written this way because i18n text CANNOT be stored in a variable
				if ( ! empty( $read_more_text ) ) {
					the_content( $read_more_text . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
				} else {
					the_content( __( 'Continue reading', 'business-blog' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
				}
			} else {
				the_content();
			}
		} elseif ( $ismore ) {
			if ( ! empty( $read_more_text ) ) {
				the_content( $read_more_text . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
			} else {
				the_content( __( 'Continue reading', 'business-blog' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
			}
		} else {
			the_excerpt();
		}
	}
}

if ( ! function_exists( 'ct_business_blog_excerpt_read_more_link' ) ) {
	function ct_business_blog_excerpt_read_more_link( $output ) {

		$read_more_text = get_theme_mod( 'read_more_text' );

		if ( ! empty( $read_more_text ) ) {
			return $output . "<p><a class='more-link' href='" . esc_url( get_permalink() ) . "'>" . $read_more_text . " <span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
		} else {
			return $output . "<p><a class='more-link' href='" . esc_url( get_permalink() ) . "'>" . __( 'Continue reading', 'business-blog' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
		}
	}
}
add_filter( 'the_excerpt', 'ct_business_blog_excerpt_read_more_link' );

if ( ! function_exists( 'ct_business_blog_custom_excerpt_length' ) ) {
	function ct_business_blog_custom_excerpt_length( $length ) {

		$new_excerpt_length = get_theme_mod( 'excerpt_length' );

		if ( ! empty( $new_excerpt_length ) && $new_excerpt_length != 25 ) {
			return $new_excerpt_length;
		} elseif ( $new_excerpt_length === 0 ) {
			return 0;
		} else {
			return 25;
		}
	}
}
add_filter( 'excerpt_length', 'ct_business_blog_custom_excerpt_length', 99 );

if ( ! function_exists( 'ct_business_blog_new_excerpt_more' ) ) {
	function ct_business_blog_new_excerpt_more( $more ) {

		$new_excerpt_length = get_theme_mod( 'excerpt_length' );
		$excerpt_more       = ( $new_excerpt_length === 0 ) ? '' : '&#8230;';

		return $excerpt_more;
	}
}
add_filter( 'excerpt_more', 'ct_business_blog_new_excerpt_more' );

if ( ! function_exists( 'ct_business_blog_remove_more_link_scroll' ) ) {
	function ct_business_blog_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_business_blog_remove_more_link_scroll' );

if ( ! function_exists( 'ct_business_blog_featured_image' ) ) {
	function ct_business_blog_featured_image() {

		global $post;
		$featured_image = '';

		if ( has_post_thumbnail( $post->ID ) ) {

			if ( is_singular() ) {
				$featured_image = '<div class="featured-image">' . get_the_post_thumbnail( $post->ID, 'full' ) . '</div>';
			} else {
				$featured_image = '<div class="featured-image"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . get_the_post_thumbnail( $post->ID, 'full' ) . '</a></div>';
			}
		}

		$featured_image = apply_filters( 'ct_business_blog_featured_image', $featured_image );

		if ( $featured_image ) {
			echo $featured_image;
		}
	}
}

if ( ! function_exists( 'ct_business_blog_social_array' ) ) {
	function ct_business_blog_social_array() {

		$social_sites = array(
			'twitter'       => 'business_blog_twitter_profile',
			'facebook'      => 'business_blog_facebook_profile',
			'instagram'     => 'business_blog_instagram_profile',
			'linkedin'      => 'business_blog_linkedin_profile',
			'pinterest'     => 'business_blog_pinterest_profile',
			'google-plus'   => 'business_blog_googleplus_profile',
			'youtube'       => 'business_blog_youtube_profile',
			'email'         => 'business_blog_email_profile',
			'email-form'    => 'business_blog_email_form_profile',

			'500px'         => 'business_blog_500px_profile',
			'behance'       => 'business_blog_behance_profile',
			'codepen'       => 'business_blog_codepen_profile',
			'delicious'     => 'business_blog_delicious_profile',
			'deviantart'    => 'business_blog_deviantart_profile',
			'digg'          => 'business_blog_digg_profile',
			'dribbble'      => 'business_blog_dribbble_profile',
			'flickr'        => 'business_blog_flickr_profile',
			'foursquare'    => 'business_blog_foursquare_profile',
			'github'        => 'business_blog_github_profile',
			'hacker-news'   => 'business_blog_hacker-news_profile',
			'paypal'        => 'business_blog_paypal_profile',
			'qq'            => 'business_blog_qq_profile',
			'reddit'        => 'business_blog_reddit_profile',
			'rss'           => 'business_blog_rss_profile',
			'skype'         => 'business_blog_skype_profile',
			'slack'         => 'business_blog_slack_profile',
			'slideshare'    => 'business_blog_slideshare_profile',
			'soundcloud'    => 'business_blog_soundcloud_profile',
			'spotify'       => 'business_blog_spotify_profile',
			'steam'         => 'business_blog_steam_profile',
			'stumbleupon'   => 'business_blog_stumbleupon_profile',
			'tencent-weibo' => 'business_blog_tencent_weibo_profile',
			'tumblr'        => 'business_blog_tumblr_profile',
			'vimeo'         => 'business_blog_vimeo_profile',
			'vine'          => 'business_blog_vine_profile',
			'vk'            => 'business_blog_vk_profile',
			'wechat'        => 'business_blog_wechat_profile',
			'weibo'         => 'business_blog_weibo_profile',
			'whatsapp'      => 'business_blog_whatsapp_profile',
			'xing'          => 'business_blog_xing_profile',
			'yahoo'         => 'business_blog_yahoo_profile',
		);

		return apply_filters( 'ct_business_blog_social_array_filter', $social_sites );
	}
}

if ( ! function_exists( 'ct_business_blog_social_icons_output' ) ) {
	function ct_business_blog_social_icons_output() {

		$social_sites = ct_business_blog_social_array();

		foreach ( $social_sites as $social_site => $profile ) {

			if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
				$active_sites[ $social_site ] = $social_site;
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
						<i class="fa fa-envelope" title="<?php esc_attr_e( 'email', 'business-blog' ); ?>"></i>
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
function ct_business_blog_wp_page_menu() {
	wp_page_menu( array(
			"menu_class" => "menu-unset",
			"depth"      => - 1
		)
	);
}

if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function ct_business_blog_add_title_tag() {
		?>
		<title><?php wp_title( ' | ' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'ct_business_blog_add_title_tag' );
endif;

function ct_business_blog_nav_dropdown_buttons( $item_output, $item, $depth, $args ) {

	if ( $args->theme_location == 'primary' ) {

		if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
			$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . __( "open menu", "business-blog" ) . '</span></button>', $item_output );
		}
	}

	return $item_output;
}
//add_filter( 'walker_nav_menu_start_el', 'ct_business_blog_nav_dropdown_buttons', 10, 4 );

function ct_business_blog_sticky_post_marker() {

	if ( is_sticky() && ! is_archive() ) {
		echo '<div class="sticky-status"><span>' . __( "Featured", "business-blog" ) . '</span></div>';
	}
}
add_action( 'sticky_post_status', 'ct_business_blog_sticky_post_marker' );

function ct_business_blog_reset_customizer_options() {

	if ( empty( $_POST['business_blog_reset_customizer'] ) || 'business_blog_reset_customizer_settings' !== $_POST['business_blog_reset_customizer'] ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['business_blog_reset_customizer_nonce'], 'business_blog_reset_customizer_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$mods_array = array(
		'logo_upload',
		'search_bar',
		'full_post',
		'excerpt_length',
		'read_more_text',
		'full_width_post',
		'author_byline',
		'custom_css'
	);

	$social_sites = ct_business_blog_social_array();

	// add social site settings to mods array
	foreach ( $social_sites as $social_site => $value ) {
		$mods_array[] = $social_site;
	}

	$mods_array = apply_filters( 'ct_business_blog_mods_to_remove', $mods_array );

	foreach ( $mods_array as $theme_mod ) {
		remove_theme_mod( $theme_mod );
	}

	$redirect = admin_url( 'themes.php?page=business_blog-options' );
	$redirect = add_query_arg( 'business_blog_status', 'deleted', $redirect );

	// safely redirect
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_init', 'ct_business_blog_reset_customizer_options' );

function ct_business_blog_delete_settings_notice() {

	if ( isset( $_GET['business_blog_status'] ) ) {
		?>
		<div class="updated">
			<p><?php _e( 'Customizer settings deleted', 'business-blog' ); ?>.</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'ct_business_blog_delete_settings_notice' );

function ct_business_blog_body_class( $classes ) {

	global $post;
	$full_post       = get_theme_mod( 'full_post' );

	if ( $full_post == 'yes' ) {
		$classes[] = 'full-post';
	}

	return $classes;
}
add_filter( 'body_class', 'ct_business_blog_body_class' );

function ct_business_blog_post_class( $classes ) {
	$classes[] = 'entry';
	return $classes;
}
add_filter( 'post_class', 'ct_business_blog_post_class' );

function ct_business_blog_custom_css_output() {

	$custom_css = get_theme_mod( 'custom_css' );
	$logo_size = get_theme_mod( 'logo_size' );

	if ( $logo_size != 48 && ! empty( $logo_size ) ) {
		$logo_size_css = '.logo {
							width: ' . $logo_size . 'px;
						  }';
		$custom_css .= $logo_size_css;
	}

	if ( $custom_css ) {
		$custom_css = ct_business_blog_sanitize_css( $custom_css );

		wp_add_inline_style( 'ct-business_blog-style', $custom_css );
		wp_add_inline_style( 'ct-business_blog-style-rtl', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_business_blog_custom_css_output', 20 );

function ct_business_blog_svg_output( $type ) {

	$svg = '';

	if ( $type == 'toggle-navigation' ) {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="21" viewBox="0 0 30 21" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-265.000000, -78.000000)" fill="#333333"><g transform="translate(265.000000, 78.000000)"><rect x="0" y="0" width="30" height="3" rx="1.5"/><rect x="0" y="9" width="30" height="3" rx="1.5"/><rect x="0" y="18" width="30" height="3" rx="1.5"/></g></g></g></svg>';
	}

	return $svg;
}

function ct_business_blog_add_meta_elements() {

	$meta_elements = '';

	$meta_elements .= sprintf( '<meta charset="%s" />' . "\n", get_bloginfo( 'charset' ) );
	$meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

	$theme    = wp_get_theme( get_template() );
	$template = sprintf( '<meta name="template" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );
	$meta_elements .= $template;

	echo $meta_elements;
}
add_action( 'wp_head', 'ct_business_blog_add_meta_elements', 1 );

// Move the WordPress generator to a better priority.
remove_action( 'wp_head', 'wp_generator' );
add_action( 'wp_head', 'wp_generator', 1 );

function ct_business_blog_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', 'archive' );
	}
}

if ( ! function_exists( 'ct_business_blog_get_content_template' ) ) {
	function ct_business_blog_get_content_template() {

		/* Blog */
		if ( is_home() ) {
			get_template_part( 'content', 'archive' );
		} /* Post */
		elseif ( is_singular( 'post' ) ) {
			get_template_part( 'content' );
		} /* Page */
		elseif ( is_page() ) {
			get_template_part( 'content', 'page' );
		} /* Attachment */
		elseif ( is_attachment() ) {
			get_template_part( 'content', 'attachment' );
		} /* Archive */
		elseif ( is_archive() ) {
			get_template_part( 'content', 'archive' );
		} /* Custom Post Type */
		else {
			get_template_part( 'content' );
		}
	}
}

// allow skype URIs to be used
function ct_business_blog_allow_skype_protocol( $protocols ){
	$protocols[] = 'skype';
	return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'ct_business_blog_allow_skype_protocol' );

// Add class to primary menu if single tier so mobile menu items can be listed horizontally instead of vertically
function ct_business_blog_primary_dropdown_check( $item_output, $item, $depth, $args ) {

	if ( $args->theme_location == 'primary' ) {

		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			if ( strpos( $args->menu_class, 'hierarchical' ) == false ) {
				$args->menu_class .= ' hierarchical';
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'ct_business_blog_primary_dropdown_check', 10, 4 );