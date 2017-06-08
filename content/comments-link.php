<?php
$classes = 'post-comments-link';
$icon = 'fa-comment-o';
if ( !comments_open() ) {
	$classes .= ' closed';
	$icon = 'fa-comment';
}

?>
<span class="<?php echo $classes; ?>">
	<?php
	echo '<a href="' . esc_url( get_comments_link() ) . '">';
		echo '<i class="fa ' . $icon . '" title="' . __( "comment icon", "business-blog" ) . '"></i>';
		echo '<span>';
			comments_number( 0, 1, '%' );
		echo '</span>';
	echo '</a>';
	?>
</span>