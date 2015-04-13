<?php
/*
 * tco_leaderboard
 */

// Get table for Development
function get_table($period, $dsid, $c) {
	global $site_options;
	$html		= '';
	$vars		= array();
	$module 	= $site_options['module'];
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/base.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );

	// If error
	if ( is_wp_error ( $response ) ) {
		$return['html'] = '<hr /><div class="alert alert-danger">'. $response->get_error_message() .'</div>';
		$return['vars'] = false;
		return $return;
	}

	// If no Result
	if (is_wp_error ( $response ) || ! isset ( $response['body'] ) || $response['body']=='[]' ) {
		$return['html'] = '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
		$return['vars'] = false;
		return $return;
	}
	
	if ($response['response']['code'] == 200) {
		$html = '
			<table class="dev-design-leaderboard leaderboard-table table table-striped table-hover table-responsive">
				<thead>
					<tr>
						<th>Handle</th>
						<th class="text-center">Completed Project</th>
						<th class="text-center">In Progress Projects</th>
						<th class="text-center">Total Points</th>
					</tr>
				</thead>
				<tbody>
		';
					
		$arrJson = json_decode($response['body']);
		
		foreach ( $arrJson as $row ) {			
			$placement_points = (array)$row->placement_points;
			$html .= '
				<tr>
					<td><a href="./user-details/?cr='.$row->user_id.'&cd='.$period.'">'.$row->handle.'</a></td>
					<td class="text-center">'.$row->complete_projects.'</td>
					<td class="text-center">'.$row->projects_in_progress.'</td>
					<td class="text-center"><strong>'.number_format($placement_points[0],2).'</strong></td>
				</tr>';			
			$vars[] = $row;
		}
		
		$html .= '
				</tbody>
			</table>';		
		
	}
	
	$return['html'] = $html;
	$return['vars'] = $vars;
	return $return;
}


// Get table for Studio, IA, and Prototype
function get_studio_table($period, $dsid, $c) {
	
	global $site_options;
	$html		= '';
	$module 	= $site_options['module'];
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/base.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	// If error
	if ( is_wp_error ( $response ) ) {
		return '<hr /><div class="alert alert-danger">'. $response->get_error_message() .'</div>';
	}

	// If no Result
	if (is_wp_error ( $response ) || ! isset ( $response['body'] ) || $response['body']=='[]' ) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	
	if ($response['response']['code'] == 200) {
		$html = '
				<table class="studio-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Completed Challenge</th>
							<th class="text-center">Current Challenge</th>
							<th class="text-center">Potential Points</th>
							<th class="text-center">Total Potential Points</th>
							<th class="text-center">Total Points</th>
						</tr>
					</thead>
					<tbody>
		';
					
		$arrJson = json_decode($response['body']);
		usort($arrJson, function($a, $b) {
			return $b->points - $a->points;
		});			
		
		foreach ( $arrJson as $row ) {
			$current_contests = (array)$row->current_contests;
			$potential_points = (array)$row->potential_points;
			$total_potential_points = (array)$row->total_potential_points;
			$points = (array)$row->points;
			
			$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->complete_contests.'</td>
						<td class="text-center">'. number_format($current_contests[0],0).'</td>
						<td class="text-center">'. number_format($potential_points[0],2).'</td>
						<td class="text-center">'. number_format($total_potential_points[0],2).'</td>
						<td class="text-center"><strong>'.number_format($points[0],2).'</strong></td>
					</tr>';			
		}
		
		$html .= '
				</tbody>
			</table>';		
		
	}
	
	return $html;
	
}


// Get table for Copilot
function get_copilot_table($sdate, $edate) {
	global $site_options;
	
	$html	= '';
	$module = $site_options['module'];
	$dsid 	= $site_options['copilot_dsid'];
	$c 		= $site_options['copilot_c'];

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/copilot.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&sdate=" . $sdate . "&edate=" . $edate;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	// If error
	if ( is_wp_error ( $response ) ) {
		return '<hr /><div class="alert alert-danger">'. $response->get_error_message() .'</div>';
	}

	// If no Result
	if (is_wp_error ( $response ) || ! isset ( $response['body'] ) || $response['body']=='[]' ) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
	

	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<table class="copilot-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Fulfillment</th>
							<th class="text-center">Amount</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				$fulfillment = $row->fulfillment!='' ? $row->fulfillment.'%' : 'N/A';
				$line_item_amount = (array)$row->line_item_amount;
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$fulfillment.'</td>
						<td class="text-center"><strong>$'.number_format($line_item_amount[0],2).'</strong></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}	
	
	return $html;
	
}



