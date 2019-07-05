<?php

/**
 * Class WP_Sponsors_Activator
 */
class WP_Sponsors_Activator {

	/**
	 * Done on Activation.
	 */
	public static function activate() {
		if ( ! class_exists( 'WP_Sponsors_Installer') ) {
			include 'class-wp-sponsors-installer.php';
		}

		WP_Sponsors_Installer::install();
	}
}