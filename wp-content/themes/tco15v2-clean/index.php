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
						the_content();
					} 
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