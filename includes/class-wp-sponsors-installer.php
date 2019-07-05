<?php
/**
 * Class WP_Sponsors_Installer
 * A class to handle installing, updating and registering everything
 * related to Sponsors.
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Class WP_Sponsors_Installer
 */
class WP_Sponsors_Installer {

	/**
	 * DB updates and callbacks that need to be run per version.
	 *
	 * @var array
	 */
	private static $db_updates = array(
		'2.0.0' => array(
			'wp_sponsors_update_200'
		),
		'3.0.0' => array(
			'wp_sponsors_update_post_type_300'
		),
	);


	/**
	 * Register content
	 */
	public function register() {
		$this->create_sponsor_taxonomies();
		$this->sponsors_register();
	}

	/**
	 * Creates a categories taxonomy for the sponsors post type
	 */
	private function create_sponsor_taxonomies() {
		// Labels for the sponsor categories
		$labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search categories' ),
			'all_items'         => __( 'All categories' ),
			'parent_item'       => __( 'Parent category' ),
			'parent_item_colon' => __( 'Parent category:' ),
			'edit_item'         => __( 'Edit category' ),
			'update_item'       => __( 'Update category' ),
			'add_new_item'      => __( 'Add New category' ),
			'new_item_name'     => __( 'New category' ),
			'menu_name'         => __( 'Categories' ),
		);
		// Arguments for the sponsor categories (public = false means it don't have a url)
		$args = array(
			'hierarchical'      => true,
			'public'            => false,
			'rewrite'           => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
		);
		// Register the sponsors taxonomy
		register_taxonomy( 'sponsor_categories', array( 'sponsor' ), $args );
	}

	/**
	 * Registers the Sponsors custom post type
	 */
	private function sponsors_register() {
		$labels = array(
			'name'               => _x( 'Sponsors', 'post type general name', 'wp-sponsors' ),
			'singular_name'      => _x( 'Sponsor', 'post type singular name', 'wp-sponsors' ),
			'menu_name'          => _x( 'Sponsors', 'admin menu', 'wp-sponsors' ),
			'name_admin_bar'     => _x( 'Sponsor', 'add new on admin bar', 'wp-sponsors' ),
			'add_new'            => _x( 'Add New', 'book', 'wp-sponsors' ),
			'add_new_item'       => __( 'Add New Sponsor', 'wp-sponsors' ),
			'new_item'           => __( 'New Sponsor', 'wp-sponsors' ),
			'edit_item'          => __( 'Edit Sponsor', 'wp-sponsors' ),
			'view_item'          => __( 'View Sponsor', 'wp-sponsors' ),
			'all_items'          => __( 'All Sponsors', 'wp-sponsors' ),
			'search_items'       => __( 'Search Sponsors', 'wp-sponsors' ),
			'parent_item_colon'  => __( 'Parent Sponsors:', 'wp-sponsors' ),
			'not_found'          => __( 'No sponsor found.', 'wp-sponsors' ),
			'not_found_in_trash' => __( 'No sponsor found in Trash.', 'wp-sponsors' ),
			'featured_image'     => __( 'Sponsor Logo', 'wp-sponsors' ),
			'set_featured_image' => __( 'Set Sponsor Logo', 'wp-sponsors' ),
			'remove_featured_image' => __( 'Remove Sponsor Logo', 'wp-sponsors' ),
			'use_featured_image' => __( 'Use Sponsor Logo', 'wp-sponsors' ),
		);

		$args = array(
			//'public'               => true,
			'labels'               => $labels,
			'public'               => false,
			'exclude_from_search'  => true,
			'publicly_queryable'   => false,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_admin_bar'    => false,
			'menu_position'        => 5,
			'menu_icon'            => 'dashicons-format-image',
			//'query_var'            => true,
			'rewrite'              => false,
			'capability_type'      => 'post',
			'has_archive'          => false,
			'hierarchical'         => false,
			'can_export'           => true,
			'query_var'            => false,
			'supports'             => array( 'title', 'page-attributes' ),
			'taxonomies'           => array( 'sponsor_categories' ),
		);

		register_post_type( 'sponsors', $args );
		add_post_type_support( 'sponsors', 'thumbnail' );

	}

	/**
	 * Check Version
	 */
	public function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && version_compare( get_option( 'sponsors_db_version' ),WP_SPONSORS_VERSION, '<' ) ) {
			self::install();
			do_action( 'wp_sponsors_updated' );
		}
	}

	/**
	 * Install WC.
	 */
	public static function install() {
		if ( ! is_blog_installed() ) {
			return;
		}

		// Check if we are not already running this routine.
		if ( 'yes' === get_transient( 'wp_sponsors_installing' ) ) {
			return;
		}

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient( 'wp_sponsors_installing', 'yes', MINUTE_IN_SECONDS * 10 );

		self::maybe_update_db_version();

		delete_transient( 'wp_sponsors_installing' );

		do_action( 'wp_sponsors_installed' );
	}

	/**
	 * Run an update callback when triggered by ActionScheduler.
	 *
	 * @since 3.6.0
	 * @param string $callback Callback name.
	 */
	public static function run_update_callback( $callback ) {
		include_once dirname( __FILE__ ) . '/functions-updates.php';

		if ( is_callable( $callback ) ) {
			$result = (bool) call_user_func( $callback );
		}
	}

	/**
	 * Is a DB update needed?
	 *
	 * @since  3.0.0
	 * @return boolean
	 */
	public static function needs_db_update() {
		$current_db_version = get_option( 'sponsors_db_version', null );
		$updates            = self::get_db_update_callbacks();

		return ! is_null( $current_db_version ) && version_compare( $current_db_version, max( array_keys( $updates ) ), '<' );
	}

	/**
	 * See if we need to show or run database updates during install.
	 *
	 * @since 3.2.0
	 */
	private static function maybe_update_db_version() {
		if ( self::needs_db_update() ) {
			self::update();
		} else {
			self::update_db_version();
		}
	}

	/**
	 * Get list of DB update callbacks.
	 *
	 * @since  3.0.0
	 * @return array
	 */
	public static function get_db_update_callbacks() {
		return self::$db_updates;
	}

	/**
	 * Push all needed DB updates to the queue for processing.
	 */
	private static function update() {
		$current_db_version = get_option( 'sponsors_db_version' );

		foreach ( self::get_db_update_callbacks() as $version => $update_callbacks ) {
			if ( version_compare( $current_db_version, $version, '<' ) ) {
				foreach ( $update_callbacks as $update_callback ) {
					self::run_update_callback( $update_callback );
				}
			}
		}

		self::update_db_version();
	}

	/**
	 * Update DB version to current.
	 *
	 * @param string|null $version New WooCommerce DB version or null.
	 */
	public static function update_db_version( $version = null ) {
		update_option( 'sponsors_db_version', is_null( $version ) ? WP_SPONSORS_VERSION : $version );
	}

}