<?php
// Add theme CSS files
function load_site_styles() {
	global $wp_styles;
	wp_enqueue_style('bootstrap',  get_template_directory_uri() . '/css/bootstrap.min.css', false, false, 'all');
	wp_enqueue_style('sourcesanspro', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900', false, false, 'all');
	wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', false, false, 'all');
}

// Add theme JS files
function load_site_scripts() {
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true);
	wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('jquery'), false, true);	
}

if(!is_admin()) {
	if (function_exists('load_site_styles')) {
		add_action('wp_enqueue_scripts', 'load_site_styles');
	}
	if (function_exists('load_site_scripts')) {
		add_action('wp_enqueue_scripts', 'load_site_scripts');
	}
}

// Twitter Library
if (! class_exists ( 'TwitterOAuth' )) {
	require_once ("lib/twitteroauth/twitteroauth.php"); // Path to twitteroauth library
}
