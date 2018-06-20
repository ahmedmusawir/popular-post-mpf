<?php 
require_once( PLUGIN_DIR . 'inc/Widgets/class-popular-widget-body.php' );
/**
 * Widget Main Class
 */
class MPFPopularPostWidgetMain
{
	
	function __construct()
	{
		add_action( 'widgets_init', array( $this, 'mpf_first_widget' ) );
	}

	public function mpf_first_widget()	
	{
		register_widget( 'MPFPoluparPostWidget' );
	}
}