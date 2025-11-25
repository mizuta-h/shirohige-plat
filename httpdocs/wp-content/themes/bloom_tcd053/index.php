<?php
$dp_options = get_design_plus_option();
$active_sidebar = get_sidebar_id();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/breadcrumb' );
get_template_part( 'template-parts/page-header' );

if ( $active_sidebar ) :
?>
	<div class="l-inner l-2colmuns u-clearfix">
		<div class="l-primary">
<?php
else :
?>
	<div class="l-inner">
<?php
endif;

if ( have_posts() ) :
?>
			<div class="p-blog-list u-clearfix">
<?php
	$post_count = 0;
	while ( have_posts() ) :
		the_post();
		$post_count++;

		$catlist_float = array();
		$catlist_meta = array();
		if ( $dp_options['show_category'] && has_category() ) :
			$queried_object = null;

			// カテゴリーアーカイブの場合は該当カテゴリーを最初に表示
			if ( is_category() ) :
				$queried_object = get_queried_object();
				if ( ! empty( $queried_object->term_id ) ) :
					$catlist_float[] = '<span class="p-category-item--' . esc_attr( $queried_object->term_id ) . '" data-url="' . get_category_link( $queried_object ) . '">' . esc_html( $queried_object->name ) . '</span>';
					$catlist_meta[] = '<span data-url="' . get_category_link( $queried_object ) . '">' . esc_html( $queried_object->name ) . '</span>';
				endif;
			endif;

			$categories = get_the_category();
			if ( $categories && ! is_wp_error( $categories ) ) :
				foreach( $categories as $category ) :
					if ( ! empty( $queried_object->term_id ) && $queried_object->term_id === $category->term_id ) continue;
					if ( ! $catlist_float ) :
						$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
					endif;
					$catlist_meta[] = '<span data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
				endforeach;
			endif;
		endif;
?>
				<article class="p-blog-list__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
						<div class="p-blog-list__item-thumbnail p-hover-effect__image">
							<div class="p-blog-list__item-thumbnail_inner">
<?php
		echo "\t\t\t\t\t\t\t\t";
		if ( has_post_thumbnail() ) :
			the_post_thumbnail( 'size1' );
		else :
			echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
		endif;
		echo "\n";

		// ネイティブ内部広告
		if ( $post->show_native_ad && $post->native_ad_label ) :
			echo "\t\t\t\t\t\t\t\t";
			echo '<div class="p-float-native-ad-label">' . esc_html( $post->native_ad_label ) . '</div>' . "\n";
		elseif ( $catlist_float ) :
			echo "\t\t\t\t\t\t\t\t";
			echo '<div class="p-float-category">' . implode( ', ', $catlist_float ) . '</div>' . "\n";
		endif;
?>
							</div>
						</div>
						<div class="p-blog-list__item-info">
<?php
		if ( $dp_options['show_date'] || $catlist_meta || $dp_options['show_views'] || $dp_options['show_archive_author'] ) :
			echo "\t\t\t\t\t\t\t";
			echo '<p class="p-blog-list__item-meta p-article__meta u-clearfix u-hidden-xs">';
			if ( $dp_options['show_date'] ) :
				echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
			endif;
			if ( $catlist_meta ) :
				echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
			endif;
			if ( $dp_options['show_views'] ) :
				echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ) . ' views</span>';
			endif;
			if ( $dp_options['show_archive_author'] ) :
				the_archive_author();
			endif;
			echo "</p>\n";
		endif;
?>
							<h2 class="p-blog-list__item-title p-article__title"><?php echo mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></h2>
							<p class="p-blog-list__item-excerpt u-hidden-xs"><?php echo tcd_the_excerpt(); ?></p>
<?php
		if ( $dp_options['show_date'] || $catlist_meta ) :
			echo "\t\t\t\t\t\t\t";
			echo '<p class="p-blog-list__item-meta02 p-article__meta u-visible-xs">';
			if ( $dp_options['show_date'] ) :
				echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
			endif;
			if ( $catlist_meta ) :
				echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
			endif;
			echo "</p>\n";
		endif;
		if ( $dp_options['show_views'] || $dp_options['show_archive_author'] ) :
			echo "\t\t\t\t\t\t\t";
			echo '<p class="p-blog-list__item-meta02 p-article__meta u-clearfix u-visible-xs">';
			if ( $dp_options['show_views'] ) :
				echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ). ' views</span>';
			endif;
			if ( $dp_options['show_archive_author'] ) :
				the_archive_author();
			endif;
			echo "</p>\n";
		endif;
?>
						</div>
					</a>
				</article>
<?php
		// ネイティブ外部広告
		if ( $dp_options['archive_native_ad_position'] && 0 === ( $post_count % $dp_options['archive_native_ad_position'] ) ) :
			if ( is_home() && $dp_options['show_archive_native_ad'] ||
				is_category() && $dp_options['show_category_archive_native_ad'] ||
				is_tag() && $dp_options['show_tag_archive_native_ad'] ||
				is_date() && $dp_options['show_date_archive_native_ad'] ||
				is_author() && $dp_options['show_author_archive_native_ad'] ||
				is_search() && $dp_options['show_search_archive_native_ad'] ) :
				$native_ad = get_native_ad();
			else :
				$native_ad = false;
			endif;
			if ( $native_ad ) :
?>
				<article class="p-blog-list__item">
					<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
						<div class="p-blog-list__item-thumbnail p-hover-effect__image">
							<div class="p-blog-list__item-thumbnail_inner">
<?php
				if ( ! empty( $native_ad['native_ad_image'] ) ) :
					$image_src = wp_get_attachment_image_src( $native_ad['native_ad_image'], 'size1' );
				else :
					$image_src = null;
				endif;
				if ( ! empty( $image_src[0] ) ) :
					$image_src = $image_src[0];
				else :
					$image_src = get_template_directory_uri() . '/img/no-image-300x300.gif';
				endif;
				echo "\t\t\t\t\t\t\t\t";
				echo '<img src="' . esc_attr( $image_src ) . '" alt="">' . "\n";

				if ( $native_ad['native_ad_label'] ) :
					echo "\t\t\t\t\t\t\t\t";
					echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
				endif;
?>
							</div>
						</div>
						<div class="p-blog-list__item-info">
							<h2 class="p-blog-list__item-title p-article__title"><?php echo esc_html( wp_trim_words( $native_ad['native_ad_title'], is_mobile() ? 34 : 46, '...' ) ); ?></h2>
						</div>
					</a>
				</article>
<?php
			endif;
		endif;
	endwhile;
?>
			</div>
<?php
	$paginate_links = paginate_links( array(
		'current' => max( 1, get_query_var( 'paged' ) ),
		'next_text' => '&#xe910;',
		'prev_text' => '&#xe90f;',
		'total' => $wp_query->max_num_pages,
		'type' => 'array',
	) );
	if ( $paginate_links ) :
?>
			<ul class="p-pager">
<?php
		foreach ( $paginate_links as $paginate_link ) :
?>
				<li class="p-pager__item"><?php echo $paginate_link; ?></li>
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
endif;

if ( $active_sidebar ) :
?>
		</div>
<?php
	get_sidebar();
?>
	</div>
<?php
else :
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
