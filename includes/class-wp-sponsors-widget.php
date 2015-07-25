<?php
    /**
    * Example Widget Class
    */
    class sponsors_widget extends WP_Widget {

        /** constructor -- name this the same as the class above */
        function sponsors_widget() {
            parent::WP_Widget(false, $name = __( 'Sponsors', 'wp-sponsors' ));
        }

        function widget($args, $instance) {
            extract( $args );
            // WP_Query arguments

            if($instance['category'] != 'all') {
                $term = $instance['category'];
            }
            else {
                $term = '';
            };
            $args = array (
                'post_type'              => 'sponsor',
                'post_status'            => 'publish',
                'pagination'             => false,
                'order'                  => 'ASC',
                'posts_per_page'         => '-1',
                'sponsor_categories'     => $term,
                'orderby'                => 'menu_order'
            );
            $title = apply_filters('widget_title', $instance['title'] );
            $before_title = "<div class='widget-title'>";
            $after_title = "</div>";
            // The Query
            $query = new WP_Query( $args );
            // The Output
            ?>
            <aside id="wp-sponsors" class="widget wp-sponsors">
                <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                <ul>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li class="sponsors-item">
                        <a href="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) ?>" target="_blank">
                        <?php if($instance['check_images'] === "on"){ ?>
                            <img src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" alt="<?php the_title(); ?>">
                        <?php } else { the_title(); } ?>
                        <?php if($instance['show_description'] === "on"){ ?>
                            <br><p class="sponsor-desc"><?php echo get_post_meta( get_the_ID(), 'wp_sponsors_desc', true ); ?></p>
                        <?php }; ?>
                        </a>
                    </li>
                <?php endwhile; wp_reset_postdata(); ?>
                </ul>
            </aside>
            <?php
        }

        // Update the widget
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['show_description'] = $new_instance['show_description'];
            $instance['check_images'] = $new_instance['check_images'];
            $instance['category'] = $new_instance['category'];
            $instance['title'] = strip_tags( $new_instance['title'] );
            return $instance;
        }

        // The Widget form
        function form($instance) {

            //Set up some default widget settings.
            $defaults = array( 'title' => __('Our sponsors', 'wp-sponsors'), 'check_images' => 'on' , 'category' => 'All');
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
                <input type="checkbox" id="<?php echo $this->get_field_id('check_images'); ?>" name="<?php echo $this->get_field_name('check_images'); ?>" <?php checked($instance['check_images'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('check_images'); ?>"><?php echo __( 'Show images', 'wp-sponsors' )?></label>
            </p>
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('show_description'); ?>" name="<?php echo $this->get_field_name('show_description'); ?>" <?php checked($instance['show_description'], 'on'); ?> />
                <label for="<?php echo $this->get_field_id('show_description'); ?>"><?php echo __( 'Show descriptions', 'wp-sponsors' )?></label>
            </p>
            <?php }
        }
        // end class sponsors_widget
        add_action('widgets_init', create_function('', 'return register_widget("sponsors_widget");'));