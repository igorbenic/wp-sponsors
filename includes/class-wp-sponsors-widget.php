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
      $args = array (
        'post_type'              => 'sponsor',
        'post_status'            => 'publish',
        'pagination'             => false,
        'order'                  => 'ASC'
      );

      // The Query
      $query = new WP_Query( $args );
      // The Output
      ?>
      <div class="wp-sponsors widget">
        <ul>
          <?php while ( $query->have_posts() ) : $query->the_post(); ?>
              <li class="sponsors-item">
                <a href="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_url', true ) ?>" target="_blank">
                <?php if($instance['check_images'] === "on"){ ?>
                  <img src="<?php echo get_post_meta( get_the_ID(), 'wp_sponsors_img', true ) ?>" alt="<?php the_title(); ?>">
                <?php } else { the_title(); } ?>
                </a>
              </li>
          <?php endwhile; wp_reset_postdata(); ?>
          </ul>
        </div>
      <?php
  }
  // Update the widget
  function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['check_images'] = $new_instance['check_images'];
      return $instance;
  }
  // The Widget form
  function form($instance) {
    if(empty($instance)) {
      $key = array('check_images');
      $instance = array_fill_keys($key, 'on');
    }
    ?>
      <p>
        <input
          type="checkbox"
          id="<?php echo $this->get_field_id('check_images'); ?>"
          name="<?php echo $this->get_field_name('check_images'); ?>"
          <?php checked($instance['check_images'], 'on'); ?>
          />
        <label for="<?php echo $this->get_field_id('check_images'); ?>"><?php echo __( 'Show images', 'wp-sponsors' )?></label>
      </p>
    <?php
  }
}

// end class sponsors_widget
add_action('widgets_init', create_function('', 'return register_widget("sponsors_widget");'));

?>