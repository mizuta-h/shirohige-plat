<?php

class Ranking_List_Widget extends WP_Widget {

	private $default_instance = array();

	function __construct() {
		// デフォルト設定
		$this->default_instance = array(
			'title' => '',
			'post_num' => 3,
			'category' => 0,
			'show_views' => 0,
			'show_native_ad' => 0,
			'link_text' => '',
			'link_url' => '',
			'link_target_blank' => 0
		);

		// ランクカラー 0は6番以降に使用
		for ( $i = 0; $i <= 5; $i++ ) {
			if ( $i > 0 && $i <= 3 ) {
				$this->default_instance['rank_font_color' . $i] = '#ffffff';
				$this->default_instance['rank_bg_color' . $i] = '#000000';
			} else {
				$this->default_instance['rank_font_color' . $i] = '#000000';
				$this->default_instance['rank_bg_color' . $i] = '#ffffff';
			}
		}

		parent::__construct(
			'ranking_list_widget',// ID
			__( 'Ranking list (tcd ver)', 'tcd-w' ),
			array(
				'classname' => 'ranking_list_widget',
				'description' => __( 'Displays access ranking list.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		global $dp_options;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		$instance = wp_parse_args( (array) $instance, $this->default_instance );

		extract($args);

		$instance['post_num'] = absint( $instance['post_num'] );
		if ( ! $instance['post_num'] ) return;

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$query_args = array(
			'post_type' => 'post',
			'posts_per_page' => $instance['post_num'],
			'ignore_sticky_posts' => 1,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'meta_key' => '_views'
		);
		if ( $instance['category'] ) {
			$query_args['cat'] = $instance['category'];
		}

		$widget_query = new WP_Query( $query_args );

		// ネイティブ外部広告
		if ( ! empty( $instance['show_native_ad'] ) ) {
			$native_ad = get_native_ad();
		} else {
			$native_ad = false;
		}
?>
<ol class="p-widget-list p-widget-list__ranking">
<?php
		if ( $widget_query->have_posts() || $native_ad ) :
			global $post;
			$rank = 0;
			if ( $widget_query->have_posts() ) :
				while ( $widget_query->have_posts() ) :
					$widget_query->the_post();
					$rank++;
					$rank_style = '';

					if ( isset( $instance['rank_bg_color' . $rank] ) ) :
						$rank_style .= 'background: ' . esc_attr( $instance['rank_bg_color' . $rank] ) . '; ';
					elseif ( $instance['rank_bg_color0'] ) :
						$rank_style .= 'background: ' . esc_attr( $instance['rank_bg_color0'] ) . '; ';
					endif;
					if ( isset( $instance['rank_font_color' . $rank] ) ) :
						$rank_style .= 'color: ' . esc_attr( $instance['rank_font_color' . $rank] ) . '; ';
					elseif ( $instance['rank_font_color0'] ) :
						$rank_style .= 'color: ' . esc_attr( $instance['rank_font_color0'] ) . '; ';
					endif;
?>
	<li class="p-widget-list__item u-clearfix">
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink() ?>">
			<span class="p-widget-list__item-rank" style="<?php echo trim( $rank_style ); ?>"><?php echo $rank; ?></span>
			<div class="p-widget-list__item-thumbnail p-hover-effect__image"><?php
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size1' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">' . "\n";
					endif;
			?></div>
			<div class="p-widget-list__item-title p-article__title"><?php echo is_mobile() ? wp_trim_words( get_the_title(), 30, '...' ) : wp_trim_words( get_the_title(), 34, '...' ); ?></div>
<?php
					if ( $instance['show_views'] || ( $post->show_native_ad && $post->native_ad_label ) ) :
?>
			<div class="p-widget-list__item-meta p-article__meta"><?php
						if ( $instance['show_views'] ) :
				?><span class="p-article__views"><?php echo number_format( intval( get_post_meta( get_the_ID(), '_views', true ) ) ); ?> views</span><?php
						endif;

						// ネイティブ内部広告
						if ( $post->show_native_ad && $post->native_ad_label ) :
				?><span class="p-article__native-ad-label"><?php echo esc_html( $post->native_ad_label ); ?></span><?php
						endif;
			?></div>
<?php
					endif;
?>
		</a>
	</li>
<?php
				endwhile;
				wp_reset_postdata();
			endif;

			if ( $native_ad ) :
?>
	<li class="p-widget-list__item u-clearfix">
		<a class="p-native-ad__link p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php echo esc_attr( $native_ad['native_ad_url'] ); ?>" targer="_blank">
			<div class="p-widget-list__item-thumbnail p-hover-effect__image">
<?php
				if ( ! empty( $native_ad['native_ad_image'] ) ) :
					$image_src = wp_get_attachment_image_src( $native_ad['native_ad_image'], 'size1' );
				else :
					$image_src = null;
				endif;
				if ( ! empty( $image_src[0] ) ) :
					$image_src = $image_src[0];
				else :
					$image_src = get_template_directory_uri() . '/img/no-image-500x348.gif';
				endif;
?>
				<img src="<?php echo esc_attr( $image_src ); ?>" alt="">
<?php
				if ( $native_ad['native_ad_label'] ) :
?>
				<div class="p-float-native-ad-label p-float-native-ad-label__small"><?php echo esc_html( $native_ad['native_ad_label'] ); ?></div>
<?php
				endif;
?>
			</div>
			<div class="p-widget-list__item-title p-article__title"><?php echo esc_html( wp_trim_words( $native_ad['native_ad_title'], 34, '...' ) ); ?></div>
		</a>
	</li>
<?php
			endif;
		else :
?>
	<li class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></li>
<?php
		endif;
?>
</ol>
<?php
		if ( $instance['link_text'] && $instance['link_url'] ) :
?>
<p class="p-widget__ranking-link"><a href="<?php echo esc_attr( $instance['link_url'] ); ?>"<?php if ( $instance['link_target_blank'] ) echo ' target="_blank"'; ?>><?php echo esc_html( $instance['link_text'] ); ?></a></p>
<?php
		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $this->default_instance;
		$instance['title'] = wp_filter_nohtml_kses( $new_instance['title'] );
		$instance['post_num'] = absint( $new_instance['post_num'] );
		$instance['category'] = absint( $new_instance['category'] );
		$instance['show_views'] = ! empty( $new_instance['show_views'] ) ? 1 : 0;
		$instance['show_native_ad'] = ! empty( $new_instance['show_native_ad'] ) ? 1 : 0;
		$instance['link_text'] = wp_filter_nohtml_kses( $new_instance['link_text'] );
		$instance['link_url'] = wp_filter_nohtml_kses( $new_instance['link_url'] );
		$instance['link_target_blank'] = ! empty( $new_instance['link_target_blank'] ) ? 1 : 0;
		for ( $i = 0; $i <= 5; $i++ ) {
			$instance['rank_font_color' . $i] = wp_filter_nohtml_kses( $new_instance['rank_font_color' . $i] );
			$instance['rank_bg_color' . $i] = wp_filter_nohtml_kses( $new_instance['rank_bg_color' . $i] );
		}
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->default_instance );
		$instance['post_num'] = absint( $instance['post_num'] );
		$instance['category'] = absint( $instance['category'] );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Number of ranks:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" type="number" value="<?php echo esc_attr( $instance['post_num'] ); ?>" min="1">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:', 'tcd-w' ); ?></label>
<?php
		wp_dropdown_categories( array(
			'class' => 'widefat',
			'echo' => 1,
			'hide_empty' => 0,
			'hierarchical' => 1,
			'id' => $this->get_field_id( 'category' ),
			'name' => $this->get_field_name( 'category' ),
			'selected' => $instance['category'],
			'show_count' => 0,
			'show_option_all' => __( 'All categories', 'tcd-w' ),
			'value_field' => 'term_id'
		) );
?>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_views' ); ?>" name="<?php echo $this->get_field_name( 'show_views' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_views'], '1' ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_views' ); ?>"><?php _e( 'Display views', 'tcd-w' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_native_ad' ); ?>" name="<?php echo $this->get_field_name( 'show_native_ad' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_native_ad'], '1' ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_native_ad' ); ?>"><?php _e( 'Display native advertisement', 'tcd-w' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link text:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_attr( $instance['link_text'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_url' ); ?>"><?php _e( 'Link url:', 'tcd-w' ); ?></label>
			<input class="large-text" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['link_url'] ); ?>">
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'link_target_blank' ); ?>" name="<?php echo $this->get_field_name( 'link_target_blank' ); ?>" type="checkbox" value="1" <?php checked( $instance['link_target_blank'], '1' ); ?>>
			<label for="<?php echo $this->get_field_id( 'link_target_blank' ); ?>"><?php _e( 'Open link in new window', 'tcd-w' ); ?></label>
		</p>
