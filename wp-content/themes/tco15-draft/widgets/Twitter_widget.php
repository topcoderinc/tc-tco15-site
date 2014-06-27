<?php

/**
 * Twitter widget
 * 
 */
class Twitter_widget extends WP_Widget {
	/**
	 * set up widget
	 */
	function Twitter_widget() {
		/* Widget settings. */
		$widget_ops = array (
				'classname' => 'Twitter_widget',
				'description' => __ ( 'Twitter widget', 'twitter_widget' ) 
		);
		
		/* Widget control settings. */
		$control_ops = array (
				'width' => 162,
				'height' => 300,
				'id_base' => 'twitter_widget' 
		);
		
		/* Create the widget. */
		$this->WP_Widget ( 'twitter_widget', __ ( 'TCO Twitter widget', 'twitter_widget' ), $widget_ops, $control_ops );
	}
	
	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {
		extract ( $args );
		
		/* Our variables from the widget settings. */
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		
		/* Before widget (defined by themes). */
		
		$values = get_post_custom ( $post->ID );
		echo $before_widget;
		
		if($title){
		echo '<h3>'.$title.'</h3>';
		}
		echo do_shortcode( "[tco_tweets]" );
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {
		
		/* Set up some default widget settings. */
		
		?>


<!-- Widget Title: Text Input -->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Twitter Title:', 'hybrid'); ?></label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width: 100%;" />
</p>
<?php
	}
}
?>