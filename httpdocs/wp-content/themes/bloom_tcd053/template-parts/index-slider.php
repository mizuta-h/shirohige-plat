<?php
global $dp_options, $post;
if ( ! $dp_options ) $dp_options = get_design_plus_option();

// 画像スライダー
if ( 'type2' == $dp_options['header_content_type'] ) :
?>
	<div id="js-index-slider" class="p-index-slider p-index-slider--type2">
<?php
	for ( $i = 1; $i <= 3; $i++ ) :
		$slider_image = wp_get_attachment_image_src( $dp_options['slider_image' . $i], 'size3');
		if ( empty( $slider_image[0] ) ) continue;

		$slider_shadow1 = $dp_options['slider' . $i . '_shadow1'] ? $dp_options['slider' . $i . '_shadow1'] : 0;
		$slider_shadow2 = $dp_options['slider' . $i . '_shadow2'] ? $dp_options['slider' . $i . '_shadow2'] : 0;
		$slider_shadow3 = $dp_options['slider' . $i . '_shadow3'] ? $dp_options['slider' . $i . '_shadow3'] : 0;
		$slider_shadow4 = $dp_options['slider' . $i . '_shadow_color'];
		$slider_headline_font_size = $dp_options['slider_headline_font_size' . $i] ? $dp_options['slider_headline_font_size' . $i] : 32;
		$slider_desc_font_size = $dp_options['slider_desc_font_size' . $i] ? $dp_options['slider_desc_font_size' . $i] : 16;
		$slider_overlay_color = $dp_options['slider_overlay_color' . $i] ? $dp_options['slider_overlay_color' . $i] : '#000000';
		$slider_overlay_opacity = isset( $dp_options['slider_overlay_opacity' . $i] ) ? $dp_options['slider_overlay_opacity' . $i] : 0.5;

		if ( $dp_options['slider_headline' . $i] || $dp_options['slider_desc' . $i] || ( $dp_options['display_slider_button' . $i] && $dp_options['slider_button_label' . $i] ) ) :
			$show_slider_content = true;
		else :
			$show_slider_content = false;
		endif;

?>
		<div class="p-index-slider__item p-index-slider__item--<?php echo esc_attr($i); ?>">
			<div class="p-index-slider__item-inner">
<?php
		if ( $show_slider_content ) :
?>
				<div class="p-index-slider__item-content">
<?php
			if ( $dp_options['slider_headline' . $i] ) :
?>
					<div class="p-index-slider__item-catch"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['slider_headline' . $i] ) ); ?></div>
<?php
			endif;
			if ( $dp_options['slider_desc' . $i] ) :
?>
					<div class="p-index-slider__item-desc"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['slider_desc' . $i] ) ); ?></div>
<?php
			endif;
			if ( $dp_options['display_slider_button' . $i] && $dp_options['slider_button_label' . $i] ) :
				if ( $dp_options['slider_url' . $i] ) :
?>
					<div><a class="p-index-slider__item-button p-button" href="<?php echo esc_url( $dp_options['slider_url' . $i] ); ?>"<?php if ( $dp_options['slider_target' . $i] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $dp_options['slider_button_label' . $i] ); ?></a></div>
<?php
				else :
?>
					<div class="p-index-slider__item-button p-button"><?php echo esc_html( $dp_options['slider_button_label' . $i] ); ?></a></div>
<?php
				endif;
			endif;
?>
				</div>
<?php
		endif;
		if ( $dp_options['slider_url' . $i] && ( ! $dp_options['display_slider_button' . $i] || ! $dp_options['slider_button_label' . $i] ) ) :
?>
				<a class="p-index-slider__item-image" href="<?php echo esc_url( $dp_options['slider_url' . $i] ); ?>"<?php if ( $dp_options['slider_target' . $i] ) { echo ' target="_blank"'; } ?>><img src="<?php echo esc_attr( $slider_image[0] ); ?>" alt=""></a>
<?php
		else :
?>
				<div class="p-index-slider__item-image"><img src="<?php echo esc_attr( $slider_image[0] ); ?>" alt=""></div>
<?php
		endif;
		if ( 0 < $slider_overlay_opacity ) :
?>
				<div class="p-index-slider__item-overlay" style="background: rgba(<?php echo esc_attr( implode( ', ', hex2rgb( $slider_overlay_color ) ) ) ?>, <?php echo esc_attr( $slider_overlay_opacity ); ?>);"></div>
