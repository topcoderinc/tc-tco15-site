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
			$content = '<img src="' . $v->user->profile_image_url . '" alt="" />
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
			
		}
	}		
	
	$html = "<div class='carousel'><ul class=\"".$class."\">";
	
	// get tweet posts
	$args = array (
			'post_type' 	 => 'tweet',
			'posts_per_page' => $limit,
			'orderby' 		 => 'title',
			'order'			 => 'DESC'
	);
	$tweets = new WP_Query ( $args );
	if ($tweets->have_posts ()) {
		while ( $tweets->have_posts () ) :
			$tweets->the_post();
			$html .= '<li>'. get_the_content() .'</li>';
		endwhile;
	}
	
	$html .= "</ul></div>";
	
	return $html;
}
add_shortcode ( "tco_tweets", "tco_tweets_function" );