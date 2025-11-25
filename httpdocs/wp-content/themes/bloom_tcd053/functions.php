<?php

/**
 * Translation
 */
load_textdomain('tcd-w', dirname(__FILE__).'/languages/tcd-bloom-' . determine_locale() . '.mo');
load_textdomain('tcd-bloom', dirname(__FILE__).'/languages/tcd-bloom-' . determine_locale() . '.mo');


// style.cssのDescriptionをPoedit等に認識させる
__( '"Bloom" was developed with the image of a feminine web magazine. It is a simple, margin-conscious design for building a blog. You can also use the side menu and ranking function to organize your information smartly.', 'tcd-w' );

/**
 * Theme setup
 */
function bloom_setup() {

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Image sizes
	add_image_size( 'size1', 500, 500, true );
	add_image_size( 'size2', 800, 550, true );
	add_image_size( 'size3', 800, 550, true );
	add_image_size( 'size-card', 300, 300, true ); // カードリンクパーツ用

	// imgタグのsrcsetを未使用に
	add_filter( 'wp_calculate_image_srcset', '__return_empty_array' );

	// Menu
	register_nav_menus( array(
		'global' => __( 'Global menu', 'tcd-w' )
	) );

}
add_action( 'after_setup_theme', 'bloom_setup' );

/**
 * Theme init
 */
function bloom_init() {
	disable_emoji();
}
add_action( 'init', 'bloom_init' );

function disable_emoji() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
    if ( 0 == $dp_options['use_emoji'] ) {

      // remove inline script
      remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
      // remove inline style
      remove_action( 'wp_print_styles', 'print_emoji_styles' );
      // remove inline style  6.4 later
      if ( function_exists( 'wp_enqueue_emoji_styles' ) ) {
        remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
        remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
      }

      // initだと早いため、admin_initで実行
      add_action( 'admin_init', function(){
        // remove inline script
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        // remove inline style
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        // remove inline style 6.4 later
        if ( function_exists( 'wp_enqueue_emoji_styles' ) ) {
          remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
        }
      } );
    }
  }
  add_action( 'init', 'disable_emoji' );

/**
 * Theme scripts and style
 */
