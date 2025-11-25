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
<?php
endif;
?>

		<div class="p-entry <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
			<h1 class="p-entry__title"><?php _e( "Sorry, but you are looking for something that isn't here.", 'tcd-w' ); ?></h1>
		</div>
<?php
if ( $active_sidebar ) :
	get_sidebar();
?>
	</div>
<?php
endif;
?>
</main>
<?php get_footer(); ?>
