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

$author = get_queried_object();
if ( $author->show_author ) :
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
			<section class="p-author">
				<h2 class="p-headline"><?php printf( __( 'Author profile', 'tcd-w' ), esc_html( $author->display_name ) ); ?></h2>
				<div class="p-author__box u-clearfix">
					<div class="p-author__thumbnail">
						<?php echo get_avatar( $author->ID, 260 ); ?>
					</div>
					<div class="p-author__info">
						<div class="p-author__title"><?php echo esc_html( $author->display_name ); ?></div><?php if ( $dp_options['show_author_views'] ) : ?><span class="p-author__views"><?php echo number_format( get_author_views( $author->ID ) ); ?> views</span><?php endif; ?>
						<div class="p-author__desc"><?php
	// URL自動リンク
	$pattern = '/(href=")?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
	$desc = preg_replace_callback( $pattern, function( $matches ) {
		// 既にリンクの場合はそのまま
		if ( isset( $matches[1] ) ) return $matches[0];
		return "<a href=\"{$matches[0]}\" target=\"_blank\">{$matches[0]}</a>";
	}, $author->description );
	echo wpautop( trim( $desc ) );
					?></div>
<?php
	if ( $sns_html ) :
?>
						<ul class="p-social-nav"><?php echo $sns_html; ?></ul>
<?php
	endif;
?>
					</div>
				</div>
			</section>
<?php
endif;

if ( have_posts() ) :
?>
			<section class="p-author__blog-list">
				<div class="p-author__blog-list__inner">
					<h2 class="p-headline"><?php printf( __( 'Archive for %s', 'tcd-w' ), esc_html( $author->display_name ) ); ?></h2>
					<div class="p-author__blog-list__items">
<?php
	$post_count = 0;
	$post_count_with_ad = 0;
	while ( have_posts() ) :
		the_post();
		$post_count++;
		$post_count_with_ad++;

		$catlist_float = array();
		$catlist_meta = array();
		if ( $dp_options['show_category'] ) :
			$categories = get_the_category();
			if ( $categories && ! is_wp_error( $categories ) ) :
				foreach( $categories as $category ) :
					if (!$catlist_float) :
						$catlist_float[] = '<span class="p-category__item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
					endif;
					$catlist_meta[] = '<span data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
				endforeach;
			endif;
		endif;
?>
						<article class="p-author__blog-list__item">
							<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
								<div class="p-author__blog-list__thumbnail">
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
					$catlist_float[] = '<span class="p-category__item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
					break;
				endforeach;
			endif;
			if ( $catlist_float ) :
				echo "\t\t\t\t\t\t\t\t\t";
				echo '<div class="p-author__blog-list__category p-float-category u-visible-xs">' . implode( ', ', $catlist_float ) . '</div>' . "\n";
			endif;
		endif;
?>
								</div>
								<h3 class="p-author__blog-list__title p-article__title"><?php echo wp_trim_words( get_the_title(), 30, '...' ); ?></h3>
<?php
		if ( $dp_options['show_date'] || $catlist_meta ) :
?>
								<p class="p-author__blog-list__meta p-article__meta u-visible-xs"><?php if ( $dp_options['show_date'] ) : ?><time class="p-author__blog-list__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?><?php if ( $catlist_meta ) : ?><span class="p-author__blog-list__category"><?php echo implode( ', ', $catlist_meta ); ?></span><?php endif; ?></p>
<?php
		endif;
?>
							</a>
						</article>
<?php
		// ネイティブ外部広告
		if ( $dp_options['show_author_archive_native_ad'] && $dp_options['archive_native_ad_position'] && 0 === ( $post_count % $dp_options['archive_native_ad_position'] ) ) :
			$native_ad = get_native_ad();
			if ( $native_ad ) :
				$post_count_with_ad++;
?>
						<article class="p-author__blog-list__item">
							<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" target="_blank">
								<div class="p-author__blog-list__thumbnail">
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
								<h3 class="p-author__blog-list__title p-article__title"><?php echo wp_trim_words( $native_ad['native_ad_title'], 30, '...' ); ?></h3>
							</a>
						</article>
<?php
			endif;
		endif;
	endwhile;

	if ( $post_count_with_ad % 3 === 1 ) :
		echo '<div class="p-author__blog-list__item u-hidden-xs"></div><div class="p-author__blog-list__item u-hidden-xs"></div>' . "\n";
	elseif ( $post_count_with_ad % 3 === 2 ) :
		echo '<div class="p-author__blog-list__item u-hidden-xs"></div>' . "\n";
	endif;
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
?>
				</div>
			</section>
<?php
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
