<?php
$dp_options = get_design_plus_option();
$active_sidebar = get_sidebar_id();
get_header();
?>
<main class="l-main">
<?php
get_template_part( 'template-parts/index-slider' );

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

// フリースペース
if ( $dp_options['index_editor'] ) :
	$freespace = apply_filters( 'the_content', $dp_options['index_editor'] );
	if ( $freespace ) :
?>
<div class="p-index-content p-entry__body">
<?php
		echo $freespace;
?>
</div>
<?php
	endif;
endif;

// タブチェック
$index_tabs = array();
for ( $i = 1; $i <= 4; $i++ ) :
	if ( ! $dp_options['show_index_tab' . $i] ) continue;

	if ( $dp_options['index_tab_label' . $i] ) :
		$index_tabs[$i] = $dp_options['index_tab_label' . $i];
	elseif ( 'type2' == $dp_options['index_tab_list_type' . $i] ) :
		$index_tabs[$i] = __( 'Recommend post', 'tcd-w' );
	elseif ( 'type3' == $dp_options['index_tab_list_type' . $i] ) :
		$index_tabs[$i] = __( 'Recommend post2', 'tcd-w' );
	elseif ( 'type4' == $dp_options['index_tab_list_type' . $i] ) :
		$index_tabs[$i] = __( 'Pickup post', 'tcd-w' );
	elseif ( 'type5' == $dp_options['index_tab_list_type' . $i] ) :
		$index_tabs[$i] = __( 'Recent posts', 'tcd-w' );
	elseif ( $dp_options['index_tab_category' . $i] ) :
		$category = get_term_by( 'id', $dp_options['index_tab_category' . $i], 'category' );
		if ( ! empty( $category->name ) ) :
			$index_tabs[$i] = $category->name;
		else :
			$dp_options['index_tab_category' . $i] = false;
			$index_tabs[$i] = __( 'Recent posts', 'tcd-w' );
		endif;
	else :
		$index_tabs[$i] = __( 'Recent posts', 'tcd-w' );
	endif;
endfor;

if ( $index_tabs ) :
?>
			<ul id="js-index-tab" class="p-index-tab">
<?php
	$tab_count = 0;
	foreach( $index_tabs as $tab_index => $tab_label ) :
		$tab_count++;
?>
				<li class="p-index-tab__item<?php if ( 1 === $tab_count ) echo ' is-active'; ?>"><a class="p-index-tab__link" href="#p-index-tab--<?php echo esc_attr( $tab_index ); ?>"><?php echo esc_html( $tab_label ); ?></a></li>
<?php
	endforeach;
?>
			</ul>
<?php
	$tab_count = 0;
	foreach( $index_tabs as $tab_index => $tab_label ) :
		$tab_count++;
?>
			<div id="p-index-tab--<?php echo esc_attr( $tab_index ); ?>" class="p-index-tab-content<?php if ( 1 === $tab_count ) echo ' is-active'; ?>">
<?php
		get_template_part( 'template-parts/index-tab-content' );
?>
			</div>
<?php
	endforeach;
	wp_reset_postdata();
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
