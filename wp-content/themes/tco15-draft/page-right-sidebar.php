<?php
/*
 * Template Name: Right Sidebar
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php get_header ();?>
<?php

$title_lower = get_the_title ();
$title_lower = str_replace ( ' ', '-', $title_lower );
$title_lower = str_replace ( '.', '-', $title_lower );


$pid = $post->ID;
?>
</head>
<body id="<?php echo 'p'.$title_lower ?>">
	<?php get_template_part ( 'navigation' ); ?>
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
					<div class="col-xs-12 col-sm-8 col-md-8">
						
						<?php if($title_lower == "tco14-blog"):?>
							
							<article class="posts">
								<article class="blogs">
										<?php
										
										global $wp_query;
										
										$paged = (get_query_var ( 'paged' )) ? get_query_var ( 'paged' ) : 1;
										
										
										query_posts ( array (
												'orderby' => 'date',
												'order' => 'DESC',
												'paged' => $paged 
										) );
										$key = array (
												'<h3>',
												'<h2>',
												'</h3>',
												'</h2>' 
										);
										if (have_posts ()) :
											while ( have_posts () ) :
												the_post ();
												global $more;
												$more = 0;
												$post_categories = wp_get_post_categories ( $post->ID );
												$hide = false;
												$cats = array ();
												
												foreach ( $post_categories as $c ) {
													$cat = get_category ( $c );
													$slug = $cat->slug;
													if ($slug == 'top-news') {
														$hide = true;
														break;
													}
												}
												if ($hide) {
													continue;
												}
												$p_title = get_the_title ();
												$p_title = str_replace ( $key, ' ', $p_title );
												?>
											<div class="section">
										<h4>
											<a href="<?php echo get_permalink(); ?>"><?php echo $p_title; ?></a>
										</h4>
										<div class="meta">
													Posted by <?php the_author_posts_link(); ?> on <?php the_time('l , F jS, Y \a\t g:i a')?>
												</div>
												<?php the_excerpt(); ?>
												<div>
											<!-- AddThis Button BEGIN -->
											<div align="right" class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php the_permalink(); ?>" addthis:title="<?php the_title(); ?>">
												<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a>
											</div>
											<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4dcbe05367ab50e2"></script>
										</div>
									</div>
										<?php
											endwhile
											;
										endif;
										
										$big = 999999999; // need an unlikely integer
										
										echo '<div class="blog-pagination">'.paginate_links ( array (
												'base' => str_replace ( $big, '%#%', esc_url ( get_pagenum_link ( $big ) ) ),
												'format' => '?paged=%#%',
												'current' => max ( 1, get_query_var ( 'paged' ) ),
												'total' => $wp_query->max_num_pages 
										) ) .'</div>';
										?>
					
					
		            			</article>
								<!-- /blogs -->
							</article>
						<?php else:?>	
										
							<article class="posts">
								<?php if (have_posts())  : the_post(); ?>	
								<?php $pid = $post->ID;?>
		
								<div class="article"><?php echo the_content();?></div>
										<?php  endif;?>
							</article>
							
						<?php endif;?>
					</div>
					<aside class="col-xs-12 col-sm-4 col-md-4">
						<div class="sideRail">
							<?php
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