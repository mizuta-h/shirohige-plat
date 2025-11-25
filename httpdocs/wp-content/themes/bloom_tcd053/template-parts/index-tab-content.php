<?php
		global $tab_index, $post, $dp_options, $ajax_index_tab_paged;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		// フリースペース
		if ( $dp_options['show_index_tab_editor' . $tab_index] && $dp_options['index_tab_editor' . $tab_index] ) :
			$freespace = apply_filters( 'the_content', $dp_options['index_tab_editor' . $tab_index] );
			if ( $freespace ) :
?>
				<div class="p-index-tab__content p-index-tab__content--<?php echo esc_attr( $tab_index ); ?> p-entry__body">
<?php
				echo $freespace;
?>
				</div>
<?php
			endif;
		endif;

		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $dp_options['index_tab_post_num' . $tab_index],
			'ignore_sticky_posts' => $dp_options['use_index_tab_sticky' . $tab_index] ? false : true
		);

		if ( 'type2' == $dp_options['index_tab_list_type' . $tab_index] ) :
			$args['meta_key'] = 'recommend_post';
			$args['meta_value'] = 'on';
		elseif ( 'type3' == $dp_options['index_tab_list_type' . $tab_index] ) :
			$args['meta_key'] = 'recommend_post2';
			$args['meta_value'] = 'on';
		elseif ( 'type4' == $dp_options['index_tab_list_type' . $tab_index] ) :
			$args['meta_key'] = 'pickup_post';
			$args['meta_value'] = 'on';
		elseif ( 'type5' == $dp_options['index_tab_list_type' . $tab_index] ) :
			if ( $ajax_index_tab_paged ) :
				$args['paged'] = $ajax_index_tab_paged;
			endif;
		elseif ( $dp_options['index_tab_category' . $tab_index] ) :
			$args['cat'] = $dp_options['index_tab_category' . $tab_index];
		endif;

		if ( 'rand' == $dp_options['index_tab_post_order' . $tab_index] ) :
			$args['orderby'] = 'rand';
		elseif ( 'date2' == $dp_options['index_tab_post_order' . $tab_index] ) :
			$args['orderby'] = 'date';
			$args['order'] = 'ASC';
		else :
			$args['orderby'] = 'date';
			$args['order'] = 'DESC';
		endif;

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :
			$post_count = 0;
			$post_count_with_ad = 0;

			// 上部2記事を大きく表示
			if ( $dp_options['show_index_tab_large' . $tab_index] ) :
?>
				<div class="p-blog-list-large u-clearfix">
<?php

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$post_count++;
					$post_count_with_ad++;

					$catlist_float = array();
					$catlist_meta = array();
					if ( $dp_options['show_category'] && has_category() ) :
						$categories = get_the_category();
						if ( $categories && ! is_wp_error( $categories ) ) :
							foreach( $categories as $category ) :
								if ( ! $catlist_float ) :
									$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
								endif;
								$catlist_meta[] = '<span data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
							endforeach;
						endif;
					endif;
?>
					<article class="p-blog-list-large__item">
						<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
							<div class="p-blog-list-large__item-thumbnail p-hover-effect__image">
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
							<div class="p-blog-list-large__item-overlay p-article__overlay u-hidden-xs">
								<div class="p-blog-list-large__item-overlay__inner">
									<h2 class="p-blog-list-large__item-title p-article__title__overlay"><?php echo mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></h2>
<?php
					if ( $dp_options['show_date'] ) :
?>
									<time class="p-blog-list-large__item-date" datetime="<?php the_time( 'c' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
<?php
					endif;
					if ( $dp_options['show_views'] ) :
?>
									<span class="p-article__views"><?php echo number_format( intval( $post->_views ) ); ?> views</span>
<?php
					endif;
					if ( $dp_options['show_archive_author'] ) :
						the_archive_author();
					endif;
?>
								</div>
							</div>
							<h2 class="p-blog-list-large__item-title p-article__title u-visible-xs"><?php echo mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></h2>
