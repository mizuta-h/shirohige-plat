<?php
function tcd_head() {
	global $dp_options, $post;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	$primary_color_hex = esc_html( implode( ', ', hex2rgb( $dp_options['primary_color'] ) ) );
	$load_color1_hex = esc_html( implode( ', ', hex2rgb( $dp_options['load_color1'] ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
	$load_color2_hex = esc_html( implode( ', ', hex2rgb( $dp_options['load_color2'] ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
?>
<?php if ( $dp_options['favicon'] && $url = wp_get_attachment_url( $dp_options['favicon'] ) ) : ?>
<link rel="shortcut icon" href="<?php echo esc_attr( $url ); ?>">
<?php endif; ?>
<style>
<?php /* Primary color */ ?>
.c-comment__form-submit:hover, c-comment__password-protected, .p-pagetop a, .slick-dots li.slick-active button, .slick-dots li:hover button { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-entry__pickup, .p-entry__related, .p-widget__title,.widget_block .wp-block-heading, .slick-dots li.slick-active button, .slick-dots li:hover button { border-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.p-index-tab__item.is-active, .p-index-tab__item:hover { border-bottom-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
.c-comment__tab-item.is-active a, .c-comment__tab-item a:hover, .c-comment__tab-item.is-active p { background-color: rgba(<?php echo $primary_color_hex; ?>, 0.7); }
.c-comment__tab-item.is-active a:after, .c-comment__tab-item.is-active p:after { border-top-color: rgba(<?php echo $primary_color_hex; ?>, 0.7); }
<?php /* Secondary color */ ?>
.p-article__meta, .p-blog-list__item-excerpt, .p-ranking-list__item-excerpt, .p-author__views, .p-page-links a, .p-page-links .p-page-links__title, .p-pager__item span { color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.p-page-links > span, .p-page-links a:hover, .p-entry__next-page__link { background-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
.p-page-links > span, .p-page-links a { border-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }

<?php /* Link hover color */ ?>
a:hover, a:hover .p-article__title, .p-global-nav > li:hover > a, .p-global-nav > li.current-menu-item > a, .p-global-nav > li.is-active > a, .p-breadcrumb a:hover, .p-widget-categories .has-children .toggle-children:hover::before, .p-footer-widget-area .p-siteinfo .p-social-nav li a:hover, .p-footer-widget-area__default .p-siteinfo .p-social-nav li a:hover { color: <?php echo esc_html( $dp_options['link_color_hover'] ); ?>; }
.p-global-nav .sub-menu a:hover, .p-global-nav .sub-menu .current-menu-item > a, .p-megamenu a.p-megamenu__hover:hover, .p-entry__next-page__link:hover, .c-pw__btn:hover { background: <?php echo esc_html( $dp_options['link_color_hover'] ); ?>; }
<?php /* content color */ ?>
.p-entry__date, .p-entry__body, .p-author__desc, .p-breadcrumb, .p-breadcrumb a { color: <?php echo esc_html( $dp_options['content_color'] ); ?>; }
<?php /* content link color */ ?>
.p-entry__body a, .custom-html-widget a { color: <?php echo esc_html( $dp_options['content_link_color'] ); ?>; }
.p-entry__body a:hover, .custom-html-widget a:hover { color: <?php echo esc_html( $dp_options['link_color_hover'] ); ?>; }
<?php /* Native ad label */ ?>
.p-float-native-ad-label { background: <?php echo esc_html( $dp_options['native_ad_label_bg_color'] ); ?>; color: <?php echo esc_html( $dp_options['native_ad_label_text_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['native_ad_label_font_size'] ); ?>px; }
<?php
/* Category color */
$categories = get_categories( array(
	'orderby' => 'ID',
	'order' => 'ASC',
	'hide_empty' => 1,
	'hierarchical' => 0,
	'taxonomy' => 'category',
	'pad_counts' => false
) );
if ( $categories && ! is_wp_error( $categories ) ) {
	foreach( $categories as $category ) {
		$term_meta = get_option( 'taxonomy_' . $category->term_id, array() );
		if ( ! empty( $term_meta['color'] ) ) {
			echo '.p-category-item--' . esc_html( $category->term_id ) . ', .cat-item-' . esc_html( $category->term_id ) . '> a, .cat-item-' . esc_html( $category->term_id ) . ' .toggle-children { color: ' . esc_html( $term_meta['color'] ) . "; }\n";
		}
	}
}
?>
<?php /* font type */ ?>
<?php 
    // フォントタイプの旧値（type1 など）を新値（1や2）にマッピング
	$convert_font_type = function($value) {
		$map = [
		  'type1' => 1,
		  'type2' => 1,
		  'type3' => 2,
		  '1'     => 1,
		  '2'     => 2,
		  '3'     => 3,
		  1       => 1,
		  2       => 2,
		  3       => 3,
		];
		return $map[$value] ?? 1;
	  };
	  
	  $font_type = $convert_font_type($dp_options['font_type'] ?? 1);
	  $headline_font_type = $convert_font_type($dp_options['headline_font_type'] ?? 1);
?>
<?php if ( 1 == $font_type ) : ?>
body { font-family: var(--tcd-font-type1); }
<?php elseif ( 2 == $font_type ) : ?>
body { font-family: var(--tcd-font-type2); }
<?php else : ?>
body { font-family:var(--tcd-font-type3); }
<?php endif; ?>
<?php /* headline font type */ ?>
.p-logo, .p-entry__title, .p-article__title, .p-article__title__overlay, .p-headline, .p-page-header__title, .p-widget__title,.widget_block .wp-block-heading, .p-sidemenu .p-siteinfo__title, .p-index-slider__item-catch, .p-header-video__caption-catch, .p-footer-blog__catch, .p-footer-cta__catch {
<?php if ( 1 == $headline_font_type ) : ?>
font-family: var(--tcd-font-type1);
<?php elseif ( 2 == $headline_font_type ) : ?>
font-family: var(--tcd-font-type2);
<?php else : ?>
font-family: var(--tcd-font-type3); 
<?php endif; ?>
}
.rich_font_logo { font-family: var(--tcd-font-type-logo); font-weight: <?php echo esc_html( $dp_options['font_list']['logo']['weight'] ?? 'bold' ); ?> !important;}
<?php /* load */ ?>
<?php if ( 'type1' == $dp_options['load_icon'] ) : ?>
.c-load--type1 { border: 3px solid rgba(<?php echo esc_html( $load_color2_hex ); ?>, 0.2); border-top-color: <?php echo esc_html( $dp_options['load_color1'] ); ?>; }
<?php elseif ( 'type2' == $dp_options['load_icon'] ) : ?>
@-webkit-keyframes loading-square-loader {
	0% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	5% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	10% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	15% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	20% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	25% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	30% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	35% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	40% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
	45%, 55% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	60% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	65% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	70% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	75% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	80% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	85% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	90% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	95%, 100% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -24px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
@keyframes loading-square-loader {
	0% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	5% { box-shadow: 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	10% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	15% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	20% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	25% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	30% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	35% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
	40% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
	45%, 55% { box-shadow: 16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	60% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	65% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -16px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	70% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	75% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -16px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	80% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	85% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	90% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 1); }
	95%, 100% { box-shadow: 16px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px 8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -8px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -8px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -24px rgba(<?php echo $load_color2_hex; ?>, 0), 16px -24px rgba(<?php echo $load_color2_hex; ?>, 0), 32px -24px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
.c-load--type2:before { box-shadow: 16px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 16px -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 32px -16px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -32px rgba(<?php echo $load_color2_hex; ?>, 1), 16px -32px rgba(<?php echo $load_color2_hex; ?>, 1), 32px -32px rgba(<?php echo $load_color1_hex; ?>, 0); }
.c-load--type2:after { background-color: rgba(<?php echo $load_color1_hex; ?>, 1); }
<?php elseif ( 'type3' == $dp_options['load_icon'] ) : ?>
.c-load--type3 i { background: <?php echo esc_html( $dp_options['load_color1'] ); ?>; }
<?php endif; ?>
<?php /* hover effect */ ?>
<?php if ( $dp_options['hover1_rotate'] ) : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>) rotate(2deg); }
<?php else : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); transform: scale(<?php echo esc_html( $dp_options['hover1_zoom'] ); ?>); }
<?php endif; ?>
<?php if ( 'type1' == $dp_options['hover2_direct'] ) : ?>
.p-hover-effect--type2 img { margin-left: -8px; }
.p-hover-effect--type2:hover img { margin-left: 8px; }
<?php else : ?>
.p-hover-effect--type2 img { margin-left: 8px; }
.p-hover-effect--type2:hover img { margin-left: -8px; }
<?php endif; ?>
<?php /*if ( 'type1' == $dp_options['hover2_direct'] ) : ?>
.p-hover-effect--type2 img { margin-left: 15px; -webkit-transform: scale(1.2) translate3d(-15px, 0, 0); transform: scale(1.2) translate3d(-15px, 0, 0);}
.p-widget .p-hover-effect--type2 img { -webkit-transform: scale(1.3) translate3d(-15px, 0, 0); transform: scale(1.3) translate3d(-15px, 0, 0); }
<?php else : ?>
.p-hover-effect--type2 img { margin-left: -15px; -webkit-transform: scale(1.2) translate3d(15px, 0, 0); transform: scale(1.2) translate3d(15px, 0, 0); }
.p-widget .p-hover-effect--type2 img { -webkit-transform: scale(1.3) translate3d(15px, 0, 0); transform: scale(1.3) translate3d(15px, 0, 0); }
<?php endif;*/ ?>
.p-hover-effect--type1 .p-article__overlay { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['hover1_bgcolor'] ) ) ); ?>, <?php echo esc_html( $dp_options['hover1_opacity'] ); ?>); }
.p-hover-effect--type2:hover img { opacity: <?php echo esc_html( $dp_options['hover2_opacity'] ); ?> }
.p-hover-effect--type2 .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover2_bgcolor'] ); ?>; }
.p-hover-effect--type2 .p-article__overlay { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['hover2_bgcolor'] ) ) ); ?>, <?php echo esc_html( $dp_options['hover2_opacity'] ); ?>); }
.p-hover-effect--type3 .p-hover-effect__image { background: <?php echo esc_html( $dp_options['hover3_bgcolor'] ); ?>; }
.p-hover-effect--type3:hover img { opacity: <?php echo esc_html( $dp_options['hover3_opacity'] ); ?>; }
.p-hover-effect--type3 .p-article__overlay { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['hover3_bgcolor'] ) ) ); ?>, <?php echo esc_html( $dp_options['hover3_opacity'] ); ?>); }
<?php /* sidebar */ ?>
<?php if ( $dp_options['sidebar_left'] ) : ?>
.l-primary { order: 2; }
.l-secondary {  order: -1;}
<?php endif; ?>
<?php /* Page header */ ?>
<?php if ( is_404() ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['overlay_404'] ) ) ); ?>, <?php echo esc_html( $dp_options['overlay_opacity_404'] ); ?>) }
<?php elseif ( is_author() || is_category() || is_date() || is_home() || is_search() || is_tag() ) :
	$archive_overlay = $dp_options['archive_overlay'];
	$archive_overlay_opacity = $dp_options['archive_overlay_opacity'];
	if ( is_category() ) :
		$queried_object = get_queried_object();
		if ( ! empty( $queried_object->term_id ) ) :
			$term_meta = get_option( 'taxonomy_' . $queried_object->term_id, array() );
			if ( ! empty( $term_meta['overlay'] ) ) :
				$archive_overlay = $term_meta['overlay'];
			endif;
			if ( ! empty( $term_meta['overlay_opacity'] ) ) :
				$archive_overlay_opacity = $term_meta['overlay_opacity'];
			endif;
		endif;
	endif;
