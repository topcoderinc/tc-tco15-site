<?php
/*
 * Shortcodes
 */
$uniqueCounter = 1;

/*
 * tco_sponsors
 */
function tco_sponsors_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"category" => "" 
	), $atts ) );
	
	$tco_spos = "";
	$args = array (
			'post_type' 	=> 'sponsor',
			'orderby' 		=> 'menu_order',
			'order'			=> 'asc',
			'category_spon' => $category,
			'post_parent'	=> 0, 
			'posts_per_page'=> -1
	);
	
	$spo_list = "";
	$tco_spos = new WP_Query ( $args );
	if ($tco_spos->have_posts ()) {
		while ( $tco_spos->have_posts () ) :
			$tco_spos->the_post();
			
			$pid = get_the_ID(); //$cal_evnts->post->ID;
			$cats = get_the_category ( $pid );
			if ( has_post_thumbnail() ) {
				$image = wp_get_attachment_image_src ( get_post_thumbnail_id ( $pid ), 'single-post-thumbnail' );
			}
			$terms = get_the_terms( $pid, 'category_spon' );
			
			$catHtml = '';
			if( $terms ) {
				foreach ( $terms as $term ) {
					$catHtml = $term->name;
				}
			}
			
			if ( $catHtml!='Draft' ) {
				$spo_list .= '
						<li class="' . $catHtml . '">
							<div class="center-block">
								<!--<h3><a href="' . get_permalink ( $pid ) . '">' . get_the_title() . '</a></h3>-->
								<figure><a href="' . get_permalink ( $pid ) . '"><img src="' . $image [0] . '" alt="' . get_the_title () . '"/></a></figure>
								<div class="post-content">' . apply_filters('the_content', get_the_excerpt()) . '</div>
								<hr/>
							</div>
						</li>';
			}
					
		endwhile;
	}	
	
	$html = "";
	$html = "<ol class='list-group sponsors'>
				" . $spo_list . "
			</ol>";
	
	return $html;
}
add_shortcode ( "tco_sponsors", "tco_sponsors_function" );

