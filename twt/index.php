<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "757478231159169024-R8wjOyBYCEalHEpOVEFmgchgVLxpekj",
    'oauth_access_token_secret' => "XoTxDYe5NHxOCUqUKrOsO5vVaB8iexRCJRasEOOUQvxAC",
    'consumer_key' => "5WGB7905kZtoh2DqjAUwhJoSP",
    'consumer_secret' => "ygX5KtBGwjRoVNFCfJwGPiNOusWzI8ZFl7YneVl3jXmB6Jxnkf"
);
// will have to hide all these keys somehow in the future

// 

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=#KASTW';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

// var_dump(json_decode($response));

$results = json_decode($response, true);
foreach ($results['statuses'] as $search) {
    $tweet = $search['text'];
    echo $tweet;
    echo "<br>";
}
?>  