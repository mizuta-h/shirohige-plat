<?php
global $dp_options, $tcd_megamenu;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php if ( $dp_options['use_ogp'] ) { echo 'prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb#"'; } ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="description" content="<?php seo_description(); ?>">
<meta name="viewport" content="width=<?php echo is_no_responsive() ? '1280' : 'device-width'; ?>">
<?php if ( $dp_options['use_ogp'] ) { ogp(); } ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( $dp_options['use_load_icon'] ) : ?>
<div id="site_loader_overlay">
	<div id="site_loader_animation" class="c-load--<?php echo esc_attr( $dp_options['load_icon'] ); ?>">
		<?php if ( 'type3' === $dp_options['load_icon'] ) : ?>
		<i></i><i></i><i></i><i></i>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<div id="site_wrap">
	<header id="js-header" class="l-header">
		<div class="l-header__bar">
			<div class="l-inner">
<?php
if ( 'yes' == $dp_options['use_logo_image'] && $image = wp_get_attachment_image_src( $dp_options['header_logo_image_mobile'], 'full' ) ) :
?>
				<div class="p-logo l-header__logo l-header__logo--mobile<?php if ( $dp_options['header_logo_image_mobile_retina'] ) echo ' l-header__logo--retina'; ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_attr( $image[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"<?php if ( $dp_options['header_logo_image_mobile_retina'] ) echo ' width="' . floor( $image[1] / 2 ) . '"'; ?>></a>
				</div>
<?php
else :
?>
				<div class="p-logo l-header__logo l-header__logo--mobile l-header__logo--text">
					<a class="rich_font_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				</div>
<?php
endif;

if ( has_nav_menu( 'global' ) ) :
	$nav = wp_nav_menu( array(
		'container' => 'nav',
		'menu_class' => 'p-global-nav u-clearfix',
		'menu_id' => 'js-global-nav',
		'theme_location' => 'global',
		'link_after' => '<span></span>',
		'echo' => 0
	) );
	if ( $dp_options['show_header_search'] ) :
		$nav_replace = "$0\n";
		$nav_replace .= '<li class="p-header-search p-header-search--mobile">';
		$nav_replace .= '<form action="' . esc_url( home_url( '/' ) ) . '" method="get">';
		$nav_replace .= '<input type="text" name="s" value="' . esc_attr( get_query_var( 's' ) ) . '" class="p-header-search__input" placeholder="SEARCH">';
		$nav_replace .= '<input type="submit" value="&#xe915;" class="p-header-search__submit">';
		$nav_replace .= '</form>';
		$nav_replace .= "</li>\n";
		$nav = preg_replace('/<ul.*?js-global-nav.*?>/', $nav_replace, $nav);

	endif;
	echo $nav;

	if ( ! is_no_responsive() ) :
?>
				<a href="#" id="js-menu-button" class="p-menu-button c-menu-button u-visible-lg"></a>
<?php
	endif;
endif;

if ( $dp_options['show_sidemenu'] && ! is_mobile() && is_active_sidebar( 'sidemenu_widget' ) ) :
 ?>
				<a href="#" id="js-sidemenu-button" class="p-sidemenu-button c-sidemenu-button u-hidden-lg"></a>
<?php
endif;

if ( $dp_options['show_header_search'] ) :
?>
				<a href="#" id="js-search-button" class="p-search-button c-search-button u-hidden-lg"></a>
				<div class="p-header-search p-header-search--pc">
					<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
						<input type="text" name="s" value="<?php echo esc_attr( get_query_var( 's' ) ); ?>" class="p-header-search__input" placeholder="SEARCH">
					</form>
				</div>
<?php
endif;
?>
			</div>
		</div>
		<div class="l-inner">
<?php
if ( is_front_page() ){ $thisTag = 'h1'; } else { $thisTag = 'div'; }
if ( 'yes' == $dp_options['use_logo_image'] && $image = wp_get_attachment_image_src( $dp_options['header_logo_image'], 'full' ) ) :
?>
			<<?php echo $thisTag; ?> class="p-logo l-header__logo l-header__logo--pc<?php if ( $dp_options['header_logo_image_retina'] ) { echo ' l-header__logo--retina'; } ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_attr( $image[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>"<?php if ( $dp_options['header_logo_image_retina'] ) echo ' width="' . floor( $image[1] / 2 ) . '"'; ?>></a>
			</<?php echo $thisTag; ?>>
