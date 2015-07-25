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
            'posts_per_page'        => '-1',
            'sponsor_categories'    => $category,
        );
        $sizes = array('small' => '15%', 'medium' => '30%', 'large' => '60%', 'full' => '100%', 'default' => '25%');
        ob_start();

        // Set default options with then shortcode is used without parameters
        if ( !isset($atts['style']) ) { $atts['style'] = 'list';}
        if ( !isset($atts['images']) && $atts['image'] != "no" ) { $atts['images'] = 'yes';}

        $query = new WP_Query($args);
        // If we have results, continue:
        if ( $query->have_posts() ) { 
            // If the style option is set to list or the nothing, list view will be used
            if($atts['style'] === "list") { ?>
                <div id="wp-sponsors">
                    <ul>
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <li class="sponsors-item">
                            <a href="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) ?>" target="_blank">
                                <?php if($atts['images'] === "yes"){ ?>
                                    <img 
                                    src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" 
                                    alt="<?php the_title(); ?>" 
                                    width="<?php echo $sizes[$size]; ?>"
                                    >
                                <?php } else { the_title(); } ?>
                            </a>
                            <?php if ( $atts['description'] === "yes" ) { ?> <p><?php echo get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ); ?></p> <?php } ?>
                        </li>
                        <?php endwhile; return ob_get_clean(); ?>
                    </ul>
                </div>
        <?php };
            // If the style option is set to linear, this view will be used
            if($atts['style'] === "linear") { ?>
                <div id="wp-sponsors" class="clearfix"> 
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="sponsor-item <?php echo $size; ?>">
                        <?php if($atts['image'] === "yes" OR $atts['images'] === "yes" ){ ?>
                            <img src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" alt="<?php the_title(); ?>" >
                        <?php } else { the_title(); } ?>
                        <?php if ( $atts['description'] === "yes" ) { ?> <p><?php echo get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ); ?></p> <?php } ?>
                    </div>
                    <?php endwhile; return ob_get_clean(); ?>
                </div>
        <?php };
            }
        }
    add_shortcode( 'sponsors', 'sponsors_register_shortcode' );