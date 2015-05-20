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
        ), $atts ) );

        $args = array (
            'post_type'             => 'sponsor',
            'post_status'           => 'publish',
            'pagination'            => false,
            'order'                 => 'ASC',
            'posts_per_page'        => '-1',
            'sponsor_categories'    => $category,
        );
        $sizes = array('small' => '15%', 'medium' => '30%', 'large' => '60', 'full' => '100%', 'default' => '25%');

        ob_start();

        $query = new WP_Query($args);
        if ( $query->have_posts() ) { 
        if ( empty($atts) ) {
            $atts = Array();
            $atts['images'] = "yes";
            $atts['image'] = "yes";
        }
            ?>
        <div id="wp-sponsors">
            <ul>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <li class="sponsors-item">
                    <a href="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) ?>" target="_blank">
                        <?php if($atts['image'] === "yes" OR $atts['images'] === "yes" ){ ?>
                            <img 
                            src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" 
                            alt="<?php the_title(); ?>" 
                            width="<?php echo $sizes[$size]; ?>"
                            >
                        <?php } else { the_title(); } ?>
                    </a>
                </li>
                <?php endwhile; return ob_get_clean(); ?>
            </ul>
        </div><?php
        }
    }
    add_shortcode( 'sponsors', 'sponsors_register_shortcode' );

?>