<?php
/**
 * エディターに関連する記述をここにまとめる
 *
 * NOTE: TCD Classic Editorの個別対応もここ
 */

/**
 * プラグインが有効化されている場合の処理
 *
 * NOTE: TCDCE_ACTIVEは、プラグインで定義された定数（有効化されていればtrue）
 */
if ( defined( 'TCDCE_ACTIVE' ) && TCDCE_ACTIVE ) {
	/**
	 * スタートガイド
	 */
	// 告知追加： このプラグインを有効化している間、TCDテーマの「クイックタグ」機能は利用できません。
	add_action( 'tcdce_top_menu', 'tcdce_top_menu_common_caution', 9 );
	/**
	 * 基本設定
	 */
	// 告知追加： TCDテーマオプションの設定が本文に反映されるため、基本設定はお使いいただけません。
	add_action( 'tcdce_submenu_tcd_classic_editor_basic', 'tcdce_submenu_basic_common_caution' );
	// 基本設定のスタイルを読み込まない
	remove_filter( 'tcdce_render_quicktag_style', 'tcdce_render_quicktag_basic_style' );
	/**
	 * クイックタグ
	 */
	// フロントの use_quicktagオプションを強制的にオフにする（元テーマの関連スタイルを除去）
	add_filter( 'option_dp_options', 'tcdce_disable_theme_quicktag' );
	/**
	 * Googleマップ
	 */
	// 特に無し
	/**
	 * 目次
	 */
	// スマホ用目次ウィジェットアイコンを表示するブレイクポイント
	add_filter( 'tcdce_toc_show_breakpoint', fn() => 991 );
	// 目次のスタイル調整
	add_filter( 'tcdce_enqueue_inline_style', function( $style ){
		$style .=
		// 目次ウィジェットとヘッダーの距離
		'body { --tcdce-toc-sticky-top: 80px; }' .
		'body:has(.l-header--fixed) { --tcdce-toc-sticky-top: 230px; }' .
		'@media only screen and (max-width: 1199px) { body:has(.l-header--fixed) { --tcdce-toc-sticky-top: 110px; } }' .
		// スマホフッターバー表示時の対策
		'body:has(.c-footer-bar) .p-toc-open { margin-bottom: 50px; }' .
		// トップに戻るボタンを非表示
		'body:has(.p-toc-open) .p-pagetop { display:none!important; }' .
		// ドロワーメニュー表示に目次アイコン非表示
		// 'html.open_menu .p-toc-open { display:none; }';
		'';
		return $style;
	} );
		// 目次の投稿タイプから不要なものを削除
		add_filter( 'tcdce_toc_setting_post_types_options', function( $post_types ){
			return array_filter( $post_types, function ( $post_type ) {
				return ! in_array( $post_type, [ 'course','faq' ] );
			} );
		} );
	
	/**
	 * design-plus.cssを取り除く
	 */
	add_action( 'wp_enqueue_scripts', function(){
		wp_dequeue_style( 'design-plus' );
	}, 12 );
	/**
	 * エディタ独自スタイル対応
	 */
	add_filter( 'tcdce_enqueue_inline_style', function( $style ){
		global $dp_options;
		$style .=
		// レイアウト
		'.tcdce-body { padding-block: 0.7em; }' .
		// ページビルダー
		'.pb-widget-editor:has(.tcdce-body) { margin-top:0; }' .
		'@media only screen and (min-width: 768px) { .tcd-pb-row-inner:has(.col2) .pb-widget-editor .tcdce-body { padding-block:0; } }' .
		'.pb-widget-editor .tcdce-body > :last-child { margin-bottom:0; }' .
		'.tcdce-body blockquote { margin-inline:0; }' .
		'.tcdce-body .pb_font_family_1 { font-family: var(--tcd-font-type1); }' .
		'.tcdce-body .pb_font_family_2 { font-family: var(--tcd-font-type2); }' .
		'.tcdce-body .pb_font_family_3 { font-family: var(--tcd-font-type3); }' .
		'';
		return $style;
	} );
	/**
	 * 有効化されていれば、ココで処理を止める
	 */
	return;
}

/**
 * 以下はテーマのエディタ周りの機能
 *
 * NOTE: プラグイン有効化時は、以下は実行されない
 */
/**
 * the_contentで実行されているもの
 */

// クラシックエディターのtable スクロール対応 ------------------------------------------------------------------------
add_filter('the_content', function( $content ){
	if( !has_blocks() ){
	$content = str_replace( '<table', '<div class="s_table"><table', $content );
	$content = str_replace( '</table>', '</table></div>', $content );
	}
	return $content;
	} );

/**
 * ビジュアルエディタに表(テーブル)の機能を追加
 */
function mce_external_plugins_table( $plugins ) {
	$plugins['table'] = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.4/plugins/table/plugin.min.js';
	return $plugins;
}
add_filter( 'mce_external_plugins', 'mce_external_plugins_table' );

/**
 * tinymceのtableボタンにclass属性プルダウンメニューを追加
 */
