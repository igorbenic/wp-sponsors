<?php

    /**
     * Adds sponsors shortcode option
     */
    function sponsors_register_shortcode($atts) {


        // define attributes and their defaults
        extract( shortcode_atts( array (
            'type' => 'post',
            'image' => 'yes',
            'images' => 'yes',
            'category' => '',
            'size' => 'default',
            'style' => 'list',
            'description' => 'no',
            'orderby' => 'menu_order',
            'title' => 'no',
            'max' => '-1',
            'debug' => NULL
        ), $atts ) );

        $args = array (
            'post_type'             => 'sponsor',
            'post_status'           => 'publish',
            'pagination'            => false,
            'order'                 => 'ASC',
            'orderby'               => $atts['orderby'],
            'posts_per_page'        => (int)$atts['max'] ? $atts['max'] : '-1',
            'tax_query'             => array(),
        );

        $nofollow = ( defined( 'SPONSORS_NO_FOLLOW' ) ) ? SPONSORS_NO_FOLLOW : true;

        if(!empty($category)) {
          $args['tax_query'] = array(
            array(
              'taxonomy'  => 'sponsor_categories',
              'field'     => 'slug',
              'terms'     => $category,
            ),
          );
        }

        // $sizes = array('small' => '15%', 'medium' => '30%', 'large' => '50%', 'full' => '100%', 'default' => '30%');
        ob_start();

        // Set default options with then shortcode is used without parameters
        // style options defaults to list
        if ( !isset($atts['style']) ) { $atts['style'] = 'list';}
        // images options default to yes

        $images != 'no' && $image != 'no' ? $images = true : $images = false;
        // debug option defaults to false
        isset($debug) ? $debug = true : $debug = false;
        $description === 'yes' ? $description = true : $description = false;
        $title === 'yes' ? $title = true : $title = false;

        $query = new WP_Query($args);

        // Set up the shortcode styles
        $style = array();
        $layout = $atts['style'];

        $shame = new Wp_Sponsors_Shame();

        switch ($layout) {
            case "list":
                $style['containerPre'] = '<div id="wp-sponsors"><ul>';
                $style['containerPost'] = '</ul></div>';
                $style['wrapperClass'] = 'sponsor-item';
                $style['wrapperPre'] = 'li';
                $style['wrapperPost'] = '</li>';
                break;
            case "linear":
            case "grid":
                $style['containerPre'] = '<div id="wp-sponsors" class="clearfix">';
                $style['containerPost'] = '</div>';
                $style['wrapperClass'] = 'sponsor-item';
                $style['wrapperPre'] = 'div';
                $style['wrapperPost'] = '</div>';
                $style['imageSize'] = 'full';
                break;
        }

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) : $query->the_post();

                if($query->current_post === 0) { echo $style['containerPre']; }
                // Check if the sponsor was a link
                get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) != '' ? $link = get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) : $link = false;
                $class = '';
                $class .= $size;
                if($debug) { $class .= ' debug'; }

                echo '<' . $style['wrapperPre'] . ' class="' . $style['wrapperClass'] .' ' . $class . '">';
                $sponsor = '';
                // Check if we have a link
                if($link && !$images) {
                    $sponsor .= '<a href=' .$link . ' target="_blank">';
                }
                // Check if we have a title
                if($title) {
                    $sponsor .= '<h3>'.get_the_title().'</h3>';
                }
                // Close the link tag if we have it
                if($link && !$images) {
                    $sponsor .= '</a>';
                }
                // Check if we have a link
                if($link && $images) {
                    $sponsor .= '<a href=' .$link . ' target="_blank">';
                }
                // Check if we should do images, just show the title if there's no image set
                 if($images){
                    $sponsor .=  $shame->getImage(get_the_ID());
                 } elseif ($title === false) {
                     $sponsor .= '<h3>' . get_the_title() . '</h3>';
                }

                // Check if we need a description and the description is not empty
                if($description) {
                    $sponsor .= '<p>' . get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ) . '</p> ';
                }
                // Close the link tag if we have it
                if($link && $images) {
                    $sponsor .= '</a>';
                }
                echo $sponsor;
                echo $style['wrapperPost'];
                if( ($query->current_post + 1) === $query->post_count) { echo $style['containerPost']; }
            endwhile;
            wp_reset_postdata();
            return ob_get_clean();
        }
    }
    add_shortcode( 'sponsors', 'sponsors_register_shortcode' );
