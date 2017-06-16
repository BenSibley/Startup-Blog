<?php
$button_text = get_theme_mod('slider_button_text');
if ( $button_text == '' ) {
	$button_text = __( 'Read more', 'business-blog');
}

?>
<li class="<?php esc_attr_e( $classes ); ?>">
	<div class="content-container">
		<div class="title"><?php the_title(); ?></div>
		<?php echo ct_business_blog_excerpt(); ?>
		<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( $button_text ); ?></a>
	</div>
	<div class="image-container">
		<?php the_post_thumbnail(); ?>
	</div>
</li>