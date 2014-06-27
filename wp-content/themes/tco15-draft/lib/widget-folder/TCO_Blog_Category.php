<?php

/**
 * a widget to show Sponsor single item in sidebar
 * 
 */


function get_archives_count_of_category($cat, $exclude) {
	global $wpdb, $wp_locale;
	$cat_id = $cat->cat_ID;
	
	$query = "SELECT count(distinct ID) as posts FROM $wpdb->posts as a,  $wpdb->term_relationships as b WHERE a.ID = b.object_id and a.post_type = 'post' and a.post_status = 'publish' and b.term_taxonomy_id = " . $cat_id . " and a.ID NOT IN (SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = " . $exclude . ")";
	$key = md5($query);
	$arcresults = $wpdb->get_results($query);
	$cache[ $key ] = $arcresults;
	
	if ( $arcresults ) {
		$afterafter = $after;
		foreach ( (array) $arcresults as $arcresult ) {
			$output = intval($arcresult->posts);
			return $output;
		}
	}
	return 0;
}
global $glCount;
/**
 * Create HTML list of categories.
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class Walker_Widget_Category extends Walker {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args Will only append content if style argument value is 'list'.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args Will only append content if style argument value is 'list'.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int $depth Depth of category in reference to parents.
	 * @param array $args
	 */
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);
		
		
		global $glCount;
		
		$ex = get_category_by_slug('topnews');
		$count = get_archives_count_of_category($category, $ex->cat_ID);
		if ($category->slug == 'topnews' || $count < 1) {
			return;
		}
		$glCount++;
		
		$cat_name = esc_attr( $category->name );
		
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$link = '<a href="' . esc_url( get_term_link($category) ) . '" ';
		
		
		if ( $use_desc_for_title == 0 || empty($category->description) )
			$link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '"';
		else
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		$link .= '>';
		$link .= $cat_name;

		if ( !empty($show_count) )
			$link .= ' (<span>' . $count . '</span>)';

		$link .= '</a>';
		if ($glCount % 2 == 1) {
			
			
			$output .= "\t<tr><td";
			$output .= ">$link</td>\n";
		} else {
			$output .= "\t<td>$link</td></tr>\n";
		}
	}

	/**
	 * @see Walker::end_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Not used.
	 * @param int $depth Depth of category. Not used.
	 * @param array $args Only uses 'list' for whether should append to output.
	 */
	function end_el( &$output, $page, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$output .= "</li>\n";
	}

}

class TCO_Blog_Category extends WP_Widget {
    /**
     * set up widget
     * 
     */
    function TCO_Blog_Category() {
        /* Widget settings. */
        $widget_ops = array( 
            'classname' => 'TCO_Blog_Category', 
            'description' => __('manage sponsor list', 'tco_blog_category') );

        /* Widget control settings. */
        $control_ops = array( 
            'width' => 162, 
            'height' => 300, 
            'id_base' => 'tco_blog_category' 
        );

        /* Create the widget. */
        $this->WP_Widget( 
            'tco_blog_category', 
            __('TCO_Blog_Category Widget', 'tco_blog_category'), 
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
<div class="blogCates">
	<h3><?php echo $title; ?> <a href="javascript:;"></a></h3>
    <table>
        <colgroup>
            <col width="50%">
            <col width="50%">
        </colgroup>
		<?php 
		global $glCount;
		$glCount = 0;
		$args = array(
			'orderby'		=> 'name',
			'show_count'	=> 1,
			'title_li'		=> '',
			'walker'        => new Walker_Widget_Category
		);
		wp_list_categories($args); 
		?>
        
        <tbody>
        </tbody>
    </table>
</div><!-- end of .blogCates -->
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
            'title' => __('BLOG CATEGORIES', 'hybrid')
        );
        $instance = wp_parse_args( (array) $instance, $defaults );?>
        

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Blog Category Title:', 'hybrid'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>      
    <?php
    }    
}
?>