<?php
    /**
    * Example Widget Class
    */
    class sponsors_widget extends WP_Widget {

        function __construct() {
            parent::__construct(false, $name = __( 'Sponsors', 'wp-sponsors' ), array( 'description' => __('List your sponsors, per category, with or without images', 'wp-sponsors')));
        }

        function widget($args, $instance) {
            extract( $args );
            // WP_Query arguments
            if($instance['category'] != 'all' && $instance['category'] != '') {
                $term = $instance['category'];
            }

            $args = array (
                'post_type'              => 'sponsor',
                'post_status'            => 'publish',
                'pagination'             => false,
                'order'                  => 'ASC',
                'posts_per_page'         => '-1',
                'orderby'                => $instance['order_by']
            );

            if($instance['category'] != 'all' && $instance['category'] != '') {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'sponsor_categories',
                        'field'    => 'slug',
                        'terms'    => $term,
                    )
                );
            }

            if($instance['max']) {
                $args['posts_per_page'] = $instance['max'];
            }

            $nofollow = ( defined( 'SPONSORS_NO_FOLLOW' ) ) ? SPONSORS_NO_FOLLOW : true;

            $title = apply_filters('widget_title', $instance['title'] );
            $widget_target = $instance['target_blank'] == "on" ? true : false;

            // filter for the wrapper and item classes
            $sponsorStyling = apply_filters('sponsors_widget_styling', 'sponsors-item');

            // The Query
            $query = new WP_Query( $args );
            $shame = new Wp_Sponsors_Shame();
            // The Output
            ?>
                <?php echo $before_widget; ?>
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                <ul class="<?php echo $instance['display_option']; ?>">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php
                        $link = get_post_meta( get_the_ID(), 'wp_sponsors_url', true );
                        $link_target = get_post_meta( get_the_ID(), 'wp_sponsor_link_behaviour', true );
                        $target = ($link_target == 1 OR $widget_target == true) ? true : false;
                    ?>
                    <li class="<?php echo $sponsorStyling ?>">
                        <?php if(!empty($link)) { ?>
                        <a href="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) ?>" <?php if($target){ ?> target="_blank"<?php }; ?> <?php if($nofollow) {?>rel="nofollow" <?php } ?>>
                        <?php }; ?>
                        <?php if($instance['show_title'] === "on"){ ?>
                            <div class="sponsor-title widget-title"><?php echo the_title(); ?></div>
                        <?php }; ?>
                        <?php if($instance['check_images'] === "on"){ ?>
                            <?php echo $shame->getImage(get_the_ID()) ?>
                        <?php } else { the_title(); } ?>
                        <?php if($instance['show_description'] === "on"){ ?>
                            <br><p class="sponsor-desc"><?php echo get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ); ?></p>
                        <?php }; ?>
                        <?php if(!empty($link)) { ?>
                        </a>
                        <?php }; ?>
                    </li>
                <?php endwhile; wp_reset_postdata(); ?>
                </ul>
                <?php echo $after_widget; ?>
            <?php
        }

        // Update the widget
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['show_description'] = $new_instance['show_description'];
            $instance['show_title'] = $new_instance['show_title'];
            $instance['check_images'] = $new_instance['check_images'];
            $instance['target_blank'] = $new_instance['target_blank'];
            $instance['order_by'] = $new_instance['order_by'];
            $instance['category'] = $new_instance['category'];
            $instance['display_option'] = $new_instance['display_option'];
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['max'] = $new_instance['max'];
            return $instance;
        }

        // The Widget form
        function form($instance) {

            //Set up some default widget settings.
            $defaults = array( 'title' => __('Our sponsors', 'wp-sponsors'), 'check_images' => 'on' , 'category' => 'all', 'display_option' => 'vertical', 'order_by' => 'menu_order', 'target_blank' => 'on', max => '');
            $instance = wp_parse_args( (array) $instance, $defaults );

            if(empty($instance)) {
                $key = array('check_images');
                $instance = array_fill_keys($key, 'on');
            }
            $cats = get_terms( 'sponsor_categories' ); ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'wp-sponsors'); ?></label>
                <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
            </p>
            <?php if ( ! empty( $cats ) && ! is_wp_error( $cats ) ){ ?>
            <p>
                <label for="<?php echo $this->get_field_id('category'); ?>"> <?php echo __('Category', 'wp-sponsors')?></label>
                <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat" style="width:100%;">
                    <option value="all"><?php echo _e('All', 'wp-sponsors'); ?></option>
                    <?php foreach ( $cats as $cat ) { ?>
                        <option <?php selected( $instance['category'],$cat->slug,  'selected'); ?> value="<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php } ?>
            <p>
                <label for="<?php echo $this->get_field_id('display_option'); ?>"> <?php echo __('Display', 'wp-sponsors')?></label>
                <select id="<?php echo $this->get_field_id('display_option'); ?>" name="<?php echo $this->get_field_name('display_option'); ?>" class="widefat" style="width:100%;">
                    <option <?php selected( $instance['display_option'], 'vertical' ); ?> value="vertical"><?php echo _e('Vertical (best for sidebars)', 'wp-sponsors'); ?></option>
                    <option <?php selected( $instance['display_option'], 'horizontal' ); ?> value="horizontal"><?php echo _e('Horizontal (best for footers)', 'wp-sponsors'); ?></option>
                </select>

            </p>
    		<p>
              <label for="<?php echo $this->get_field_id('order_by'); ?>"> <?php echo __('Order by', 'wp-sponsors')?></label>
                <select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>" class="widefat" style="width:100%;">
                    <option <?php selected( $instance['order_by'], 'menu_order' ); ?> value="menu_order"><?php echo _e('Weight', 'wp-sponsors'); ?></option>
                    <option <?php selected( $instance['order_by'], 'title' ); ?> value="title"><?php echo _e('Title', 'wp-sponsors'); ?></option>
                    <option <?php selected( $instance['order_by'], 'rand' ); ?> value="rand"><?php echo _e('Random', 'wp-sponsors'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'max' ); ?>"><?php _e('Number of sponsors to show  (leave to show all)', 'wp-sponsors'); ?></label>
                <input id="<?php echo $this->get_field_id( 'max' ); ?>" name="<?php echo $this->get_field_name( 'max' ); ?>" value="<?php echo $instance['max']; ?>" style="width:100%;"  type="number"/>
            </p>
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" <?php checked($instance['show_title'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php echo __( 'Show sponsor title', 'wp-sponsors' )?></label>
            </p>
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('check_images'); ?>" name="<?php echo $this->get_field_name('check_images'); ?>" <?php checked($instance['check_images'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('check_images'); ?>"><?php echo __( 'Show sponsor logo', 'wp-sponsors' )?></label>
            </p>
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('show_description'); ?>" name="<?php echo $this->get_field_name('show_description'); ?>" <?php checked($instance['show_description'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('show_description'); ?>"><?php echo __( 'Show sponsor description', 'wp-sponsors' )?></label>
            </p>
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('target_blank'); ?>" name="<?php echo $this->get_field_name('target_blank'); ?>" <?php checked($instance['target_blank'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('target_blank'); ?>"><?php echo __( 'Open links in a new window', 'wp-sponsors' )?></label>

            </p>
            <?php }
        }
        // end class sponsors_widget
        add_action('widgets_init', create_function('', 'return register_widget("sponsors_widget");'));