<?php
		for ( $i = 1; $i <= 5; $i++ ) :
?>
		<div style="margin:1em 0;">
			<label for="<?php echo $this->get_field_id( 'rank_font_color' . $i ); ?>"><?php printf( __('Rank %d font color:', 'tcd-w' ), $i ); ?></label>
			<div><input type="text" id="<?php echo $this->get_field_id( 'rank_font_color' . $i ); ?>" name="<?php echo $this->get_field_name( 'rank_font_color' . $i ); ?>" value="<?php echo esc_attr( $instance['rank_font_color' . $i] ); ?>" class="c-color-picker-widget" data-default-color="<?php echo esc_attr( $this->default_instance['rank_font_color' . $i] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'rank_bg_color' . $i ); ?>"><?php printf( __('Rank %d background color:', 'tcd-w' ), $i ); ?></label>
			<div><input type="text" id="<?php echo $this->get_field_id( 'rank_bg_color' . $i ); ?>" name="<?php echo $this->get_field_name( 'rank_bg_color' . $i ); ?>" value="<?php echo esc_attr( $instance['rank_bg_color' . $i] ); ?>" class="c-color-picker-widget" data-default-color="<?php echo esc_attr( $this->default_instance['rank_bg_color' . $i] ); ?>"></div>
		</div>
