<?php

$categories = get_the_category( $post->ID );
$separator  = ', ';
$output     = '';

if ( $categories ) {
	echo '<p class="post-categories">';
	echo '<span>' . esc_html_x( 'Published in', 'Published in POST CATEGORY', 'business-blog' ) . '</span> ';
	foreach ( $categories as $category ) {
		if ( $category === end( $categories ) && $category !== reset( $categories ) ) {
			$output = rtrim( $output, ", " ); // remove trailing comma
			$output .= ' ' . esc_html_x( 'and', 'CATEGORY and CATEGORY', 'business-blog' ) . ' ';
		}
		$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( _x( "View all posts in %s", 'View all posts in post category', 'business-blog' ), $category->name ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $separator;
	}
	echo trim( $output, $separator );
	echo "</p>";
}