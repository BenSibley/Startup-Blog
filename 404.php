<?php get_header(); ?>
	<div class="entry">
		<article>
			<div class="post-padding-container">
				<div class='post-header'>
					<h1 class='post-title'><?php _e('404: Page Not Found', 'business-blog'); ?></h1>
				</div>
				<div class="post-content">
					<p><?php _e('Sorry, we couldn\'t find a page at this URL', 'business-blog' ); ?></p>
					<p><?php _e('Please double-check that the URL is correct or try searching our site with the form below.', 'business-blog' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</div>
		</article>
	</div>
<?php get_footer(); ?>