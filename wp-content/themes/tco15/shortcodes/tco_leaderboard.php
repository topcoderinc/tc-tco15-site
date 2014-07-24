<?php
/*
 * tco_leaderboard
 */

// Get table for UI Prototype, Design, and Development
function get_table($track, $period, $dsid, $c, $base) {
	
	$html		= '';
	$vars		= array();
	$module 	= get_option ('module');
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/".$base.".php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
		
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response['body'], 0, 5 ) != "ERROR") {

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
						
			if ( $track=='development' ) {
				
				$arrJson = json_decode($response['body']);
				
				foreach ( $arrJson as $row ) {
					
					$html .= '
						<tr>
							<td><a href="./user-details/?cr='.$row->user_id.'&cd='.$period.'">'.$row->handle.'</a></td>
							<td class="text-center">'.$row->complete_projects.'</td>
							<td class="text-center">'.$row->projects_in_progress.'</td>
							<td class="text-center"><strong>'.number_format((float)$row->placement_points,2).'</strong></td>
						</tr>';
					
					$vars[] = $row;
				}

			} else {
			
				$xml = simplexml_load_string ( $response ['body'] );
				
				
				foreach ( $xml->children() as $row ) {
					
					$html .= '
						<tr>
							<td><a href="./user-details/?cr='.$row->user_id.'&cd='.$period.'">'.$row->handle.'</a></td>
							<td class="text-center">'.$row->complete_projects.'</td>
							<td class="text-center">'.$row->projects_in_progress.'</td>
							<td class="text-center"><strong>'.number_format((float)$row->placement_points,2).'</strong></td>
						</tr>';
					
					$vars[] = $row;
				}
				
			}
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	
	$return['html'] = $html;
	$return['vars'] = $vars;
	return $return;
}


// Get table for Copilot
function get_copilot_table($sdate, $edate) {
	
	$html	= '';
	$module = get_option ('module');
	$dsid 	= get_option ('copilot_dsid');
	$c 		= get_option ('copilot_c');

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/copilot.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&sdate=" . $sdate . "&edate=" . $edate;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
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
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$fulfillment.'</td>
						<td class="text-center"><strong>$'.number_format((float)$row->line_item_amount,2).'</strong></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
	
}

// Old Mod Dash
function get_f2f_table($sdate, $edate) {
	
	$html	= '';
	$module = get_option ('module');
	$dsid 	= get_option ('mod_dash_dsid');
	$c 		= get_option ('mod_dash_c');

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/moddash.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&sdate=" . $sdate . "&edate=" . $edate;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<table class="f2f-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Completed Project</th>
							<th class="text-center">Last Competition</th>
							<th class="text-center">TCO Points</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->num_competitions.'</td>
						<td class="text-center">'.$row->last_competition.'</td>
						<td class="text-center"><strong>'.number_format((float)$row->tco_points,2).'</strong></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
	
}

// First2Finish
function get_f2f_leaderboard($period) {
	
	$html	= '';
	$module = get_option ('module');
	$dsid 	= 30; //get_option ('mod_dash_dsid'); //enable this in tco15
	$c 		= 'tco_f2f_leaderboard'; // get_option ('mod_dash_c'); // enable this in tco15

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/f2f.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<table class="f2f-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Completed Project</th>
							<th class="text-center">TCO Points</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->completed.'</td>
						<td class="text-center"><strong>'.number_format((float)$row->total_points,2).'</strong></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
	
}


// Get table for Copilot
function get_wireframe_table($period) {
	
	$html	= '';
	$module = get_option ('module');
	$dsid 	= get_option ('wireframe_dsid');
	$c 		= get_option ('wireframe_c');

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/wireframe.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<table class="wireframe-leaderboard leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th>Handle</th>
							<th class="text-center">Potential Points</th>
							<th class="text-center">Final Points</th>
						</tr>
					</thead>
					<tbody>
			';
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.number_format((float)$row->potential_points,2).'</td>
						<td class="text-center"><strong>'.number_format((float)$row->final_points,2).'</strong></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
	
}


// Get table for Studio
function get_studio_table($period) {
	
	$html	= '';
	$module = get_option ('module');
	$dsid 	= get_option ('studio_dsid');
	$c 		= get_option ('studio_c');

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/studio.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
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
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->complete_contests.'</td>
						<td class="text-center">'.$row->current_contests.'</td>
						<td class="text-center">'.number_format((float)$row->potential_points,2).'</td>
						<td class="text-center">'.number_format((float)$row->total_potential_points,2).'</td>
						<td class="text-center"><strong>'.number_format((float)$row->points,2).'</strong></td>
					</tr>';
			}	
			
			$html .= '
					</tbody>
				</table>';		
		}
	}
	return $html;
	
}


