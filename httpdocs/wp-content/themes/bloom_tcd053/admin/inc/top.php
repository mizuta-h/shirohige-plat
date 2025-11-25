<?php
global $dp_options, $dp_default_options, $header_content_type_options, $slide_time_options, $list_type_options, $post_order_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ヘッダーコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Header content setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Header content type', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2">
		<?php foreach ( $header_content_type_options as $option ) : ?>
		<p><label><input id="header_content_button_<?php echo esc_attr( $option['value'] ); ?>" type="radio" name="dp_options[header_content_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['header_content_type'], $option['value'] ); ?>><?php echo $option['label']; ?></label></p>
		<?php endforeach; ?>
	</fieldset>
	<div id="header_content_post_slider" style="<?php if ( $dp_options['header_content_type'] == 'type1' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Type of posts', 'tcd-w' ); ?></h4>
		<fieldset class="cf select_type2">
			<?php foreach ( $list_type_options as $option ) : ?>
			<label><input type="radio" name="dp_options[header_blog_list_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['header_blog_list_type'], $option['value'] ); ?>><?php echo $option['label']; ?><?php
				if ( 'type1' == $option['value'] ) :
					echo '&nbsp;&nbsp;';
					wp_dropdown_categories( array(
						'class' => '',
						'echo' => 1,
						'hide_empty' => 0,
						'hierarchical' => 1,
						'id' => '',
						'name' => 'dp_options[header_blog_category]',
						'selected' => $dp_options['header_blog_category'],
						'show_count' => 0,
						//'show_option_all' => __( 'All categories', 'tcd-w' ),
						'value_field' => 'term_id'
					) );
				endif;
			?></label>
			<?php endforeach; ?>
		</fieldset>
		<h4 class="theme_option_headline2"><?php _e( 'Number of posts', 'tcd-w' ); ?></h4>
		<input type="number" class="small-text" name="dp_options[header_blog_num]" value="<?php echo esc_attr( $dp_options['header_blog_num'] ); ?>" min="1" />
		<h4 class="theme_option_headline2"><?php _e( 'Post order', 'tcd-w' ); ?></h4>
		<select name="dp_options[header_blog_post_order]">
			<?php foreach ( $post_order_options as $option ) : ?>
			<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['header_blog_post_order'] ); ?>><?php echo $option['label']; ?></option>
			<?php endforeach; ?>
		</select>
		<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
		<p><label><input name="dp_options[show_header_blog_date]" type="checkbox" value="1" <?php checked( $dp_options['show_header_blog_date'], 1 ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></p>
		<p><label><input name="dp_options[show_header_blog_category]" type="checkbox" value="1" <?php checked( $dp_options['show_header_blog_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></p>
		<p><label><input name="dp_options[show_header_blog_views]" type="checkbox" value="1" <?php checked( $dp_options['show_header_blog_views'], 1 ); ?>><?php _e( 'Display views', 'tcd-w' ); ?></label></p>
		<p><label><input name="dp_options[show_header_blog_author]" type="checkbox" value="1" <?php checked( $dp_options['show_header_blog_author'], 1 ); ?>><?php _e( 'Display author', 'tcd-w' ); ?></label></p>
		<h4 class="theme_option_headline2"><?php _e('Native advertisement setting', 'tcd-w'); ?></h4>
		<p><label><input name="dp_options[show_header_blog_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_header_blog_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement', 'tcd-w' ); ?></label></p>
		<h4 class="theme_option_headline2"><?php _e( 'Position of native advertisement', 'tcd-w' ); ?></h4>
		<div class="theme_option_message">
			<p><?php _e( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ); ?></p>
		</div>
		<input class="small-text" name="dp_options[header_blog_native_ad_position]" type="number" value="<?php echo esc_attr( $dp_options['header_blog_native_ad_position'] ); ?>" min="1">
	</div><!-- END #header_content_post_slider -->
	<div id="header_content_image_slider" style="<?php echo $dp_options['header_content_type'] == 'type2' ? 'display:block;' : 'display:none;'; ?>">
		<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
		<div class="sub_box cf">
			<h3 class="theme_option_subbox_headline"><?php printf( __( 'Slider%s setting', 'tcd-w' ), $i ); ?></h3>
			<div class="sub_box_content">
				<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
				<p><?php _e( 'Recommend image size. Width:800px, Max height:550px', 'tcd-w' ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js slider_image<?php echo esc_attr( $i ); ?>">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['slider_image' . $i] ); ?>" name="dp_options[slider_image<?php echo esc_attr( $i ); ?>]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['slider_image' . $i] ) { echo wp_get_attachment_image( $dp_options['slider_image' . $i], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['slider_image' . $i] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<textarea rows="2" class="large-text" name="dp_options[slider_headline<?php echo $i; ?>]"><?php echo esc_textarea( $dp_options['slider_headline' . $i] ); ?></textarea>
				<p><?php _e( 'Font size', 'tcd-w' ); ?><input type="number" class="small-text" name="dp_options[slider_headline_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_headline_font_size' . $i] ); ?>" min="0"><span>px</span></p>
				<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
				<textarea rows="4" class="large-text" name="dp_options[slider_desc<?php echo $i; ?>]"><?php echo esc_textarea( $dp_options['slider_desc' . $i] ); ?></textarea>
				<p><?php _e( 'Font size', 'tcd-w' ); ?><input type="number" class="small-text" name="dp_options[slider_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_desc_font_size' . $i] ); ?>" min="0"><span>px</span></p>
				<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
				<input class="c-color-picker" name="dp_options[slider_font_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_font_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_font_color' . $i] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider<?php echo $i; ?>_shadow1]" value="<?php echo esc_attr( $dp_options['slider' . $i . '_shadow1'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider<?php echo $i; ?>_shadow2]" value="<?php echo esc_attr( $dp_options['slider' . $i . '_shadow2'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[slider<?php echo $i; ?>_shadow3]" value="<?php echo esc_attr( $dp_options['slider' . $i . '_shadow3'] ); ?>" min="0"><span>px</span></td>
					</tr>
					<tr>
						<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
						<td><input class="c-color-picker" name="dp_options[slider<?php echo $i; ?>_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['slider' . $i . '_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider' . $i . '_shadow_color'] ); ?>"></td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
				<input class="c-color-picker" name="dp_options[slider_overlay_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_overlay_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_overlay_color' . $i] ); ?>">
				<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.5)', 'tcd-w' ); ?></p>
				<input type="number" class="small-text" name="dp_options[slider_overlay_opacity<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_overlay_opacity' . $i] ); ?>" min="0" max="1" step="0.1">
				<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
				<p><label><input name="dp_options[display_slider_button<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['display_slider_button' . $i] ); ?>><?php _e( 'Display button', 'tcd-w' ); ?></label></p>
				<h4 class="theme_option_headline2"><?php _e( 'Button color setting', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label for="dp_options[slider_button_label<?php echo $i; ?>]"><?php _e( 'Button label', 'tcd-w' ); ?></label></td>
						<td><input type="text" id="dp_options[slider_button_label<?php echo $i; ?>]" name="dp_options[slider_button_label<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['slider_button_label' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_font_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_font_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_font_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_bg_color<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_bg_color' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_bg_color' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_font_color_hover<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_font_color_hover' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_font_color_hover' . $i] ); ?>"></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[slider_button_bg_color_hover<?php echo $i; ?>]" type="text" value="<?php echo esc_attr( $dp_options['slider_button_bg_color_hover' . $i] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['slider_button_bg_color_hover' . $i] ); ?>"></td>
					</tr>
				</table>
				<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[slider_url<?php echo esc_attr( $i ); ?>]" value="<?php echo esc_attr( $dp_options['slider_url' . $i] ); ?>">
				<p><label><input name="dp_options[slider_target<?php echo esc_attr( $i ); ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['slider_target' . $i] ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?></label></p>
				<h4 class="theme_option_headline2"><?php _e( 'Advertisement label', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[slider_native_ad_label<?php echo esc_attr( $i ); ?>]" value="<?php echo esc_attr( $dp_options['slider_native_ad_label' . $i] ); ?>">
				<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
		<?php endfor; ?>
	</div><!-- END #header_content_image_slider -->
	<div id="header_content_slider_time" style="<?php if ( in_array( $dp_options['header_content_type'], array( 'type1', 'type2' ) ) ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Slide speed', 'tcd-w' ); ?></h4>
		<select name="dp_options[slide_time]">
			<?php foreach ( $slide_time_options as $option ) : ?>
			<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['slide_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' seconds', 'tcd-w' ); ?></option>
			<?php endforeach; ?>
		</select>
	</div><!-- END #header_content_slider_time -->
	<div id="header_content_video" style="<?php if ( $dp_options['header_content_type'] == 'type3' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<div class="sub_box cf">
			<h3 class="theme_option_subbox_headline"><?php _e( 'Video setting', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
				<p><?php _e( 'Please upload MP4 format file.', 'tcd-w' ); ?></p>
				<p><?php _e( 'Register within 10 MB.', 'tcd-w' ); ?><br>
				<?php _e( 'The screen ratio for video is assumed to be 16:9.', 'tcd-w' ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_video_field hide-if-no-js slider_video">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['video'] ); ?>" name="dp_options[video]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['video'] && wp_get_attachment_url( $dp_options['video'] ) ) { echo '<p class="media_url">' . wp_get_attachment_url( $dp_options['video'] ) . '</p>'; } ?></div>
						<div class="buttton_area">
							<input type="button" value="<?php _e( 'Select Video', 'tcd-w' ); ?>" class="cfvf-select-video button">
							<input type="button" value="<?php _e( 'Remove Video', 'tcd-w' ); ?>" class="cfvf-delete-video button <?php if ( ! $dp_options['video'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sub_box cf">
			<h3 class="theme_option_subbox_headline"><?php _e( 'Substitute image', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
				<p><?php _e( 'If the mobile device can\'t play video this image will be displayed instead.', 'tcd-w' ); ?></p>
				<p><?php _e( 'Recommend image size. Width:1450px or more, Height:780px or more', 'tcd-w' ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js video_image">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['video_image'] ); ?>" name="dp_options[video_image]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['video_image'] ) { echo wp_get_attachment_image( $dp_options['video_image'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['video_image'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
					<p><?php _e( 'If you would like to display an alternate image without showing the video on a smartphone, check the "Show alternate image on smartphones" checkbox below.', 'tcd-w' ); ?></p>
					<p><label><input name="dp_options[video_image_hide]" type="checkbox" value="1" <?php checked( 1, $dp_options['video_image_hide'] ); ?> /> <?php _e( 'Display alternate images on smartphones', 'tcd-w' ); ?></label></p>
				</div>
				<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END #header_content_video -->
	<div id="header_content_youtube" style="<?php if ( $dp_options['header_content_type'] == 'type4' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<div class="sub_box cf">
			<h3 class="theme_option_subbox_headline"><?php _e( 'Youtube setting', 'tcd-w' ); ?></h3>
				<div class="sub_box_content">
				<p><?php _e( 'Please enter Youtube URL.', 'tcd-w' ); ?></p>
				<input class="regular-text" type="text" name="dp_options[youtube_url]" value="<?php echo esc_attr( $dp_options['youtube_url'] ); ?>">
				<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
		<div class="sub_box cf">
			<h3 class="theme_option_subbox_headline"><?php _e( 'Substitute image', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
				<p><?php _e( 'This image will be displayed instead of Youtube video in smartphone.', 'tcd-w' ); ?></p>
				<p><?php _e( 'Recommend image size. Width:1450px or more, Height:780px or more', 'tcd-w' ); ?></p>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js youtube_image">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['youtube_image'] ); ?>" name="dp_options[youtube_image]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['youtube_image'] ) { echo wp_get_attachment_image( $dp_options['youtube_image'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['youtube_image'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
					<p><?php _e( 'If you would like to display an alternate image without showing the video on a smartphone, check the "Show alternate image on smartphones" checkbox below.', 'tcd-w' ); ?></p>
					<p><label><input name="dp_options[youtube_image_hide]" type="checkbox" value="1" <?php checked( 1, $dp_options['youtube_image_hide'] ); ?> /> <?php _e( 'Display alternate images on smartphones', 'tcd-w' ); ?></label></p>
				</div>
				<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END #header_content_youtube -->

	<?php // 動画用キャッチフレーズ ?>
	<div id="header_content_video_catch" style="<?php if ( in_array( $dp_options['header_content_type'], array( 'type3', 'type4' ) ) ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
		<div class="sub_box cf">
			<h3 class="theme_option_subbox_headline"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
				<p><?php _e( 'Catchphrase will be displayed on video.', 'tcd-w' ); ?></p>
				<p><label><input name="dp_options[use_video_catch]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_video_catch'] ); ?> /> <?php _e( 'Display catchphrase.', 'tcd-w' ); ?></label></p>
				<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="2" name="dp_options[video_catch]"><?php echo esc_textarea( $dp_options['video_catch'] ); ?></textarea>
				<h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
				<p><input type="number" class="small-text" name="dp_options[video_catch_font_size]" value="<?php echo esc_attr( $dp_options['video_catch_font_size'] ); ?>" min="0" /><span>px</span></p>
				<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
				<textarea class="large-text" cols="50" rows="2" name="dp_options[video_desc]"><?php echo esc_textarea( $dp_options['video_desc'] ); ?></textarea>
				<h4 class="theme_option_headline2"><?php _e( 'Font size of description', 'tcd-w' ); ?></h4>
				<p><input type="number" class="small-text" name="dp_options[video_desc_font_size]" value="<?php echo esc_attr( $dp_options['video_desc_font_size'] ); ?>" min="0" /><span>px</span></p>
				<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
				<input class="c-color-picker" name="dp_options[video_catch_color]" type="text" value="<?php echo esc_attr( $dp_options['video_catch_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['video_catch_color'] ); ?>">
				<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
				<table>
					<tr>
						<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[video_catch_shadow1]" value="<?php echo esc_attr( $dp_options['video_catch_shadow1'] ); ?>" min="0" /><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[video_catch_shadow2]" value="<?php echo esc_attr( $dp_options['video_catch_shadow2'] ); ?>" min="0" /><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
						<td><input type="number" class="small-text" name="dp_options[video_catch_shadow3]" value="<?php echo esc_attr( $dp_options['video_catch_shadow3'] ); ?>" min="0" /><span>px</span></td>
					</tr>
					<tr>
						<td><label><?php _e( 'Dropshadow color', 'tcd-w' ); ?></label></td>
						<td><input class="c-color-picker" name="dp_options[video_catch_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['video_catch_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['video_catch_shadow_color'] ); ?>"></td>
					</tr>
				</table>
				<?php // ボタン ?>
				<h4 class="theme_option_headline2"><?php _e( 'Button setting', 'tcd-w' ); ?></h4>
				<p class="show_video_catch_button"><label><input name="dp_options[show_video_catch_button]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_video_catch_button'] ); ?> /> <?php _e( 'Display button.', 'tcd-w' ); ?></label></p>
				<div class="video_catch_button_setting" style="<?php if ( $dp_options['show_video_catch_button'] == 1 ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
					<h4 class="theme_option_headline2"><?php _e( 'Label of button', 'tcd-w' ); ?></h4>
					<input class="regular-text" type="text" name="dp_options[video_catch_button]" value="<?php echo esc_attr( $dp_options['video_catch_button'] ); ?>" />
					<h4 class="theme_option_headline2"><?php _e( 'Button color setting', 'tcd-w' ); ?></h4>
					<table>
						<tr>
							<td><label><?php _e( 'Font color', 'tcd-w' ); ?></label></td>
							<td><input class="c-color-picker" name="dp_options[video_button_font_color]" type="text" value="<?php echo esc_attr( $dp_options['video_button_font_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['video_button_font_color'] ); ?>"></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Background color', 'tcd-w' ); ?></label></td>
							<td><input class="c-color-picker" name="dp_options[video_button_bg_color]" type="text" value="<?php echo esc_attr( $dp_options['video_button_bg_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['video_button_bg_color'] ); ?>"></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Font hover color', 'tcd-w' ); ?></label></td>
							<td><input class="c-color-picker" name="dp_options[video_button_font_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['video_button_font_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['video_button_font_color_hover'] ); ?>"></td>
						</tr>
						<tr>
							<td><label><?php _e( 'Background hover color', 'tcd-w' ); ?></label></td>
							<td><input class="c-color-picker" name="dp_options[video_button_bg_color_hover]" type="text" value="<?php echo esc_attr( $dp_options['video_button_bg_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['video_button_bg_color_hover'] ); ?>"></td>
						</tr>
					</table>
					<?php // リンク ?>
					<h4 class="theme_option_headline2"><?php _e( 'Button link URL', 'tcd-w' ); ?></h4>
					<input class="regular-text" type="text" name="dp_options[video_button_url]" value="<?php echo esc_attr( $dp_options['video_button_url'] ); ?>" />
					<p><label><input name="dp_options[video_button_target]" type="checkbox" value="1" <?php checked( 1, $dp_options['video_button_target'] ); ?> /> <?php _e( 'Open link in new window', 'tcd-w' ); ?></label></p>
				</div>
				<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
			</div><!-- END .sub_box_content -->
		</div><!-- END .sub_box -->
	</div><!-- END #header_content_video_catch -->
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダーコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Wysiwyg editor', 'tcd-w' ); ?></h3>
<?php
	wp_editor(
		$dp_options['index_editor'],
		'index_editor',
		array(
			'textarea_name' => 'dp_options[index_editor]',
			'textarea_rows' => 10
		)
	);
?>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ヘッダーコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Tab content setting', 'tcd-w' ); ?></h3>
<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php printf( __( 'Tab%d setting', 'tcd-w' ), $i ); ?></h3>
		<div class="sub_box_content">
			<p><label><input name="dp_options[show_index_tab<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_tab' . $i] ); ?> /> <?php printf( __( 'Show tab%d', 'tcd-w' ), $i ); ?></label></p>
			<h4 class="theme_option_headline2"><?php _e( 'Tab label', 'tcd-w' ); ?></h4>
			<input class="regular-text" type="text" name="dp_options[index_tab_label<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['index_tab_label' . $i] ); ?>" />
			<p class="description"><?php _e( 'When it is blank Category name etc. are displayed.', 'tcd-w' ); ?></p>

			<h4 class="theme_option_headline2"><?php _e( 'Wysiwyg editor', 'tcd-w' ); ?></h4>
			<p><label><input class="js-index_tab_editor" name="dp_options[show_index_tab_editor<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_tab_editor' . $i] ); ?> /> <?php _e( 'Display free space', 'tcd-w' ); ?></label></p>
<?php
	wp_editor(
		$dp_options['index_tab_editor' . $i],
		'index_tab_editor' . $i,
		array(
			'textarea_name' => 'dp_options[index_tab_editor' . $i . ']',
			'textarea_rows' => 8
		)
	);
?>
			<h4 class="theme_option_headline2"><?php _e( 'Type of posts', 'tcd-w' ); ?></h4>
			<fieldset class="cf select_type2">
				<?php foreach ( $list_type_options as $option ) : ?>
				<label><input type="radio" name="dp_options[index_tab_list_type<?php echo $i; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['index_tab_list_type' . $i], $option['value'] ); ?>><?php echo $option['label']; ?><?php
					if ( 'type1' == $option['value'] ) :
						echo '&nbsp;&nbsp;';
						wp_dropdown_categories(array(
							'class' => '',
							'echo' => 1,
							'hide_empty' => 0,
							'hierarchical' => 1,
							'id' => '',
							'name' => 'dp_options[index_tab_category' . $i . ']',
							'selected' => $dp_options['index_tab_category' . $i],
							'show_count' => 0,
							//'show_option_all' => __( 'All categories', 'tcd-w' ),
							'value_field' => 'term_id'
						) );
					endif;
					if ( 'type5' == $option['value'] ) :
						echo '&nbsp;'.__('(with pager)', 'tcd-w');
					endif;
				?></label>
				<?php endforeach; ?>
			</fieldset>
			<h4 class="theme_option_headline2"><?php _e( 'Number of posts', 'tcd-w' ); ?></h4>
			<input type="number" class="small-text" name="dp_options[index_tab_post_num<?php echo $i; ?>]" value="<?php echo esc_attr( $dp_options['index_tab_post_num' . $i] ); ?>" min="1" />
			<h4 class="theme_option_headline2"><?php _e( 'Post order', 'tcd-w' ); ?></h4>
			<select name="dp_options[index_tab_post_order<?php echo $i; ?>]">
				<?php foreach ( $post_order_options as $option ) : ?>
				<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['index_tab_post_order' . $i] ); ?>><?php echo $option['label']; ?></option>
				<?php endforeach; ?>
			</select>
			<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
			<p><label><input name="dp_options[show_index_tab_large<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_index_tab_large' . $i] ); ?> /> <?php _e( 'Display the top two articles larger', 'tcd-w' ); ?></label></p>
			<p><label><input name="dp_options[use_index_tab_sticky<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $dp_options['use_index_tab_sticky' . $i] ); ?> /> <?php _e( 'Enable sticky posts', 'tcd-w' ); ?></label></p>



			<h4 class="theme_option_headline2"><?php _e('Native advertisement setting', 'tcd-w'); ?></h4>
			<p><label><input name="dp_options[show_index_tab_native_ad<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( $dp_options['show_index_tab_native_ad' . $i], 1 ); ?>><?php _e( 'Display native advertisement', 'tcd-w' ); ?></label></p>
			<h4 class="theme_option_headline2"><?php _e( 'Position of native advertisement', 'tcd-w' ); ?></h4>
			<div class="theme_option_message">
				<p><?php _e( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ); ?></p>
			</div>
			<input class="small-text" name="dp_options[index_tab_native_ad_position<?php echo $i; ?>]" type="number" value="<?php echo esc_attr( $dp_options['index_tab_native_ad_position' . $i] ); ?>" min="1">
			<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
<?php endfor; ?>
</div>
