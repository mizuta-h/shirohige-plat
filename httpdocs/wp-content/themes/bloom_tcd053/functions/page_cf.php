<?php

function tcd_page_meta_box() {
	add_meta_box(
		'tcd_page_meta_box' ,// ID of meta box
		__( 'Page setting', 'tcd-w' ), // label
		'show_tcd_page_meta_box', // callback function
		'page', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_page_meta_box' );

function show_tcd_page_meta_box() {
	global $post;

	// タイトル表示設定
	$title_align = array(
		'name' => __( 'Title align', 'tcd-w' ),
		'id' => 'title_align',
		'type' => 'radio',
		'std' => 'left',
		'options' => array(
			array(
				'name' => __( 'Align left', 'tcd-w' ),
				'value' => 'left'
			),
			array(
				'name' => __( 'Align center', 'tcd-w' ),
				'value' => 'center'
			),
			array(
				'name' => __( 'No title', 'tcd-w' ),
				'value' => 'hide'
			)
		)
	);
	$title_align_meta = $post->title_align;
	if ( ! $title_align_meta ) {
		$title_align_meta = $title_align['std'];
	}

	// サイドコンテンツの設定
	$display_side_content = array(
		'name' => __( 'Side content', 'tcd-w' ),
		'id' => 'display_side_content',
		'type' => 'radio',
		'std' => 'show',
		'options' => array(
			array(
				'name' => __( 'Display side content', 'tcd-w' ),
				'value' => 'show'
			),
			array(
				'name' => __( 'No side content', 'tcd-w' ),
				'value' => 'hide'
			)
		)
	);
	$display_side_content_meta = $post->display_side_content;
	if ( ! $display_side_content_meta ) {
		$display_side_content_meta = $display_side_content['std'];
	}

	echo '<input type="hidden" name="tcd_page_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<dl class="tcd_custom_fields">';

	// タイトル表示設定
	echo '<dt class="label"><label for="' . esc_attr( $title_align['id'] ). '">' . esc_html( $title_align['name'] ) . '</label></dt>';
	echo '<dd class="content"><ul class="radio title_align cf">';
	foreach ( $title_align['options'] as $title_align_option ) {
		echo '<li><label><input type="radio" id ="title_align-' . esc_attr( $title_align_option['value'] ) . '" name="' . $title_align['id'] . '" value="' . esc_attr( $title_align_option['value'] ) . '"' . checked( $title_align_meta, $title_align_option['value'] , false ) . ' />' . esc_html( $title_align_option['name'] ) . '</label></li>';
	}
	echo '</ul></dd>';

	// サイドコンテンツの選択
	echo '<dt class="label"><label for="' . esc_attr( $display_side_content['id'] ) . '">' . esc_html( $display_side_content['name'] ). '</label></dt>';
	echo '<dd class="content"><ul class="radio side_content cf">';
	foreach ( $display_side_content['options'] as $display_side_content_option ) {
		echo '<li><label><input type="radio" id ="side_content-' . esc_attr( $display_side_content_option['value'] ) . '" name="' . $display_side_content['id'] . '" value="' . esc_attr( $display_side_content_option['value'] ) . '"' . checked( $display_side_content_meta, $display_side_content_option['value'] , false ) . ' />' . esc_html( $display_side_content_option['name'] ). '</label></li>';
	}
	echo '</ul></dd>';

	echo '</dl>'."\n";
}

function save_tcd_page_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_page_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_page_meta_box_nonce'], basename( __FILE__ ) ) ) {
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
		'display_side_content'
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
add_action( 'save_post', 'save_tcd_page_meta_box' );
