<?php

/*
 * tco_forum_posts
 */
function tco_forum_posts_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
			"url"	=> '',
			"limit" => 10
	), $atts ) );
	
	$html = '';
	
	if ($url!='') {
		
		require_once "rss/rss_fetch.inc";
	
		$forumFeedsUrl 		= 'http://apps.topcoder.com/forums/?module=RSS&forumID=571004';//$url;							   
		$forumFeedsMaxItem 	= $limit;
		
		if ( !defined('MAGPIE_CACHE_AGE') ) {
			define('MAGPIE_CACHE_AGE', 60*60); // one hour
		}		
		
		define('MAGPIE_FETCH_TIME_OUT', 60);

		$feed 		= fetch_rss($forumFeedsUrl);
		$arrForum 	= $feed->items;
		$forumCount = count($arrForum);
		
		if ( $forumCount>0 ) {
			$html = '<ul class="forum-posts">';
			for ($i=0; $i<$forumCount; $i++) {
				if($i >= $forumFeedsMaxItem) {
					break;
				}
				
				$title 		= $arrForum[$i]["title"];
				$creator 	= $arrForum[$i]["author"] !='' ? $arrForum[$i]["author"] : $arrForum[$i]["dc"]["creator"];
				$link 		= $arrForum[$i]["link"];
				$description = $arrForum[$i]["summary"];
			
				$html .= '
					<li>
						<h5><a href="'. $link.'">'. $title.'</a></h5>
						<p>'. $description.'</p>
						<p><small>Posted by <a href="'. $link.'">'. $creator.'</a></small></p>
					</li>';    
			}
			$html .= '</ul>';
		}

	}
	
	return $html;
}
add_shortcode ( "tco_forum_posts", "tco_forum_posts_function" );