<?php
					if ( $dp_options['show_date'] || $catlist_meta || $dp_options['show_views'] || $dp_options['show_archive_author'] ) :
						echo "\t\t\t\t\t\t\t";
						echo '<p class="p-blog-list-large__item-meta02 p-article__meta u-clearfix u-visible-xs">' . "\n";
						if ( $dp_options['show_date'] ) :
							echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
						endif;
						if ( $catlist_meta ) :
							echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
						endif;
						if ( $dp_options['show_views'] ) :
							echo '<span class="p-article__views">' . number_format( intval( $post->_views ) ). ' views</span>';
						endif;
						if ( $dp_options['show_archive_author'] ) :
							the_archive_author();
						endif;
						echo "</p>\n";
					endif;

					// ネイティブ内部広告
					if ( $post->show_native_ad && $post->native_ad_label ) :
						echo "\t\t\t\t\t\t\t";
						echo '<div class="p-float-native-ad-label">' . esc_html( $post->native_ad_label ) . '</div>' . "\n";
					elseif ( $catlist_float ) :
						echo "\t\t\t\t\t\t\t";
						echo '<div class="p-float-category">' . implode( ', ', $catlist_float ) . '</div>' . "\n";
					endif;
?>
						</a>
					</article>
<?php
					if ( 2 <= $post_count_with_ad ) break;

					// ネイティブ外部広告
					if ( $dp_options['show_index_tab_native_ad' . $tab_index] && $dp_options['index_tab_native_ad_position' . $tab_index] && 0 === ( $post_count % $dp_options['index_tab_native_ad_position' . $tab_index] ) ) :
						$native_ad = get_native_ad();
						if ( $native_ad ) :
							$post_count_with_ad++;
?>
					<article class="p-blog-list-large__item">
						<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
							<div class="p-blog-list-large__item-thumbnail p-hover-effect__image">
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

							if ( $native_ad['native_ad_label'] ) :
								echo "\t\t\t\t\t\t\t\t";
								echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
							endif;

?>
							</div>
							<div class="p-blog-list-large__item-overlay p-article__overlay u-hidden-xs">
								<div class="p-blog-list-large__item-overlay__inner">
									<h2 class="p-blog-list-large__item-title p-article__title__overlay"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></h2>
								</div>
							</div>
							<h2 class="p-blog-list-large__item-title p-article__title u-visible-xs"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></h2>
						</a>
					</article>
<?php
						endif;
					endif;

					if ( 2 <= $post_count_with_ad ) break;
				endwhile;
?>
				</div>
<?php
			endif;

			// 通常表示
			if ( $the_query->have_posts() && $the_query->post_count > $post_count ) :
?>
				<div class="p-blog-list u-clearfix">
<?php
				if ( $dp_options['show_index_tab_large' . $tab_index] ) :
					// ネイティブ外部広告
					if ( $dp_options['show_index_tab_native_ad' . $tab_index] && $dp_options['index_tab_native_ad_position' . $tab_index] && 0 === ( $post_count % $dp_options['index_tab_native_ad_position' . $tab_index] ) && 1 != $dp_options['index_tab_native_ad_position' . $tab_index] ) :
						$native_ad = get_native_ad();
						if ( $native_ad ) :
							$post_count_with_ad++;
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
							echo "\t\t\t\t\t\t\t\t\t";
							echo '<img src="' . esc_attr( $image_src ) . '" alt="">' . "\n";

							if ( $native_ad['native_ad_label'] ) :
								echo "\t\t\t\t\t\t\t\t\t";
								echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
							endif;
?>
								</div>
							</div>
							<div class="p-blog-list__item-info">
								<h2 class="p-blog-list__item-title p-article__title"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></h2>
							</div>
						</a>
					</article>
<?php
						endif;
					endif;
				endif;

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$post_count++;
					$post_count_with_ad++;

					$catlist_float = array();
					$catlist_meta = array();
					if ( $dp_options['show_category'] && has_category() ) :
						$categories = get_the_category();
						if ( $categories && ! is_wp_error( $categories ) ) :
							foreach( $categories as $category ) :
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
					echo "\t\t\t\t\t\t\t\t\t";
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size1' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
					endif;
					echo "\n";

					// ネイティブ内部広告
					if ( $post->show_native_ad && $post->native_ad_label ) :
						echo "\t\t\t\t\t\t\t\t\t";
						echo '<div class="p-float-native-ad-label">' . esc_html( $post->native_ad_label ) . '</div>' . "\n";
					elseif ( $catlist_float ) :
						echo "\t\t\t\t\t\t\t\t\t";
						echo '<div class="p-float-category">' . implode( ', ', $catlist_float ) . '</div>' . "\n";
					endif;
