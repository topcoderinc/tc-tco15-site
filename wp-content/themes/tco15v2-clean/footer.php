<?php global $site_options; ?>	
		
		
		<footer>
			<div class="top-section">
				<div class="container">
					<div class="row text-center">
						<div class="col-xs-6 col-sm-4 col-md-2">
							<a href="<?php echo get_page_link_by_slug('program'); ?>" class="program">Program</span></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-2">
							<a href="<?php echo get_page_link_by_slug('blog'); ?>" class="blog">Blog</span></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-2">
							<a href="<?php echo get_page_link_by_slug('photos'); ?>" class="photos">Photos</span></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-2">
							<a href="<?php echo get_page_link_by_slug('movies'); ?>" class="movies">Movies</a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-2">
							<a href="<?php echo get_page_link_by_slug('twitter'); ?>" class="twitter">Twitter</a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-2">
							<a href="<?php echo get_page_link_by_slug('sponsorship'); ?>" class="sponsorship">Sponsorship</a>
						</div>
					</div>
				</div>						
			</div>
			<div class="bottom-section text-center">
				<a href="http://www.topcoder.com/" class="powered"><span class="sr-only">powered by Topcoder</span></a>
			</div>
		</footer>
		
		<?php wp_footer(); ?>

	</body>

</html>