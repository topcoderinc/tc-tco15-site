<?php

/**
 * a widget to show blog post
 * 
 */
class TCO_Blog_Posts extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function TCO_Blog_Posts() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'TCO_Blog_Posts', 
            'description' => __('manage blog post list', 'tco_blog_posts') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'tco_blog_posts' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'tco_blog_posts', 
            __('TCO_Blog_Posts Widget', 'tco_blog_posts'), 
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
        
            
        /* Before widget (defined by themes). */
		
    	$values = get_post_custom($post->ID);
        echo $before_widget;
		
?>
<div class="blogFilter">
    <h3>
        <?php echo $title; ?>
    </h3>
    <div class="archives">
    <ul>		
    <?php 
	    $cat = get_category_by_slug('top-news');
    ?>
		<?php
		global $wpdb;
		$limit = 0;
		$year_prev = null;
		$exclude = $cat->cat_ID;
		$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month ,	YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts as a, $wpdb->term_relationships as b WHERE a.ID = b.object_id and a.post_type = 'post' and a.post_status = 'publish'  and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC");
		foreach($months as $month) :
			$year_current = $month->year;
			if ($year_current != $year_prev){
				if ($year_prev != null){?>
				
				<?php } ?>
			
			<li class="archive-year"><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/"><?php echo $month->year; ?></a></li>
			
			<?php } ?>
			<li><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"><span class="archive-month"><?php echo date_i18n("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?></span></a></li>
		<?php $year_prev = $year_current;
		
		if(++$limit >= 18) { break; }
		
		endforeach; ?>
    </ul>
    </div>    
</div><!-- end of .blogSelector -->
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
            'title' => __('Blog Posts', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Blog Posts Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>      
    <?php
    }    
}
?>