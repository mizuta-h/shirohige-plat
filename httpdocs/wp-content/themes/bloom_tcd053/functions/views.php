<?php

/**
 * アクセス数機能を有効にするフラグ
 */
if ( ! defined( 'TCD_ENABLE_VIEWS' ) ) {
	define( 'TCD_ENABLE_VIEWS', true );
}

/**
 * 期間アクセス数テーブルを使用するフラグ
 */
if ( ! defined( 'TCD_USE_VIEWS_RANGE_TABLE' ) ) {
	define( 'TCD_USE_VIEWS_RANGE_TABLE', true );
}

/**
 * 期間アクセス数テーブルの1年より前のデータを定期的に削除・最適化するフラグ
 */
if ( ! defined( 'TCD_DELETE_OLD_DATA_FROM_VIEWS_RANGE_TABLE' ) ) {
	define( 'TCD_DELETE_OLD_DATA_FROM_VIEWS_RANGE_TABLE', true );
}

/**
 * カスタムフィールドのアクセス数を使用するフラグ
 */
if ( ! defined( 'TCD_USE_VIEWS_CUSTOM_FIELD' ) ) {
	define( 'TCD_USE_VIEWS_CUSTOM_FIELD', true );
}

/**
 * カスタムフィールドのアクセス数をメタボックスで変更可能にするフラグ
 */
if ( ! defined( 'TCD_VIEWS_CUSTOM_FIELD_EDITABLE' ) ) {
	define( 'TCD_VIEWS_CUSTOM_FIELD_EDITABLE', false );
}

/**
 * カスタムフィールドのアクセス数をクイック編集で変更可能にするフラグ
 */
if ( ! defined( 'TCD_VIEWS_CUSTOM_FIELD_QUICKEDITABLE' ) ) {
	define( 'TCD_VIEWS_CUSTOM_FIELD_QUICKEDITABLE', false );
}

/**
 * カスタムフィールドのアクセス数を一覧カラムに表示するフラグ
 */
if ( ! defined( 'TCD_SHOW_VIEWS_CUSTOM_FIELD_ADMIN_COLMUN' ) ) {
	define( 'TCD_SHOW_VIEWS_CUSTOM_FIELD_ADMIN_COLMUN', true );
}

/**
 * キャッシュする場合の初期秒数
 */
if ( ! defined( 'TCD_VIEWS_CACHE_DEFAULT_SECONDES' ) ) {
	define( 'TCD_VIEWS_CACHE_DEFAULT_SECONDES', HOUR_IN_SECONDS );
}

/**
 * アクセス数対象の投稿タイプを配列を返す
 *
 * @return array
 */
function get_post_views_post_types() {
	if ( ! TCD_ENABLE_VIEWS ) {
		return array();
	}

	$post_views_post_types = array( 'post','page');
	//$post_views_post_types = get_post_types( array( 'public' => true ), 'names' );
	return (array) apply_filters( 'get_post_views_post_types', $post_views_post_types );
}

/**
 * アクセス数出力関数
 *
 * @param string|int     $post_id       Post ID.
 * @param string         $view_range    期間指定 [ '' | day | daily | week | weekly | month | monthly | year | yearly ]
 * @param int|null|false $cache_seconds キャッシュ秒数 nullでTCD_VIEWS_CACHE_DEFAULT_SECONDESを使用、falseでキャッシュ無し
 * @return void
 */
function the_post_views( $post_id = null, $view_range = null, $cache_seconds = null ) {
	echo get_post_views( $post_id, $view_range, $cache_seconds );
}

/**
 * アクセス数取得関数
 *
 * @param string|int     $post_id       Post ID.
 * @param string         $view_range    期間指定 [ '' | day | daily | week | weekly | month | monthly | year | yearly ]
 * @param int|null|false $cache_seconds キャッシュ秒数 nullでTCD_VIEWS_CACHE_DEFAULT_SECONDESを使用、falseでキャッシュ無し
 * @return int|null
 */
