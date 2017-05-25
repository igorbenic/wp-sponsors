<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://studioespresso.co
 * @since             1.0.0
 * @package           Wp_Sponsors
 *
 * @wordpress-plugin
 * Plugin Name:       Sponsors
 * Plugin URI:        http://studioespresso.co
 * Description:       Add links and logo's for your sponsors/partners/etc to your sidebars and posts with our widget and shortcode.
 * Version:           2.3.1
 * Author:            Studio Espresso
 * Author URI:        http://studioespresso.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-sponsors
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-sponsors-activator.php
 */
function activate_wp_sponsors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-sponsors-activator.php';
	Wp_Sponsors_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-sponsors-deactivator.php
 */
function deactivate_wp_sponsors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-sponsors-deactivator.php';
	Wp_Sponsors_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_sponsors' );
register_deactivation_hook( __FILE__, 'deactivate_wp_sponsors' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-sponsors.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_sponsors() {

	$plugin = new Wp_Sponsors();
	$plugin->run();

}
run_wp_sponsors();
