<?php

/*
 * tco_recent_blog_posts
 */
function tco_recent_blog_posts_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"category" 		=> "",
			"limit" 		=> 10,
			"show" 			=> "summary",
			"first" 		=> "summary", 
			"pagination"	=> false
	), $atts ) );
	
	$args = array (
			'posts_per_page'=> $limit,
			'orderby'		=> 'date',
			'order'			=> 'DESC',
			'category' => $category
	);	
	
	if ( $pagination ) {
		$paged = (get_query_var ( 'paged' )) ? get_query_var ( 'paged' ) : 1;
		$args['paged'] = $paged;
	}
	
	$html = '';
	
	$post_query = new WP_Query ( $args );
	if ($post_query->have_posts ()) {
		$ctr = 1;
		while ( $post_query->have_posts () ) :
			$post_query->the_post ();
			
			$pid = $post_query->post->ID;
			$con = get_the_content();
			
			$html .= '<section class="section">';
			
			if ( $first=='full' && $ctr>1 && $show=='summary' ) {
				$html .= '<h5><strong><a href="'.get_permalink().'">'. get_the_title().'</a></strong></h5>';
			} else {
				$html .= '<h4><a href="'.get_permalink().'">'. get_the_title().'</a></h4>';
			}
				
			$html .= '<div class="meta">
					Posted by <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author_meta( 'display_name' ).'</a> on '. get_the_time('l , F jS, Y \a\t g:i a').'
				</div>
				<div class="post-content">';
														
				if ( $show=='full' ) {
					$content = $con; // to do: check when there is more tag to still display full content
				} else { // show only summary
					if ( strpos($con, '<!--more-->') ) {
						$content = $con;	
					} else {
						$content = get_the_excerpt();
					}						
				}
				
				if ( $ctr==1 ) {
					if ( $first=='full' ) {
						$content = $con;
					} else {
						$content = get_the_excerpt();
					}
				}
			
				$html .= apply_filters('the_content', $content);
				
				$ctr++;
				
				$html .='</div>
			</section>';
		endwhile;
		
		if ( $pagination ) {
			$big = 999999999; // need an unlikely integer								
			$html .= '<div class="blog-pagination">'.paginate_links ( array (
					'base' => str_replace ( $big, '%#%', esc_url ( get_pagenum_link ( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max ( 1, get_query_var ( 'paged' ) ),
					'total' => $post_query->max_num_pages 
			) ) .'</div>';		
		}

	}
	
	
	
	
	return $html;
}
add_shortcode ( "tco_recent_blog_posts", "tco_recent_blog_posts_function" );


