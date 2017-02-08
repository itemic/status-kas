<?php
return [
	'twitter' => [
		'slug' 				=> 'kaohsiung-american-school',
		'owner' 			=> 'VictorBoulanger',
		'include_rts' 		=> false,
		'filter_hashtags' 	=> true,
		'display_hashtags' 	=> ['KASTW',
								'KAStech'],
		'case_sensitive'	=> false,
		'tweet_count'		=> 150
	],
	
	'media' => [
		'file_location'		=> "media",
		'media_objects'		=> ["https://www.youtube.com/watch?v=gUEhQ65FOJ8"
								],
		'image_duration'	=> 3000,
		'slides_canvas'		=> "",
		'slides_count'		=> 2,
		'slides_duration'	=> 5000
	
	],

	'calendar' => [
		'entries' 			=> 10
	],

	'mode' => [
		'fullscreen'		=> false
	],

	'news_ticker' => [
		'spreadsheet_url' 	=> "https://docs.google.com/spreadsheets/d/11Z_TJTHhb7Ivuq5swt5HYnJTSl9-cGMo3kKQ5768VUM/pubhtml"
	],

	'twitter_api' => [
		'oauth_token' 		=> "757478231159169024-R8wjOyBYCEalHEpOVEFmgchgVLxpekj",
		'oauth_secret'		=> "XoTxDYe5NHxOCUqUKrOsO5vVaB8iexRCJRasEOOUQvxAC",
		'cons_key'			=> "5WGB7905kZtoh2DqjAUwhJoSP",
		'cons_secret'		=> "ygX5KtBGwjRoVNFCfJwGPiNOusWzI8ZFl7YneVl3jXmB6Jxnkf",
	],

	'calendar_api' => [
		'calendar'			=> "kas.kh.edu.tw_iv193c4dfh6prrut4cn5f1k8h4@group.calendar.google.com",
		'api_key'			=> "AIzaSyAhLZQoSUvAJrXgpqNlilhgcxng1tAuj4o"
	],

	'weather_api' => [
		'api_key'			=> "a16af3b757f5e314c507e6fda482d046",
		'lat'				=> "22.676",
		'lon'				=> "120.294",
		'aqi'				=>	"+FnNny1OD023y6sJSIyDmA"
	]
];
?>