<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

// スマホ表示の時、スマホ専用画像が登録されていればそれを、されていなければPC用画像を表示する
$image_url = null;
if ( is_mobile() && $dp_options['footer_cta_image_sp'] ) {
	$image_url = wp_get_attachment_url( $dp_options['footer_cta_image_sp'] );
}
if ( ! $image_url && $dp_options['footer_cta_image'] ) {
	$image_url = wp_get_attachment_url( $dp_options['footer_cta_image'] );
}
?>
<div id="js-footer-cta" class="p-footer-cta"<?php if ( $image_url ) echo ' data-parallax="scroll" data-image-src="' . esc_attr( $image_url ) . '"'; ?>>
	<div class="p-footer-cta__inner" style="background: rgba(<?php echo implode( ', ', hex2rgb( $dp_options['footer_cta_overlay' ] ) ) . ', ' . esc_attr( $dp_options['footer_cta_overlay_opacity'] ); ?>);">
<?php
if ( 'type1' === $dp_options['footer_cta_type'] ) :
	if ( $dp_options['footer_cta_catch'] ) :
?>
		<div class="p-footer-cta__catch" style="font-size: <?php echo esc_attr( $dp_options['footer_cta_catch_font_size'] ); ?>px; "><?php echo str_replace( array( "\r\n", "\r", "\n"), '<br>', $dp_options['footer_cta_catch'] ); ?></div>
<?php
	endif;
	if ( $dp_options['footer_cta_desc'] ) :
?>
		<div class="p-footer-cta__desc" style="font-size: <?php echo esc_attr( $dp_options['footer_cta_desc_font_size'] ); ?>px;"><?php echo wpautop( $dp_options['footer_cta_desc'] ); ?></div>
<?php
	endif;
	if ( $dp_options['footer_cta_btn_label'] ) :
?>
		<a id="js-footer-cta__btn" class="p-footer-cta__btn" href="<?php echo esc_url( $dp_options['footer_cta_btn_url'] ); ?>"<?php if ( $dp_options['footer_cta_btn_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $dp_options['footer_cta_btn_label'] ); ?></a>
<?php
	endif;
else :
	// ページビルダー表示時の不具合対策
	if ( $priority = has_filter( 'the_content', 'page_builder_filter_the_content' ) ) :
		remove_filter( 'the_content', 'page_builder_filter_the_content', $priority );
	endif;
?>
		<div class="p-footer-cta__desc">
			<?php echo apply_filters( 'the_content', $dp_options['footer_cta_editor'] ); ?>
		</div>
<?php
endif;
?>
	</div>
</div>