<?php
		endif;
		if ( $dp_options['slider_native_ad_label' . $i] ) :
?>
				<div class="p-float-native-ad-label"><?php echo esc_html( $dp_options['slider_native_ad_label' . $i] ); ?></div>
<?php
		endif;
?>
			</div>
		</div>
<?php
	endfor;
?>
	</div>
<?php
// 動画を背景に表示する
elseif ( 'type3' == $dp_options['header_content_type'] ) :
	$video_url = wp_get_attachment_url( $dp_options['video'] );
	
	// スマホ画像表示用分岐
	$header_video_hide = $dp_options['video_image_hide'];
	$is_sp_image = true;
	if(wp_is_mobile() & $header_video_hide && wp_get_attachment_url( $dp_options['video_image'] )):
		$is_sp_image = false;
	elseif ( !auto_play_movie() && wp_get_attachment_url( $dp_options['video_image'] ) ) :
		$is_sp_image = false;
	else:
		$is_sp_image = true;
	endif;
	
	if ( $is_sp_image ) : // if is pc
		if ( ! empty( $video_url ) ) :
?>
	<div class="p-header-video">
		<div id="js-header-video" class="p-header-video__video"></div>
<?php
			if ( $dp_options['use_video_catch'] || $dp_options['show_video_catch_button'] ) :
				$catch = esc_html( $dp_options['video_catch'] );
				$font_size = $dp_options['video_catch_font_size'];
				$desc = esc_html( $dp_options['video_desc'] );
				$desc_font_size = $dp_options['video_desc_font_size'];
				$font_color = $dp_options['video_catch_color'];
				$shadow1 = $dp_options['video_catch_shadow1'];
				$shadow2 = $dp_options['video_catch_shadow2'];
				$shadow3 = $dp_options['video_catch_shadow3'];
				$shadow4 = $dp_options['video_catch_shadow_color'];
?>
		<div class="p-header-video__overlay">
			<div class="p-header-video__caption l-inner">
<?php
				if ( $dp_options['use_video_catch'] ) :
					if ( $dp_options['video_catch'] ) :
?>
				<p class="p-header-video__caption-catch" style="font-size:<?php echo esc_html( $font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_catch'] ) ); ?></p>
<?php
					endif;
					if ( $dp_options['video_desc'] ) :
?>
				<p class="p-header-video__caption-desc" style="font-size:<?php echo esc_html( $desc_font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_desc'] ) ); ?></p>
<?php
					endif;
				endif;

				if ( $dp_options['show_video_catch_button'] && $dp_options['video_catch_button'] ) :
					if ( $dp_options['video_button_url'] ) :
