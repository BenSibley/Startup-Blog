<?php
/*
 * TRT Notes:
 * esc_html() is used on L8 because "esc_attr" strips the classes due to the use of numbers e.g slider-2
 */
$button_text = get_theme_mod('slider_button_text');
?>
<li class="<?php echo esc_html( $classes ); ?>">
	<div class="content-container">
		<div class="max-width">
			<div class="title"><?php the_title(); ?></div>
			<?php the_excerpt(); ?>
			<a class="read-more" href="<?php the_permalink(); ?>">
				<?php
				if ( $button_text == '' ) {
					esc_html_e( 'Read more', 'business-blog');
				} else {
					echo esc_html( $button_text );
				}
				?>
			</a>
		</div>
	</div>
	<div class="image-container">
		<?php the_post_thumbnail(); ?>
	</div>
</li>