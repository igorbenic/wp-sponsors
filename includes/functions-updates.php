<?php
/**
 * Functions to run updates
 */

/**
 * Sponsors Updates for 2.0.0 and above.
 */
function wp_sponsors_update_200() {
	require_once ABSPATH . 'wp-includes/pluggable.php';
	global $wpdb;
	$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key like "'. $wpdb->prefix .'_sponsors_img"', OBJECT );

	foreach ($results as $key => $sponsor) {
		$data[$sponsor->post_id]['sponsor'] = $sponsor->post_id;
		$image = preg_split('/uploads\//', $sponsor->meta_value, PREG_SPLIT_OFFSET_CAPTURE);

		$query = "SELECT post_id FROM " . $wpdb->prefix . "postmeta WHERE meta_key = '_wp_attached_file' AND  meta_value = '". $image[1] . "'";
		$imageId = $wpdb->get_row($query, OBJECT);
		$data[$sponsor->post_id]['current_image'] = $image[1];
		$data[$sponsor->post_id]['featured_image'] = $imageId->post_id;
	}
	if(isset($data)) {
		foreach($data as $key => $entry) {
			$wpdb->insert($wpdb->prefix . '_postmeta',
				array(
					'post_id' => $key,
					'meta_key' => '_thumbnail_id',
					'meta_value' => $entry['featured_image']
				),
				array( '%d', '%s', '%s' )
			);
		}
	}
	$wpdb->insert($wpdb->prefix . 'options', array( 'option_name' => 'sponsors_db_version', 'option_value' => 2), array( '%s', '%d' ));
	return;
}

/**
 * Update post type to 'sponsors' to be compatible with Simple Sponsorships.
 */
function wp_sponsors_update_post_type_300() {
	global $wpdb;

	$wpdb->update( $wpdb->posts, array( 'post_type' => 'sponsors' ), array( 'post_type' => 'sponsor' ) );

	$descriptions = $wpdb->get_results( $wpdb->prepare( 'SELECT post_id, meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key=%s', 'wp_sponsors_desc' ), ARRAY_A );
	if ( $descriptions ) {
		foreach ( $descriptions as $description ) {
			$text    = $description['meta_value'];
			$post_id = $description['post_id'];
			$ret     = $wpdb->update( $wpdb->posts, array( 'post_content' => $text ), array( 'ID' => $post_id ) );
			if ( false !== $ret ) {
				delete_post_meta( $post_id, 'wp_sponsors_desc' );
			}
		}
	}
}