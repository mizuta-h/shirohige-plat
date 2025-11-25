<?php
 use TCD\Helper\UI;
 use TCD\Helper\Sanitization as San;

// 設定項目と無害化用コールバックを登録
function theme_options_init() {
	register_setting(
		'design_plus_options',
		'dp_options',
		'theme_options_validate'
	);
}
add_action( 'admin_init', 'theme_options_init' );

// 外観メニューにサブメニューを登録
function theme_options_add_page() {
	add_theme_page(
		__( 'TCD Theme Options', 'tcd-w' ),
		__( 'TCD Theme Options', 'tcd-w' ),
		'edit_theme_options',
		'theme_options',
		'theme_options_do_page'
	);
}
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * オプション初期値
 * @var array
 */
global $dp_default_options;
$dp_default_options = array(

	/**
	 * 基本設定
	 */
	// 色の設定
	'primary_color' => '#000000',
	'secondary_color' => '#999999',
	'link_color_hover' => '#aaaaaa',
	'content_color' => '#666666',
	'content_link_color' => '#000000',

	// ファビコンの設定
	'favicon' => '',


  // フォントセット（type1, type2, type3, logo 用）
  'font_list' => array(
	1 => [ // type1
	  'type'       => 'system',
	  'weight'     => 'normal',
	  'japan'      => 'sans-serif',
	  'latin'      => 'arial',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
	2 => [ // type2
	  'type'       => 'system',
	  'weight'     => 'normal',
	  'japan'      => 'serif',
	  'latin'      => 'times',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
	3 => [ // type3
	  'type'       => 'system',
	  'weight'     => 'normal',
	  'japan'      => 'kyokasho',
	  'latin'      => 'palatino',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
	'logo' => [ // ロゴ用フォント
	  'type'       => 'web',
	  'weight'     => 'bold',
	  'japan'      => 'kyokasho',
	  'latin'      => 'palatino',
	  'web_japan'  => 'noto_sans',
	  'web_latin'  => '',
	],
),

	// フォントタイプ
	'font_type' => 1,

	// 大見出しのフォントタイプ
	'headline_font_type' => 1,

	// 絵文字の設定
	'use_emoji' => 0,

	// クイックタグの設定
	'use_quicktags' => 1,

	// レスポンシブデザインの設定
	'responsive' => 'yes',

	// サイドバーの設定
	'sidebar_left' => 0,

	// サイドメニューの設定
	'show_sidemenu' => 1,

	// ロード画面の設定
	'use_load_icon' => 'yes',
	'load_icon' => 'type1',
	'load_time' => 3,
	'load_color1' => '#000000',
	'load_color2' => '#999999',

	// ホバーエフェクトの設定
	'hover_type' => 'type1',
	'hover1_zoom' => 1.2,
	'hover1_rotate' => 1,
	'hover1_opacity' => 0.5,
	'hover1_bgcolor' => '#000000',
	'hover2_direct' => 'type1',
	'hover2_opacity' => 0.5,
	'hover2_bgcolor' => '#000000',
	'hover3_opacity' => 0.5,
	'hover3_bgcolor' => '#000000',

	// Facebook OGPの設定
	'use_ogp' => 0,
	'fb_app_id' => '',
	'ogp_image' => '',

	// Twitter Cardsの設定
	'twitter_account_name' => '',

	// ソーシャルボタンの表示設定
	'show_sns_top' => 1,
	'sns_type_top' => 'type1',
	'show_twitter_top' => 1,
	'show_fblike_top' => 1,
	'show_fbshare_top' => 1,
	'show_hatena_top' => 1,
	'show_pocket_top' => 1,
	'show_feedly_top' => 1,
	'show_rss_top' => 1,
	'show_pinterest_top' => 1,
	'show_sns_btm' => 1,
	'sns_type_btm' => 'type1',
	'show_twitter_btm' => 1,
	'show_fblike_btm' => 1,
	'show_fbshare_btm' => 1,
	'show_hatena_btm' => 1,
	'show_pocket_btm' => 1,
	'show_feedly_btm' => 1,
	'show_rss_btm' => 1,
	'show_pinterest_btm' => 1,
	'twitter_info' => '',

	// Google Map
	'gmap_api_key' => '',
	'gmap_marker_type' => 'type1',
	'gmap_custom_marker_type' => 'type1',
	'gmap_marker_text' => '',
	'gmap_marker_color' => '#ffffff',
	'gmap_marker_img' => '',
	'gmap_marker_bg' => '#000000',

	// カスタムCSS
	'css_code' => '',

	// カスタムスクリプト
	'custom_head' => '',

	/**
	 * ロゴ
	 */
	// ヘッダーのロゴ
	'use_logo_image' => 'no',
	'logo_font_size' => 28,
	'header_logo_image' => '',
	'header_logo_image_retina' => '',

	// ヘッダーのロゴ（スマホ用）
	'logo_font_size_mobile' => 18,
	'header_logo_image_mobile' => '',
	'header_logo_image_mobile_retina' => '',

	// フッターのロゴ
	'footer_logo_font_size' => 28,
	'footer_logo_font_size_mobile' => 18,
	'footer_logo_image' => false,
	'footer_logo_image_retina' => '',

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	'header_content_type' => 'type2',
	'header_blog_list_type' => 'type1',
	'header_blog_category' => 0,
	'header_blog_num' => 5,
	'header_blog_post_order' => 'date1',
	'show_header_blog_date' => 1,
	'show_header_blog_category' => 1,
	'show_header_blog_views' => 0,
	'show_header_blog_author' => 0,
	'show_header_blog_native_ad' => 0,
	'header_blog_native_ad_position' => 4,
	'video' => false,
	'video_image' => false,
	'video_image_hide' => 0,
	'youtube_url' => '',
	'youtube_image' => false,
	'youtube_image_hide' => 0,
	'use_video_catch' => 1,
	'video_catch' => '',
	'video_catch_font_size' => 32,
	'video_desc' => '',
	'video_desc_font_size' => 16,
	'video_catch_color' => '#ffffff',
	'video_catch_shadow1' => 0,
	'video_catch_shadow2' => 0,
	'video_catch_shadow3' => 0,
	'video_catch_shadow_color' => '#333333',
	'show_video_catch_button' => '',
	'video_catch_button' => '',
	'video_button_font_color' => '#ffffff',
	'video_button_font_color_hover' => '#ffffff',
	'video_button_bg_color' => '#000000',
	'video_button_bg_color_hover' => '#000000',
	'video_button_url' => '',
	'video_button_target' => 1,
	'slide_time' => '7000',

	// トップページコンテンツの設定
  'index_editor' => __( "Free space enters here. You can decorate with a rich editor", 'tcd-w' ),
	'show_index_tab1' => 1,
    'index_tab_label1' => sprintf( __( 'Tab%s heading', 'tcd-w' ), 1 ),
	'show_index_tab_editor1' => 1,
    'index_tab_editor1' => __( "Free space enters here. You can decorate with a rich editor", 'tcd-w' ),
	'index_tab_list_type1' => 'type1',
	'index_tab_category1' => 0,
	'index_tab_post_num1' => 10,
	'index_tab_post_order1' => 'date1',
	'show_index_tab_large1' => 1,
	'use_index_tab_sticky1' => 1,
	'show_index_tab_native_ad1' => 0,
	'index_tab_native_ad_position1' => 4,
	'show_index_tab2' => 1,
    'index_tab_label2' => sprintf( __( 'Tab%s heading', 'tcd-w' ), 2 ),
	'show_index_tab_editor2' => 0,
	'index_tab_editor2' => '',
	'index_tab_list_type2' => 'type1',
	'index_tab_category2' => 0,
	'index_tab_post_num2' => 10,
	'index_tab_post_order2' => 'date1',
	'show_index_tab_large2' => 0,
	'use_index_tab_sticky2' => 1,
	'show_index_tab_native_ad2' => 0,
	'index_tab_native_ad_position2' => 4,
	'show_index_tab3' => 1,
    'index_tab_label3' => sprintf( __( 'Tab%s heading', 'tcd-w' ), 3 ),
	'show_index_tab_editor3' => 0,
	'index_tab_editor3' => '',
	'index_tab_list_type3' => 'type1',
	'index_tab_category3' => 0,
	'index_tab_post_num3' => 10,
	'index_tab_post_order3' => 'date1',
	'show_index_tab_large3' => 0,
	'use_index_tab_sticky3' => 1,
	'show_index_tab_native_ad3' => 0,
	'index_tab_native_ad_position3' => 4,
	'show_index_tab4' => 0,
    'index_tab_label4' => sprintf( __( 'Tab%s heading', 'tcd-w' ), 4 ),
	'show_index_tab_editor4' => 0,
	'index_tab_editor4' => '',
	'index_tab_list_type4' => 'type1',
	'index_tab_category4' => 0,
	'index_tab_post_num4' => 10,
	'index_tab_post_order4' => 'date1',
	'show_index_tab_large4' => 0,
	'use_index_tab_sticky4' => 1,
	'show_index_tab_native_ad4' => 0,
	'index_tab_native_ad_position4' => 4,

	/**
	 * ブログ
	 */
	// ブログの設定
	'blog_breadcrumb_label' => __( 'BLOG', 'tcd-w' ),

	// アーカイブページヘッダーの設定
	'archive_image' => '',
	'archive_overlay' => '#000000',
	'archive_overlay_opacity' => 0.2,
	'archive_catchphrase' => __( 'BLOG', 'tcd-w' ),
    'archive_desc' => __( 'Here is the description of the blog archive page. You can set font size, font color, drop shadow', 'tcd-w' ),
	'archive_catchphrase_font_size' => 30,
	'archive_desc_font_size' => 14,
	'archive_color' => '#ffffff',
	'archive_shadow1' => 0,
	'archive_shadow2' => 0,
	'archive_shadow3' => 0,
	'archive_shadow_color' => '#999999',

	// アーカイブページ ネイティブ広告の設定
	'show_archive_native_ad' => 0,
	'show_category_archive_native_ad' => 0,
	'show_tag_archive_native_ad' => 0,
	'show_date_archive_native_ad' => 0,
	'show_author_archive_native_ad' => 0,
	'show_search_archive_native_ad' => 0,
	'archive_native_ad_position' => 4,

	// 記事詳細の設定
	'title_font_size' => 30,
	'title_align' => 'type1',
	'content_font_size' => 14,
	'page_link' => 'type1',

	// 表示設定
	'show_views' => 1,
	'show_thumbnail' => 1,
	'show_date' => 1,
	'show_category' => 1,
	'show_archive_author' => 1,
	'show_author' => 1,
	'show_author_views' => 1,
	'show_next_post' => 1,
	'show_comment' => 1,
	'show_trackback' => 1,

	// ピックアップ記事の設定
	'show_pickup_post' => 1,
	'pickup_post_headline' => __( 'Pickup posts', 'tcd-w' ),
	'pickup_post_num' => 3,
	'show_pickup_post_native_ad' => 0,
	'pickup_post_native_ad_position' => 2,

	// 関連記事の設定
	'show_related_post' => 1,
	'related_post_headline' => __( 'Related posts', 'tcd-w' ),
	'related_post_num' => 8,
	'show_related_post_native_ad' => 0,
	'related_post_native_ad_position' => 3,

	// 記事詳細の広告設定1
	'single_ad_code1' => '',
	'single_ad_image1' => false,
	'single_ad_url1' => '',
	'single_ad_code2' => '',
	'single_ad_image2' => false,
	'single_ad_url2' => '',

	// 記事詳細の広告設定2
	'single_ad_code3' => '',
	'single_ad_image3' => false,
	'single_ad_url3' => '',
	'single_ad_code4' => '',
	'single_ad_image4' => false,
	'single_ad_url4' => '',

	// スマートフォン専用の広告
	'single_mobile_ad_code1' => '',
	'single_mobile_ad_image1' => false,
	'single_mobile_ad_url1' => '',

	/**
	 * ヘッダー
	 */
	// ヘッダーバーの表示位置
	'header_fix' => 'type2',

	// ヘッダーバーの表示位置（スマホ）
	'mobile_header_fix' => 'type2',

	// ヘッダーバーの色の設定
	'header_bg' => '#ffffff',
	'header_opacity' => 0.8,
	'header_font_color' => '#000000',

	// ヘッダー検索
	'show_header_search' => 1,

	// グローバルメニュー表示設定
	'megamenu' => array(),

	/**
	 * フッター
	 */
	// ブログコンテンツの設定
	'show_footer_blog_top' => 1,
	'show_footer_blog' => 1,
    'footer_blog_catchphrase' => __( 'Feature articles of this month', 'tcd-w' ),
	'footer_blog_catchphrase_font_size' => 20,
	'footer_blog_list_type' => 'type1',
	'footer_blog_category' => 0,
	'footer_blog_num' => 9,
	'footer_blog_post_order' => 'date1',
	'show_footer_blog_date' => 0,
	'show_footer_blog_category' => 0,
	'show_footer_blog_views' => 0,
	'show_footer_blog_author' => 0,
	'show_footer_blog_native_ad' => 0,
	'footer_blog_native_ad_position' => 3,
	'footer_blog_slide_time' => '7000',

	// フッターCTAの設定
	'show_footer_cta_top' => 1,
	'show_footer_cta' => 1,
	'footer_cta_type' => 'type1',
	'footer_cta_catch' => '',
	'footer_cta_catch_font_size' => 30,
    'footer_cta_desc' => __( "Enter description here", 'tcd-w' ),
	'footer_cta_desc_font_size' => 14,
    'footer_cta_btn_label' => __( 'Click here for details', 'tcd-w' ),
	'footer_cta_btn_url' => '#',
	'footer_cta_btn_target' => 0,
	'footer_cta_btn_color' => '#ffffff',
	'footer_cta_btn_bg' => '#000000',
	'footer_cta_btn_color_hover' => '#ffffff',
	'footer_cta_btn_bg_hover' => '#666666',
	'footer_cta_image' => '',
	'footer_cta_image_sp' => '',
	'footer_cta_overlay' => '#ffffff',
	'footer_cta_overlay_opacity' => 0.8,
	'footer_cta_editor' => '',

	// SNSボタンの設定
	'footer_instagram_url' => '',
	'footer_twitter_url' => '',
	'footer_tiktok_url' => '',
	'footer_pinterest_url' => '',
	'footer_facebook_url' => '',
	'footer_youtube_url' => '',
	'footer_contact_url' => '',
	'footer_show_rss' => 0,

	// スマホ用固定フッターバーの設定
	'footer_bar_display' => 'type3',
	'footer_bar_tp' => 0.8,
	'footer_bar_bg' => '#ffffff',
	'footer_bar_border' => '#dddddd',
	'footer_bar_color' => '#000000',
	'footer_bar_btns' => array(
		array(
			'type' => 'type1',
			'label' => '',
			'url' => '',
			'number' => '',
			'target' => 0,
			'icon' => 'file-text'
		)
	),

	/**
	 * 404 ページ
	 */
	'image_404' => '',
	'overlay_404' => '#000000',
	'overlay_opacity_404' => 0.2,
	'catchphrase_404' => __( '404 Not Found', 'tcd-w' ),
    'desc_404' => __( 'The page you were looking for could not be found', 'tcd-w' ),
	'catchphrase_font_size_404' => 30,
	'desc_font_size_404' => 14,
	'color_404' => '#ffffff',
	'shadow1_404' => 0,
	'shadow2_404' => 0,
	'shadow3_404' => 0,
	'shadow_color_404' => '#999999',

	/**
	 * ネイティブ広告
	 */
	'native_ad_label_font_size' => 11,
	'native_ad_label_text_color' => '#ffffff',
	'native_ad_label_bg_color' => '#000000',

	/**
	 * ページ保護
	 */
	'pw_label' => '',
	'pw_align' => 'type1',
	'pw_name1' => '',
	'pw_name2' => '',
	'pw_name3' => '',
	'pw_name4' => '',
	'pw_name5' => '',
	'pw_btn_display1' => '',
	'pw_btn_display2' => '',
	'pw_btn_display3' => '',
	'pw_btn_display4' => '',
	'pw_btn_display5' => '',
	'pw_btn_label1' => '',
	'pw_btn_label2' => '',
	'pw_btn_label3' => '',
	'pw_btn_label4' => '',
	'pw_btn_label5' => '',
	'pw_btn_url1' => '',
	'pw_btn_url2' => '',
	'pw_btn_url3' => '',
	'pw_btn_url4' => '',
	'pw_btn_url5' => '',
	'pw_btn_target1' => 0,
	'pw_btn_target2' => 0,
	'pw_btn_target3' => 0,
	'pw_btn_target4' => 0,
	'pw_btn_target5' => 0,
	'pw_editor1' => '',
	'pw_editor2' => '',
	'pw_editor3' => '',
	'pw_editor4' => '',
	'pw_editor5' => ''
);

// オプション初期値ループ項目
for ( $i = 1; $i <= 3; $i++ ) {
	$dp_default_options['slider_headline' . $i] = '';
	$dp_default_options['slider_headline_font_size' . $i] = 32;
	$dp_default_options['slider_desc' . $i] = '';
	$dp_default_options['slider_desc_font_size' . $i] = 16;
	$dp_default_options['slider_font_color' . $i] = '#ffffff';
	$dp_default_options['slider' . $i . '_shadow1'] = 0;
	$dp_default_options['slider' . $i . '_shadow2'] = 0;
	$dp_default_options['slider' . $i . '_shadow3'] = 0;
	$dp_default_options['slider' . $i . '_shadow_color'] = '#999999';
	$dp_default_options['slider_overlay_color' . $i] = '#000000';
	$dp_default_options['slider_overlay_opacity' . $i] = 0.5;
	$dp_default_options['display_slider_button' . $i] = '';
	$dp_default_options['slider_button_label' . $i] = '';
	$dp_default_options['slider_button_font_color' . $i] = '#ffffff';
	$dp_default_options['slider_button_bg_color' . $i] = '#000000';
	$dp_default_options['slider_button_font_color_hover' . $i] = '#ffffff';
	$dp_default_options['slider_button_bg_color_hover' . $i] = '#000000';
	$dp_default_options['slider_url' . $i] = '';
	$dp_default_options['slider_target' . $i] = 0;
	$dp_default_options['slider_image' . $i] = '';
	$dp_default_options['slider_native_ad_label' . $i] = '';
}
for ( $i = 1; $i <= 6; $i++ ) {
	$dp_default_options['native_ad_title' . $i] = '';
	$dp_default_options['native_ad_label' . $i] = __( 'PR', 'tcd-w' );
	$dp_default_options['native_ad_image' . $i] = '';
	$dp_default_options['native_ad_url' . $i] = '';
}

// オプション初期値ループ項目のデフォルト値上書き
$i = 1;
$dp_default_options['slider_headline' . $i] = __( 'Catchphrase for slider 1', 'tcd-w' );
$dp_default_options['slider_desc' . $i] = __( "Description for slider 1", 'tcd-w' );
$dp_default_options['slider_button_label' . $i] = __( 'Button', 'tcd-w' );
$dp_default_options['slider_url' . $i] = '#';
$dp_default_options['slider_target' . $i] = 1;
$dp_default_options['native_ad_title' . $i] = __( 'Advertisement title', 'tcd-w' );
$dp_default_options['native_ad_label' . $i] = __( 'PR', 'tcd-w' );
$dp_default_options['native_ad_url' . $i] = '#';

/**
 * Design Plus のオプションを返す
 *
 * @global array $dp_default_options
 * @return array
 */
function get_design_plus_option() {
	global $dp_default_options;
	return shortcode_atts( $dp_default_options, get_option( 'dp_options', array() ) );
}

// フォントタイプ
global $font_type_options;
$font_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' )
	)
);

// 大見出しのフォントタイプ
global $headline_font_type_options;
$headline_font_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' )
	)
);

