<?php
/**
 * The blocks class. Handles registering blocks.
 */

/**
 * Class Blocks
 *
 * @package Simple_Sponsorships
 */
class WP_Sponsors_Blocks {

	/**
	 * Blocks constructor.
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue' ), 20 );
		add_filter( 'block_categories', array( $this, 'add_block_category' ), 10 );
		add_action( 'init', array( $this, 'register_blocks' ) );
	}

	/**
	 * Returning Sponsors for the Block.
	 *
	 * @param array $args Array of arguments.
	 * @return string
	 */
	public function get_sponsors( $args ) {
		$args['description']     = '0' === $args['description'] ? 'no' : 'yes';
		$args['images']          = '0' === $args['images'] ? 'no' : 'yes';
		$args['image']           = '0' === $args['images'] ? 'no' : 'yes';
		$args['with_categories'] = '0' === $args['with_categories'] ? 'no' : 'yes';
		$args['title']           = '0' === $args['title'] ? 'no' : 'yes';
		$args['max']             = '0' === $args['max'] ? '-1' : $args['max'];
		$block = WP_Sponsors_Shortcodes::sponsors_shortcode( $args );

		if ( ! $block ) {
			$block = __( 'There were no sponsors found.', 'wp-sponsors' );
		}

		return $block;
	}

	/**
	 * Return the Package HTML.
	 *
	 * @param array $args Array of arguments.
	 * @return string
	 */
	public function get_form_sponsor( $args ) {
		$block = WP_Sponsors_Shortcodes::sponsors_form( $args );

		return $block;
	}

	/**
	 * Registering the dynamic blocks.
	 */
	public function register_blocks() {

		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type( 'wp-sponsors/sponsors', [
			'render_callback' => array( $this, 'get_sponsors' ),
			'attributes'      => [
				'category_title'  => [
					'type'    => 'string',
					'default' => 'h3',
				],
				'size' => [
					'type' => 'string',
					'default' => 'default',
				],
				'image_size' => [
					'type' => 'string',
					'default' => 'medium',
				],
				'images' => [
					'type' => 'string',
					'default' => '1',
				],
				'style' => [
					'type' => 'string',
					'default' => 'list',
				],
				'with_categories' => [
					'type' => 'string',
					'default' => '0',
				],
				'category' => [
					'type' => 'string',
					'default' => '0'
				],
				'description' => [
					'type' => 'string',
					'default' => '0',
				],
				'title' => [
					'type' => 'string',
					'default' => '0',
				],
				'max' => [
					'type' => 'string',
					'default' => '-1',
				],
				'adaptiveheight' => [
					'type' => 'string',
					'default' => '1'
				],
				'autoplay' => [
					'type' => 'string',
					'default' => '1',
				],
				'autoplayspeed' => [
					'type' => 'string',
					'default' => '3000',
				],
				'arrows' => [
					'type' => 'string',
					'default' => '1',
				],
				'centermode' => [
					'type' => 'string',
					'default' => '0',
				],
				'dots' => [
					'type' => 'string',
					'default' => '0',
				],
				'infinite' => [
					'type' => 'string',
					'default' => '1',
				],
				'slidestoshow' => [
					'type' => 'string',
					'default' => '1',
				],
				'slidestoscroll' => [
					'type' => 'string',
					'default' => '1',
				],
				'verticalcenter' => [
					'type' => 'string',
					'default' => '1',
				],
				'slider_image' => [
					'type' => 'string',
					'default' => 'full',
				],
			]
		] );

		/*register_block_type( 'wp-sponsors/form-sponsor', [
			'render_callback' => array( $this, 'get_form_sponsor' ),
			'attributes'      => [
				'packages' => [
					'default' => '',
					'type'    => 'string'
				],
			]
		] );*/
	}

	/**
	 * Adding Simple Sponsorships category.
	 *
	 * @param array $categories Array of categories.
	 *
	 * @return array
	 */
	public function add_block_category( $categories ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'wp-sponsors',
					'title' => __( 'Sponsors', 'wp-sponsors' ),
				),
			)
		);
	}

	/**
	 * Enqueue Editor Assets for Blocks.
	 */
	public function enqueue() {

		if ( ! wp_script_is( 'wp-sponsors-block-js', 'registered' ) ) {
			wp_register_script(
				'wp-sponsors-block-js',
				WP_SPONSORS_URL . '/assets/dist/js/gutenberg.js',
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor', 'wp-compose' ),
				filemtime( WP_SPONSORS_PATH . '/assets/dist/js/gutenberg.js', )
			);
		}

		$images_sizes   = array_keys( WP_Sponsors_Extras::get_image_sizes() );
		$images_sizes[] = 'full';

		wp_enqueue_script( 'wp-sponsors-block-js' );
		wp_localize_script( 'wp-sponsors-block-js', 'wp_sponsors_blocks', array(
			'nonce'         => wp_create_nonce( 'wp-sponsors-admin-nonce' ),
			'ajax'          => admin_url( 'admin-ajax.php' ),
			'image_sizes'   => $images_sizes,
		));

		// Styles.
		wp_enqueue_style(
			'wp-sponsors-block-css',
			WP_SPONSORS_URL . '/assets/dist/css/gutenberg.css',
			array( 'wp-edit-blocks' ),
			filemtime( WP_SPONSORS_PATH . '/assets/dist/css/gutenberg.css', )
		);
	}
}