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
        return $links;
    }
}