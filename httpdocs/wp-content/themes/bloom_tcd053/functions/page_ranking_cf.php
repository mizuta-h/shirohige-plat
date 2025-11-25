<?php

function tcd_page_ranking_meta_box() {
	add_meta_box(
		'tcd_page_ranking_meta_box', // ID of meta box
		__( 'Ranking', 'tcd-w' ), // label
		'show_tcd_page_ranking_meta_box', // callback function
		'page', // post type
		'normal', // context
		'high' // priority
	);
}
add_action( 'add_meta_boxes', 'tcd_page_ranking_meta_box' );

function show_tcd_page_ranking_meta_box( $post ) {

	echo '<input type="hidden" name="tcd_page_ranking_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<dl class="tcd_custom_fields">' . "\n";

	$cf_key = 'rank_post_num';
	$cf_value = absint( $post->$cf_key );
	if ( ! $cf_value ) $cf_value = 10;
	echo '<dt class="label"><label>' . __( 'Number of ranks', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1">';
	echo '</dd>' . "\n";

	$cf_key = 'rank_category';
	$cf_value = $post->$cf_key;
	echo '<dt class="label"><label>' . __( 'Category', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	wp_dropdown_categories( array(
		'class' => '',
		'echo' => 1,
		'hide_empty' => 0,
		'hierarchical' => 1,
		'id' => '',
		'name' => $cf_key,
		'selected' => $cf_value,
		'show_count' => 0,
		'show_option_all' => __( 'All categories', 'tcd-w' ),
		'value_field' => 'term_id'
	) );
	echo '</dd>' . "\n";

	echo '<dt class="label"><label>' . __( 'Display setting', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">' . "\n";

	$cf_key = 'rank_show_date';
	$cf_value = $post->$cf_key;
	echo '<p><label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1" ' . checked( $cf_value, '1', false ) . '>' . __( 'Display date', 'tcd-w' ) , '</label></p>' . "\n";

	$cf_key = 'rank_show_category';
	$cf_value = $post->$cf_key;
	echo '<p><label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1" ' . checked( $cf_value, '1', false ) . '>' . __( 'Display category', 'tcd-w' ) , '</label></p>' . "\n";

	$cf_key = 'rank_show_views';
	$cf_value = $post->$cf_key;
	echo '<p><label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1" ' . checked( $cf_value, '1', false ) . '>' . __( 'Display views', 'tcd-w' ) , '</label></p>' . "\n";

	$cf_key = 'rank_show_author';
	$cf_value = $post->$cf_key;
	echo '<p><label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1" ' . checked( $cf_value, '1', false ) . '>' . __( 'Display author', 'tcd-w' ) , '</label></p>' . "\n";

	echo '</dd>' . "\n";

	// ネイティブ広告設定
	$cf_key = 'show_native_ad';
	$cf_value = $post->$cf_key;
	echo '<dt class="label"><label>' . __( 'Native advertisement', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content"><label><input name="' . esc_attr( $cf_key ) . '" type="checkbox" value="1" ' . checked( $cf_value, '1', false ) . '>' . __( 'Display native advertisement', 'tcd-w' ) . '</label></dd>' . "\n";

	$cf_key = 'native_ad_position';
	$cf_value = $post->$cf_key;
	if ( ! $cf_value ) $cf_value = 4;
	echo '<dt class="label"><label>' . __( 'Position of native advertisement', 'tcd-w' ) , '</label></dt>';
	echo '<dd class="content">';
	echo '<div class="theme_option_message"><p>' . __( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ) . '</p></div>';
	echo '<input class="small-text" name="' . esc_attr( $cf_key ) . '" type="number" value="' . esc_attr( $cf_value ) . '" min="1">';
	echo '</dd>' . "\n";

	echo '<dt class="label"><label>' . __( 'Rank color setting', 'tcd-w' ) . '</label></dt>';
	echo '<dd class="content">' . "\n";
	echo '<table>' . "\n";

	for ( $i = 1; $i <= 5; $i++ ) {
		$cf_key = 'rank_font_color' . $i;
		$cf_value = $post->$cf_key;
		$cf_default = ( 3 >= $i ) ? '#ffffff' : '#000000';
		if ( ! $cf_value ) $cf_value = $cf_default;
		echo '<tr><td><label>' . sprintf( __('Rank %d font color:', 'tcd-w' ), $i ) . '</label></td>';
		echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

		$cf_key = 'rank_bg_color' . $i;
		$cf_value = $post->$cf_key;
		$cf_default = ( 3 >= $i ) ? '#000000' : '#ffffff';
		if ( ! $cf_value ) $cf_value = $cf_default;
		echo '<tr><td><label>' . sprintf( __('Rank %d background color:', 'tcd-w' ), $i ) , '</label></td>';
		echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";
	}

	$cf_key = 'rank_font_color0';
	$cf_value = $post->$cf_key;
	$cf_default = '#000000';
	if ( ! $cf_value ) $cf_value = $cf_default;
	echo '<tr><td><label>' . __( 'Other rank font color:', 'tcd-w' ) , '</label></td>';
	echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

	$cf_key = 'rank_background_color0';
	$cf_value = $post->$cf_key;
	$cf_default = '#ffffff';
	if ( ! $cf_value ) $cf_value = $cf_default;
	echo '<tr><td><label>' . __( 'Other rank background color:', 'tcd-w' ) , '</label></td>';
	echo '<td><input class="c-color-picker" name="' . esc_attr( $cf_key ) . '" type="text" value="' . esc_attr( $cf_value ) . '" data-default-color="' . esc_attr( $cf_default ) . '"></td></tr>' . "\n";

	echo '</table>' . "\n";
	echo '</dd>' . "\n";

	echo '</dl>' . "\n";

	echo <<< EOM
<script>
jQuery(function($){
	$('select#page_template').change(function(){
		if (this.value.indexOf('ranking') > -1) {
			$('#tcd_page_ranking_meta_box-hide').attr('checked', 'checked');
			$('#tcd_page_ranking_meta_box').show().removeClass('closed');
		} else {
			$('#tcd_page_ranking_meta_box-hide').removeAttr('checked');
			$('#tcd_page_ranking_meta_box').hide();
		}
	}).trigger('change');
});
</script>
EOM;
}

function save_tcd_page_ranking_meta_box( $post_id ) {

	// verify nonce
	if ( ! isset( $_POST['tcd_page_ranking_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['tcd_page_ranking_meta_box_nonce'], basename( __FILE__ ) ) ) {
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
	} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// save or delete
	$cf_keys = array(
		'rank_category',
		'rank_post_num',
		'rank_show_date',
		'rank_show_category',
		'rank_show_views',
		'rank_show_author',
		'show_native_ad',
		'native_ad_position'
	);
	for ( $i = 0; $i <= 5; $i++ ) {
		$cf_keys[] = 'rank_font_color' . $i;
		$cf_keys[] = 'rank_bg_color' . $i;
	}
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
add_action( 'save_post', 'save_tcd_page_ranking_meta_box' );

function tcd_page_ranking_hidden_meta_boxes( $hidden, $screen, $use_defaults ) {
	$hidden[] = 'tcd_page_ranking_meta_box';
	return array_unique( $hidden );
}
add_action( 'hidden_meta_boxes', 'tcd_page_ranking_hidden_meta_boxes', 10, 3 );