// Get table for Algorithm
function getAlgorithmLeaderboard() {
	$html	= '';
	$module = $site_options['module'];
	$dsid 	= $site_options['algo_dsid'];
	$c 		= $site_options['algo_c'];

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/algo_overview.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid;
	$response 	= wp_remote_get ( $url, array('timeout'=>300) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<h3>Leaderboard</h3>
				<table class="algorithm-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Rating</th>
							<th class="text-center">1A</th>
							<th class="text-center">1B</th>
							<th class="text-center">1C</th>
							<th class="text-center">2A</th>
							<th class="text-center">2B</th>
							<th class="text-center">2C</th>
							<th class="text-center">3A</th>
							<th class="text-center">3B</th>
							<th class="text-center">S1</th>
							<th class="text-center">S2</th>
							<th class="text-center">W</th>
							<th class="text-center">F</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->rating.'</td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round1a.'">'.$row->round1a.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round1b.'">'.$row->round1b.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round1c.'">'.$row->round1c.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round2a.'">'.$row->round2a.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round2b.'">'.$row->round2b.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round2c.'">'.$row->round2c.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round3a.'">'.$row->round3a.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round3b.'">'.$row->round3b.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->semi1.'">'.$row->semi1.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->semi2.'">'.$row->semi2.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->wildcard.'">'.$row->wildcard.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->final.'">'.$row->final.'</span></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
}


// Get table for Marathon
function getMarathonLeaderboard() {
	$html	= '';
	$module = $site_options['module'];
	$dsid 	= $site_options['marathon_dsid'];
	$c 		= $site_options['marathon_c'];

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/marathon.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid;
	$response 	= wp_remote_get ( $url, array('timeout'=>300) );
	
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] ) || $response ['body']=='ERROR: 404') {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this track</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<h3>Leaderboard</h3>
				<table class="marathon-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Rating</th>
							<th class="text-center">Round 1</th>
							<th class="text-center">Round 2</th>
							<th class="text-center">Round 3</th>
							<th class="text-center">Finals</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->rating.'</td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round1.'">'.$row->round1.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round2.'">'.$row->round2.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->round3.'">'.$row->round3.'</span></td>
						<td class="text-center"><span class="roundAlgo roundAlgo-'.$row->final.'">'.$row->final.'</span></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
}



function tco_leaderboard_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"track" => "ui prototype" 
	), $atts ) );	
	
	global $site_options;

	switch( $track ) {
		case 'copilot':
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_copilot_table ( date('Y-m-d', strtotime($site_options['evnt_start_p1'])), date('Y-m-d', strtotime($site_options['evnt_end_p1'])) ) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_copilot_table ( date('Y-m-d', strtotime($site_options['evnt_start_p2'])), date('Y-m-d', strtotime($site_options['evnt_end_p2'])) ) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_copilot_table ( date('Y-m-d', strtotime($site_options['evnt_start_p3'])), date('Y-m-d', strtotime($site_options['evnt_end_p3'])) ) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_copilot_table ( date('Y-m-d', strtotime($site_options['evnt_start_p4'])), date('Y-m-d', strtotime($site_options['evnt_end_p4'])) ) . '</div>';		
			break;		
			
					
		case 'algorithm':
			$html = getAlgorithmLeaderboard();
			break;


		case 'marathon':
			$html = getMarathonLeaderboard();
			break;
			
		case 'development':
			
			$dsid 		= $site_options['dev_dsid'];
			$c 			= $site_options['dev_c'];	
			
			$p1_data	= get_table ( $site_options['dev_p1'], $dsid, $c );
			$p2_data	= get_table ( $site_options['dev_p2'], $dsid, $c );
			$p3_data	= get_table ( $site_options['dev_p3'], $dsid, $c );
			$p4_data	= get_table ( $site_options['dev_p4'], $dsid, $c );

			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . $p1_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period2">' . $p2_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period3">' . $p3_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period4">' . $p4_data['html'] . '</div>';				
			break;
		
		case 'studio':
			$dsid 		= $site_options['studio_dsid'];
			$c 			= $site_options['studio_c'];	

			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_studio_table($site_options['studio_p1'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_studio_table($site_options['studio_p2'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_studio_table($site_options['studio_p3'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_studio_table($site_options['studio_p4'], $dsid, $c) . '</div>';		
			break;
			
		case 'ia': // information architecture
			$dsid 		= $site_options['ia_dsid'];
			$c 			= $site_options['ia_c'];	

			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_studio_table($site_options['ia_p1'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_studio_table($site_options['ia_p2'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_studio_table($site_options['ia_p3'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_studio_table($site_options['ia_p4'], $dsid, $c) . '</div>';		
		
			break;
						
		default: // prototype
			$dsid 		= $site_options['prototype_dsid'];
			$c 			= $site_options['prototype_c'];	

			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_studio_table($site_options['prototype_p1'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_studio_table($site_options['prototype_p2'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_studio_table($site_options['prototype_p3'], $dsid, $c) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_studio_table($site_options['prototype_p4'], $dsid, $c) . '</div>';			
	}
	
	
	if ( $track!='algorithm' && $track!='marathon' ) {
		$html = '
			<h3>Leaderboard</h3>
			<ul class="nav nav-tabs nav-justified">
				<li class="active"><a href="#period1">Period 1</a></li>
				<li><a href="#period2">Period 2</a></li>
				<li><a href="#period3">Period 3</a></li>
				<li><a href="#period4">Period 4</a></li>
			</ul>
			<div class="tab-content">
				'.$tab_content.'
			</div>';
	}
	
	return $html;
}

add_shortcode ( "tco_leaderboard", "tco_leaderboard_function" );

