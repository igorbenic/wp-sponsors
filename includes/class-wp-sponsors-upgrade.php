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
    public function __construct( $wp_sponsors, $version ) {

        $this->wp_sponsors = $wp_sponsors;
        $this->version = $version;

    }

    public function run() {
        $upgradeFunction = 'upgrade' . str_replace('.', '' , $this->version);
        if(is_callable(array($this, $upgradeFunction))) {
            $this->$upgradeFunction();
        }
            
        return;
    }

}
