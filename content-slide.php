<?php
$button_text = get_theme_mod('slider_button_text');
// Using esc_html() on L5 because "esc_attr" strips the classes due to the use of numbers e.g slider-2
?>
<li class="<?php echo esc_html( $classes ); ?>">
	<div class="content-container">
		<div class="max-width">
			<div class="title"><?php the_title(); ?></div>
			<?php
			// echo'ing get_the_excerpt() instead of using the_excerpt() to avoid plugins adding content via filters.
			// Ex. Jetpack will add social sharing buttons into the slide when using the_excerpt(): http://pics.competethemes.com/l3AM
			echo wp_kses_post( wpautop( get_the_excerpt() ) );
			?>
			<a class="read-more" href="<?php the_permalink(); ?>">
				<?php
				if ( $button_text == '' ) {
					esc_html_e( 'Read more', 'startup-blog');
				} else {
					echo esc_html( $button_text );
				}
				?>
			</a>
		</div>
	</div>
	<div class="image-container" style="background-image: url('<?php the_post_thumbnail_url(); ?>');"></div>
</li>