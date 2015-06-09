<?php get_header(); ?>

<main>

	<?php get_template_part ( 'part-masthead' ); ?>
	
	<div class="container">

		<div class="article">
		<?php 
			if (have_posts())  :
				the_post(); 
				$parent_title = get_the_title($post->post_parent);
		?>
			<h3 class="post-title">Congratulations to the <?php echo ucwords($parent_title); ?> Online Champions!</h3>
			
			<?php the_content(); ?>
			
			<h3 class="alt-post-title">Online Champions &amp; Trip Winners</h3>
			
			
		<?php endif; ?>
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
				if ( $query->have_posts() ) :
					$ctr = 0;
					while ( $query->have_posts() ) :
						$query->the_post();
						$topcoder_meaning 	= get_field('topcoder_meaning');
						$strPermalink 		= $topcoder_meaning!='' ? get_the_permalink() : 'javascript:;';
						
						if ($topcoder_meaning!='') : 
							$ctr++;
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
						endif;
					endwhile;
				endif;
					
				// Restore original Post Data
				wp_reset_postdata();
			?>
			</div>
		</div><!-- .article -->
		
	</div><!-- .container -->
</main>

<?php get_footer(); ?>