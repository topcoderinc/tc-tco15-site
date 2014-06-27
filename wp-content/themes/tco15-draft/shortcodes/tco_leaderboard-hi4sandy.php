<?php

/*
 * tco_leaderboard
 */
function get_leadeboard_data($cotest_type, $cd) {
	if ($cotest_type == "algorithm") {
		$dsid = get_option ( 'algo_dsid' );
		$c = get_option ( 'algo_c' );
	}
	if ($cotest_type == "marathon") {
		$dsid = get_option ( 'marathon_dsid' );
		$c = get_option ( 'marathon_c' );
	}
	if ($cotest_type == "mod dash") {
		$dsid = get_option ( 'mod_dash_dsid' );
		$c = get_option ( 'mod_dash_c' );
	}
	if ($cotest_type == "design") {
		$dsid = get_option ( 'design_dsid' );
		$c = get_option ( 'design_c' );
	}
	if ($cotest_type == "development") {
		$dsid = get_option ( 'dev_dsid' );
		$c = get_option ( 'dev_c' );
	}
	if ($cotest_type == "studio") {
		$dsid = get_option ( 'studio_dsid' );
		$c = get_option ( 'studio_c' );
	}
	if ($cotest_type == "ui prototype") {
		$dsid = get_option ( 'ui_dsid' );
		$c = get_option ( 'ui_c' );
	}
	if ($cotest_type == "wireframe") {
		$dsid = get_option ( 'wireframe_dsid' );
		$c = get_option ( 'wireframe_c' );
	}
	// $url = get_bloginfo( 'stylesheet_directory' )."/includes/prototype.php?module=BasicData&c=tco_software_leaderboard&dsid=30&cd=548&start=0&records=10000&sortField=handle";
	$url = get_bloginfo ( 'stylesheet_directory' ) . "/includes/prototype.php?module=" . get_option ( 'module' ) . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd . "&start=0&records=10000&sortField=handle";
	$response = wp_remote_get ( $url );
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return "{Error}";
	}
	if ($response ['response'] ['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			$members = "";
			foreach ( $xml->children () as $member ) {
				$members [] = array (
						'user_id' => ( string ) $member->user_id,
						'handle' => $member->handle,
						'complete_projects' => $member->complete_projects,
						'projects_in_progress' => $member->projects_in_progress,
						'placement_points' => $member->placement_points,
						'complete_contests' => $member->complete_contests,
						'current_contests' => $member->current_contests,
						'potential_points' => $member->potential_points,
						'total_potential_points' => $member->total_potential_points,
						'points' => $member->points 
				);
			}
			$result = json_encode ( $members );
			return json_decode ( $result );
		}
		return "{Error}";
	}
}
function format_val($str) {
	return $str == "" ? "0.00" : $str;
}
global $lAll;
$lAll = "";
function get_table($type, $period) {
	$leaderboard_data = get_leadeboard_data ( $type, $period );
	if ($leaderboard_data != null && $leaderboard_data != "{Error}") {
		
		global $lAll;
		if ($lAll == "") {
			$lAll = array ();
		}
		
		$lb_table = '<table class="table">
			<thead><tr>
	          <th>Handle</th>
	          <th>Completed Project</th>
	          <th>In Progress Projects</th>
	          <th>Total Points</th>
	        </tr></thead><tbody>';
		
		if ($type == "studio") {
			$lb_table = '<table class="table">
			<thead><tr>
	          <th>Handle</th>
	          <th>Complete Contest</th>
	          <th>Current Contest</th>
	          <th>Potential Points</th>
				<th>Total Potential Points</th>
				<th>Total Points</th>
	        </tr></thead><tbody>';
			
			foreach ( $leaderboard_data as $lm ) {
				$lb_table .= '<tr>
				          <td><a href="http://community.topcoder.com/tco14/development/development-user-details/?cr=' . $lm->user_id . '&amp;cd=undefined" style="color: undefined" class="handleName">' . $lm->handle->{"0"} . '</a></td>
				          <td>' . format_val ( $lm->complete_contests->{"0"} ) . '</td>
				          <td>' . format_val ( $lm->current_contests->{"0"} ) . '</td>
				          <td>' . format_val ( $lm->potential_points->{"0"} ) . '</td>
				          <td>' . format_val ( $lm->total_potential_points->{"0"} ) . '</td>
		          		  <td>' . format_val ( $lm->points->{"0"} ) . '</td>
				        </tr>';
				
				// array_push($lAll,array(, , , , ));
			}
		} else {
			foreach ( $leaderboard_data as $lm ) {
				$lb_table .= '<tr>
			          <td><a href="http://community.topcoder.com/tco14/development/development-user-details/?cr=' . $lm->user_id . '&amp;cd=undefined" style="color: undefined" class="handleName">' . $lm->handle->{"0"} . '</a></td>
			          <td>' . $lm->complete_projects->{"0"} . '</td>
			          <td>' . $lm->projects_in_progress->{"0"} . '</td>
			          <td>' . $lm->placement_points->{"0"} . '</td>
			        </tr>';
				if (count ( $lAll [$lm->user_id] ) == 0) {
					$lAll [$lm->user_id] = array (
							'handle' => $lm->handle->{"0"},
							'complete_projects' => $lm->complete_projects->{"0"},
							'projects_in_progress' => $lm->projects_in_progress->{"0"},
							'placement_points' => $lm->placement_points->{"0"} 
					);
				} else {
					$lAll [$lm->user_id] ['complete_projects'] = ( int ) $lm->complete_projects->{"0"} + ( int ) $lAll [$lm->user_id] ['complete_projects'];
					$lAll [$lm->user_id] ['projects_in_progress'] = ( int ) $lm->projects_in_progress->{"0"} + ( int ) $lAll [$lm->user_id] ['projects_in_progress'];
					$lAll [$lm->user_id] ['placement_points'] = ( float ) $lm->placement_points->{"0"} + ( float ) $lAll [$lm->user_id] ['placement_points'];
				}
				
				// array_push($lAll,array(, , , , ));
			}
		}
		
		$lb_table .= '</tbody></table>';
		// $lAll = sort($lAll);
		// var_dump($lAll);
		return $lb_table;
	} else {
		return '<p>Comming Soon</p>';
	}
}
function usortTest($a, $b) {
	// var_dump($a);
	// var_dump($b);
	return ($a ['placement_points'] > $b ['placement_points']) ? - 1 : 1;
}
function get_overall_lb() {
	global $lAll;
	if (count ( $lAll ) == 0) {
		return '<p>Comming soon</p>';
	}
	usort ( $lAll, usortTest );
	
	$ovAllRows = '<table class="table">
			<thead><tr>
	          <th>Handle</th>
	          <th>Completed Project</th>
	          <th>In Progress Projects</th>
	          <th>Total Points</th>
	        </tr></thead><tbody>';
	foreach ( $lAll as $key => $lm ) {
		$ovAllRows .= '<tr>
		          <td><a href="http://community.topcoder.com/tco14/development/development-user-details/?cr=' . $key . '&amp;cd=undefined" style="color: undefined" class="handleName">' . $lm ['handle'] . '</a></td>
		          <td>' . $lm ['complete_projects'] . '</td>
		          <td>' . $lm ['projects_in_progress'] . '</td>
		          <td>' . number_format ( $lm ['placement_points'], 1, '.', '' ) . '</td>
		        </tr>';
	}
	$ovAllRows .= '</tbody></table>';
	return $ovAllRows;
}
function tco_leaderboard_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"track" => "ui prototype" 
	), $atts ) );
	
	$all = false;
	$type = $track;
	if ($type == "algorithm") {
		$p1 = "";
		$p2 = "";
		$p3 = "";
		$p4 = "";
		$c = get_option ( 'algo_c' );
		$dsid = get_option ( 'algo_dsid' );
	}
	if ($type == "marathon") {
		$p1 = "";
		$p2 = "";
		$p3 = "";
		$p4 = "";
		$c = get_option ( 'marathon_c' );
		$dsid = get_option ( 'marathon_dsid' );
	}
	if ($type == "f2f") {
		$p1 = "";
		$p2 = "";
		$p3 = "";
		$p4 = "";
		$c = get_option ( 'mod_dash_c' );
		$dsid = get_option ( 'mod_dash_dsid' );
	}
	if ($type == "design") {
		$p1 = get_option ( 'design_p1' );
		$p2 = get_option ( 'design_p2' );
		$p3 = get_option ( 'design_p3' );
		$p4 = get_option ( 'design_p4' );
		$all = true;
		$c = get_option ( 'design_c' );
		$dsid = get_option ( 'design_dsid' );
	}
	if ($type == "development") {
		$p1 = get_option ( 'dev_p1' );
		$p2 = get_option ( 'dev_p2' );
		$p3 = get_option ( 'dev_p3' );
		$p4 = get_option ( 'dev_p4' );
		$all = true;
		$c = get_option ( 'dev_c' );
		$dsid = get_option ( 'dev_dsid' );
	}
	if ($type == "studio") {
		$p1 = get_option ( 'studio_p1' );
		$p2 = get_option ( 'studio_p2' );
		$p3 = get_option ( 'studio_p3' );
		$p4 = get_option ( 'studio_p4' );
		$c = get_option ( 'studio_c' );
		$dsid = get_option ( 'studio_dsid' );
	}
	if ($type == "ui prototype") {
		$p1 = get_option ( 'ui_p1' );
		$p2 = get_option ( 'ui_p2' );
		$p3 = get_option ( 'ui_p3' );
		$p4 = get_option ( 'ui_p4' );
		$c = get_option ( 'ui_c' );
		$dsid = get_option ( 'ui_dsid' );
	}
	if ($type == "wireframe") {
		$p1 = get_option ( 'wireframe_p1' );
		$p2 = get_option ( 'wireframe_p2' );
		$p3 = get_option ( 'wireframe_p3' );
		$p4 = get_option ( 'wireframe_p4' );
		$c = get_option ( 'wireframe_c' );
		$dsid = get_option ( 'wireframe_dsid' );
	}
	if ($type == "copilot") {
		$p1 = "";
		$p2 = "";
		$p3 = "";
		$p4 = "";
		$c = get_option ( 'copilot_c' );
		$dsid = get_option ( 'copilot_dsid' );
	}
	
	if ($all) {
		$allnt = "<li><a href='#Overall'>Overall</a></li>";
	}
	$rows = "";
	$tl = array (
			$p1,
			$p2,
			$p3,
			$p4 
	);
	for($i = 1; $i < 5; $i ++) {
		$v1 = get_option ( 'evnt_start_p' . $i );
		$v2 = get_option ( 'evnt_end_p' . $i );
		$cls = '';
		if ($i == 1) {
			$cls = ' class="current"';
		}
		
		if ($type == "copilot" || $type == "f2f") {
			$thRows .= '<th' . $cls . '><a href="javascript:;" class="periodBtn" rel="sdate=' . $v1 . '&edate=' . $v2 . '">Period ' . $i . '</a></th>';
		} else {
			$thRows .= '<th' . $cls . '><a href="javascript:;" class="periodBtn" rel="' . $tl [$i - 1] . '">Period ' . $i . '</a></th>';
		}
	}
	
	if ($type == "copilot") {
		$thRows .= '<th> <div class="handle"> <div><input type="text" class="search" placeholder="Search Handle" /> </div> </div> </th>';
		$titleRows .= '<th>Handle</th>
				<th colspan="2">Full Fillment</th>
				<th colspan="2">Amount</th>';
	} else if ($type == "wireframe") {
		$thRows .= '<th> <div class="handle"> <div><input type="text" class="search" placeholder="Search Handle" /> </div> </div> </th>';
		$titleRows = '<th colspan="3">Handle</th>
				<th>Potential Points</th>
				<th>Final Points</th>';
	} else if ($type == "algorithm") {
		
		$thRows = '<th colspan="15" class="handle"> <div class="handle"> <div class="f-left"><input type="text" class="search" placeholder="Search Handle" /> </div> </div> </th>';
		
		$titleRows = '<th>Handle</th>                                     
                                        <th>Rating</th>
                                        <th class="columnTitle">1A</th>
                                        <th class="columnTitle">1B</th>
                                        <th class="columnTitle">1C</th>
                                        <th class="columnTitle">2A</th>
                                        <th class="columnTitle">2B</th>
                                        <th class="columnTitle">2C</th>
                                        <th class="columnTitle">3A</th>
                                        <th class="columnTitle">3B</th>
                                        <th class="columnTitle">S1</th>
                                        <th class="columnTitle">S2</th>
                                        <th class="columnTitle">W</th>
                                        <th class="columnTitle">F</th>';
		
		$colGr = '<colgroup>
					<col width="20%">
					<col width="20%">
				</colgroup>';
	} else if ($type == "design") {
		$thRows .= '<th><a href="javascript:;" class="periodBtn" rel="all">Overall</a></th><th class="handle"> <div class="handle"> <div><input type="text" class="search" placeholder="Search Handle" /> </div> </div> </th>';
		
		$titleRows = '<th colspan="2">Handle</th>
				<th>Completed Project</th>
				<th>In Progress Projects</th>
				<th colspan="2">Total Points</th>';
	} else if ($type == "marathon") {
		$thRows = '<th colspan="6" class="atop"><div class="handle"><div>  <input type="text" class="search" placeholder="Search Handle"> </div> </div></th>';
		
		$titleRows = '<th>Handle</th>
                                        <th>Rating</th>
                                        <th class="columnTitle">Round 1</th>
                                        <th class="columnTitle">Round 2</th>
                                        <th class="columnTitle">Round 3</th>
                                        <th class="columnTitle">Finals</th>';
		$colGr = '<colgroup>
					<col width="20%">
					<col width="20%">
				</colgroup>';
	} else if ($type == "studio") {
		
		$thRows .= '<th colspan="2" class="handle"> <div class="handle"> <div><input type="text" class="search" placeholder="Search Handle" /> </div> </div> </th>';
		
		$titleRows = '<th>Handle</th>
                                        <th>Complete Contest</th>
                                        <th>Current Contest</th>
                                        <th>Potential Points  </th>
                                        <th>Total Potential Points</th>
                                        <th>Total Points</th>';
		$colGr = '<colgroup>
                                    <col width="">
                                    <col width="16.5%">
                                    <col width="16.5%">
                                    <col width="16.5%">
                                    <col width="16.5%">
                                    <col width="16.5%" class="last">
                                </colgroup>';
		
	}else {
		
		$thRows .= '<th colspan="2" class="handle"> <div class="handle"> <div><input type="text" class="search" placeholder="Search Handle" /> </div> </div> </th>';
		
		$titleRows = '<th colspan="2">Handle</th>
				<th>Completed Project</th>
				<th>In Progress Projects</th>
				<th>Total Points</th>';
		
		$colGr = '<colgroup>
					<col width="">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%" class="last">
				</colgroup>';
	}
	
	$html = "";
	$html = '<div class="leadboard">
        		<h2>Leaderboard</h2>
                <script type="text/javascript">
					var cur_c = "' . $c . '";
					var cur_dsid = "' . $dsid . '";
				</script>
                <div class="dataTable view" id="' . $type . '">
                    <div class="pagination  hidden-sm hidden-xs">
                        <div class="left">
                            <span>View</span>
                            <input type="text" class="text viewAmount" value="30"/>
                            <span>at a time starting with</span>
                            <input type="text" class="text startIndex" value="0"/>
                            <a href="javascript:;" class="blueBtn1 goBtn"><span class="buttonMask"><span class="text">GO</span></span></a>
                        </div>
                        <div class="right">
                            <a href="javascript:;" class="prev"><i></i></a>
                            <a href="javascript:;" class="next"><i></i></a>
                        </div>
                    </div>  <!-- end of .pagination -->
            
                    <div class="tableMask">
                        <div class="tableMaskBot">
                            <table cellpadding="0" cellspacing="0">
                                ' . $colGr . '
                                <thead>
                                    <tr class="topTh">
                                           ' . $thRows . '
                                    </tr>
                                    <tr class="botTh">
                                    	' . $titleRows . '
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end of .tableMask -->
                    <p class="showing  hidden-sm hidden-xs">Showing <span class="from">0</span> to <span class="to">0</span> of <span class="total">0</span> Handle</p>
                    <div class="pagination hidden-sm hidden-xs">
                        <div class="left">
                            <span>View</span>
                            <input type="text" class="text viewAmount" value="30"/>
                            <span>at a time starting with</span>
                            <input type="text" class="text startIndex" value="0"/>
                            <a href="javascript:;" class="blueBtn1 goBtn"><span class="buttonMask"><span class="text">GO</span></span></a>
                        </div>
                        <div class="right">
                            <a href="javascript:;" class="prev"><i></i></a>
                            <a href="javascript:;" class="next"><i></i></a>
                        </div>
                    </div>  <!-- end of .pagination -->
					
					<div class="pagination pagination-xs visible-sm visible-xs">  
							<a href="javascript:;" class="prev pull-left"><i></i></a>
							<a href="javascript:;" class="next pull-right"><i></i></a>
							<p class="showingStatus"></p>
						
					</div>  <!-- end of .pagination -->
					<script type="text/javascript">
                        var userDetail = "' . get_permalink ( get_page_by_title ( "Development User Details" ) ) . '";
                        if (userDetail.indexOf("?") >= 0) {
                            userDetail = userDetail + "&cr=";
                        } else {
                            userDetail = userDetail + "?cr=";
                        }
                    </script>
                </div><!-- end of .dataTable -->
            </div>';
	
	return $html;
}

add_shortcode ( "tco_leaderboard", "tco_leaderboard_function" );