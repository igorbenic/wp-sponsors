<?php

/**
 * Contains classes and methods that should be refactored later but can't be right now
 *
 * @package    Wp_Sponsors
 * @subpackage Wp_Sponsors/includes
 * @author     Jan Henckens <jan@studioespresso.co>
 */
class Wp_Sponsors_Shame {

    public function getImage($post_ID) {
        $post_thumbnail = get_the_post_thumbnail( $post_ID, 'medium' );
        $post_custom_image = get_post_meta( $post_ID, 'wp_sponsors_img', true );

        if ($post_thumbnail && !empty($post_thumbnail)) {
            return $post_thumbnail;
        } elseif (isset($post_custom_image)) {
            return '<img src="' . $post_custom_image . '" height="80px"/>';
        }
    }
    
}
    