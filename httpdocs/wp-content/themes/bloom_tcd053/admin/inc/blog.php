<?php
global $dp_options, $dp_default_options, $title_align_options, $page_link_options, $pickup_post_num_options, $related_post_num_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<?php // ブログの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Blog setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Breadcrumb label', 'tcd-w' ); ?></h4>
	<input class="regular-text" name="dp_options[blog_breadcrumb_label]" type="text" value="<?php echo esc_attr( $dp_options['blog_breadcrumb_label'] ); ?>">
	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // アーカイブページヘッダーの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Setting for archive page header', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Header image', 'tcd-w' ); ?></h4>
	<p><?php printf( __( '<a href="%s" target="_blank">In category editing screen</a>category Arcave header setting can be set for each category.
This setting is used in common when "Category archive header setting" is not set, and other archive pages (monthly, tag, author, search result).', 'tcd-w' ), admin_url( 'edit-tags.php?taxonomy=category' ) ); ?></p>
	<p><?php _e( 'Recommend image size. Width:1450px, Height:150px', 'tcd-w' ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js archive_image">
			<input type="hidden" value="<?php echo esc_attr( $dp_options['archive_image'] ); ?>" name="dp_options[archive_image]" class="cf_media_id">
			<div class="preview_field"><?php if ( $dp_options['archive_image'] ) { echo wp_get_attachment_image( $dp_options['archive_image'], 'medium' ); } ?></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['archive_image'] ) { echo 'hidden'; } ?>">
			</div>
		</div>
	</div>
	<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
	<input class="c-color-picker" name="dp_options[archive_overlay]" type="text" value="<?php echo esc_attr( $dp_options['archive_overlay'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['archive_overlay'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
	<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.2)', 'tcd-w' ); ?></p>
	<input type="number" class="small-text" name="dp_options[archive_overlay_opacity]" value="<?php echo esc_attr( $dp_options['archive_overlay_opacity'] ); ?>" min="0" max="1" step="0.1">
	<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
	<input class="regular-text" type="text" name="dp_options[archive_catchphrase]" value="<?php echo esc_attr( $dp_options['archive_catchphrase'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
	<p><input type="number" class="small-text" name="dp_options[archive_catchphrase_font_size]" value="<?php echo esc_attr( $dp_options['archive_catchphrase_font_size'] ); ?>" min="0"><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
	<textarea class="large-text" cols="50" rows="4" name="dp_options[archive_desc]"><?php echo esc_textarea( $dp_options['archive_desc'] ); ?></textarea>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of description', 'tcd-w' ); ?></h4>
	<p><input type="number" class="small-text" name="dp_options[archive_desc_font_size]" value="<?php echo esc_attr( $dp_options['archive_desc_font_size'] ); ?>" min="0"><span>px</span></p>
	<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
	<input class="c-color-picker" name="dp_options[archive_color]" type="text" value="<?php echo esc_attr( $dp_options['archive_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['archive_color'] ); ?>">
	<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
	<table class="theme_option_table">
		<tr>
			<td><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></td>
			<td><input type="number" class="small-text" name="dp_options[archive_shadow1]" value="<?php echo esc_attr( $dp_options['archive_shadow1'] ); ?>" min="0"><span>px</span></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></td>
			<td><input type="number" class="small-text" name="dp_options[archive_shadow2]" value="<?php echo esc_attr( $dp_options['archive_shadow2'] ); ?>" min="0"><span>px</span></td>
		</tr>
		<tr>
			<td><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></td>
			<td><input type="number" class="small-text" name="dp_options[archive_shadow3]" value="<?php echo esc_attr( $dp_options['archive_shadow3'] ); ?>" min="0"><span>px</span></td>
		</tr>
		<tr>
			<td><?php _e( 'Dropshadow color', 'tcd-w' ); ?></td>
			<td><input class="c-color-picker" name="dp_options[archive_shadow_color]" type="text" value="<?php echo esc_attr( $dp_options['archive_shadow_color'] ); ?>" data-default-color="<?php echo esc_attr( $dp_default_options['archive_shadow_color'] ); ?>"></td>
		</tr>
	</table>
	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // アーカイブページ ネイティブ広告の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Native advertisement setting for archive page', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e('Native advertisement display setting', 'tcd-w'); ?></h4>
	<p><label><input name="dp_options[show_archive_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_archive_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement for blog archive page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_category_archive_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_category_archive_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement for category archive page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_tag_archive_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_tag_archive_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement for tag archive page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_date_archive_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_date_archive_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement for date archive page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_author_archive_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_author_archive_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement for author archive page', 'tcd-w' ); ?></label></p>
	<p><label><input name="dp_options[show_search_archive_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_search_archive_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement for search results page', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Position of native advertisement', 'tcd-w' ); ?></h4>
	<div class="theme_option_message">
		<p><?php _e( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ); ?></p>
	</div>
	<input class="small-text" name="dp_options[archive_native_ad_position]" type="number" value="<?php echo esc_attr( $dp_options['archive_native_ad_position'] ); ?>" min="1">
	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 記事詳細ページの設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Single Page Settings', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of post title', 'tcd-w' ); ?></h4>
	<input type="number" class="small-text" name="dp_options[title_font_size]" value="<?php echo esc_attr( $dp_options['title_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Title align', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2">
		<?php foreach ( $title_align_options as $option ) : ?>
		<label><input type="radio" name="dp_options[title_align]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['title_align'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<h4 class="theme_option_headline2"><?php _e( 'Font size of post contents', 'tcd-w' ); ?></h4>
	<input type="number" class="small-text" name="dp_options[content_font_size]" value="<?php echo esc_attr( $dp_options['content_font_size'] ); ?>" min="0"><span>px</span>
	<h4 class="theme_option_headline2"><?php _e( 'Pages link setting', 'tcd-w' ); ?></h4>
	<fieldset class="cf select_type2">
		<?php foreach ( $page_link_options as $option ) : ?>
		<label><input type="radio" name="dp_options[page_link]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $dp_options['page_link'] ); ?>><?php echo $option['label']; ?></label>
		<?php endforeach; ?>
	</fieldset>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 表示設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Display setting', 'tcd-w' ); ?></h3>
	<h4 class="theme_option_headline2"><?php _e('Common settings', 'tcd-w'); ?></h4>
	<ul>
		<li><label><input name="dp_options[show_date]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_date'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></li>
	</ul>
	<ul>
		<li><label><input name="dp_options[show_category]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_category'] ); ?>><?php _e( 'Display category (Categories are always visible on post detail pages.)', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e('Settings for single page', 'tcd-w'); ?></h4>
	<ul>
		<li><label><input name="dp_options[show_thumbnail]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_thumbnail'] ); ?>><?php _e( 'Display thumbnail', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_author]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_author'] ); ?>><?php _e( 'Display author\'s information', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_author_views]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_author_views'] ); ?>><?php _e( 'Display author views', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sns_top]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_sns_top'] ); ?>><?php _e( 'Buttons to the article top', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_sns_btm]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_sns_btm'] ); ?>><?php _e( 'Buttons to the article bottom', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_next_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_next_post'] ); ?>><?php _e( 'Display next previous post link', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_comment]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_comment'] ); ?>><?php _e( 'Display comment', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_trackback]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_trackback'] ); ?>><?php _e( 'Display trackbacks', 'tcd-w' ); ?></label></li>
	</ul>
	<h4 class="theme_option_headline2"><?php _e('Settings for archive page', 'tcd-w'); ?></h4>
	<ul>
		<li><label><input name="dp_options[show_views]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_views'] ); ?>><?php _e( 'Display views', 'tcd-w' ); ?></label></li>
		<li><label><input name="dp_options[show_archive_author]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_archive_author'] ); ?>><?php _e( 'Display author', 'tcd-w' ); ?></label></li>
	</ul>
	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // ピックアップ記事の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e('Pickup posts setting', 'tcd-w'); ?></h3>
	<p><?php _e('Pickup posts will be displayed at the bottom of post page.','tcd-w'); ?></p>
	<p><label><input name="dp_options[show_pickup_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_pickup_post'] ); ?> /> <?php _e('Display pickup post', 'tcd-w'); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e('Headline of pickup posts', 'tcd-w'); ?></h4>
	<input class="regular-text" type="text" name="dp_options[pickup_post_headline]" value="<?php echo esc_attr( $dp_options['pickup_post_headline'] ); ?>" />
	<h4 class="theme_option_headline2"><?php _e('Number of pickup posts', 'tcd-w'); ?></h4>
	<select name="dp_options[pickup_post_num]">
