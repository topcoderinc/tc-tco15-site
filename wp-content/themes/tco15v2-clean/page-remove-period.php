<?php
	
	global $current_user;
	get_currentuserinfo(); 

			
	// get total number of challenge to process
	$args = array (
		'post_type'              => 'challenge',
		'post_status'            => 'publish',
		'posts_per_page'         => -1,
		'meta_query'             => array(
			array(
				'key'       => 'track',
				'value'     => $_GET['track'],
			),
			array(
				'key'       => 'period',
				'value'     => $_GET['period'],
			),
		),
	);
	$query = new WP_Query( $args );
	
		
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '[' .get_the_title() . '] - Deleted <br />';
			wp_delete_post($post->ID, true);
		}
		
	} else {
		echo 'Nothing to show...';	
	}
		
?>