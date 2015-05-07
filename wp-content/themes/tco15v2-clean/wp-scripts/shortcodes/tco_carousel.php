<?php

/*
 * tco_carousel
 */
function tco_carousel_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"id"		=> 0
	), $atts ) );
	$content = $content == null ? "" : $content;
	
	$args = array (
			'post_type' 		=> 'carousel',
			'posts_per_page' 	=> 1,
			'p' 				=> $id 
	);
	
	$html = '';
	
	$query = new WP_Query ( $args );
	if ($query->have_posts ()) {
		$html = '<div class="winner-banner">';
		while ( $query->have_posts () ) :
			$query->the_post ();
			$html .=  apply_filters ('the_content', get_the_content () );
		endwhile;
		$html .= '</div>';
	}
	
	return $html;
}

add_shortcode ( "tco_carousel", "tco_carousel_function" );
