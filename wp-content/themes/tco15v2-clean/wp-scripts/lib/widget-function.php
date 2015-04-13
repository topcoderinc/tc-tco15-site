<?php

include 'widget-folder/Sponsor_Widget.php';
include 'widget-folder/TCO_Recent_Post.php';
include 'widget-folder/Tweet_Fetcher.php';
include 'widget-folder/Forum.php';
include 'widget-folder/TCO_Blog_Posts.php';
include 'widget-folder/TCO_Blog_Category.php';
include 'widget-folder/Banner.php';


if ( function_exists('register_sidebar') ) {
	 /*
     * Board dirctors single page sidebar
     */
    register_sidebar(array(
        'name' => 'Index Bottom Bar',
		'id'   => 'index_bar',
        'description' => 'Index page\'s bottom bar',
        'before_widget' => '',
        'after_widget' => ''
    ));
    register_sidebar(array(
        'name' => 'Alt Siderbar',
		'id'   => 'alt_board',
        'description' => 'Altnative side bar',
        'before_widget' => '',
        'after_widget' => ''
    ));
    register_sidebar(array(
        'name' => 'Overview Sidebar',
		'id'   => 'overview_board',
        'description' => 'Overview Sidebar',
        'before_widget' => '',
        'after_widget' => ''
    ));
    register_sidebar(array(
        'name' => 'Blog Sidebar',
		'id'   => 'blog_board',
        'description' => 'Blog Page Sidebar',
        'before_widget' => '',
        'after_widget' => ''
    ));
    register_sidebar(array(
        'name' => 'Banner Sidebar',
		'id'   => 'banner_board',
        'description' => 'Sidebar in About page',
        'before_widget' => '',
        'after_widget' => ''
    ));
    register_sidebar(array(
        'name' => 'Poster Sidebar',
		'id'   => 'poster_board',
        'description' => 'Sidebar in Poster Design page',
        'before_widget' => '',
        'after_widget' => ''
    ));
}

/**
 * Add function to widgets_init that'll load our widgets.
 */
add_action( 'widgets_init', 'csstem_load_widgets' );



function csstem_load_widgets() {
   register_widget( 'Sponsor_Widget' );
   register_widget( 'TCO_Recent_Post' );
   register_widget( 'Tweet_Fetcher' );
   register_widget( 'Forum' );
   register_widget( 'TCO_Blog_Posts' );
   register_widget( 'TCO_Blog_Category' );
   register_widget( 'Banner' );
}


?>