function get_post_views( $post_id = null, $view_range = null, $cache_seconds = null ) {
	if ( ! TCD_ENABLE_VIEWS ) {
		return null;
	}

	if ( isset( $post_id->ID ) ) {
		$post_id = $post_id->ID;
	}
	if ( ! $post_id && ! empty( $GLOBALS['post']->ID ) ) {
		$post_id = $GLOBALS['post']->ID;
	}

	$post_id = (int) $post_id;

	if ( 0 >= $post_id ) {
		return 0;
	}

	$view_range = strtolower( $view_range );
	if ( ! in_array( $view_range, array( 'day', 'daily', 'week', 'weekly', 'month', 'monthly', 'year', 'yearly' ), true ) ) {
		$view_range = '';
	}

	if ( ! $view_range && TCD_USE_VIEWS_CUSTOM_FIELD ) {
		return (int) get_post_meta( $post_id, '_views', true );
	}

	if ( TCD_USE_VIEWS_RANGE_TABLE && exists_table_views() ) {
		// キャッシュ対応
		$cache_key = null;
		if ( null === $cache_seconds ) {
			$cache_seconds = TCD_VIEWS_CACHE_DEFAULT_SECONDES;
		}
		if ( is_int( $cache_seconds ) && 0 < $cache_seconds ) {
			$cache_key = 'tcd_views_' . md5( serialize( compact( 'post_id', 'view_range' ) ) );
			$result = get_transient( $cache_key );
			if ( false !== $result ) {
				return $result;
			}
		}

		global $wpdb;

		// テーブル名
		$tablename = $wpdb->prefix . 'tcd_post_views';

		// 期間指定値からfrom日時タイムスタンプ計算
		if ( ! $view_range ) {
			$from_ts = 0;
		} elseif ( in_array( $view_range, array( '24h', 'day', 'daily' ), true ) ) {
			$from_ts = current_time( 'timestamp', true ) - DAY_IN_SECONDS;
		} elseif ( in_array( $view_range, array( 'week', 'weekly' ), true ) ) {
			$from_ts = current_time( 'timestamp', true ) - WEEK_IN_SECONDS;
		} elseif ( in_array( $view_range, array( 'month', 'monthly' ), true ) ) {
			$from_ts = strtotime( '-1 month', current_time( 'timestamp', true ) );
		} elseif ( in_array( $view_range, array( 'year', 'yearly' ), true ) ) {
			$from_ts = current_time( 'timestamp', true ) - YEAR_IN_SECONDS;
		} else {
			$from_ts = 0;
		}

		if ( $from_ts ) {
			$sql = "SELECT COUNT(id) FROM {$tablename} WHERE post_id = {$post_id} AND datetime_gmt >= %s";
			$result = (int) $wpdb->get_var( $wpdb->prepare( $sql, date( 'Y-m-d H:i:s', $from_ts ) ) );
		} else {
			$sql = "SELECT COUNT(id) FROM {$tablename} WHERE post_id = {$post_id}";
			$result = (int) $wpdb->get_var( $sql );
		}

		// キャッシュ対応
		if ( $cache_key ) {
			set_transient( $cache_key, $result, $cache_seconds );
		}

		return $result;
	}

	return 0;
}

/**
 * アクセス数ランキング記事一覧取得関数 キャッシュ対応版
 *
 * @param string $view_range    期間指定 [ '' | day | daily | week | weekly | month | monthly | year | yearly ]
 * @param string $query_args    WP_Queryの引数指定
 * @param string $output_type   出力形式 [ ''（WP_Query以外） | WP_Query ]
 * @param int|null|false $cache_seconds キャッシュ秒数 nullでTCD_VIEWS_CACHE_DEFAULT_SECONDESを使用、falseでキャッシュ無し
 * @return WP_Query|array
 *
 * 期間アクセス数テーブルからランキング一覧作成する場合（期間指定ありもしくはカスタムフィールドアクセス数未使用）戻り値のpost->viewsにアクセス数が入ります。またアクセス数が0のものは戻り値に含まれません。
 */
function get_posts_views_ranking( $view_range = null, $query_args = array(), $output_type = null, $cache_seconds = null ) {
	if ( ! TCD_ENABLE_VIEWS ) {
		if ( 'wp_query' === strtolower( $output_type ) ) {
			$_wp_query = new WP_Query();
			return $_wp_query;
		} else {
			return array();
		}
	}

	// キャッシュ初期秒数使用
	if ( null === $cache_seconds ) {
		$cache_seconds = TCD_VIEWS_CACHE_DEFAULT_SECONDES;
	}

	// キャッシュ秒数あり
	if ( is_int( $cache_seconds ) && 0 < $cache_seconds ) {
		$cache_key = 'tcd_views_' . md5( serialize( compact( 'view_range', 'query_args', 'output_type' ) ) );

		$results = get_transient( $cache_key );
		if ( false === $results ) {
			$results = _get_posts_views_ranking( $view_range, $query_args, $output_type );
			set_transient( $cache_key, $results, $cache_seconds );
		}

		return $results;
	}

	// キャッシュ秒数なし
	return _get_posts_views_ranking( $view_range, $query_args, $output_type );
}

