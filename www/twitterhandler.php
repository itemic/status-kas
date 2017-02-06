<?php
ini_set('display_errors', 1);
	
	require_once('keys.php');
	require_once('TwitterAPIExchange.php');
	require_once('config.php');
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

	$results = json_decode($response, true);
		if (!$case_sensitive_hashtags) {
			$display_hashtags = array_map('strtolower', $display_hashtags);
	}



	if ($results != "") {
		$tweets = array();
		$users = array();
		$images = array();
		$times = array();

		foreach ($results as $search) {
			if ($filter_hashtags) {
				$entityhashtags = $search['entities']['hashtags'];

				foreach ($entityhashtags as $hashtag) {
					$hashtag_query = $hashtag['text'];
					if (!$case_sensitive_hashtags) {
						$hashtag_query = strtolower($hashtag_query);
					}
					if (in_array($hashtag_query, $display_hashtags)) {
						if (array_key_exists('media', $search['entities'])) {
							$entitymedia = $search['entities']['media'];
							$subimages = array();
							foreach ($entitymedia as $twimg) {
								array_push($subimages, $twimg["media_url_https"]);
							}
							array_push($images, $subimages);
						} else {
							array_push($images, array());
						}
						$tweet = $search['text'];
						// $tweet = addslashes($search['text']);
						$tweet = preg_replace('~[\r\n]+~', ' ', $tweet);
						$username = addslashes($search['user']['screen_name']);
						$time = $search['created_at'];

						array_push($tweets, $tweet);
						array_push($users, $username);
						array_push($times, $time);

						break;
					}
				}
			} else {
				if (array_key_exists('media', $search['entities'])) {
					$entitymedia = $search['entities']['media'];
					$subimages = array();
					foreach ($entitymedia as $twimg) {
						array_push($subimages, $twimg["media_url_https"]);
					}
					array_push($images, $subimages);
				} else {
					array_push($images, array()
						);
				}
				$tweet = $search['text'];
				// $tweet = addslashes($search['text']);
				$tweet = preg_replace('~[\r\n]+~', ' ', $tweet);
				$username = addslashes($search['user']['screen_name']);
				$time = $search['created_at'];

				array_push($tweets, $tweet);
				array_push($users, $username);
				array_push($times, $time);

			}
		}
		$data = [$tweets, $users, $images, $times];
		echo json_encode($data);
	}
?>