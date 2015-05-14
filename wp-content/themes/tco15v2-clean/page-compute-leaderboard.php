<?php
	
	global $current_user;
	get_currentuserinfo(); 
	
	// TO DO: only admin user should have access on this tool
	
	$period 		= $_GET['period'];
	$track			= $_GET['track'];
	$action			= $_GET['action'];
	$eventName		= 'tco15';
	$strPermalink	= get_the_permalink();
	
	// period dates
	$dateStart[1] 	= '2014-08-01';
	$dateEnd[1] 	= '2014-09-30';
	
	$dateStart[2] 	= '2014-10-01';
	$dateEnd[2] 	= '2014-12-31';
	
	$dateStart[3] 	= '2015-01-01';
	$dateEnd[3] 	= '2015-03-31';
	
	$dateStart[4] 	= '2015-04-01';
	$dateEnd[4] 	= '2015-06-30';

	if ( $period>0 && $period<5 ) {
		
		// get and save list of challenges
		if ( $action!='details' ) {
			$start		= date('Y-m-d', strtotime($dateStart[$period] . ' -1 month'));
			$end		= date('Y-m-d', strtotime($dateEnd[$period] . ' +1 month'));
			switch ( $track ) {
				case 'development':
					$url = 'http://api.topcoder.com/v2/challenges/past?type=develop&submissionEndFrom='.$start.'&submissionEndTo='.$end.'&pageSize=100000&challengeType=Design,Development,Assembly%20Competition,Test%20Suites,Test%20Scenarios,Code';
					break;
					
				case 'ia':
					$url = 'http://api.topcoder.com/v2/challenges/past?type=design&submissionEndFrom='.$start.'&submissionEndTo='.$end.'&pageSize=100000&challengeType=Wireframes';
					break;
					
				case 'ui-design':
					$url = 'http://api.topcoder.com/v2/challenges/past?type=design&submissionEndFrom='.$start.'&submissionEndTo='.$end.'&pageSize=100000&challengeType=Logo%20Design,Print/Presentation,Web%20Design,Application%20Front-End%20Design,Banners/Icons,Widget%20or%20Mobile%20Screen%20Design,Front-End%20Flash';
					break;
					
				case 'prototype':
					$url = 'http://api.topcoder.com/v2/challenges/past?type=develop&submissionEndFrom='.$start.'&submissionEndTo='.$end.'&pageSize=100000&challengeType=UI%20Prototype%20Competition,Architecture,Conceptualization,Specification';
					break;
					
				default: 
					$url = '';
			}
			
			
			$json 	= file_get_contents($url);
			$obj 	= json_decode($json);
			
			if( isset($obj->total) && $obj->total>0 ) {
				foreach($obj->data as $k=>$challenge) {
					
					if ( strtotime($challenge->registrationStartDate)>=strtotime($dateStart[$period].'T00:00:00.000-0400') &&
						 strtotime($challenge->registrationStartDate)<=strtotime($dateEnd[$period].'T23:59:59.999-0400') && 
						 $challenge->eventName==$eventName && 
						 $challenge->status=='Completed') {
							 
	
						// search if challenge already existing
						$args = array (
							'post_type'              => 'challenge',
							'post_status'            => 'publish',
							'posts_per_page'         => 1,
							'meta_query'             => array(
								array(
									'key'       => 'challenge_id',
									'value'     => $challenge->challengeId,
								),
							),
						);
						
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
								$wp_challenge_id = get_the_ID();
							}
						} else {
							$wp_challenge_id = 0;
						}
						wp_reset_postdata();
						
						
						// insert to wp if not found
						if ( $wp_challenge_id==0 ) {
							$postdata = array(
								'post_title'			=> $challenge->challengeName,
								'post_status'           => 'publish', 
								'post_type'             => 'challenge',
								'post_author'           => $current_user->ID
							);
							$post_id = wp_insert_post( $postdata, $wp_error );
							
							// add custom fields
							if ($post_id>0) {
								add_post_meta($post_id, 'challenge_id', $challenge->challengeId, true);
								add_post_meta($post_id, 'track', $track, true);
								add_post_meta($post_id, 'period', $period, true);
							}
						}
						
						$challenges[] = $challenge;
					}
				}
			}
			
			// get total number of challenge to process
			$args = array (
				'post_type'              => 'challenge',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'meta_query'             => array(
					array(
						'key'       => 'track',
						'value'     => $track,
					),
					array(
						'key'       => 'period',
						'value'     => $period,
					),
					array(
						'key'       => 'challenge_url',
						'compare' 	=> 'NOT EXISTS',
						'value'     => '',
					),
				),
			);
			$query = new WP_Query( $args );
			$intTotalPost = $query->post_count;
			
		} else { // Get Challenge Details and insert to WP
			
			// get challenge ID from WP post
			$wp_challenge_id = 0;
			$args = array (
						'post_type'              => 'challenge',
						'post_status'            => 'publish',
						'posts_per_page'         => 1,
						'meta_query'             => array(
							array(
								'key'       => 'track',
								'value'     => $track,
							),
							array(
								'key'       => 'period',
								'value'     => $period,
							),
							array(
								'key'       => 'challenge_url',
								'compare' 	=> 'NOT EXISTS',
								'value'     => '',
							),
						),
					);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$wp_challenge_id 	= get_field('challenge_id');
					$wp_post_id 		= get_the_ID();
					$wp_post_title		= get_the_title();
				}
			} else {
				$return['msg'] = 'Completed';
			}
			
			// get challenge details from TC API
			if ( $wp_challenge_id>0 ) {
				
				if ( $track=='development' || $track=='prototype' ) { // Development and Prototype track;
					$challenge_url 	= 'https://api.topcoder.com/v2/develop/challenges/'.$wp_challenge_id;
				
					$challenge_json = file_get_contents($challenge_url);
					$challenge_obj 	= json_decode($challenge_json);
					
					if ( $challenge_obj) {
						
						// count number of passing submissions
						$numberOfSubmissions = 0;
						foreach( $challenge_obj->submissions as $k=>$v ) {
							if ( $v->submissionStatus=='Active' || $v->submissionStatus=='Completed Without Win' ) {
								$numberOfSubmissions++;	
							}
							
							if ($numberOfSubmissions==5) {
								break;
							}
						}
						
						
						// placement points formula
						if ( $track=='development' ) { 
							switch( $numberOfSubmissions ) {
								case 1:
									$placement_points[1] = $challenge_obj->prize[0] * 1;
									break;
									
								case 2:
									$placement_points[1] = $challenge_obj->prize[0] * .7;
									$placement_points[2] = $challenge_obj->prize[0] * .3;
									break;
									
								case 3:
									$placement_points[1] = $challenge_obj->prize[0] * .65;
									$placement_points[2] = $challenge_obj->prize[0] * .25;
									$placement_points[3] = $challenge_obj->prize[0] * .10;
									break;
									
								case 4:
									$placement_points[1] = $challenge_obj->prize[0] * .60;
									$placement_points[2] = $challenge_obj->prize[0] * .22;
									$placement_points[3] = $challenge_obj->prize[0] * .10;
									$placement_points[4] = $challenge_obj->prize[0] * .08;
									break;
								
								default:
									$placement_points[1] = $challenge_obj->prize[0] * .56;
									$placement_points[2] = $challenge_obj->prize[0] * .20;
									$placement_points[3] = $challenge_obj->prize[0] * .10;
									$placement_points[4] = $challenge_obj->prize[0] * .08;
									$placement_points[5] = $challenge_obj->prize[0] * .06;
							}
						} else {
							$placement_points[1] = 11;
							$placement_points[2] = 9;
							$placement_points[3] = 7;
							$placement_points[4] = 4;
							$placement_points[5] = 1;
						}
						
						
						// save custom fields
						add_post_meta($wp_post_id, 'challenge_url', $challenge_obj->directUrl, true);
						add_post_meta($wp_post_id, 'winners', $numberOfSubmissions, true);
						
						foreach( $challenge_obj->submissions as $k=>$v ) {
							$placement = $v->placement;
							
							add_post_meta($wp_post_id, 'winners_'.$k.'_placement', $placement, true);
							add_post_meta($wp_post_id, 'winners_'.$k.'_handle', $v->handle, true);
							add_post_meta($wp_post_id, 'winners_'.$k.'_submission_date', $v->submissionDate, true);
							add_post_meta($wp_post_id, 'winners_'.$k.'_score', $v->finalScore, true);
							add_post_meta($wp_post_id, 'winners_'.$k.'_placement_points', $placement_points[$placement], true);
							
							if ( $placement==5 ) {
								break;
							}
						}
						
						$return['msg'] 	= 'ok';
					} else {
						$return['msg'] 	= 'Something went wrong with TC API request of challenge "' . $wp_post_title . '"';
					}
					
				} else if ( $track=='ia' || $track=='ui-design' ) { // Information Architecture, UI Design track
					
					// Challenge Details
					$challenge_url 	= 'https://api.topcoder.com/v2/design/challenges/'.$wp_challenge_id;
					$challenge_json = file_get_contents($challenge_url);
					$challenge_obj 	= json_decode($challenge_json);
					
					if ( $challenge_obj) {
						
						// Get Result
						$result_url 	= 'https://api.topcoder.com/v2/design/challenges/result/'.$wp_challenge_id;
						$result_json 	= file_get_contents($result_url);
						$result_obj 	= json_decode($result_json);
						
						if( $result_obj ) {
						
							// placement points formula
							$placement_points[1] = 11;
							$placement_points[2] = 9;
							$placement_points[3] = 7;
							$placement_points[4] = 4;
							$placement_points[5] = 1;
							
							// number of passing submissions
							$numberOfSubmission  = $result_obj->submissions>5 ? 5 : $result_obj->submissions;
							
							// save custom fields
							add_post_meta($wp_post_id, 'challenge_url', $challenge_obj->directUrl, true);
							add_post_meta($wp_post_id, 'winners', $numberOfSubmission, true);
							
							foreach( $result_obj->results as $k=>$v ) {
								
								if ( $v->placement<=5 && ($v->submissionStatus=='Completed Without Win' || $v->submissionStatus=='Active')) {
									$key = $v->placement - 1;
									
									add_post_meta($wp_post_id, 'winners_'.$key.'_placement', $v->placement, true);
									add_post_meta($wp_post_id, 'winners_'.$key.'_handle', $v->handle, true);
									add_post_meta($wp_post_id, 'winners_'.$key.'_submission_date', $v->submissionDate, true);
									add_post_meta($wp_post_id, 'winners_'.$key.'_placement_points', $placement_points[$v->placement], true);
								
								}
							}
						
							$return['msg'] 	= 'ok';
							
						} else {
							$return['msg'] 	= 'Something went wrong with TC API Result request of challenge "' . $wp_post_title . '"';
						}
					} else {
						$return['msg'] 	= 'Something went wrong with TC API request of challenge "' . $wp_post_title . '"';
					}
				}
				
			}
			
			echo json_encode($return);
			die();
		}
		
		
	} // endif;
?>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
	$(document).ready(function($) {
		$('#completed').hide();
		
		<?php if ( $intTotalPost>0 ) : ?>
		
		getChallengeDetails();
		function getChallengeDetails() {
			
			$('#currentProcessing').text( parseInt($('#currentProcessing').text()) + 1 );
			$.ajax({
				url: '<?php echo $strPermalink; ?>',
				data: { 
					track	: '<?php echo $track; ?>',
					period	: '<?php echo $period; ?>',
					action	: 'details'
				},
				method: 'GET',
				dataType: 'json',
				success:function(data) {
					if (data.msg=='ok') {
						getChallengeDetails();
					} else {
						$('#completed').text(data.msg).show();	
					}
				}
			}); 
		}
		
		<?php endif; ?>
	});
</script>
<h1><?php echo ucwords($track); ?> Period <?php echo $period; ?></h1>
<p>
	Processing # <span id="currentProcessing">0</span> 
	out of <?php echo $intTotalPost; ?>.
	<strong id="completed"></strong>
</p>