/**
 * アクセス数ランキング記事一覧取得 サブ関数
 *
 * @param string $view_range    期間指定 [ '' | day | daily | week | weekly | month | monthly | year | yearly ]
 * @param string $query_args    WP_Queryの引数指定
 * @param string $output_type   出力形式 [ ''（WP_Query以外） | WP_Query ]
 * @return WP_Query|array
 *
 * 期間アクセス数テーブルからランキング一覧作成する場合（期間指定ありもしくはカスタムフィールドアクセス数未使用）戻り値のpost->viewsにアクセス数が入ります。またアクセス数が0のものは戻り値に含まれません。
 */
function _get_posts_views_ranking( $view_range = null, $query_args = array(), $output_type = null ) {
	$query_args_defaults = array(
		'ignore_sticky_posts' => 1
	);
	$query_args = wp_parse_args( (array) $query_args, $query_args_defaults );

	$view_range = strtolower( $view_range );
	if ( ! in_array( $view_range, array( 'day', 'daily', 'week', 'weekly', 'month', 'monthly', 'year', 'yearly' ), true ) ) {
		$view_range = '';
	}

	$output_type = strtolower( $output_type );

	if ( ! $view_range && TCD_USE_VIEWS_CUSTOM_FIELD ) {
		// カスタムフィールドアクセス数降順
		$query_args2 = $query_args;
		$query_args2['meta_key'] = '_views';
		$query_args2['orderby'] = 'meta_value_num';
		$query_args2['order'] = 'DESC';
		if ( isset( $query_args2['meta_value'] ) ) {
			unset( $query_args2['meta_value'] );
		}

		$_wp_query = new WP_Query( $query_args2 );

		// ランダム対応
		if ( ! empty( $query_args['orderby'] ) && 'rand' === $query_args['orderby'] && $_wp_query->posts ) {
			mt_shuffle( $_wp_query->posts );
		}

		if ( 'wp_query' === $output_type ) {
			return $_wp_query;
		} else {
			return (array) $_wp_query->posts;
		}
	}

	if ( TCD_USE_VIEWS_RANGE_TABLE && exists_table_views() ) {
		// 期間指定をグローバル変数にセット
		$GLOBALS['_view_range'] = $view_range;

		// posts_clausesフィルター追加
		add_filter( 'posts_clauses', '_get_posts_views_ranking_posts_clauses', 999, 2 );

		// WP Query実行
		$_wp_query = new WP_Query( $query_args );

		// posts_clausesフィルター削除
		remove_filter( 'posts_clauses', '_get_posts_views_ranking_posts_clauses', 999, 2 );

		// グローバル変数の期間指定を削除
		unset( $GLOBALS['_view_range'] );

		// ランダム対応
		if ( ! empty( $query_args['orderby'] ) && 'rand' === $query_args['orderby'] && $_wp_query->posts ) {
			mt_shuffle( $_wp_query->posts );
		}

		if ( 'wp_query' === $output_type ) {
			return $_wp_query;
		} else {
			return (array) $_wp_query->posts;
		}
	}

	if ( 'wp_query' === $output_type ) {
		$_wp_query = new WP_Query();
		return $_wp_query;
	} else {
		return array();
	}
}

/**
 * アクセス数ランキング記事一覧取得用posts_clausesフィルター
 *
 * @param string[] $clauses Associative array of the clauses for the query.
 * @param WP_Query $query   The WP_Query instance (passed by reference).
 * @return string[]
 */
