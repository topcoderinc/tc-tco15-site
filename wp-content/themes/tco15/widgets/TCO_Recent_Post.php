<?php

/**
 * a widget to show Sponsor single item in sidebar
 * 
 */
class TCO_Recent_Post extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function TCO_Recent_Post() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'TCO_Recent_Post', 
            'description' => __('manage recent post list', 'tco_recent_post') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'tco_recent_post' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'tco_recent_post', 
            __('TCO_Recent_Post Widget', 'tco_recent_post'), 
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
        $post_count = (int)($instance['post_count']);
        
            
        /* Before widget (defined by themes). */
		
    	$values = get_post_custom($post->ID);
        echo $before_widget;
		
		
?>

<div class="posts">

	<h3><?php echo $title; ?></h3>
<?php echo apply_filters ('the_content', '[tco_recent_blog_posts limit="'.$post_count.'"]' )  ?>


<!--
<div class="buttons"><a class="btn" href="<?php echo get_permalink( get_page_by_title( 'Blog' ) ); ?>" data-page="pPosts" data-menu="posts">MORE POSTS</a></div>
</div><!-- end of .posts -->
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
        $instance['post_count'] = strip_tags( $new_instance['post_count'] );

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
            'title' => __('Recent Posts', 'hybrid'), 
            'post_count' => __('3', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <!-- Sponsor image url: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e('Show Post Count:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" value="<?php echo $instance['post_count']; ?>" style="width:100%;" />
        </p>
                  
    <?php
    }    
}
?>