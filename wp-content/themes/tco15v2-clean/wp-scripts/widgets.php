<?php 
/**
 * Widget codes
 */
 
include 'widgets/Calendar_widget.php';
include 'widgets/Sponsor_Widget.php';
include 'widgets/Twitter_widget.php';
include 'widgets/Widget_forum.php';
include 'widgets/TCO_Blog_Posts.php';
include 'widgets/TCO_Blog_Category.php';
include 'widgets/TCO_Recent_Post.php';


function tco_load_widgets() {
   register_widget( 'Calendar_widget' );
   register_widget( 'Sponsor_Widget' );
   register_widget( 'Twitter_Widget' );
   register_widget( 'Widget_forum' );
   register_widget( 'TCO_Recent_Post' );
   register_widget( 'TCO_Blog_Posts' );
   register_widget( 'TCO_Blog_Category' );
}

add_action( 'widgets_init', 'tco_load_widgets' );
