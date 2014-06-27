<?php
/*
 * tco_registrants
 */
function tco_registrants_function($atts, $content = null) {
	$dsid 	= get_option ( 'reg_setting_dsid' );
	$eid	= get_option ( 'evnt_id' );	
	$c		= get_option ( 'reg_setting_c' );	
	
	$url 		= get_bloginfo ( 'stylesheet_directory' ) . "/includes/registrants.php?module=" . get_option ( 'module' ) . "&eid=" . $eid . "&dsid=" . $dsid . "&c=".$c;
	$response 	= wp_remote_get ( $url, array('timeout'=>60) );
	$return 	= '';
	
	if (is_wp_error ( $response ) || ! isset ( $response ['body'] )) {
		return "{Error}";
	}
	if ($response ['response'] ['code'] == 200) {
		if (substr ( $response ['body'], 0, 5 ) != "ERROR") {
			$xml = simplexml_load_string ( $response ['body'] );
			$result = '<table class="table">
							<thead>
								<th>Handle</th>
							</thead>
							<tbody>';
			foreach ( $xml->children() as $value ) {
				$result .= '	<tr>
									<td><a href="http://www.topcoder.com/tc?module=MemberProfile&cr='.$value->user_id.'" style="color:'.$value->handlecolor.'">'.$value->handle.'</a></td>
								</tr>';
			}
			$result .= '	</tbody>
						</table>';
		}
	}
	return $result;
}
add_shortcode ( "tco_registrants", "tco_registrants_function" );