function bloom_scripts() {

	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	// 共通
	wp_enqueue_style( 'bloom-style', get_stylesheet_uri(), array(), version_num() );
	wp_enqueue_script( 'bloom-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), version_num(), true );

	  	// TCDCE対策のため、クイックタグスタイルをstyle.cssから分離させる
	// NOTE: スタイルの優先度に影響を与えないよう、style.cssの直後に読み込み
	wp_enqueue_style( 'design-plus', get_template_directory_uri() . '/css/design-plus.css', array(), version_num() );

	// slick読み込みフラグ
	$slick_load = false;

	if ( is_front_page() ) {
		if ( 'type3' == $dp_options['header_content_type'] ) {
			if ( $dp_options['video'] && auto_play_movie() ) {
				wp_enqueue_style( 'bloom-vegas', get_template_directory_uri() . '/css/vegas.min.css' );
				wp_enqueue_script( 'bloom-vegas', get_template_directory_uri() . '/js/vegas.js', array( 'jquery' ), version_num(), true );
			}
		} elseif ( 'type4' == $dp_options['header_content_type'] ) {
			if ( $dp_options['youtube_url'] && auto_play_movie() ) {
				wp_enqueue_style( 'bloom-YTPlayer', get_template_directory_uri() . '/css/jquery.mb.YTPlayer.min.css' );
				wp_enqueue_script( 'bloom-YTPlayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.min.js', array( 'jquery' ), version_num(), true );
			}
		} else {
			$slick_load = true;
		}

		if ( $dp_options['show_footer_blog_top'] ) {
			$slick_load = true;
		}
	} elseif ( $dp_options['show_footer_blog'] ) {
		$slick_load = true;
	}

	// slick
	if ( $slick_load ) {
		wp_enqueue_script( 'bloom-slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), version_num(), true );
		wp_enqueue_style( 'bloom-slick', get_template_directory_uri() . '/css/slick.min.css' );

		// ページビルダーのslick.js,slick.cssを読み込まないように
		add_filter( 'page_builder_slick_enqueue_script', '__return_false' );
		add_filter( 'page_builder_slick_enqueue_style', '__return_false' );
	}

	// レスポンシブ
	if ( ! is_no_responsive() ) {
		wp_enqueue_style( 'bloom-responsive', get_template_directory_uri() . '/responsive.css', array( 'bloom-style' ), version_num() );
		if ( is_mobile() && 'type3' !== $dp_options['footer_bar_display'] ) {
			wp_enqueue_style( 'bloom-footer-bar', get_template_directory_uri() . '/css/footer-bar.css', false, version_num() );
			wp_enqueue_script( 'bloom-footer-bar', get_template_directory_uri() . '/js/footer-bar.js', array( 'jquery' ), version_num(), true );
		}
	}

	// ヘッダースクロール
	if ( 'type2' == $dp_options['header_fix'] || 'type2' == $dp_options['mobile_header_fix'] ) {
		wp_enqueue_script( 'bloom-header-fix', get_template_directory_uri() . '/js/header-fix.js', array( 'jquery' ), version_num(), true );
	}

	// サイドメニュー
	if ( $dp_options['show_sidemenu'] && ! is_mobile() && is_active_sidebar( 'sidemenu_widget' ) ) {
		wp_enqueue_script( 'bloom-sidemenu', get_template_directory_uri() . '/js/sidemenu.js', array( 'jquery' ), version_num(), true );
	}

	// フッターCTA
	if ( ( is_front_page() && $dp_options['show_footer_cta_top'] ) || ( ! is_front_page() && $dp_options['show_footer_cta'] ) ) {
		wp_enqueue_script( 'bloom-parallax', get_template_directory_uri() . '/js/parallax.min.js', array( 'jquery' ), version_num(), true );
		wp_enqueue_script( 'bloom-inview', get_template_directory_uri() . '/js/jquery.inview.min.js', array( 'jquery' ), version_num(), true );
	}

	// アドミンバーのインラインスタイルを出力しない
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
	remove_action( 'wp_head', 'wp_admin_bar_header' );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_admin_bar_bump_styles' );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_admin_bar_header_styles' );
}
add_action( 'wp_enqueue_scripts', 'bloom_scripts' );

function bloom_admin_scripts() {

	// 管理画面共通
	wp_enqueue_style( 'tcd_admin_css', get_template_directory_uri() . '/admin/css/tcd_admin.css', array(), version_num() );
	wp_enqueue_script( 'tcd_script', get_template_directory_uri() . '/admin/js/tcd_script.js', array(), version_num() );
	wp_enqueue_script('font_ui', get_template_directory_uri().'/admin/font/ui/font_ui.js', '', '1.0.4', true);
	wp_enqueue_style('font_ui_css', get_template_directory_uri() . '/admin/font/ui/font_ui.css','','1.0.0');

	// 画像アップロードで使用
	wp_enqueue_script( 'cf-media-field', get_template_directory_uri() . '/admin/js/cf-media-field.js', array( 'media-upload' ), version_num() );
	wp_localize_script( 'cf-media-field', 'cfmf_text', array(
		'image_title' => __( 'Please Select Image', 'tcd-w' ),
		'image_button' => __( 'Use this Image', 'tcd-w' ),
		'video_title' => __( 'Please Select Video', 'tcd-w' ),
		'video_button' => __( 'Use this Video', 'tcd-w' )
	) );

	// メディアアップローダーAPIを利用するための処理
	wp_enqueue_media();

	// ウィジェットで使用
	wp_enqueue_script( 'bloom-widget-script', get_template_directory_uri() . '/admin/js/widget.js', array( 'jquery' ), version_num() );

	// テーマオプションのタブで使用
	wp_enqueue_script( 'jquery.cookieTab', get_template_directory_uri() . '/admin/js/jquery.cookieTab.js', array(), version_num() );

	// フッターバー
	wp_enqueue_style( 'bloom-admin-footer-bar', get_template_directory_uri() . '/admin/css/footer-bar.css', array(), version_num() );
	wp_enqueue_script( 'bloom-admin-footer-bar', get_template_directory_uri() . '/admin/js/footer-bar.js', array(), version_num() );

	// WPカラーピッカー
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'bloom_admin_scripts' );

// シェアボタンのCSSを読み込み
function bloom_add_sns_link_files() {
	wp_enqueue_style( 'sns-button', get_template_directory_uri() . '/css/sns-botton.css', '', version_num() );
}
add_action( 'wp_enqueue_scripts', 'bloom_add_sns_link_files' );

// 各サムネイル画像生成時の品質を82→90に
function custom_wp_editor_set_quality($quality, $mime_type) {
	return 90;
}
add_filter('wp_editor_set_quality', 'custom_wp_editor_set_quality', 10, 2);

// Widget area
function bloom_widgets_init() {

	// Common side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Common side widget', 'tcd-w' ),
		'id' => 'common_side_widget'
	) );

	// Index side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Index side widget', 'tcd-w' ),
		'id' => 'index_side_widget'
	) );

	// Archive side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Archive side widget', 'tcd-w' ),
		'id' => 'archive_side_widget'
	) );

	// Post side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Post side widget', 'tcd-w' ),
		'id' => 'post_side_widget'
	) );

	// Page side widget
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Page side widget', 'tcd-w' ),
		'id' => 'page_side_widget'
	) );

	// Sidemenu
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Side menu widget', 'tcd-w' ),
		'id' => 'sidemenu_widget'
	) );

	// Footer
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Footer widget', 'tcd-w' ),
		'id' => 'footer_widget'
	) );

	// Common side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Common side widget (mobile)', 'tcd-w' ),
		'id' => 'common_side_widget_mobile'
	) );

	// Index side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Index side widget (mobile)', 'tcd-w' ),
		'id' => 'index_side_widget_mobile'
	) );

	// Archive side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Archive side widget (mobile)', 'tcd-w' ),
		'id' => 'archive_side_widget_mobile'
	) );

	// Post side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Post side widget (mobile)', 'tcd-w' ),
		'id' => 'post_side_widget_mobile'
	) );

	// Page side widget (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Page side widget (mobile)', 'tcd-w' ),
		'id' => 'page_side_widget_mobile'
	) );

	// Footer (mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget %2$s" id="%1$s">' . "\n",
		'after_widget' => "</div>\n",
		'before_title' => '<div class="p-widget__title">',
		'after_title' => '</div>' . "\n",
		'name' => __( 'Footer widget (mobile)', 'tcd-w' ),
		'id' => 'footer_widget_mobile'
	) );

}
add_action( 'widgets_init', 'bloom_widgets_init' );

