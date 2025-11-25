<?php
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
<?php
		endif;
?>
		<article class="p-entry <?php echo $active_sidebar ? 'l-primary' : 'l-inner'; ?>">
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
	endwhile;

	if ( $active_sidebar ) :
		get_sidebar();
?>
	</div>
<?php
	endif;
endif;
?>
</main>
<?php get_footer(); ?>
