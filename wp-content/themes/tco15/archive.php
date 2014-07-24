<?php
/**
 * Template Name: Blogs
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
<body class="stick-head" id="<?php echo 'p'.$title_lower ?>">
	<?php
	get_template_part ( 'navigation' );
	?>
	<div class="main-content">
		<div class="pTitleBar">
			<div class="container">
				<h1><?php
					if ( is_category() ) {
						single_cat_title( 'Posts under ', true ); 
					} elseif ( is_author() ) {						
						echo 'Posts by ' . get_the_author_meta( 'user_nicename' , $post->post_author );
					} elseif ( is_archive() ) {
						if ( is_day() ) {
        					printf( __( 'Daily Archives: <span>%s</span>', '' ), get_the_date() );
						} elseif ( is_month() ) {
							printf( __( 'Monthly Archives: <span>%s</span>', '' ), get_the_date( _x( 'F Y', 'monthly archives date format', '' ) ) ); 
						} elseif ( is_year() ) {
        					printf( __( 'Yearly Archives: <span>%s</span>', '' ), get_the_date( _x( 'Y', 'yearly archives date format', '' ) ) );
						} 
					} else {
						echo 'Blog Archives';
					}
				?></h1>
				
				<?php get_template_part ( 'navigation-fourth-level' ); ?>
			</div>
		</div>
		
		<?php get_template_part ( 'breadcrumbs' ); ?>
		
		<div class="article container">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8">
					<article class="posts">
						<article class="blogs">						
								<?php
								global $wp_query;
								
								$paged = (get_query_var ( 'paged' )) ? get_query_var ( 'paged' ) : 1;
								if (have_posts ()) :
									while ( have_posts () ) :
										the_post ();
										global $more;
										$more = 0;
									?>
									<div class="section">
										<h3>
											<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<div class="meta">
											Posted by <?php the_author_posts_link(); ?> on <?php the_time('l , F jS, Y \a\t g:i a')?>
										</div>
										<?php the_excerpt(); ?>
									<div>
								</div>
							</div>
								<?php
									endwhile
									;
								endif;
								
								$big = 999999999; // need an unlikely integer
								
								echo '<div class="blog-pagination">'.paginate_links ( array (
										'base' 		=> str_replace ( $big, '%#%', esc_url ( get_pagenum_link ( $big ) ) ),
										'format' 	=> '?paged=%#%',
										'current' 	=> max ( 1, get_query_var ( 'paged' ) ),
										'total' 	=> $wp_query->max_num_pages 
								) ) .'</div>';
								?>
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