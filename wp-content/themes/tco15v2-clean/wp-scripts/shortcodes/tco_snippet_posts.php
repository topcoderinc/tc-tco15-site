<?php

/*
 * tco_snippet_posts
 */
function posts_where( $where ) {
	global $intFromID;
	$where .= " AND ID < $intFromID";
	return $where;
}
function tco_snippet_posts_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"category" 	=> "",
			"limit" 	=> 1,
			"from_id"	=> 0
	), $atts ) );
	
	$args = array (
			'posts_per_page'	=> $posts_per_page,
			'orderby'			=> 'date',
			'order'				=> 'DESC',
			'category'			=> $category
	);	
	
	if ( $from_id>0 ) {
		global $intFromID;
		$intFromID = $from_id;
		add_filter( 'posts_where' , 'posts_where' );		
	}
	
	$post_query = new WP_Query ( $args );
	$html = '';
	if ($post_query->have_posts ()) {
		$ctr = 1;
		$html = '<h3>More Interesting Articles</h3>';
		while ( $post_query->have_posts () ) :
			$post_query->the_post ();
			
			$content = get_the_excerpt();
			
			$html .= '<section class="section snippets">
				<h5><strong><a href="'.get_permalink().'">'. get_the_title().'</a></strong></h5>
				<div class="meta">
					Posted by <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author_meta( 'display_name' ).'</a> on '. get_the_time('l , F jS, Y \a\t g:i a').'
				</div>
				<div class="post-content">' . apply_filters('the_content', $content) . '</div>
			</section>';
		endwhile;
				
	}		
	
	return $html;
}
add_shortcode ( "tco_snippet_posts", "tco_snippet_posts_function" );


