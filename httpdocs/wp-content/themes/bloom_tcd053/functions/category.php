<?php

// カテゴリー追加用入力欄を出力 -------------------------------------------------------
function category_add_extra_category_fields() {
?>
<div class="form-field category-color-wrap">
	<label for="category-color"><?php _e( 'Category color', 'tcd-w' ); ?></label>
	<input type="text" id="category-color" name="term_meta[color]" value="#000000" data-default-color="#000000" class="c-color-picker">
</div>
<div class="form-field category-image_megamenu-wrap">
	<label for="category-image_megamenu"><?php _e( 'Category image for Mega menu A', 'tcd-w' ); ?></label>
	<p class="description"><?php _e( 'Recommend image size. Width:260px, Height:180px', 'tcd-w' ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js">
			<input type="hidden" value="" id="category-image_megamenu" name="term_meta[image_megamenu]" class="cf_media_id">
			<div class="preview_field"></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button hidden">
			</div>
		</div>
	</div>
</div>
<h3><?php _e( 'Category archive header setting', 'tcd-w' ); ?></h3>
<div class="form-field category-image-wrap">
	<label for="category-image"><?php _e( 'Category image for archive header', 'tcd-w' ); ?></label>
	<p class="description"><?php _e( 'Recommend image size. Width:1450px, Height:150px', 'tcd-w' ); ?></p>
	<div class="image_box cf">
		<div class="cf cf_media_field hide-if-no-js">
			<input type="hidden" value="" id="category-image" name="term_meta[image]" class="cf_media_id">
			<div class="preview_field"></div>
			<div class="button_area">
				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button hidden">
			</div>
		</div>
	</div>
</div>
<div class="form-field category-overlay-wrap">
	<label for="category-overlay"><?php _e( 'Color of overlay', 'tcd-w' ); ?></label>
	<input type="text" id="category-overlay" name="term_meta[overlay]" value="#000000" data-default-color="#000000" class="c-color-picker">
</div>
<div class="form-field category-overlay_opacity-wrap">
	<label for="category-overlay_opacity"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></label>
	<input type="number" class="small-text" id="category-overlay_opacity" name="term_meta[overlay_opacity]" value="0.2" min="0" max="1" step="0.1">
</div>
<div class="form-field category-catchphrase_font_size-wrap">
	<label for="category-catchphrase_font_size"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></label>
	<input type="number" class="small-text" id="category-catchphrase_font_size" name="term_meta[catchphrase_font_size]" value="30" min="0"> px
</div>
<div class="form-field category-desc_font_size-wrap">
	<label for="category-desc_font_size"><?php _e( 'Font size of description', 'tcd-w' ); ?></label>
	<input type="number" class="small-text" id="category-desc_font_size" name="term_meta[desc_font_size]" value="14" min="0"> px
</div>
<div class="form-field category-catchphrase_color-wrap">
	<label for="category-catchphrase_color"><?php _e( 'Font color', 'tcd-w' ); ?></label>
	<input type="text" id="category-catchphrase_color" name="term_meta[catchphrase_color]" value="#FFFFFF" data-default-color="#FFFFFF" class="c-color-picker">
</div>
<div class="form-field category-shadow1-wrap">
	<label for="category-shadow1"><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label>
	<input type="number" class="small-text" id="category-shadow1" name="term_meta[shadow1]" value="0" min="0"> px
</div>
<div class="form-field category-shadow2-wrap">
	<label for="category-shadow2"><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label>
	<input type="number" class="small-text" id="category-shadow2" name="term_meta[shadow2]" value="0" min="0"> px
</div>
<div class="form-field category-shadow3-wrap">
	<label for="category-shadow3"><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label>
	<input type="number" class="small-text" id="category-shadow3" name="term_meta[shadow3]" value="0" min="0"> px
</div>
<div class="form-field category-shadow4-wrap">
	<label for="category-shadow4"><?php _e( 'Dropshadow color', 'tcd-w' ); ?></label>
	<input type="text" id="category-shadow4" name="term_meta[shadow4]" value="#999999" data-default-color="#999999" class="c-color-picker">
</div>
<?php
}
add_action( 'category_add_form_fields', 'category_add_extra_category_fields' );

// カテゴリー編集用入力欄を出力 -------------------------------------------------------
function category_edit_extra_category_fields( $term ) {
	$term_meta = get_option( 'taxonomy_' . $term->term_id, array() );
	$term_meta = array_merge( array(
		'color' => '#000000',
		'image_megamenu' => null,
		'image' => null,
		'overlay' => '#000000',
		'overlay_opacity' => 0.2,
		'catchphrase_font_size' => 30,
		'desc_font_size' => 14,
		'catchphrase_color' => '#ffffff',
		'shadow1' => 0,
		'shadow2' => 0,
		'shadow3' => 0,
		'shadow4' => '#999999'
	), $term_meta );
?>
<tr class="form-field">
	<th><label for="category_color"><?php _e( 'Category color', 'tcd-w' ); ?></label></th>
	<td><input type="text" id="category_color" name="term_meta[color]" value="<?php echo esc_attr( $term_meta['color'] ); ?>" data-default-color="#000000" class="c-color-picker"></td>
</tr>
<tr class="form-field">
	<th><label for="category-image_megamenu"><?php _e( 'Category image for Mega menu A', 'tcd-w' ); ?></label></th>
	<td>
		<p class="description"><?php _e( 'Recommend image size. Width:260px, Height:180px', 'tcd-w' ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js">
				<input type="hidden" value="<?php if ( $term_meta['image_megamenu'] ) echo esc_attr( $term_meta['image_megamenu'] ); ?>" id="category_image_megamenu" name="term_meta[image_megamenu]" class="cf_media_id">
				<div class="preview_field"><?php if ( $term_meta['image_megamenu'] ) echo wp_get_attachment_image( $term_meta['image_megamenu'], 'medium'); ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $term_meta['image_megamenu'] ) echo 'hidden'; ?>">
				</div>
			</div>
		</div>
	</td>
</tr>
<tr class="form-field">
	<th colspan="2"><h3><?php _e( 'Category archive header setting', 'tcd-w' ); ?></h3></th>
</tr>
<tr class="form-field">
	<th><label for="category-image"><?php _e( 'Category image for archive header', 'tcd-w' ); ?></label></th>
	<td>
		<p class="description"><?php _e( 'Recommend image size. Width:1450px, Height:150px', 'tcd-w' ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js">
				<input type="hidden" value="<?php if ( $term_meta['image'] ) echo esc_attr( $term_meta['image'] ); ?>" id="category_image" name="term_meta[image]" class="cf_media_id">
				<div class="preview_field"><?php if ( $term_meta['image'] ) echo wp_get_attachment_image( $term_meta['image'], 'medium'); ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $term_meta['image'] ) echo 'hidden'; ?>">
				</div>
			</div>
		</div>
	</td>
</tr>
<tr>
	<th><label for="category-color"><?php _e( 'Color of overlay', 'tcd-w' ); ?></label></th>
	<td><input type="text" id="category-overlay" name="term_meta[overlay]" value="<?php echo esc_attr( $term_meta['overlay'] ); ?>" data-default-color="#000000" class="c-color-picker"></td>
</tr>
<tr>
	<th><label for="category-overlay_opacity"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></label></th>
	<td><input type="number" class="small-text" id="category-overlay_opacity" name="term_meta[overlay_opacity]" value="<?php echo esc_attr( $term_meta['overlay_opacity'] ); ?>" min="0" max="1" step="0.1"></td>
</tr>
<tr>
	<th><label for="category-catchphrase_font_size"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></label></th>
	<td><input type="number" class="small-text" id="category-catchphrase_font_size" name="term_meta[catchphrase_font_size]" value="<?php echo esc_attr( $term_meta['catchphrase_font_size'] ); ?>" min="0"> px</td>
</tr>
<tr>
	<th><label for="category-desc_font_size"><?php _e( 'Font size of description', 'tcd-w' ); ?></label></th>
	<td><input type="number" class="small-text" id="category-desc_font_size" name="term_meta[desc_font_size]" value="<?php echo esc_attr( $term_meta['desc_font_size'] ); ?>" min="0"> px</td>
</tr>
<tr>
	<th><label for="category-catchphrase_color"><?php _e( 'Font color', 'tcd-w' ); ?></label></th>
	<td><input type="text" id="category-catchphrase_color" name="term_meta[catchphrase_color]" value="<?php echo esc_attr( $term_meta['catchphrase_color'] ); ?>" data-default-color="#FFFFFF" class="c-color-picker"></td>
</tr>
<tr>
	<th><label for="category-shadow1"><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label></th>
	<td><input type="number" class="small-text" id="category-shadow1" name="term_meta[shadow1]" value="<?php echo esc_attr( $term_meta['shadow1'] ); ?>" min="0"> px</td>
</tr>
<tr>
	<th><label for="category-shadow2"><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label></th>
	<td><input type="number" class="small-text" id="category-shadow2" name="term_meta[shadow2]" value="<?php echo esc_attr( $term_meta['shadow2'] ); ?>" min="0"> px</td>
</tr>
<tr>
	<th><label for="category-shadow3"><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label></th>
	<td><input type="number" class="small-text" id="category-shadow3" name="term_meta[shadow3]" value="<?php echo esc_attr( $term_meta['shadow3'] ); ?>" min="0"> px</td>
</tr>
<tr>
	<th><label for="category-shadow4"><?php _e( 'Dropshadow color', 'tcd-w' ); ?></label></th>
	<td><input type="text" id="category-shadow4" name="term_meta[shadow4]" value="<?php echo esc_attr( $term_meta['shadow4'] ); ?>" data-default-color="#999999" class="c-color-picker"></td>
</tr>
<?php
}
add_action( 'category_edit_form_fields', 'category_edit_extra_category_fields' );

// データを保存 -------------------------------------------------------
function category_save_extra_category_fileds( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = get_option( "taxonomy_{$term_id}", array() );
		$meta_keys = array(
			'color',
			'image_megamenu',
			'image',
			'overlay',
			'overlay_opacity',
			'catchphrase_font_size',
			'desc_font_size',
			'catchphrase_color',
			'shadow1',
			'shadow2',
			'shadow3',
			'shadow4'
		);
		foreach ( $meta_keys as $key ) {
			if ( isset( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}

		update_option( "taxonomy_{$term_id}", $term_meta );
	}
}
add_action( 'created_category', 'category_save_extra_category_fileds' );
add_action( 'edited_category', 'category_save_extra_category_fileds' );
