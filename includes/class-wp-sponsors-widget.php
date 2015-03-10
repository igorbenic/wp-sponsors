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
        'order'                  => 'ASC',
        'posts_per_page'        => '-1'
      );
      $title = apply_filters('widget_title', $instance['title'] );
      $before_title = "<h1 class='widget-title'>";
      $after_title = "</h1>";
      // The Query
      $query = new WP_Query( $args );
      // The Output
      ?>
      <aside id="wp-sponsors" class="widget wp-sponsors">
      <?php
      if ( $title ) echo $before_title . $title . $after_title;
      ?>
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
        </aside>
      <?php
  }
  // Update the widget
  function update( $new_instance, $old_instance ) {

      $instance = $old_instance;
      $instance['check_images'] = $new_instance['check_images'];
      $instance['title'] = strip_tags( $new_instance['title'] );

      return $instance;
  }
  // The Widget form
  function form($instance) {

    //Set up some default widget settings.
    $defaults = array( 'title' => __('Our sponsors', 'example_title'), 'check_images' => 'on' );
    $instance = wp_parse_args( (array) $instance, $defaults );

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
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'example'); ?></label>
        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
    </p>
    <?php
  }
}

// end class sponsors_widget
add_action('widgets_init', create_function('', 'return register_widget("sponsors_widget");'));

?>