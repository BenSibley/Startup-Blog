<?php

if ( ! is_archive() ) {
	return;
}

$icon_class = 'folder-open';
$prefix = _x( 'Posts published in', 'Posts published in CATEGORY', 'business-blog' );

if ( is_tag() ) {
	$icon_class = 'tag';
	$prefix = __( 'Posts tagged as', 'business-blog' );
} elseif ( is_author() ) {
	$icon_class = 'user';
	$prefix = _x( 'Posts published by', 'Posts published by AUTHOR', 'business-blog' );
} elseif ( is_date() ) {
	$icon_class = 'calendar';
	// Repeating default value to add new translator note - context may change word choice
	$prefix = _x( 'Posts published in', 'Posts published in MONTH', 'business-blog' );
}
?>

<div class='archive-header'>
	<h1>
		<i class="fa fa-<?php echo $icon_class; ?>"></i>
		<?php
		echo $prefix . ' ';
		the_archive_title( '&ldquo;', '&rdquo;' );
		?>
	</h1>
	<p class="description">
		<?php the_archive_description(); ?>
	</p>
</div>