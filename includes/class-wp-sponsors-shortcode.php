<?php

    /**
     * Adds sponsors shortcode option
     */
    function sponsors_register_shortcode($atts) {


        // define attributes and their defaults
        extract( shortcode_atts( array (
            'type' => 'post',
            'image' => 'yes',
            'category' => '',
            'size' => 'default',
            'style' => 'list',
            'description' => 'no'
        ), $atts ) );

        $args = array (
            'post_type'             => 'sponsor',
            'post_status'           => 'publish',
            'pagination'            => false,
            'order'                 => 'ASC',
            'orderby'               => 'menu_order',
            'posts_per_page'        => '-1',
            'tax_query'             => array(),
        );

        $nofollow = true;
        if(false === SPONSORS_NO_FOLLOW) {
            $nofollow = false;
        }

        if(!empty($category)) {
          $args['tax_query'] = array(
            array(
              'taxonomy'  => 'sponsor_categories',
              'field'     => 'slug',
              'terms'     => $category,
            ),
          );
        }
        
        $sizes = array('small' => '15%', 'medium' => '30%', 'large' => '50%', 'full' => '100%', 'default' => '30%');
        ob_start();

        // Set default options with then shortcode is used without parameters
        // style options defaults to list
        if ( !isset($atts['style']) ) { $atts['style'] = 'list';}
        // images options default to yes
        $images != 'no' || $image != 'no'  ? $images = true : $images = false;
        // debug option defaults to false
        isset($atts['debug']) ? $debug = true : $debug = false;
        $description = 'yes' ? $description = true : $description = false;

        $query = new WP_Query($args);

        // Set up the shortcode styles
        $style = array();
        $layout = $atts['style'];

        switch ($layout) {
            case "list":
                $style['containerPre'] = '<div id="wp-sponsors"><ul>';
                $style['containerPost'] = '</ul></div>';
                $style['wrapperClass'] = 'sponsors-item';
                $style['wrapperPre'] = '<li class="' .  $style["wrapperClass"] . '">';
                $style['wrapperPost'] = '</li>';
                break;
            case "linear":
            case "grid":
                $style['containerPre'] = '<div id="wp-sponsors" class="clearfix">';
                $style['containerPost'] = '</div>';
                $style['wrapperClass'] = 'sponsors-item';
                $style['wrapperPre'] = '<div class="' .  $style["wrapperClass"] . '">';
                $style['wrapperPost'] = '</div>';
                break;
        }
 
        if ( $query->have_posts() ) { 
            while ( $query->have_posts() ) : $query->the_post();

                if($query->current_post === 0) { echo $style['containerPre']; }
                // Check if the sponsor was a link
                get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) != '' ? $link = get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) : $link = false;
                if($debug) { $style['wrapperClass'] .= ' debug'; }
                echo $style['wrapperPre']; 
                $sponsor = '';
                // Check if we have a link
                if($link) { 
                    $sponsor .= '<a href=' .$link . ' target="_blank">';
                }
                // Check if we should do images, just show the title if there's no image set
                 if($images){
                    $sponsor .= '<img src=' . get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) . ' width=' . $sizes[$size] . '>';
                } else {
                    $sponsor .= the_title();
                }
                // Check if we need a description and the description is not empty 
                if($description) {
                    $sponsor .= '<p>' . get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ) . '</p> ';
                }
                // Close the link tag if we have it
                if($link) { 
                    $sponsor .= '</a>';
                }
                echo $sponsor;
                echo $style['wrapperPost'];
                $style['wrapperClass'] = 'sponsor-item';
                if( ($query->current_post + 1) === $query->post_count) { echo $style['containerPost']; }
            endwhile;
            return ob_get_clean();
        }
    }
    add_shortcode( 'sponsors', 'sponsors_register_shortcode' );