<?php
else :
?>
			<<?php echo $thisTag; ?> class="p-logo l-header__logo l-header__logo--pc l-header__logo--text">
				<a class="rich_font_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</<?php echo $thisTag; ?>>
<?php
endif;
?>
		</div>
<?php
if ( $tcd_megamenu ) :
?>
<?php
	foreach ( $tcd_megamenu as $menu_id => $value ) :
		if ( empty( $value['categories'] ) ) continue;
?>
		<div id="p-megamenu--<?php echo esc_attr( $menu_id ) ?>" class="p-megamenu p-megamenu--<?php echo esc_attr( $value['type'] ); ?>">
			<ul class="l-inner">
<?php
		$cnt = 0;
		foreach ( $value['categories'] as $menu ) :
			$category = get_term_by( 'id', $menu->object_id, 'category' );
			if ( empty( $category->term_id ) ) continue;

			if ( 'type2' === $value['type'] ) :
				$term_meta = get_option( 'taxonomy_' . $category->term_id );
				$image_src = null;
				if ( ! empty( $term_meta['image_megamenu'] ) ) :
					$image_src = wp_get_attachment_image_src( $term_meta['image_megamenu'], 'size2' );
				endif;
				if ( ! $image_src && ! empty( $term_meta['image'] ) ) :
					$image_src = wp_get_attachment_image_src( $term_meta['image'], 'size2' );
				endif;
				if ( ! empty( $image_src[0] ) ) :
					$image_src = $image_src[0];
				else :
					$image_src = get_template_directory_uri() . '/img/no-image-500x348.gif';
				endif;
?>
				<li><a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo get_category_link( $category->term_id ); ?>"><div class="p-megamenu__image p-hover-effect__image"><img src="<?php echo esc_attr( $image_src ); ?>" alt=""></div><?php echo esc_html( $category->name ); ?></a></li>
<?php
			elseif ( 'type3' === $value['type'] ) :
				// ネイティブ外部広告
				if ( ! empty( $dp_options['megamenu']['show_native_ad'] ) && in_array( $menu_id, $dp_options['megamenu']['show_native_ad'] ) ) :
					$native_ad = get_native_ad();
				else :
					$native_ad = false;
				endif;

				$megamenu_posts = get_posts( array(
					'cat' => $category->term_id,
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => $native_ad ? 3 : 4
				) );
?>
				<li<?php if ( ! $cnt ) echo ' class="is-active"'; ?>>
					<a class="p-megamenu__hover" href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></a>
<?php
				if ( $megamenu_posts || $native_ad ) :
?>
					<ul class="sub-menu">
<?php
					if ( $megamenu_posts ) :
						foreach( $megamenu_posts as $megamenu_post ) :
							if ( has_post_thumbnail( $megamenu_post->ID ) ) :
								$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $megamenu_post->ID ), 'size2' );
							else :
								$image_src = null;
							endif;
							if ( ! empty( $image_src[0] ) ) :
								$image_src = $image_src[0];
							else :
								$image_src = get_template_directory_uri() . '/img/no-image-500x348.gif';
							endif;
?>
						<li><a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo get_permalink( $megamenu_post ); ?>"><div class="p-megamenu__image p-hover-effect__image"><img src="<?php echo esc_attr( $image_src ); ?>" alt=""></div><?php echo wp_trim_words( get_the_title( $megamenu_post ), 24, '...' ); ?></a></li>
<?php
						endforeach;
					endif;

					// ネイティブ外部広告
					if ( $native_ad ) :
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
?>
						<li><a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" targer="_blank"><div class="p-megamenu__image p-hover-effect__image"><img src="<?php echo esc_attr( $image_src ); ?>" alt=""><?php if ( $native_ad['native_ad_label'] ) : ?><div class="p-float-native-ad-label__small"><?php echo esc_html( $native_ad['native_ad_label'] ); ?></div><?php endif; ?></div><?php echo esc_html( wp_trim_words( $native_ad['native_ad_title'], 24, '...' ) ); ?></a></li>
<?php

					endif;
?>
					</ul>
<?php
				endif;
?>
				</li>
<?php
			elseif ( 'type4' === $value['type'] ) :
?>
				<li><a class="p-megamenu__hover" href="<?php echo get_category_link( $category->term_id ); ?>"><span><?php echo esc_html( $category->name ); ?></span></a></li>
<?php
			endif;
			$cnt++;
		endforeach;
?>
			</ul>
		</div>
<?php
	endforeach;
endif;
?>
	</header>
