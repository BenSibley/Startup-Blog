<?php

echo "<div id='site-title' class='site-title'>";
	if ( has_custom_logo() ) {
		/* TRT Note: avoiding use of the_custom_logo() b/c there is no way to display the site title upon removing the logo since 
		has_custom_logo() will always evaluate to true. This approach outputs the image without the class used for selective refresh.
		Logos should be displayed in place of titles not in conjunction because logos ARE the site/business' name (otherwise they're just graphics). */
		$logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $logo_id , 'full' );
		$logo_url = $image[0];
		echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="logo" />';
	} else {
		echo "<a href='" . esc_url( home_url() ) . "'>";
			bloginfo( 'name' );
		echo "</a>";
	}
echo "</div>";