<?php
		endfor;
		$i = 0;
?>
		<div style="margin:1em 0;">
			<label for="<?php echo $this->get_field_id( 'rank_font_color' . $i ); ?>"><?php _e( 'Other rank font color:', 'tcd-w' ); ?></label>
			<div><input type="text" id="<?php echo $this->get_field_id( 'rank_font_color' . $i ); ?>" name="<?php echo $this->get_field_name( 'rank_font_color' . $i ); ?>" value="<?php echo esc_attr( $instance['rank_font_color' . $i] ); ?>" class="c-color-picker-widget" data-default-color="<?php echo esc_attr( $this->default_instance['rank_font_color' . $i] ); ?>"></div>
			<label for="<?php echo $this->get_field_id( 'rank_bg_color' . $i ); ?>"><?php _e( 'Other rank background color:', 'tcd-w' ); ?></label>
			<div><input type="text" id="<?php echo $this->get_field_id( 'rank_bg_color' . $i ); ?>" name="<?php echo $this->get_field_name( 'rank_bg_color' . $i ); ?>" value="<?php echo esc_attr( $instance['rank_bg_color' . $i] ); ?>" class="c-color-picker-widget" data-default-color="<?php echo esc_attr( $this->default_instance['rank_bg_color' . $i] ); ?>"></div>
		</div>
<?php
	}
}

function register_ranking_list_widget() {
	register_widget( 'Ranking_List_Widget' );
}
add_action( 'widgets_init', 'register_ranking_list_widget' );
