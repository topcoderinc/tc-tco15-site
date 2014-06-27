<?php
/*
 * tco_event_list
 */
function tco_event_list_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
		'limit'	=> 5
	), $atts ) );

	global $wpdb;
		
	$cal_posts = $wpdb->get_results( "
		SELECT      p.*, STR_TO_DATE(pm.meta_value, '%m/%d/%Y') as start_date
		FROM        $wpdb->posts p				
		INNER JOIN  $wpdb->postmeta pm
					ON p.ID = pm.post_id
					AND pm.meta_key = '_cmb_start_date'
		WHERE       p.post_type = 'calendar' 
					AND STR_TO_DATE(meta_value, '%m/%d/%Y') >= '".date('Y-m-d')."'
		ORDER BY    start_date ASC
		LIMIT 		$limit
		" ); 
				
	$html = '';
	
	if ( $cal_posts ) {
		$html = '
			<table class="upcoming-event-list table table-striped table-hover table-responsive">
				<tbody>';
		foreach( $cal_posts as $k=>$v ) {

			$startDate 	= get_post_meta( $v->ID, '_cmb_start_date', true );
			$endDate 	= get_post_meta( $v->ID, '_cmb_end_date', true );
			$cats 		= wp_get_post_terms($v->ID,'category_cal');
			$link 		= get_post_meta( $v->ID, '_cmb_title_link', true );
			
			$condate	= date('F d, Y', strtotime($startDate));
			
			if ($endDate!='') {
				$condate .= ' - ' . date('F d, Y', strtotime($endDate));
			}
			
			$content	= $v->post_content;
			$content	= $content!='' ? $content : $condate;
			
						
			if ( $link!='' ) {
				$title = '<a href="'.$link.'">'. $v->post_title .'</a>';
			} else {
				$title = $v->post_title;	
			}
						
			$html .= '
				<tr>					
					<td>'. $content.' <br />' . $startDate . '</td>
					<td>'. $title . ' - ' . $cats[0]->name.'</td>
				</tr>
			';
			
		}
		$html .= '
				</tbody>
			</table>
		';		
	}
	
	return $html;
}
add_shortcode ( "tco_event_list", "tco_event_list_function" );