function mce_buttons_table( $buttons ) {
	$buttons[] = 'table';
	return $buttons;
}
add_filter( 'mce_buttons', 'mce_buttons_table' );

function table_classes_tinymce( $settings ) {
	$styles = array(
		array( 'title' => __( 'Default style', 'tcd-w' ), 'value' => '' ),
		array( 'title' => __( 'No border', 'tcd-w' ), 'value' => 'table_no_border' ),
		array( 'title' => __( 'Display only horizontal border', 'tcd-w' ), 'value' => 'table_border_horizontal' )
	);
	$settings['table_class_list'] = json_encode( $styles );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'table_classes_tinymce' );

/**
 * ビジュアルエディタにページ分割ボタンを追加
 */
function add_nextpage_buttons( $buttons ) {
	array_push( $buttons, 'wp_page' );
	return $buttons;
}
add_filter( 'mce_buttons', 'add_nextpage_buttons' );

// Editor style
function bloom_add_editor_styles() {
	add_theme_support('editor-styles');
	add_editor_style( get_template_directory_uri()."/admin/css/editor-style-02.css?d=".date('YmdGis', filemtime(get_template_directory().'/admin/css/editor-style-02.css')) );
}
add_action( 'admin_init', 'bloom_add_editor_styles' );

function tcd_quicktag_admin_init() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( $dp_options['use_quicktags'] && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) ) {
		add_filter( 'mce_external_plugins', 'tcd_add_tinymce_plugin' );

		add_filter( 'mce_buttons', 'tcd_register_mce_button' );
		
		add_action( 'admin_print_footer_scripts', 'tcd_add_quicktags' );

		// Dynamic css for classic visual editor
		add_filter( 'editor_stylesheets', 'editor_stylesheets_tcd_visual_editor_dynamic_css' );

		// Dymamic css for visual editor on block editor
		// wp_enqueue_style( 'tcd-quicktags', get_tcd_quicktags_dynamic_css_url(), false, version_num() );
	}
}
add_action( 'admin_init', 'tcd_quicktag_admin_init' );

// Declare script for new button
function tcd_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['tcd_mce_button'] = get_template_directory_uri() . '/admin/js/mce-button.js?ver=2.0.0';
	return $plugin_array;
}

// Register new button in the editor
function tcd_register_mce_button( $buttons ) {
	array_push( $buttons, 'tcd_mce_button' );
	return $buttons;
}