function _get_posts_views_ranking_posts_clauses( $clauses, $wp_query ) {
	if ( TCD_ENABLE_VIEWS && TCD_USE_VIEWS_RANGE_TABLE && exists_table_views() ) {
		// グローバル変数に期間指定があれば
		if ( isset( $GLOBALS['_view_range'] ) ) {
			$view_range = $GLOBALS['_view_range'];

			global $wpdb;

			// テーブル名
			$tablename = $wpdb->prefix . 'tcd_post_views';

			// fields
			$clauses['fields'] .= ", COUNT(DISTINCT post_views.id) AS views";

			// join
			$clauses['join'] .= " INNER JOIN {$tablename} AS post_views ON ({$wpdb->posts}.ID = post_views.post_id)";

			// groupby
			$clauses['groupby'] = "{$wpdb->posts}.ID";

			// orderby
			$clauses['orderby'] = "views DESC, " . $clauses['orderby'];

			// 期間指定値からfrom日時タイムスタンプ計算
			if ( in_array( $view_range, array( '24h', 'day', 'daily' ), true ) ) {
				$from_ts = current_time( 'timestamp', true ) - DAY_IN_SECONDS;
			} elseif ( in_array( $view_range, array( 'week', 'weekly' ), true ) ) {
				$from_ts = current_time( 'timestamp', true ) - WEEK_IN_SECONDS;
			} elseif ( in_array( $view_range, array( 'month', 'monthly' ), true ) ) {
				$from_ts = strtotime( '-1 month', current_time( 'timestamp', true ) );
			} elseif ( in_array( $view_range, array( 'year', 'yearly' ), true ) ) {
				$from_ts = current_time( 'timestamp', true ) - YEAR_IN_SECONDS;
			} else {
				$from_ts = null;
			}

			if ( $from_ts ) {
				// where
				$clauses['where'] .= " AND post_views.datetime_gmt >= '" . date( 'Y-m-d H:i:s', $from_ts ) . "'";
			}
		}
	}

	return $clauses;
}

if ( ! function_exists( 'mt_shuffle' ) ) :
	/**
	 * shuffle()の偏り対策
	 *
	 * @param array $array Array to shuffle (passed by reference).
	 * @return int[]
	 */
	function mt_shuffle( array &$array ) {
		$array = array_values( $array );
		for ( $i = count( $array ) - 1; $i > 0; --$i ) {
			$j = mt_rand( 0, $i );
			if ( $i !== $j ) {
				list( $array[ $i ], $array[ $j ] ) = array( $array[ $j ], $array[ $i ] );
			}
		}
	}
endif;

/**
 * アクセス数機能が有効の場合
 */
