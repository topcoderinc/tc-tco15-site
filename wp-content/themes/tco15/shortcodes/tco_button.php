<?php
/*
 * tco_button
 */
function tco_button_function($atts, $content = null) {
	extract(
   		shortcode_atts(array(
			'link' 		=> '#',
			'style'		=> 'btn-primary',
			'target'	=> '_self',
			'size'		=> ''
		), $atts));
		
   	return '<a class="btn '.$style.' ' . $size . '" href="'.$link.'" target="'.$target.'"><span>' . do_shortcode($content) . '</span></a>';
}
add_shortcode('tco_button', 'tco_button_function');
