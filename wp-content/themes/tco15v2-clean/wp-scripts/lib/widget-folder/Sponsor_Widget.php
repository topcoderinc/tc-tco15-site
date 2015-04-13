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
            __('Sponsor_Widget Widget', 'sponsor_widget'), 
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
		
		$item_slug = 'overview-sponsors';
		$item = wp_get_nav_menu_object($item_slug);
		$items = wp_get_nav_menu_items($item->term_id);
		
		if (is_home() || is_front_page()) {
		
?>
<div class="sponsorList">
    <div>
        <h3>
            <?php echo $title; ?>
        </h3>
        <p class="list">
<?php
			foreach( (array) $items as $key => $item) {
				$title = $item->title;
				$url = $item->url;
				$page_id = $item->object_id;
				
				
				$thumbnailVal = get_post_meta($page_id,'Sponsor Image Small',true);
				
				$thumbnailImg = wp_get_attachment_image_src( $thumbnailVal, "full" );
				$thumbnailImg = $thumbnailImg[0];
				
				if ($thumbnailImg != null) {
?>
            <a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
                <img src="<?php echo $thumbnailImg; ?>" alt="<?php echo $title; ?>" />
            </a>

<?php
				}
			}
?>

        </p>
    </div>
</div>
<?php
		} else {
?>
<div class="sponsor">
    <h3><?php echo $title; ?></h3>
    <div class="carousel">
<?php
	foreach( (array) $items as $key => $item) {
		$title = $item->title;
		$url = $item->url;
		$page_id = $item->object_id;
		
		
		$thumbnailVal = get_post_meta($page_id,'Sponsor Image Small',true);
		
		$thumbnailImg = wp_get_attachment_image_src( $thumbnailVal, "full" );
		$thumbnailImg = $thumbnailImg[0];
		
		if ($thumbnailImg != null) {
?>

	<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
		<img src="<?php echo $thumbnailImg; ?>" alt="<?php echo $title; ?>" />
	</a>

<?php
		}
	}
?>

    </div>
</div><!-- end of .sponsor -->
<?php
		}
		
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
            'title' => __('EVENT SPONSORS', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Sponsor Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>      
    <?php
    }    
}
?>