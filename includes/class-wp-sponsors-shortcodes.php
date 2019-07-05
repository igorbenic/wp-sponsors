<?php

class WP_Sponsors_Shortcodes {

	/**
	 * Register Shortcodes.
	 */
	public function register_shortcodes() {
		add_shortcode( 'sponsors', array( __CLASS__, 'sponsors_shortcode' ) );
	}

	/**
	 * Shortcode for showing sponsors
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function sponsors_shortcode( $atts = array() ) {

		$atts = shortcode_atts( array (
			'type' => 'post',
			'image' => 'yes',
			'images' => 'yes',
			'category' => '',
			'size' => 'default',
			'image_size' => 'medium',
			'style' => 'list',
			'description' => 'no',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'title' => 'no',
			'max' => '-1',
			'debug' => NULL
		), $atts, 'wp_sponsors' );

		$args = array (
			'post_type'      => array( 'sponsors', 'sponsor' ), // Allowing 'sponsor' in case the update does not work.
			'post_status'    => 'publish',
			'pagination'     => false,
			'order'          => $atts['order'],
			'orderby'        => isset( $atts['orderby'] ) ? $atts['orderby'] : 'menu_order',
			'posts_per_page' => isset( $atts['max'] ) ? $atts['max'] : '-1',
			'tax_query'      => array(),
		);

		$nofollow = ( defined( 'SPONSORS_NO_FOLLOW' ) ) ? SPONSORS_NO_FOLLOW : true;

		if( $atts['category'] ) {
			$atts['category'] = explode( ',', $atts['category'] );
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'sponsor_categories',
					'field'     => 'slug',
					'terms'     => $atts['category'],
				),
			);
		}

		$images      = 'no' !== $atts['images'] && 'no' !== $atts['image'] ? true : false;
		$debug       = $atts['debug'] ? true : false;
		$description = 'yes' === $atts['description'] ? true : false;
		$title       = 'yes' === $atts['title'] ? true : false;
		// $sizes = array('small' => '15%', 'medium' => '30%', 'large' => '50%', 'full' => '100%', 'default' => '30%');
		ob_start();

		$query = new WP_Query( $args );

		// Set up the shortcode styles
		$style = array();
		$layout = $atts['style'];

		switch ( $layout ) {
			case "list":
				$style['containerPre'] = '<div id="wp-sponsors"><ul>';
				$style['containerPost'] = '</ul></div>';
				$style['wrapperClass'] = 'sponsor-item';
				$style['wrapperPre'] = 'li';
				$style['wrapperPost'] = '</li>';
				break;
			case "linear":
			case "grid":
				$style['containerPre'] = '<div id="wp-sponsors" class="clearfix grid">';
				$style['containerPost'] = '</div>';
				$style['wrapperClass'] = 'sponsor-item';
				$style['wrapperPre'] = 'div';
				$style['wrapperPost'] = '</div>';
				$style['imageSize'] = 'full';
				break;
		}

		if ( $query->have_posts() ) {
			echo $style['containerPre'];
			while ( $query->have_posts() ) : $query->the_post();

				$sponsor_id  = get_the_ID();
				$link        = get_post_meta( $sponsor_id, 'wp_sponsors_url', true );
				$link_target = get_post_meta( $sponsor_id, 'wp_sponsor_link_behaviour', true );
				$target      = 1 === absint( $link_target ) ? 'target="_blank"' : '';
				$class       = '';
				$class      .= $atts['size'];
				$image       = false;

				if( $debug ) {
					$class .= ' debug';
				}

				echo '<' . $style['wrapperPre'] . ' class="' . $style['wrapperClass'] .' ' . $class . '">';
				$sponsor = '';

				// Check if we have a link
				if( $link && ! $images && $title ) {
					$sponsor .= '<a href=' . esc_attr( $link ) . ' ' . $target . '>';
					$sponsor .= '<h3>' . get_the_title() . '</h3>';
					$sponsor .= '</a>';
				}

				if ( $images ) {
					// Check if we should do images, just show the title if there's no image set
					$image = get_the_post_thumbnail( $sponsor_id, $atts['image_size'] );

					// We did not want title, but we don't have an image. Show the title then.
					if ( ! $image && ! $title ) {
						$image = '<h3>' . get_the_title() . '</h3>';
					}

					if ( $image ) {
						// Check if we have a link
						if( $link ) {
							$sponsor .= '<a href=' . esc_attr( $link ) . ' ' .$target. '>';
						}

						$sponsor .= $image;

						// Close the link tag if we have it
						if( $link ) {
							$sponsor .= '</a>';
						}
					}
				}

				// Check if we need a description and the description is not empty
				if( $description ) {
					$desc = do_shortcode( wpautop( get_the_content( get_the_ID() ) ) );
					if ( ! $desc ) {
						$desc = get_post_meta( get_the_ID(), 'wp_sponsors_desc', true );
					}
					if ( $desc ) {
						$sponsor .= '<p>' . $desc . '</p> ';
					}
				}

				echo $sponsor;
				echo $style['wrapperPost'];

			endwhile;
			echo $style['containerPost'];
			wp_reset_postdata();
			return ob_get_clean();
		}
	}
}