// レスポンシブデザインの設定
global $responsive_options;
$responsive_options = array(
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Use responsive design', 'tcd-w' )
	),
	'no' => array(
		'value' => 'no',
		'label' => __( 'Do not use responsive design', 'tcd-w' )
	)
);

// ローディングアイコンの種類の設定
global $load_icon_options;
$load_icon_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Circle', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Square', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Dot', 'tcd-w' ) )
);

// ロード画面の設定
global $load_time_options;
for ( $i = 3; $i <= 10; $i++ ) {
	$load_time_options[$i * 1000] = array( 'value' => $i * 1000, 'label' => $i );
}

// ホバーエフェクトの設定
global $hover_type_options;
$hover_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Zoom', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Slide', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Fade', 'tcd-w' )
	)
);
global $hover2_direct_options;
$hover2_direct_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Left to Right', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Right to Left', 'tcd-w' )
	)
);

// Google Maps
global $gmap_marker_type_options;
$gmap_marker_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Use default marker', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Use custom marker', 'tcd-w' )
	)
);
global $gmap_custom_marker_type_options;
$gmap_custom_marker_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Text', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Image', 'tcd-w' )
	)
);

// ロゴに画像を使うか否か
global $logo_type_options;
$logo_type_options = array(
	'no' => array(
		'value' => 'no',
		'label' => __( 'Use text for logo', 'tcd-w' )
	),
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Use image for logo', 'tcd-w' )
	)
);

// ヘッダーコンテンツの設定
global $header_content_type_options;
$header_content_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Posts slider', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Image slider', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Video background', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Youtube background', 'tcd-w' )
	)
);

// ヘッダーバーの表示位置
global $header_fix_options;
$header_fix_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Normal header', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Fix at top after page scroll', 'tcd-w' )
	)
);

// 記事タイプ
global $list_type_options;
$list_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Category', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Recommend post', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Recommend post2', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Pickup post', 'tcd-w' )
	),
	'type5' => array(
		'value' => 'type5',
		'label' => __( 'All posts', 'tcd-w' )
	)
);

// タイトルの文字揃え
global $title_align_options;
$title_align_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Align left', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Align center', 'tcd-w' )
	)
);

// ページナビ
global $page_link_options;
$page_link_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Page numbers', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Read more button', 'tcd-w' ),
	)
);

// ピックアップ記事の数
global $pickup_post_num_options;
for ( $i = 1; $i <= 5; $i++ ) {
	$pickup_post_num_options[$i * 3] = array( 'value' => $i * 3, 'label' => $i * 3 );
}

// 関連記事の数
global $related_post_num_options;
for ( $i = 1; $i <= 5; $i++ ) {
	$related_post_num_options[$i * 4] = array( 'value' => $i * 4, 'label' => $i * 4 );
}

// フッターブログコンテンツの数
global $footer_blog_num_options;
for ( $i = 1; $i <= 5; $i++ ) {
	$footer_blog_num_options[$i * 3] = array( 'value' => $i * 3, 'label' => $i * 3 );
}

// ブログ表示順
global $post_order_options;
$post_order_options = array(
	'date1' => array(
		'value' => 'date1',
		'label' => __( 'Date (DESC)', 'tcd-w' )
	),
	'date2' => array(
		'value' => 'date2',
		'label' => __( 'Date (ASC)', 'tcd-w' )
	),
	'rand' => array(
		'value' => 'rand',
		'label' => __( 'Random', 'tcd-w' )
	)
);

// スライダーが切り替わるスピード
global $slide_time_options;
for ( $i = 3; $i <= 15; $i++ ) {
	$slide_time_options[$i * 1000] = array( 'value' => $i * 1000, 'label' => $i );
}

// 記事上ボタンタイプ
global $sns_type_top_options;
$sns_type_top_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'style1', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'style2', 'tcd-w' )
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'style3', 'tcd-w' )
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'style4', 'tcd-w' )
	),
	'type5' => array(
		'value' => 'type5',
		'label' => __( 'style5', 'tcd-w' )
	)
);

// 記事下ボタンタイプ
global $sns_type_btm_options;
$sns_type_btm_options = $sns_type_top_options;

// フッターの固定メニュー 表示タイプ
global $footer_bar_display_options;
$footer_bar_display_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Fade In', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Slide In', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Hide', 'tcd-w' ) )
);

// フッターバーボタンのタイプ
global $footer_bar_button_options;
$footer_bar_button_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Default', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Share', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Telephone', 'tcd-w' ) )
);

// フッターバーボタンのアイコン
global $footer_bar_icon_options;
$footer_bar_icon_options = array(
	'file-text' => array(
		'value' => 'file-text',
		'label' => __( 'Document', 'tcd-w' )
	),
	'share-alt' => array(
		'value' => 'share-alt',
		'label' => __( 'Share', 'tcd-w' )
	),
	'phone' => array(
		'value' => 'phone',
		'label' => __( 'Telephone', 'tcd-w' )
	),
	'envelope' => array(
		'value' => 'envelope',
		'label' => __( 'Envelope', 'tcd-w' )
	),
	'tag' => array(
		'value' => 'tag',
		'label' => __( 'Tag', 'tcd-w' )
	),
	'pencil' => array(
		'value' => 'pencil',
		'label' => __( 'Pencil', 'tcd-w' )
	)
);

// 記事下CTAのタイプ
global $footer_cta_type_options;
$footer_cta_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Template', 'tcd-w' ),
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Wysiwyg editor', 'tcd-w' ),
	)
);

// 保護ページalign
global $pw_align_options;
$pw_align_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Align left', 'tcd-w' )
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Align center', 'tcd-w' )
	)
);

// メガメニュー
global $megamenu_options;
$megamenu_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Dropdown menu', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu1.jpg'
	),
	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Mega menu A', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu2.jpg'
	),
	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Mega menu B', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu3.jpg'
	),
	'type4' => array(
		'value' => 'type4',
		'label' => __( 'Mega menu C', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/megamenu4.jpg'
	)
);

