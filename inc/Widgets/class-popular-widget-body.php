<?php 
/**
 *
 * Widget Class
 *
 */


/**
 * Adds Foo_Widget widget.
 */
class MPFPoluparPostWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'mpf_popular_post_widget', // Base ID
			esc_html__( 'MPF Popular Posts', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Displays Popular Posts by Views', 'text_domain' ), ) // Args
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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$sticky = get_option( 'sticky_posts' );
		//The args 
		$query_args = array(
			'post_type' => 'post',
			'posts_per_page' => 5,
			'meta_key' => 'views',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'ignore_sticky_posts' => 1, //this only ignores the fact that it' sticky, doesn't remove it from the list.
			'post__not_in' => $sticky
		);

		// The Query
		$the_query = new WP_Query( $query_args );		

		// The Loop
		if ( $the_query->have_posts() ) {
			echo '<ul class="mpf-pop-post-widget">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				?>
				
				<a href="<?php the_permalink(); ?>">
					<li>
						
						<?php  if ( ! has_post_thumbnail() ) : ?>

							<div class="mpf-col-1">
								<i class="fa fa-list-ul fa-3x" aria-hidden="true"></i>
							</div>
						
						<?php else: ?>
							<div class="mpf-col-1">
								<?php the_post_thumbnail('post-thumbnail', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']); ?>
							</div>
						<?php endif; ?>
							
						<div class="mpf-col-2"><?php the_title(); ?>
						[<?php echo get_post_meta( get_the_ID(), 'views', true ); ?>]		
						</div>

					</li>
				</a>	
				
				<?php
				
			}
			echo '</ul>';
			/* Restore original Post Data */
			wp_reset_postdata();
		} else {
			// no posts found
		}

		echo $args['after_widget'];
		
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );

		?>

			<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
			<input class="widefat" 
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
				type="text" 
				value="<?php echo esc_attr( $title ); ?>"
			>
			</p>

		<?php 
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Foo_Widget