<?php
	foreach ( $pickup_post_num_options as $option ) :
		if ( $dp_options['pickup_post_num'] == $option['value'] ) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
		echo '<option value="' . esc_attr( $option['value'] ) . '" ' . $selected . '>' . $option['label'] . '</option>' ."\n";
	endforeach;
?>
	</select>
	<h4 class="theme_option_headline2"><?php _e('Native advertisement setting', 'tcd-w'); ?></h4>
	<p><label><input name="dp_options[show_pickup_post_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_pickup_post_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Position of native advertisement', 'tcd-w' ); ?></h4>
	<div class="theme_option_message">
		<p><?php _e( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ); ?></p>
	</div>
	<input class="small-text" name="dp_options[pickup_post_native_ad_position]" type="number" value="<?php echo esc_attr( $dp_options['pickup_post_native_ad_position'] ); ?>" min="1">
	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 関連記事の設定 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e('Related posts setting', 'tcd-w'); ?></h3>
	<p><?php _e('Related posts will be displayed at the bottom of Pickup posts.','tcd-w'); ?></p>
	<p><label><input name="dp_options[show_related_post]" type="checkbox" value="1" <?php checked( 1, $dp_options['show_related_post'] ); ?> /> <?php _e('Display related post', 'tcd-w'); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e('Headline of related posts', 'tcd-w'); ?></h4>
	<input class="regular-text" type="text" name="dp_options[related_post_headline]" value="<?php echo esc_attr( $dp_options['related_post_headline'] ); ?>" />
	<h4 class="theme_option_headline2"><?php _e('Number of related posts', 'tcd-w'); ?></h4>
	<select name="dp_options[related_post_num]">
