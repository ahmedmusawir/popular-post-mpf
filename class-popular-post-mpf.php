<?php 

/**
* Popular Post Class
*/
class MPFPopularPost
{
	
	function __construct()
	{
		add_action( 'wp_head', array($this, 'mpf_count_popular_posts') );
		add_filter( 'manage_posts_columns' , array( $this, 'add_views_column' ) );	
		add_action( 'manage_posts_custom_column' , array( $this, 'add_data_into_views_column' ), 5, 2 );

	}

	public function add_views_column( $columns ) {

	    $columns['post_views'] = __('Views');
	    $columns['featured_image'] = __('Featured Image');

	    return $columns;
	}

	function add_data_into_views_column( $column_name, $postID ) {

		// print_r($column_name);

		if ( $column_name === 'post_views' ) {
	
			echo get_post_meta( $postID, 'views', true ); 

		}

		if ( $column_name === 'featured_image' ) {
	
			// Give the Post Thumbnail a class "alignleft".
			echo get_the_post_thumbnail( $postID, 'thumbnail', array( 'class' => 'alignleft' ) );			

		}
		
	}	

	public function mpf_count_popular_post_views( $postID )	{
		
		$total_key = 'views';
		//Get current views field 
		$total = get_post_meta( $postID, $total_key, true );
		// echo '<h1 style="background: white;">Top View: '. $total .'</h1>';

		//If current views field is empty, set it to One 
		if ( $total == '' ) {

			delete_post_meta( $postID, $total_key );
			add_post_meta( $postID, $total_key, '1' );


		} else {
			//if current views field has a value, add 1 to that 
			$total++;
			update_post_meta( $postID, $total_key, $total );
			// echo '<h1>Total View: '. $total .'</h1>';
		}

	}

	public function mpf_count_popular_posts() {

		//Check that this is a single post and the user is a visitor 
		if ( !is_single() ) return;
		if ( !is_user_logged_in() ) {
			//Get the post ID 
			if ( empty( $post_id ) ) {
				global $post;
				$post_id = $post->ID;
			}
			// Run Post Popularity Counter on post 
			$this->mpf_count_popular_post_views( $post_id );

		}
	}
}