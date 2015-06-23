<?php get_header(); ?>

<main>

	<?php get_template_part ( 'part-masthead' ); ?>

	<div class="container">
	
		<section>
			<h2 class="section-title">COMPETITION TRACKS</h2>
			<div class="row text-center">
				<div class="col-sm-4">
					<a href="<?php echo get_page_link_by_slug('algorithm'); ?>" class="track-block algorithm">
						<strong>ALGORITHM</strong><br />
						A timed contest where all contestants compete online and are given the 
						same problems to solve under the same time constraints. 
					</a>
				</div>
				<div class="col-sm-4">
					<a href="<?php echo get_page_link_by_slug('development'); ?>" class="track-block development">
						<strong>DEVELOPMENT</strong><br />
						The Development Competition includes the following tracks: Code, 
						Component Design, Component Development, Assembly, Testing Scenarios, and Testing Suites. 
					</a>
				</div>
				<div class="col-sm-4">
					<a href="<?php echo get_page_link_by_slug('information-architecture'); ?>" class="track-block ia">
						<strong>INFORMATION ARCHITECTURE</strong><br />
						The Information Architecture (IA) Competition includes the following tracks: 
						Wireframes and some new IA tracks to be determined. 
					</a>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-sm-4">
					<a href="<?php echo get_page_link_by_slug('marathon'); ?>" class="track-block marathon">
						<strong>MARATHON</strong><br />
						Marathon Competition provides a more flexible format with an extended timeline that offers 
						different types of problems than what can be offered in the Algorithm Competition.
					</a>
				</div>
				<div class="col-sm-4">
					<a href="<?php echo get_page_link_by_slug('ui-design'); ?>" class="track-block ui-design">
						<strong>UI DESIGN</strong><br />
						The UI Design Competition includes the following competitions: Logo Design, Print Design, 
						Presentation Design, Web and Application Design, Banners/Small Element Design, and Icons. 
					</a>
				</div>
				<div class="col-sm-4">
					<a href="<?php echo get_page_link_by_slug('prototype'); ?>" class="track-block prototype">
						<strong>PROTOTYPE</strong><br />
						The Prototype Competition includes the following tracks: UI Prototype, Architecture, 
						Conceptualization, and Specification. . 
					</a>
				</div>
			</div>
		</section>
		<section>
			<div class="row">
				<div class="col-sm-3 col-md-4 hidden-xs">
					<hr class="sep" />
				</div>
				<div class="col-sm-6 col-md-4">
					<a href="<?php echo get_page_link_by_slug('overview'); ?>" class="btn btn-lg btn-block">Learn More</a>
				</div>
				<div class="col-sm-3 col-md-4 hidden-xs">
					<hr class="sep" />
				</div>
			</div>
		</section>
	
		<?php /*
		<section>
			<?php echo do_shortcode('[tco_carousel limit="15"]'); ?>
		</section>
		*/ ?>
		
		
		<?php
			// WP_Query arguments
			$args = array (
				'post_type'              => 'quotes',
				'order'                  => 'ASC',
				'orderby'                => 'id',
			);
			
			// The Query
			$query = new WP_Query( $args );
			
			// The Loop
			if ( $query->have_posts() ) :
		?>
		<section>
			
			<div class="row">
				<div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
				
					<div id="carousel-quotes" class="carousel slide" data-ride="carousel" data-interval="15000">
						
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<?php for($i=0; $i<$query->found_posts; $i++) : ?>
								<li data-target="#carousel-quotes" data-slide-to="<?php echo $i; ?>" class="<?php echo $i==0 ? 'active' : ''; ?>"></li>
							<?php endfor; ?>
						</ol>
						
						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<?php
								$active = true;
								while ( $query->have_posts() ) :
									$query->the_post();
							?>
							
							<div class="item text-center <?php echo $active ? 'active' : ''; ?>">
								<q><?php echo $post->post_content; ?></q>
							</div>
							<?php $active = false; endwhile; ?>
						</div>
						
						
					</div>
				
				</div>
			</div>
		</section>
		<?php
			endif;
			
			// Restore original Post Data
			wp_reset_postdata();
		?>	
		
	</div><!-- .container -->
</main>

<?php get_footer(); ?>