?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $archive_overlay ) ) ); ?>, <?php echo esc_html( $archive_overlay_opacity ); ?>) }
<?php elseif ( is_page() && ! is_front_page() ) : // フロントページも固定ページのため、条件から除く ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $post->page_overlay ) ) ); ?>, <?php echo esc_html( $post->page_overlay_opacity ); ?>) }
<?php endif; ?>
<?php /* Entry */ ?>
.p-entry__title { font-size: <?php echo esc_html( $dp_options['title_font_size'] ); ?>px; }
.p-entry__body, .p-entry__body p { font-size: <?php echo esc_html( $dp_options['content_font_size'] ); ?>px; }
<?php /* Header */ ?>
.l-header__bar { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $dp_options['header_bg'] ) ) ); ?>, <?php echo esc_html( $dp_options['header_opacity'] ); ?>); }
.l-header__bar > .l-inner > a, .p-global-nav > li > a { color: <?php echo esc_html( $dp_options['header_font_color'] ); ?>; }
<?php /* logo */ ?>
.l-header__logo--text a { color: <?php echo esc_html( $dp_options['header_font_color'] ); ?>; font-size: <?php echo esc_html( $dp_options['logo_font_size'] ); ?>px; }
.l-footer .p-siteinfo .p-logo { font-size: <?php echo esc_html( $dp_options['footer_logo_font_size'] ); ?>px; }
<?php /* Footer CTA */ ?>
<?php if ( ( is_front_page() && $dp_options['show_footer_cta_top'] ) || 		( ! is_front_page() && $dp_options['show_footer_cta'] ) ) : ?>
.p-footer-cta__btn { background: <?php echo esc_html( $dp_options['footer_cta_btn_bg'] ); ?>; color: <?php echo esc_html( $dp_options['footer_cta_btn_color'] ); ?>; }
.p-footer-cta__btn:hover { background: <?php echo esc_html( $dp_options['footer_cta_btn_bg_hover'] ); ?>; color: <?php echo esc_html( $dp_options['footer_cta_btn_color_hover'] ); ?>; }
<?php endif; ?>
<?php /* Footer bar */ ?>
<?php if ( is_mobile() && ( 'type1' === $dp_options['footer_bar_display'] || 'type2' === $dp_options['footer_bar_display'] ) ) : ?>
.c-footer-bar { background: rgba(<?php echo implode( ',', hex2rgb( $dp_options['footer_bar_bg'] ) ) . ', ' . esc_html( $dp_options['footer_bar_tp'] ); ?>); border-top: 1px solid <?php echo esc_html( $dp_options['footer_bar_border'] ); ?>; color:<?php echo esc_html( $dp_options['footer_bar_color'] ); ?>; }
.c-footer-bar a { color: <?php echo esc_html( $dp_options['footer_bar_color'] ); ?>; }
.c-footer-bar__item + .c-footer-bar__item { border-left: 1px solid <?php echo esc_html( $dp_options['footer_bar_border'] ); ?>; }
<?php endif; ?>
<?php /* Responsive */ ?>
<?php if ( ! is_no_responsive() ) : ?>
@media only screen and (max-width: 1200px) {
	.l-header__logo--mobile.l-header__logo--text a { font-size: <?php echo esc_html( $dp_options['logo_font_size_mobile'] ); ?>px; }
	.p-global-nav { background-color: rgba(<?php echo implode( ',', hex2rgb( $dp_options['primary_color'] ) ) . ', ' . esc_html( $dp_options['header_opacity'] ) ?>); }
}
@media only screen and (max-width: 991px) {
	.l-footer .p-siteinfo .p-logo { font-size: <?php echo esc_html( $dp_options['footer_logo_font_size_mobile'] ); ?>px; }
	.p-copyright { background-color: <?php echo esc_html( $dp_options['primary_color'] ); ?>; }
	.p-pagetop a { background-color: <?php echo esc_html( $dp_options['secondary_color'] ); ?>; }
}
<?php if ( 'type2' == $dp_options['load_icon'] ) : ?>
@media only screen and (max-width: 767px) {
	@-webkit-keyframes loading-square-loader {
		0% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		5% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		10% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		15% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		20% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		25% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		30% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		35% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		40% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
		45%, 55% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		60% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		65% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		70% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		75% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		80% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		85% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		90% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		95%, 100% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -15px rgba(<?php echo $load_color1_hex; ?>, 0); }
	}
	@keyframes loading-square-loader {
		0% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		5% { box-shadow: 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		10% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		15% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		20% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		25% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		30% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -50px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		35% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -50px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
		40% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
		45%, 55% { box-shadow: 10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		60% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		65% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -10px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		70% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		75% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -10px rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		80% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		85% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		90% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 1); }
		95%, 100% { box-shadow: 10px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px 5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -5px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -5px rgba(<?php echo $load_color2_hex; ?>, 0), 0 -15px rgba(<?php echo $load_color2_hex; ?>, 0), 10px -15px rgba(<?php echo $load_color2_hex; ?>, 0), 20px -15px rgba(<?php echo $load_color1_hex; ?>, 0); }
	}
	.c-load--type2:before { box-shadow: 10px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px 0 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 10px -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 20px -10px 0 rgba(<?php echo $load_color2_hex; ?>, 1), 0 -20px rgba(<?php echo $load_color2_hex; ?>, 1), 10px -20px rgba(<?php echo $load_color2_hex; ?>, 1), 20px -20px rgba(<?php echo $load_color1_hex; ?>, 0); }
}
<?php endif; ?>
<?php endif; ?>
<?php
if ( is_front_page() ) {
	// image slider caption
	if ( 'type2' == $dp_options['header_content_type'] ) {
		for ( $i = 1; $i <= 3; $i++ ) {
			$slider_shadow1 = $dp_options['slider' . $i . '_shadow1'];
			$slider_shadow2 = $dp_options['slider' . $i . '_shadow2'];
			$slider_shadow3 = $dp_options['slider' . $i . '_shadow3'];
			$slider_shadow4 = $dp_options['slider' . $i . '_shadow_color'];

			if ( $dp_options['slider_headline' . $i] ) {
				echo ".p-index-slider__item--" . $i ." .p-index-slider__item-catch { color: " . esc_attr( $dp_options['slider_font_color' . $i] ) . "; font-size: " . esc_attr( $dp_options['slider_headline_font_size' . $i] ) . "px; text-shadow: " . esc_attr( $slider_shadow1 ) . "px " . esc_attr( $slider_shadow2 ) . "px " . esc_attr( $slider_shadow3 ) . "px " . esc_attr( $slider_shadow4 ) . "; }\n";
			}
			if ( $dp_options['slider_desc' . $i] ) {
				echo ".p-index-slider__item--" . $i ." .p-index-slider__item-desc { color: " . esc_attr( $dp_options['slider_font_color' . $i] ) . "; font-size: " . esc_attr( $dp_options['slider_desc_font_size' . $i] ) . "px; text-shadow: " . esc_attr( $slider_shadow1 ) . "px " . esc_attr( $slider_shadow2 ) . "px " . esc_attr( $slider_shadow3 ) . "px " . esc_attr( $slider_shadow4 ) . "; }\n";
			}
			if ( $dp_options['display_slider_button' . $i] && $dp_options['slider_button_label' . $i] ) {
				echo ".p-index-slider__item--" . $i ." .p-index-slider__item-button { background-color: " . esc_attr( $dp_options['slider_button_bg_color' . $i] ) . ";color: " . esc_attr( $dp_options['slider_button_font_color' . $i] ) . "; }\n";
				echo ".p-index-slider__item--" . $i ." .p-index-slider__item-button:hover { background-color: " . esc_attr( $dp_options['slider_button_bg_color_hover' . $i] ) . ";color: " . esc_attr( $dp_options['slider_button_font_color_hover' . $i] ) . "; }\n";
			}
		}

	// video caption
	} elseif ( in_array( $dp_options['header_content_type'], array( 'type3', 'type4' ) ) ) {
		if ( $dp_options['use_video_catch'] ) {
			$shadow1 = $dp_options['video_catch_shadow1'];
			$shadow2 = $dp_options['video_catch_shadow2'];
			$shadow3 = $dp_options['video_catch_shadow3'];
			$shadow4 = $dp_options['video_catch_shadow_color'];
			if ( $dp_options['video_catch'] ) {
				echo ".p-header-video__caption-catch { color:" . esc_attr( $dp_options['video_catch_color'] ) . "; font-size:" . esc_attr( $dp_options['video_catch_font_size'] ) . "px; text-shadow: " . esc_attr( $shadow1 ) . "px " . esc_attr( $shadow2 ) . "px " . esc_attr( $shadow3 ) . "px " . esc_attr( $shadow4 ) . "; }\n";
			}
			if ( $dp_options['video_desc'] ) {
				echo ".p-header-video__caption-desc { color:" . esc_attr( $dp_options['video_catch_color'] ) . "; font-size:" . esc_attr( $dp_options['video_desc_font_size'] ) . "px; text-shadow: " . esc_attr( $shadow1 ) . "px " . esc_attr( $shadow2 ) . "px " . esc_attr( $shadow3 ) . "px " . esc_attr( $shadow4 ) . "; }\n";
			}
		}
		if ( $dp_options['show_video_catch_button'] ) {
			echo ".p-header-video__caption-button { background-color:" . esc_attr( $dp_options['video_button_bg_color'] ) . "; color:" . esc_attr( $dp_options['video_button_font_color'] ) . "; }\n";
			echo ".p-header-video__caption-button:hover { background-color:" . esc_attr( $dp_options['video_button_bg_color_hover'] ) . "; color:" . esc_attr( $dp_options['video_button_font_color_hover'] ) . "; }\n";		}
	}
}

/* Site info widget button color */
foreach( get_option( 'widget_site_info_widget', array() ) as $key => $value ) {
	if ( is_int( $key ) && ! empty( $value['button_font_color'] ) ) {
		echo '#site_info_widget-' . $key . ' .p-siteinfo__button { background: ' . esc_html( $value['button_bg_color'] ) . '; color: ' . esc_html( $value['button_font_color'] ) . "; }\n";
		echo '#site_info_widget-' . $key . ' .p-siteinfo__button:hover { background: ' . esc_html( $value['button_bg_color_hover'] ) . '; color: ' . esc_html( $value['button_font_color_hover'] ) . "; }\n";
	}
}
?>
<?php /* Custom CSS */ ?>
<?php if ( $dp_options['css_code'] ) { echo $dp_options['css_code']; } ?>
</style>
<?php
}
add_action( 'wp_head', 'tcd_head' );

// Custom head/script
function tcd_custom_head() {
  $options = get_design_plus_option();

  if ( $options['custom_head'] ) {
    echo $options['custom_head'] . "\n";
  }
}
add_action( 'wp_head', 'tcd_custom_head', 9999 );
?>
