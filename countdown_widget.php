<?php
/*
Plugin Name: Countdown Widget
Description: Countdown generator. Based on Martin Angelov's mockup
Author: Ezekiel Riva
Version: 1
Author URI: https://github.com/ezekielriva
Special Thanks: Martin Angelov
*/


define('COUNTDOWN_DIR', get_option('siteurl').'/wp-content/plugins/er-countdown-widget/');
class CountdownWidget extends WP_Widget
{

  function CountdownWidget()
  {
    $widget_ops = array('classname' => 'CountdownWidget', 'description' => 'Display a countdown' );
    $this->WP_Widget('CountdownWidget', 'Countdown', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'until_date' => '', 'event' => '' ) );
    $until_date = $instance['until_date'];
    $event = $instance['event'];
?>
  <p>
    <label for="<?php echo $this->get_field_id('until_date'); ?>">Until Date: 
      <input class="widefat" id="<?php echo $this->get_field_id('until_date'); ?>" name="<?php echo $this->get_field_name('until_date'); ?>" type="date" value="<?php echo attribute_escape($until_date); ?>" />
      Chose a limit date for countdown. Format MM/DD/YYYY
    </label>
    <br>
    <label for="<?php echo $this->get_field_id('event'); ?>">Event: 
      <input class="widefat" id="<?php echo $this->get_field_id('event'); ?>" name="<?php echo $this->get_field_name('event'); ?>" type="date" value="<?php echo attribute_escape($event); ?>" />
    </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['until_date'] = $new_instance['until_date'];
    $instance['event'] = $new_instance['event'];
    return $instance;
  }

  function addCountdownAssets()
  {
    wp_enqueue_script('countdown', COUNTDOWN_DIR . 'assets/countdown/jquery.countdown.js', array('jquery'), null, true );
    wp_enqueue_style('bootstrapwp', COUNTDOWN_DIR .'assets/css/countdown.css', false ,'0.90', 'all' );
  }
 
  function widget($args, $instance)
  {
    $this->addCountdownAssets();

    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $until_date = empty($instance['until_date']) ? ' ' : apply_filters('widget_until_date', $instance['until_date']);
    $event = empty($instance['event']) ? ' ' : apply_filters('widget_event', $instance['event']);
 
    ?>
    <div id="countdown" class="countdownHolder">
    </div>
    <span id="note"></span>
    <?php
    $this->executeJs($until_date, $event);
 
    echo $after_widget;
  }

  function executeJs($until_date, $event)
  {
    ?>
    <script type="text/javascript">
      window.onload = function () {
        $ = jQuery;
        var note = $('#note'),
          ts = new Date('<?php echo $until_date ?>');
          
        $('#countdown').countdown({
          timestamp : ts,
          callback  : function(days, hours, minutes, seconds){
            
            var message = "";
            
            message += days + " day" + ( days==1 ? '':'s' ) + ", ";
            message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
            message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
            message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";
            
            message += "left until <?php echo $event ?>";
            
            note.html(message);
          }
        });
      };

    </script>
    <?php
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("CountdownWidget");') );?>
