<?php

// プロフィールURL項目にSNSを追加
function tcd_user_profile_user_contactmethods( $methods, $user ) {
	return array(
		'facebook_url' => __( 'Your Facebook URL', 'tcd-w' ),
		'twitter_url' => __( 'Your X URL', 'tcd-w' ),
		'instagram_url' => __( 'Your Instagram URL', 'tcd-w' ),
		'pinterest_url' => __( 'Your Pinterest URL', 'tcd-w' ),
		'youtube_url' => __( 'Your Youtube URL', 'tcd-w' ),
		'contact_url' => __( 'Your contact page URL<br>(You can use mailto:)', 'tcd-w' )
	);
}
add_filter( 'user_contactmethods', 'tcd_user_profile_user_contactmethods', 10, 2 );

// プロフィールに項目を追加
function tcd_user_profile_edit_user_profile( $user ) {
?>
	<h3><?php _e( 'Other profile information', 'tcd-w' ); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="show_author"><?php _e( 'Show authors profile', 'tcd-w' ); ?></label></th>
			<td><input name="show_author" type="checkbox" id="show_author" value="1" <?php checked( $user->show_author, 1 ); ?>> <?php _e( 'Show', 'tcd-w'); ?></td>
		</tr>
	</table>
<?php
}
add_action( 'show_user_profile', 'tcd_user_profile_edit_user_profile', 11 );
add_action( 'edit_user_profile', 'tcd_user_profile_edit_user_profile', 11 );

// プロフィール追加項目保存
function tcd_user_profile_edit_user_profile_update( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) return false;
	update_usermeta( $user_id, 'show_author', ! empty( $_POST['show_author'] ) ? 1 :0 );
}
add_action( 'personal_options_update', 'tcd_user_profile_edit_user_profile_update' );
add_action( 'edit_user_profile_update', 'tcd_user_profile_edit_user_profile_update' );

// アーカイブ用投稿者HTML出力
function the_archive_author( $post = null, $echo = true ) {
	if ( ! $post ) $post = get_post();

	$html = '';

	if ( function_exists( 'get_coauthors') ) {
		$authors = get_coauthors( $post->ID );
	} else {
		$authors = array( get_user_by( 'id', $post->post_author ) );
	}

	if ( $authors && is_array( $authors ) ) {
		foreach( $authors as $author ) {
			if ( ! $author->show_author ) continue;

			$html .= '<span class="p-article__author" data-url="' . get_author_posts_url( $author->ID ) . '"><span class="p-article__author-thumbnail">' . get_avatar( $author->ID, 32 ) . '</span>' . esc_html( $author->display_name ) . '</span>';
		}

		if ( $html ) {
			$html = '<span class="p-article__authors">' . $html . '</span>';
		}
	}

	$html = apply_filters( 'the_archive_author', $html, $post );

	if ( $echo ) {
		echo $html;
	} else {
		return $html;
	}
}
