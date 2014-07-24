<!DOCTYPE html>
<html lang="en">
<head>
<?php get_header ();?>
</head>
<body class="stick-head">
	<?php
		get_template_part ( 'navigation' );
	?>	
	<div class="main-content">	
		<div class="pTitleBar">
			<div class="container">
				<h1><?php the_title();?></h1>	
				
				<?php get_template_part ( 'navigation-fourth-level' ); ?>
							
			</div>
		</div>
		
		<?php get_template_part ( 'breadcrumbs' ); ?>
		
			<div class="article container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-8">
						<article class="posts">
							<article class="blogs">							
									
									<?php if (have_posts())  : the_post(); ?>
									<div class="section">										
										<div class="meta">
											<?php the_time('M d, Y')?> &nbsp; | &nbsp; 
											By <strong><?php echo get_the_author_meta( 'display_name' ); ?></strong> &nbsp; | &nbsp; 
											In <?php the_category(', '); ?>
										</div>
										<div class="post-content">
										<?php the_content(); ?>
										</div>
										
										
										<div>
											<!-- AddThis Button BEGIN -->
											<div align="right" class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php the_permalink(); ?>" addthis:title="<?php the_title(); ?>">
												<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> 
												<a class="addthis_button_tweet"></a> 
												<a class="addthis_button_pinterest_pinit"></a>
												<a class="addthis_counter addthis_pill_style"></a>
											</div>
											<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4dcbe05367ab50e2"></script> 
										</div>
									</div>	
									<?php endif; ?>
																		
									<?php echo do_shortcode('[tco_snippet_posts from_id="'.$post->ID.'"]'); ?>
																
							</article>
							<!-- /blogs -->
						</article>
					</div>
					<aside class="col-xs-12 col-sm-12 col-md-4">
						<div class="sideRail">
							<?php					
								$blog = get_page_by_title('Blog');	
								$pid = $blog->ID;	
								
								$sb = get_post_meta ( $pid, '_cmb_right_sb_select', true );
									
								if (function_exists ( "smk_sidebar" )) {
									smk_sidebar ( $sb );
								}
							?>
						</div>
					  </aside>
				</div>

			</div>
	</div>	
	<!-- /.main-content -->
	
	<?php get_footer(); ?>
	<!-- /.footer -->
</body>
</html>