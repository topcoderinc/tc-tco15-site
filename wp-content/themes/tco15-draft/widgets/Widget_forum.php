<?php

/**
 * a widget to show Sponsor single item in sidebar
 * 
 */
class Widget_forum extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function Widget_forum() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'Widget_forum', 
            'description' => __('A widget to stream TCO forum posts', 'forum') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'forum' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'forum', 
            __('Forum Widget', 'forum'), 
            $widget_ops, 
            $control_ops 
        );
        
    }     

    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
		
        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $forum_url = strip_tags($instance['forum_url']);
        $forum_sidebar_max = strip_tags($instance['forum_sidebar_max']);
        
            
        /* Before widget (defined by themes). */
        echo $before_widget;
		
		require_once "rss/rss_fetch.inc";

		$forumFeedsUrl 		= $forum_url;
		$forumFeedsMaxItem 	= $forum_sidebar_max!=null ? $forum_sidebar_max : 3;
		
		if ($forumFeedsUrl!='') {			

			if ( !defined('MAGPIE_CACHE_AGE') ) {
				define('MAGPIE_CACHE_AGE', 60*60); // one hour
			}		
			
			$feed 		= fetch_rss($forumFeedsUrl);
			$arrForum 	= $feed->items;
			$forumCount = count($arrForum);
			
?>
<div class="posts forum_widget">
	<h3><?php echo $title; ?></h3>
	<div class="carousel">
	<ol>
    <?php
	$html = "";
		for($i = 0; $i < $forumCount; $i++) {
			if($i >= $forumFeedsMaxItem) {
				break;
			}
			$title 		= $arrForum[$i]["title"];
			$creator 	= $arrForum[$i]["author"] !='' ? $arrForum[$i]["author"] : $arrForum[$i]["dc"]["creator"];
			$link 		= $arrForum[$i]["link"];
			$description = $arrForum[$i]["summary"];
			$cls = '';
			if ($i == 0) {
				$cls = ' class="first"';
			}
			if($i==0 && $i%3==0){
				$html .=  '<li class="gr"><ul>';
			}else if($i%3==0){
				$html .=  '</ul></li><li class="gr"><ul>';
			}
	
	
   	 	$html .= '<li '.$cls.' >
        <div class="post-title"><a href="'. $link.'"><strong>'. $title.'</strong></a></div>
        <div>
        	<div class="desc">
            '. $description.'
            </div>
            Posted by <strong><a href="'. $link.'">'. $creator.'</a></strong>
        </div>
        </li>';
    
		if($i%3!=0 && $i == $forumCount-1){
				$html .= '</ul></li>';
			}
		}
	?>	
	<?php echo $html ?>;
	</ol>
	</div>
</div>

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
        $instance['forum_url'] = strip_tags( $new_instance['forum_url'] );
        $instance['forum_sidebar_max'] = strip_tags( $new_instance['forum_sidebar_max'] );

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
            'title' => __('Forum Posts', 'hybrid'),
			'forum_url' =>  __('http://apps.topcoder.com/forums/?module=RSS&forumID=558718', 'hybrid'),
			'forum_sidebar_max' =>  __('10', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
		
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Form Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'forum_url' ); ?>"><?php _e('Forum Feed:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'forum_url' ); ?>" name="<?php echo $this->get_field_name( 'forum_url' ); ?>" value="<?php echo $instance['forum_url']; ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'forum_sidebar_max' ); ?>"><?php _e('Max shown forum:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'forum_sidebar_max' ); ?>" name="<?php echo $this->get_field_name( 'forum_sidebar_max' ); ?>" value="<?php echo $instance['forum_sidebar_max']; ?>" style="width:100%;" />
        </p>
                  
    <?php
    }    
}
?>