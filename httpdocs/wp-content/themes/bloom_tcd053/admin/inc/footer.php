<?php
global $dp_options, $dp_default_options, $list_type_options, $post_order_options, $footer_blog_num_options, $slide_time_options, $footer_cta_type_options, $footer_bar_display_options, $footer_bar_button_options, $footer_bar_icon_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ブログコンテンツの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Blog contents settings', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Display a carousel slider of blog posts in the footer area.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_footer_blog_top]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_top'], 1 ); ?>><?php _e( 'Show blog contents on top page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_footer_blog]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog'], 1 ); ?>><?php _e( 'Show blog contents on subpage', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[footer_blog_catchphrase]" value="<?php echo esc_attr( $dp_options['footer_blog_catchphrase'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
	<p><input type="number" class="small-text" name="dp_options[footer_blog_catchphrase_font_size]" value="<?php echo esc_attr( $dp_options['footer_blog_catchphrase_font_size'] ); ?>" min="0"><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e( 'Type of posts', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2">
		<?php foreach ( $list_type_options as $option ) : ?>
		<label><input type="radio" name="dp_options[footer_blog_list_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['footer_blog_list_type'], $option['value'] ); ?>><?php echo $option['label']; ?><?php
			if ( 'type1' == $option['value'] ) :
				echo '&nbsp;&nbsp;';
				wp_dropdown_categories( array(
					'class' => '',
					'echo' => 1,
					'hide_empty' => 0,
					'hierarchical' => 1,
					'id' => '',
					'name' => 'dp_options[footer_blog_category]',
					'selected' => $dp_options['footer_blog_category'],
					'show_count' => 0,
					'show_option_all' => __( 'All categories', 'tcd-w' ),
					'value_field' => 'term_id'
				) );
			endif;
		?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Number of posts', 'tcd-w' ); ?></h4>
	<select name="dp_options[footer_blog_num]">
		<?php foreach ( $footer_blog_num_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['footer_blog_num'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
		<?php endforeach; ?>
	</select>
	<h4 class="theme_option_headline2"><?php _e( 'Post order', 'tcd-w' ); ?></h4>
	<select name="dp_options[footer_blog_post_order]">
		<?php foreach ( $post_order_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['footer_blog_post_order'] ); ?>><?php echo $option['label']; ?></option>
		<?php endforeach; ?>
	</select>
	<h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
	<p><label><input name="dp_options[show_footer_blog_date]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_date'], 1 ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_footer_blog_category]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_footer_blog_views]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_views'], 1 ); ?>><?php _e( 'Display views', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_footer_blog_author]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_author'], 1 ); ?>><?php _e( 'Display author', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e('Native advertisement setting', 'tcd-w'); ?></h4>
	<p><label><input name="dp_options[show_footer_blog_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_blog_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Position of native advertisement', 'tcd-w' ); ?></h4>
	<div class="theme_option_message">
		<p><?php _e( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ); ?></p>
	</div>
	<input class="small-text" name="dp_options[footer_blog_native_ad_position]" type="number" value="<?php echo esc_attr( $dp_options['footer_blog_native_ad_position'] ); ?>" min="1">
	<h4 class="theme_option_headline2"><?php _e( 'Slide speed', 'tcd-w' ); ?></h4>
	<select name="dp_options[footer_blog_slide_time]">
		<?php foreach ( $slide_time_options as $option ) : ?>
		<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $dp_options['footer_blog_slide_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' seconds', 'tcd-w' ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フッターCTAの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Footer free contents setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'You can set up footer free contents which is displayed at the bottom of the footer on scroll.', 'tcd-w' ); ?></p>
	<p><label><input name="dp_options[show_footer_cta_top]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_cta_top'], 1 ); ?>><?php _e( 'Show footer free contents on top page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_footer_cta]" type="checkbox" value="1" <?php checked( $dp_options['show_footer_cta'], 1 ); ?>><?php _e( 'Show footer free contents on subpage', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Contents type', 'tcd-w' ); ?></h4>
	<?php foreach( $footer_cta_type_options as $option ) : ?>
	<p><label><input type="radio" class="footer-cta-type" name="dp_options[footer_cta_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['footer_cta_type'] ); ?>> <?php echo $option['label']; ?></label></p>
	<?php endforeach; ?>
	<div class="footer-cta-type1-content footer-cta-content <?php if ( 'type1' !== $dp_options['footer_cta_type'] ) { echo 'hidden'; } ?>">
		<h5 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h5>
		<textarea name="dp_options[footer_cta_catch]" class="large-text"><?php echo esc_textarea( $dp_options['footer_cta_catch'] ); ?></textarea>
		<p><label><?php _e( 'Font size', 'tcd-w' ); ?> <input type="number" class="small-text" name="dp_options[footer_cta_catch_font_size]" value="<?php echo esc_attr( $dp_options['footer_cta_catch_font_size'] ); ?>" min="0"> px</label></p>
		<h5 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h5>
		<textarea name="dp_options[footer_cta_desc]" class="large-text"><?php echo esc_textarea( $dp_options['footer_cta_desc'] ); ?></textarea>
		<p><label><?php _e( 'Font size', 'tcd-w' ); ?> <input type="number" class="small-text" name="dp_options[footer_cta_desc_font_size]" value="<?php echo esc_attr( $dp_options['footer_cta_desc_font_size'] ); ?>" min="0"> px</label></p>
		<h5 class="theme_option_headline2"><?php _e( 'Button settings', 'tcd-w' ); ?></h5>
		<p><label><?php _e( 'Button label', 'tcd-w' ); ?> <input type="text" name="dp_options[footer_cta_btn_label]" value="<?php echo esc_attr( $dp_options['footer_cta_btn_label'] ); ?>" class="regular-text"></label></p>
		<p><label><?php _e( 'Link URL', 'tcd-w' ); ?> <input type="text" name="dp_options[footer_cta_btn_url]" value="<?php echo esc_attr( $dp_options['footer_cta_btn_url'] ); ?>" class="regular-text"></label></p>
		<p><label><input type="checkbox" name="dp_options[footer_cta_btn_target]" value="1" <?php checked( 1, $dp_options['footer_cta_btn_target'] ); ?>> <?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
		<table class="theme_option_table">
			<tr>
				<td><?php _e( 'Font color', 'tcd-w' ); ?></td>
				<td><input type="text" class="c-color-picker" name="dp_options[footer_cta_btn_color]" value="<?php echo esc_attr( $dp_options['footer_cta_btn_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_cta_btn_color'] ); ?>"></td>
			</tr>
			<tr>
				<td><?php _e( 'Background color', 'tcd-w' ); ?></td>
				<td><input type="text" class="c-color-picker" name="dp_options[footer_cta_btn_bg]" value="<?php echo esc_attr( $dp_options['footer_cta_btn_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_cta_btn_bg'] ); ?>"></td>
			</tr>
			<tr>
				<td><?php _e( 'Font color on hover', 'tcd-w' ); ?></td>
				<td><input type="text" class="c-color-picker" name="dp_options[footer_cta_btn_color_hover]" value="<?php echo esc_attr( $dp_options['footer_cta_btn_color_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_cta_btn_color_hover'] ); ?>"></td>
			</tr>
			<tr>
				<td><?php _e( 'Background color on hover', 'tcd-w' ); ?></td>
				<td><input type="text" class="c-color-picker" name="dp_options[footer_cta_btn_bg_hover]" value="<?php echo esc_attr( $dp_options['footer_cta_btn_bg_hover'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_cta_btn_bg_hover'] ); ?>"></td>
			</tr>
		</table>
	</div>
	<div class="footer-cta-type2-content footer-cta-content <?php if ( 'type2' !== $dp_options['footer_cta_type'] ) { echo 'hidden'; } ?>">
		<h5 class="theme_option_headline2"><?php _e( 'Wysiwyg editor', 'tcd-w' ); ?></h5>
<?php
	wp_editor(
		$dp_options['footer_cta_editor'],
		'footer_cta_editor',
		array(
			'textarea_name' => 'dp_options[footer_cta_editor]',
			'textarea_rows' => 10
		)
	);
?>
	</div>
	<h5 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h5>
	<p><?php _e( 'Recommend image size. Width:1450px, Height:450px', 'tcd-w' ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js footer_cta_image">
			<input type="hidden" value="<?php echo esc_attr( $dp_options['footer_cta_image'] ); ?>" name="dp_options[footer_cta_image]" class="cf_media_id">
			<div class="preview_field"><?php if ( $dp_options['footer_cta_image'] ) { echo wp_get_attachment_image( $dp_options['footer_cta_image'], 'full' ); } ?></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['footer_cta_image'] ) { echo 'hidden'; } ?>">
			</div>
		</div>
	</div>
	<h5 class="theme_option_headline2"><?php _e( 'Image for mobile', 'tcd-w' ); ?></h5>
	<p><?php _e( 'Recommend image size. Width:360px, Height:320px', 'tcd-w' ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js footer_cta_image_sp">
			<input type="hidden" value="<?php echo esc_attr( $dp_options['footer_cta_image_sp'] ); ?>" name="dp_options[footer_cta_image_sp]" class="cf_media_id">
			<div class="preview_field"><?php if ( $dp_options['footer_cta_image_sp'] ) { echo wp_get_attachment_image( $dp_options['footer_cta_image_sp'], 'full' ); } ?></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['footer_cta_image_sp'] ) { echo 'hidden'; } ?>">
			</div>
		</div>
	</div>
	<h5 class="theme_option_headline2"><?php _e( 'Image settings', 'tcd-w' ); ?></h5>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Color of overlay', 'tcd-w' ); ?></td>
			<td><input type="text" class="c-color-picker" name="dp_options[footer_cta_overlay]" value="<?php echo esc_attr( $dp_options['footer_cta_overlay'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_cta_overlay'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></td>
			<td><input type="number" name="dp_options[footer_cta_overlay_opacity]" max="1" min="0" step="0.1" value="<?php echo esc_attr( $dp_options['footer_cta_overlay_opacity'] ); ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></td>
		</tr>
	</table>

	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // SNSボタンの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'SNS button setting', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Enter url of your SNS page. If it is blank SNS button will not be shown.', 'tcd-w' ); ?></p>
	<ul class="footer_sns">
		<li><label><?php _e( 'Your Instagram URL', 'tcd-w' ); ?></label> <input class="regular-text" type="text" name="dp_options[footer_instagram_url]" value="<?php echo esc_attr( $dp_options['footer_instagram_url'] ); ?>"></li>
		<li><label><?php _e( 'Your X URL', 'tcd-w' ); ?></label> <input class="regular-text" type="text" name="dp_options[footer_twitter_url]" value="<?php echo esc_attr( $dp_options['footer_twitter_url'] ); ?>"></li>
		<li><label><?php _e( 'Your TikTok URL', 'tcd-w' ); ?></label> <input class="regular-text" type="text" name="dp_options[footer_tiktok_url]" value="<?php echo esc_attr( $dp_options['footer_tiktok_url'] ); ?>"></li>
		<li><label><?php _e( 'Your Pinterest URL', 'tcd-w' ); ?></label> <input class="regular-text" type="text" name="dp_options[footer_pinterest_url]" value="<?php echo esc_attr( $dp_options['footer_pinterest_url'] ); ?>"></li>
		<li><label><?php _e( 'Your Facebook URL', 'tcd-w' ); ?></label> <input class="regular-text" type="text" name="dp_options[footer_facebook_url]" value="<?php echo esc_attr( $dp_options['footer_facebook_url'] ); ?>"></li>
		<li><label><?php _e( 'Your Youtube URL', 'tcd-w' ); ?></label> <input class="regular-text" type="text" name="dp_options[footer_youtube_url]" value="<?php echo esc_attr( $dp_options['footer_youtube_url'] ); ?>"></li>
		<li><label><?php _e('Your contact page URL (You can use mailto:)', 'tcd-w'); ?></label> <input class="regular-text" type="text" name="dp_options[footer_contact_url]" value="<?php echo esc_attr( $dp_options['footer_contact_url'] ); ?>"></li>
	</ul>
	<hr>
	<p><label><input name="dp_options[footer_show_rss]" type="checkbox" value="1" <?php checked( 1, $dp_options['footer_show_rss'] ); ?>><?php _e( 'Display RSS button', 'tcd-w' ); ?></label></p>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // フッターバーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Setting of the footer bar for smart phone', 'tcd-w' ); ?></h3>
	<p><?php _e( 'Please set the footer bar which is displayed with smart phone.', 'tcd-w' ); ?>
	<h4 class="theme_option_headline2"><?php _e( 'Display type of the footer bar', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2">
		<?php foreach ( $footer_bar_display_options as $option ) : ?>
		<label><input type="radio" name="dp_options[footer_bar_display]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $dp_options['footer_bar_display'], $option['value'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the appearance of the footer bar', 'tcd-w' ); ?></h4>
	<table class="theme_option_table">
		<tr>
			<td><?php _e( 'Background color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_bg]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_bg'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_bg'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Border color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_border]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_border'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_border'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Font color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[footer_bar_color]" type="text" value="<?php echo esc_attr( $dp_options['footer_bar_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['footer_bar_color'] ); ?>"></td>
		</tr>
		<tr>
			<td><?php _e( 'Opacity of background', 'tcd-w' ); ?></td>
			<td><input type="number" class="small-text" name="dp_options[footer_bar_tp]" value="<?php echo esc_attr( $dp_options['footer_bar_tp'] ); ?>" min="0" max="1" step="0.1" /></td>
		</tr>
		<tr>
			<td colspan="2"><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<h4 class="theme_option_headline2"><?php _e( 'Settings for the contents of the footer bar', 'tcd-w' ); ?></h4>
	<p><?php _e( 'You can display the button with icon in footer bar. (We recommend you to set max 4 buttons.)', 'tcd-w' ); ?><br><?php _e( 'You can select button types below.', 'tcd-w' ); ?></p>
	<table class="table-border">
		<tr>
			<th><?php _e( 'Default', 'tcd-w' ); ?></th>
			<td><?php _e( 'You can set link URL.', 'tcd-w' ); ?></td>
		</tr>
		<tr>
			<th><?php _e( 'Share', 'tcd-w' ); ?></th>
			<td><?php _e( 'Share buttons are displayed if you tap this button.', 'tcd-w' ); ?></td>
		</tr>
		<tr>
			<th><?php _e( 'Telephone', 'tcd-w' ); ?></th>
			<td><?php _e( 'You can call this number.', 'tcd-w' ); ?></td>
		</tr>
	</table>
	<p><?php _e( 'Click "Add item", and set the button for footer bar. You can drag the item to change their order.', 'tcd-w' ); ?></p>
	<div class="repeater-wrapper">
		<div class="repeater sortable" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
			<?php
			if ( $dp_options['footer_bar_btns'] ) :
				foreach ( $dp_options['footer_bar_btns'] as $key => $value ) :
			?>
			<div class="sub_box repeater-item repeater-item-<?php echo esc_attr( $key ); ?>">
				<h4 class="theme_option_subbox_headline"><?php echo esc_attr( $value['label'] ); ?></h4>
				<div class="sub_box_content">
					<p class="footer-bar-target" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1" <?php checked( $value['target'], 1 ); ?>><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<table class="table-repeater">
						<tr class="footer-bar-type">
							<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
							<td>
								<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
									<?php foreach( $footer_bar_button_options as $option ) : ?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value['type'], $option['value'] ); ?>><?php echo $option['label']; ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="regular-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>"></td>
						</tr>
						<tr class="footer-bar-url" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value="<?php echo esc_attr( $value['url'] ); ?>"></td>
						</tr>
						<tr class="footer-bar-number" style="<?php if ( $value['type'] !== 'type3' ) { echo 'display: none;'; } ?>">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value="<?php echo esc_attr( $value['number'] ); ?>"></td>
						</tr>
						<tr>
							<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
							<td>
								<?php foreach( $footer_bar_icon_options as $option ) : ?>
								<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $value['icon'] ); ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php echo $option['label']; ?></label></p>
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
				</div>
			</div>
			<?php
				endforeach;
			endif;
			?>
			<?php
				$key = 'addindex';
				ob_start();
			?>
			<div class="sub_box repeater-item repeater-item-<?php echo $key; ?>">
			<h4 class="theme_option_subbox_headline"><?php _e( 'New item', 'tcd-w' ); ?></h4>
				<div class="sub_box_content">
					<p class="footer-bar-target"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1"><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<table class="table-repeater">
						<tr class="footer-bar-type">
								<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
								<td>
									<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
										<?php foreach( $footer_bar_button_options as $option ) : ?>
										<option value="<?php echo esc_attr( $option['value'] ); ?>"><?php echo $option['label']; ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
						<tr>
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="regular-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value=""></td>
						</tr>
						<tr class="footer-bar-url">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value=""></td>
						</tr>
						<tr class="footer-bar-number" style="display: none;">
							<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
							<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value=""></td>
						</tr>
						<tr>
							<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
							<td>
								<?php foreach( $footer_bar_icon_options as $option ) : ?>
								<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>"<?php if ( 'file-text' == $option['value'] ) { echo ' checked="checked"'; } ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php echo $option['label']; ?></label></p>
								<?php endforeach; ?>
							</td>
						</tr>
					</table>
					<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
				</div>
			</div>
			<?php $clone = ob_get_clean(); ?>
		</div>
		<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
	</div>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
