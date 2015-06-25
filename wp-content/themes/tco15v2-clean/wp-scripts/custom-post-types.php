<?php 


/* taxonomies */


add_action( 'init', 'create_hierarchical_taxonomy', 0 );

function create_hierarchical_taxonomy() {
/*
 *  category calendar
 * */
	// Add taxonomy, make it hierarchical like categories
	$name = "Category_cal";
	$labels = array(
			'name' => _x( 'Calendar Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Calendar Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Category' ),
			'all_items' => __( 'All Category' ),
			'parent_item' => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item' => __( 'Edit Category' ),
			'update_item' => __( 'Update Category' ),
			'add_new_item' => __( 'Add New Category' ),
			'new_item_name' => __( 'New Category Name' ),
			'menu_name' => __( 'Category' ),
	);

	// Now register the taxonomy

	register_taxonomy('category_cal',array('calendar'), array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'category_cal' ),
	));

	
	// Add Category Filter
	add_action('restrict_manage_posts','calendar_restrict_manage_posts');
	function calendar_restrict_manage_posts() {
		global $typenow;
		$taxonomy = 'category_cal';
		
		if ($typenow=='calendar'){
			$filters = array($taxonomy);
			foreach ($filters as $tax_slug) {
				$tax_obj = get_taxonomy($tax_slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { 
					$label = (isset($_GET[$tax_slug])) ? $_GET[$tax_slug] : ''; // Fix
					echo '<option value='. $term->slug, $label == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
				}
				echo "</select>";
			}			
		}
	}
	
		
/*
 *  category sponsors
* */
	$name = "Category_spon";
	$labels = array(
			'name' => _x( 'Sponsor Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Sponsor Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Category' ),
			'all_items' => __( 'All Category' ),
			'parent_item' => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item' => __( 'Edit Category' ),
			'update_item' => __( 'Update Category' ),
			'add_new_item' => __( 'Add New Category' ),
			'new_item_name' => __( 'New Category Name' ),
			'menu_name' => __( 'Category' ),
	);
	
	// Now register the taxonomy
	
	register_taxonomy('category_spon',array('sponsor'), array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'category_spon' ),
	));

}


/* custom post type */

add_action ( 'init', 'custom_post_register' );
function custom_post_register() {
	
/* Calendar Post Type */
	$strPostName = 'Calendar';

	$labels = array (
			'name' => _x ( $strPostName . 's', 'post type general name' ),
			'singular_name' => _x ( $strPostName, 'post type singular name' ),
			'add_new' => _x ( 'Add New', $strPostName . ' Post' ),
			'add_new_item' => __ ( 'Add New ' . $strPostName . ' Post' ),
			'edit_item' => __ ( 'Edit ' . $strPostName . ' Post' ),
			'new_item' => __ ( 'New ' . $strPostName . ' Post' ),
			'view_item' => __ ( 'View ' . $strPostName . ' Post' ),
			'search_items' => __ ( 'Search ' . $strPostName ),
			'not_found' => __ ( 'Nothing found' ),
			'not_found_in_trash' => __ ( 'Nothing found in Trash' ),
			'parent_item_colon' => ''
	);

	$args = array (
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 25,
			'menu_icon'           => 'dashicons-calendar-alt',
			'exclude_from_search' => false,
			'show_in_nav_menus' => true,
			'taxonomies' => array (
					'category_cal'
			),
			'supports' => array (
					'title',
					'editor',
					'page-attributes'
			)
	);
	

	register_post_type ( 'calendar', $args );
	
	
	
	add_filter("manage_edit-calendar_columns", "prod_edit_columns");
	add_action("manage_posts_custom_column",  "prod_custom_columns");
	
	function prod_edit_columns($columns){
		$columns = array(
		"title" => "Title",
		"category_cal" => "Category",
		"date" => "Date"
		);

		return $columns;
	}


	function prod_custom_columns($column){
        global $post;
        switch ($column)
        {
            case "category_cal":
                echo get_the_term_list($post->ID, 'category_cal', '', ', ','');
                break;
        }
	}

	
/* Carousel Post Type */	
	$strPostName = 'Carousel';
	
	$labels = array (
			'name' => _x ( $strPostName . 's', 'post type general name' ),
			'singular_name' => _x ( $strPostName, 'post type singular name' ),
			'add_new' => _x ( 'Add New', $strPostName . ' Post' ),
			'add_new_item' => __ ( 'Add New ' . $strPostName . ' Post' ),
			'edit_item' => __ ( 'Edit ' . $strPostName . ' Post' ),
			'new_item' => __ ( 'New ' . $strPostName . ' Post' ),
			'view_item' => __ ( 'View ' . $strPostName . ' Post' ),
			'search_items' => __ ( 'Search ' . $strPostName ),
			'not_found' => __ ( 'Nothing found' ),
			'not_found_in_trash' => __ ( 'Nothing found in Trash' ),
			'parent_item_colon' => ''
	);
	
	$args = array (
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 25,
			'menu_icon'           => 'dashicons-slides',
			'exclude_from_search' => false,
			'show_in_nav_menus' => true,
			'taxonomies' => array (),
			'supports' => array (
					'title',
					'editor',
					'page-attributes',
					'post-formats'
			)
	);
	
	register_post_type ( 'carousel', $args );
	
	
	flush_rewrite_rules ( false );
		
}

