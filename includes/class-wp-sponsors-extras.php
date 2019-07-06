<?php 

class WP_Sponsors_Extras {

	/**
	* Get size information for all currently-registered image sizes.
	*
	* @global $_wp_additional_image_sizes
	* @uses   get_intermediate_image_sizes()
	* @return array $sizes Data for all currently-registered image sizes.
	*/
	static function get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}
    
    public function setup() {
        add_filter( 'plugin_row_meta', array( $this, 'add_row_meta' ), 10, 2 );
    }

    /**
     * Add to links
     *
     * @param array $links
     *
     * @return array
     */
    function add_row_meta( $links, $file ) {
    	if ( 'wp-sponsors/wp-sponsors.php' === $file ) {
    		$links['simple-sponsorships'] = '<a target="_blank" href="https://wordpress.org/plugins/simple-sponsorships/">' . __( 'Try Simple Sponsorships', 'wp-sponsors' ) . '</a>';
	    }
        return $links;
    }
}