/**
 * get sidebar id
 */
function get_sidebar_id( $is_active_sidebar = true ) {
	$sidebars = array();

	if ( is_front_page() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'index_side_widget_mobile';
			$sidebars[] = 'archive_side_widget_mobile';
		} else {
			$sidebars[] = 'index_side_widget';
			$sidebars[] = 'archive_side_widget';
		}

	} elseif ( is_home() || is_archive() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'archive_side_widget_mobile';
		} else {
			$sidebars[] = 'archive_side_widget';
		}

	} elseif ( is_page() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'page_side_widget_mobile';
		} else {
			$sidebars[] = 'page_side_widget';
		}

	} elseif ( is_singular() ) {
		if ( is_mobile() ) {
			$sidebars[] = 'post_side_widget_mobile';
		} else {
			$sidebars[] = 'post_side_widget';
		}
	}

	if ( is_mobile() ) {
		$sidebars[] = 'common_side_widget_mobile';
	} else {
		$sidebars[] = 'common_side_widget';
	}

	if ( ! empty( $sidebars ) ) {
		if ( $is_active_sidebar ) {
			foreach( $sidebars as $sidebar ) {
				if ( is_active_sidebar( $sidebar ) ) {
					return $sidebar;
				}
			}
		} else {
			return array_shift( $sidebars );
		}
	}

	return false;
}

/**
 * body class
 */
function bloom_body_classes( $classes ) {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();

	if ( wp_is_mobile() ) {
		$classes[] = 'wp-is-mobile';
	}

	if ( ! is_no_responsive() ) {
		$classes[] = 'is-responsive';
	}

	if ( $dp_options['header_fix'] == 'type2' ) {
		$classes[] = 'l-header__fix';
	}

	if ( !is_no_responsive() && $dp_options['mobile_header_fix'] == 'type2' ) {
		$classes[] = 'l-header__fix--mobile';
	}

	if ( $dp_options['show_sidemenu'] && ! is_mobile() && is_active_sidebar( 'sidemenu_widget' ) ) {
		$classes[] = 'l-has-sidemenu';
	}

	return array_unique( $classes );
}
add_filter( 'body_class', 'bloom_body_classes' );

