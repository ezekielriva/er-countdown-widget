<?php
/*
Plugin Name: Countdown Widget
Description: Countdown generator
Author: Ezekiel Riva
Version: 1
Author URI: https://github.com/ezekielriva
*/


class CountdownWidget extends WP_Widget
{
  function CountdownWidget()
  {
    $widget_ops = array('classname' => 'CountdownWidget', 'description' => 'Display a countdown' );
    $this->WP_Widget('CountdownWidget', 'Countdown', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'until_date' => '' ) );
    $until_date = $instance['until_date'];
?>
  <p>
    <label for="<?php echo $this->get_field_id('until_date'); ?>">Until Date: 
      <input class="widefat" id="<?php echo $this->get_field_id('until_date'); ?>" name="<?php echo $this->get_field_name('until_date'); ?>" type="date" value="<?php echo attribute_escape($until_date); ?>" />
      Chose a limit date for countdown
    </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['until_date'] = $new_instance['until_date'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $until_date = empty($instance['until_date']) ? ' ' : apply_filters('widget_until_date', $instance['until_date']);
 
    if (!empty($until_date))
      echo $before_until_date . $until_date . $after_title;
 
    ?>
    <div id="countdown" class="countdownHolder">
      <span class="countDays">
          <span class="position">
              <span class="digit static"></span>
          </span>
          <span class="position">
              <span class="digit static"></span>
          </span>
      </span>

      <span class="countDiv countDiv0"></span>

      <span class="countHours">
          <span class="position">
              <span class="digit static"></span>
          </span>
          <span class="position">
              <span class="digit static"></span>
          </span>
      </span>

      <span class="countDiv countDiv1"></span>

      <span class="countMinutes">
          <span class="position">
              <span class="digit static"></span>
          </span>
          <span class="position">
              <span class="digit static"></span>
          </span>
      </span>

      <span class="countDiv countDiv2"></span>

      <span class="countSeconds">
          <span class="position">
              <span class="digit static"></span>
          </span>
          <span class="position">
              <span class="digit static"></span>
          </span>
      </span>

      <span class="countDiv countDiv3"></span>
    </div>
    <?php
    // WIDGET CODE GOES HERE
    echo "<h1>This is my new widget!</h1>";
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("CountdownWidget");') );?>
