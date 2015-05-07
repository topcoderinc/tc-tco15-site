<?php

/*
 * tco_winner
 */
function tco_winner_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"orderby" => "menu_order",
			"order" => "ASC",
			"limit" => 10,
			"interval" => "6000" 
	), $atts ) );
	$content = $content == null ? "Carousels" : $content;
	
	$args = array (
			'post_type' => 'carousel',
			"orderby" => $orderby,
			'paged' => $paged,
			'posts_per_page' => $limit,
			'order' => $order 
	);
	$slides = new WP_Query ( $args );
	global $uniqueCounter;
	$carouselId = 'carousel-' . $uniqueCounter;
	$slideHtml = "";
	$carouselNavs = "";
	$count = 0;
	if ($slides->have_posts ()) {
		while ( $slides->have_posts () ) :
			$slides->the_post ();
			
			$slideHtml .= ' <div class="item ' . ($count == 0 ? "active" : "") . '">' . apply_filters ('the_content', get_the_content () ) . '</div>';
			$carouselNavs .= '<li class="' . ($count == 0 ? "active" : "") . '" data-target="#' . $carouselId . '" data-slide-to="' . $count . '"></li> ';
			$count += 1;
		endwhile
		;
	}
	;
	
	$html = '';
	$html .= '<div id="' . $carouselId . '" class="news-carousel carousel slide" data-ride="carousel" data-interval="'.$interval.'">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				   ' . $carouselNavs . '
				  </ol>
				
				  <!-- Wrapper for slides -->			
				  <div class="carousel-inner">
				    
			' . $slideHtml . '					
				  </div>
				
				 <!--  Controls -->
				  <a class="left carousel-control" href="#' . $carouselId . '" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				  </a>
				  <a class="right carousel-control" href="#' . $carouselId . '" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				  </a>
				</div>';
	
	$uniqueCounter += 1;
	return $html;
}

add_shortcode ( "tco_winner", "tco_winner_function" );
