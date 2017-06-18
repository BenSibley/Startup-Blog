<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
<?php do_action( 'business_blog_body_top' ); ?>
<a class="skip-content" href="#main"><?php _e( 'Press "Enter" to skip to content', 'business-blog' ); ?></a>
<div id="overflow-container" class="overflow-container">
	<?php do_action( 'business_blog_before_header' ); ?>
	<header class="site-header" id="site-header" role="banner">
		<div class="secondary-header">
			<div class="max-width">
				<?php ct_business_blog_social_icons_output(); ?>
				<button id="toggle-navigation-secondary" class="toggle-navigation-secondary" aria-expanded="false">
					<span class="screen-reader-text"><?php _e( 'open menu', 'business-blog' ); ?></span>
					<span class="icon">+</span>
				</button>
				<div id="menu-secondary-container" class="menu-secondary-container">
					<?php get_template_part( 'menu', 'secondary' ); ?>
				</div>
			</div>
		</div>
		<div class="primary-header">
			<div class="max-width">
				<div id="title-container" class="title-container">
					<?php get_template_part( 'logo' ) ?>
					<?php if ( get_bloginfo( 'description' ) && get_theme_mod( 'tagline' ) != 'footer' && get_theme_mod( 'tagline' ) != 'no' ) {
						echo '<p class="tagline">' . get_bloginfo( 'description' ) . '</p>';
					} ?>
				</div>
				<button id="toggle-navigation" class="toggle-navigation" name="toggle-navigation" aria-expanded="false">
					<span class="screen-reader-text"><?php _e( 'open menu', 'business-blog' ); ?></span>
					<?php echo ct_business_blog_svg_output( 'toggle-navigation' ); ?>
				</button>
				<div id="menu-primary-container" class="menu-primary-container">
					<?php get_template_part( 'menu', 'primary' ); ?>
					<?php get_template_part( 'content/search-bar' ); ?>
				</div>
			</div>
		</div>
	</header>
	<?php ct_business_blog_slider(); ?>
	<?php do_action( 'business_blog_after_header' ); ?>
	<div class="main-content-container">
		<div class="max-width">
			<?php if ( get_theme_mod( 'sidebar' ) == 'before' ) {
				get_sidebar( 'primary' );
			} ?>
			<section id="main" class="main" role="main">
				<?php do_action( 'business_blog_main_top' );
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
				}