<?php
	foreach ( $related_post_num_options as $option ) :
		if ( $dp_options['related_post_num'] == $option['value'] ) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
		echo '<option value="' . esc_attr( $option['value'] ) . '" ' . $selected . '>' . $option['label'] . '</option>' ."\n";
	endforeach;
?>
	</select>
	<h4 class="theme_option_headline2"><?php _e('Native advertisement setting', 'tcd-w'); ?></h4>
	<p><label><input name="dp_options[show_related_post_native_ad]" type="checkbox" value="1" <?php checked( $dp_options['show_related_post_native_ad'], 1 ); ?>><?php _e( 'Display native advertisement', 'tcd-w' ); ?></label></p>
	<h4 class="theme_option_headline2"><?php _e( 'Position of native advertisement', 'tcd-w' ); ?></h4>
	<div class="theme_option_message">
		<p><?php _e( 'Registered native advertisements 1 to 6 will be displayed at random each time after the number of articles set in here.', 'tcd-w' ); ?></p>
	</div>
	<input class="small-text" name="dp_options[related_post_native_ad_position]" type="number" value="<?php echo esc_attr( $dp_options['related_post_native_ad_position'] ); ?>" min="1">
	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
</div>
<?php // 広告の登録1 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>1</h3>
	<p><?php _e( 'This banner will be displayed under contents.', 'tcd-w' ); ?></p>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code1]"><?php echo esc_textarea( $dp_options['single_ad_code1'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image1">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image1'] ); ?>" name="dp_options[single_ad_image1]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image1'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image1'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url1]" value="<?php echo esc_attr( $dp_options['single_ad_url1'] ); ?>">
				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code2]"><?php echo esc_textarea( $dp_options['single_ad_code2'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image2">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image2'] ); ?>" name="dp_options[single_ad_image2]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image2'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image2'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image2'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url2]" value="<?php echo esc_attr( $dp_options['single_ad_url2'] ); ?>">
				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
