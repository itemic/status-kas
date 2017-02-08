<!-- THIS IS A VERSION WITH KEYS REMOVED -->
<!-- THE OLD KEYS ARE PROBABLY NO LONGER WORKING -->

<?php
return [
	'twitter' => [
		'slug' 				=> '',
		'owner' 			=> '',
		'include_rts' 		=> false,
		'filter_hashtags' 	=> true,
		'display_hashtags' 	=> [],
		'case_sensitive'	=> false,
		'tweet_count'		=> 150
	],
	
	'media' => [
		'file_location'		=> "/media/",
		'media_objects'		=> [],
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
		'spreadsheet_url' 	=> ""
	],

	'twitter_api' => [
		'oauth_token' 		=> "",
		'oauth_secret'		=> "",
		'cons_key'			=> "",
		'cons_secret'		=> "",
	],

	'calendar_api' => [
		'calendar'			=> "",
		'api_key'			=> ""
	],

	'weather_api' => [
		'api_key'			=> "",
		'lat'				=> "22.676",
		'lon'				=> "120.294"
	]
];
?>