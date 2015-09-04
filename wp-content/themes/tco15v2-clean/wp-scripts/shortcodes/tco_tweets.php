<?php
/*
 * Shortcodes
 */
$uniqueCounter = 1;

/*
 * tco_tweets
 */
function tco_tweets_function($atts, $content = null) {
	extract ( shortcode_atts ( array (
		'class'	=> '',
		'limit'	=> 10
	), $atts ) );
	
	$key = get_option ( 'twtr_keyword' );
	function twitterify($ret) {
		$ret = preg_replace ( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret );
		$ret = preg_replace ( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret );
		$ret = preg_replace ( "/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret );
		$ret = preg_replace ( "/#(\w+)/", "<a href=\"https://twitter.com/hashtag/\\1?src=hash\" target=\"_blank\">#\\1</a>", $ret );
		return $ret;
	}
	
	$carouselId = 'side-tweet-'.md5(microtime());
	$interval	= 10000;
	$search = $key;
	$consumerkey = "zf6xRR8ZtvHoNMKNxvJrDJfOV";
	$consumersecret = "o7fGFNbPdaG928pC5NiqrUS54UMnf4iEo26AuDusowerXN7kWO";
	$accesstoken = "17635954-dJsg88dcztdoJ9yEZN2apFAi0ohwBBD1RAcu3eXd3";
	$accesstokensecret = "Bz0PdNWnSmwHoIPilwJtYKXUUV4JJNEurj1467xRlQMQt";
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth ( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
		return $connection;
	}
	
	$connection = getConnectionWithAccessToken ( $consumerkey, $consumersecret, $accesstoken, $accesstokensecret );
	
	$params ['q'] = $search;
	$tweets = $connection->get ( "https://api.twitter.com/1.1/search/tweets.json", $params );
	
	// save to wp as posts to prevent blank tweet list	
	if ( count($tweets->statuses)>0 ) {
		$user = get_user_by( 'slug', 'quesks' );
		foreach ( $tweets->statuses as $k => $v ) {
			$content = '<img src="' . str_replace('_normal', '', $v->user->profile_image_url) . '" alt="" class="img-responsive" />
					<p>
						<a href="http://twitter.com/' . $v->user->screen_name . '">@' . $v->user->screen_name . '</a>
						<span>' . twitterify ( $v->text ) . '</span>
					<p>';
			// get the member's page ID

			$tweetpage = get_page_by_title( $v->id_str, 'OBJECT', 'tweet' );
			
			if ( $tweetpage->ID==0 ) {
									
				$tweet_post = array(
					'post_title' 	=> $v->id_str,
					'post_content' 	=> $content,
					'post_status' 	=> 'publish',
					'post_author' 	=> $user->ID,
					'post_type' 	=> 'tweet'
				);
				$pageID = wp_insert_post($tweet_post);
					
			}
			
			// for display render
			$slideHtml .= ' <div class="item ' . ($k == 0 ? "active" : "") . '">' . apply_filters ('the_content', $content ) . '</div>';
			$carouselNavs .= '<li class="' . ($k == 0 ? "active" : "") . '" data-target="#' . $carouselId . '" data-slide-to="' . $k . '"></li> ';
			
		}
	}		
	
	
	if ( count($tweets->statuses)==0 ) {
		$args = array (
			'post_type' 	 => 'tweet',
			'posts_per_page' => $limit,
			'orderby' 		 => 'title',
			'order'			 => 'DESC'
		);
		$tweets = new WP_Query ( $args );
		
		$slideHtml		= '';
		$carouselNavs 	= '';
		$count 			= 0;
		
		if ($tweets->have_posts ()) {
			while ( $tweets->have_posts () ) :
				$tweets->the_post();
				$slideHtml .= ' <div class="item ' . ($count == 0 ? "active" : "") . '">' . apply_filters ('the_content', get_the_content () ) . '</div>';
				$carouselNavs .= '<li class="' . ($count == 0 ? "active" : "") . '" data-target="#' . $carouselId . '" data-slide-to="' . $count . '"></li> ';
				$count += 1;
			endwhile;
		}
	}
	
	
	$html = '<div id="' . $carouselId . '" class="side-tweeter-carousel carousel slide" data-ride="carousel" data-interval="'.$interval.'">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				   ' . $carouselNavs . '
				  </ol>
				
				  <!-- Wrapper for slides -->			
				  <div class="carousel-inner">' . $slideHtml . '</div>
				
				 <!--  Controls -->
				  <a class="left carousel-control" href="#' . $carouselId . '" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				  </a>
				  <a class="right carousel-control" href="#' . $carouselId . '" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				  </a>
				</div>';
	
	return $html;
}
add_shortcode ( "tco_tweets", "tco_tweets_function" );