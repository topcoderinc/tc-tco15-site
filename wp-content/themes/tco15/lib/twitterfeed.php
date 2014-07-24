<?php	
	include '../../../../wp-load.php';
	
	if( !class_exists('TwitterOAuth') ) {
		require_once("./twitteroauth/twitteroauth.php"); //Path to twitteroauth library
	}
	 
	$search = get_option('feed_tco');	
	$notweets = 30;
	$consumerkey = "JJCRZlSBK8ebevdEEUCw";
	$consumersecret = "9Nc7T3jSBa9BMHmVvN1tMhxeTlWn2flg1IrQySHA";
	$accesstoken = "17635954-nUkNRsUU2Mbt37wu1T16JbvruVLcKXk9p60nH8MG3";
	$accesstokensecret = "kEhs4FMGjgcNaOjvF9QeYYdJU3ZFR4MW5VI1RJ2AE";
	  
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
	
	$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	 
	$params['q'] = $search;
	$params['count'] = $notweets;
	
	//$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=".$notweets);
	$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json", $params);
	echo json_encode($tweets);					
	
?>