<?php
$dp_options = get_design_plus_option();
$active_sidebar = get_sidebar_id();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/breadcrumb' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		if ( $post->title_align && in_array( $post->title_align, array( 'type1', 'type2' ) ) ) :
			$title_align = $post->title_align;
		else :
			$title_align = $dp_options['title_align'];
		endif;

		if ( $post->page_link && in_array( $post->page_link, array( 'type1', 'type2' ) ) ) :
			$page_link = $post->page_link;
		else :
			$page_link = $dp_options['page_link'];
		endif;

		if ( $active_sidebar ) :
?>
	<div class="l-inner l-2colmuns u-clearfix">
<?php
		endif;
?>
		<article class="p-entry <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
			<div class="p-entry__inner">
				<h1 class="p-entry__title"<?php if ( 'type2' == $title_align ) echo ' style="text-align: center;"'; ?>><?php the_title(); ?></h1>
<?php
		if ( $dp_options['show_date'] ) :
?>
				<p class="p-entry__date"<?php if ( 'type2' == $title_align ) echo ' style="text-align: center;"'; ?>><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
		endif;

		// ネイティブ内部広告
		if ( $post->show_native_ad && $post->native_ad_label && $post->native_ad_url ) :
?>
				<p class="p-entry__native-ad"><a href="<?php echo esc_attr( $post->native_ad_url ); ?>" target="_blank"><?php echo esc_html( $post->native_ad_label ); ?></a></p>
<?php
		endif;

		if ( $dp_options['show_thumbnail'] && has_post_thumbnail() ) :
?>
				<div class="p-entry__thumbnail">
<?php
			echo "\t\t\t\t\t";
			the_post_thumbnail( 'full' );
			echo "\n";

			$catlist_float = array();
			if ( has_category() ) :
				$categories = get_the_category();
				if ( $categories && ! is_wp_error( $categories ) ) :
					foreach( $categories as $category ) :
						$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '">' . esc_html( $category->name ) . '</span>';
						break;
					endforeach;
				endif;
				if ( $catlist_float ) :
?>
					<div class="p-float-category"><?php echo implode( ', ', $catlist_float ); ?></div>
<?php
				endif;
			endif;
?>
				</div>
<?php
		endif;

		if ( $dp_options['show_sns_top'] ) :
			get_template_part( 'template-parts/sns-btn-top' );
		endif;
?>
				<div class="p-entry__body u-clearfix">
<?php
		the_content();

		if ( ! post_password_required() ) :
			if ( 'type2' === $page_link ):
				if ( $page < $numpages && preg_match( '/href="(.*?)"/', _wp_link_page( $page + 1 ), $matches ) ) :
?>
				<div class="p-entry__next-page">
					<a class="p-entry__next-page__link" href="<?php echo esc_url( $matches[1] ); ?>"><?php _e( 'Read more', 'tcd-w' ); ?></a>
					<div class="p-entry__next-page__numbers"><?php echo $page . ' / ' . $numpages; ?></div>
				</div>
<?php
				endif;
			else:
				wp_link_pages( array(
					'before' => '<div class="p-page-links">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>'
				) );
			endif;
		endif;
?>
				</div>
