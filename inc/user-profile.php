<?php

function startup_blog_add_social_profile_settings( $user ) {

	$user_id = get_current_user_id();

	if ( ! current_user_can( 'edit_posts', $user_id ) ) {
		return false;
	}

	$social_sites = ct_startup_blog_social_array();

	?>
	<table class="form-table">
		<tr>
			<th>
				<h3><?php esc_html_e( 'Social Profiles', 'startup-blog' ); ?></h3>
			</th>
		</tr>
		<?php
		foreach ( $social_sites as $key => $social_site ) {

			$label = ucfirst( $key );

			if ( $key == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $key == 'rss' ) {
				$label = 'RSS';
			} elseif ( $key == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $key == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $key == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $key == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $key == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $key == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $key == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $key == 'qq' ) {
				$label = 'QQ';
			} elseif ( $key == 'vk' ) {
				$label = 'VK';
			} elseif ( $key == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $key == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			} elseif ( $key == 'paypal' ) {
				$label = 'PayPal';
			} elseif ( $key == 'email-form' ) {
				$label = 'Contact Form';
			} elseif ( $key == 'google-wallet' ) {
				$label = 'Google Wallet';
			}
			?>
			<tr>
				<th>
					<?php if ( $key == 'email' ) : ?>
						<label for="<?php echo esc_attr( $key ); ?>-profile"><?php esc_html_e( 'Email Address', 'startup-blog' ); ?></label>
					<?php else : ?>
						<label for="<?php echo esc_attr( $key ); ?>-profile"><?php echo esc_html( $label ); ?></label>
					<?php endif; ?>
				</th>
				<td>
					<?php if ( $key == 'email' ) { ?>
						<input type='text' id='<?php echo esc_attr( $key ); ?>-profile' class='regular-text'
						       name='<?php echo esc_attr( $key ); ?>-profile'
						       value='<?php echo is_email( get_the_author_meta( $social_site, $user->ID ) ); ?>'/>
					<?php } elseif ( $key == 'skype' ) { ?>
						<input type='url' id='<?php echo esc_attr( $key ); ?>-profile' class='regular-text'
						       name='<?php echo esc_attr( $key ); ?>-profile'
						       value='<?php echo esc_url( get_the_author_meta( $social_site, $user->ID ), array( 'http', 'https', 'skype' ) ); ?>'/>
					<?php } else { ?>
						<input type='url' id='<?php echo esc_attr( $key ); ?>-profile' class='regular-text'
						       name='<?php echo esc_attr( $key ); ?>-profile'
						       value='<?php echo esc_url( get_the_author_meta( $social_site, $user->ID ) ); ?>'/>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</table>
	<?php
}
add_action( 'show_user_profile', 'startup_blog_add_social_profile_settings' );
add_action( 'edit_user_profile', 'startup_blog_add_social_profile_settings' );

function startup_blog_save_social_profiles( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$social_sites = ct_startup_blog_social_array();

	foreach ( $social_sites as $key => $social_site ) {
		if ( $key == 'email' ) {
			// if email, only accept 'mailto' protocol
			if ( isset( $_POST["$key-profile"] ) ) {
				update_user_meta( $user_id, $social_site, sanitize_email( wp_unslash( $_POST["$key-profile"] ) ) );
			}
		} elseif ( $key == 'skype' ) {
			// accept skype protocol
			if ( isset( $_POST["$key-profile"] ) ) {
				update_user_meta( $user_id, $social_site, esc_url_raw( wp_unslash( $_POST["$key-profile"] ), array( 'http', 'https', 'skype' ) ) );
			}
		} else {
			if ( isset( $_POST["$key-profile"] ) ) {
				update_user_meta( $user_id, $social_site, esc_url_raw( wp_unslash( $_POST["$key-profile"] ) ) );
			}
		}
	}
}
add_action( 'personal_options_update', 'startup_blog_save_social_profiles' );
add_action( 'edit_user_profile_update', 'startup_blog_save_social_profiles' );