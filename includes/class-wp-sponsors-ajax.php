<?php

class WP_Sponsors_AJAX {

	/**
	 * Get Categories
	 */
	public function get_categories() {
		$terms = get_terms( array(
			'taxonomy' => 'sponsor_categories',
		) );

		wp_send_json_success( $terms );
	}
}