<?php
		if ( $dp_options['show_author'] ) :
			if ( function_exists( 'get_coauthors') ) :
				$authors = get_coauthors();
			else :
				$authors = array( get_user_by( 'id', $post->post_author ) );
			endif;
			if ( $authors && is_array( $authors ) ) :
				foreach( $authors as $author ) :
					if ( ! $author->show_author ) continue;

					$sns_html = '';
					if ( $author->user_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--url"><a href="' . esc_attr( $author->user_url ) . '" target="_blank"></a></li>';
					endif;
					if ( $author->facebook_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--facebook"><a href="' . esc_attr( $author->facebook_url ) . '" target="_blank"></a></li>';
					endif;
					if ( $author->twitter_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--twitter"><a href="' . esc_attr( $author->twitter_url ) . '" target="_blank"></a></li>';
					endif;
					if ( $author->instagram_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--instagram"><a href="' . esc_attr( $author->instagram_url ) . '" target="_blank"></a></li>';
					endif;
					if ( $author->pinterest_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--pinterest"><a href="' . esc_attr( $author->pinterest_url ) . '" target="_blank"></a></li>';
					endif;
					if ( $author->youtube_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--youtube"><a href="' . esc_attr( $author->youtube_url ) . '" target="_blank"></a></li>';
					endif;
					if ( $author->contact_url ) :
						$sns_html .= '<li class="p-social-nav__item p-social-nav__item--contact"><a href="' . esc_attr( $author->contact_url ) . '" target="_blank"></a></li>';
					endif;
?>
				<div class="p-author__box u-clearfix">
					<div class="p-author__thumbnail">
						<a class="p-author__thumbnail__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo get_author_posts_url( $author->ID ); ?>">
							<div class="p-hover-effect__image"><?php echo get_avatar( $author->ID, 260 ); ?></div>
						</a>
					</div>
					<div class="p-author__info">
						<h3 class="p-author__title"><?php echo esc_html( $author->display_name ); ?></h3><?php if ( $dp_options['show_author_views'] ) : ?><span class="p-author__views"><?php echo number_format( get_author_views( $author->ID ) ); ?> views</span><?php endif; ?>
						<p class="p-author__desc"><?php echo wp_trim_words( $author->description, 78, '...' ); ?></p>
<?php
					if ( $sns_html ) :
?>
						<ul class="p-social-nav"><?php echo $sns_html; ?></ul>
<?php
					endif;
?>
						<a class="p-author__link" href="<?php echo get_author_posts_url( $author->ID ); ?>"><?php echo _e( 'Profile', 'tcd-w' ); ?></a>
					</div>
				</div>
<?php
				endforeach;
			endif;
		endif;

		if ( $dp_options['show_sns_btm'] ) :
			get_template_part( 'template-parts/sns-btn-btm' );
		endif;

		if ( has_category() || has_tag() || $dp_options['show_comment'] ) :
?>
				<ul class="p-entry__meta c-meta-box u-clearfix">
					<?php if ( has_category() ) : ?><li class="c-meta-box__item c-meta-box__item--category"><?php the_category( ', ' ); ?></li><?php endif; ?>
					<?php if ( has_tag() && get_the_tags() ) : ?><li class="c-meta-box__item c-meta-box__item--tag"><?php echo get_the_tag_list( '', ', ', '' ); ?></li><?php endif; ?>
					<?php if ( $dp_options['show_comment'] ) : ?><li class="c-meta-box__item c-meta-box__item--comment"><?php _e( 'Comments', 'tcd-w' ); ?>: <a href="#comment_headline"><?php echo get_comments_number( '0', '1', '%' ); ?></a></li><?php endif; ?>
				</ul>
<?php
		endif;

		$previous_post = get_previous_post();
		$next_post = get_next_post();
		if ( $dp_options['show_next_post'] && ( $previous_post || $next_post ) ) :
?>
				<ul class="p-entry__nav c-entry-nav">
<?php
			if ( $previous_post ) :
?>
					<li class="c-entry-nav__item c-entry-nav__item--prev">
						<a href="<?php echo esc_url( get_permalink( $previous_post->ID ) ); ?>" data-prev="<?php _e( 'Previous post', 'tcd-w' ); ?>"><span class="u-hidden-sm"><?php echo esc_html( wp_trim_words( $previous_post->post_title, 37, '...' ) ); ?></span></a>
					</li>
<?php
			else :
?>
					<li class="c-entry-nav__item c-entry-nav__item--empty"></li>
<?php
			endif;
			if ( $next_post ) :
?>
					<li class="c-entry-nav__item c-entry-nav__item--next">
						<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" data-next="<?php _e( 'Next post', 'tcd-w' ); ?>"><span class="u-hidden-sm"><?php echo esc_html( wp_trim_words( $next_post->post_title, 37, '...' ) ); ?></span></a>
					</li>
<?php
			else :
?>
					<li class="c-entry-nav__item c-entry-nav__item--empty"></li>
<?php
			endif;
?>
				</ul>
<?php
		endif;

		get_template_part( 'template-parts/advertisement' );
?>
			</div>
<?php
		if ( $dp_options['show_pickup_post'] ) :
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'post__not_in' => array( $post->ID ),
				'posts_per_page' => $dp_options['pickup_post_num'],
				'orderby' => 'rand',
				'meta_key' => 'pickup_post',
				'meta_value' => 'on'
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
?>
			<section class="p-entry__pickup">
				<div class="p-entry__pickup__inner">
<?php
				if ( $dp_options['pickup_post_headline'] ) :
?>
					<h2 class="p-headline"><?php echo esc_html( $dp_options['pickup_post_headline'] ); ?></h2>
<?php
				endif;
?>
					<div class="p-entry__pickup-items">
<?php
				$post_count = 0;
				$post_count_with_ad = 0;
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$post_count++;
					$post_count_with_ad++;

					$catlist_float = array();
					$catlist_meta = array();
					if ( $dp_options['show_category'] ) :
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
						<article class="p-entry__pickup-item">
							<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
								<div class="p-entry__pickup__thumbnail">
<?php
					echo "\t\t\t\t\t\t\t\t\t";
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size2' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-500x348.gif" alt="">';
					endif;
					echo "\n";

					// ネイティブ内部広告
					if ( $post->show_native_ad && $post->native_ad_label ) :
						echo "\t\t\t\t\t\t\t\t\t";
						echo '<div class="p-float-native-ad-label">' . esc_html( $post->native_ad_label ) . '</div>' . "\n";
					elseif ( $dp_options['show_category'] ) :
						$catlist_float = array();
						$categories = get_the_category();
						if ( $categories && ! is_wp_error( $categories ) ) :
							foreach( $categories as $category ) :
								$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
								break;
							endforeach;
						endif;
						if ( $catlist_float ) :
							echo "\t\t\t\t\t\t\t\t\t";
							echo '<div class="p-entry__pickup__category p-float-category u-visible-xs">' . implode( ', ', $catlist_float ) . '</div>' . "\n";
						endif;
					endif;
?>
								</div>
								<h3 class="p-entry__pickup__title p-article__title"><?php echo wp_trim_words( get_the_title(), 30, '...' ); ?></h3>
<?php
					if ( $dp_options['show_date'] || $catlist_meta ) :
?>
								<p class="p-entry__pickup__meta p-article__meta u-visible-xs"><?php if ( $dp_options['show_date'] ) : ?><time class="p-entry__pickup__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?><?php if ( $catlist_meta ) : ?><span class="p-entry__pickup__category"><?php echo implode( ', ', $catlist_meta ); ?></span><?php endif; ?></p>
<?php
					endif;
?>
							</a>
						</article>
<?php
					if ( $post_count_with_ad >= $dp_options['pickup_post_num'] ) break;

					// ネイティブ外部広告
					if ( $dp_options['show_pickup_post_native_ad'] && $dp_options['pickup_post_native_ad_position'] && 0 === ( $post_count % $dp_options['pickup_post_native_ad_position'] ) ) :
						$native_ad = get_native_ad();
						if ( $native_ad ) :
							$post_count_with_ad++;
?>
						<article class="p-entry__pickup-item">
							<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
								<div class="p-entry__pickup__thumbnail">
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
							echo "\t\t\t\t\t\t\t\t\t";
							echo '<img src="' . esc_attr( $image_src ) . '" alt="">' . "\n";

							if ( $native_ad['native_ad_label'] ) :
								echo "\t\t\t\t\t\t\t\t\t";
								echo '<div class="p-float-native-ad-label">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
							endif;
?>
								</div>
								<h3 class="p-entry__pickup__title p-article__title"><?php echo wp_trim_words( $native_ad['native_ad_title'], 30, '...' ); ?></h3>
							</a>
						</article>
<?php
						endif;
					endif;

					if ( $post_count_with_ad >= $dp_options['pickup_post_num'] ) break;
				endwhile;
				wp_reset_postdata();

				if ( $post_count_with_ad % 3 === 1 ) :
					echo '<div class="p-entry__pickup-item u-hidden-xs"></div><div class="p-entry__pickup-item u-hidden-xs"></div>' . "\n";
				elseif ( $post_count_with_ad % 3 === 2 ) :
					echo '<div class="p-entry__pickup-item u-hidden-xs"></div>' . "\n";
				endif;
?>
					</div>
				</div>
			</section>
<?php
			endif;
		endif;

		if ( $dp_options['show_related_post'] ) :
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'post__not_in' => array( $post->ID ),
				'posts_per_page' => $dp_options['related_post_num'],
				'orderby' => 'rand'
			);
			$categories = get_the_category();
			if ( $categories ) :
				$category_ids = array();
				foreach( $categories as $category ) :
					if ( !empty( $category->term_id ) ) :
						$category_ids[] = $category->term_id;
					endif;
				endforeach;
				if ( $category_ids ) :
					$args['tax_query'][] = array(
						'taxonomy' => 'category',
						'field' => 'term_id',
						'terms' => $category_ids,
						'operator' => 'IN'
					);
				endif;
			endif;
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
?>
			<section class="p-entry__related">
				<div class="p-entry__related__inner">
<?php
				if ( $dp_options['related_post_headline'] ) :
?>
					<h2 class="p-headline"><?php echo esc_html( $dp_options['related_post_headline'] ); ?></h2>
<?php
				endif;
?>
					<div class="p-entry__related-items">
<?php
				$post_count = 0;
				$post_count_with_ad = 0;
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$post_count++;
					$post_count_with_ad++;
?>
						<article class="p-entry__related-item">
							<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
								<div class="p-entry__related__thumbnail p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>">
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
						echo '<div class="p-float-native-ad-label__small u-hidden-xs">' . esc_html( $post->native_ad_label ) . '</div>' . "\n";
						echo "\t\t\t\t\t\t\t\t\t";
						echo '<div class="p-float-native-ad-label u-visible-xs">' . esc_html( $post->native_ad_label ) . '</div>' . "\n";
					elseif ( $dp_options['show_category'] ) :
						$catlist_float = array();
						$categories = get_the_category();
						if ( $categories && ! is_wp_error( $categories ) ) :
							foreach( $categories as $category ) :
								$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
								break;
							endforeach;
						endif;
						if ( $catlist_float ) :
							echo "\t\t\t\t\t\t\t\t\t";
							echo '<div class="p-entry__related__category p-float-category u-visible-xs">' . implode( ', ', $catlist_float ) . '</div>' . "\n";
						endif;
					endif;
?>
								</div>
								<h3 class="p-entry__related__title p-article__title"><?php echo wp_trim_words( get_the_title(), 30, '...' ); ?></h3>
<?php
					if ( $dp_options['show_date'] ) :
?>
								<p class="p-entry__related__meta p-article__meta u-visible-xs"><time class="p-entry__related__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
					endif;
?>
							</a>
						</article>
<?php
					if ( $post_count_with_ad >= $dp_options['related_post_num'] ) break;

					// ネイティブ外部広告
					if ( $dp_options['show_related_post_native_ad'] && $dp_options['related_post_native_ad_position'] && 0 === ( $post_count % $dp_options['related_post_native_ad_position'] ) ) :
						$native_ad = get_native_ad();
						if ( $native_ad ) :
							$post_count_with_ad++;
?>
						<article class="p-entry__related-item">
							<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
								<div class="p-entry__related__thumbnail p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>">
<?php
							if ( ! empty( $native_ad['native_ad_image'] ) ) :
								$image_src = wp_get_attachment_image_src( $native_ad['native_ad_image'], 'size3' );
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
								echo '<div class="p-float-native-ad-label__small u-hidden-xs">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
								echo "\t\t\t\t\t\t\t\t\t";
								echo '<div class="p-float-native-ad-label u-visible-xs">' . esc_html( $native_ad['native_ad_label'] ) . '</div>' . "\n";
							endif;
?>
								</div>
								<h3 class="p-entry__related__title p-article__title"><?php echo wp_trim_words( $native_ad['native_ad_title'], 30, '...' ); ?></h3>
							</a>
						</article>
<?php
						endif;
					endif;

					if ( $post_count_with_ad >= $dp_options['related_post_num'] ) break;
				endwhile;
				wp_reset_postdata();

				if ( $post_count_with_ad % 4 === 1) :
					echo '<div class="p-entry__related-item u-hidden-xs"></div><div class="p-entry__related-item u-hidden-xs"></div><div class="p-entry__related-item u-hidden-xs"></div>' . "\n";
				elseif ( $post_count_with_ad % 4 === 2) :
					echo '<div class="p-entry__related-item u-hidden-xs"></div><div class="p-entry__related-item u-hidden-xs"></div>' . "\n";
				elseif ( $post_count_with_ad % 4 === 3) :
					echo '<div class="p-entry__related-item u-hidden-xs"></div>' . "\n";
				endif;

?>
					</div>
				</div>
			</section>
<?php
			endif;
		endif;

		if ( $dp_options['show_comment'] ) :
			comments_template( '', true );
		endif;
?>
		</article>
<?php
	endwhile;
endif;

if ( $active_sidebar ) :
	get_sidebar();
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
