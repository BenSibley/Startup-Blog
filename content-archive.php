<div <?php post_class(); ?>>
	<?php do_action( 'business_blog_archive_post_before' ); ?>
	<article>
		<div class='post-header'>
			<?php do_action( 'business_blog_sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php get_template_part( 'content/post-byline' ); ?>
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 42, '', get_the_author() ); ?>
			<?php get_template_part( 'content/comments-link' ); ?>
		</div>
		<?php ct_business_blog_featured_image(); ?>
		<div class="post-content">
			<?php the_excerpt(); ?>
		</div>
	</article>
	<?php do_action( 'business_blog_archive_post_after' ); ?>
</div>