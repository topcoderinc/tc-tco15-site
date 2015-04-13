<?php
/*
 * tco_button
 */
function tco_user_details_function() {
	global $site_options;
	
	$html		= '';
	
	$module 	= $site_options['module'];
	$dsid 		= $site_options['dev_dsid'];
	$c 			= $site_options['dev_c_user'];	
	$cr 		= $_GET['cr'];
	$cd 		= $_GET['cd'];	

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/development_user.php?cd=$cd&cr=$cr&module=$module&dsid=$dsid&c=$c";
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	

	// If error
	if ( is_wp_error ( $response ) ) {
		$return['html'] = '<hr /><div class="alert alert-danger">'. $response->get_error_message() .'</div>';
		$return['vars'] = false;
		return $return;
	}

	// If no Result
	if (! isset ( $response['body'] ) || $response['body']=='[]' ) {
		$return['html'] = '<hr /><div class="alert alert-info">No Challenge Details for this User</div>';
		$return['vars'] = false;
		return $return;
	}
	
	if ($response['response']['code'] == 200) {
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
	return $html;
}
add_shortcode('tco_user_details', 'tco_user_details_function');