</div><!-- END .theme_option_field -->
<?php // 記事詳細の広告設定2 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>2</h3>
	<p><?php _e( 'Please copy and paste the short code inside the content to show this banner.', 'tcd-w' ); ?></p>
	<p><?php _e( 'Short code', 'tcd-w' ); ?> : <input type="text" readonly="readonly" value="[s_ad]"></p>
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code3]"><?php echo esc_textarea( $dp_options['single_ad_code3'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image3">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image3'] ); ?>" name="dp_options[single_ad_image3]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image3'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image3'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image3'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url3]" value="<?php echo esc_attr( $dp_options['single_ad_url3'] ); ?>">
				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
	<div class="sub_box cf">
		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
		<div class="sub_box_content">
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
				<textarea class="large-text" cols="50" rows="10" name="dp_options[single_ad_code4]"><?php echo esc_textarea( $dp_options['single_ad_code4'] ); ?></textarea>
			</div>
			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
				<div class="image_box cf">
					<div class="cf cf_media_field hide-if-no-js single_ad_image4">
						<input type="hidden" value="<?php echo esc_attr( $dp_options['single_ad_image4'] ); ?>" name="dp_options[single_ad_image4]" class="cf_media_id">
						<div class="preview_field"><?php if ( $dp_options['single_ad_image4'] ) { echo wp_get_attachment_image( $dp_options['single_ad_image4'], 'medium' ); } ?></div>
						<div class="button_area">
							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_ad_image4'] ) { echo 'hidden'; } ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="theme_option_content">
				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
				<input class="regular-text" type="text" name="dp_options[single_ad_url4]" value="<?php echo esc_attr( $dp_options['single_ad_url4'] ); ?>">
				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
			</div>
		</div>
	</div><!-- END .sub_box -->
</div><!-- END .theme_option_field -->
<?php // スマホ専用広告の登録 ?>
<div class="theme_option_field cf">
	<h3 class="theme_option_headline"><?php _e( 'Mobile device banner setup', 'tcd-w' ); ?></h3>
	<p><?php _e( 'This banner will be displayed on mobile device.', 'tcd-w' ); ?></p>
	<div class="theme_option_content">
		<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
		<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
		<textarea class="large-text" cols="50" rows="10" name="dp_options[single_mobile_ad_code1]"><?php echo esc_textarea( $dp_options['single_mobile_ad_code1'] ); ?></textarea>
	</div>
	<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' );?></p>
	<div class="theme_option_content">
		<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js single_mobile_ad_image1">
				<input type="hidden" value="<?php echo esc_attr( $dp_options['single_mobile_ad_image1'] ); ?>" name="dp_options[single_mobile_ad_image1]" class="cf_media_id">
				<div class="preview_field"><?php if ( $dp_options['single_mobile_ad_image1'] ) { echo wp_get_attachment_image( $dp_options['single_mobile_ad_image1'], 'medium' ); } ?></div>
				<div class="buttton_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $dp_options['single_mobile_ad_image1'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="theme_option_content">
		<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
		<input class="regular-text" type="text" name="dp_options[single_mobile_ad_url1]" value="<?php echo esc_attr( $dp_options['single_mobile_ad_url1'] ); ?>">
		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
</div>
