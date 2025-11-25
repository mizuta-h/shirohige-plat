<?php
/**
 * Styled post list (tcd ver)
 */
class Styled_Post_List1_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'styled_post_list1_widget', // ID
			__( 'Styled post list (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'styled_post_list1_widget',
				'description' => __( 'Displays styled post list.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {
		global $dp_options;
		if ( ! $dp_options ) $dp_options = get_design_plus_option();

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$list_style = $instance['list_style'];
		$list_type = $instance['list_type'];
		$post_num = $instance['post_num'];
		$show_date = $instance['show_date'];
		$post_order = $instance['post_order'];

		if ( ! in_array( $list_style, array( 'type1', 'type2', 'type3' ) ) ) {
			$list_style = 'type1';
		}

		if ( 'date2' == $post_order ) {
			$order = 'ASC';
		} else {
			$order = 'DESC';
		}
		if ( $post_order == 'date1' || $post_order == 'date2' ) {
			$post_order = 'date';
		}

		if ( 'recent_post' == $list_type ) {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $post_num,
				'ignore_sticky_posts' => 1,
				'orderby' => $post_order,
				'order' => $order
			);
		} else {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $post_num,
				'ignore_sticky_posts' => 1,
				'orderby' => $post_order,
				'order' => $order,
				'meta_key' => $list_type,
				'meta_value' => 'on'
			);
		}

		$widget_query = new WP_Query( $args );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( 'type2' == $list_style ) :
			echo '<ul class="p-widget-list p-widget-list__' . esc_attr( $list_style ) .' u-clearfix">'."\n";
		else :
			echo '<ul class="p-widget-list p-widget-list__' . esc_attr( $list_style ) .'">'."\n";
		endif;

		if ( $widget_query->have_posts() ) :
			global $post;
			while ( $widget_query->have_posts() ) :
				$widget_query->the_post();

				if ( 'type3' == $list_style ) :
?>
	<li class="p-widget-list__item">
		<a href="<?php the_permalink() ?>">
			<div class="p-widget-list__item-title p-article__title"><?php echo is_mobile() ? wp_trim_words( get_the_title(), 28, '...' ) : wp_trim_words( get_the_title(), 40, '...' ); ?></div>
<?php
					if ( $show_date ) :
?>
			<time class="p-widget-list__item-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
<?php
					endif;
?>
		</a>
	</li>
<?php
				elseif ( 'type2' == $list_style ) :
					$catlist_float = array();
					if ( $dp_options['show_category'] && has_category() ) :
						$categories = get_the_category();
						if ( $categories && ! is_wp_error( $categories ) ) :
							foreach( $categories as $category ) :
								$catlist_float[] = '<span class="p-category-item--' . esc_attr( $category->term_id ) . '" data-url="' . get_category_link( $category ) . '">' . esc_html( $category->name ) . '</span>';
								break;
							endforeach;
						endif;
					endif;
?>
	<li class="p-widget-list__item">
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink() ?>">
			<div class="p-widget-list__item-thumbnail p-hover-effect__image"><?php
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size1' );
					else :
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
					endif;

					// ネイティブ内部広告
					if ( $post->show_native_ad && $post->native_ad_label ) :
						echo '<div class="p-float-native-ad-label">' . esc_html( $post->native_ad_label ) . '</div>';
					elseif ( $catlist_float ) :
						echo '<div class="p-float-category">' . implode( ', ', $catlist_float ) . '</div>';
					endif;

			?></div>
			<div class="p-widget-list__item-title p-article__title"><?php echo wp_trim_words( get_the_title(), 25, '...' ); ?></div>
<?php
					if ( $show_date ) :
?>
			<p class="p-widget-list__item-meta p-article__meta"><time class="p-widget-list__item-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
					endif;
?>
		</a>
	</li>
<?php
				else :
?>
	<li class="p-widget-list__item u-clearfix">
		<a class="p-hover-effect--<?php echo esc_attr( $dp_options['hover_type'] ); ?>" href="<?php the_permalink() ?>">
			<div class="p-widget-list__item-thumbnail p-hover-effect__image"><?php
					if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'size1' );
					else :
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-300x300.gif" alt="">';
					endif;

					// ネイティブ内部広告
					if ( $post->show_native_ad && $post->native_ad_label ) :
						echo '<div class="p-float-native-ad-label__small">' . esc_html( $post->native_ad_label ) . '</div>';
					endif;
			?></div>
			<div class="p-widget-list__item-title p-article__title"><?php echo is_mobile() ? wp_trim_words( get_the_title(), 30, '...' ) : wp_trim_words( get_the_title(), 34, '...' ); ?></div>
