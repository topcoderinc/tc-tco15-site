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
			'menu_position' => 5,
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
			'menu_position' => 5,
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
	
/* Sponsors Post Type */
	$strPostName = 'Sponsor';
	
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
			'capability_type' => 'page',
			'hierarchical' => true,
			'menu_position' => 5,
			'exclude_from_search' => false,
			'show_in_nav_menus' => true,
			'taxonomies' => array (
					'category_spon'
			),
			'supports' => array (
					'title',
					'editor',
					'page-attributes',
					'thumbnail'
			)
	);
	
	register_post_type ( 'sponsor', $args );
	
	flush_rewrite_rules ( false );
		
}


// Member Post Type
function member_post_type() {

	$labels = array(
		'name'                => 'Members',
		'singular_name'       => 'Member',
		'menu_name'           => 'Members',
		'parent_item_colon'   => 'Member Parent:',
		'all_items'           => 'All Members',
		'view_item'           => 'View Member',
		'add_new_item'        => 'Add New Member',
		'add_new'             => 'Add New Member',
		'edit_item'           => 'Edit Member',
		'update_item'         => 'Update Member',
		'search_items'        => 'Search Member',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$args = array(
		'label'               => 'member',
		'description'         => 'Member\'s information and photos',
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'member', $args );
}
add_action( 'init', 'member_post_type', 0 );


// Staff Post Type
function staff_post_type() {

	$labels = array(
		'name'                => 'Staff',
		'singular_name'       => 'Staff',
		'menu_name'           => 'Staff',
		'parent_item_colon'   => 'Staff Parent:',
		'all_items'           => 'All Staff',
		'view_item'           => 'View Staff',
		'add_new_item'        => 'Add New Staff',
		'add_new'             => 'Add New Staff',
		'edit_item'           => 'Edit Staff',
		'update_item'         => 'Update Staff',
		'search_items'        => 'Search Staff',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$args = array(
		'label'               => 'Staff',
		'description'         => 'Staff information and photos',
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'staff', $args );
}
add_action( 'init', 'staff_post_type', 0 );


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
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'tweet', $args );
}
add_action( 'init', 'tweet_post_type', 0 );