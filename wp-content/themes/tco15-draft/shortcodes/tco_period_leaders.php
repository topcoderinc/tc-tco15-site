<?php
/*
 * tco_period_leaders
 */
function tco_period_leaders_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"period" 		=> 1,
			"copilot_id"	=> 292,
			"design_id"		=> 364,
			"development_id"=> 480,
			"f2f_id"		=> 549,
			"studio_id"		=> 578,
			"ui_id"			=> 304,
			"wireframe_id"	=> 312

	), $atts ) );	


	$module 	= get_option ('module');
	$sdate		= get_option('evnt_start_p'.$period);
	$edate		= get_option('evnt_end_p'.$period);
	
	// get copilot
	$dsid 		= get_option ('copilot_dsid');
	$c 			= get_option ('copilot_c');
	$url 		= get_bloginfo ('stylesheet_directory' ) . "/includes/copilot.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&sdate=" . $sdate . "&edate=" . $edate;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );	
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR" ) {
		$xml 			= simplexml_load_string ( $response ['body'] );
		$copilot		= $xml->children();
		$copilot_handle = $copilot->row->handle;
	} else {
		$copilot_handle = '';
	}
	
	
	// design
	$dsid 		= get_option ('design_dsid');
	$c 			= get_option ('design_c');
	$cd			= get_option ('design_p'.$period);
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/design.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR") {
		$xml 			= simplexml_load_string ( $response ['body'] );
		$design			= $xml->children();
		$design_handle 	= $design->row->handle;
	} else {
		$design_handle = '';
	}
	
	// development
	$dsid 		= get_option ('dev_dsid');
	$c 			= get_option ('dev_c');
	$cd			= get_option ('dev_p'.$period);
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/development.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR" ) {
		$development		= json_decode($response['body']);
		$development_handle = $development[0]->handle;
	} else {
		$development_handle = '';
	}
	
	
	// first2finish	
	if ( $period==4 ) {
		$dsid 		= 30; //get_option ('mod_dash_dsid'); //enable this in tco15
		$c 			= 'tco_f2f_leaderboard'; // get_option ('mod_dash_c'); // enable this in tco15
		$cd 		= 547;
		$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/f2f.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd;
	} else {
		$dsid 		= get_option ('mod_dash_dsid');
		$c 			= get_option ('mod_dash_c');
		$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/moddash.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&sdate=" . $sdate . "&edate=" . $edate;
	}
	
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR") {
		$xml 		= simplexml_load_string ( $response ['body'] );
		$f2f		= $xml->children();
		$f2f_handle = $f2f->row->handle;
	} else {
		$f2f_handle = '';
	}

	
	// studio
	$dsid 		= get_option ('studio_dsid');
	$c 			= get_option ('studio_c');
	$cd			= get_option ('studio_p'.$period);
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/studio.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR") {
		$xml 			= simplexml_load_string ( $response ['body'] );
		$studio			= $xml->children();
		$studio_handle 	= $studio->row->handle;
	} else {
		$studio_handle = '';
	}
	
	// prototype
	$dsid 		= get_option ('ui_dsid');
	$c 			= get_option ('ui_c');
	$cd			= get_option ('ui_p'.$period);
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/prototype.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR") {
		$xml 				= simplexml_load_string ( $response ['body'] );
		$prototype			= $xml->children();
		$prototype_handle 	= $prototype->row->handle;
	} else {
		$prototype_handle = '';
	}
	
	// wireframe
	$dsid 		= get_option ('wireframe_dsid');
	$c 			= get_option ('wireframe_c');
	$cd			= get_option ('wireframe_p'.$period);
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/wireframe.php?module=" . $module . "&c=" . $c . "&dsid=" . $dsid . "&cd=" . $cd;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	if ( ! is_wp_error ( $response ) && $response ['response'] ['code'] == 200 && substr( $response ['body'], 0, 5 ) != "ERROR") {
		$xml 		= simplexml_load_string ( $response ['body'] );
		$wireframe	= $xml->children();
		$wireframe_handle = $wireframe->row->handle;
	} else {
		$wireframe_handle = '';
	}


	$url_copilot	= get_permalink($copilot_id);
	$url_design		= get_permalink($design_id);
	$url_development= get_permalink($development_id);
	$url_f2f		= get_permalink($f2f_id);
	$url_studio		= get_permalink($studio_id);
	$url_ui			= get_permalink($ui_id);
	$url_wireframe	= get_permalink($wireframe_id);	
	
	$html = '
			<table class="dev-design-leaderboard leaderboard-table table table-striped table-hover table-responsive">
				<thead>
					<tr>
						<th>Track</th>
						<th>Handle</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="'. $url_copilot .'">Copilot</a></td>
						<td><a href="'. $url_copilot .'">'.$copilot_handle.'</a></td>
					</tr>
					<tr>
						<td><a href="'. $url_design .'">Design</a></td>
						<td><a href="'. $url_design .'">'.$design_handle.'</a></td>
					</tr>
					<tr>
						<td><a href="'. $url_development .'">Development</a></td>
						<td><a href="'. $url_development .'">'.$development_handle.'</a></td>
					</tr>
					<tr>
						<td><a href="'. $url_f2f .'">First2Finish</a></td>
						<td><a href="'. $url_f2f .'">'.$f2f_handle.'</a></td>
					</tr>
					<tr>
						<td><a href="'. $url_studio .'">Studio</a></td>
						<td><a href="'. $url_studio .'">'.$studio_handle.'</a></td>
					</tr>
					<tr>
						<td><a href="'. $url_ui .'">UI Prototype</a></td>
						<td><a href="'. $url_ui .'">'.$prototype_handle.'</a></td>
					</tr>
					<tr>
						<td><a href="'. $url_wireframe .'">Wireframe</a></td>
						<td><a href="'. $url_wireframe .'">'.$wireframe_handle.'</a></td>
					</tr>
				</tbody>
			</table>';
	
	return $html;
}

add_shortcode ( "tco_period_leaders", "tco_period_leaders_function" );

