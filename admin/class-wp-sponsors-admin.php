<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/admin
 * @author     Jan Henckens <jan@studioespresso.co>
 */
class Wp_Sponsors_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_sponsors    The ID of this plugin.
	 */
	private $wp_sponsors;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $wp_sponsors       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_sponsors, $version ) {

		$this->wp_sponsors = $wp_sponsors;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Sponsors_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Sponsors_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wp_sponsors, plugin_dir_url( __FILE__ ) . 'css/wp-sponsors-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Sponsors_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Sponsors_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wp_sponsors, plugin_dir_url( __FILE__ ) . 'js/wp-sponsors-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->wp_sponsors, 'objectL10n', array(
			'title' => __('Select a sponsor logo', 'wp-sponsors'),
			'button' => __('Add image', 'wp-sponsors')
			));

	}

    /**
     * The function that checks for updates and runs the appropriate upgrade when needed
     *
     * @since     2.0.0
     */
    public function update() {
        if(is_admin()) {
        	if(get_option( 'sponsors_db_version') < 2 ) {
                $update = new WP_Sponsors_upgrade( $this->version );
                $update->run( 'upgrade200' );
        	}
            return;
        }
        return;
    }

}
