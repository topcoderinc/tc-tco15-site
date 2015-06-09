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
		
	</div><!-- .container -->
</main>

<?php get_footer(); ?>