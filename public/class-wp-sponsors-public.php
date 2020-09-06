<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/public
 * @author     Jan Henckens <jan@studioespresso.co>
 */
class WP_Sponsors_Public {

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
	 * Form Errors
	 *
	 * @var array
	 */
	public $form_errors = array();


	/**
	 * Form Notices
	 *
	 * @var array
	 */
	public $form_notices = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $wp_sponsors       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_sponsors, $version ) {

		$this->wp_sponsors = $wp_sponsors;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Sponsors_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Sponsors_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wp_sponsors, WP_SPONSORS_URL . 'assets/dist/css/public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Sponsors_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Sponsors_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wp_sponsors, WP_SPONSORS_URL . 'assets/dist/js/public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Show Errors and notices on the Submission form.
	 */
	public function show_errors_and_notices() {
		if ( $this->form_errors ) {
			foreach ( $this->form_errors as $error ) {
				echo '<div class="wp-sponsors-form-notice wp-sponsors-form-error">' . $error . '</div>';
			}
		}

		if ( $this->form_notices ) {
			foreach ( $this->form_notices as $notice ) {
				echo '<div class="wp-sponsors-form-notice">' . $notice . '</div>';
			}
		}
	}

	/**
	 * Form Submission for Sponsors.
	 */
	public function sponsors_acquisition_form_submit() {
		if ( ! isset( $_POST['sponsors_acquisition_form_nonce'] ) ) {
			return;
		}

		if ( ! $_POST['sponsors_acquisition_form_nonce'] || ! wp_verify_nonce( $_POST['sponsors_acquisition_form_nonce'], 'sponsors_acquisition_form' ) ) {
			return;
		}

		$posted_data = isset( $_POST['wp_sponsors_form'] ) ? $_POST['wp_sponsors_form'] : array();

		if ( ! $posted_data ) {
			return;
		}

		$name = isset( $posted_data['name'] ) ? $posted_data['name'] : '';

		if ( ! $name ) {
			$this->form_errors[] = __( 'Sponsor Name is required', 'wp-sponsors' );
		}

		$email = isset( $posted_data['email'] ) ? $posted_data['email'] : '';

		if ( ! $email ) {
			$this->form_errors[] = __( 'Sponsor Email is required', 'wp-sponsors' );
		}

		$desc  = isset( $posted_data['desc'] ) ? $posted_data['desc'] : '';
		$url   = isset( $posted_data['website'] ) ? $posted_data['website'] : '';

		do_action( 'sponsors_acquisition_form_before_submit', $this, $posted_data );

		if ( ! $this->form_errors ) {
			$post = wp_insert_post(
				array(
					'post_title'   => $name,
					'post_content' => $desc,
					'post_type'    => 'sponsors'
				),
				true
			);

			if ( ! is_wp_error( $post ) ) {
				$this->form_notices[] = __( 'Sponsor Information submitted.', 'wp-sponsors' );
				update_post_meta( $post, '_website', $url );
				update_post_meta( $post, '_email', $email );
				do_action( 'sponsors_acquisition_form_submitted', $post );
			}
		}

		add_action( 'wp_sponsors_acquisition_form_fields_before', array( $this, 'show_errors_and_notices' ) );
	}

	/**
	 * Send the Form Email
	 *
	 * @param integer $sponsor_id Sponsor ID
	 */
	public function send_acquisition_form_email( $sponsor_id ) {
		$sponsor = get_post( $sponsor_id );

		$sponsor_link = admin_url( 'post.php?post=' . $sponsor_id . '&action=edit');
		$subject = sprintf( __( 'New Sponsor Submitted: %s', 'wp-sponsors' ), $sponsor->post_title );
		$message = __( 'Hi, there was a new sponsor submission on your site!', 'wp-sponsors' );
		$message .= sprintf( __( 'You can check it out here: %s', 'wp-sponsors' ), '<a href="' . esc_url( $sponsor_link ) . '">' . $sponsor_link . '</a>' );
		$to = get_option( 'admin_email' );

		wp_mail( $to, $subject, $message );
	}
}