// Register Custom Post Type
function travel_form_post_type() {

	$labels = array(
		'name'                => _x( 'Travel Forms', 'Post Type General Name', 'tco' ),
		'singular_name'       => _x( 'Travel Form', 'Post Type Singular Name', 'tco' ),
		'menu_name'           => __( 'Travel Forms', 'tco' ),
		'name_admin_bar'      => __( 'Travel Forms', 'tco' ),
		'parent_item_colon'   => __( 'Parent Item:', 'tco' ),
		'all_items'           => __( 'All Items', 'tco' ),
		'add_new_item'        => __( 'Add New Item', 'tco' ),
		'add_new'             => __( 'Add New', 'tco' ),
		'new_item'            => __( 'New Item', 'tco' ),
		'edit_item'           => __( 'Edit Item', 'tco' ),
		'update_item'         => __( 'Update Item', 'tco' ),
		'view_item'           => __( 'View Item', 'tco' ),
		'search_items'        => __( 'Search Item', 'tco' ),
		'not_found'           => __( 'Not found', 'tco' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tco' ),
	);
	$args = array(
		'label'               => __( 'travel_form', 'tco' ),
		'description'         => __( 'Member\'s Travel Form', 'tco' ),
		'labels'              => $labels,
		'supports'            => array( 'title', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-id-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'travel_form', $args );

}

// Hook into the 'init' action
add_action( 'init', 'travel_form_post_type', 0 );




// Tweet Post Type
function tweet_post_type() {

	$labels = array(
		'name'                => 'Tweet',
		'singular_name'       => 'Tweets',
		'menu_name'           => 'Tweets',
		'parent_item_colon'   => 'Tweet Parent:',
		'all_items'           => 'All Tweets',
		'view_item'           => 'View Tweet',
		'add_new_item'        => 'Add New Tweet',
		'add_new'             => 'Add New Tweet',
		'edit_item'           => 'Edit Tweet',
		'update_item'         => 'Update Tweet',
		'search_items'        => 'Search Tweet',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$args = array(
		'label'               => 'Tweet',
		'description'         => 'Tweets',
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-twitter',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'tweet', $args );
}
add_action( 'init', 'tweet_post_type', 0 );



// Challenges Custom Post Type for leaderboard
function challenges_post_type() {

	$labels = array(
		'name'                => _x( 'Challenges', 'Post Type General Name', 'tco' ),
		'singular_name'       => _x( 'Challenge', 'Post Type Singular Name', 'tco' ),
		'menu_name'           => __( 'Challenges', 'tco' ),
		'name_admin_bar'      => __( 'Challenges', 'tco' ),
		'parent_item_colon'   => __( 'Parent Item:', 'tco' ),
		'all_items'           => __( 'All Items', 'tco' ),
		'add_new_item'        => __( 'Add New Item', 'tco' ),
		'add_new'             => __( 'Add New', 'tco' ),
		'new_item'            => __( 'New Item', 'tco' ),
		'edit_item'           => __( 'Edit Item', 'tco' ),
		'update_item'         => __( 'Update Item', 'tco' ),
		'view_item'           => __( 'View Item', 'tco' ),
		'search_items'        => __( 'Search Item', 'tco' ),
		'not_found'           => __( 'Not found', 'tco' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tco' ),
	);
	$args = array(
		'label'               => __( 'challenge', 'tco' ),
		'description'         => __( 'Challenges for leaderboard computation', 'tco' ),
		'labels'              => $labels,
		'supports'            => array( 'title', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-awards',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'challenge', $args );

}

// Hook into the 'init' action
add_action( 'init', 'challenges_post_type', 0 );


// Register Custom Post Type
function quotes_post_type() {

	$labels = array(
		'name'                => _x( 'Quotes', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Quote', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Quotes', 'text_domain' ),
		'name_admin_bar'      => __( 'Quotes', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'quotes', 'text_domain' ),
		'description'         => __( 'Quotes', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-format-quote',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'quotes', $args );

}

// Hook into the 'init' action
add_action( 'init', 'quotes_post_type', 0 );


// Register Custom Post Type
function membersform_post_type() {

	$labels = array(
		'name'                => _x( 'Members Form', 'Post Type General Name', 'tco' ),
		'singular_name'       => _x( 'Members Form', 'Post Type Singular Name', 'tco' ),
		'menu_name'           => __( 'Members Form', 'tco' ),
		'name_admin_bar'      => __( 'Post Type', 'tco' ),
		'parent_item_colon'   => __( 'Parent Item:', 'tco' ),
		'all_items'           => __( 'All Items', 'tco' ),
		'add_new_item'        => __( 'Add New Item', 'tco' ),
		'add_new'             => __( 'Add New', 'tco' ),
		'new_item'            => __( 'New Item', 'tco' ),
		'edit_item'           => __( 'Edit Item', 'tco' ),
		'update_item'         => __( 'Update Item', 'tco' ),
		'view_item'           => __( 'View Item', 'tco' ),
		'search_items'        => __( 'Search Item', 'tco' ),
		'not_found'           => __( 'Not found', 'tco' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tco' ),
	);
	$args = array(
		'label'               => __( 'membersform', 'tco' ),
		'description'         => __( 'Post Type Description', 'tco' ),
		'labels'              => $labels,
		'supports'            => array( 'title', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-id',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'membersform', $args );

}

// Hook into the 'init' action
add_action( 'init', 'membersform_post_type', 0 );