// テーマオプション画面の作成
function theme_options_do_page() {

	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	$tabs = array(
		// 基本設定
		array(
			'label' => __( 'Basic', 'tcd-w' ),
			'template_part' => 'admin/inc/basic',
		),
		// ロゴの設定
		array(
			'label' => __( 'Logo', 'tcd-w' ),
			'template_part' => 'admin/inc/logo',
		),
		// トップページ
		array(
			'label' => __( 'Index', 'tcd-w' ),
			'template_part' => 'admin/inc/top',
		),
		// ブログ
		array(
			'label' => __( 'Blog', 'tcd-w' ),
			'template_part' => 'admin/inc/blog',
		),
		// ヘッダー
		array(
			'label' => __( 'Header', 'tcd-w' ),
			'template_part' => 'admin/inc/header',
		),
		// フッター
		array(
			'label' => __( 'Footer', 'tcd-w' ),
			'template_part' => 'admin/inc/footer',
		),
		// 404 ページ
		array(
			'label' => __( '404 page', 'tcd-w' ),
			'template_part' => 'admin/inc/404',
		),
		// ネイティブ広告
		array(
			'label' => __( 'Native advertisement', 'tcd-w' ),
			'template_part' => 'admin/inc/native_ad',
		),
		// ページ保護
		array(
			'label' => __( 'Password protected pages', 'tcd-w' ),
			'template_part' => 'admin/inc/password',
		),
		// Tools
		array(
			'label' => __( 'Tools', 'tcd-w' ),
			'template_part' => 'admin/inc/tools',
		)
	);

?>
<div class="wrap">
	<h2><?php _e( 'TCD Theme Options', 'tcd-w' ); ?></h2>
<?php
	// 更新時のメッセージ
	if ( ! empty( $_REQUEST['settings-updated'] ) ) :
?>
	<div class="updated fade">
		<p><strong><?php _e( 'Updated', 'tcd-w' ); ?></strong></p>
	</div>
<?php
	endif;

	// Toolsメッセージ
	theme_options_tools_notices();
?>
	<div id="tcd_theme_option" class="cf">
		<div id="tcd_theme_left">
			<ul id="theme_tab" class="cf">
<?php
	foreach( $tabs as $key => $tab ):
?>
				<li><a href="#tab-content<?php echo esc_attr( $key + 1 ); ?>"><?php echo esc_html( $tab['label'] ); ?></a></li>
<?php
	endforeach;
?>
			</ul>
		</div>
		<div id="tcd_theme_right">
			<form method="post" action="options.php" enctype="multipart/form-data">
<?php
	settings_fields( 'design_plus_options' );
?>
				<div id="tab-panel">
<?php
	foreach( $tabs as $key => $tab ):
?>
					<div id="#tab-content<?php echo esc_attr( $key + 1 ); ?>">
<?php
		if ( !empty( $tab['template_part'] ) ) :
			get_template_part( $tab['template_part'] );
		endif;
?>
					</div>
<?php
	endforeach;
?>
				</div><!-- END #tab-panel -->
			</form>
		</div><!-- END #tcd_theme_right -->
	</div><!-- END #tcd_theme_option -->
</div><!-- END #wrap -->
<?php
}

/**
 * チェック
 */
