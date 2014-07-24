<?php
/*
 * tco_button
 */
function tco_field_function($atts, $content = null) {
	extract(
   		shortcode_atts(array(
			'label'		=> '',
			'type'		=> 'text'
		), $atts));
		
	$html = '
		<div class="form-group">
			
		</div>';
	
	
   	return $html;
}

add_shortcode('tco_field', 'tco_field_function');