?>
				<div><a class="p-header-video__caption-button p-button" href="<?php echo esc_attr( $dp_options['video_button_url'] ); ?>"<?php if ( $dp_options['video_button_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $dp_options['video_catch_button'] ); ?></a></div>
<?php
					else :
?>
				<div class="p-header-video__caption-button p-button"><?php echo esc_html( $dp_options['video_catch_button'] ); ?></div>
<?php
					endif;
				endif;
?>
			</div>
		</div>
<?php
			endif;
?>
	</div>
<?php
		endif;
	else : // if is mobile device
		$video_image = wp_get_attachment_image_src( $dp_options['video_image'], 'full' );
		if ( ! empty( $video_image[0] ) ) :
?>
	<div class="p-header-video--mobile p-header--mobile">
		<img src="<?php echo esc_attr( $video_image[0] ); ?>" alt="">
<?php
			if ( $dp_options['use_video_catch'] || $dp_options['show_video_catch_button'] ) :
				$catch = esc_html( $dp_options['video_catch'] );
				$font_size = $dp_options['video_catch_font_size'];
				$desc = esc_html( $dp_options['video_desc'] );
				$desc_font_size = $dp_options['video_desc_font_size'];
				$font_color = $dp_options['video_catch_color'];
				$shadow1 = $dp_options['video_catch_shadow1'];
				$shadow2 = $dp_options['video_catch_shadow2'];
				$shadow3 = $dp_options['video_catch_shadow3'];
				$shadow4 = $dp_options['video_catch_shadow_color'];
?>
		<div class="p-header-video__overlay">
			<div class="p-header-video__caption l-inner">
<?php
				if ( $dp_options['use_video_catch'] ) :
					if ( $dp_options['video_catch'] ) :
?>
				<p class="p-header-video__caption-catch" style="font-size:<?php echo esc_html( $font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_catch'] ) ); ?></p>
<?php
					endif;
					if ( $dp_options['video_desc'] ) :
?>
				<p class="p-header-video__caption-desc" style="font-size:<?php echo esc_html( $desc_font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_desc'] ) ); ?></p>
<?php
					endif;
				endif;

				if ( $dp_options['show_video_catch_button'] && $dp_options['video_catch_button'] ) :
					if ( $dp_options['video_button_url'] ) :
?>
				<div><a class="p-header-video__caption-button p-button" href="<?php echo esc_attr( $dp_options['video_button_url'] ); ?>"<?php if ( $dp_options['video_button_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $dp_options['video_catch_button'] ); ?></a></div>
<?php
					else :
?>
				<div class="p-header-video__caption-button p-button"><?php echo esc_html( $dp_options['video_catch_button'] ); ?></div>
<?php
					endif;
				endif;
?>
			</div>
		</div>
<?php
			endif;
?>
	</div>
<?php
			endif;
		endif;

// Youtubeの動画を背景に表示する
elseif ( 'type4' == $dp_options['header_content_type'] ) :
	$youtube_url = $dp_options['youtube_url'];
	$header_youtube_hide = $dp_options['youtube_image_hide'];
	$is_sp_image = true;

	// スマホ画像表示用分岐
	if(wp_is_mobile() & $header_youtube_hide && wp_get_attachment_url( $dp_options['youtube_image'] )):
		$is_sp_image = false;
	elseif ( !auto_play_movie() && wp_get_attachment_url( $dp_options['youtube_image'] ) ) :
		$is_sp_image = false;
	else:
		$is_sp_image = true;
	endif;

	if ( $is_sp_image ) : // if is pc
		if ( ! empty( $youtube_url ) ) :
?>
	<div class="p-header-youtube">
		<div id="js-header-youtube" class="p-header-youtube__video"></div>
		<div id="js-youtube-video-player" class="player" data-property="{videoURL:'<?php echo esc_url( $youtube_url ); ?>',containment:'#js-header-youtube',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,showControls:false,showYTLogo: false,stopMovieOnBlur:false,ratio:'16/9'}"></div>
<?php
			if ( $dp_options['use_video_catch'] || $dp_options['show_video_catch_button'] ) :
				$catch = esc_html( $dp_options['video_catch'] );
				$font_size = $dp_options['video_catch_font_size'];
				$desc = esc_html( $dp_options['video_desc'] );
				$desc_font_size = $dp_options['video_desc_font_size'];
				$font_color = $dp_options['video_catch_color'];
				$shadow1 = $dp_options['video_catch_shadow1'];
				$shadow2 = $dp_options['video_catch_shadow2'];
				$shadow3 = $dp_options['video_catch_shadow3'];
				$shadow4 = $dp_options['video_catch_shadow_color'];
?>
		<div class="p-header-video__overlay">
			<div class="p-header-video__caption l-inner">
<?php
				if ( $dp_options['use_video_catch'] ) :
					if ( $dp_options['video_catch'] ) :
?>
				<p class="p-header-video__caption-catch" style="font-size:<?php echo esc_html( $font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_catch'] ) ); ?></p>
<?php
					endif;
					if ( $dp_options['video_desc'] ) :
?>
				<p class="p-header-video__caption-desc" style="font-size:<?php echo esc_html( $desc_font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_desc'] ) ); ?></p>
<?php
					endif;
				endif;

				if ( $dp_options['show_video_catch_button'] && $dp_options['video_catch_button'] ) :
					if ( $dp_options['video_button_url'] ) :
?>
				<div><a class="p-header-video__caption-button p-button" href="<?php echo esc_attr( $dp_options['video_button_url'] ); ?>"<?php if ( $dp_options['video_button_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $dp_options['video_catch_button'] ); ?></a></div>
<?php
					else :
?>
				<div class="p-header-video__caption-button p-button"><?php echo esc_html( $dp_options['video_catch_button'] ); ?></div>
<?php
					endif;
				endif;
?>
			</div>
		</div>
<?php
			endif;
?>
	</div>

<?php
		endif;
	else : // if is mobile device
		$youtube_image = wp_get_attachment_image_src( $dp_options['youtube_image'], 'full' );
		if ( ! empty( $youtube_image[0] ) ) :
?>
	<div class="p-header-youtube--mobile p-header--mobile">
		<img src="<?php echo esc_attr( $youtube_image[0] ); ?>" alt="">
<?php
			if ( $dp_options['use_video_catch'] || $dp_options['show_video_catch_button'] ) :
?>
		<div class="p-header-video__overlay">
			<div class="p-header-video__caption l-inner">
<?php
				if ( $dp_options['use_video_catch'] ) :
					if ( $dp_options['video_catch'] ) :
?>
				<p class="p-header-video__caption-catch" style="font-size:<?php echo esc_html( $font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_catch'] ) ); ?></p>
<?php
					endif;
					if ( $dp_options['video_desc'] ) :
?>
				<p class="p-header-video__caption-desc" style="font-size:<?php echo esc_html( $desc_font_size ); ?>px; text-shadow:<?php echo esc_html( $shadow1 ); ?>px <?php echo esc_html( $shadow2 ); ?>px <?php echo esc_html( $shadow3 ); ?>px <?php echo esc_html( $shadow4 ); ?>; color:<?php echo esc_html( $font_color ); ?>;"><?php echo str_replace( array( "\r\n", "\r", "\n" ), '<br>', esc_html( $dp_options['video_desc'] ) ); ?></p>
<?php
					endif;
				endif;

				if ( $dp_options['show_video_catch_button'] && $dp_options['video_catch_button'] ) :
					if ( $dp_options['video_button_url'] ) :
?>
				<div><a class="p-header-video__caption-button p-button" href="<?php echo esc_attr( $dp_options['video_button_url'] ); ?>"<?php if ( $dp_options['video_button_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $dp_options['video_catch_button'] ); ?></a></div>
<?php
					else :
?>
				<div class="p-header-video__caption-button p-button"><?php echo esc_html( $dp_options['video_catch_button'] ); ?></div>
<?php
					endif;
				endif;
?>
			</div>
		</div>
<?php
			endif;
?>
	</div>
<?php
		endif;
	endif;

// 記事スライダー
else :
	$header_blog_category = null;
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'post',
		'posts_per_page' => $dp_options['header_blog_num'],
		'ignore_sticky_posts' => true
	);
	if ( 'type2' == $dp_options['header_blog_list_type'] ) :
		$args['meta_key'] = 'recommend_post';
		$args['meta_value'] = 'on';
	elseif ( 'type3' == $dp_options['header_blog_list_type'] ) :
		$args['meta_key'] = 'recommend_post2';
		$args['meta_value'] = 'on';
	elseif ( 'type4' == $dp_options['header_blog_list_type'] ) :
		$args['meta_key'] = 'pickup_post';
		$args['meta_value'] = 'on';
	elseif ( 'type5' == $dp_options['header_blog_list_type'] ) :
	elseif ( $dp_options['header_blog_category'] ) :
		$header_blog_category = get_category( $dp_options['header_blog_category'] );
	endif;
	if ( ! empty( $header_blog_category ) && ! is_wp_error( $header_blog_category ) ) :
		$args['cat'] = $header_blog_category->term_id;
	else :
		$header_blog_category = null;
	endif;
	if ( 'rand' == $dp_options['header_blog_post_order'] ) :
		$args['orderby'] = 'rand';
	elseif ( 'date2' == $dp_options['header_blog_post_order'] ) :
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
	else :
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	endif;
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
?>
	<div id="js-index-slider" class="p-index-slider p-index-slider--type1 p-header-blog__list clearfix">
<?php
		$i = 0;
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$i++;

			$catlist_float = array();
			$catlist_meta = array();
			if ( $dp_options['show_header_blog_category'] ) :
				$categories = get_the_category();
				if ( $categories && ! is_wp_error( $categories ) ) :
					// 選択カテゴリーを先に表示
					if ( $header_blog_category ) :
						$catlist_float[] = '<span class="p-category-item--' . esc_attr( $header_blog_category->term_id ) . '" data-url="' . get_category_link( $header_blog_category ) . '">' . esc_html( $header_blog_category->name ) . '</span>';
						$catlist_meta[] = '<span data-url="' . get_category_link( $header_blog_category ) . '">' . esc_html( $header_blog_category->name ) . '</span>';
					endif;
					foreach( $categories as $category ) :
						if ( $header_blog_category && $header_blog_category->term_id == $category->term_id ) continue;
						if ( ! $catlist_float ) :
							$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
						endif;
						$catlist_meta[] = '<span data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
					endforeach;
				endif;
			endif;
?>
		<article class="p-header-blog__item">
			<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
				<div class="p-header-blog__item-thumbnail p-hover-effect__image">
<?php
			echo "\t\t\t\t\t";
			if ( has_post_thumbnail() ) :
				the_post_thumbnail( 'size3' );
			else :
				echo '<img src="' . get_template_directory_uri() . '/img/no-image-800x550.gif" alt="">';
			endif;
			echo "\n";
?>
				</div>
				<div class="p-header-blog__item-overlay p-article__overlay u-hidden-sm">
					<div class="p-header-blog__item-overlay__inner">
						<div class="p-header-blog__item-title p-article__title__overlay"><?php echo mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></div>
<?php
			if ( $dp_options['show_header_blog_date'] ) :
?>
						<time class="p-header-blog__item-date" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
<?php
			endif;
			if ( $dp_options['show_header_blog_views'] ) :
?>
						<span class="p-article__views"><?php echo number_format( intval( $post->_views ) ); ?> views</span>
<?php
			endif;
			if ( $dp_options['show_header_blog_author'] ) :
				the_archive_author();
			endif;
?>
					</div>
				</div>
				<div class="l-inner u-visible-sm">
					<div class="p-header-blog__item-title p-article__title"><?php echo mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></div>
<?php
			if ( $dp_options['show_header_blog_date'] || $catlist_meta || $dp_options['show_header_blog_views'] || $dp_options['show_header_blog_author'] ) :
				echo "\t\t\t\t\t";
				echo '<p class="p-header-blog__item-meta p-article__meta">';
				if ( $dp_options['show_date'] ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( $catlist_meta ) :
					echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
				endif;
				if ( $dp_options['show_header_blog_views'] ) :
					echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ) . ' views</span>';
				endif;
				if ( $dp_options['show_header_blog_author'] ) :
					the_archive_author();
				endif;
				echo "</p>\n";
			endif;
?>
				</div>
<?php
			// ネイティブ内部広告
			if ( $post->show_native_ad && $post->native_ad_label ) :
?>
				<div class="p-float-native-ad-label"><?php echo esc_html( $post->native_ad_label ); ?></div>
<?php
			elseif ( $catlist_float ) :
?>
				<div class="p-float-category"><?php echo implode( ', ', $catlist_float ); ?></div>
<?php
			endif;
?>
			</a>
		</article>
<?php
			// ネイティブ外部広告
			if ( $dp_options['show_header_blog_native_ad'] && $dp_options['header_blog_native_ad_position'] && 0 === ( $i % $dp_options['header_blog_native_ad_position'] ) ) :
				$native_ad = get_native_ad();
				if ( $native_ad ) :
?>
		<article class="p-header-blog__item">
			<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
				<div class="p-header-blog__item-thumbnail p-hover-effect__image">
<?php
					if ( ! empty( $native_ad['native_ad_image'] ) ) :
						$image_src = wp_get_attachment_image_src( $native_ad['native_ad_image'], 'size3' );
					else :
						$image_src = null;
					endif;
					if ( ! empty( $image_src[0] ) ) :
						$image_src = $image_src[0];
					else :
						$image_src = get_template_directory_uri() . '/img/no-image-800x550.gif';
					endif;
					echo "\t\t\t\t\t";
					echo '<img src="' . esc_attr( $image_src ) . '" alt="">' . "\n";

					if ( $native_ad['native_ad_label'] ) :
						echo "\t\t\t\t\t";
						echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
					endif;
?>
				</div>
				<div class="p-header-blog__item-overlay p-article__overlay u-hidden-sm">
					<div class="p-header-blog__item-overlay__inner">
						<div class="p-header-blog__item-title p-article__title__overlay"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></div>
					</div>
				</div>
				<div class="l-inner u-visible-sm">
					<div class="p-header-blog__item-title p-article__title"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></div>
				</div>
			</a>
		</article>
<?php
				endif;
			endif;
		endwhile;
		wp_reset_postdata();
?>
	</div>
<?php
	endif;
endif;
