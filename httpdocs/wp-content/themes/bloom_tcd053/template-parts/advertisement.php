<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

if ( is_singular( 'post' ) ) {
	if ( is_mobile() ) {
		if ( $dp_options['single_mobile_ad_code1'] || $dp_options['single_mobile_ad_image1'] ) {
			echo '<div class="p-entry__ad">' . "\n";
			if ( $dp_options['single_mobile_ad_code1'] ) {
				echo '<div class="p-entry__ad-item">' . $dp_options['single_mobile_ad_code1'] . '</div>';
			} elseif ( $dp_options['single_mobile_ad_image1'] ) {
				$single_mobile_image1 = wp_get_attachment_image_src( $dp_options['single_mobile_ad_image1'], 'full' );
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $dp_options['single_mobile_ad_url1'] ) . '"><img src="' . esc_attr( $single_mobile_image1[0] ) . '" alt=""></a></div>';
			}
			echo '</div>' . "\n";
		}
	} else {
		if ( $dp_options['single_ad_code1'] || $dp_options['single_ad_image1'] || $dp_options['single_ad_code2'] || $dp_options['single_ad_image2'] ) {
			echo '<div class="p-entry__ad">' . "\n";
			if ( $dp_options['single_ad_code1'] ) {
				echo '<div class="p-entry__ad-item">' . $dp_options['single_ad_code1'] . '</div>';
			} elseif ( $dp_options['single_ad_image1'] ) {
				$single_image1 = wp_get_attachment_image_src( $dp_options['single_ad_image1'], 'full' );
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $dp_options['single_ad_url1'] ) . '"><img src="' . esc_attr( $single_image1[0] ) . '" alt=""></a></div>';
			}
			if ( $dp_options['single_ad_code2'] ) {
				echo '<div class="p-entry__ad-item">' . $dp_options['single_ad_code2'] . '</div>';
			} elseif ( $dp_options['single_ad_image2'] ) {
				$single_image2 = wp_get_attachment_image_src( $dp_options['single_ad_image2'], 'full' );
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $dp_options['single_ad_url2'] ) . '"><img src="' . esc_attr( $single_image2[0] ) . '" alt=""></a></div>';
			}
			echo '</div>' . "\n";
		}
	}
}
?>