// Get table for Mashathon
function get_mashathon_table($period) {
	
	$html	= '';
	$module = get_option ('module');
	$dsid 	= get_option ('mashathon_dsid');
	$c 		= get_option ('mashathon_c');

	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/studio.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $period;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return '<hr /><div class="alert alert-info">No leaderboard data yet for this period</div>';
	}
		
	if ($response['response']['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			
			$html = '
				<table class="mashathon-leaderboard leaderboard-table table table-striped table-hover table-responsive">
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
			foreach ( $xml->children() as $row ) {
				
				$html .= '
					<tr>
						<td>'.$row->handle.'</td>
						<td class="text-center">'.$row->complete_contests.'</td>
						<td class="text-center">'.$row->current_contests.'</td>
						<td class="text-center">'.number_format((float)$row->potential_points,2).'</td>
						<td class="text-center">'.number_format((float)$row->total_potential_points,2).'</td>
						<td class="text-center"><strong>'.number_format((float)$row->points,2).'</strong></td>
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
	$module = get_option ('module');
	$dsid 	= get_option ('algo_dsid');
	$c 		= get_option ('algo_c');

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
	$module = get_option ('module');
	$dsid 	= get_option ('marathon_dsid');
	$c 		= get_option ('marathon_c');

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

	switch( $track ) {
		case 'copilot':
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_copilot_table ( get_option('evnt_start_p1'), get_option('evnt_end_p1') ) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_copilot_table ( get_option('evnt_start_p2'), get_option('evnt_end_p2') ) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_copilot_table ( get_option('evnt_start_p3'), get_option('evnt_end_p3') ) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_copilot_table ( get_option('evnt_start_p4'), get_option('evnt_end_p4') ) . '</div>';		
			break;		
			
		case 'wireframe':
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_wireframe_table ( get_option('wireframe_p1') ) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_wireframe_table ( get_option('wireframe_p2') ) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_wireframe_table ( get_option('wireframe_p3') ) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_wireframe_table ( get_option('wireframe_p4') ) . '</div>';		
			break;
		
		case 'algorithm':
			$html = getAlgorithmLeaderboard();
			break;

		case 'marathon':
			$html = getMarathonLeaderboard();
			break;
		
		
		case 'design':
			$dsid 		= get_option ('design_dsid');
			$c 			= get_option ('design_c');	
			$base		= 'design';
			
			$p1_data	= get_table ( $track, get_option ('design_p1'), $dsid, $c, $base );
			$p2_data	= get_table ( $track, get_option ('design_p2'), $dsid, $c, $base );
			$p3_data	= get_table ( $track, get_option ('design_p3'), $dsid, $c, $base );
			$p4_data	= get_table ( $track, get_option ('design_p4'), $dsid, $c, $base );
			
			if ( count($p1_data['vars'])>0 ) {
				foreach( $p1_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}
			if ( count($p2_data['vars'])>0 ) {
				foreach( $p2_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}
			if ( count($p3_data['vars'])>0 ) {
				foreach( $p3_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}
			if ( count($p4_data['vars'])>0 ) {
				foreach( $p4_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}

			foreach ($overall as $val) $tmp[] = $val['placement_points'];
			array_multisort($tmp, SORT_DESC, $overall);

			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . $p1_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period2">' . $p2_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period3">' . $p3_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period4">' . $p4_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="Overall">
					<table class="dev-design-leaderboard leaderboard-table table table-striped table-hover table-responsive">
						<thead>
							<tr>
								<th>Handle</th>
								<th class="text-center">Completed Project</th>
								<th class="text-center">In Progress Projects</th>
								<th class="text-center">Total Points</th>
							</tr>
						</thead>
						<tbody>';

			foreach( $overall as $row ) {
				$tab_content .= '
							<tr>
								<td><a href="./user-details/?cr='.$row['user_id'].'&cd=all">'.$row['handle'].'</a></td>
								<td class="text-center">'.$row['complete_projects'].'</td>
								<td class="text-center">'.$row['projects_in_progress'].'</td>
								<td class="text-center">'.number_format($row['placement_points'],2).'</td>
							</tr>';
			}
			
			$tab_content .= '
						</tbody>
					</table>
				</div>';
				
			break;
			
		case 'development':
			$dsid 		= get_option ('dev_dsid');
			$c 			= get_option ('dev_c');	
			$base		= 'development';
			$p1_data	= get_table ( $track, get_option ('dev_p1'), $dsid, $c, $base );
			$p2_data	= get_table ( $track, get_option ('dev_p2'), $dsid, $c, $base );
			$p3_data	= get_table ( $track, get_option ('dev_p3'), $dsid, $c, $base );
			$p4_data	= get_table ( $track, get_option ('dev_p4'), $dsid, $c, $base );
			
			if ( count($p1_data['vars'])>0 ) {
				foreach( $p1_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}
			if ( count($p2_data['vars'])>0 ) {
				foreach( $p2_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}
			if ( count($p3_data['vars'])>0 ) {
				foreach( $p3_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}
			if ( count($p4_data['vars'])>0 ) {
				foreach( $p4_data['vars'] as $row ) {
					$overall[(string)$row->user_id]['user_id'] 				 = (string)$row->user_id;
					$overall[(string)$row->user_id]['handle'] 				 = (string)$row->handle;
					$overall[(string)$row->user_id]['complete_projects'] 	+= (int)$row->complete_projects;
					$overall[(string)$row->user_id]['projects_in_progress']	+= (int)$row->projects_in_progress;
					$overall[(string)$row->user_id]['placement_points'] 	+= (float)$row->placement_points;
				}
			}

			foreach ($overall as $val) $tmp[] = $val['placement_points'];
			array_multisort($tmp, SORT_DESC, $overall);

			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . $p1_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period2">' . $p2_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period3">' . $p3_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period4">' . $p4_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="Overall">
					<table class="dev-design-leaderboard leaderboard-table table table-striped table-hover table-responsive">
						<thead>
							<tr>
								<th>Handle</th>
								<th class="text-center">Completed Project</th>
								<th class="text-center">In Progress Projects</th>
								<th class="text-center">Total Points</th>
							</tr>
						</thead>
						<tbody>';

			foreach( $overall as $row ) {
				$tab_content .= '
							<tr>
								<td><a href="./user-details/?cr='.$row['user_id'].'&cd=all">'.$row['handle'].'</a></td>
								<td class="text-center">'.$row['complete_projects'].'</td>
								<td class="text-center">'.$row['projects_in_progress'].'</td>
								<td class="text-center">'.number_format($row['placement_points'],2).'</td>
							</tr>';
			}
			
			$tab_content .= '
						</tbody>
					</table>
				</div>';
				
			break;
		
		case 'f2f';
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_f2f_table ( get_option('evnt_start_p1'), get_option('evnt_end_p1') ) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_f2f_table ( get_option('evnt_start_p2'), get_option('evnt_end_p2') ) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_f2f_table ( get_option('evnt_start_p3'), get_option('evnt_end_p3') ). '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_f2f_leaderboard ( get_option('mod_dash_p4') ) . '</div>';		
			break;
			
		case 'studio':
			$dsid 		= get_option ('studio_dsid');
			$c 			= get_option ('studio_c');	
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_studio_table(get_option ('studio_p1')) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_studio_table(get_option ('studio_p2')) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_studio_table(get_option ('studio_p3')) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_studio_table(get_option ('studio_p4')) . '</div>';		
			break;
			
		case 'mashathon':
			$dsid 		= get_option ('mashathon_dsid');
			$c 			= get_option ('mashathon_c');	
			/*
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . get_mashathon_table(get_option ('mashathon_p1')) . '</div>
				<div class="tab-pane fade" 			 id="period2">' . get_mashathon_table(get_option ('mashathon_p2')) . '</div>
				<div class="tab-pane fade" 			 id="period3">' . get_mashathon_table(get_option ('mashathon_p3')) . '</div>
				<div class="tab-pane fade" 			 id="period4">' . get_mashathon_table(get_option ('mashathon_p4')) . '</div>';		
			*/
			$tab_content = '
				<div class="tab-pane fade in active" id="period4">' . get_mashathon_table(get_option ('mashathon_p4')) . '</div>';		
			break;
			
		default: // ui prototype
			$dsid 		= get_option ('ui_dsid');
			$c 			= get_option ('ui_c');	
			$base		= 'prototype';

			$p1_data	= get_table ( $track, get_option ('ui_p1'), $dsid, $c, $base );
			$p2_data	= get_table ( $track, get_option ('ui_p2'), $dsid, $c, $base );
			$p3_data	= get_table ( $track, get_option ('ui_p3'), $dsid, $c, $base );
			$p4_data	= get_table ( $track, get_option ('ui_p4'), $dsid, $c, $base );
						
			$tab_content = '
				<div class="tab-pane fade in active" id="period1">' . $p1_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period2">' . $p2_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period3">' . $p3_data['html'] . '</div>
				<div class="tab-pane fade" 			 id="period4">' . $p4_data['html'] . '</div>';
		
	}
	

	if ($track == "design" || $track=='development') {
		$all_tab = '<li><a href="#Overall">Overall</a></li>';
	}	
	
	if ($track=='mashathon') {
		$html = '
			<h3>Leaderboard</h3>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#period4">Period 4</a></li>
			</ul>
			<div class="tab-content">
				'.$tab_content.'
			</div>';		
	} else {
		if ( $track!='algorithm' && $track!='marathon' ) {
		$html = '
			<h3>Leaderboard</h3>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#period1">Period 1</a></li>
				<li><a href="#period2">Period 2</a></li>
				<li><a href="#period3">Period 3</a></li>
				<li><a href="#period4">Period 4</a></li>
				'.$all_tab.'
			</ul>
			<div class="tab-content">
				'.$tab_content.'
			</div>';
		}
	}
	
	return $html;
}

add_shortcode ( "tco_leaderboard", "tco_leaderboard_function" );

