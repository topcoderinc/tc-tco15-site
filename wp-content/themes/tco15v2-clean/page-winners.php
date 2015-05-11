<?php get_header(); ?>

<main>

	<?php get_template_part ( 'part-masthead' ); ?>
	
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
					?>
						<div class="col-sm-3">
							<a href="<?php echo $strPermalink; ?>" class="finalist-thumb">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail('full', array('class' => 'img-responsive img-full'));
							} else {
								echo '<img src="'.get_template_directory_uri().'/i/nophoto-finalists.png" class="img-responsive img-full" />';	
							}
							?>
								<span><?php the_title(); ?></span>
							</a>
						</div>
						
						<?php if ( $ctr%4==0) : ?>
						<div class="clearfix"></div>
						<?php endif; ?>
						
					<?php
							}
						}
						
						// Restore original Post Data
						wp_reset_postdata();
					?>
					</div>
				</div>
            
            </div>
            <div class="col-sm-4 col-lg-3">
            	<?php get_sidebar(); ?>
            </div>
        </div><!-- .row -->
	</div><!-- .container -->
</main>

<?php get_footer(); ?>