function tcd_add_quicktags() {
	$tcdQuicktagsL10n = array(
		'pulldown_title' => array(
			'display' => __( 'quicktags', 'tcd-w' ),
		),
		'ytube' => array(
			'display' => __( 'Youtube', 'tcd-w' ),
            'tag' => __( '<div class="ytube">Youtube code here</div>', 'tcd-w' )
		),
		'relatedcardlink' => array(
            'display' => __( 'Cardlink', 'tcd-w' ),
            'tag' => __( '[clink url="Post URL to display"]', 'tcd-w' )
		),
		'post_col-2' => array(
            'display' => __( '2 column', 'tcd-w' ),
            'tag' => __( '<div class="post_row"><div class="post_col post_col-2">Text and image tags to display in the left column</div><div class="post_col post_col-2">Text and image tags to display in the right column</div></div>', 'tcd-w' )
		),
		'post_col-3' => array(
            'display' => __( '3 column', 'tcd-w' ),
            'tag' => __( '<div class="post_row"><div class="post_col post_col-3">Text and image tags to display in the left column</div><div class="post_col post_col-3">Text and image tags to display in the center column</div><div class="post_col post_col-3">Text and image tags to display in the right column</div></div>', 'tcd-w' )
		),
/*
		'style3a' => array(
            'display' => __( 'H3 styleA', 'tcd-w' ),
            'tag' => __( '<h3 class="style3a">Heading 3 styleA</h3>', 'tcd-w' )
		),
		'style3b' => array(
            'display' => __( 'H3 styleB', 'tcd-w' ),
            'tag' => __( '<h3 class="style3b">Heading 3 styleB</h3>', 'tcd-w' )
		),
		'style4a' => array(
            'display' => __( 'H4 styleA', 'tcd-w' ),
            'tag' => __( '<h4 class="style4a">Heading 4 styleA</h4>', 'tcd-w' )
		),
		'style4b' => array(
			'display' => __( 'H4 styleB', 'tcd-w' ),
            'tag' => __( '<h4 class="style4b">Heading 4 styleB</h4>', 'tcd-w' )
		),
		'style5a' => array(
			'display' => __( 'H5 styleA', 'tcd-w' ),
            'tag' => __( '<h5 class="style5a">Heading 5 styleA</h5>', 'tcd-w' )
		),
		'style5b' => array(
			'display' => __( 'H5 styleB', 'tcd-w' ),
			'tag' => __( '<h5 class="style5b">Heading 5 styleB</h5>', 'tcd-w' )
		),
*/
		'style_h2' => array(
      'display' => 'h2',
			'tagStart' => '<h2 class="style_h2">',
			'tagEnd' => '</h2>'
		),
		'style_h3' => array(
      'display' => 'h3',
			'tagStart' => '<h3 class="style_h3">',
			'tagEnd' => '</h3>'
		),
		'style_h4' => array(
      'display' => 'h4',
			'tagStart' => '<h4 class="style_h4">',
			'tagEnd' => '</h4>'
		),
		'style_h5' => array(
      'display' => 'h5',
			'tagStart' => '<h5 class="style_h5">',
			'tagEnd' => '</h5>'
		),
		'well' => array(
      'display' => __( 'Frame styleA', 'tcd-w' ),
			'tagStart' => '<div class="well">',
			'tagEnd' => '</div>'
		),
		'well2' => array(
      'display' => __( 'Frame styleB', 'tcd-w' ),
			'tagStart' => '<div class="well2">',
			'tagEnd' => '</div>'
		),
		'well3' => array(
      'display' => __( 'Frame styleC', 'tcd-w' ),
			'tagStart' => '<div class="well3">',
			'tagEnd' => '</div>'
		),
		'q_button' => array(
            'display' => __( 'Flat btn', 'tcd-w' ),
			'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button">Flat button</a></div>', 'tcd-w' )
		),
		'q_button_l' => array(
            'display' => __( 'Flat btn-L', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button sz_l">Flat button sizeL</a></div>', 'tcd-w' )
		),
		'q_button_s' => array(
            'display' => __( 'Flat btn-S', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button sz_s">Flat button sizeS</a></div>', 'tcd-w' )
		),
		'q_button_blue' => array(
            'display' => __( 'Flat btn-blue', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button bt_blue">Flat button blue</a></div>', 'tcd-w' )
		),
		'q_button_green' => array(
            'display' => __( 'Flat btn-green', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button bt_green">Flat button green</a></div>', 'tcd-w' )
		),
		'q_button_red' => array(
            'display' => __( 'Flat btn-red', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button bt_red">Flat button red</a></div>', 'tcd-w' )
		),
		'q_button_yellow' => array(
            'display' => __( 'Flat btn-yellow', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button bt_yellow">Flat button yellow</a></div>', 'tcd-w' )
		),
		'q_button_rounded' => array(
            'display' => __( 'Rounded btn', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button rounded">Rounded button</a></div>', 'tcd-w' )
		),
		'q_button_rounded_l' => array(
            'display' => __( 'Rounded btn-L', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button rounded sz_l">Rounded button sizeL</a></div>', 'tcd-w' )
		),
		'q_button_rounded_s' => array(
            'display' => __( 'Rounded btn-S', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button rounded sz_s">Rounded button sizeS</a></div>', 'tcd-w' )
		),
		'q_button_pill' => array(
            'display' => __( 'oval btn', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button pill">Oval button</a></div>', 'tcd-w' )
		),
		'q_button_pill_l' => array(
            'display' => __( 'oval btn-L', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button pill sz_l">Oval button sizeL</a></div>', 'tcd-w' )
		),
		'q_button_pill_s' => array(
            'display' => __( 'oval btn-S', 'tcd-w' ),
            'tag' => __( '<div class="q_button_wrap"><a href="#" class="q_button pill sz_s">Oval button sizeS</a></div>', 'tcd-w' )
		),
		'single_banner' => array(
            'display' => __( 'advertisement', 'tcd-w' ),
			'tag' => __( '[s_ad]', 'tcd-w' )
		),
		'page_break' => array(
			'display' => __( 'Page break' ),
			'tag' => '<!--nextpage-->'
		)
	);
?>
<script type="text/javascript">
// TCDtCD
<?php
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		echo "var tcdQuicktagsL10n = " . json_encode( $tcdQuicktagsL10n ) . ";\n";
	}
	if ( wp_script_is( 'quicktags' ) ) {
		foreach( $tcdQuicktagsL10n as $key => $value ) {
			if ( is_numeric( $key ) || empty( $value['display'] ) ) continue;
			if ( empty( $value['tag'] ) && empty( $value['tagStart'] ) ) continue;

			if ( isset( $value['tag'] ) || ! isset( $value['tagStart'] ) ) {
				$value['tagStart'] = $value['tag'] . "\n\n";
			}
			if ( ! isset( $value['tagEnd'] ) ) {
				$value['tagEnd'] = '';
			}

			$key = json_encode( $key );
			$display = json_encode( $value['display'] );
			$tagStart = json_encode( $value['tagStart'] );
			$tagEnd = json_encode( $value['tagEnd'] );
			echo "QTags.addButton($key, $display, $tagStart, $tagEnd);\n";
		}
	}
?>
</script>
<?php
}

// Get dymamic css url
function get_tcd_quicktags_dynamic_css_url() {
	return admin_url( 'admin-ajax.php?action=tcd_quicktags_dynamic_css' );
}

// add_editor_style()だとテーマ内のcssが最後になるためここで最後尾にcss追加
function editor_stylesheets_tcd_visual_editor_dynamic_css( $stylesheets ) {
	$stylesheets[] = get_tcd_quicktags_dynamic_css_url();
	$stylesheets = array_unique( $stylesheets );
	return $stylesheets;
}
