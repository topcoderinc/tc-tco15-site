<?php
/*
 * tco_button
 */
function tco_user_details_function() {
	
	$html		= '';
	$cr 		= $_GET['cr'];
	$cd 		= $_GET['cd'];	

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/development_user.php?cd=" . $cd . "&cr=" . $cr;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if ( is_wp_error($response) || !isset($response['body']) || (isset($response['body']) && $response['body']=='ERROR: 400') ) {
		return '<hr /><div class="alert alert-info">User Data Not Found</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<table class="leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Project Name</th>
							<th class="text-center">Project Version</th>
							<th class="text-center">Submitted Date</th>
							<th class="text-center">Score</th>
							<th class="text-center">Placement</th>
							<th class="text-center">Placement Points</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->project_name.'</td>
						<td class="text-center">'.$row->project_version.'</td>
						<td class="text-center">'.$row->submit_date.'</td>
						<td class="text-center">'.$row->score.'</td>
						<td class="text-center">'.$row->placed.'</td>
						<td class="text-center">'.number_format((float)$row->placement_points, 2).'</td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
}
add_shortcode('tco_user_details', 'tco_user_details_function');
