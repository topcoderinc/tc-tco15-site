<?php get_header(); ?>

<main>

	<?php get_template_part ( 'part-masthead' ); ?>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-lg-9">
            
				<div class="article">
				
					<h2 class="post-title">Blog</h2>
            	<?php 
					if (have_posts())  :
						while ( have_posts () ) :
							the_post();
				?>
					<section>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				
						<?php the_excerpt(); ?>
				
					</section>
					
					<hr />
				<?php
						endwhile;
					endif;
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