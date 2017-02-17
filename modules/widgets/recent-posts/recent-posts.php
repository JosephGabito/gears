<?php

/**
 * Adds Gears_Blog_Post_Widget widget.
 */
class Gears_Blog_Post_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gears_blog_post_widget', // Base ID
			__( 'Gears: Recent Posts', 'gears' ), // Name
			array( 'classname' => 'gears_blog_post_widget', 'description' => __( 'Use this widget to display blog post.', 'gears' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title =  __( 'Recent Posts', 'gears' );
		$max = 5;
		$sortby = 'date';
		$orderby = 'asc';
		$count = ! empty( $instance['count'] ) ? '1' : '0';

		if ( !empty( $instance['title'] ) ) {
		    $title = $instance['title'];
		}

		if ( !empty( $instance['max'] ) ) {
		    // $max = absint( $max );
				  $max = $instance['max'];
		}

		if ( !empty( $instance['sortby'] ) ) {
		    $sortby = $instance['sortby'];
		}

		if ( !empty( $instance['orderby'] ) ) {
		    $orderby = $instance['orderby'];
		}

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$stmt = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $max,
			'orderby'             => $sortby,
			'order'               => $orderby,
			'show_count'   				=> $count,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($stmt->have_posts()) :
		?>
		<?php echo $args['before_widget']; ?>

		<?php  echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>
		<ul>
			<?php while ( $stmt->have_posts() ) : $stmt->the_post();?>
  			<li <?php post_class(); ?> >
				<div class="gears-blog-posts-item">

					<div class="gears-blog-posts-item-thumbnail">
						<a title="<?php esc_attr( the_title() ); ?>" href="<?php esc_url( the_permalink() ); ?>">
							<?php the_post_thumbnail('thumbnail'); ?>
						</a>
					</div>

					<div class="gears-blog-posts-item-details">

						<div class="gears-blog-posts-item-details-title">
							<a title="<?php esc_attr( the_title() ); ?>" href="<?php esc_url( the_permalink() ); ?>">
								<?php the_title( '<h3 class="title">', '</h3>' ); ?>
							</a>
						</div>

						<div class="gears-blog-posts-item-details-comment">
							<a href="<?php echo esc_url( comments_link() ); ?>" class="gears_blog_post_comment" >
								<?php
									if ($count == 0) {
										_e('Leave a Comment', 'gears');
									}else{
 										comments_number( 'Leave a Comment', '<span class="comment-count">1</span> Comment', '<span class="comment-count">%</span> Comments' );
									}
								?>
							</a>
						</div>

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
  			</li>
			<?php endwhile; ?>
		</ul>

		<div class="clearfix"></div>

		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
		endif;
	}

	/**
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['max'] = (int) $new_instance['max'];
		$instance['sortby'] = $new_instance['sortby'] ;
		$instance['orderby'] = $new_instance['orderby'] ;
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;

		if ( in_array( $new_instance['sortby'], array( 'title', 'author', 'date', 'rand' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'date';
		}
		if ( in_array( $new_instance['orderby'], array( 'asc', 'desc' ) ) ) {
			$instance['orderby'] = $new_instance['orderby'];
		} else {
			$instance['orderby'] = 'desc';
		}
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = __('Recent Posts', 'gears');
		$max = 5;
		$sortby = __('date', 'gears');
		$orderby = __('desc', 'gears');
		$count = false;

		foreach ( $instance as $key => $value ) {
			if ( !empty( $instance[$key] ) ) {
				$$key = $instance[$key];
			}
		}

		?>
		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'gears' ); ?></label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

			<span class="help-text">

				<em><?php _e('You can use this field to enter the widget title.', 'gears'); ?></em>

			</span>

		</p>

		<p>

			<label for="<?php echo $this->get_field_id( 'max' ); ?>"><?php _e( 'Number of Posts to show: ', 'gears' ); ?></label>

			<input class="tiny-text" id="<?php echo $this->get_field_id( 'max' ); ?>" name="<?php echo $this->get_field_name( 'max' ); ?>" type="number" step="1" min="1" value="<?php echo $max; ?>" size="3" />

		</p>

		<p>

  			<label for="<?php echo $this->get_field_id( 'sortby' ); ?>"><?php _e( 'Sort By:', 'gears' ); ?></label>

			<select class="widefat" id="<?php echo $this->get_field_id( 'sortby' ); ?>" name="<?php echo $this->get_field_name( 'sortby' ); ?>" >

				<option value="title"<?php selected($sortby, 'title' ); ?>>
					<?php _e( 'Title', 'gears' ); ?>
				</option>

				<option value="author"<?php selected($sortby, 'author' ); ?>>
					<?php _e( 'Author', 'gears' ); ?>
				</option>

				<option value="date"<?php selected($sortby, 'date' ); ?>>
					<?php _e( 'Date', 'gears' ); ?>
				</option>

				<option value="rand"<?php selected($sortby, 'rand' ); ?>>
					<?php _e( 'Random', 'gears' ); ?>
				</option>

			</select>

		</p>

		<p>

			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'gears' ); ?></label>

			<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" >

				<option value="asc"<?php selected($orderby, 'asc' ); ?>>
					<?php _e( 'ASC', 'gears' ); ?>
				</option>

				<option value="desc"<?php selected($orderby, 'desc' ); ?>>
					<?php _e( 'DESC', 'gears' ); ?>
				</option>

			</select>

		</p>

		<p>

			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show Comment Count' ); ?></label><br />

		</p>
		<?php
	}

}// Class Gears_Blog_Post_Widget

add_action( 'widgets_init', 'gears_register_blog_post_widget' );

function gears_register_blog_post_widget() {

    if ( true === apply_filters( 'gears_widget_recent_posts_is_enabled', '__return_false', 10, 1 ) ):

        register_widget( 'Gears_Blog_Post_Widget' );

    endif;

	return;
}
