<?php

/**
 * a widget to show Sponsor single item in sidebar
 * 
 */
class Sponsor_Widget extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function Sponsor_Widget() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'Sponsor_Widget', 
            'description' => __('manage sponsor list', 'sponsor_widget') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'sponsor_widget' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'sponsor_widget', 
            __('Sponsors Widget', 'sponsor_widget'), 
            $widget_ops, 
            $control_ops 
        );
        
    }     

    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
		$category = apply_filters('widget_category', $instance['category'] );
        
            
        /* Before widget (defined by themes). */
		
    	$values = get_post_custom($post->ID);
        echo $before_widget;
		
		if($title){
		echo '<h3>'.$title.'</h3>';
		}
        echo do_shortcode("[tco_sponsors category='".$category."']");

		
		
        /* After widget (defined by themes). */
        echo $after_widget;
    }
        
    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		
        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 
            'title' => __('Event Sponsors', 'hybrid'),
			'category' => __('','hybird')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Sponsor Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>  
		<p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Sponsor category:', 'hybrid'); ?></label>
            <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo $instance['category']; ?>" style="width:100%;" >
            	<option selected="selected" value="">None</option>
            	<option <?php echo $instance['category'] == "Diamond"?"selected='selected'":"";?> value="Diamond"> Diamond </option>
            	<option <?php echo $instance['category'] == "Platinum"?"selected='selected'":"";?> value="Platinum">Platinum</option>
            	<option <?php echo $instance['category'] == "Gold"?"selected='selected'":"";?> value="Gold">Gold</option>            
            </select>
        </p>  		
    <?php
    }    
}
?>