?>
								</div>
							</div>
							<div class="p-blog-list__item-info">
<?php
					if ( $dp_options['show_date'] || $catlist_meta || $dp_options['show_views'] || $dp_options['show_archive_author'] ) :
						echo "\t\t\t\t\t\t\t\t";
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
								<h2 class="p-blog-list__item-title p-article__title"><?php echo is_mobile() ? wp_trim_words( get_the_title(), 25, '...' ) : mb_strimwidth( get_the_title(), 0, 92, '...' ); ?></h2>
								<p class="p-blog-list__item-excerpt u-hidden-xs"><?php echo tcd_the_excerpt(); ?></p>
<?php
					if ( $dp_options['show_date'] || $catlist_meta ) :
						echo "\t\t\t\t\t\t\t\t";
						echo '<p class="p-blog-list__meta02 p-article__meta u-visible-xs">';
						if ( $dp_options['show_date'] ) :
							echo '<time class="p-article__date" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_time( 'Y.m.d' ) . '</time>';
						endif;
						if ( $catlist_meta ) :
							echo '<span class="p-article__category">' . implode( ', ', $catlist_meta ) . '</span>';
						endif;
						echo "</p>\n";
					endif;
					if ( $dp_options['show_views'] || $dp_options['show_archive_author'] ) :
						echo "\t\t\t\t\t\t\t\t";
						echo '<p class="p-blog-list__meta02 p-article__meta u-clearfix u-visible-xs">';
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
					if ( $dp_options['show_index_tab_native_ad' . $tab_index] && $dp_options['index_tab_native_ad_position' . $tab_index] && 0 === ( $post_count % $dp_options['index_tab_native_ad_position' . $tab_index] ) ) :
						$native_ad = get_native_ad();
						if ( $native_ad ) :
							$post_count_with_ad++;
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
							echo "\t\t\t\t\t\t\t\t\t";
							echo '<img src="' . esc_attr( $image_src ) . '" alt="">' . "\n";

							if ( $native_ad['native_ad_label'] ) :
								echo "\t\t\t\t\t\t\t\t\t";
								echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
							endif;
?>
								</div>
							</div>
							<div class="p-blog-list__item-info">
								<h2 class="p-blog-list__item-title p-article__title"><?php echo mb_strimwidth( $native_ad['native_ad_title'], 0, 92, '...' ); ?></h2>
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
			endif;

			if ( 'type5' == $dp_options['index_tab_list_type' . $tab_index] ) :
				$paginate_links = paginate_links( array(
					'current' => max( 1, $the_query->get( 'paged' ) ),
					'next_text' => '&#xe910;',
					'prev_text' => '&#xe90f;',
					'total' => $the_query->max_num_pages,
					'type' => 'array',
					'base' => '%_%',
					'format' => '?page=%#%'
				) );
				if ( $paginate_links ) :
?>
				<ul class="p-pager" data-tab="<?php echo esc_attr( $tab_index); ?>" data-ajax-url="<?php echo esc_attr( admin_url( 'admin-ajax.php' )); ?>">
<?php
					foreach ( $paginate_links as $paginate_link ) :
						$paginate_link_page = 1;
						if ( preg_match( '/ href=[\'"](\?page=(\d+))?[\'"]/', $paginate_link, $matches ) ) :
							if ( ! empty( $matches[2] ) ) :
								$paginate_link_page = $matches[2];
							endif;
							$paginate_link = str_replace( $matches[0], ' href="#" data-page="' . $paginate_link_page . '"', $paginate_link );
						endif;
?>
					<li class="p-pager__item"><?php echo $paginate_link; ?></li>
<?php
					endforeach;
?>
				</ul>
<?php
				endif;

			endif;
		endif;
