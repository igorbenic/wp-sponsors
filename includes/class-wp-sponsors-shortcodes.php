<?php

class WP_Sponsors_Shortcodes {

	/**
	 * Register Shortcodes.
	 */
	public function register_shortcodes() {
		add_shortcode( 'sponsors', array( __CLASS__, 'sponsors_shortcode' ) );
		add_shortcode( 'sponsors_acquisition_form', array( __CLASS__, 'sponsors_form' ) );
	}

	/**
	 * Sponsor Form
     *
	 * @return string
	 */
	public static function sponsors_form( $atts = array() ) {
		$atts = shortcode_atts( array (
			'fields' => '',
			'fields_labels' => '',
			'button' => __( 'Submit', 'wp-sponsors' ),
		), $atts, 'wp_sponsors_form' );


		ob_start();
		?>
		<form method="POST" class="wp-sponsors-form" enctype="multipart/form-data">

			<?php
				do_action( 'wp_sponsors_acquisition_form_fields_before' );
				wp_nonce_field( 'sponsors_acquisition_form', 'sponsors_acquisition_form_nonce' );
			?>
			<div class="wp-sponsors-form-field">
				<label for="wp_sponsors_name"><?php esc_html_e( 'Sponsor Name', 'wp-sponsors' ); ?></label>
				<input id="wp_sponsors_name" required="required" type="text" name="wp_sponsors_form[name]" placeholder="<?php esc_attr_e( 'Sponsor Name', 'wp-sponsors' ); ?>">
			</div>

			<div class="wp-sponsors-form-field">
				<label for="wp_sponsors_email"><?php esc_html_e( 'Sponsor Email', 'wp-sponsors' ); ?></label>
				<input id="wp_sponsors_email" required="required" type="email" name="wp_sponsors_form[email]" placeholder="<?php esc_attr_e( 'Sponsor Email', 'wp-sponsors' ); ?>">
			</div>

			<div class="wp-sponsors-form-field">
				<label for="wp_sponsors_website"><?php esc_html_e( 'Sponsor Website', 'wp-sponsors' ); ?></label>
				<input id="wp_sponsors_website" type="text" name="wp_sponsors_form[website]" placeholder="<?php esc_attr_e( 'Website', 'wp-sponsors' ); ?>">
			</div>

			<div class="wp-sponsors-form-field">
				<label for="wp_sponsors_desc"><?php esc_html_e( 'Sponsor Description', 'wp-sponsors' ); ?></label>
				<textarea id="wp_sponsors_desc" name="wp_sponsors_form[desc]" placeholder="<?php esc_attr_e( 'Description', 'wp-sponsors' ); ?>"></textarea>
			</div>

			<?php
				if ( $atts['fields'] ) {
					$fields = explode( ',', $atts['fields'] );
					$labels = explode( ',', $atts['fields_labels'] );

					foreach ( $fields as $index => $field ) {
						$label = isset( $labels[ $index ] ) ? $labels[ $index ] : ucfirst( $field );
						?>
						<div class="wp-sponsors-form-field">
							<label for="wp_sponsors_<?php echo $field; ?>"><?php echo esc_html( $label ); ?></label>
							<textarea id="wp_sponsors_<?php echo $field; ?>" name="wp_sponsors_form[<?php echo $field; ?>]" placeholder="<?php echo esc_attr( $label ); ?>"></textarea>
						</div>

						<?php
					}
				}

				do_action( 'wp_sponsors_acquisition_form_fields' );
			?>

			<button type="submit" class="button wp-sponsors-button" name="sponsors_acquisition_form"><?php echo $atts['button']; ?></button>
		</form>
		<?php

		return ob_get_clean();
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
			'with_categories' => 'no',
			'category_title' => 'h3',
			'size' => 'default',
			'image_size' => 'medium',
			'slider_image' => 'full',
			'style' => 'list',
			'description' => 'no',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'title' => 'no',
			'max' => '-1',
			'adaptiveheight' => '1',
			'autoplay' => '1',
			'autoplayspeed' => '3000',
			'arrows' => '1',
			'centermode' => '0',
			'dots' => '0',
			'infinite' => '1',
			'slidestoshow' => '1',
			'slidestoscroll' => '1',
			'variablewidth' => '0',
			'verticalcenter' => '1',
			'breakpoints' => '',
			'debug' => NULL
		), $atts, 'wp_sponsors' );

		$args = array (
			'post_type'      => array( 'sponsors', 'sponsor' ), // Allowing 'sponsor' in case the update does not work.
			'post_status'    => 'publish',
			'pagination'     => false,
			'no_found_rows'  => true,
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

		$images        = 'no' !== $atts['images'] && 'no' !== $atts['image'] ? true : false;
		$debug         = $atts['debug'] ? true : false;
		$description   = 'yes' === $atts['description'] ? true : false;
		$title         = 'yes' === $atts['title'] ? true : false;
		$sponsor_posts = get_posts( $args );
		$sponsors      = array();
		$categories    = array();
		$slickSettings = array();

		foreach ( $sponsor_posts as $sponsor_post ) {
			$link = get_post_meta( $sponsor_post->ID, '_website', true );

			if ( ! $link ) {
				$link = get_post_meta( $sponsor_post->ID, 'wp_sponsors_url', true );
			}

			$sponsor                = array();
			$sponsor['id']          = $sponsor_post->ID;
			$sponsor['link']        = $link;
			$sponsor['link_target'] = get_post_meta( $sponsor_post->ID, 'wp_sponsor_link_behaviour', true );
			$sponsor['logo']        = get_the_post_thumbnail( $sponsor_post->ID, $atts['image_size'] );
			$sponsor['title']       = get_the_title( $sponsor_post );
			$sponsor['categories']  = get_the_terms( $sponsor_post, 'sponsor_categories');
			$desc = do_shortcode( wpautop( $sponsor_post->post_content ) );
			if ( ! $desc ) {
				$desc = get_post_meta( $sponsor_post->ID, 'wp_sponsors_desc', true );
			}


			$sponsor['desc'] = $desc;
			$sponsors[] = $sponsor;
		}

		if( 'yes' === $atts['with_categories'] ) {
			foreach( $sponsors as $sponsor ) {
				if ( $sponsor['categories'] ) {
					foreach ( $sponsor['categories'] as $term ) {
						if ( ! isset( $categories[ $term->term_id ] ) ) {
							$categories[ $term->term_id ] = array(
								'title' => $term->name,
								'slug'  => $term->slug,
								'sponsors' => array()
							);
						}
						$categories[ $term->term_id ]['sponsors'][] = $sponsor;
					}
				}
			}
		} else {
			// Get all under one category so we can iterate through them.
			$categories[0] = array( 'title' => '', 'slug' => '',  'sponsors' => $sponsors );
		}



		ob_start();

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
				break;
			case "slider":
				$slickSettings['adaptiveHeight'] = $atts['adaptiveheight'] === '1' ? true : false;
				$slickSettings['autoplay']       = $atts['autoplay'] === '1' ? true : false;
				$slickSettings['autoplaySpeed']  = $atts['autoplayspeed'];
				$slickSettings['arrows']         = $atts['arrows'] === '1' ? true : false;
				$slickSettings['centerMode']     = $atts['centermode'] === '1' ? true : false;
				$slickSettings['dots']           = $atts['dots'] === '1' ? true : false;
				$slickSettings['infinite']       = $atts['infinite'] === '1' ? true : false;
				$slickSettings['slidesToShow']   = absint( $atts['slidestoshow'] );
				$slickSettings['slidesToScroll'] = absint( $atts['slidestoscroll'] );
				$slickSettings['variablewidth']  = $atts['variablewidth'] === '1' ? true : false;

				if ( $atts['breakpoints'] ) {
				    $breakpoints                 = explode( '|', $atts['breakpoints'] );
					$slickSettings['responsive'] = array();

					foreach ( $breakpoints as $breakpoint ) {
					    $breakpoint_config = explode( ';', $breakpoint );
					    if ( count( $breakpoint_config ) > 2 ) {
						    $slickSettings['responsive'][] = array(
                                'breakpoint' => absint( $breakpoint_config[0] ),
                                'settings'   => array(
                                    'slidesToShow' => absint( $breakpoint_config[1] ),
                                    'slidesToScroll' => absint( $breakpoint_config[2] ),
                                )
                            );
                        }
                    }
                }
				/*$slickSettings['responsive'] = array(
                    array(
                        'breakpoint' => 600,
                        'settings'   => array(
                            'slidesToShow' => 2,
                            'slidesToScroll' => 2,
                        )
                    ),
					array(
						'breakpoint' => 480,
						'settings'   => array(
							'slidesToShow' => 1,
							'slidesToScroll' => 1,
						)
					),
                );*/
				$style['containerPre'] = '<div id="wp-sponsors" class="clearfix slider wp-sponsors ' . esc_attr( $atts['slider_image'] ) . ' ' . ( 1 === absint( $atts['verticalcenter'] ) ? 'vertical-center' : '' ) . '" data-slick="' . esc_attr( wp_json_encode( $slickSettings ) ) . '">';
				$style['containerPost'] = '</div>';
				$style['wrapperClass'] = 'sponsor-item';
				$style['wrapperPre'] = 'div';
				$style['wrapperPost'] = '</div>';
				break;
		}

		if ( $sponsors ) {
			foreach ( $categories as $category ) {

				if ( isset( $category['title'] ) && $category['title'] ) {
					echo '<' . $atts['category_title'] . '>' . $category['title'] . '</' . $atts['category_title'] . '>';
				}
				
				$_sponsors = $category['sponsors'];
				echo $style['containerPre'];
				foreach ( $_sponsors as $sponsor ) {

					$link        = $sponsor['link'];
					$link_target = $sponsor['link_target'];
					$target      = 1 === absint( $link_target ) ? 'target="_blank"' : '';
					$class       = '';
					$class       .= $atts['size'];

					if ( $sponsor['categories'] ) {
					    $class .= ' ' . implode( ' ', wp_list_pluck( $sponsor['categories'], 'slug' ) );
                    }


					if ( $debug ) {
						$class .= ' debug';
					}

					echo '<' . $style['wrapperPre'] . ' class="' . esc_attr( $style['wrapperClass'] ) . ' ' . esc_attr( $class ) . '">';
					$sponsor_html = '';

					if ( $title ) {
						// Check if we have a link
						if ( $link ) {
							$sponsor_html .= '<a href=' . esc_attr( $link ) . ' ' . $target . ' ' . ( $nofollow ? 'rel="nofollow"' : '' ) . '>';
						}

						$sponsor_html .= '<h3>' . $sponsor['title'] . '</h3>';
						if ( $link ) {
							$sponsor_html .= '</a>';
						}
					}

					if ( $images ) {
						// Check if we should do images, just show the title if there's no image set
						$image = $sponsor['logo'];

						// We did not want title, but we don't have an image. Show the title then.
						if ( ! $image && ! $title ) {
							$image = '<h3>' . $sponsor['title'] . '</h3>';
						}

						if ( $image ) {
							// Check if we have a link
							if ( $link ) {
								$sponsor_html .= '<a href=' . esc_attr( $link ) . ' ' . $target . ' ' . ( $nofollow ? 'rel="nofollow"' : '' ) . '>';
							}

							$sponsor_html .= $image;

							// Close the link tag if we have it
							if ( $link ) {
								$sponsor_html .= '</a>';
							}
						}
					}

					// Check if we need a description and the description is not empty
					if ( $description ) {
						$desc = $sponsor['desc'];
						if ( $desc ) {
							$sponsor_html .= $desc;
						}
					}

					echo $sponsor_html;
					echo $style['wrapperPost'];

				}
				echo $style['containerPost'];
			}
			return ob_get_clean();
		}
	}
}
