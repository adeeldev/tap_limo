<?php
/*
 * Plugin Name: Off the Shelf Core Feature Pack
 * Plugin URI: http://www.shapingrain.com/
 * Description: Provides profiles, banners, modal windows and advanced shortcodes for the Off the Shelf theme.
 * Version: 1.0.7
 * Author: ShapingRain.com Labs
 * Author URI: http://www.shapingrain.com/
 */

/*
 * Global constants
 */
define('OFFTHESHELF_FEATURE_PACK', true);


/*
 * Third Party Libraries
 */
if ( ! class_exists( 'SR_Custom_Post_Type') ) {
	require_once ( plugin_dir_path (  __FILE__  ) . '/libs/class.custom-post-types.php' );
}


/*
 * Include individual components
 */
require_once ( plugin_dir_path (  __FILE__  ) . '/profiles.php' );
require_once ( plugin_dir_path (  __FILE__  ) . '/banners.php' );
require_once ( plugin_dir_path (  __FILE__  ) . '/modals.php' );
require_once ( plugin_dir_path (  __FILE__  ) . '/advanced-shortcodes.php' );
require_once ( plugin_dir_path (  __FILE__  ) . '/tools.php' );


/*
 * Load plugin textdomain.
 */
function offtheshelf_features_load_textdomain() {
	load_plugin_textdomain( 'offtheshelf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'offtheshelf_features_load_textdomain' );


/*
 * Compatibility check
 */
function offtheshelf_features_check_theme() {
	if ( ! function_exists('offtheshelf_option') ) {

		add_action( 'admin_init', 'offtheshelf_features_plugin_deactivate' );
		add_action( 'admin_notices', 'offtheshelf_features_plugin_admin_notice' );

		function offtheshelf_features_plugin_deactivate() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}

		function offtheshelf_features_plugin_admin_notice() {
			echo '<div class="updated"><p>' . __('<strong>Off the Shelf Feature Pack</strong> requires the Off the Shelf theme and has been <strong>deactivated</strong>.', 'offtheshelf') .'</p></div>';
			if ( isset( $_GET['activate'] ) )
				unset( $_GET['activate'] );
		}
	}
}
add_action( 'init', 'offtheshelf_features_check_theme' );


/*
 * Initialization routine
 */
function offtheshelf_features_activation() {
	if ( function_exists('offtheshelf_option_global') && function_exists('offtheshelf_setup_initial_setup') ) {
		if ( ! offtheshelf_option_global('setup_init_done') ) {
			// theme has never before been activated, so we need to run initial setup routine
			offtheshelf_setup_initial_setup();
		}
	}
}
register_activation_hook( __FILE__, 'offtheshelf_features_activation' );
