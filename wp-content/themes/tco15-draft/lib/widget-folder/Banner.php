<?php

/**
 * a widget to show Sponsor single item in sidebar
 * 
 */
class Banner extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function Banner() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'Banner', 
            'description' => __('manage banner item in sponsor about page', 'banner') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'banner' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'banner', 
            __('Banner Widget', 'banner'), 
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
        $banner_url = strip_tags($instance['banner_url']);
        $url = strip_tags($instance['url']);
        
            
        /* Before widget (defined by themes). */
		
    	$values = get_post_custom($post->ID);
        echo $before_widget;
?>
<a class="banner" href="<?php echo $url; ?>">
    <img src="<?php echo $banner_url; ?>" alt="" width="366" height="162" />
</a>
<?php
		
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
        $instance['banner_url'] = strip_tags($new_instance['banner_url']);
        $instance['url'] = strip_tags($new_instance['url']);

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
            'title' => __('', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Banner Name:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'banner_url' ); ?>"><?php _e('Banner Image URL:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'banner_url' ); ?>" name="<?php echo $this->get_field_name( 'banner_url' ); ?>" value="<?php echo $instance['banner_url']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('Banner URL Link:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" style="width:100%;" />
        </p>
    <?php
    }    
}
?>