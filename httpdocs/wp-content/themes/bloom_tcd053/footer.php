<?php
global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
	<footer class="l-footer">
<?php
// フッターブログスライダー
if ( ( is_front_page() && $dp_options['show_footer_blog_top'] ) || ( ! is_front_page() && $dp_options['show_footer_blog'] ) ) :
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'post',
		'posts_per_page' => $dp_options['footer_blog_num']
	);
	$footer_blog_catchphrase = '';
	$footer_blog_category = null;
	if ( $dp_options['footer_blog_catchphrase'] ) :
		$footer_blog_catchphrase = esc_html( $dp_options['footer_blog_catchphrase'] );
	endif;
	if ( 'type2' == $dp_options['footer_blog_list_type'] ) :
		$args['meta_key'] = 'recommend_post';
		$args['meta_value'] = 'on';
	elseif ( 'type3' == $dp_options['footer_blog_list_type'] ) :
		$args['meta_key'] = 'recommend_post2';
		$args['meta_value'] = 'on';
	elseif ( 'type4' == $dp_options['footer_blog_list_type'] ) :
		$args['meta_key'] = 'pickup_post';
		$args['meta_value'] = 'on';
	elseif ( $dp_options['footer_blog_category'] ) :
		$footer_blog_category = get_category( $dp_options['footer_blog_category'] );
	endif;
	if ( ! empty( $footer_blog_category ) && ! is_wp_error( $footer_blog_category ) ) :
		$args['cat'] = $footer_blog_category->term_id;
		if ( $footer_blog_catchphrase ) :
			$footer_blog_catchphrase = '<a href="' . get_category_link( $footer_blog_category ) . '">' . $footer_blog_catchphrase . '</a>';
		endif;
	else :
		$footer_blog_category = null;
	endif;
	if ( 'rand' == $dp_options['footer_blog_post_order'] ) :
		$args['orderby'] = 'rand';
	elseif ( 'date2' == $dp_options['footer_blog_post_order'] ) :
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
	else :
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	endif;
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>
		<div id="js-footer-blog" class="p-footer-blog">
			<div class="l-inner">
<?php
		if ( $footer_blog_catchphrase ) :
?>
				<h2 class="p-footer-blog__catch" style="font-size: <?php echo esc_attr( $dp_options['footer_blog_catchphrase_font_size'] ); ?>px;"><?php echo $footer_blog_catchphrase; ?></h2>
<?php
		endif;
?>
				<div id="js-footer-slider" class="p-footer-blog__list clearfix">
<?php
		$post_count = 0;
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$post_count++;

			$catlist_float = array();
			$catlist_meta = array();
			if ( $dp_options['show_footer_blog_category'] ) :
				$categories = get_the_category();
				if ( $categories && ! is_wp_error( $categories ) ) :
					// 選択カテゴリーを先に表示
					if ( $footer_blog_category ) :
						$catlist_float[] = '<span class="p-category-item--' . esc_attr( $footer_blog_category->term_id ) . '" data-url="' . get_category_link( $footer_blog_category ) . '">' . esc_html( $footer_blog_category->name ) . '</span>';
						$catlist_meta[] = '<span data-url="' . get_category_link( $footer_blog_category ) . '">' . esc_html( $footer_blog_category->name ) . '</span>';
					endif;
					foreach( $categories as $category ) :
						if ( $footer_blog_category && $footer_blog_category->term_id == $category->term_id ) continue;
						if ( ! $catlist_float ) :
							$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
						endif;
						$catlist_meta[] = '<span data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
					endforeach;
				endif;
			endif;
?>
					<article class="p-footer-blog__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-footer-blog__item-thumbnail p-hover-effect__image">
<?php
			echo "\t\t\t\t\t\t\t\t";
			if ( has_post_thumbnail() ) :
				the_post_thumbnail( 'size2' );
			else :
				echo '<img src="' . get_template_directory_uri() . '/img/no-image-500x348.gif" alt="">';
			endif;
			echo "\n";
?>
							</div>
							<div class="p-footer-blog__item-overlay p-article__overlay u-hidden-xs">
								<div class="p-footer-blog__item-overlay__inner">
									<h3 class="p-footer-blog__item-title p-article__title__overlay"><?php echo wp_trim_words( get_the_title(), 50, '...' ); ?></h3>
<?php
			if ( $dp_options['show_footer_blog_date'] ) :
?>
									<time class="p-footer-blog__item-date" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
<?php
			endif;
			if ( $dp_options['show_footer_blog_views'] ) :
?>
									<span class="p-article__views"><?php echo number_format(intval( $post->_views ) ); ?> views</span>
<?php
			endif;
			if ( $dp_options['show_footer_blog_author'] ) :
				the_archive_author();
			endif;
?>
								</div>
							</div>
							<h3 class="p-footer-blog__item-title p-article__title u-visible-xs"><?php echo wp_trim_words( get_the_title(), 30, '...' ); ?></h3>
