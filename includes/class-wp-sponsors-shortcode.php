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
        ), $atts ) );

        $args = array (
            'post_type'             => 'sponsor',
            'post_status'           => 'publish',
            'pagination'            => false,
            'order'                 => 'ASC',
            'posts_per_page'        => '-1',
            'sponsor_categories'    => $category,
        );

        ob_start();
        $query = new WP_Query($args);

        if ( $query->have_posts() ) { ?>
        <div id="wp-sponsors">
            <ul>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <li class="sponsors-item">
                    <a href="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) ?>" target="_blank">
                        <?php if($atts['images'] === "yes"){ ?>
                            <img src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" alt="<?php the_title(); ?>">
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