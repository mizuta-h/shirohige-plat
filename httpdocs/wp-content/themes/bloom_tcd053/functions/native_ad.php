<?php

/**
 * ネイティブ広告ランダム取得
 */
function get_native_ad() {
	global $dp_options, $tcd_native_ad, $tcd_native_ad_temp;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( ! is_array( $tcd_native_ad ) ) {
		$tcd_native_ad = array();
		$tcd_native_ad_temp = array();

		for ( $i = 1; $i <= 6; $i++ ) {
			if ( ! empty( $dp_options['native_ad_title' . $i] ) && ! empty( $dp_options['native_ad_image' . $i] ) ) {
				$tcd_native_ad[] = array(
					'native_ad_title' => $dp_options['native_ad_title' . $i],
					'native_ad_label' => $dp_options['native_ad_label' . $i],
					'native_ad_image' => $dp_options['native_ad_image' . $i],
					'native_ad_url' => $dp_options['native_ad_url' . $i]
				);
			}
		}
	}

	if ( ! $tcd_native_ad ) return false;

	if ( ! $tcd_native_ad_temp ) {
		$tcd_native_ad_temp = $tcd_native_ad;
		mt_shuffle( $tcd_native_ad_temp );
	}

	if ( $tcd_native_ad_temp ) {
		return array_shift( $tcd_native_ad_temp );
	}
}

/**
 * shuffle()の偏り対策
 */
if ( ! function_exists( 'mt_shuffle' ) ) :
	function mt_shuffle( array &$array ) {
		$array = array_values( $array );
		for ( $i = count( $array ) - 1; $i > 0; --$i ) {
			$j = mt_rand( 0, $i );
			if ( $i !== $j ) {
				list( $array[$i], $array[$j] ) = array( $array[$j], $array[$i] );
			}
		}
	}
endif;

/**
 * 最初のthe_postでネイティブ広告テンポラリー配列をリセット
 */
function native_ad_the_post( $post, $wp_query ) {
	if ( ! is_admin() && $wp_query->is_main_query() && 0 === $wp_query->current_post) {
		global $tcd_native_ad_temp;
		$tcd_native_ad_temp = array();
	}
}
add_action( 'the_post', 'native_ad_the_post', 10, 2 );