<?php
			if ( $dp_options['show_footer_blog_date'] || $catlist_meta || $dp_options['show_footer_blog_views'] || $dp_options['show_footer_blog_author'] ) :
				echo "\t\t\t\t\t\t\t";
				echo '<p class="p-footer-blog__item-meta p-article__meta u-visible-xs">';
				if ( $dp_options['show_footer_blog_date'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( $catlist_meta ) :
					echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
				endif;
				if ( $dp_options['show_footer_blog_views'] ) :
					echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ) . ' views</span>';
				endif;
				if ( $dp_options['show_footer_blog_author'] ) :
					the_archive_author();
				endif;
				echo "</p>\n";
			endif;

			// ネイティブ内部広告
			if ( $post->show_native_ad && $post->native_ad_label ) :
?>
							<div class="p-float-native-ad-label"><?php echo esc_html( $post->native_ad_label ); ?></div>
<?php
			elseif ( $catlist_float ) :
?>
							<div class="p-footer-blog__category p-float-category"><?php echo implode( ', ', $catlist_float ); ?></div>
<?php
			endif;
?>
						</a>
					</article>
<?php
		// ネイティブ外部広告
		if ( $dp_options['show_footer_blog_native_ad'] && $dp_options['footer_blog_native_ad_position'] && 0 === ( $post_count % $dp_options['footer_blog_native_ad_position'] ) ) :
			$native_ad = get_native_ad();
			if ( $native_ad ) :
?>
					<article class="p-footer-blog__item">
						<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
							<div class="p-footer-blog__item-thumbnail p-hover-effect__image">
<?php
				if ( ! empty( $native_ad['native_ad_image'] ) ) :
					$image_src = wp_get_attachment_image_src( $native_ad['native_ad_image'], 'size2' );
				else :
					$image_src = null;
				endif;
				if ( ! empty( $image_src[0] ) ) :
					$image_src = $image_src[0];
				else :
					$image_src = get_template_directory_uri() . '/img/no-image-500x348.gif';
				endif;
				echo "\t\t\t\t\t\t\t\t";
				echo '<img src="' . esc_attr( $image_src ) . '" alt="">' . "\n";
?>
							</div>
							<div class="p-footer-blog__item-overlay p-article__overlay u-hidden-xs">
								<div class="p-footer-blog__item-overlay__inner">
									<h3 class="p-footer-blog__item-title p-article__title__overlay"><?php echo esc_html( wp_trim_words( $native_ad['native_ad_title'], 50, '...' ) ); ?></h3>
								</div>
							</div>
							<h3 class="p-footer-blog__item-title p-article__title u-visible-xs"><?php echo esc_html( wp_trim_words( $native_ad['native_ad_title'], 30, '...' ) ); ?></h3>
<?php
				if ( $native_ad['native_ad_label'] ) :
					echo "\t\t\t\t\t\t\t";
					echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
				endif;
?>
						</a>
					</article>
<?php
			endif;
		endif;

		endwhile;
		wp_reset_postdata();
?>
				</div>
			</div>
		</div>
<?php
	endif;
endif;

// フッターCTA
if ( ( is_front_page() && $dp_options['show_footer_cta_top'] ) || ( ! is_front_page() && $dp_options['show_footer_cta'] ) ) :
	get_template_part( 'template-parts/footer-cta' );
endif;

// フッターウィジェット
if ( is_mobile() ) :
	$footer_widget = 'footer_widget_mobile';
else :
	$footer_widget = 'footer_widget';
endif;
if ( is_active_sidebar( $footer_widget ) ) :
	$footer_widget_area_class = 'p-footer-widget-area';
	ob_start();
	dynamic_sidebar( $footer_widget );
	$footer_widget_html = ob_get_clean();
else :
	$footer_widget_area_class = 'p-footer-widget-area__default';
	ob_start();
	the_widget(
		'Site_Info_Widget',
		array(
			'title' => get_bloginfo( 'name' ),
			'image' => 'yes' == $dp_options['use_logo_image'] ? $dp_options['footer_logo_image'] : false,
			'image_retina' => $dp_options['footer_logo_image_retina'],
			'image_url' => home_url( '/' ),
			'image_target_blank' => 0,
			'description' => get_bloginfo( 'description' ),
			'use_sns_theme_options' => 1
		),
		array(
			'id' => $footer_widget,
			'before_widget' => '<div class="p-widget p-footer-widget site_info_widget">' . "\n",
			'after_widget' => "</div>\n",
			'before_title' => '<h2 class="p-widget__title">',
			'after_title' => '</h2>' . "\n"
		)
	);
	$footer_widget_html = ob_get_clean();
endif;
// モバイル用に最初のSNSボタンにクラス追加
$preg_replaced = 0;
$footer_widget_html = preg_replace( '/<ul class="p-social-nav/', '<ul class="p-social-nav p-social-nav__mobile', $footer_widget_html, 1, $preg_replaced );
// SNSボタン有クラス
if ( $preg_replaced ) :
	$footer_widget_area_class .= ' p-footer-widget-area__has-social-nav';
endif;
?>
		<div id="js-footer-widget" class="<?php echo esc_attr( $footer_widget_area_class ); ?>">
			<div class="p-footer-widget-area__inner l-inner">
<?php
	echo $footer_widget_html;
?>
			</div>
		</div>
		<div class="p-copyright">
			<div class="l-inner">
				<p><small>Copyright &copy;<span class="u-hidden-sm"> <?php echo date( 'Y',current_time( 'timestamp', 0 ) ); ?></span> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</small></p>
			</div>
		</div>
<?php
if ( is_mobile() && ! is_no_responsive() && 'type3' !== $dp_options['footer_bar_display'] ) :
	get_template_part( 'template-parts/footer-bar' );
endif;
?>
		<div id="js-pagetop" class="p-pagetop"><a href="#"></a></div>
	</footer>
<?php
// サイドメニュー
if ( $dp_options['show_sidemenu'] && ! is_mobile() && is_active_sidebar( 'sidemenu_widget' ) ) :
?>
	<div class="p-sidemenu">
		<div class="p-sidemenu__inner">
<?php
	dynamic_sidebar( 'sidemenu_widget' );
?>
		</div>
	</div>
	<div id="js-sidemenu-overlay" class="p-sidemenu-overlay">
		<a href="#" id="js-sidemenu-close-button" class="p-sidemenu-close-button c-sidemenu-close-button u-hidden-lg"></a>
	</div>
<?php
endif;
?>
</div><?php // #site_wrap ?>
<?php wp_footer(); ?>
<script>
jQuery(function($){

	var initialized = false;
	var initialize = function(){
		if (initialized) return;
		initialized = true;

<?php
// フロントページ
if ( is_front_page() ) :
	// 動画
	if ( 'type3' == $dp_options['header_content_type'] ) :
		if ( $dp_options['video'] && auto_play_movie() ) :
?>
		$('#js-header-video').vegas({
			timer: false,
			slides: [
				{
<?php
			if ( $dp_options['video_image'] ) :
?>
					src: '<?php echo esc_html( wp_get_attachment_url( $dp_options['video_image'] ) ); ?>',
<?php
			endif;
?>
					video: {
					src: [ '<?php echo esc_html( wp_get_attachment_url ( $dp_options['video'] ) ); ?>'],
						loop: true,
						mute: true
					},
				}
			]
		});

<?php
		endif;

	// Youtube
	elseif ( 'type4' == $dp_options['header_content_type'] ) :
		if ( $dp_options['youtube_url'] && auto_play_movie() ) :
?>
		jQuery('#js-youtube-video-player').YTPlayer();

<?php
		endif;

	// ヘッダースライダー
	elseif ( in_array( $dp_options['header_content_type'], array( 'type1', 'type2') ) ) :

?>
		init_index_slider(<?php echo absint( $dp_options['slide_time'] ); ?>, <?php echo is_no_responsive() ? 0 : 1; ?>);

<?php
	endif;
endif;

// フッターブログスライダー
if ( ( is_front_page() && $dp_options['show_footer_blog_top'] ) || ( ! is_front_page() && $dp_options['show_footer_blog'] ) ) :
?>
		init_footer_slider(<?php echo absint( $dp_options['footer_blog_slide_time'] ); ?>, <?php echo is_no_responsive() ? 0 : 1; ?>);

<?php
endif;
?>
		$('body').addClass('js-initialized');
		$(window).trigger('resize')
	};

<?php
if ( $dp_options['use_load_icon'] ) :
?>
	$(window).load(function() {
		$('#site_loader_animation:not(:hidden, :animated)').delay(600).fadeOut(400, initialize);
		$('#site_loader_overlay:not(:hidden, :animated)').delay(900).fadeOut(800);
		$('#site-wrap').css('display', 'block');
	});
	setTimeout(function(){
		$('#site_loader_animation:not(:hidden, :animated)').delay(600).fadeOut(400, initialize);
		$('#site_loader_overlay:not(:hidden, :animated)').delay(900).fadeOut(800);
		$('#site-wrap').css('display', 'block');
	}, <?php if ( $dp_options['load_time'] ) { echo esc_html( $dp_options['load_time'] ); } else { echo '5000'; } ?>);
<?php
else : // ロード画面を表示しない
?>
	initialize();
<?php
endif;
?>

});
</script>
<?php
if ( is_single() ) :
	if ( 'type5' == $dp_options['sns_type_top'] || 'type5' == $dp_options['sns_type_btm'] ) :
		if ( $dp_options['show_twitter_top'] || $dp_options['show_twitter_btm'] ) :
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php
		endif;
		if ( $dp_options['show_fblike_top'] || $dp_options['show_fbshare_top'] || $dp_options['show_fblike_btm'] || $dp_options['show_fbshare_btm'] ) :
?>
<!-- facebook share button code -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
		endif;
		if ( $dp_options['show_hatena_top'] || $dp_options['show_hatena_btm'] ) :
?>
<script type="text/javascript" src="//b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
<?php
		endif;
		if ( $dp_options['show_pocket_top'] || $dp_options['show_pocket_btm'] ) :
?>
<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
<?php
		endif;
		if ( ($dp_options['show_pinterest_top'] && $dp_options['sns_type_top'] == 'type5') || ($dp_options['show_pinterest_btm'] && $dp_options['sns_type_btm'] == 'type5') ) :
?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php
		endif;
	endif;
endif;
?>
</body>
</html>
