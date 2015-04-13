<?php
/*
 * tco_schedule
 */
function tco_schedule_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
		"category" 	=> "",
		"headers"	=> "", 
		"class"		=> "",
		"colwidth"	=> ""
	), $atts ) );
	
	$tco_sch_rows = "";
	$args = array (
		'post_type' 	=> 'calendar',
		'category_cal' 	=> $category,
		'orderby' 		=> 'menu_order',
		'order'			=> 'ASC'
	);


	if ($headers=='')  {				
		$th = '<th colspan="2">'.$category.'</th>';	
	} else {
		$arrHeaders = explode(",", $headers);
		if ( $arrHeaders ) {
			$th = '';
			foreach( $arrHeaders as $k=>$v ) {
				$th .= '<th width="'.$colwidth.'">'.trim($v).'</th>';
			}
		}
	}

	$tco_sch = new WP_Query ( $args );
	if ($tco_sch->have_posts ()) {
		while ( $tco_sch->have_posts () ) :
			$tco_sch->the_post ();
			
			$pid = $tco_sch->post->ID;
			$con = get_the_content();
			if ($con == "") {
				$startDate = get_post_meta ( $pid, '_cmb_start_date', true );				
				$con = date('F d, Y', strtotime($startDate));
				
				$arrStartDate = explode(" ", $startDate);
				if ( count($arrStartDate)>1 ) {
					$con .= " " . $arrStartDate[1];
				}
								
				$endDate = get_post_meta ( $pid, '_cmb_end_date', true );
				if ($endDate != null && $endDate != "") {
					$con .= " - " . date('F d, Y', strtotime($endDate));

					$arrEndDate = explode(" ", $endDate);
					if ( count($arrEndDate)>1 ) {
						$con .= " " . $arrEndDate[1];
					}
				}
			}
			
			$link = get_post_meta ( $pid, '_cmb_title_link', true );
			
			if ( $link!='' ) {
				$title = '<a href="'.$link.'">'. get_the_title() .'</a>';
			} else {
				$title = get_the_title();	
			}
			
			$tco_sch_rows .= '<tr>
					<td width="'.$colwidth.'">' . $title . '</td>
					<td width="'.$colwidth.'">' . $con . '</td>';
			if ( isset($arrHeaders) && count($arrHeaders)>2 ) {		
				for( $ctr=1; $ctr <= (count($arrHeaders)-2); $ctr++) {
					$tco_sch_rows .= "<td>". get_post_meta( $pid, '_cmb_extra_column_' . $ctr, true ) ."</td>";
				}
			}
			
			$tco_sch_rows .= "</tr>";
		endwhile
		;
	}
	
	$class = $class . " " . str_replace(" ", "-", strtolower($category));
	
	$html = '';
	$html .= '<table class="table '.$class.'">
			    <thead>
					<tr>
					' .$th . '
					</tr>
				</thead>
			  	<tbody>
			  		' . $tco_sch_rows . '
			  	</tbody>
			  </table>';
	
	return $html;
}
add_shortcode ( "tco_schedule", "tco_schedule_function" );


