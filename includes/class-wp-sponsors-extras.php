<?php 

class Wp_Sponsors_extras {
    
    public function setup() {
        add_filter( 'plugin_row_meta', array($this, 'custom_plugin_row_meta'), 10, 2 );
    }

    /**
     * Add to links
     *
     * @param array $links
     *
     * @return array
     */
    function custom_plugin_row_meta( $links, $file ) {

        if ( strpos( $file, 'wp-sponsors.php' ) !== false ) {
            $new_links = array(
                    'donate' => '<a href="http://studioespresso.co/donate?utm_source=plugin&amp;utm_medium=dashboard_link&amp;utm_campaign=wp-sponsors
                    " target="_blank" style="color: brown; font-weight: bold;">Donate</a>',
                    'support' => '<a href="https://wordpress.org/support/plugin/wp-sponsors" target="_blank" style="color: green; font-weight: bold;">Support</a>'
                    );
            $links = array_merge( $links, $new_links );
        }
        
        return $links;
    }
}