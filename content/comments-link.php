<span class="comments-link">
	<i class="fa fa-comment" title="<?php _e( 'comment icon', 'business-blog' ); ?>"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( __( 'Comments closed', 'business-blog' ), __( '1 Comment', 'business-blog' ), __( '% Comments', 'business-blog' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( __( 'Leave a Comment', 'business-blog' ), __( '1 Comment', 'business-blog' ), __( '% Comments', 'business-blog' ) );
		echo '</a>';
	endif;
	?>
</span>