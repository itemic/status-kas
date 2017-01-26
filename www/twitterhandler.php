<?php
	ini_set('display_errors', 1);
	require('TwitterAPIExchange.php');
	require('keys.php')
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
		'oauth_access_token' => $oauth_token,
		'oauth_access_token_secret' => $oauth_secret,
		'consumer_key' => $cons_key,
		'consumer_secret' => $cons_secret
		); 

	/** Perform a GET request and echo the response **/
	/** Note: Set the GET field BEFORE calling buildOauth(); **/
	$url = 'https://api.twitter.com/1.1/lists/statuses.json';
	// Don't know what's better: count=100 will show A LOT if you don't restrict hashtags
	// But if you restrict hashtags you'll need a lot because otherwise it will only show those
	// in the past day or so.
	$getfield = "?slug=$twitter_slug&owner_screen_name=$twitter_owner&include_rts=$include_rts&count=$tweet_count&include_entities=true";
	$requestMethod = 'GET';

	$twitter = new TwitterAPIExchange($settings);
	$response = $twitter->setGetfield($getfield)
	->buildOauth($url, $requestMethod)
	->performRequest();
	echo "hi";
	
	?>  
