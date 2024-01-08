<?php

// Display code/markup goes here. Don't forget to include nonces!
// Noncename needed to verify where the data originated
echo '<input type="hidden" name="wp_sponsors_nonce" id="wp_sponsors_nonce" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';
// Get the url data if its already been entered
$meta_value = get_post_meta( get_the_ID(), '_website', true );
if ( ! $meta_value ) {
	$meta_value = get_post_meta( get_the_ID(), 'wp_sponsors_url', true );
}
// Checks and displays the retrieved value
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponsors_url" class="post-attributes-label">' . __( 'Link', 'wp-sponsors' ) . '</label></p>';
echo '<input type="url" name="_website" value="' . esc_attr( $meta_value ) . '" class="widefat" />';


// Get the url data if its already been entered
$meta_value = get_post_meta( get_the_ID(), '_email', true );
// Checks and displays the retrieved value
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponosrs_email" class="post-attributes-label">' . __( 'Email', 'wp-sponsors' ) . '</label></p>';
echo '<input type="email" id="wp_sponosrs_email" name="_email" value="' . esc_attr( $meta_value ) . '" class="widefat" />';


// Display code/markup goes here. Don't forget to include nonces!
// Noncename needed to verify where the data originated
// Get the url data if its already been entered
$meta_value = get_post_meta( get_the_ID(), 'wp_sponsors_desc', true );
$meta_value = apply_filters( 'the_content', $meta_value );
$meta_value = str_replace( ']]>', ']]>', $meta_value );

$meta_value = get_post_meta( get_the_ID(), 'wp_sponsor_link_behaviour', true );
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponsor_link_behaviour" class="post-attributes-label">' . __( 'Link behaviour', 'wp-sponsors' ) . '</label></p>';
$meta_value = $meta_value == "" ? "1" : $meta_value;
echo '<label><input type="checkbox" id="wp_sponsor_link_behaviour" name="wp_sponsor_link_behaviour" value="1" ' . checked( $meta_value, '1', false ) . '>' . __( 'Open link in a new window', 'wp-sponsors' ) . '</label>';
