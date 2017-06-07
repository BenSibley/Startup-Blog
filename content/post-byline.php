<?php
$author_display = get_theme_mod( 'display_post_author' );
$date_display   = get_theme_mod( 'display_post_date' );

if ( $author_display == 'hide' && $date_display == 'hide' ) {
	return;
}

$author = get_the_author();
$date   = date_i18n( get_option( 'date_format' ), strtotime( get_the_date( 'r' ) ) );

echo '<div class="post-byline">';
if ( $author_display == 'hide' ) {
	printf( _x( 'Published %s', 'This blog post was published on some date', 'business-blog' ), $date );
} elseif ( $date_display == 'hide' ) {
	printf( _x( 'Published by %s', 'This blog post was published by some author', 'business-blog' ), $author );
} else {
	printf( _x( 'Published %1$s by %2$s', 'This blog post was published on some date by some author', 'business-blog' ), $date, $author );
}
echo '</div>';
