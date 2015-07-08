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
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-64921625-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
		
		<?php wp_footer(); ?>

	</body>

</html>