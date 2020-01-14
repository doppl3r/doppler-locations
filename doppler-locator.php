<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Doppler Locator
 * Description:       Manage store locations and preview them on a map
 * Version:           1.0.0
 * Author:            Doppler Creative
 * Author URI:        https://www.dopplercreative.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       doppler-locator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DOPPLER_LOCATORVERSION', '1.0.0' );

function activate_doppler_locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-doppler-locator-activator.php';
	Doppler_Locator_Activator::activate();
}

function deactivate_doppler_locator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-doppler-locator-deactivator.php';
	Doppler_Locator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_doppler_locator' );
register_deactivation_hook( __FILE__, 'deactivate_doppler_locator' );

require plugin_dir_path( __FILE__ ) . 'includes/class-doppler-locator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_doppler_locator() {

	$plugin = new Doppler_Locator();
	$plugin->run();

}
run_doppler_locator();