<?php
					if ( $show_date ) :
?>
			<p class="p-widget-list__item-meta p-article__meta"><time class="p-widget-list__item-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time></p>
<?php
					endif;
?>
		</a>
	</li>
<?php
				endif;
			endwhile;
			wp_reset_postdata();
		else :
?>
			<li class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></li>
<?php
		endif;

		echo "</ul>\n";

		echo $after_widget;
	}

	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$list_style = ! empty( $instance['list_style'] ) ? $instance['list_style'] : 'type1';
		$list_type = ! empty( $instance['list_type'] ) ? $instance['list_type'] : 'recent_post';
		$post_num = ! empty( $instance['post_num'] ) ? $instance['post_num'] : 5;
		$post_order = ! empty( $instance['post_order'] ) ? $instance['post_order'] : 'date1';
		$show_date = ! empty( $instance['show_date'] ) ? $instance['show_date'] : 0;
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'list_style' ); ?>"><?php _e( 'List type:', 'tcd-w' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'list_style' ); ?>" name="<?php echo $this->get_field_name( 'list_style' ); ?>" class="widefat">
				<option value="type1" <?php selected( $list_style, 'type1' ); ?>><?php _e( '1 Column', 'tcd-w' ); ?></option>
				<option value="type2" <?php selected( $list_style, 'type2' ); ?>><?php _e( '2 Columns', 'tcd-w' ); ?></option>
				<option value="type3" <?php selected( $list_style, 'type3' ); ?>><?php _e( 'Title only', 'tcd-w' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'list_type' ); ?>"><?php _e( 'Post type:', 'tcd-w' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'list_type' ); ?>" name="<?php echo $this->get_field_name( 'list_type' ); ?>" class="widefat">
				<option value="recent_post" <?php selected( $list_type, 'recent_post' ); ?>><?php _e( 'Recent post', 'tcd-w' ); ?></option>
				<option value="recommend_post" <?php selected( $list_type, 'recommend_post' ); ?>><?php _e( 'Recommend post', 'tcd-w' ); ?></option>
				<option value="recommend_post2" <?php selected( $list_type, 'recommend_post2' ); ?>><?php _e( 'Recommend post2', 'tcd-w' ); ?></option>
				<option value="pickup_post" <?php selected( $list_type, 'pickup_post' ); ?>><?php _e( 'Pickup post', 'tcd-w' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Number of post:', 'tcd-w' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" class="widefat">
<?php
		for ( $i = 1; $i <= 10; $i++ ) {
			echo '<option value="' . $i . '" ' . selected( $post_num, $i ) . '>' . $i . '</option>' . "\n";
		}
?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_order' ); ?>"><?php _e( 'Post order:', 'tcd-w' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'post_order' ); ?>" name="<?php echo $this->get_field_name( 'post_order' ); ?>" class="widefat">
				<option value="date1" <?php selected( $post_order, 'date1' ); ?>><?php _e( 'Date (DESC)', 'tcd-w' ); ?></option>
				<option value="date2" <?php selected( $post_order, 'date2' ); ?>><?php _e( 'Date (ASC)', 'tcd-w' ); ?></option>
				<option value="rand" <?php selected( $post_order, 'rand' ); ?>><?php _e( 'Random', 'tcd-w' ); ?></option>
			</select>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" value="1" <?php checked( $show_date, 1 ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display date', 'tcd-w' ); ?></label>
		</p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['list_style'] = strip_tags( $new_instance['list_style'] );
		$instance['list_type'] = strip_tags( $new_instance['list_type'] );
		$instance['post_num'] = strip_tags( $new_instance['post_num'] );
		$instance['post_order'] = strip_tags( $new_instance['post_order'] );
		$instance['show_date'] = strip_tags( $new_instance['show_date'] );
		return $instance;
	}
}

function register_styled_post_list1_widget() {
	register_widget( 'Styled_Post_List1_Widget' );
}
add_action( 'widgets_init', 'register_styled_post_list1_widget' );
