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
class WP_Sponsors_Admin {

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

		wp_enqueue_style( $this->wp_sponsors, WP_SPONSORS_URL . 'assets/dist/css/admin.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->wp_sponsors, WP_SPONSORS_URL . 'assets/dist/js/admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->wp_sponsors, 'objectL10n', array(
			'title' => __('Select a sponsor logo', 'wp-sponsors'),
			'button' => __('Add image', 'wp-sponsors')
			));

	}

	/**
	 * Save Metaboxes.
	 *
	 * @param $post_id
	 * @param \WP_Post $post Post object
	 */
	public function save_meta_boxes( $post_id, $post ) {
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times

		// Checks save status
		$is_autosave    = wp_is_post_autosave( $post_id );
		$is_revision    = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST['wp_sponsors_nonce'] ) && wp_verify_nonce( $_POST['wp_sponsors_nonce'], basename( __FILE__ ) ) ) ? 'true' : 'false';
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		if ( 'sponsors' !== get_post_type( $post ) ) {
			return;
		}


		// Checks for input and sanitizes/saves if needed
		if ( isset( $_POST['_website'] ) ) {
			update_post_meta( $post_id, '_website', sanitize_text_field( $_POST['_website'] ) );
		}

		if ( isset( $_POST['_email'] ) ) {
			update_post_meta( $post_id, '_email', sanitize_text_field( $_POST['_email'] ) );
		}

		if ( isset( $_POST['wp_sponsors_desc'] ) ) {
			update_post_meta( $post_id, 'wp_sponsors_desc', $_POST['wp_sponsors_desc'] );
		}

		if ( isset( $_POST['_data_content'] ) ) {
			update_post_meta( $post_id, '_data_content', $_POST['_data_content'] );
		}

		$link_behaviour = isset($_POST['wp_sponsor_link_behaviour']) ? '1' : '0';
		update_post_meta( $post_id, 'wp_sponsor_link_behaviour', $link_behaviour );
	}

	/**
	 * Sponsors metaboxes
	 */
	public function add_meta_boxes() {
		add_meta_box( 'wp-sponsor-info', __( 'Sponsor', 'wp_sponsors' ), array( $this, 'sponsors_info_metabox' ), 'sponsors', 'normal', 'high' );
		remove_meta_box( 'postimagediv', 'sponsors', 'side' ); //replace post_type from your post type name
		add_meta_box( 'postimagediv', __( 'Sponsor logo', 'wp-sponsors' ), 'post_thumbnail_meta_box', 'sponsors', 'side', 'high' );
		if ( ! class_exists('\Simple_Sponsorships\Plugin' ) ) {
			add_meta_box( 'ss-metabox-info', __( 'Simple Sponsorships', 'wp-sponsors' ), array( $this, 'ss_info_metabox' ), 'sponsors', 'side', 'low' );
		}
	}

	public function sponsors_info_metabox( $post ) {
		include_once 'partials/meta-boxes/sponsor-info.php';
	}

	public function ss_info_metabox() {
		include_once 'partials/meta-boxes/ss-info.php';
	}


	/**
	 * Adds a new column to the Sponsors overview list in the dashboard
	 *
	 * @param array $defaults
	 */
	public function add_new_sponsors_column( $defaults ) {
		$defaults['wp_sponsors_logo'] = __( 'Sponsor logo', 'wp-sponsors' );
		$defaults['menu_order']       = __( 'Order', 'wp-sponsors' );

		return $defaults;
	}

	/**
	 * Adds the sponsors image (if available) to the Sponsors overview list in the dashboard
	 *
	 * @param string $column_name
	 * @param integer $post_id
	 */
	public function sponsors_custom_columns( $column_name, $post_id ) {
		global $post;

		switch ( $column_name ) {
			case 'wp_sponsors_logo':
				echo get_the_post_thumbnail( $post_id, array( 0, 50 ) );
				break;
			case 'menu_order':
				$order = $post->menu_order;
				echo $order;
				break;
			default:
				break;
		}
	}

	/**
	 * Order Column
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function sponsor_order_column( $columns ) {
		$columns['menu_order'] = 'menu_order';

		return $columns;
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

	/**
	 * Register Menus
	 */
    public function register_menus() {
	    add_submenu_page(
	    	'edit.php?post_type=sponsors',
		    __( 'Sponsors - Documentation', 'wp-sponsors'),
		    __( 'Documentation', 'wp-sponsors'),
		    'manage_options',
		    'wp-sponsors-docs',
		    array( $this, 'documentation' )
	    );
    }

	/**
	 * Documentation Page
	 */
    public function documentation() {
		include_once 'partials/documentation.php';
    }

}
