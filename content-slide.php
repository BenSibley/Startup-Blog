<li class="<?php echo $classes; ?>">
	<div class="content-container">
		<div class="title"><?php the_title(); ?></div>
		<?php echo ct_business_blog_excerpt(); ?>
		<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'business-blog'); ?></a>
	</div>
	<div class="image-container">
		<?php the_post_thumbnail(); ?>
	</div>
</li>