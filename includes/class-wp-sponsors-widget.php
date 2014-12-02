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
        $check_images = $instance['check_images'] ? 'true' : 'false';

        ?>
              <?php echo $before_widget; ?>

              <ul>
                <li><?php echo $check_images; ?></li>
              </ul> 
              <?php echo $after_widget; ?>
        <?php
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['check_images'] = $new_instance['check_images'];
        return $instance;
    }

    function form($instance) {

        $check_images    = esc_attr($instance['check_images']);
        ?>
          <p>
              <input class="checkbox" type="checkbox" <?php checked($instance['check_images'], 'on'); ?> id="<?php echo $this->get_field_id('check_images'); ?>" name="<?php echo $this->get_field_name('check_images'); ?>" /> 
              <label for="<?php echo $this->get_field_id('check_images'); ?>"><?php echo __( 'Show images', 'wp-sponsors' )?></label>
          </p>
        <?php
    }

} // end class sponsors_widget
add_action('widgets_init', create_function('', 'return register_widget("sponsors_widget");'));

?>