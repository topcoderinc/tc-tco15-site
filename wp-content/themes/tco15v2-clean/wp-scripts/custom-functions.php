<?php
/**
 * Custom Function codes
 */
 
function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER ["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER ["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"] . $_SERVER ["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER ["SERVER_NAME"] . $_SERVER ["REQUEST_URI"];
	}
	return $pageURL;
}
function get_page_link_by_slug($page_slug) {
	$page = get_page_by_path ( $page_slug );
	if ($page) :
		return get_permalink ( $page->ID );
	 else :
		return "#";
	endif;
}
function wpb_set_post_views($postID) {
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta ( $postID, $count_key, true );
	if ($count == '') {
		$count = 0;
		delete_post_meta ( $postID, $count_key );
		add_post_meta ( $postID, $count_key, '0' );
	} else {
		$count ++;
		update_post_meta ( $postID, $count_key, $count );
	}
}
function wpb_track_post_views($post_id) {
	if (! is_single ())
		return;
	if (empty ( $post_id )) {
		global $post;
		$post_id = $post->ID;
	}
	wpb_set_post_views ( $post_id );
}
add_action ( 'wp_head', 'wpb_track_post_views' );

/* sidebars */
if (! function_exists ( 'smk_get_all_sidebars' )) {
	function smk_get_all_sidebars() {
		global $wp_registered_sidebars;
		$all_sidebars = array ();
		if ($wp_registered_sidebars && ! is_wp_error ( $wp_registered_sidebars )) {
			
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$all_sidebars [$sidebar ['id']] = $sidebar ['name'];
			}
		}
		return $all_sidebars;
	}
}


/* excerpt */
function new_excerpt_more($more) {
	return '...<p class="text-right">' . '<a href="' . get_permalink ( get_the_ID () ) . '" class="more">Read More</a></p>';
}
add_filter ( 'excerpt_more', 'new_excerpt_more' );
function custom_excerpt_length($length) {
	return 27;
}

function custom_content($new_length = 55) {
	$output = get_the_content ();
	$output = apply_filters ( 'wptexturize', $output );
	$output = substr ( $output, 0, $new_length ) . '...';
	return $output;
}

/* wrap content to $len length content, and add '...' to end of wrapped content */
function wrap_content_strip_html($content, $len, $strip_html = false, $sp = '\n\r', $ending = '...') {
	if ($strip_html) {
		$content = strip_tags ( $content );
		$content = strip_shortcodes ( $content );
	}
	$c_title_wrapped = wordwrap ( $content, $len, $sp );
	$w_title = explode ( $sp, $c_title_wrapped );
	if (strlen ( $content ) <= $len) {
		$ending = '';
	}
	return $w_title [0] . $ending;
}

/* get page id by slug */
function get_ID_by_slug($page_slug) {
	$page = get_page_by_path ( $page_slug );
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

/* function convert category slug to category id */
function getCategoryId($slug) {
	$idObj = get_category_by_slug ( $slug );
	$id = $idObj->term_id;
	return $id;
}

/* set email format to html */
function set_html_content_type() {
	return 'text/html';
}

// Content Trimmer
function trim_content($content, $length = 100) {
	$output = strip_tags($content);
	$output = apply_filters ( 'wptexturize', $output );
	$output = substr ($output, 0, $length );
	$output = substr ($output, 0, strrpos($output, ' '));
	
	if (strlen($content) > $length) {
		$output .= "...";
	} 
	
	return $output;
}