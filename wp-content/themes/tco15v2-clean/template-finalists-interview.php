<?php 
/*
Template Name: Finalists Page
*/
get_header(); 

$masthead		= 'masthead-nophoto';
$cover_photo 	= get_field('cover_photo');
if ( $cover_photo ) {
	if ( $cover_photo['width']>992 ) {
		$masthead	= 'masthead-full';
	} else {
		$masthead	= 'masthead-small';
	}
}

$track		 	= get_field('track');
$q[]		 	= get_field_object('topcoder_meaning');
$q[]			= get_field_object('greatest_accomplishment');
$q[]		 	= get_field_object('hobbies');
$q[]		 	= get_field_object('best_tip');
$q[]		 	= get_field_object('topcoder_story');

$bgPosition 	= get_field('cover_photo_position');

?>

<main>
	
	<?php if ( $masthead=='masthead-full' ) : ?>
	<div class="<?php echo $masthead; ?>" style="background: url(<?php echo $cover_photo['url']; ?>) <?php echo $bgPosition; ?>">
		<div class="container">
			<div class="track-handle">
				<span><?php echo $track; ?> <?php echo $track=='Copilot' ? 'Winner' : 'Finalist'; ?></span>
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="container">
		    
		<div class="article">
			
			<?php if ( $masthead!='masthead-full'  ) : ?>
			<?php if ($masthead=='masthead-small') : ?>
			<div class="col-xs-12 col-sm-6 col-md-4 pull-right">
				&nbsp;
				<img src="<?php echo $cover_photo['url']; ?>" class="img-responsive img-full img-thumbnail" />
			</div>
			<?php endif; ?>
			<div class="masthead-finalists">
				
				<div class="track-handle">
					<span><?php echo $track; ?> <?php echo $track=='Copilot' ? 'Winner' : 'Finalist'; ?></span>
					<h1><?php the_title(); ?></h1>
				</div>
					
			</div>
			<hr />
			<?php endif; ?>
			
			
			
		
			<div class="interview">
				<h2 class="alt-section-title">INTERVIEW</h2>
				<?php foreach($q as $k=>$v) : ?>
				<div class="item">
					<h3><strong><?php echo $v['label']; ?></strong></h3>
					<?php echo apply_filters('the_content', $v['value']); ?>
				</div>
				<hr />
				<?php endforeach; ?>
			</div>
			
			
			<?php
				// get next and prev interview
				$currentID = $post->ID;
				$args = array (
					'post_parent'            => $post->post_parent,
					'post_type'              => 'page',
					'post_status'            => 'publish',
					'posts_per_page'         => '-1',
					'order'                  => 'ASC',
					'orderby'                => 'menu_order',
					'meta_query'             => array(
						array(
							'key'       => 'topcoder_meaning',
							'value'     => '',
							'compare'   => '!=',
						),
					),
				);
				
				
				$strNext = '';
				$strPrev = '';
					
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					$ctr = 0;
					while ( $query->have_posts() ) {
						$query->the_post();
						$link[$ctr] = get_the_permalink();
						
						if ($currentID==$post->ID) {
							$current_ctr = $ctr;
						}
						
						$ctr++;
					}
					
					if ($current_ctr>0) {
						$strPrev = $link[$current_ctr-1];
					}
					
					if ($current_ctr< (count($link)-1) ) {
						$strNext = $link[$current_ctr+1];
					}
					
				}
				
				// Restore original Post Data
				wp_reset_postdata();
				
				
			?>
			<nav>
				<ul class="pager">
					<li class="previous<?php if ($strPrev=='') : ?> disabled<?php endif; ?>"><a href="<?php echo $strPrev!='' ? $strPrev : '#'; ?>"><span aria-hidden="true">&larr;</span> Previous <?php echo $track=='Copilot' ? 'Winner' : 'Finalist'; ?></a></li>
					<li class="home"><a href="<?php echo get_permalink($post->post_parent); ?>">All <?php echo $track; ?> <?php echo $track=='Copilot' ? 'Winners' : 'Finalists'; ?></a></li>
					<li class="next<?php if ($strNext=='') : ?> disabled<?php endif; ?>"><a href="<?php echo $strNext!='' ? $strNext : '#'; ?>">Next <?php echo $track=='Copilot' ? 'Winner' : 'Finalist'; ?> <span aria-hidden="true">&rarr;</span></a></li>
				</ul>
			</nav>
			
		</div>
            
	</div><!-- .container -->
</main>

<?php get_footer(); ?>