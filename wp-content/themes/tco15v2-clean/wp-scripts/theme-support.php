<?php
/**
 * Theme Support
 */
 
// add menu support
add_theme_support( 'menus' );

// add featured thumbnail support
add_theme_support( 'post-thumbnails' );

// add post format support
add_theme_support ( 'post-formats', array (
		'image',
		'video' 
) );

// enables tags on pages
function tags_support_all() {
	register_taxonomy_for_object_type ( 'post_tag', 'page' );
	register_taxonomy_for_object_type ( 'category', 'posts' );
}