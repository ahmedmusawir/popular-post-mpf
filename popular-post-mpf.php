<?php 

/**
 *
 * Plugin Name: MPF Popular Post  
 * Plugin URI:	https://htmlfivedev.com 
 * Description: Display a short notice above the post content.
 * Version: 	1.0
 * Author URI: 	https://www.linkedin.com/in/ahmedmusawir
 * License: 	GPL-2.0+ 
 *
 */

//If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die("Cannot Access Directly");
}
define( "PLUGIN_DIR", plugin_dir_path( __FILE__ ) );

// echo PLUGIN_DIR;
// echo plugin_dir_path( __FILE__ ) . '<br>';
// echo plugins_url( '/assets/js/admin.js', __FILE__ );
// die;

require_once( plugin_dir_path( __FILE__ ) . 'class-enqueue.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-popular-post-mpf.php' );
require_once( plugin_dir_path( __FILE__ ) . 'inc/Widgets/popular-post-widget-main.php' );

function mpf_popular_post_start() {

	$setup_styles = new MPFPopularPostEnqueue();
	$setup_styles->initialize();

	$popular_post = new MPFPopularPost();

	$pop_post_widget = new MPFPopularPostWidgetMain();

}

mpf_popular_post_start();

// Activation
require_once plugin_dir_path( __FILE__ ) . 'inc/Base/class-activate.php';
register_activation_hook( __FILE__, array( 'MPFPopularPostActivate', 'activate' ) );

// Activation
require_once plugin_dir_path( __FILE__ ) . 'inc/Base/class-deactivate.php';
register_deactivation_hook( __FILE__, array( 'MPFPopularPostDeactivate', 'deactivate' ) );