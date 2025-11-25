<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

$signage = $catchphrase = $desc = null;

if ( is_404() ) :
	$signage = wp_get_attachment_url( $dp_options['image_404'] );
	$catchphrase = trim( $dp_options['catchphrase_404'] );
	$desc = trim( $dp_options['desc_404'] );
	$catchphrase_font_size = $dp_options['catchphrase_font_size_404'] ? $dp_options['catchphrase_font_size_404'] : 30;
	$desc_font_size = $dp_options['desc_font_size_404'] ? $dp_options['desc_font_size_404'] : 14;
	$color = $dp_options['color_404'] ? $dp_options['color_404'] : '#FFFFFF';
	$shadow1 = ( ! empty( $dp_options['shadow1_404'] ) ) ? $dp_options['shadow1_404'] : 0;
	$shadow2 = ( ! empty( $dp_options['shadow2_404'] ) ) ? $dp_options['shadow2_404'] : 0;
	$shadow3 = ( ! empty( $dp_options['shadow3_404'] ) ) ? $dp_options['shadow3_404'] : 0;
	$shadow4 = $dp_options['shadow_color_404'];

elseif ( is_author() || is_category() || is_date() || is_home() || is_search() || is_tag() ) :
	$signage = wp_get_attachment_url( $dp_options['archive_image'] );
	$catchphrase = trim( $dp_options['archive_catchphrase'] );
	$desc = trim( $dp_options['archive_desc'] );
	$catchphrase_font_size = $dp_options['archive_catchphrase_font_size'] ? $dp_options['archive_catchphrase_font_size'] : 30;
	$desc_font_size = $dp_options['archive_desc_font_size'] ? $dp_options['archive_desc_font_size'] : 14;
	$color = $dp_options['archive_color'] ? $dp_options['archive_color'] : '#FFFFFF';
	$shadow1 = ( ! empty( $dp_options['archive_shadow1'] ) ) ? $dp_options['archive_shadow1'] : 0;
	$shadow2 = ( ! empty( $dp_options['archive_shadow2'] ) ) ? $dp_options['archive_shadow2'] : 0;
	$shadow3 = ( ! empty( $dp_options['archive_shadow3'] ) ) ? $dp_options['archive_shadow3'] : 0;
	$shadow4 = $dp_options['archive_shadow_color'];

	if ( ! is_home() && $catchphrase ) :
		$catchphrase = get_the_archive_title() ;
	endif;

	if ( is_category() ) :
		$queried_object = get_queried_object();
		if ( ! empty( $queried_object->term_id ) ) :
			if ( $catchphrase ) :
				$catchphrase = get_the_archive_title() ;
			endif;

			$category_ids = get_ancestors( $queried_object->term_id, 'category' );
			if ( $category_ids ) :
				array_unshift( $category_ids, $queried_object->term_id );
			else :
				$category_ids = array( $queried_object->term_id );
			endif;
			foreach( $category_ids as $category_id ) :
				$category = get_term_by( 'id', $category_id, 'category' );
				if ( empty( $category->name ) ) continue;

				$term_meta = get_option( 'taxonomy_' . $category_id );
				if ( ! $term_meta ) continue;

				if ( ! empty( $term_meta['image'] ) ) :
					$signage2 = wp_get_attachment_url( $term_meta['image'] );
					// カテゴリー画像がある場合のみ各設定上書き
					if ( $signage2 ) :
						$signage = $signage2;

						if ( $catchphrase || $desc ) :
							$desc = trim( $category->description );
						endif;
						if ( isset( $term_meta['catchphrase_font_size'] ) ) :
							$catchphrase_font_size = $term_meta['catchphrase_font_size'];
						endif;
						if ( isset( $term_meta['desc_font_size'] ) ) :
							$desc_font_size = $term_meta['desc_font_size'];
						endif;
						if ( isset( $term_meta['catchphrase_color'] ) ) :
							$color = $term_meta['catchphrase_color'];
						endif;
						if ( isset( $term_meta['shadow1'] ) ) :
							$shadow1 = $term_meta['shadow1'];
						endif;
						if ( isset( $term_meta['shadow2'] ) ) :
							$shadow2 = $term_meta['shadow2'];
						endif;
						if ( isset( $term_meta['shadow3'] ) ) :
							$shadow3 = $term_meta['shadow3'];
						endif;
						if ( isset( $term_meta['shadow4'] ) ) :
							$shadow4 = $term_meta['shadow4'];
						endif;
						break;
					endif;
				endif;
			endforeach;
		endif;
	endif;

elseif ( is_page() ) :
	$signage = wp_get_attachment_url( $post->page_header_image );
	$catchphrase = trim( $post->page_headline );
	$catchphrase_font_size = $post->page_headline_font_size ? $post->page_headline_font_size : 30;
	$desc = trim( $post->page_desc );
	$desc_font_size = $post->page_desc_font_size ? $post->page_desc_font_size : 14;
	$color = $post->page_headline_color;
	$shadow1 = ( ! empty( $post->page_headline_shadow1 ) ) ? $post->page_headline_shadow1 : 0;
	$shadow2 = ( ! empty( $post->page_headline_shadow2 ) ) ? $post->page_headline_shadow2 : 0;
	$shadow3 = ( ! empty( $post->page_headline_shadow3 ) ) ? $post->page_headline_shadow3 : 0;
	$shadow4 = $post->page_headline_shadow4;
endif;

if ( $signage || $catchphrase || $desc ) :
?>
	<header class="p-page-header"<?php if ( !empty( $signage ) ) echo ' style="background-image: url(' . esc_attr( $signage ) . ');"'; ?>>
		<div class="p-page-header__inner l-inner" style="text-shadow: <?php echo esc_attr( $shadow1 ); ?>px <?php echo esc_attr( $shadow2 ); ?>px <?php echo esc_attr( $shadow3 ); ?>px <?php echo esc_attr( $shadow4 ); ?>">
<?php
	if ( $catchphrase ) :
?>
			<h1 class="p-page-header__title" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $catchphrase_font_size ); ?>px;"><?php echo esc_html( $catchphrase ); ?></h1>
<?php
	endif;
	if ( $desc ) :
?>
			<p class="p-page-header__desc" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $desc_font_size ); ?>px;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $desc ) ); ?></p>
<?php
	endif;
?>
		</div>
	</header>
<?php
endif;