if ( TCD_ENABLE_VIEWS && ( TCD_USE_VIEWS_RANGE_TABLE || TCD_USE_VIEWS_CUSTOM_FIELD ) ) :

	/**
	 * アクセス数メタボックス追加
	 *
	 * @return void
	 */
	function add_views_meta_box() {
		add_meta_box(
			'views',
			__( 'Views', 'tcd-w' ),
			'show_views_meta_box',
			get_post_views_post_types(),
			'side',
			'low'
		);
	}
	add_action( 'add_meta_boxes', 'add_views_meta_box', 55 );

	/**
	 * アクセス数メタボックス表示
	 *
	 * @return void
	 */
	function show_views_meta_box() {
		global $post;

		if ( TCD_USE_VIEWS_CUSTOM_FIELD && TCD_VIEWS_CUSTOM_FIELD_EDITABLE ) :
?>
<input type="hidden" name="views_meta_box_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
<p>
	<input type="number" name="_views" value="<?php echo intval( get_post_meta( $post->ID, '_views', true ) ); ?>" class="large-text" readonly="readonly" />
	<label><input type="checkbox" name="edit_views" value="1" /><?php _e( 'Edit views', 'tcd-w' ); ?></label>
</p>
<script>
jQuery(function($){
	$(':checkbox[name="edit_views"]').change(function(){
		if (this.checked) {
			$(this).closest('.inside').find('input[name="_views"]').removeAttr('readonly');
		} else {
			$(this).closest('.inside').find('input[name="_views"]').attr('readonly', 'readonly');
		}
	});
});
</script>
<?php
		endif;

		$html = '';

		if ( TCD_USE_VIEWS_CUSTOM_FIELD && ! TCD_VIEWS_CUSTOM_FIELD_EDITABLE ) {
			$html .= '<tr><td>' . __( 'Total views', 'tcd-w' ) . '</td><td class="textright">' . intval( get_post_meta( $post->ID, '_views', true ) ) . "</td></tr>\n";
		} elseif ( ! TCD_USE_VIEWS_CUSTOM_FIELD && TCD_USE_VIEWS_RANGE_TABLE ) {
			$html .= '<tr><td>' . __( 'Total views', 'tcd-w' ) . '</td><td class="textright">' . get_post_views( $post->ID, '' ) . "</td></tr>\n";
		}

		if ( TCD_USE_VIEWS_RANGE_TABLE ) {
			$html .= '<tr><td>' . __( 'Daily views', 'tcd-w' ) . '</td><td class="textright">' . get_post_views( $post->ID, 'daily' ) . "</td></tr>\n";
			$html .= '<tr><td>' . __( 'Weekly views', 'tcd-w' ) . '</td><td class="textright">' . get_post_views( $post->ID, 'weekly' ) . "</td></tr>\n";
			$html .= '<tr><td>' . __( 'Monthly views', 'tcd-w' ) . '</td><td class="textright">' . get_post_views( $post->ID, 'monthly' ) . "</td></tr>\n";
			$html .= '<tr><td>' . __( 'Yearly views', 'tcd-w' ) . '</td><td class="textright">' . get_post_views( $post->ID, 'yearly' ) . "</td></tr>\n";
		}

		if ( $html ) {
			echo "<table class=\"widefat\">\n" . $html . "</table>\n";
		}
	}

	/**
	 * アクセス数メタボックス保存
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 * @param bool    $update  Whether this is an existing post being updated.
	 * @return void
	 */
	function save_views_meta_box( $post_id, $post, $update ) {
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// _viewsカスタムフィールドが空なら0をセット
		if ( ! empty( $post->post_type ) && in_array( $post->post_type, get_post_views_post_types(), true ) && '' === get_post_meta( $post_id, '_views', true ) ) {
			update_post_meta( $post_id, '_views', 0 );
		}

		if ( ! TCD_USE_VIEWS_CUSTOM_FIELD ) {
			return $post_id;
		}

		// verify nonce
		if ( ! isset( $_POST['views_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['views_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// check permissions
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// save カスタムフィールドのリビジョン・プレビュー対応はしない
		if ( ! empty( $_POST['edit_views'] ) && isset( $_POST['_views'] ) ) {
			update_post_meta( $post_id, '_views', intval( $_POST['_views'] ) );
		}

		return $post_id;
	}
	add_action( 'save_post', 'save_views_meta_box', 10, 3 );

endif;

/**
 * カスタムフィールドのアクセス数をクイック編集で変更可能な場合
 */
if ( TCD_ENABLE_VIEWS && TCD_VIEWS_CUSTOM_FIELD_QUICKEDITABLE && TCD_USE_VIEWS_CUSTOM_FIELD ) :

	/**
	 * クイック編集に項目を追加
	 *
	 * @param string $column_name Name of the column to edit.
	 * @param string $post_type   The post type slug, or current screen name if this is a taxonomy list table.
	 * @param string $taxonomy    The taxonomy name, if any.
	 * @return void|false
	 */
	function views_quick_edit_custom_box( $column_name, $post_type, $taxonomy = null ) {
		if ( ! in_array( $post_type, get_post_views_post_types(), true ) ) {
			return false;
		}

		// 1度だけ出力させる
		static $print_nonce = true;
		if ( $print_nonce ) {
			$print_nonce = false;
?>
<input type="hidden" name="views_meta_box_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
<fieldset class="inline-edit-col-right">
	<div class="inline-edit-col column-views">
		<div class="inline-edit-group">
			<label class="inline-edit-views" style="float:left;margin-right:1em;">
				<span class="title"><?php _e( 'Views', 'tcd-w' ); ?></span>
				<span class="input-text-wrap"><input type="number" name="_views" value="" readonly="readonly" style="width:6em;" />
			</label>
			<label class="inline-edit-views" style="padding-top:0.2em;">
				<input type="checkbox" name="edit_views" value="1" /> <?php _e( 'Edit views', 'tcd-w' ); ?>
			</label>
		</div>
	</div>
</fieldset>
<?php
		}
	}
	add_action( 'quick_edit_custom_box', 'views_quick_edit_custom_box', 20, 3 );

	/**
	 * クイック編集用でフォームに差し込む値
	 * get_inline_dataにはフィルターがないためpost_row_actionsで処理
	 * quick_edit.php内の処理より後に実行し、$actions['custom_quick_edit_values']に追記すること
	 *
	 * @param string[] $actions An array of row action links.
	 * @param WP_Post  $post    The post object.
	 * @return string[]
	 */
	function views_custom_quick_edit_values( $actions, $post ) {
		if ( ! in_array( $post->post_type, get_post_views_post_types(), true ) ) {
			return $actions;
		}

		if ( ! isset( $actions['custom_quick_edit_values'] ) ) {
			$actions['custom_quick_edit_values'] = '';
		}
		$actions['custom_quick_edit_values'] .= '<div class="hidden"><div class="_views">' . esc_html( intval( get_post_meta( $post->ID, '_views', true ) ) ) . '</div></div>';
		return $actions;
	}
	add_action( 'post_row_actions', 'views_custom_quick_edit_values', 100, 2 );
	add_action( 'page_row_actions', 'views_custom_quick_edit_values', 100, 2 );

	/**
	 * クイック編集用js
	 * 別途quick_edit.phpのjs出力が必要
	 *
	 * @return void
	 */
	function views_quick_edit_js() {
?>
<script>
jQuery(function($){
	$(':checkbox[name="edit_views"]').change(function(){
		if (this.checked) {
			$(this).closest('.column-views').find('input[name="_views"]').removeAttr('readonly');
		} else {
			$(this).closest('.column-views').find('input[name="_views"]').attr('readonly', 'readonly');
		}
	});
});
</script>
<?php
	}
	add_action( 'admin_footer-edit.php', 'views_quick_edit_js' );

endif;

/**
 * カスタムフィールドのアクセス数を一覧カラムに表示する場合
 */
if ( TCD_ENABLE_VIEWS && TCD_SHOW_VIEWS_CUSTOM_FIELD_ADMIN_COLMUN && TCD_USE_VIEWS_CUSTOM_FIELD ) :

	/**
	 * 一覧カラムinit
	 *
	 * @return void
	 */
	function views_admin_colmun_init() {
		foreach ( get_post_views_post_types() as $post_type ) {
			add_filter( 'manage_' . $post_type . '_posts_columns', 'cf_views_posts_columns', 10 );
			add_action( 'manage_' . $post_type . '_posts_custom_column', 'cf_views_posts_custom_column', 10, 2 );
			add_filter( 'manage_edit-' . $post_type . '_sortable_columns', 'cf_views_sortable_columns', 10 );
		}

		add_action( 'parse_query', 'cf_views_sortable_columns_query', 20 );
	}
	add_action( 'admin_init', 'views_admin_colmun_init' );

	/**
	 * 一覧カラム追加
	 *
	 * @param string[] $post_columns An associative array of column headings.
	 * @return string[]
	 */
	function cf_views_posts_columns( $columns ) {
		$columns['views'] = __( 'Views', 'tcd-w' );
		return $columns;
	}

	/**
	 * 一覧カラム表示
	 *
	 * @param string $column_name The name of the column to display.
	 * @param int    $post_id     The current post ID.
	 * @return void
	 */
	function cf_views_posts_custom_column( $column_name, $post_id ) {
		if ( 'views' === $column_name ) {
			echo intval( get_post_meta( $post_id, '_views', true ) );
		}
	}

	/**
	 * 一覧ソートカラム
	 *
	 * @param string[] $sortable_columns An array of sortable columns.
	 * @return string[]
	 */
	function cf_views_sortable_columns( $sortable_columns ) {
		$sortable_columns['views'] = 'views';
		return $sortable_columns;
	}

	/**
	 * ソートクエリー
	 *
	 * @param WP_Query $query The WP_Query instance (passed by reference).
	 * @return void
	 */
	function cf_views_sortable_columns_query( $wp_query ) {
		// 管理画面のメインクエリー以外は終了
		if ( ! is_admin() || ! $wp_query->is_main_query() ) {
			return;
		}

		// アクセス数ソート
		if ( isset( $_REQUEST['orderby'] ) && 'views' === $_REQUEST['orderby'] ) {
			$wp_query->set( 'orderby', 'meta_value_num' );
			$wp_query->set( 'meta_key', '_views' );
		}
	}

endif;

/**
 * 期間アクセス数テーブル存在チェック
 *
 * @return bool
 */
function exists_table_views() {
	static $exists_table_views = null;

	if ( $exists_table_views !== null ) {
		return $exists_table_views;
	}

	global $wpdb;

	// テーブル名
	$tablename = $wpdb->prefix . 'tcd_post_views';

	// テーブルあり
	if ( $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
		$exists_table_views = true;
	} else {
		$exists_table_views = false;
	}

	return $exists_table_views;
}

/**
 * 期間アクセス数テーブルを使用する場合
 */
if ( TCD_ENABLE_VIEWS && TCD_USE_VIEWS_RANGE_TABLE ) :

	/**
	 * テーブル作成
	 *
	 * @return bool
	 */
	function create_table_views() {
		// セキュリティ確保の為権限チェック
		if ( ! current_user_can( 'edit_themes' ) ) {
			return false;
		}

		global $wpdb;

		// テーブル名
		$tablename = $wpdb->prefix . 'tcd_post_views';

		// テーブルあり
		if ( $wpdb->get_var( "show tables like '{$tablename}'" ) == $tablename ) {
			return true;
		}

		// テーブルが存在しなければテーブル作成
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `{$tablename}` (
			`id` bigint unsigned NOT NULL AUTO_INCREMENT,
			`post_id` bigint unsigned NOT NULL DEFAULT '0',
			`datetime_gmt` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `post_id` (`post_id`),
			KEY `datetime_gmt` (`datetime_gmt`)
		) {$charset_collate} ;";

		dbDelta( $sql );

		if ( $wpdb->get_var( "show tables like '{$tablename}' " ) == $tablename ) {
			return true;
		}

		return false;
	}
	add_action( 'after_switch_theme', 'create_table_views' );

	/**
	 * レコード追加
	 *
	 * @param string|int $post_id Post ID.
	 * @return int|false
	 */
	function insert_table_views( $post_id ) {
		if ( ! exists_table_views() ) {
			return false;
		}

		global $wpdb;

		// テーブル名
		$tablename = $wpdb->prefix . 'tcd_post_views';

		$post_id = (int) $post_id;
		if ( 0 < $post_id ) {
			return $wpdb->insert(
				$tablename,
				array(
					'post_id' => $post_id,
					'datetime_gmt' => current_time( 'mysql', true )
				),
				array(
					'%d',
					'%s'
				)
			);
		}

		return false;
	}

	/**
	 * 期間アクセス数テーブルの1年より前のデータを削除・最適化する処理
	 *
	 * @return void
	 */
	function tcd_optimize_table_views() {
		// 無効もしくはテーブル無しの場合
		if ( ! TCD_DELETE_OLD_DATA_FROM_VIEWS_RANGE_TABLE || apply_filters( 'disable_delete_old_data_from_table_views', false ) || ! exists_table_views() ) {
			return;
		}

		global $wpdb;

		// テーブル名
		$tablename = $wpdb->prefix . 'tcd_post_views';

		// タイムアウト対策
		set_time_limit( 60 );

		// 現タイムスタンプ
		$current_ts = current_time( 'timestamp', false );
		$current_ts_gmt = current_time( 'timestamp', true );

		// 1年より前のデータを削除
		$result = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$tablename} WHERE datetime_gmt < %s",
				date( 'Y-m-01 00:00:00', $current_ts_gmt - YEAR_IN_SECONDS )
			)
		);

		if ( $result ) {
			// テーブル最適化
			$wpdb->query( "OPTIMIZE TABLE {$tablename}" );
		}

		// 次回スケジュールを翌月1日 00:00:30（ローカル時間）に登録
		$next_event_ts = strtotime( date( 'Y-m-01 00:00:30', $current_ts_gmt ) . ' +1 month', $current_ts_gmt ) - $current_ts + $current_ts_gmt;
		wp_schedule_single_event( $next_event_ts, 'tcd_cron_optimize_table_views' );
	}
	add_action( 'tcd_cron_optimize_table_views', 'tcd_optimize_table_views' );

	/**
	 * tcd_optimize_table_viewsのスケジュール処理
	 *
	 * @return void
	 */
	function tcd_optimize_table_views_schedule() {
		// 無効もしくはテーブル無しの場合
		if ( ! TCD_DELETE_OLD_DATA_FROM_VIEWS_RANGE_TABLE || apply_filters( 'disable_delete_old_data_from_table_views', false ) || ! exists_table_views() ) {
			// 次回スケジュールがあれば削除
			if ( wp_next_scheduled( 'tcd_cron_optimize_table_views' ) ) {
				wp_unschedule_hook( 'tcd_cron_optimize_table_views' );
			}
			return;
		}

		// 次回スケジュールが無ければ翌月1日 00:00:30（ローカル時間）に登録
		if ( ! wp_next_scheduled( 'tcd_cron_optimize_table_views' ) ) {
			$current_ts = current_time( 'timestamp', false );
			$current_ts_gmt = current_time( 'timestamp', true );
			$next_event_ts = strtotime( date( 'Y-m-01 00:00:30', $current_ts_gmt ) . ' +1 month', $current_ts_gmt ) - $current_ts + $current_ts_gmt;

			wp_schedule_single_event( $next_event_ts, 'tcd_cron_optimize_table_views' );
		}
	}
	add_action( 'init', 'tcd_optimize_table_views_schedule', 10 );

