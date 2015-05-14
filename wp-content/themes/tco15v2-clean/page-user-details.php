<?php 
	get_header(); 
	
	$handle = $_GET['handle'];
	$track 	= $_GET['track'];
	$period = $_GET['period'];
	
	
?>

<main>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-lg-9">
            
				<div class="article">
            	<?php 
					if (have_posts())  {
						the_post(); 
						echo '<h2 class="post-title">';
						the_title();
						echo '</h2>';
					} 
				?>
					<h3>
						<?php echo $handle; ?> <?php 
						if ($track=='ia') {
							$type = 'design';
							echo 'Information Architecture';
						} else if ($track=='ui-design') {
							$type = 'design';
							echo 'UI Design';
						} else {
							$type = 'develop';
							echo ucwords($track); 
						} ?> <?php echo $period; ?> Completed Challenges
					</h3>
					
					<?php
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
							)
						),
					);
					
					$query = new WP_Query( $args );	
					if ( $query->have_posts() ) : 
				?>
				<table class="leaderboard-table table table-striped table-hover table-responsive">
					<thead>
						<tr>
							<th width="50%">Project Name</th>
							<th class="text-center">Submission Date</th>
							<th class="text-center">Score</th>
							<th class="text-center">Placement</th>
							<th class="text-center">Placement Points</th>
						</tr>
					</thead>
					<tbody>
				<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							
							$intPlacements = get_field('winners');
							$show = false;
							for( $i=0; $i<$intPlacements; $i++ ) {
								$placement_handle = get_field('winners_'.$i.'_handle');
								
								if ($placement_handle==$handle) {
									$submit_date 	= get_field('winners_'.$i.'_submission_date');
									$score 			= get_field('winners_'.$i.'_score');
									$points 		= get_field('winners_'.$i.'_placement_points');
									$placement		= $i+1;
									$show 			= true;
									break;	
								}
							}
							
							if ( $show ) :
				?>
						<tr>
							<td><a href="https://www.topcoder.com/challenge-details/<?php echo get_field('challenge_id'); ?>/?type=<?php echo $type; ?>" target="_blank"><?php the_title(); ?></a></td>
							<td class="text-center"><?php echo $submit_date; ?></td>
							<td class="text-center"><?php echo $score; ?></td>
							<td class="text-center"><?php echo $placement; ?></td>
							<td class="text-center"><?php echo number_format($points, 2); ?></td>
						</tr>
				<?php		
							endif;
							unset($winners);
						endwhile;
				?>
					</tbody>
				</table>
				<?php
					endif;
					wp_reset_postdata();
				?>
				</div>
            </div>
            <div class="col-sm-4 col-lg-3">
            	<?php get_sidebar(); ?>
            </div>
        </div><!-- .row -->
	</div><!-- .container -->
</main>

<?php get_footer(); ?>