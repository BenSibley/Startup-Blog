<?php
$author_display = get_theme_mod( 'post_byline_author' );
$date_display   = get_theme_mod( 'post_byline_date' );

if ( $author_display == 'no' && $date_display == 'no' ) {
	return;
}

$author = get_the_author();
$date   = date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );

echo '<div class="post-byline">';
if ( $author_display == 'no' ) {
	printf( esc_html_x( 'Published %s', 'This blog post was published on some date', 'business-blog' ), $date );
} elseif ( $date_display == 'no' ) {
	printf( esc_html_x( 'Published by %s', 'This blog post was published by some author', 'business-blog' ), $author );
} else {
	printf( esc_html_x( 'Published %1$s by %2$s', 'This blog post was published on some date by some author', 'business-blog' ), $date, $author );
}
echo '</div>';
