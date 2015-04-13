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
		$ret = preg_replace ( "/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $ret );
		return $ret;
	}
	
	$search = $key;
	$notweets = $limit;
	$consumerkey = "JJCRZlSBK8ebevdEEUCw";
	$consumersecret = "9Nc7T3jSBa9BMHmVvN1tMhxeTlWn2flg1IrQySHA";
	$accesstoken = "17635954-nUkNRsUU2Mbt37wu1T16JbvruVLcKXk9p60nH8MG3";
	$accesstokensecret = "kEhs4FMGjgcNaOjvF9QeYYdJU3ZFR4MW5VI1RJ2AE";
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth ( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
		return $connection;
	}
	
	$connection = getConnectionWithAccessToken ( $consumerkey, $consumersecret, $accesstoken, $accesstokensecret );
	
	$params ['q'] = $search;
	$params ['count'] = $notweets;
	$tweets = $connection->get ( "https://api.twitter.com/1.1/search/tweets.json", $params );
	
	$html = "<div class='carousel'><ul class=\"".$class."\">";
	if ( count($tweets->statuses)>0 ) {
		foreach ( $tweets->statuses as $k => $v ) {
			$html .= '<li>
					<img src="' . $v->user->profile_image_url . '" alt="" />
					<p>
						<a href="http://twitter.com/' . $v->user->screen_name . '">@' . $v->user->screen_name . '</a>
						<span>' . twitterify ( $v->text ) . '</span>
					<p>
				  </li>';
		}
	}
	
	$html .= "</ul></div>";
		
	return $html;
}
add_shortcode ( "tco_tweets", "tco_tweets_function" );
