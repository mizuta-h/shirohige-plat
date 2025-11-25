<?php

/**
 * Template Name: Ranking
 */

if ( 'hide' == $post->display_side_content ) {
	$active_sidebar = false;
} else {
	$active_sidebar = get_sidebar_id();
}
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/breadcrumb' );
get_template_part( 'template-parts/page-header' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

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

		if ( has_post_thumbnail() || 'hide' != $post->title_align || $post->post_content || post_password_required() ) :
?>
			<article class="p-entry">
				<div class="p-entry__inner">
<?php
			if ( 'hide' != $post->title_align ) :
?>
					<h1 class="p-entry__title"<?php if ( 'center' == $post->title_align ) echo ' style="text-align: center;"'; ?>><?php the_title(); ?></h1>
<?php
			endif;

			if ( has_post_thumbnail() ) :
				echo "\t\t\t\t\t<div class=\"p-entry__thumbnail\">";
				the_post_thumbnail( 'full' );
				echo "</div>\n";
			endif;
?>
					<div class="p-entry__body">
<?php
			the_content();

			if ( ! post_password_required() ) :
				wp_link_pages( array(
					'before' => '<div class="p-page-links">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>'
				) );
			endif;
?>
					</div>
				</div>
			</article>
<?php
		endif;
	endwhile;

	if ( ! post_password_required() ) :
		$_post = $post;

		$query_args = array(
			'post_type' => 'post',
			'posts_per_page' => $_post->rank_post_num ? $_post->rank_post_num : 10,
			'ignore_sticky_posts' => 1,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => '_views'
		);
		if ( $_post->rank_category ) :
			$query_args['cat'] = $_post->rank_category;
		endif;

		$the_query = new WP_Query( $query_args );

		if ( $the_query->have_posts() ) :
?>
			<div class="p-ranking-list u-clearfix">
<?php
			$rank = 0;
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				$rank++;

				$catlist_meta = array();
				if ( $_post->rank_show_category && has_category() ) :
					$categories = get_the_category();
					if ( $categories && ! is_wp_error( $categories ) ) :
						foreach( $categories as $category ) :
							$catlist_meta[] = '<span data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
						endforeach;
					endif;
				endif;

				$rank_style = '';
				if ( $_post->{'rank_bg_color' . $rank} ) :
					$rank_style .= 'background: ' . esc_attr( $_post->{'rank_bg_color' . $rank} ) . '; ';
				elseif ( $_post->rank_bg_color0 ) :
					$rank_style .= 'background: ' . esc_attr( $_post->rank_bg_color0 ) . '; ';
				endif;
				if ( $_post->{'rank_font_color' . $rank} ) :
					$rank_style .= 'color: ' . esc_attr( $_post->{'rank_font_color' . $rank} ) . '; ';
				elseif ( $_post->rank_font_color0 ) :
					$rank_style .= 'color: ' . esc_attr( $_post->rank_font_color0 ) . '; ';
				endif;
?>
				<article class="p-ranking-list__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
						<div class="p-ranking-list__item-thumbnail p-hover-effect__image">
							<div class="p-ranking-list__item-thumbnail_inner">
								<span class="p-ranking-list__item-rank" style="<?php echo trim( $rank_style ); ?>"><?php echo $rank; ?></span>
<?php
				echo "\t\t\t\t\t\t\t\t";
				if ( has_post_thumbnail() ) :
					the_post_thumbnail( 'size1' );
				else :
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
				endif;
				echo "\n";
?>
							</div>
						</div>
						<div class="p-ranking-list__item-info">
							<p class="p-ranking-list__item-meta p-article__meta u-hidden-xs"><?php
				if ( $_post->rank_show_date ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( $catlist_meta ) :
					echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
				endif;
				if ( $_post->rank_show_views ) :
					echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ) . ' views</span>';
				endif;
				if ( $_post->rank_show_author ) :
					the_archive_author();
				endif;

				// ネイティブ内部広告
				if ( $post->show_native_ad && $post->native_ad_label ) :
					echo '<span class="p-article__native-ad-label">' . esc_html( $post->native_ad_label ) . '</span>';
				endif;
							?></p>
							<h2 class="p-ranking-list__item-title p-article__title"><?php echo mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></h2>
							<p class="p-ranking-list__item-excerpt u-hidden-xs"><?php echo tcd_the_excerpt(); ?></p>
							<p class="p-ranking-list__item-meta02 p-article__meta u-visible-xs"><?php
				if ( $_post->rank_show_date ) :
					echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
				endif;
				if ( $catlist_meta ) :
					echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
				endif;
				if ( $_post->rank_show_views ) :
					echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ). ' views</span>';
				endif;

				// ネイティブ内部広告
				if ( $post->show_native_ad && $post->native_ad_label ) :
					echo '<span class="p-article__native-ad-label">' . esc_html( $post->native_ad_label ) . '</span>';
				endif;

				if ( $_post->rank_show_author ) :
					the_archive_author();
				endif;
							?></p>
						</div>
					</a>
				</article>
<?php
				// ネイティブ外部広告
				if ( $_post->show_native_ad && $_post->native_ad_position && 0 === ( $rank % $_post->native_ad_position ) ) :
					$native_ad = get_native_ad();
					if ( $native_ad ) :
?>
				<article class="p-ranking-list__item">
					<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>">
						<div class="p-ranking-list__item-thumbnail p-hover-effect__image">
							<div class="p-ranking-list__item-thumbnail_inner">
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
						<div class="p-ranking-list__item-info">
							<h2 class="p-ranking-list__item-title p-article__title"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></h2>
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
endif;
?>
</main>
<?php get_footer(); ?>
