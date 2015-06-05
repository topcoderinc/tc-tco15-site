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
	
		
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$wp_challenge_id 	= get_field('challenge_id');
			$wp_post_id 		= get_the_ID();
			$wp_post_title		= get_the_title();
			
			echo 'Challenge Title:' . $wp_post_title . '<br />';
			echo 'Challenge ID' . $wp_challenge_id;
			echo '<hr>';
		}
	} else {
		echo 'Nothing to show...';	
	}
		
?>