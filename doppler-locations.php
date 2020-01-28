<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Doppler Locations
 * Description:       Manage store locations and preview them on a map
 * Version:           1.0.0
 * Author:            Doppler Creative
 * Author URI:        https://www.dopplercreative.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       doppler-locations
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

function activate_doppler_locations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	Doppler_Locations_Activator::activate();
}

function deactivate_doppler_locations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	Doppler_Locations_Deactivator::deactivate();
}

function uninstall_doppler_locations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uninstaller.php';
	Doppler_Locations_Uninstaller::uninstall();
}

// Use core activation/deactivation hooks
register_activation_hook( __FILE__, 'activate_doppler_locations' );
register_deactivation_hook( __FILE__, 'deactivate_doppler_locations' );
register_uninstall_hook(__FILE__, 'uninstall_doppler_locations');

// Evaluate the main file and include classes
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin.php';

// Add shortcodes
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes.php';


// Run the plugin
function run_doppler_locations() {
	// Make available for other classes
	global $doppler_locations_plugin;

	// Init plugin class
	$doppler_locations_plugin = new Doppler_Locations();
	$doppler_locations_plugin->run();
}

// Call the plugin
run_doppler_locations();