function theme_options_validate( $input ) {
	global $dp_default_options, $font_type_options, $headline_font_type_options, $responsive_options, $load_icon_options, $load_time_options, $logo_type_options, $hover_type_options, $hover2_direct_options, $sns_type_top_options, $sns_type_btm_options, $header_content_type_options, $header_fix_options, $list_type_options, $post_order_options, $title_align_options, $page_link_options, $pickup_post_num_options, $related_post_num_options, $footer_blog_num_options, $slide_time_options, $footer_cta_type_options, $footer_bar_display_options, $footer_bar_icon_options, $footer_bar_button_options, $pw_align_options, $megamenu_options, $gmap_marker_type_options, $gmap_custom_marker_type_options,$tcd_font_manager;

	// 色の設定
	$input['primary_color'] = wp_filter_nohtml_kses( $input['primary_color'] );
	$input['secondary_color'] = wp_filter_nohtml_kses( $input['secondary_color'] );
	$input['link_color_hover'] = wp_filter_nohtml_kses( $input['link_color_hover'] );
	$input['content_color'] = wp_filter_nohtml_kses( $input['content_color'] );
	$input['content_link_color'] = wp_filter_nohtml_kses( $input['content_link_color'] );

	// ファビコン
	$input['favicon'] = wp_filter_nohtml_kses( $input['favicon'] );

	  // フォントリストのバリデーション
	  $input['font_list'] = San\repeater(
		$input['font_list'],
		function( $font_item ) use ( $tcd_font_manager ) {
		  return [
			'type'      => San\choice( $font_item['type'] ?? 'system', [ 'system', 'web' ] ),
			'weight'    => San\choice( $font_item['weight'] ?? 'normal', [ 'normal', 'bold' ] ),
			'japan'     => San\choice( $font_item['japan'] ?? '', array_keys( $tcd_font_manager->system_font_japan ) ),
			'latin'     => San\choice( $font_item['latin'] ?? '', array_keys( $tcd_font_manager->system_font_latin ) ),
			'web_japan' => San\choice( $font_item['web_japan'] ?? '', array_merge( [ '' ], array_keys( $tcd_font_manager->web_font_japan ) ) ),
			'web_latin' => San\choice( $font_item['web_latin'] ?? '', array_merge( [ '' ], array_keys( $tcd_font_manager->web_font_latin ) ) ),
		  ];
		}
		);

	// フォントの種類
	$input['font_type'] = San\choice( $input['font_type'], [ '1', '2', '3' ] );

	// 大見出しのフォントタイプ
	$input['headline_font_type'] = San\choice( $input['headline_font_type'], [ '1', '2', '3' ] );

	// 絵文字の設定
	$input['use_emoji'] = ! empty( $input['use_emoji'] ) ? 1 : 0;

	// クイックタグの設定
	$input['use_quicktags'] = ! empty( $input['use_quicktags'] ) ? 1 : 0;
	// レスポンシブの設定
	if ( ! isset( $input['responsive'] ) || ! array_key_exists( $input['responsive'], $responsive_options ) )
		$input['responsive'] = $dp_default_options['responsive'];

	// サイドバーの設定
	$input['sidebar_left'] = ! empty( $input['sidebar_left'] ) ? 1 : 0;

	// サイドメニューの設定
	$input['show_sidemenu'] = ! empty( $input['show_sidemenu'] ) ? 1 : 0;

	// ロード画面の設定
	$input['use_load_icon'] = ! empty( $input['use_load_icon'] ) ? 1 : 0;
	if ( ! isset( $input['load_icon'] ) || ! array_key_exists( $input['load_icon'], $load_icon_options ) )
		$input['load_icon'] = $dp_default_options['load_icon'];
	if ( ! isset( $input['load_time'] ) || ! array_key_exists( $input['load_time'], $load_time_options ) )
		$input['load_time'] = $dp_default_options['load_time'];
	$input['load_color1'] = wp_filter_nohtml_kses( $input['load_color1'] );
	$input['load_color2'] = wp_filter_nohtml_kses( $input['load_color2'] );

	// ホバーエフェクトの設定
	if ( ! isset( $input['hover_type'] ) || ! array_key_exists( $input['hover_type'], $hover_type_options ) )
		$input['hover_type'] = $dp_default_options['hover_type'];
	$input['hover1_zoom'] = wp_filter_nohtml_kses( $input['hover1_zoom'] );
	$input['hover1_rotate'] = ! empty( $input['hover1_rotate'] ) ? 1 : 0;
	$input['hover1_opacity'] = wp_filter_nohtml_kses( $input['hover1_opacity'] );
	$input['hover1_bgcolor'] = wp_filter_nohtml_kses( $input['hover1_bgcolor'] );
	if ( ! isset( $input['hover2_direct'] ) || ! array_key_exists( $input['hover2_direct'], $hover2_direct_options ) )
		$input['hover2_direct'] = $dp_default_options['hover2_direct'];
	$input['hover2_opacity'] = wp_filter_nohtml_kses( $input['hover2_opacity'] );
	$input['hover2_bgcolor'] = wp_filter_nohtml_kses( $input['hover2_bgcolor'] );
	$input['hover3_opacity'] = wp_filter_nohtml_kses( $input['hover3_opacity'] );
	$input['hover3_bgcolor'] = wp_filter_nohtml_kses( $input['hover3_bgcolor'] );

	// Facebook OGPの設定
	$input['use_ogp'] = ! empty( $input['use_ogp'] ) ? 1 : 0;
	$input['fb_app_id'] = wp_filter_nohtml_kses( $input['fb_app_id'] );
	$input['ogp_image'] = wp_filter_nohtml_kses( $input['ogp_image'] );

	// Twitter Cardsの設定
	$input['twitter_account_name'] = wp_filter_nohtml_kses( $input['twitter_account_name'] );

	// ソーシャルボタンの表示設定
	if ( ! isset( $input['sns_type_top'] ) || ! array_key_exists( $input['sns_type_top'], $sns_type_top_options ) )
		$input['sns_type_top'] = $dp_default_options['sns_type_top'];
	$input['show_sns_top'] = ! empty( $input['show_sns_top'] ) ? 1 : 0;
	$input['show_twitter_top'] = ! empty( $input['show_twitter_top'] ) ? 1 : 0;
	$input['show_fblike_top'] = ! empty( $input['show_fblike_top'] ) ? 1 : 0;
	$input['show_fbshare_top'] = ! empty( $input['show_fbshare_top'] ) ? 1 : 0;
	$input['show_hatena_top'] = ! empty( $input['show_hatena_top'] ) ? 1 : 0;
	$input['show_pocket_top'] = ! empty( $input['show_pocket_top'] ) ? 1 : 0;
	$input['show_feedly_top'] = ! empty( $input['show_feedly_top'] ) ? 1 : 0;
	$input['show_rss_top'] = ! empty( $input['show_rss_top'] ) ? 1 : 0;
	$input['show_pinterest_top'] = ! empty( $input['show_pinterest_top'] ) ? 1 : 0;

	if ( ! isset( $input['sns_type_btm'] ) || ! array_key_exists( $input['sns_type_btm'], $sns_type_btm_options ) )
		$input['sns_type_btm'] = $dp_default_options['sns_type_btm'];
	$input['show_sns_btm'] = ! empty( $input['show_sns_btm'] ) ? 1 : 0;
	$input['show_twitter_btm'] = ! empty( $input['show_twitter_btm'] ) ? 1 : 0;
	$input['show_fblike_btm'] = ! empty( $input['show_fblike_btm'] ) ? 1 : 0;
	$input['show_fbshare_btm'] = ! empty( $input['show_fbshare_btm'] ) ? 1 : 0;
	$input['show_hatena_btm'] = ! empty( $input['show_hatena_btm'] ) ? 1 : 0;
	$input['show_pocket_btm'] = ! empty( $input['show_pocket_btm'] ) ? 1 : 0;
	$input['show_feedly_btm'] = ! empty( $input['show_feedly_btm'] ) ? 1 : 0;
	$input['show_rss_btm'] = ! empty( $input['show_rss_btm'] ) ? 1 : 0;
	$input['show_pinterest_btm'] = ! empty( $input['show_pinterest_btm'] ) ? 1 : 0;

	// Google Maps
	$input['gmap_api_key'] = wp_filter_nohtml_kses( $input['gmap_api_key'] );
	if ( ! isset( $input['gmap_marker_type'] ) || ! array_key_exists( $input['gmap_marker_type'], $gmap_marker_type_options ) )
		$input['gmap_marker_type'] = $dp_default_options['gmap_marker_type'];
	if ( ! isset( $input['gmap_custom_marker_type'] ) || ! array_key_exists( $input['gmap_custom_marker_type'], $gmap_custom_marker_type_options ) )
		$input['gmap_custom_marker_type'] = $dp_default_options['gmap_custom_marker_type'];
	$input['gmap_marker_text'] = wp_filter_nohtml_kses( $input['gmap_marker_text'] );
	$input['gmap_marker_color'] = wp_filter_nohtml_kses( $input['gmap_marker_color'] );
	$input['gmap_marker_img'] = wp_filter_nohtml_kses( $input['gmap_marker_img'] );
	$input['gmap_marker_bg'] = wp_filter_nohtml_kses( $input['gmap_marker_bg'] );

	// オリジナルスタイルの設定
	$input['css_code'] = $input['css_code'];

	// Custom head/script
	$input['custom_head'] = $input['custom_head'];

	// ロゴのタイプ
	if ( ! isset( $input['use_logo_image'] ) || ! array_key_exists( $input['use_logo_image'], $logo_type_options ) )
		$input['use_logo_image'] = $dp_default_options['use_logo_image'];
	// ヘッダーのロゴ
	$input['logo_font_size'] = wp_filter_nohtml_kses( $input['logo_font_size'] );
	$input['header_logo_image'] = wp_filter_nohtml_kses( $input['header_logo_image'] );
	$input['header_logo_image_retina'] = ! empty( $input['header_logo_image_retina'] ) ? 1 : 0;

	// ヘッダーのロゴ（スマホ用）
	$input['logo_font_size_mobile'] = wp_filter_nohtml_kses( $input['logo_font_size_mobile'] );
	$input['header_logo_image_mobile'] = wp_filter_nohtml_kses( $input['header_logo_image_mobile'] );
	$input['header_logo_image_mobile_retina'] = ! empty( $input['header_logo_image_mobile_retina'] ) ? 1 : 0;

	// フッターのロゴ
	$input['footer_logo_font_size'] = wp_filter_nohtml_kses( $input['footer_logo_font_size'] );
	$input['footer_logo_font_size_mobile'] = wp_filter_nohtml_kses( $input['footer_logo_font_size_mobile'] );
	$input['footer_logo_image'] = wp_filter_nohtml_kses( $input['footer_logo_image'] );
	$input['footer_logo_image_retina'] = ! empty( $input['footer_logo_image_retina'] ) ? 1 : 0;

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	if ( ! isset( $input['header_content_type'] ) || ! array_key_exists( $input['header_content_type'], $header_content_type_options ) )
		$input['header_content_type'] = $dp_default_options['header_content_type'];
	if ( ! isset( $input['header_blog_list_type'] ) || ! array_key_exists( $input['header_blog_list_type'], $list_type_options ) )
		$input['header_blog_list_type'] = $dp_default_options['header_blog_list_type'];
	$input['header_blog_category'] = intval( $input['header_blog_category'] );
	$input['header_blog_num'] = intval( $input['header_blog_num'] );
	if ( ! isset( $input['header_blog_post_order'] ) || ! array_key_exists( $input['header_blog_post_order'], $post_order_options ) )
		$input['header_blog_post_order'] = $dp_default_options['header_blog_post_order'];
	$input['show_header_blog_date'] = ! empty( $input['show_header_blog_date'] ) ? 1 : 0;
	$input['show_header_blog_category'] = ! empty( $input['show_header_blog_category'] ) ? 1 : 0;
	$input['show_header_blog_views'] = ! empty( $input['show_header_blog_views'] ) ? 1 : 0;
	$input['show_header_blog_author'] = ! empty( $input['show_header_blog_author'] ) ? 1 : 0;
	$input['show_header_blog_native_ad'] = ! empty( $input['show_header_blog_native_ad'] ) ? 1 : 0;
	$input['header_blog_native_ad_position'] = intval( $input['header_blog_native_ad_position'] );

	for ( $i = 1; $i <= 3; $i++ ) {
		$input['slider_headline_font_size' . $i] = wp_filter_nohtml_kses( $input['slider_headline_font_size' . $i] );
		$input['slider_desc' . $i] = wp_filter_nohtml_kses( $input['slider_desc' . $i] );
		$input['slider_desc_font_size' . $i] = wp_filter_nohtml_kses( $input['slider_desc_font_size' . $i] );
		$input['slider_font_color' . $i] = wp_filter_nohtml_kses( $input['slider_font_color' . $i] );
		$input['slider' . $i . '_shadow1'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow1'] );
		$input['slider' . $i . '_shadow2'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow2'] );
		$input['slider' . $i . '_shadow3'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow3'] );
		$input['slider' . $i . '_shadow_color'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow_color'] );
		$input['display_slider_button' . $i] = ! empty( $input['display_slider_button' . $i] ) ? 1 : 0;
		$input['slider_button_label' . $i] = wp_filter_nohtml_kses( $input['slider_button_label' . $i] );
		$input['slider_button_font_color' . $i] = wp_filter_nohtml_kses( $input['slider_button_font_color' . $i] );
		$input['slider_button_bg_color' . $i] = wp_filter_nohtml_kses( $input['slider_button_bg_color' . $i] );
		$input['slider_button_font_color_hover' . $i] = wp_filter_nohtml_kses( $input['slider_button_font_color_hover' . $i] );
		$input['slider_button_bg_color_hover' . $i] = wp_filter_nohtml_kses( $input['slider_button_bg_color_hover' . $i] );
		$input['slider_url' . $i] = wp_filter_nohtml_kses( $input['slider_url' . $i] );
		$input['slider_target' . $i] = ! empty( $input['slider_target' . $i] ) ? 1 : 0;
		$input['slider_image' . $i] = wp_filter_nohtml_kses( $input['slider_image' . $i] );
		$input['slider_native_ad_label' . $i] = wp_filter_nohtml_kses( $input['slider_native_ad_label' . $i] );
	}
	if ( ! isset( $input['slide_time'] ) || ! array_key_exists( $input['slide_time'], $slide_time_options ) )
		$input['slide_time'] = $dp_default_options['slide_time'];
	$input['video'] = wp_filter_nohtml_kses( $input['video'] );
	$input['video_image'] = wp_filter_nohtml_kses( $input['video_image'] );
	$input['video_image_hide'] = ! empty( $input['video_image_hide'] ) ? 1 : 0;
	$input['youtube_url'] = wp_filter_nohtml_kses( $input['youtube_url'] );
	$input['youtube_image'] = wp_filter_nohtml_kses( $input['youtube_image'] );
	$input['youtube_image_hide'] = ! empty( $input['youtube_image_hide'] ) ? 1 : 0;

	// トップページの動画用キャッチフレーズ
	$input['use_video_catch'] = ! empty( $input['use_video_catch'] ) ? 1 : 0;
	$input['video_catch'] = wp_filter_nohtml_kses( $input['video_catch'] );
	$input['video_catch_font_size'] = wp_filter_nohtml_kses( $input['video_catch_font_size'] );
	$input['video_desc'] = wp_filter_nohtml_kses( $input['video_desc'] );
	$input['video_desc_font_size'] = wp_filter_nohtml_kses( $input['video_desc_font_size'] );
	$input['video_catch_color'] = wp_filter_nohtml_kses( $input['video_catch_color'] );
	$input['video_catch_shadow1'] = wp_filter_nohtml_kses( $input['video_catch_shadow1'] );
	$input['video_catch_shadow2'] = wp_filter_nohtml_kses( $input['video_catch_shadow2'] );
	$input['video_catch_shadow3'] = wp_filter_nohtml_kses( $input['video_catch_shadow3'] );
	$input['video_catch_shadow_color'] = wp_filter_nohtml_kses( $input['video_catch_shadow_color'] );
	$input['show_video_catch_button'] = ! empty( $input['show_video_catch_button'] ) ? 1 : 0;
	$input['video_catch_button'] = wp_filter_nohtml_kses( $input['video_catch_button'] );
	$input['video_button_font_color'] = wp_filter_nohtml_kses( $input['video_button_font_color'] );
	$input['video_button_font_color_hover'] = wp_filter_nohtml_kses( $input['video_button_font_color_hover'] );
	$input['video_button_bg_color'] = wp_filter_nohtml_kses( $input['video_button_bg_color'] );
	$input['video_button_bg_color_hover'] = wp_filter_nohtml_kses( $input['video_button_bg_color_hover'] );
	$input['video_button_url'] = wp_filter_nohtml_kses( $input['video_button_url'] );
	$input['video_button_target'] = ! empty( $input['video_button_target'] ) ? 1 : 0;

	// フリースペース
	$input['index_editor'] = $input['index_editor']; // HTML対応

	// トップページコンテンツの設定
	for ( $i = 1; $i <= 4; $i++ ) {
		$input['show_index_tab' . $i] = ! empty( $input['show_index_tab' . $i] ) ? 1 : 0;
		$input['index_tab_label' . $i] = wp_filter_nohtml_kses( $input['index_tab_label' . $i] );
		$input['show_index_tab_editor' . $i] = ! empty( $input['show_index_tab_editor' . $i] ) ? 1 : 0;
		$input['index_tab_editor' . $i] = $input['index_tab_editor' . $i]; // HTML対応
		if ( ! isset( $input['index_tab_list_type' . $i] ) || ! array_key_exists( $input['index_tab_list_type' . $i], $list_type_options ) )
			$input['index_tab_list_type' . $i] = $dp_default_options['index_tab_list_type' . $i];
		$input['index_tab_category' . $i] = intval( $input['index_tab_category' . $i] );
		$input['index_tab_post_num' . $i] = intval( $input['index_tab_post_num' . $i] );
		if ( 1 > $input['index_tab_post_num' . $i] )
			$input['index_tab_post_num' . $i] = $dp_default_options['index_tab_post_num' . $i];
		if ( ! isset( $input['index_tab_post_order' . $i] ) || ! array_key_exists( $input['index_tab_post_order' . $i], $post_order_options ) )
			$input['index_tab_post_order' . $i] = $dp_default_options['index_tab_post_order' . $i];
		$input['show_index_tab_large' . $i] = ! empty( $input['show_index_tab_large' . $i] ) ? 1 : 0;
		$input['use_index_tab_sticky' . $i] = ! empty( $input['use_index_tab_sticky' . $i] ) ? 1 : 0;
		$input['show_index_tab_native_ad' . $i] = ! empty( $input['show_index_tab_native_ad' . $i] ) ? 1 : 0;
		$input['index_tab_native_ad_position' . $i] = intval( $input['index_tab_native_ad_position' . $i] );
	}

	/**
	 * ブログ
	 */
	 // ブログの設定
	$input['blog_breadcrumb_label'] = wp_filter_nohtml_kses( $input['blog_breadcrumb_label'] );

	// アーカイブページヘッダーの設定
	$input['archive_image'] = wp_filter_nohtml_kses( $input['archive_image'] );
	$input['archive_overlay'] = wp_filter_nohtml_kses( $input['archive_overlay'] );
	$input['archive_overlay_opacity'] = wp_filter_nohtml_kses( $input['archive_overlay_opacity'] );
	$input['archive_catchphrase'] = wp_filter_nohtml_kses( $input['archive_catchphrase'] );
	$input['archive_desc'] = wp_filter_nohtml_kses( $input['archive_desc'] );
	$input['archive_catchphrase_font_size'] = wp_filter_nohtml_kses( $input['archive_catchphrase_font_size'] );
	$input['archive_desc_font_size'] = wp_filter_nohtml_kses( $input['archive_desc_font_size'] );
	$input['archive_color'] = wp_filter_nohtml_kses( $input['archive_color'] );
	$input['archive_shadow1'] = wp_filter_nohtml_kses( $input['archive_shadow1'] );
	$input['archive_shadow2'] = wp_filter_nohtml_kses( $input['archive_shadow2'] );
	$input['archive_shadow3'] = wp_filter_nohtml_kses( $input['archive_shadow3'] );
	$input['archive_shadow_color'] = wp_filter_nohtml_kses( $input['archive_shadow_color'] );

	// アーカイブページ ネイティブ広告の設定
	$input['show_archive_native_ad'] = ! empty( $input['show_archive_native_ad'] ) ? 1 : 0;
	$input['show_category_archive_native_ad'] = ! empty( $input['show_category_archive_native_ad'] ) ? 1 : 0;
	$input['show_tag_archive_native_ad'] = ! empty( $input['show_tag_archive_native_ad'] ) ? 1 : 0;
	$input['show_date_archive_native_ad'] = ! empty( $input['show_date_archive_native_ad'] ) ? 1 : 0;
	$input['show_author_archive_native_ad'] = ! empty( $input['show_author_archive_native_ad'] ) ? 1 : 0;
	$input['show_search_archive_native_ad'] = ! empty( $input['show_search_archive_native_ad'] ) ? 1 : 0;
	$input['archive_native_ad_position'] = intval( $input['archive_native_ad_position'] );

	// 記事ページの設定
	$input['title_font_size'] = wp_filter_nohtml_kses( $input['title_font_size'] );
	$input['content_font_size'] = wp_filter_nohtml_kses( $input['content_font_size'] );
	if ( ! isset( $input['title_align'] ) || ! array_key_exists( $input['title_align'], $title_align_options ) )
		$input['title_align'] = $dp_default_options['title_align'];
	if ( ! isset( $input['page_link'] ) || ! array_key_exists( $input['page_link'], $page_link_options ) )
		$input['page_link'] = $dp_default_options['page_link'];

	// 表示設定
	$input['show_views'] = ! empty( $input['show_views'] ) ? 1 : 0;
	$input['show_thumbnail'] = ! empty( $input['show_thumbnail'] ) ? 1 : 0;
	$input['show_date'] = ! empty( $input['show_date'] ) ? 1 : 0;
	$input['show_category'] = ! empty( $input['show_category'] ) ? 1 : 0;
	$input['show_archive_author'] = ! empty( $input['show_archive_author'] ) ? 1 : 0;
	$input['show_author'] = ! empty( $input['show_author'] ) ? 1 : 0;
	$input['show_author_views'] = ! empty( $input['show_author_views'] ) ? 1 : 0;
	$input['show_next_post'] = ! empty( $input['show_next_post'] ) ? 1 : 0;
	$input['show_comment'] = ! empty( $input['show_comment'] ) ? 1 : 0;
	$input['show_trackback'] = ! empty( $input['show_trackback'] ) ? 1 : 0;

	// ピックアップ記事の設定
	$input['show_pickup_post'] = ! empty( $input['show_pickup_post'] ) ? 1 : 0;
	$input['pickup_post_headline'] = wp_filter_nohtml_kses( $input['pickup_post_headline'] );
	if ( ! isset( $input['pickup_post_num'] ) || ! array_key_exists( $input['pickup_post_num'], $pickup_post_num_options ) )
		$input['pickup_post_num'] = $dp_default_options['pickup_post_num'];
	$input['show_pickup_post_native_ad'] = ! empty( $input['show_pickup_post_native_ad'] ) ? 1 : 0;
	$input['pickup_post_native_ad_position'] = intval( $input['pickup_post_native_ad_position'] );

	// 関連記事の設定
	$input['show_related_post'] = ! empty( $input['show_related_post'] ) ? 1 : 0;
	$input['related_post_headline'] = wp_filter_nohtml_kses( $input['related_post_headline'] );
	if ( ! isset( $input['related_post_num'] ) || ! array_key_exists( $input['related_post_num'], $related_post_num_options ) )
		$input['related_post_num'] = $dp_default_options['related_post_num'];
	$input['show_related_post_native_ad'] = ! empty( $input['show_related_post_native_ad'] ) ? 1 : 0;
	$input['related_post_native_ad_position'] = intval( $input['related_post_native_ad_position'] );

	// 記事ページの広告設定1, 2
	for ( $i = 1; $i <= 4; $i++ ) {
		$input['single_ad_code' . $i] = $input['single_ad_code' . $i];
		$input['single_ad_image' . $i] = wp_filter_nohtml_kses( $input['single_ad_image' . $i] );
		$input['single_ad_url' . $i] = wp_filter_nohtml_kses( $input['single_ad_url' . $i] );
	}
	// スマートフォン専用の広告
	$input['single_mobile_ad_code1'] = $input['single_mobile_ad_code1'];
	$input['single_mobile_ad_image1'] = wp_filter_nohtml_kses( $input['single_mobile_ad_image1'] );
	$input['single_mobile_ad_url1'] = wp_filter_nohtml_kses( $input['single_mobile_ad_url1'] );

	// ヘッダーバーの表示位置
	if ( ! isset( $input['header_fix'] ) || ! array_key_exists( $input['header_fix'], $header_fix_options ) )
		$input['header_fix'] = $dp_default_options['header_fix'];

	// ヘッダーバーの表示位置（スマホ）
	if ( ! isset( $input['mobile_header_fix'] ) || ! array_key_exists( $input['mobile_header_fix'], $header_fix_options ) )
		$input['mobile_header_fix'] = $dp_default_options['mobile_header_fix'];

	// ヘッダーバーの色の設定
	$input['header_bg'] = wp_filter_nohtml_kses( $input['header_bg'] );
	$input['header_opacity'] = wp_filter_nohtml_kses( $input['header_opacity'] );
	$input['header_font_color'] = wp_filter_nohtml_kses( $input['header_font_color'] );

	// ヘッダー検索
	$input['show_header_search'] = wp_filter_nohtml_kses( $input['show_header_search'] );

	// フッターブログコンテンツの設定
	$input['show_footer_blog_top'] = ! empty( $input['show_footer_blog_top'] ) ? 1 : 0;
	$input['show_footer_blog'] = ! empty( $input['show_footer_blog'] ) ? 1 : 0;
	$input['footer_blog_catchphrase'] = wp_filter_nohtml_kses( $input['footer_blog_catchphrase'] );
	$input['footer_blog_catchphrase_font_size'] = wp_filter_nohtml_kses( $input['footer_blog_catchphrase_font_size'] );
	if ( ! isset( $input['footer_blog_list_type'] ) || ! array_key_exists( $input['footer_blog_list_type'], $list_type_options ) )
		$input['footer_blog_list_type'] = $dp_default_options['footer_blog_list_type'];
	$input['footer_blog_category'] = intval( $input['footer_blog_category'] );
	if ( ! isset( $input['footer_blog_num'] ) || ! array_key_exists( $input['footer_blog_num'], $footer_blog_num_options ) )
		$input['footer_blog_num'] = $dp_default_options['footer_blog_num'];
	if ( ! isset( $input['footer_blog_post_order'] ) || ! array_key_exists( $input['footer_blog_post_order'], $post_order_options ) )
		$input['footer_blog_post_order'] = $dp_default_options['footer_blog_post_order'];
	$input['show_footer_blog_date'] = ! empty( $input['show_footer_blog_date'] ) ? 1 : 0;
	$input['show_footer_blog_category'] = ! empty( $input['show_footer_blog_category'] ) ? 1 : 0;
	$input['show_footer_blog_views'] = ! empty( $input['show_footer_blog_views'] ) ? 1 : 0;
	$input['show_footer_blog_author'] = ! empty( $input['show_footer_blog_author'] ) ? 1 : 0;
	$input['show_footer_blog_native_ad'] = ! empty( $input['show_footer_blog_native_ad'] ) ? 1 : 0;
	$input['footer_blog_native_ad_position'] = intval( $input['footer_blog_native_ad_position'] );
	if ( ! isset( $input['footer_blog_slide_time'] ) || ! array_key_exists( $input['footer_blog_slide_time'], $slide_time_options ) )
		$input['footer_blog_slide_time'] = $dp_default_options['footer_blog_slide_time'];

	// フッターCTAの設定
	$input['show_footer_cta_top'] = ! empty( $input['show_footer_cta_top'] ) ? 1 : 0;
	$input['show_footer_cta'] = ! empty( $input['show_footer_cta'] ) ? 1 : 0;
	if ( ! isset( $input['footer_cta_type'] ) || ! array_key_exists( $input['footer_cta_type'], $footer_cta_type_options ) )
		$input['footer_cta_type'] = $dp_default_options['footer_cta_type'];
	$input['footer_cta_catch'] = $input['footer_cta_catch']; // HTML対応
	$input['footer_cta_catch_font_size'] = wp_filter_nohtml_kses( $input['footer_cta_catch_font_size'] );
	$input['footer_cta_desc'] = $input['footer_cta_desc']; // HTML対応
	$input['footer_cta_desc_font_size'] = wp_filter_nohtml_kses( $input['footer_cta_desc_font_size'] );
	$input['footer_cta_btn_label'] = wp_filter_nohtml_kses( $input['footer_cta_btn_label'] );
	$input['footer_cta_btn_url'] = wp_filter_nohtml_kses( $input['footer_cta_btn_url'] );
	$input['footer_cta_btn_target'] = ! empty( $input['footer_cta_btn_target'] ) ? 1 : 0;
	$input['footer_cta_btn_color'] = wp_filter_nohtml_kses( $input['footer_cta_btn_color'] );
	$input['footer_cta_btn_bg'] = wp_filter_nohtml_kses( $input['footer_cta_btn_bg'] );
	$input['footer_cta_btn_color_hover'] = wp_filter_nohtml_kses( $input['footer_cta_btn_color_hover'] );
	$input['footer_cta_btn_bg_hover'] = wp_filter_nohtml_kses( $input['footer_cta_btn_bg_hover'] );
	$input['footer_cta_image'] = wp_filter_nohtml_kses( $input['footer_cta_image'] );
	$input['footer_cta_image_sp'] = wp_filter_nohtml_kses( $input['footer_cta_image_sp'] );
	$input['footer_cta_overlay'] = wp_filter_nohtml_kses( $input['footer_cta_overlay'] );
	$input['footer_cta_overlay_opacity'] = wp_filter_nohtml_kses( $input['footer_cta_overlay_opacity'] );
	$input['footer_cta_editor'] = $input['footer_cta_editor']; // HTML対応

	// SNSボタンの設定
	$input['footer_instagram_url'] = wp_filter_nohtml_kses( $input['footer_instagram_url'] );
	$input['footer_twitter_url'] = wp_filter_nohtml_kses( $input['footer_twitter_url'] );
	$input['footer_tiktok_url'] = wp_filter_nohtml_kses( $input['footer_tiktok_url'] );
	$input['footer_pinterest_url'] = wp_filter_nohtml_kses( $input['footer_pinterest_url'] );
	$input['footer_facebook_url'] = wp_filter_nohtml_kses( $input['footer_facebook_url'] );
	$input['footer_youtube_url'] = wp_filter_nohtml_kses( $input['footer_youtube_url'] );
	$input['footer_contact_url'] = wp_filter_nohtml_kses( $input['footer_contact_url'] );
	$input['footer_show_rss'] = ! empty( $input['footer_show_rss'] ) ? 1 : 0;

	// スマホ用固定フッターバーの設定
	if ( ! array_key_exists( $input['footer_bar_display'], $footer_bar_display_options ) ) $input['footer_bar_display'] = 'type3';
	$input['footer_bar_bg'] = wp_filter_nohtml_kses( $input['footer_bar_bg'] );
	$input['footer_bar_border'] = wp_filter_nohtml_kses( $input['footer_bar_border'] );
	$input['footer_bar_color'] = wp_filter_nohtml_kses( $input['footer_bar_color'] );
	$input['footer_bar_tp'] = wp_filter_nohtml_kses( $input['footer_bar_tp'] );
	$footer_bar_btns = array();
	if ( empty( $input['repeater_footer_bar_btns'] ) && ! empty( $input['footer_bar_btns'] ) && is_array( $input['footer_bar_btns'] ) ) {
		$input['repeater_footer_bar_btns'] = $input['footer_bar_btns'];
	}
	if ( isset( $input['repeater_footer_bar_btns'] ) ) {
		foreach ( $input['repeater_footer_bar_btns'] as $key => $value ) {
			$footer_bar_btns[] = array(
				'type' => ( isset( $input['repeater_footer_bar_btns'][$key]['type'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['type'], $footer_bar_button_options ) ) ? $input['repeater_footer_bar_btns'][$key]['type'] : 'type1',
				'label' => isset( $input['repeater_footer_bar_btns'][$key]['label'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['label'] ) : '',
				'url' => isset( $input['repeater_footer_bar_btns'][$key]['url'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['url'] ) : '',
				'number' => isset( $input['repeater_footer_bar_btns'][$key]['number'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['number'] ) : '',
				'target' => ! empty( $input['repeater_footer_bar_btns'][$key]['target'] ) ? 1 : 0,
				'icon' => ( isset( $input['repeater_footer_bar_btns'][$key]['icon'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['icon'], $footer_bar_icon_options ) ) ? $input['repeater_footer_bar_btns'][$key]['icon'] : 'file-text'
			);
		}
		unset( $input['repeater_footer_bar_btns'] );
	}
	$input['footer_bar_btns'] = $footer_bar_btns;

	// 404 ページ
	$input['image_404'] = wp_filter_nohtml_kses( $input['image_404'] );
	$input['overlay_404'] = wp_filter_nohtml_kses( $input['overlay_404'] );
	$input['overlay_opacity_404'] = wp_filter_nohtml_kses( $input['overlay_opacity_404'] );
	$input['catchphrase_404'] = wp_filter_nohtml_kses( $input['catchphrase_404'] );
	$input['desc_404'] = wp_filter_nohtml_kses( $input['desc_404'] );
	$input['catchphrase_font_size_404'] = wp_filter_nohtml_kses( $input['catchphrase_font_size_404'] );
	$input['desc_font_size_404'] = wp_filter_nohtml_kses( $input['desc_font_size_404'] );
	$input['color_404'] = wp_filter_nohtml_kses( $input['color_404'] );
	$input['shadow1_404'] = wp_filter_nohtml_kses( $input['shadow1_404'] );
	$input['shadow2_404'] = wp_filter_nohtml_kses( $input['shadow2_404'] );
	$input['shadow3_404'] = wp_filter_nohtml_kses( $input['shadow3_404'] );
	$input['shadow_color_404'] = wp_filter_nohtml_kses( $input['shadow_color_404'] );

	// ネイティブ広告
	$input['native_ad_label_font_size'] = intval( $input['native_ad_label_font_size'] );
	$input['native_ad_label_text_color'] = wp_filter_nohtml_kses( $input['native_ad_label_text_color'] );
	$input['native_ad_label_bg_color'] = wp_filter_nohtml_kses( $input['native_ad_label_bg_color'] );

	for ( $i = 1; $i <= 6; $i++ ) {
		$input['native_ad_title' . $i] = $input['native_ad_title'.$i];
		$input['native_ad_image' . $i] = wp_filter_nohtml_kses( $input['native_ad_image'.$i] );
		$input['native_ad_url' . $i] = wp_filter_nohtml_kses( $input['native_ad_url'.$i] );
		$input['native_ad_label' . $i] = $input['native_ad_label'.$i];
	}

	// 保護ページ
	$input['pw_label'] = wp_filter_nohtml_kses( $input['pw_label'] );
	if ( ! isset( $input['pw_align'] ) || ! array_key_exists( $input['pw_align'], $pw_align_options ) )
		$input['pw_align'] = $dp_default_options['pw_align'];
	for ( $i = 1; $i <= 5; $i++ ) {
		$input['pw_name' . $i] = wp_filter_nohtml_kses( $input['pw_name' . $i] );
		$input['pw_btn_display' . $i] = ! empty( $input['pw_btn_display' . $i] ) ? 1 : 0;
		$input['pw_btn_label' . $i] = wp_filter_nohtml_kses( $input['pw_btn_label' . $i] );
		$input['pw_btn_url' . $i] = wp_filter_nohtml_kses( $input['pw_btn_url' . $i] );
		$input['pw_btn_target' . $i] = ! empty( $input['pw_btn_target' . $i] ) ? 1 : 0;
		$input['pw_editor' . $i] = $input['pw_editor' . $i];
	}

	return $input;
}


/**
 * オプションTools エクスポート・インポート・リセット 実行
 */
function theme_options_tools() {
	global $pagenow;

	// テーマオプションサブミット先はoptions.php
	if ( 'options.php' != $pagenow ) return;

	// TCDテーマオプションサブミットチェック
	if ( empty( $_POST['option_page'] ) || 'design_plus_options' !== $_POST['option_page'] || empty( $_POST['dp_options'] ) ) return;

	// エクスポート
	if ( ! empty( $_POST['tcd-tools-export'] ) ) {
		// 現設定取得
		if ( function_exists( 'get_design_plus_options' ) ) {
			$dp_options = get_design_plus_options();
		} elseif ( function_exists( 'get_design_plus_option' ) ) {
			$dp_options = get_design_plus_option();
		} elseif ( function_exists( 'get_desing_plus_options' ) ) {
			$dp_options = get_desing_plus_options();
		} elseif ( function_exists( 'get_desing_plus_option' ) ) {
			$dp_options = get_desing_plus_option();
		} else {
			$dp_options = array();
		}


		// postされた設定取得して現設定にマージ
		if ( ! empty( $_POST['dp_options'] ) ) {
			$dp_options_posted = wp_unslash( $_POST['dp_options'] );
			// バリデート
			$dp_options_posted = theme_options_validate( $dp_options_posted );
			// マージ
			$dp_options = array_merge( $dp_options, $dp_options_posted );
		}

		// エクスポート設定フィルター
		$dp_options = apply_filters( 'tcd_theme_options_tools-export', $dp_options );

		// ファイル名
		$filename = implode( '-', array(
			'tcd_theme_options',
			'export',
			get_bloginfo( 'name' ),
			wp_get_theme()->get( 'Name' ),
			date( 'Ymd', current_time('timestamp' ) )
		) ) . '.json';

		// json出力
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="' . rawurlencode( $filename ) . '"');
		if ( defined('JSON_PRETTY_PRINT') ) {
			echo json_encode( $dp_options, JSON_PRETTY_PRINT );
		} else {
			echo json_encode( $dp_options );
		}
		exit();

	// インポート
	} elseif ( ! empty( $_POST['tcd-tools-import'] ) ) {
		$json = _theme_options_tools_get_import_json();
		if ( is_numeric( $json ) ) {
			$import_error = $json;
		} elseif ( ! is_array( $json ) ) {
			$import_error = 15;
		} else {
			// 現設定取得
			if ( function_exists( 'get_design_plus_options' ) ) {
				$dp_options = get_design_plus_options();
			} elseif ( function_exists( 'get_design_plus_option' ) ) {
				$dp_options = get_design_plus_option();
			} elseif ( function_exists( 'get_desing_plus_options' ) ) {
				$dp_options = get_desing_plus_options();
			} elseif ( function_exists( 'get_desing_plus_option' ) ) {
				$dp_options = get_desing_plus_option();
			} else {
				$dp_options = array();
			}

			// 現設定にインポート設定マージ
			// jsonファイルを任意編集・部分インポートの場合を考慮してここではバリデートは行わない
			$dp_options = array_merge( $dp_options, $json );

			// インポート設定フィルター
			$dp_options = apply_filters( 'tcd_theme_options_tools-import', $dp_options );

			// 保存
			update_option( 'dp_options', $dp_options );
		}

		// エラーリダイレクト先
		if ( ! empty( $import_error ) ) {
			$redirect = add_query_arg( 'tcd-tools-result', 'import-error' . $import_error, wp_get_referer() );

		// 成功リダイレクト先
		} else {
			$redirect = add_query_arg( 'tcd-tools-result', 'import-success', wp_get_referer() );
		}

	// リセット
	} elseif ( ! empty( $_POST['tcd-tools-reset'] ) ) {
		// デフォルト設定取得
		global $dp_default_options;
		if ( $dp_default_options && is_array( $dp_default_options ) ) {
			$dp_options = $dp_default_options;
		} else {
			$dp_options = array();
		}

		// リセットデフォルト設定フィルター
		$dp_options = apply_filters( 'tcd_theme_options_tools-reset-default_options', $dp_options );

		// リセット設定フィルター
		$dp_options = apply_filters( 'tcd_theme_options_tools-reset', $dp_options );

		// テーマ初期化があれば上書きモードで実行
		if ( function_exists( 'theme_options_tools_initialize' ) ) {
			theme_options_tools_initialize( $dp_options, true, true );
		} else {
			// 保存 ここでtheme_options_validateが実行されるので値には注意
			update_option( 'dp_options', $dp_options );
		}


		// リダイレクト先
		$redirect = add_query_arg( 'tcd-tools-result', 'reset-success', wp_get_referer() );
	}

	// リダイレクト
	if ( ! empty( $redirect ) ) {
		// 保存メッセージが残っている場合があるので削除
		wp_redirect( remove_query_arg( 'settings-updated', $redirect ) );
		exit();
	}
}
add_action( 'admin_init', 'theme_options_tools' );

/**
 * オプションTools jsonインポート
 */
function _theme_options_tools_get_import_json() {
	if ( empty( $_FILES['tcd-tools-import-file'] ) ) {
		return 11;
	}

	$uploaded_file = $_FILES['tcd-tools-import-file'];

	if ( ! isset( $uploaded_file['tmp_name'], $uploaded_file['name'] ) ) {
		return 12;
	} elseif ( isset( $uploaded_file['error'] ) && 0 < $uploaded_file['error'] ) {
		return $uploaded_file['error'];
	}

	$wp_filetype = wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'], array( 'json' => 'application/json' ) );
	if ( ! wp_match_mime_types( 'json', $wp_filetype['type'] ) ) {
		return 13;
	}

	$file_contents = file_get_contents( $uploaded_file['tmp_name'] );

	if ( ! $file_contents ) {
		return 14;
	}

	$json = json_decode( $file_contents, true );

	if ( ! $json ) {
		return 15;
	}

	return $json;
}

/**
 * オプションToolsメッセージ
 */
function theme_options_tools_notices() {
	// TCDテーマオプションページ以外なら終了
	if ( empty( $_GET['page'] ) || 'theme_options' !== $_GET['page'] ) return false;

	// メッセージクエリー文字列が無ければ終了
	if ( empty( $_GET['tcd-tools-result'] ) ) return false;

	// メッセージクエリー文字列を配列化
	$tools_result = explode( '-', $_GET['tcd-tools-result'] );

	// インポートエラーメッセージ
	if ( isset( $tools_result[0], $tools_result[1] ) && 'import' === $tools_result[0] && 'error' === $tools_result[1] ) {
		$message = '';

		if ( isset( $tools_result[2] ) ) {
			$int_import_error = intval( $tools_result[2] );
			switch( $int_import_error ) {
				// 1-4, 5-8はファイルアップロード時のエラーコード
				case 1:
					$message = $int_import_error . ' : ' . __( 'The uploaded file exceeds the upload_max_filesize directive in php.ini.' );
					break;
				case 2:
					$message = $int_import_error . ' : ' . __( 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.' );
					break;
				case 3:
					$message = $int_import_error . ' : ' . __( 'The uploaded file was only partially uploaded.' );
					break;
				case 4:
					$message = $int_import_error . ' : ' . __( 'No file was uploaded.' );
					break;
				case 6:
					$message = $int_import_error . ' : ' . __( 'Missing a temporary folder.' );
					break;
				case 7:
					$message = $int_import_error . ' : ' . __( 'Failed to write file to disk.' );
					break;
				case 8:
					$message = $int_import_error . ' : ' . __( 'File upload stopped by extension.' );
					break;
				case 11:
                  $message = $int_import_error . ' : ' . __( 'File has not been uploaded.', 'tcd-w' );
					break;
				case 12:
                  $message = $int_import_error . ' : ' . __( 'There is no file', 'tcd-w' );
					break;
				case 13:
                  $message = $int_import_error . ' : ' . __( 'The file extension is not .json', 'tcd-w' );
					break;
				case 14:
                  $message = $int_import_error . ' : ' . __( 'Failed to read the file', 'tcd-w' );
					break;
				case 15:
                    $message = $int_import_error . ' : ' . __( 'Json decoding failed', 'tcd-w' );
					break;
				default :
					$message = esc_html( $_GET['import-error'] );
					break;
			}
		}

		echo '<div class="update-message notice notice-error notice-alt"><p><strong>' . sprintf( __( 'Import error. %s', 'tcd-w' ), $message ) . '</strong></p></div>';

	// インポート成功メッセージ
	} elseif ( isset( $tools_result[0], $tools_result[1] ) && 'import' === $tools_result[0] && 'success' === $tools_result[1] ) {
        echo '<div class="updated"><p><strong>' . __( 'Settings imported', 'tcd-w' ) . '</strong></p></div>';

	// リセット成功メッセージ
	} elseif ( isset( $tools_result[0], $tools_result[1] ) && 'reset' === $tools_result[0] && 'success' === $tools_result[1] ) {
        echo '<div class="updated"><p><strong>' . __( 'Settings reset', 'tcd-w' ) . '</strong></p></div>';
	}
}

/**
 * オプションToolsメッセージのクエリー文字列自動削除
 */
function theme_options_tools_removable_query_args( $removable_query_args ) {
	$removable_query_args[] = 'tcd-tools-result';
	return $removable_query_args;
}
add_filter( 'removable_query_args', 'theme_options_tools_removable_query_args' );

/**
 * オプションTools デフォルト画像設定取得
 */
function theme_options_tools_get_default_images_settings() {
	// デフォルト画像設定
	$default_images_settings = array(
/*
		array(
			// 保存するファイル名 既存メディアの検索に使用するのでユニークなファイル名が望ましい
			// 未指定の場合はコピー元ファイル名が使用されます
			'media_filename' => 'op_1450x150.jpg',

			// コピー元のファイルパス
			'source_filepath' => get_template_directory() . '/img/op_default/op_1450x150.jpg',

			// 適用するテーマオプションキー
			// リピーター等の配列の場合は"['repeater'][0]['image']"のように指定
			'theme_option_keys' => array( 'slider_image1', 'index_content01_image' )
*/
	);

	$default_images_settings = apply_filters( 'tcd_theme_options_tools-get_default_images_settings', $default_images_settings );

	if ( ! $default_images_settings )
		return false;

	return $default_images_settings;
}

/**
 * オプションTools デフォルト画像をメディアに登録した分のテーマオプション配列を返す
 */
function theme_options_tools_get_default_images_options( $a = array() ) {
	// デフォルト画像設定取得
	$default_images_settings = theme_options_tools_get_default_images_settings();

	if ( ! $default_images_settings )
		return $a;

	// 引数チェック
	if ( ! $a || ! is_array( $a ) )
		$a = array();

	// デフォルト画像設定をループ
	foreach ( $default_images_settings as $key => &$value ) {
		// 既存メディアを検索しメディアID取得
		// なければ挿入しメディアID取得
		$attachment_id = theme_options_tools_get_media_id( $value, true );
		if ( $attachment_id )
			$value['attachment_id'] = $attachment_id;

		// テーマオプションに代入
		if ( $attachment_id && ! empty( $value['theme_option_keys'] ) ) {
			foreach ( (array) $value['theme_option_keys'] as $theme_option_key ) {
				// []で囲まれている場合はevalで無理矢理代入
				if ( '[' === substr( $theme_option_key, 0, 1 ) && ']' === substr( $theme_option_key, -1 ) ) {
					eval( '$a' . $theme_option_key . ' = ' . $value['attachment_id'] . ';' );
				} elseif ( empty( $a[$theme_option_key] ) ) {
					$a[$theme_option_key] = $attachment_id;
				}
			}
		}
	}

	return apply_filters( 'tcd_theme_options_tools-get_default_images_array', $a );
}

/**
 * オプションTools メディアからファイル名で検索しメディアidを返す
 */
function theme_options_tools_get_media_id( $a = array(), $not_found_insert = false ) {
	// 文字列の場合はコピー元ファイル扱い
	if ( is_string( $a ) )
		$a = array( 'source_filepath' => $a );

	// 必要ファイルインクルード
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	// アップロード用ディレクトリのパスを取得
	$wp_upload_dir = wp_upload_dir();

	// 既存メディア検索用SQL
	global $wpdb;
	$sql = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid LIKE %s";

	// WPファイルシステム
	global $wp_filesystem;
	$can_wp_filesystem = WP_Filesystem();

	// コピー元ファイルが未設定もしくは存在しない場合は終了
	if ( empty( $a['source_filepath'] ) || ! file_exists( $a['source_filepath'] ) )
		return false;

	// 検索用ファイル名が未設定の場合はコピー元からファイル名取得
	if ( empty( $a['media_filename'] ) )
		$a['media_filename'] = basename( $a['source_filepath'] );

	// 既存メディアをファイル名で後方一致検索
	$attachment_id = $wpdb->get_var( $wpdb->prepare( $sql, '%/'.$wpdb->esc_like( $a['media_filename'] ) ) ) ;

	// 既存メディアあり
	if ( $attachment_id ) {
		return (int) $attachment_id;

	// 既存メディアなしでインサートフラグあり
	} elseif ( $not_found_insert ) {
		// メディアパス・URL
		$file_path = $wp_upload_dir['path'] . '/' . $a['media_filename'];
		$file_url = $wp_upload_dir['url'] . '/' . $a['media_filename'];

		if ( $can_wp_filesystem ) {
			// アップロード用ディレクトリに上書きコピー
			$wp_filesystem->copy( $a['source_filepath'], $file_path, true, FS_CHMOD_FILE);

			// コピー失敗等でファイルが無い場合は終了
			if ( ! $wp_filesystem->exists( $file_path ) )
				return false;

		} else {
			// アップロード用ディレクトリに上書きコピー
			@copy( $a['source_filepath'], $file_path );

			// コピー失敗等でファイルが無い場合は終了
			if ( ! file_exists( $file_path ) )
				return false;

			// パーミッション変更
			@chmod( $file_path, defined('FS_CHMOD_FILE') ? FS_CHMOD_FILE : 0644 );
		}

		// メディア追加
		// http://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wp_insert_attachment
		$filetype = wp_check_filetype( basename( $file_path ), null );
		$attachment_id = wp_insert_attachment( array(
			'guid' => $file_url,
			'post_mime_type' => $filetype['type'],
			'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_path ) ),
			'post_content' => '',
			'post_status' => 'inherit'
		), $file_path, 0 );

		// メディア追加失敗時は終了
		if ( ! $attachment_id )
			return false;

		// 添付ファイルのメタデータを生成し、データベースを更新
		$attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
		wp_update_attachment_metadata( $attachment_id, $attach_data );

		return (int) $attachment_id;
	}

	return false;
}

/**
 * オプションTools 現在のテーマオプション設定にデフォルト画像をセットして返す
 */
function theme_options_tools_set_default_images( $dp_options = array(), $is_reset = false ) {
	$dp_options = (array) $dp_options;

	// 引数$is_resetが空でテーマオプションが保存されている場合は終了
	if ( ! $is_reset && get_option( 'dp_options', false ) !== false )
		return $dp_options;

	// デフォルト画像をセットした配列取得
	$default_images_options = theme_options_tools_get_default_images_options();
	if ( ! $default_images_options )
		return $dp_options;


	// 現設定にデフォルト画像をマージ
	$dp_options = array_merge( $dp_options, $default_images_options );

	return apply_filters( 'tcd_theme_options_tools-set_default_images', $dp_options, $default_images_options );
}

/**
 * オプションTools テーマ初期化 デフォルト・サンプル処理
 */
function theme_options_tools_initialize( $dp_options = array(), $is_reset = false, $update_option = true ) {
	// 念のため管理画面限定
	if ( ! is_admin() )
		return;

	// 引数$dp_optionsが空の場合は現設定取得
	if ( ! $dp_options || ! is_array( $dp_options ) ) {
		global $dp_default_options;
		if ( function_exists( 'get_design_plus_options' ) ) {
			$dp_options = get_design_plus_options();
		} elseif ( function_exists( 'get_design_plus_option' ) ) {
			$dp_options = get_design_plus_option();
		} elseif ( function_exists( 'get_desing_plus_options' ) ) {
			$dp_options = get_desing_plus_options();
		} elseif ( function_exists( 'get_desing_plus_option' ) ) {
			$dp_options = get_desing_plus_option();
		} elseif ( $dp_default_options && is_array( $dp_default_options ) ) {
			$dp_options = $dp_default_options;
		} else {
			$dp_options = array();
		}
	}

	// テーマオプションフィルター
	$dp_options_filterd = apply_filters( 'tcd_theme_options_tools-initialize', $dp_options, $is_reset, $update_option );

	// テーマオプション保存
	if ( $dp_options_filterd && is_array( $dp_options_filterd ) && $update_option ) {
		// テーマ変更時はフィルターで値が変更になった場合のみ保存する
		if ( $is_reset || $dp_options_filterd !== $dp_options ) {
			update_option( 'dp_options', $dp_options_filterd );
		}
	}

	if ( ! $update_option ) {
		return $dp_options;
	}
}

/**
 * テーマ変更後の最初の読み込みで実行されるアクションでテーマ初期化
 */
add_action( 'after_switch_theme', 'theme_options_tools_initialize' );

/**
 * テーマ初期化にテーマデフォルト画像フィルター追加
 */
add_filter( 'tcd_theme_options_tools-initialize', 'theme_options_tools_set_default_images', 10, 2 );

/**
 * オプションTools 新規サイトチェック
 */
function theme_options_tools_is_new_site() {
	static $is_new_site;

	if ( is_bool( $is_new_site ) )
		return $is_new_site;

	// 全投稿取得
	$posts = get_posts( array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 2
	) );

	// 全カテゴリー取得
	$categories = get_categories( array(
		'hide_empty' => false
	) );

	// 投稿数が1以下、カテゴリー数が1以下、テーマオプションが保存されていない場合は新規サイト扱い
	if ( count( $posts ) <= 1 && count( $categories ) <= 1 && get_option( 'dp_options', false ) === false ) {
		$is_new_site = true;
	} else {
		$is_new_site = false;
	}

	return $is_new_site;
}


/************************************************/
/* ここからBloom用設定 */
/************************************************/

/**
 * Bloom オプションTools デフォルト画像設定フィルター
 */
function bloom_theme_options_tools_get_default_images_settings( $default_images_settings ) {
	// デフォルト画像設定
	return array(
/*
		array(
			// 保存するファイル名 既存メディアの検索に使用するのでユニークなファイル名が望ましい
			// 未指定の場合はコピー元ファイル名が使用されます
			'media_filename' => 'op_1450x150.jpg',

			// コピー元のファイルパス
			'source_filepath' => get_template_directory() . '/img/op_default/op_1450x150.jpg',

			// 適用するテーマオプションキー
			// リピーター等の配列の場合は"['repeater'][0]['image']"のように指定
			'theme_option_keys' => array( 'slider_image1', 'index_content01_image' )
*/
		array(
			'media_filename' => 'bloom-op_1450x150.gif',
			'source_filepath' => get_template_directory() . '/img/op_default/op_1450x150.gif',
			'theme_option_keys' => array( 'image_404' )
		),
		array(
			'media_filename' => 'bloom-op_800x550.gif',
			'source_filepath' => get_template_directory() . '/img/op_default/op_800x550.gif',
			'theme_option_keys' => array( 'slider_image2', 'slider_image3', 'native_ad_image1' )
		),
		array(
			'media_filename' => 'bloom-op_blog-header.gif',
			'source_filepath' => get_template_directory() . '/img/op_default/op_blog-header.gif',
			'theme_option_keys' => array( 'archive_image' )
		),
		array(
			'media_filename' => 'bloom-op_footer-free.gif',
			'source_filepath' => get_template_directory() . '/img/op_default/op_footer-free.gif',
			'theme_option_keys' => array( 'footer_cta_image' )
		),
		array(
			'media_filename' => 'bloom-op_top-slider.gif',
			'source_filepath' => get_template_directory() . '/img/op_default/op_top-slider.gif',
			'theme_option_keys' => array( 'slider_image1' )
		)
	);
}

/**
 * Bloom オプションTools サンプルカテゴリー
 */
function bloom_theme_options_tools_set_sample_categories( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-categories'] ) )
		return $dp_options;

	// メガメニュー画像 メディアID
	$media_id_image_megamenu = theme_options_tools_get_media_id( array(
		'media_filename' => 'bloom-image_260x180.gif',
		'source_filepath' => get_template_directory() . '/img/op_default/image_260x180.gif'
	), true );

	// ページヘッダー画像 メディアID
	$media_id_image = theme_options_tools_get_media_id( array(
		'media_filename' => 'bloom-op_1450x150.gif',
		'source_filepath' => get_template_directory() . '/img/op_default/op_1450x150.gif'
	), true );

	// サンプルカテゴリー設定配列
	$sample_categories = array(
		array(
			'name' => __( 'Sample Category1', 'tcd-w' ),
			'slug' => 'sample-category1',
			// オプション保存のカスタムフィールド meta_key => meta_value
			'metas' => array(
				'image_megamenu' => $media_id_image_megamenu,
				'image' => $media_id_image
			)
		),
		array(
			'name' => __( 'Sample Category2', 'tcd-w' ),
			'slug' => 'sample-category2',
			'metas' => array(
				'image_megamenu' => $media_id_image_megamenu,
				'image' => $media_id_image
			)
		),
		array(
			'name' => __( 'Sample Category3', 'tcd-w' ),
			'slug' => 'sample-category3',
			'metas' => array(
				'image_megamenu' => $media_id_image_megamenu,
				'image' => $media_id_image
			)
		),
		array(
			'name' => __( 'Sample Category4', 'tcd-w' ),
			'slug' => 'sample-category4',
			'metas' => array(
				'image_megamenu' => $media_id_image_megamenu,
				'image' => $media_id_image
			)
		)
	);

	// サンプルカテゴリー設定ループ
	foreach( $sample_categories as $sample_category ) {
		if ( empty( $sample_category['name'] ) )
			continue;

		if ( empty( $sample_category['taxonomy'] ) )
			$sample_category['taxonomy'] = 'category';

		if ( empty( $sample_category['slug'] ) )
			$sample_category['slug'] = sanitize_title( $sample_category['name'] );

		// 同スラッグカテゴリーがある場合は追加しない
		$term = get_term_by( 'slug', $sample_category['slug'], $sample_category['taxonomy'] );
		if ( ! empty( $term->term_id ) )
			continue;

		// カテゴリー追加
		$result = wp_insert_term(
			$sample_category['name'],
			$sample_category['taxonomy'],
			array(
				'description'=> isset( $sample_category['description'] ) ? $sample_category['description'] : '',
				'slug' => $sample_category['slug'],
				'parent'=> isset( $sample_category['parent'] ) ? absint( $sample_category['parent'] ) : 0
			)
		);

		// カテゴリー追加成功時、カテゴリーメタ保存
		if ( ! is_wp_error( $result ) && ! empty( $result['term_id'] ) && ! empty( $sample_category['metas'] ) ) {
			$term_meta = array();

			foreach( $sample_category['metas'] as $meta_key => $meta_value ) {
				if ( ! is_int( $meta_key ) && $meta_value )
					$term_meta[$meta_key] = $meta_value;
			}

			if ( $term_meta )
				update_option( 'taxonomy_' . $result['term_id'], $term_meta );
		}
	}

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * Bloom オプションTools サンプル記事
 */
function bloom_theme_options_tools_set_sample_posts( $dp_options ) {
	// アイキャッチ メディアID
	$media_id = theme_options_tools_get_media_id( array(
		'media_filename' => 'bloom-image_800x550.gif',
		'source_filepath' => get_template_directory() . '/img/op_default/image_800x550.gif'
	), true );

	// 記事「Hello world!」にアイキャッチセット
	$find_posts = get_posts( array(
	  'name' => 'hello-world',
	  'post_type' => 'post',
	  'post_status' => 'any',
	  'posts_per_page' => 1
	) );
	if ( ! empty( $find_posts[0]->ID ) ) {
		if ( ! has_post_thumbnail( $find_posts[0]->ID ) ) {
			if ( $media_id ) {
				set_post_thumbnail( $find_posts[0]->ID, $media_id );
			}
		}
	}

	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-posts'] ) )
		return $dp_options;

	// サンプル記事設定配列
	$sample_posts = array(
		array(
            'post_title' => __( 'Sample post1', 'tcd-w' ),
            'post_content' => __( 'sample text sample text.', 'tcd-w' ),
			'post_name' => 'sample-post1',
			'post_status' => 'publish',
			'post_type' => 'post',
			// アイキャッチ メディアIDもしくはtheme_options_tools_get_media_id()用の配列もしくはコピー元ファイルパス
			'thumbnail' => $media_id,
			// タクソノミー タクソノミースラッグ => タームスラッグ（配列指定可）
			'taxonomies' => array(
				'category' => 'sample-category1'
			),
			// カスタムフィールド meta_key => meta_value
			'metas' => array()
		),
		array(
            'post_title' => __( 'Sample post2', 'tcd-w' ),
            'post_content' => __( 'sample text sample text.', 'tcd-w' ),
			'post_name' => 'sample-post2',
			'post_status' => 'publish',
			'post_type' => 'post',
			// アイキャッチ
			'thumbnail' => $media_id,
			// タクソノミー
			'taxonomies' => array(
				'category' => 'sample-category2'
			),
			// カスタムフィールド
			'metas' => array(),
		),
		array(
            'post_title' => __( 'Sample post3', 'tcd-w' ),
            'post_content' => __( 'sample text sample text.', 'tcd-w' ),
			'post_name' => 'sample-post3',
			'post_status' => 'publish',
			'post_type' => 'post',
			// アイキャッチ
			'thumbnail' => $media_id,
			// タクソノミー
			'taxonomies' => array(
				'category' => 'sample-category3'
			),
			// カスタムフィールド
			'metas' => array()
		),
		array(
            'post_title' => __( 'Sample post4', 'tcd-w' ),
            'post_content' => __( 'sample text sample text.', 'tcd-w' ),
			'post_name' => 'sample-post4',
			'post_status' => 'publish',
			'post_type' => 'post',
			// アイキャッチ
			'thumbnail' => $media_id,
			// タクソノミー
			'taxonomies' => array(
				'category' => 'sample-category4'
			),
			// カスタムフィールド
			'metas' => array()
		)
	);

	// サンプル記事設定ループ
	foreach( $sample_posts as $i => $sample_post ) {
		if ( empty( $sample_post['post_title'] ) )
			continue;

		// 同スラッグ記事がある場合は追加しない
		$find_posts = get_posts( array(
		  'name' => ! empty( $sample_post['post_name'] ) ? $sample_post['post_name'] : sanitize_title( $sample_post['post_title'] ),
		  'post_type' => ! empty( $sample_post['post_type'] ) ? $sample_post['post_type'] : 'post',
		  'post_status' => 'any',
		  'posts_per_page' => 1
		) );
		if ( $find_posts )
			continue;

		// アイキャッチ・タクソノミー・カスタムフィールド指定を抜き出し
		if ( isset( $sample_post['thumbnail'] ) ) {
			$thumbnail = $sample_post['thumbnail'];
			unset( $sample_post['thumbnail'] );
		} else {
			$thumbnail = null;
		}
		if ( isset( $sample_post['taxonomies'] ) ) {
			$taxonomies = $sample_post['taxonomies'];
			unset( $sample_post['taxonomies'] );
		} else {
			$taxonomies = null;
		}
		if ( isset( $sample_post['metas'] ) ) {
			$metas = $sample_post['metas'];
			unset( $sample_post['metas'] );
		} else {
			$metas = null;
		}

		// 記事追加
		$post_id = wp_insert_post( $sample_post );

		// 記事追加成功時
		if ( $post_id ) {
			// アイキャッチ
			if ( $thumbnail ) {
				// int以外の場合はメディアID取得を試みる
				if ( ! is_int( $thumbnail ) )
					$thumbnail = theme_options_tools_get_media_id( $thumbnail, true );

				if ( is_int( $thumbnail ) )
					set_post_thumbnail( $post_id, $thumbnail );
			}

			// タクソノミー
			if ( $taxonomies && is_array( $taxonomies ) ) {
				foreach( $taxonomies as $taxonomy => $terms ) {
					$set_terms = array();

					foreach( (array) $terms as $term ) {
						if ( is_int( $term ) ) {
							$set_terms[] = $term;
						} else {
							$term_exists = term_exists( $term, $taxonomy );
							if ( ! empty( $term_exists['term_id'] ) )
								$set_terms[] = (int) $term_exists['term_id'];
						}
					}

					if ( $set_terms )
						wp_set_post_terms( $post_id, $set_terms, $taxonomy, false );
				}
			}

			// カスタムフィールド
			if ( $metas && is_array( $metas ) ) {
				foreach( $metas as $meta_key => $meta_value ) {
					if ( ! is_int( $meta_key ) && $meta_value )
						update_post_meta( $post_id, $meta_key, $meta_value);
				}
			}
		}
	}

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * Bloom オプションTools サンプルメニュー
 */
function bloom_theme_options_tools_set_sample_menus( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-menus'] ) )
		return $dp_options;

	// グローバルメニュー設定済みの場合は終了
	$menu_locations = get_nav_menu_locations();
	$nav_menus = wp_get_nav_menus();
	if ( ! empty( $menu_locations['global'] ) && $nav_menus && ! is_wp_error( $nav_menus ) ) {
		foreach( $nav_menus as $nav_menu ) {
			if ( $nav_menu->term_id == $menu_locations['global'] )
				return $dp_options;
		}
	}

	// サンプルメニュー設定済みの場合は終了
	if ( $nav_menus && ! is_wp_error( $nav_menus ) ) {
		foreach( $nav_menus as $nav_menu ) {
			if ( $nav_menu->name == __( 'Sample menu', 'tcd-w' ) )
				return $dp_options;
		}
	}

	// サンプルメニュー作成
	$menu_id = wp_create_nav_menu( __( 'Sample menu', 'tcd-w' ) );
	if ( is_wp_error( $menu_id ) )
		return $dp_options;

	// 親メニューアイテム
	$menu_items = array(
		array(
			'name' => 'HOME',
			'url' => home_url( '/' )
		),
		array(
			'name' => __( 'Dropdown menu', 'tcd-w' ),
			'url' => '#'
		),
		array(
			'name' => __( 'Mega menu A', 'tcd-w' ),
			'url' => '#',
			'megamenu' => 'type2'
		),
		array(
			'name' => __( 'Mega menu B', 'tcd-w' ),
			'url' => '#',
			'megamenu' => 'type3'
		),
		array(
			'name' => __( 'Mega menu C', 'tcd-w' ),
			'url' => '#',
			'megamenu' => 'type4'
		)
	);

	// 子メニューアイテム用カテゴリースラッグ サンプルカテゴリー・未分類
	$category_slugs = array(
		'sample-category1',
		'sample-category2',
		'sample-category3',
		'sample-category4',
		'未分類',
		'uncategorized'
	);

	// 親メニューアイテム作成
	foreach( $menu_items as $menu_item ) {
		if ( empty( $menu_item['name'] ) || empty( $menu_item['url'] ) )
			continue;

		$menu_item_db_id = wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-type' => 'custom',
			'menu-item-title' => $menu_item['name'],
			'menu-item-url' => $menu_item['url'],
			'menu-item-status' => 'publish'
		) );

		if ( $menu_item_db_id && ! is_wp_error( $menu_item_db_id ) ) {
			// メガメニュー テーマオプション設定
			if ( ! empty( $menu_item['megamenu'] ) )
				$dp_options['megamenu'][$menu_item_db_id] = $menu_item['megamenu'];

			// 子メニューアイテム（カテゴリー）作成
			foreach( $category_slugs as $category_slug ) {
				$term = get_term_by( 'slug', $category_slug, 'category' );
				if ( ! empty( $term->term_id ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-type' => 'taxonomy',
						'menu-item-title' => $term->name,
						'menu-item-object' => $term->taxonomy,
						'menu-item-object-id' => $term->term_id,
						'menu-item-parent-id' => $menu_item_db_id,
						'menu-item-status' => 'publish'
					) );
				}
			}
		}
	}

	// グローバルメニューにセット
	$menu_locations = (array) $menu_locations;
	$menu_locations['global'] = (int) $menu_id;
	set_theme_mod( 'nav_menu_locations', $menu_locations );

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * Bloom オプションTools サンプルウィジェット
 */
function bloom_theme_options_tools_set_sample_widgets( $dp_options ) {
	// 新規サイト以外、リセットチェックなしの場合は終了
	if ( ! theme_options_tools_is_new_site() && empty( $_POST['tcd-tools-reset-sample-widgets'] ) )
		return $dp_options;

	// next_widget_id_number用にインクルード
	require_once ABSPATH . '/wp-admin/includes/widgets.php';

	// ウィジェットエリア設定取得
	$sidebars_widgets = wp_get_sidebars_widgets();

	// サンプルウィジェット設定
	$sample_widgets = array(
		// 広告
		array(
			'class_name' => 'tcdw_ad_widget',
			'params' => array(
				'banner_code1' => '',
				'banner_image1' => 	theme_options_tools_get_media_id( array(
					'media_filename' => 'bloom-image_300x250.gif',
					'source_filepath' => get_template_directory() . '/img/op_default/image_300x250.gif'
				), true ),
				'banner_url1' => '#',
				'banner_code2' => '',
				'banner_image2' => '',
				'banner_url2' => '',
				'banner_code3' => '',
				'banner_image3' => '',
				'banner_url3' => '',
			)
		),
		// おすすめ記事
		array(
			'class_name' => 'Styled_Post_List1_widget',
			'params' => array(
				'title' => __( 'Recommend post', 'tcd-w'),
				'list_style' => 'type2',
				'list_type' => 'recommend_post',
				'post_num' => 4,
				'post_order' => 'date1',
				'show_date' => 0
			)
		),
		// カテゴリー
		array(
			'class_name' => 'Tcdw_Category_List_Widget',
			'params' => array(
				'title' => __( 'Category', 'tcd-w'),
				'exclude_cat_num' => ''
			)
		),
		// 人気記事ランキング
		array(
			'class_name' => 'Ranking_List_Widget',
			'params' => array(
				'title' => __( 'Popular post ranking', 'tcd-w'),
				'post_num' => 3,
				'category' => 0,
				'show_views' => 1,
				'show_native_ad' => 0,
				'link_text' => '',
				'link_url' => '',
				'link_target_blank' => 0,
				'rank_font_color0' => '#000000',
				'rank_bg_color0' => '#ffffff',
				'rank_font_color1' => '#ffffff',
				'rank_bg_color1' => '#000000',
				'rank_font_color2' => '#ffffff',
				'rank_bg_color2' => '#000000',
				'rank_font_color3' => '#ffffff',
				'rank_bg_color3' => '#000000',
				'rank_font_color4' => '#000000',
				'rank_bg_color4' => '#ffffff',
				'rank_font_color5' => '#000000',
				'rank_bg_color5' => '#ffffff',
			)
		),
		// 最新記事
		array(
			'class_name' => 'Styled_Post_List1_widget',
			'params' => array(
				'title' => __( 'Recent post', 'tcd-w'),
				'list_style' => 'type1',
				'list_type' => 'recent_post',
				'post_num' => 3,
				'post_order' => 'date1',
				'show_date' => 1
			)
		),
		// アーカイブ
		array(
			'class_name' => 'Tcdw_Archive_List_Widget',
			'params' => array(
				'title' => ''
			)
		)
	);

	// PC・モバイル基本ウィジェットエリア
	foreach( array( 'common_side_widget', 'common_side_widget_mobile' ) as $sidebar ) {
		// 現ウィジェットを設定を削除
		if ( ! empty( $sidebars_widgets[$sidebar] ) ) {
			foreach( $sidebars_widgets[$sidebar] as $widget_id ) {
				$pieces = explode( '-', $widget_id );
				$multi_number = array_pop( $pieces );
				$id_base = implode( '-', $pieces );
				$widget_db = get_option( 'widget_' . $id_base );
				if ( isset( $widget_db[$multi_number] ) ) {
					unset( $widget_db[$multi_number] );
					update_option( 'widget_' . $id_base, $widget_db );
				}
			}
		}

		// ウィジェットエリアを空に
		$sidebars_widgets[$sidebar] = array();

		// ウィジェットループしてウィジェット追加
		foreach( $sample_widgets as $sample_widget ) {
			$widget_class = null;

			if ( isset( $sample_widget['class_name'] ) && class_exists( $sample_widget['class_name'] ) ) {
				$widget_class = new $sample_widget['class_name'];
				$widget_id_base = $widget_class->id_base;
			} elseif ( ! empty( $sample_widget['id'] ) ) {
				$widget_id_base = $sample_widget['id'];
			} else {
				continue;
			}

			// WP_Widget::update_callback()等を使う方法もあるがPOST前提で扱いずらいためDBのオプション値を直接変更
			$widget_db = get_option( 'widget_' . $widget_id_base, array() );

			// ウィジェットID番号
			$widget_id_number = next_widget_id_number( $widget_id_base );
			$widget_db_keys = array_filter( array_keys( $widget_db ), 'is_int' );
			if ( $widget_db_keys )
				$widget_id_number = max( $widget_id_number, max( $widget_db_keys ) + 1 );

			// ウィジェット値
			if ( isset( $sample_widget['params'] ) ) {
				if ( $widget_class ) {
					$widget_db[$widget_id_number] = $widget_class->update( $sample_widget['params'], array() );
				} else {
					$widget_db[$widget_id_number] = $sample_widget['params'];
				}
			} else {
				$widget_db[$widget_id_number] = array();
			}

			// ウィジェットDB保存
			if ( ! isset( $widget_db['_multiwidget'] ) )
				$widget_db['_multiwidget'] = 1;

			update_option( 'widget_' . $widget_id_base, $widget_db );

			// ウィジェットエリアに追加
			$sidebars_widgets[$sidebar][] = $widget_id_base . '-' . $widget_id_number;
		}
	}

	// ウィジェットエリア保存
	wp_set_sidebars_widgets( $sidebars_widgets );

	// テーマオプションフィルター内で動作しているためreturn必須
	return $dp_options;
}

/**
 * Bloom テーマ初期化フィルター
 */
add_filter( 'tcd_theme_options_tools-get_default_images_settings', 'bloom_theme_options_tools_get_default_images_settings', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'bloom_theme_options_tools_set_sample_categories', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'bloom_theme_options_tools_set_sample_posts', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'bloom_theme_options_tools_set_sample_menus', 10, 1 );
add_filter( 'tcd_theme_options_tools-initialize', 'bloom_theme_options_tools_set_sample_widgets', 10, 1 );
