<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/includes
 * @author     Jan Henckens <jan@studioespresso.co>
 */
class WP_Sponsors {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Sponsors_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $wp_sponsors The string used to uniquely identify this plugin.
	 */
	protected $wp_sponsors;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->wp_sponsors = 'wp-sponsors';
		$this->version     = '3.2.0';

		$this->define_constants();
		$this->load_dependencies();
		$this->set_locale();
		$this->define_general_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function define_constants() {
		if ( ! defined( 'WP_SPONSORS_VERSION' ) ) {
			define( 'WP_SPONSORS_VERSION', $this->version );
		}

		if ( ! defined( 'WP_SPONSORS_URL' ) ) {
			define( 'WP_SPONSORS_URL', plugin_dir_url( WP_SPONSORS_FILE ) );
		}

		if ( ! defined( 'WP_SPONSORS_PATH' ) ) {
			define( 'WP_SPONSORS_PATH', plugin_dir_path( WP_SPONSORS_FILE ) );
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Sponsors_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Sponsors_i18n. Defines internationalization functionality.
	 * - Wp_Sponsors_Admin. Defines all hooks for the dashboard.
	 * - Wp_Sponsors_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-widget.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-shortcodes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-installer.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-blocks.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-ajax.php';
		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-sponsors-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-sponsors-extras.php';

		$extra = new WP_Sponsors_Extras();
		$extra->setup();

		new WP_Sponsors_Blocks();

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-sponsors-public.php';

		$this->loader = new WP_Sponsors_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Sponsors_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP_Sponsors_i18n();
		$plugin_i18n->set_domain( $this->get_wp_sponsors() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		if ( ! is_admin() ) { return; }

		$plugin_admin = new WP_Sponsors_Admin( $this->get_wp_sponsors(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin,'add_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin,'save_meta_boxes' );
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'update' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'manage_sponsors_posts_custom_column', $plugin_admin, 'sponsors_custom_columns', 10, 2 );

		$this->loader->add_filter( 'manage_edit-sponsors_sortable_columns', $plugin_admin,'sponsor_order_column' );
		$this->loader->add_filter( 'manage_sponsors_posts_columns', $plugin_admin, 'add_new_sponsors_column' );

		$plugin_ajax = new WP_Sponsors_AJAX();
		$this->loader->add_action( 'wp_ajax_wp_sponsors_get_categories', $plugin_ajax, 'get_categories' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP_Sponsors_Public( $this->get_wp_sponsors(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'sponsors_acquisition_form_submit' );


	}

	/**
	 * Define General Hooks used for anything else.
	 * Some both on public and admin.
	 */
	private function define_general_hooks() {
		register_activation_hook( WP_SPONSORS_FILE, array( 'WP_Sponsors_Installer', 'install' ) );

		$installer  = new WP_Sponsors_Installer();
		$shortcodes = new WP_Sponsors_Shortcodes();
		$this->loader->add_action( 'init', $installer, 'register', 0 );
		$this->loader->add_action( 'init', $installer, 'check_version' );
		$this->loader->add_action( 'init', $shortcodes, 'register_shortcodes', 0 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_wp_sponsors() {
		return $this->wp_sponsors;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Sponsors_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