/**
 * Excerpt
 */
function custom_excerpt_length( $length ) {
	return 75;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

/**
 * Remove wpautop from the excerpt
 */
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Customize archive title
 */
function bloom_archive_title( $title ) {
	global $author, $post;
	if ( is_author() ) {
		$title = get_the_author_meta( 'display_name', $author );
	} elseif ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_day() ) {
		$title = get_the_time( __( 'F jS, Y', 'tcd-w' ), $post );
	} elseif ( is_month() ) {
		$title = get_the_time( __( 'F, Y', 'tcd-w' ), $post );
	} elseif ( is_year() ) {
		$title = get_the_time( __( 'Y', 'tcd-w' ), $post );
	} elseif ( is_search() ) {
		$title = __( 'Search result', 'tcd-w' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'bloom_archive_title', 10 );

/**
 * Translate Hex to RGB
 */
function hex2rgb( $hex ) {

	$hex = str_replace( '#', '', $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}

	$rgb = array( $r, $g, $b );

	return $rgb;
}

/**
 * ユーザーエージェントを判定するための関数
 */
function is_mobile() {

	if ( isset( $_SERVER['HTTP_SEC_CH_UA_MOBILE'] ) ) {
	  $is_mobile = ( '?1' === $_SERVER['HTTP_SEC_CH_UA_MOBILE'] );
  } elseif ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
	  $is_mobile = false;
  } elseif (
	  (str_contains( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) && !str_contains( $_SERVER['HTTP_USER_AGENT'], 'iPad' )) // iPad を除外
	  || (str_contains( $_SERVER['HTTP_USER_AGENT'], 'Android' ) && !str_contains( $_SERVER['HTTP_USER_AGENT'], 'Tablet' )) // Android タブレットを除外
	  || str_contains( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) // iPhone を明示的に含む
	  || str_contains( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' )
	  || str_contains( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' )
	  || str_contains( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' )
  ) {
	  $is_mobile = true;
  } else {
	  $is_mobile = false;
  }
  return $is_mobile;
  
  }
  // WordPress5.9 未満、かつPHP7系環境で発生するエラー対策( wp-includes/compat.php  )
  if ( ! function_exists( 'str_contains' ) ) {
	function str_contains( $haystack, $needle ) {
	  return false !== strpos( $haystack, $needle );
	}
  }

/**
 * レスポンシブOFF機能を判定するための関数
 */
function is_no_responsive() {
	global $dp_options;
	if ( ! $dp_options ) $dp_options = get_design_plus_option();
	return $dp_options['responsive'] == 'no' ? true : false;
}

/**
 * スクリプトのバージョン管理
 */
function version_num() {
	static $theme_version = null;

	if ( $theme_version !== null ) {
		return $theme_version;
	}

	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_data = wp_get_theme( get_template() );
	} else {
		$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
	}

	if ( isset( $theme_data['Version'] ) ) {
		$theme_version = $theme_data['Version'];
	} else {
		$theme_version = '';
	}

	return $theme_version;
}

/**
 * カードリンクパーツ
 */
function get_the_custom_excerpt( $content, $length ) {
	$length = $length ? $length : 70; // デフォルトの長さを指定する
	$content = preg_replace( '/<!--more-->.+/is', '', $content ); // moreタグ以降削除
	$content = strip_shortcodes( $content ); // ショートコード削除
	$content = strip_tags( $content ); // タグの除去
	$content = str_replace( '&nbsp;', '', $content ); // 特殊文字の削除（今回はスペースのみ）
	$content = mb_substr( $content, 0, $length ); // 文字列を指定した長さで切り取る
	return $content.'...';
}

/**
 * カードリンクショートコード
 */
function clink_scode( $atts ) {
$atts = shortcode_atts(
    array(
      'url' => "",
      'title' => "",
      'excerpt' => ""
    ),
    $atts
  );

  // URLから投稿IDを取得
  $post_id = url_to_postid( $atts['url'] );

  // 各投稿データの取得
  $post = get_post( $post_id );
  $date = get_the_date( 'Y.m.d', $post_id );
  $image_url = get_the_post_thumbnail_url( $post_id, 'size-card' );
  $title = get_the_title( $post );
  $excerpt = get_the_custom_excerpt( $post->post_excerpt ? $post->post_excerpt : $post->post_content, 120 );

  // 投稿IDの取得に失敗した場合、外部リンクから取得した情報で上書き
  if( ! $post_id ){

    if ( ! class_exists( 'OpenGraph' ) ) {
      get_template_part( 'functions/OpenGraph' );
	}
    $graph = OpenGraph::fetch( $atts['url'] );
    if( $graph ){
      $date = '';
      $image_url = $graph->image;
      $title = $graph->title;
      $excerpt = $graph->description;

	}
	}
  // 画像がセットされていなければ、no image画像をセット
  if( ! $image_url ){
    $image_url = get_template_directory_uri() . '/img/no-image-300x300.gif';
  }
	
  // パラメータでタイトルが入力されていれば上書き
  if( $atts['title'] ){
    $title = $atts['title'];
  }

  // パラメータで抜粋が入力されていれば上書き
  if( $atts['excerpt'] ){
    $excerpt = $atts['excerpt'];
  }
    // カードリンクのHTMLを返す（外部リンクのサムネイル対策で、height:100%;を追加）
  return sprintf(
    '<div class="cardlink">
      <a class="cardlink_thumbnail" href="%1$s">
        <img src="%2$s" alt="%3$s" width="120" height="120" style="height:100%%;"/>
      </a>
      <div class="cardlink_content">
        %4$s
        <div class="cardlink_title">
          <a href="%1$s">%3$s</a>
        </div>
        <div class="cardlink_excerpt">%5$s</div>
      </div>
    </div>',
    esc_url( $atts['url'] ),
    esc_url( $image_url ),
    wp_strip_all_tags( $title ),
    $date ? '<span class="cardlink_timestamp">' . esc_html( $date ) . '</span>' : '',
    wp_strip_all_tags( $excerpt ),
  );
}


add_shortcode( 'clink', 'clink_scode' );

/**
 * カスタムコメント
 */
function custom_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if ( ! $commentcount ) {
		$commentcount = 0;
	}
?>
<li id="comment-<?php comment_ID(); ?>" class="c-comment__list-item comment">
	<div class="c-comment__item-header u-clearfix">
		<div class="c-comment__item-meta u-clearfix">
<?php
	if ( function_exists( 'get_avatar' ) && get_option( 'show_avatars' ) ) {
		echo get_avatar( $comment, 35, '', false, array( 'class' => 'c-comment__item-avatar' ) );
	}
	if ( get_comment_author_url() ) {
		echo '<a id="commentauthor-' . get_comment_ID() . '" class="c-comment__item-author" rel="nofollow">' . get_comment_author() . '</a>' . "\n";
	} else {
		echo '<span id="commentauthor-' . get_comment_ID() . '" class="c-comment__item-author">' . get_comment_author() . '</span>' . "\n";
	}
?>
			<time class="c-comment__item-date" datetime="<?php comment_time( 'c' ); ?>"><?php comment_time( __( 'F jS, Y', 'tcd-w' ) ); ?></time>
		</div>
		<ul class="c-comment__item-act">
<?php
	if ( 1 == get_option( 'thread_comments' ) ) :
?>
			<li><?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment-content', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __( 'REPLY', 'tcd-w' ) . '' ) ) ); ?></li>
<?php
	else :
?>
			<li><a href="javascript:void(0);" onclick="MGJS_CMT.reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'js-comment__textarea');"><?php _e( 'REPLY', 'tcd-w' ); ?></a></li>
<?php
	endif;
?>
		<?php edit_comment_link( __( 'EDIT', 'tcd-w' ), '<li>', '</li>'); ?>
		</ul>
	</div>
	<div id="comment-content-<?php comment_ID() ?>" class="c-comment__item-body">
<?php
	if ( 0 == $comment->comment_approved ) {
		echo '<span class="c-comment__item-note">' . __( 'Your comment is awaiting moderation.', 'tcd-w' ) . '</span>' . "\n";
	} else {
		comment_text();
	}
?>
	</div>
<?php
}

/**
 * トップページタブ ページャーajax
 */
function ajax_index_tab_pagenate() {
	if ( isset( $_POST['tab'], $_POST['page'] ) ) {
		global $tab_index, $ajax_index_tab_paged, $dp_options;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		$tab_index = intval( $_POST['tab'] );
		$ajax_index_tab_paged = intval( $_POST['page'] );

		if ( isset( $dp_options['index_tab_list_type' . $tab_index] ) && 'type5' == $dp_options['index_tab_list_type' . $tab_index]  && $ajax_index_tab_paged > 0 ) {
			//  先頭固定表示有効の場合はis_homeでないと反映されないためアクションでis_home化
			add_action( 'pre_get_posts', '_ajax_index_tab_pagenate_pre_get_posts' );

			get_template_part( 'template-parts/index-tab-content' );
		}
	}
	exit();
}
add_action( 'wp_ajax_index_tab_pagenate', 'ajax_index_tab_pagenate' );
add_action( 'wp_ajax_nopriv_index_tab_pagenate', 'ajax_index_tab_pagenate' );
function _ajax_index_tab_pagenate_pre_get_posts($wp_query) {
	$wp_query->is_home = true;
}


// Theme options
require get_template_directory() . '/admin/theme-options.php';

// Co-Authors Plus
require get_template_directory() . '/functions/co-authors-plus/co-authors-plus.php';

// Simple Local Avatars
require get_template_directory() . '/functions/simple-local-avatars/simple-local-avatars.php';

// Add custom columns
require get_template_directory() . '/functions/admin_column.php';

// Category custom fields
require get_template_directory() . '/functions/category.php';

// Custom CSS
require get_template_directory() . '/functions/custom_css.php';

// Add quicktags to the visual editor
require get_template_directory() . '/functions/custom_editor.php';

// hook wp_head
require get_template_directory() . '/functions/head.php';

// Mega menu
require get_template_directory() . '/functions/megamenu.php';

// Native advertisement
require get_template_directory() . '/functions/native_ad.php';

// OGP
require get_template_directory() . '/functions/ogp.php';

// Recommend post
require get_template_directory() . '/functions/recommend.php';

// Page builder
require get_template_directory() . '/pagebuilder/pagebuilder.php';

// Post custom fields
require get_template_directory() . '/functions/post_cf.php';

// Page custom fields
require get_template_directory() . '/functions/page_cf.php';
require get_template_directory() . '/functions/page_cf2.php';
require get_template_directory() . '/functions/page_ranking_cf.php';

// Password protected pages
require get_template_directory() . '/functions/password_form.php';

// Show custom fields in quick edit
require get_template_directory() . '/functions/quick_edit.php';

// Meta title and description
require get_template_directory() . '/functions/seo.php';

// Shortcode
require get_template_directory() . '/functions/short_code.php';

// Views
require get_template_directory() . '/functions/views.php';

// User profile
require get_template_directory() . '/functions/user_profile.php';

// セットアップ -------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/functions/theme-setup.php' );

// Update notifier
require get_template_directory() . '/functions/update_notifier.php';

// マニュアル 
require get_template_directory() . '/functions/manual.php';

// カスタマイザー設定( 外観 > ウィジェットから設定を取り除く
require get_template_directory() . '/functions/customizer.php';

// 「トップページ」と「ブログ一覧ページ」用の固定ページ作成機能の実装----------------------------------
require_once  ( dirname(__FILE__) . '/functions/class-page-new.php' );

// 新フォント機能 --------------------------------------------------------------------------------
require_once ( dirname(__FILE__) . '/admin/font/hooks-font.php' );

// Widgets
require get_template_directory() . '/widget/ad.php';
require get_template_directory() . '/widget/archive_list.php';
require get_template_directory() . '/widget/category_list.php';
require get_template_directory() . '/widget/google_search.php';
require get_template_directory() . '/widget/styled_post_list1.php';
require get_template_directory() . '/widget/ranking_list.php';
require get_template_directory() . '/widget/site_info.php';


// ウィジェットブロックエディターを無効化 --------------------------------------------------------------------------------
function exclude_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'exclude_theme_support' );

// プラグインインストーラー
require_once get_template_directory() . '/functions/class-plugin-installer.php';


// videoタグやyoutubeの自動再生に対応しているか判定 ----------------------------------------------
// Android 標準ブラウザは不可、Android版 Chrome ver53以下は不可、iOS ver10以下は不可、それ以外は再生を許可
function auto_play_movie() {
  $ua = mb_strtolower($_SERVER['HTTP_USER_AGENT']);
  // Android -----------------------------------
  if( preg_match('/android/ui', $ua) ) {
    //echo 'Android<br />';
    // 標準ブラウザ
    if (strpos($ua, 'android') !== false && strpos($ua, 'linux; u;') !== false && strpos($ua, 'chrome') === false) {
      return FALSE;
    // Chrome
    } elseif ( preg_match('/(chrome)\/([0-9\.]+)/', $ua , $matches) ){
      $match = (float) $matches[2];
      $version = floor($match);
      if($version < 53){
        return FALSE;
      } else {
        return TRUE;
      }
    } else {
      return TRUE;
    }
  // iOS ---------------------------------------
  } elseif(preg_match('/iphone|ipod|ipad/ui', $ua)) {
    //echo 'iOS<br />';
    if ( preg_match('/(iphone|ipod|ipad) os ([0-9_]+)/', $ua, $matches) ) {
      $matches[2] = (float) str_replace('_', '.', $matches[2]);
      $version = floor($matches[2]);
      if($version < 10){
        return FALSE;
      } else {
        return TRUE;
      }
    } else {
      return TRUE;
    }
  // PC等、その他のOS ---------------------------------------
  } else {
    //echo 'OTHER OS<br />';
    return TRUE;
  }
}

// 埋め込みコンテンツのレスポンシブ化
add_theme_support( 'responsive-embeds' );

/**
 * PWAプラグイン未インストール時のメッセージ
 *
 * NOTE: TCDユーザーがPWAプラグインを知る・使うための導線を作るために用意
 */
add_action( 'admin_notices', 'tcd_pwa_admin_notice' );
function tcd_pwa_admin_notice(){
  global $plugin_page;

  // テーマオプションページ以外では表示しない
  if( $plugin_page !== 'theme_options' ){
    return;
  }

  // TCD PWA が有効化されていれば表示しない
  if( defined( 'TCDPWA_ACTIVE' ) && TCDPWA_ACTIVE ){
    return;
  }

  // チェックしたいプラグインのメインファイルを指定
  $target_plugin_file = 'tcd-pwa/tcd-pwa.php';

  // すべてのインストール済みプラグインを取得
  $installed_plugins = get_plugins();

  // インストール済みなら終了
  if( isset( $installed_plugins[$target_plugin_file] ) ){
    return;
  }

  // notice作成
  printf(
    '<div class="notice notice-info is-dismissible">
      <p>%1$s</p>
      <p>
        <a class="button" href="%2$s" target="_blank">%3$s</a>
        <a class="button button-primary" href="%4$s" target="_blank">%5$s</a>
      </p>
    </div>',
    // TCDテーマをPWA化できるプラグイン「TCD Progressive Web Apps」を利用できます。
    __( 'The TCD Progressive Web Apps plugin is available to convert TCD themes into PWAs.','tcd-w'  ),
    // 解説記事URL
    'https://tcd-theme.com/2025/05/tcd-pwa.html',
    // 設定・使い方
    __( 'Settings/How to use','tcd-w'  ),
    // マイページの商品URL
    'https://tcd.style/order-history?pname=TCD+Progressive+Web+Apps',
    // 今すぐインストール
    __( 'Install Now','tcd-w' )
  );
}

/**
 * 管理画面 サイトヘルスのWP情報にユーザーエージェント追加
 *
 * NOTE: カスタマーサポート対策
 */
add_filter( 'debug_information', 'tcd_add_debug_information' );
function tcd_add_debug_information( $info ) {
  if( isset( $info['wp-core']['fields'] ) ){
    $info['wp-core']['fields']['user_agent'] = [
      'label' => 'User Agent',
      'value' => $_SERVER['HTTP_USER_AGENT'] ?? 'UA could not be retrieved',
    ];
  }
  return $info;
}