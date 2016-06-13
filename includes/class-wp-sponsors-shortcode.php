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
        
        $sizes = array('small' => '15%', 'medium' => '30%', 'large' => '60%', 'full' => '100%', 'default' => '30%');
        ob_start();

        // Set default options with then shortcode is used without parameters
        // style options defaults to list
        if ( !isset($atts['style']) ) { $atts['style'] = 'list';}
        // images options default to yes
        if ( !isset($atts['images']) && $atts['image'] != "no" ) { $atts['images'] = 'yes';}
        // debug option defaults to false
        isset($atts['debug']) ? $debug = true : $debug = false;

        $query = new WP_Query($args);
        // If we have results, continue:
        if ( $query->have_posts() ) { 
            // If the style option is set to list or the nothing, list view will be used
            if($atts['style'] === "list") { ?>
                <div id="wp-sponsors">
                    <ul>
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                            <?php $link = get_post_meta( get_the_ID(), 'wp_sponsors_url', true ); ?>
                            <li class="sponsors-item">
                                <?php if(!empty($link)) { ?><a href="<?php echo $link ?>" target="_blank" <?php if($nofollow) {?>rel="nofollow" <?php } ?>><?php }; ?>
                                <?php if($atts['images'] === "yes"){ ?>
                                    <img  src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>"  alt="<?php the_title(); ?>"  width="<?php echo $sizes[$size]; ?>">
                                <?php } else { the_title(); } ?>
                                <?php if(!empty($link)) { ?></a><?php }; ?>
                            <?php if ( $atts['description'] === "yes" ) { 
                                    if(get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ) != "") {  ?>
                                        <p><?php echo get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ); ?></p> 
                             <?php } }  ?>
                            </li>
                        <?php endwhile; ?> 
                    </ul>
                </div>
            <?php return ob_get_clean(); ?>
        <?php };
            // If the style option is set to linear, this view will be used
            if($atts['style'] === "linear") { ?>
                <div id="wp-sponsors" class="clearfix"> 
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php $link = get_post_meta( get_the_ID(), 'wp_sponsors_url', true ); ?>
                    <?php   $class = 'sponsor-item';
                            $class .= ' ' . $size;
                            if($debug) { $class .= ' ' . 'debug'; } 
                    ?>
                    <div class="<?php echo $class; ?>">
                        <?php if(!empty($link)) { ?><a href="<?php echo $link ?>" target="_blank" rel="nofollow"><?php }; ?>
                        <?php if($atts['image'] === "yes" OR $atts['images'] === "yes" ){ ?>
                            <img src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" alt="<?php the_title(); ?>">
                        <?php } else { the_title(); } ?>
                            <?php if ( $atts['description'] === "yes" ) { 
                                    if(get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ) != "") {  ?>
                                        <p><?php echo get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ); ?></p> 
                             <?php } }  ?>                        
                             <?php if(!empty($link)) { ?></a><?php }; ?>
                    </div>
                    <?php endwhile; ?>

                </div>
            <?php return ob_get_clean(); ?>
        <?php };
            }
        }
    add_shortcode( 'sponsors', 'sponsors_register_shortcode' );
