<?php

// Display code/markup goes here. Don't forget to include nonces!
// Noncename needed to verify where the data originated
echo '<input type="hidden" name="wp_sponsors_nonce" id="wp_sponsors_nonce" value="' . wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';
// Get the url data if its already been entered
$meta_value = get_post_meta( get_the_ID(), '_website', true );
if ( ! $meta_value ) {
	$meta_value = get_post_meta( get_the_ID(), 'wp_sponsors_url', true );
}
// Checks and displays the retrieved value
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponsors_url" class="post-attributes-label">' . __( 'Link', 'wp-sponsors' ) . '</label></p>';
echo '<input type="url" name="_website" value="' . $meta_value . '" class="widefat" />';


// Get the url data if its already been entered
$meta_value = get_post_meta( get_the_ID(), '_email', true );
// Checks and displays the retrieved value
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponosrs_email" class="post-attributes-label">' . __( 'Email', 'wp-sponsors' ) . '</label></p>';
echo '<input type="email" id="wp_sponosrs_email" name="_email" value="' . $meta_value . '" class="widefat" />';


// Display code/markup goes here. Don't forget to include nonces!
// Noncename needed to verify where the data originated
// Get the url data if its already been entered
$meta_value = get_post_meta( get_the_ID(), 'wp_sponsors_desc', true );
$meta_value = apply_filters( 'the_content', $meta_value );
$meta_value = str_replace( ']]>', ']]>', $meta_value );
// Checks and displays the retrieved value
$editor_settings = array( 'wpautop'       => true,
                          'media_buttons' => false,
                          'textarea_rows' => '8',
                          'textarea_name' => 'wp_sponsors_desc'
);
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponsors_desc" class="post-attributes-label">' . __( 'Description', 'wp-sponsors' ) . '</label></p>';
echo '<p><strong>Description field will be deleted in 3.1.0. Please move all the content in the default content area above (if it did not move automatically).</strong></p>';
echo wp_editor( $meta_value, 'wp_sponsors_desc', $editor_settings );

$meta_value = get_post_meta( get_the_ID(), 'wp_sponsor_link_behaviour', true );
echo '<p class="post-attributes-label-wrapper"><label for="wp_sponsor_link_behaviour" class="post-attributes-label">' . __( 'Link behaviour', 'wp-sponsors' ) . '</label></p>';
$meta_value = $meta_value == "" ? "1" : $meta_value;
echo '<label><input type="checkbox" id="wp_sponsor_link_behaviour" name="wp_sponsor_link_behaviour" value="1" ' . checked( $meta_value, '1', false ) . '>' . __( 'Open link in a new window', 'wp-sponsors' ) . '</label>';
