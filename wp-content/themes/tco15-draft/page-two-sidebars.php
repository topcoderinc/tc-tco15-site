<?php
/*
 * Template Name: Two Sidebars
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
	<?php
	get_template_part ( 'navigation' );
	?>
	<div class="main-content">
		<div class="pTitleBar">
			<div class="container">
				<h1><?php the_title();?></h1>
				<ul class="lvl3Menu">
                	<?php
							$menu = "";
							$title_lower = strtolower ( $title_lower );
							switch ($title_lower) {
								case ($title_lower == 'wireframe-tournament' || $title_lower == 'ui-prototype-tournament' || $title_lower == 'copilot-tournament' || $title_lower == 'win-tco-trips') :
									$menu = 'overview-win';
									break;
								case ($title_lower == 'algorithm-leaderboard' || $title_lower == 'algorithm-advancers-leaderboard' || $title_lower == 'algorithm-advancers-bracket') :
									$menu = 'algo-leaderboard';
									break;
								case ($title_lower == 'marathon-leaderboard' || $title_lower == 'marathon-advancers-leaderboard' || $title_lower == 'marathon-advancers-bracket') :
									$menu = 'marathon-leaderboard';
									break;
								case ($title_lower == 'studio-leaderboard' || $title_lower == 'studio-advancers-leaderboard' || $title_lower == 'studio-advancers-bracket') :
									$menu = 'studio-leaderboard';
									break;
								case ($title_lower == 'competition-rules') :
									$menu = 'rules-menu';
									break;
								case ($title_lower == 'sponsors') :
									$menu = 'sponsor-menu';
									break;
							}
							
							$currentId = $post->ID;
							if ($menu != "") {
								renderThirdMenu ( $menu, $currentId );
							}
							?>
                </ul>
			</div>
		</div>
		<?php if (have_posts())  : the_post(); ?>	
		<?php $pid = $post->ID;?>
		<div class="article container">
			<div class="row">
				<aside class="col-xs-12 col-sm-4 col-md-3">
					<div class="sideRail">
							<?php
								$sbLt = get_post_meta ( $pid, '_cmb_left_sb_select', true );
								
								if (function_exists ( "smk_sidebar" )) {
									smk_sidebar ( $sbLt );
								}
							?>
						</div>
				</aside>
				<div class="col-xs-12 col-sm-8 col-md-6">
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
								<div class="article"><?php echo the_content();?></div>
							</article>
							
						<?php endif;?>
				</div>
				<aside class="col-xs-12 col-sm-12 col-md-3">
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
		<!-- /.article -->
		<?php  endif;?>
	</div>
	<!-- /.main-content -->
	
	<?php get_footer(); ?>
	<!-- /.footer -->
</body>
</html>