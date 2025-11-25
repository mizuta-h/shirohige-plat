<?php

function tcd_post_meta_box() {
	add_meta_box(
		'tcd_post_meta_box' ,// ID of meta box
		__( 'Post setting', 'tcd-w' ), // label
		'show_tcd_post_meta_box', // callback function
		'post', // post type
		'normal', // context
		'high' // priority
	);

	add_meta_box(
		'tcd_post_meta_box2' ,// ID of meta box
		__( 'Advertisement label settings', 'tcd-w' ), // label
		'show_tcd_post_meta_box2', // callback function
		'post', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_post_meta_box', 10 );

function show_tcd_post_meta_box() {
	global $post;

	// タイトル表示設定
	$title_align = array(
		'name' => __( 'Title align', 'tcd-w' ),
		'id' => 'title_align',
		'type' => 'radio',
		'std' => '',
		'options' => array(
			array(
				'name' => __( 'Use theme option setting', 'tcd-w' ),
				'value' => ''
			),
			array(
				'name' => __( 'Align left', 'tcd-w' ),
				'value' => 'type1'
			),
			array(
				'name' => __( 'Align center', 'tcd-w' ),
				'value' => 'type2'
			)
		)
	);
	$title_align_meta = $post->title_align;
	if ( ! $title_align_meta ) {
		$title_align_meta = $title_align['std'];
	}

	// ページナビゲーション設定
	$page_link = array(
		'name' => __( 'Pages link setting', 'tcd-w' ),
		'id' => 'page_link',
		'type' => 'radio',
		'std' => '',
		'options' => array(
			array(
				'name' => __( 'Use theme option setting', 'tcd-w' ),
				'value' => ''
			),
			array(
				'name' => __( 'Page numbers', 'tcd-w' ),
				'value' => 'type1'
			),
			array(
				'name' => __( 'Read more button', 'tcd-w' ),
				'value' => 'type2'
			)
		)
	);
	$page_link_meta = $post->page_link;
	if ( ! $page_link_meta ) {
		$page_link_meta = $page_link['std'];
	}

	echo '<input type="hidden" name="tcd_post_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />' . "\n";

	echo '<dl class="tcd_custom_fields">' . "\n";

	// タイトル表示設定
	echo '<dt class="label"><label for="' . esc_attr( $title_align['id'] ). '">' . esc_html( $title_align['name'] ) . '</label></dt>';
	echo '<dd class="content"><ul class="radio title_align cf">';
	foreach ( $title_align['options'] as $title_align_option ) {
		echo '<li><label><input type="radio" id ="title_align-' . esc_attr( $title_align_option['value'] ) . '" name="' . $title_align['id'] . '" value="' . esc_attr( $title_align_option['value'] ) . '"' . checked( $title_align_meta, $title_align_option['value'] , false ) . ' />' . esc_html( $title_align_option['name'] ) . '</label></li>';
	}
	echo '</ul></dd>' . "\n";

	// ページナビゲーション設定
	echo '<dt class="label"><label for="' . esc_attr( $page_link['id'] ). '">' . esc_html( $page_link['name'] ) . '</label></dt>';
	echo '<dd class="content">';
    echo '<p class="desc">' . __( 'Please set the page navigation display method of page split display by & lt;! - nextpage - & gt;', 'tcd-w' ) . '</p>';
	echo '<ul class="radio page_link cf">';
	foreach ( $page_link['options'] as $page_link_option ) {
		echo '<li><label><input type="radio" id ="page_link-' . esc_attr( $page_link_option['value'] ) . '" name="' . $page_link['id'] . '" value="' . esc_attr( $page_link_option['value'] ) . '"' . checked( $page_link_meta, $page_link_option['value'] , false ) . ' />' . esc_html( $page_link_option['name'] ) . '</label></li>';
	}
	echo '</ul></dd>' . "\n";

	echo '</dl>' . "\n";
}

// ネイティブ広告設定
function show_tcd_post_meta_box2() {
	global $post;

	$cf_key = 'show_native_ad';
	$cf_value = $post->$cf_key;
	echo '<p><label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1" ' . checked( $cf_value, '1', false ) . '>' . __( 'Display advertisement label', 'tcd-w' ) , '</label></p>' . "\n";
	echo '<p><label>' . __( 'Please check this when using this post as article advertisement.', 'tcd-w' ) , '</label></p>' . "\n";

	echo '<dl class="tcd_custom_fields">' . "\n";

	$cf_key = 'native_ad_label';
	$cf_value = $post->$cf_key;
	echo '<dt class="label"><label>' . __( 'Native advertisement label', 'tcd-w' ) . '</label></dt>';
	echo '<dd class="content"><input class="regular-text" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '"></dd>' . "\n";

	$cf_key = 'native_ad_url';
	$cf_value = $post->$cf_key;
	echo '<dt class="label"><label>' . __( 'Native advertisement url', 'tcd-w' ) . '</label></dt>';
	echo '<dd class="content"><input class="regular-text" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '"></dd>' . "\n";

	echo '</dl>' . "\n";
}

function save_tcd_post_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_post_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_post_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
	}

	// save or delete
	$cf_keys = array(
		'title_align',
		'page_link',
		'show_native_ad',
		'native_ad_label',
		'native_ad_url'
	);
	foreach ( $cf_keys as $cf_key ) {
		$old = get_post_meta( $post_id, $cf_key, true );
		$new = isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '';

		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $cf_key, $new );
		} elseif ( ! $new && $old ) {
			delete_post_meta( $post_id, $cf_key, $old );
		}
	}

}
add_action( 'save_post', 'save_tcd_post_meta_box' );
