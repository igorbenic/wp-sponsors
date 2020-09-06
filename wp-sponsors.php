<?php

/**
 * Plugin Name:       Sponsors
 * Plugin URI:        http://www.wpsimplesponsorships.com
 * Description:       Add links and logo's for your sponsors/partners/etc to your sidebars and posts with our widget and shortcode.
 * Version:           3.4.0
 * Author:            Simple Sponsorships
 * Author URI:        http://www.wpsimplesponsorships.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-sponsors
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'WP_SPONSORS_FILE' ) ) {
	define( 'WP_SPONSORS_FILE', __FILE__ );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-sponsors-activator.php
 */
function activate_wp_sponsors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-sponsors-activator.php';
	WP_Sponsors_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_wp_sponsors' );

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

	$plugin = new WP_Sponsors();
	$plugin->run();

}
run_wp_sponsors();
