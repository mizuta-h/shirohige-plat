<?php
global $dp_options, $dp_default_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ネイティブ広告の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Native advertisement setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Native advertisement label setting', 'tcd-w' ); ?></h4>
	<table class="theme_option_table">
		<tr>
			<td><label><?php _e( 'Font size', 'tcd-w' ); ?></label></td>
			<td><input class="small-text" name="dp_options[native_ad_label_font_size]" type="number" value="<?php echo esc_attr( $dp_options['native_ad_label_font_size'] ); ?>" min="0"><span>px</span></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[native_ad_label_text_color]" type="text" value="<?php echo esc_attr( $dp_options['native_ad_label_text_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['native_ad_label_text_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
			<td><input class="c-color-picker" name="dp_options[native_ad_label_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['native_ad_label_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['native_ad_label_bg_color'] ); ?>"></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'Native advertisement contents setting', 'tcd-w' ); ?></h4>
	<div class="theme_option_message">
		<p><?php _e( 'One out of five advertisement will be displayed at random.', 'tcd-w' ); ?></p>
	</div>
	<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
	<div class="sub_box cf"> 
		<h3 class="theme_option_subbox_headline"><?php printf( __( 'Native advertisement%s setting', 'tcd-w' ), $i ); ?></h3>
		<div class="sub_box_content">
			<h4 class="theme_option_headline2"><?php _e( 'Native advertisement title', 'tcd-w' ); ?></h4>
			<input class="regular-text" name="dp_options[native_ad_title<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['native_ad_title' . $i] ); ?>" />
			<h4 class="theme_option_headline2"><?php _e( 'Native advertisement label', 'tcd-w' ); ?></h4>
			<input class="regular-text" name="dp_options[native_ad_label<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['native_ad_label' . $i] ); ?>" />
			<h4 class="theme_option_headline2"><?php _e( 'Native advertisement image', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Recommend image size. Width:390px Height:270px', 'tcd-w' ); ?></p>
			<p><?php _e( 'When displaying native advertisements on the header slider, we recommend a width of 800px and a height of 550px or more', 'tcd-w' ); ?></p>
			<div class="image_box cf">
				<div class="cf cf_media_field hide-if-no-js native_ad_image<?php echo $i; ?>">
					<input type="hidden" value="<?php echo esc_attr( $dp_options['native_ad_image' . $i] ); ?>" id="native_ad_image<?php echo $i; ?>" name="dp_options[native_ad_image<?php echo $i; ?>]" class="cf_media_id">
					<div class="preview_field"><?php if ( $dp_options['native_ad_image' . $i] ) { echo wp_get_attachment_image( $dp_options['native_ad_image' . $i], 'medium' ); } ?></div>
					<div class="buttton_area">
						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['native_ad_image' . $i] ) { echo 'hidden'; } ?>">
					</div>
				</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Native advertisement link url', 'tcd-w' ); ?></h4>
			<input class="regular-text" name="dp_options[native_ad_url<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['native_ad_url' . $i] ); ?>" />
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" />
		</div>
	</div>
	<?php endfor; ?>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
