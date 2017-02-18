<?php

/**
 * Define the plugin upgrade routine.
 *
 * Check if there is an update available and perform that update when applicable
 *
 * @link       http://example.com
 * @since      2.0
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/includes
 */

/**
 * Define the plugin upgrade routine.
 *
 * Check if there is an update available and perform that update when applicable
 *
 * @since      2.0.0
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/includes
 * @author     Jan Henckens <jan@studioespresso.co>
 */
class Wp_Sponsors_upgrade {


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
    public function __construct( $version ) {
        $this->version = $version;

    }

    public function run( $update ) {
        if(is_callable(array($this, $update))) {
                $this->$update();
        }
        return;
    }

    public function upgrade200() {
        require_once ABSPATH . 'wp-includes/pluggable.php';
        global $wpdb;
        $results = $wpdb->get_results( 'SELECT * FROM' . $wpdb->prefix . '_postmeta WHERE meta_key like "'. $wpdb->prefix .'_sponsors_img"', OBJECT );

        foreach ($results as $key => $sponsor) {
            $data[$sponsor->post_id]['sponsor'] = $sponsor->post_id;
            $image = preg_split('/uploads\//', $sponsor->meta_value, PREG_SPLIT_OFFSET_CAPTURE);

            $query = "SELECT post_id FROM " . $wpdb->prefix . "_postmeta WHERE meta_key = '_wp_attached_file' AND  meta_value = '". $image[1] . "'";
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
        $wpdb->insert($wpdb->prefix . '_options', array( 'option_name' => 'sponsors_db_version', 'option_value' => 2), array( '%s', '%d' ));
        return;
    }

}
