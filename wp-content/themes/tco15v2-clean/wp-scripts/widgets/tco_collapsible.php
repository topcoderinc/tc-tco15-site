<?php
/*
 * tco_collapsible
 */
function tco_collapsible_function($atts, $content = null) {
	extract(
   		shortcode_atts(array(
			'title'	=> ''
		), $atts));
	
	$collapseID = 'collapse-'.uniqid();
	$html = '<div class="panel panel-default">
    			<div class="panel-heading">
      				<h4 class="panel-title">
        				<a data-toggle="collapse" href="#'.$collapseID.'">'.$title.'</a>
      				</h4>
    			</div>
				<div id="'.$collapseID.'" class="panel-collapse collapse in">
					<div class="panel-body">'.apply_filters('the_content', $content).'</div>
    			</div>
  			</div>';
   	return $html;
}
add_shortcode('tco_collapsible', 'tco_collapsible_function');
