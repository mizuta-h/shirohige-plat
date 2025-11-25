<?php
global $post, $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_option();
$breadcrumb_position = 1;
?>
	<div class="p-breadcrumb c-breadcrumb">
		<ul class="p-breadcrumb__inner c-breadcrumb__inner l-inner u-clearfix" itemscope itemtype="https://schema.org/BreadcrumbList">
			<li class="p-breadcrumb__item c-breadcrumb__item p-breadcrumb__item--home c-breadcrumb__item--home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="item"><span itemprop="name">HOME</span></a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
if ( is_author() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ); ?>
			</li>
<?php
elseif ( is_category() ) :
	if ( $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;

	$ancestors = get_ancestors( get_query_var( 'cat' ), 'category' );
	if ( $ancestors ) :
		foreach( array_reverse( $ancestors ) as $category_id ) :
			$category = get_term_by( 'id', $category_id, 'category' );
			if ( empty( $category->name ) ) continue;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
		endforeach;
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( single_cat_title( '', false ) ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_tag() ) :
	if ( $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( single_tag_title( '', false ) ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_search() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php _e( 'Search result', 'tcd-w' ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_year() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'Y', 'tcd-w' ), $post ) ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_month() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'F, Y', 'tcd-w' ), $post ) ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_day() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( get_the_time( __( 'F jS, Y', 'tcd-w' ), $post ) ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_home() ) :
	if ( $dp_options['blog_breadcrumb_label'] ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
elseif ( is_page() ) :

	$ancestors_ids = array_reverse(get_post_ancestors( $post ));
	$content_num = 2;
	?>
	<?php
	  if(!empty($ancestors_ids)){
		foreach($ancestors_ids as $page_id):
	?>
	<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="p-breadcrumb__item c-breadcrumb__item"><a itemprop="item" href="<?php echo esc_url(get_permalink($page_id)); ?>"><span itemprop="name"><?php echo esc_html(get_the_title($page_id)); ?></span></a><meta itemprop="position" content="<?php echo esc_attr($content_num); ?>"></li>
	<?php
		  $content_num++;
		endforeach;
	  };
	?>
	<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" ><span itemprop="name"><?php the_title_attribute(); ?></span><meta itemprop="position" content="<?php echo esc_attr($content_num); ?>"></li>
	
<?php
elseif ( is_singular( 'post' ) ) :
	if ( $dp_options['blog_breadcrumb_label'] ) :

?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $dp_options['blog_breadcrumb_label'] ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
	endif;
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<?php
	$categories = get_the_category();
	foreach ( $categories as $key => $category ) :
		if ( 0 !== $key ) :
			echo ', ';
		endif;
?>
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" itemprop="item">
					<span itemprop="name"><?php echo esc_html( $category->name ); ?></span>
				</a>
<?php
	endforeach;
?>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php echo strip_tags( get_the_title( $post->ID ) ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
elseif ( is_404() ) :
?>
			<li class="p-breadcrumb__item c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name"><?php _e( "Sorry, but you are looking for something that isn't here.", 'tcd-w' ); ?></span>
				<meta itemprop="position" content="<?php echo $breadcrumb_position++; ?>" />
			</li>
<?php
endif;
?>
		</ul>
	</div>
