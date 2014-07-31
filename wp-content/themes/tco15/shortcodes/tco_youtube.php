<?php
/*
 * tco_youtube
 */
function tco_youtube_function($atts) {
	extract(
   		shortcode_atts(array(
			'src' 		=> '#'
		), $atts));
		
   	return '<div class="embed-container"><iframe src="'.$src.'" frameborder="0" allowfullscreen></iframe></div>';
}
add_shortcode('tco_youtube', 'tco_youtube_function');