endif;


if ( TCD_ENABLE_VIEWS && ( TCD_USE_VIEWS_RANGE_TABLE || TCD_USE_VIEWS_CUSTOM_FIELD ) ) :

	/**
	 * キャッシュ系プラグイン対策でajaxでのアクセス数カウントアップ用js出力
	 *
	 * @return void
	 */
	function views_wp_footer() {
		if ( is_preview() ) {
			return;
		}

		$post_views_post_types = get_post_views_post_types();
		$views_count_up = false;

		if ( $post_views_post_types ) {
			if ( is_singular( $post_views_post_types ) ) {
				$views_count_up = true;
			}
		}

		if ( $views_count_up ) {
			wp_reset_query();
			$queried_object = get_queried_object();
			if ( ! empty( $queried_object->ID ) ) {
?>
<script>
jQuery(function($) {
	jQuery.post('<?php echo admin_url( 'admin-ajax.php' ); ?>',{ action: 'views_count_up', post_id: <?php echo (int) $queried_object->ID; ?>, nonce: '<?php echo wp_create_nonce( 'views_count_up' ); ?>'});
});
</script>
<?php
			}
		}
	}
	add_action( 'wp_footer', 'views_wp_footer', 20 );

	/**
	 * ajaxでのアクセス数カウントアップ
	 *
	 * @return void
	 */
	function ajax_views_count_up() {
		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			return;
		}

		if ( isset( $_POST['post_id'], $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'views_count_up' ) ) {
			$post_id = (int) $_POST['post_id'];
			if ( 0 < $post_id && in_array( get_post_type( $post_id ), get_post_views_post_types(), true ) && in_array( get_post_status( $post_id ), array( 'publish', 'private' ), true ) ) {
				if ( TCD_USE_VIEWS_RANGE_TABLE ) {
					insert_table_views( $post_id );
				}
				if ( TCD_USE_VIEWS_CUSTOM_FIELD ) {
					update_post_meta( $post_id, '_views', intval( get_post_meta( $post_id, '_views', true ) ) + 1 );
				}
				echo 'Done';
			} else {
				echo 'Failure';
			}
			exit;
		}
	}
	add_action( 'wp_ajax_views_count_up', 'ajax_views_count_up' );
	add_action( 'wp_ajax_nopriv_views_count_up', 'ajax_views_count_up' );

