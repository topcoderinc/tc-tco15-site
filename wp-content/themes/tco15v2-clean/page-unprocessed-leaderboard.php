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
			
			echo 'Challenge Title: ' . get_the_title() . '<br />';
			echo 'Challenge ID: ' . get_field('challenge_id'). '<br />';
			echo 'Track: ' . get_field('track'). '<br />';
			echo 'Period: ' . get_field('period');
			echo '<hr>';
		}
	} else {
		echo 'Nothing to show...';	
	}
		
?>