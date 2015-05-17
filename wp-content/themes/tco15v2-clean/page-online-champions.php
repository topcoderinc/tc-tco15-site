<?php get_header(); ?>

<main>

	<?php get_template_part ( 'part-masthead' ); ?>
	
	<div class="container">
            
		<div class="article">
		
		<?php 
			if (have_posts())  {
				the_post(); 
				echo '<h2 class="post-title">';
				the_title();
				echo '</h2>';
			}
		?>
		
			<div class="row">
			<?php
				
				// get all child pages
				$args = array (
					'post_type'			=> 'page',
					'post_parent'       => $post->ID,
					'post_status'       => 'publish',
					'order'             => 'ASC',
					'orderby'           => 'menu_order',
					'posts_per_page'    => '-1',
				);
				
				// The Query
				$query = new WP_Query( $args );
				
				// The Loop
				if ( $query->have_posts() ) {
					$ctr = 0;
					while ( $query->have_posts() ) {
						$query->the_post();
						$ctr++;
						$topcoder_meaning 	= get_field('topcoder_meaning');
						$strPermalink 		= $topcoder_meaning!='' ? get_the_permalink() : 'javascript:;';
						
						if ( get_field('topcoder_meaning')!='' ) {
							$handle = get_the_title();
							
							$arrInterview[$handle]['coverphoto']	= get_field('cover_photo');
							$arrInterview[$handle]['questions'] 	= array( get_field_object('topcoder_meaning'),
													 get_field_object('greatest_accomplishment'),
													 get_field_object('hobbies'),
													 get_field_object('best_tip'),
													 get_field_object('topcoder_story')
													);
						}
			?>
				<div class="col-md-3 col-sm-4">
					<div class="finalist-thumb">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail('full', array('class' => 'img-responsive img-full'));
					} else {
						echo '<img src="'.get_template_directory_uri().'/i/nophoto-finalists.png" class="img-responsive img-full" />';	
					}
					?>
						<span><?php the_title(); ?></span>
					</div>
				</div>
				
				<?php if ( $ctr%4==0) : ?>
				<div class="clearfix hide visible-md"></div>
				<?php endif; ?>
				
				<?php if ( $ctr%3==0) : ?>
				<div class="clearfix hide visible-sm"></div>
				<?php endif; ?>
				
			<?php
					}
				}
				
				// Restore original Post Data
				wp_reset_postdata();
			?>
			</div>
		</div>
		
		<?php if ( isset($arrInterview) ) : $ctr = 0; ?>
		<hr />
		<h2 class="alt-section-title">INTERVIEWS</h2>
		<?php foreach( $arrInterview as $handle=>$interview ) : $ctr++; ?>
			
			<h3 class="interview-title"><?php echo $handle; ?></h3>
			
			<?php if ($interview['coverphoto']) : ?>
			<div class="col-sm-6 pull-right">
			<img src="<?php echo $interview['coverphoto']['sizes']['large']; ?>" class="img-responsive img-thumbnail alignright" />
			</div>
			<?php endif; ?>
			
			<?php foreach( $interview['questions'] as $k=>$v ) : ?>
			<strong><?php echo $v['label']; ?></strong>
			<?php echo apply_filters('the_content', $v['value']); ?>
			<?php endforeach; ?>
			
			<div class="clearfix"></div>
			
		<?php endforeach; ?>
        <?php endif; ?>
		
		
		
	</div><!-- .container -->
</main>

<?php get_footer(); ?>