endif;


// 投稿者の記事の合計ビュー数を取得
function get_author_views( $user_id ) {
	global $wpdb;

	$user_id = (int) $user_id;
	if ( 0 >= $user_id ) return 0;
	$user = get_user_by( 'id', $user_id );
	if ( ! $user ) return 0;

	// 記事ID配列取得
	$sql = "SELECT DISTINCT tr.object_id FROM $wpdb->terms AS t
		INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id
		INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id
		WHERE tt.taxonomy = 'author' AND t.slug = %s
		ORDER BY tr.object_id ASC";
	$arr_post_ids = $wpdb->get_col( $wpdb->prepare( $sql, 'cap-' . $user->user_nicename ), 0, ARRAY_A );
	if ( ! $arr_post_ids ) return 0;

	// 記事IDで絞り込み記事ビュー数_viewの合計値を取得
	$str_post_ids = implode( ',', $arr_post_ids );
	$sql = "SELECT SUM(pm.meta_value+0) FROM $wpdb->posts AS p
		INNER JOIN $wpdb->postmeta AS pm ON pm.post_id = p.ID
		WHERE p.post_type = 'post' AND p.post_status = 'publish'
		AND (p.post_author = $user_id OR p.ID IN ($str_post_ids))
		AND pm.meta_key = '_views'";
	$author_views = $wpdb->get_var( $sql );

	return (int) $author_views;
}
