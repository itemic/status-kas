<div class="container-fluid" id="whole-thing" style="height: 100%">
		<div class="row">
			<div class="col-md-9">
				<div class="row" id="banner-module" style=" height: 20vh">
					<img id="banner-img" style="height: 20vh"; src="../assets/pics/topbanner.png" class="img-responsive center-block" alt="kas logo"/>

				</div>
				<div class="row" id="ticker-module">
					<div class="text-center news-ticker" id="n-ticker">Loading ticker...</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center embed-responsive embed-responsive-16by9" style="height: 810px; min-height:calc(75%); max-height:calc(75%)">
						<div id="canvas" style="overflow: hidden;"><!-- VIDEO --></div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="row module-spacing text-center" id="time-module" >
					<div class="col-md-12">
						<span id="cal"></span><br>
						<span id="time"></span> <span id="ampm"></span>
						<div class="col-md-6">
						<div class="text-center">
							<span class="data-header">MS BLOCK</span><br>
							<span id="ms" class="data"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-center">
							<span class="data-header">HS BLOCK</span><br>
							<span id="hs" class="data"></span>
						</div>
					</div>
					</div>
				</div>
				<div class="row icon-spacing module-spacing outer-icon" id="calendar-module">
					<div class="icon col-md-2">
						<div class="icon"><i class="fa fa-calendar"></i></div>
					</div>
					<div class="col-md-10">
						<div class="slider" id="calendar-block">
							Unable to load calendar...
						</div>
					</div>
				</div>
				<div class="row icon-spacing module-spacing" id="weather-module">
					<div class="col-md-2 icon" id="weathericon">
						<i class="fa fa-cloud"></i>
					</div>
					<div class="col-md-10" style="line-height: 12px">
					<div class="row weathertable">
						<div class="col-md-12 weathertable">
							<span class="data" id="temp"></span>
						</div>
						<!-- <div class="col-md-8 weathertable">
							<span class="data-header" id="weatherconditions"></span>
						</div> -->
					</div>
					<div class="row weathertable">
						<div class="col-md-4 weathertable">
							<span class="data" id="aqi"></span>
						</div>
						<div class="col-md-8 weathertable">
							<span class="data-header-dark">AQI</span>
						</div>
					</div>
					<div class="row weathertable">
						<div class="col-md-12">
							<span class="data-header credits"><br>Powered by Dark Sky</span>
						</div>
						
					</div>
						
						
						
					</div>
				</div>
				
				<div class="row icon-spacing module-spacing" id="twitter-module">
					<div class="icon col-md-2 tw-icon">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</div>
					<div class="col-md-10">
						<div class="slider" id="twitter-block">
							Twitter data failed to load.
						</div>
					</div>

				</div>
				
			</div>
		</div>
	</div>

	<?php
	ini_set('display_errors', 1);
	require_once('TwitterAPIExchange.php');
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
	// If the results are empty that means there was some error getting Twitter stuff
	// TRAILING COMMAS ARE FINE LOL
	if ($results != "") { 
		echo "<script>var tweetArray; var userArray; var imgArray; var timeArray;</script>";
	$tweet_string = "<script>tweetArray =[";
	$user_string = "<script>userArray =[";
	$img_string = "<script>imgArray = [";
	$time_string = "<script>timeArray = [";
	foreach ($results as $search) {
		if ($filter_hashtags) {
			$entityhashtags = $search['entities']['hashtags'];
			
			
			
			foreach ($entityhashtags as $hashtag) {
				$hashtag_query = $hashtag['text'];
				if (!$case_sensitive_hashtags) {
					$hashtag_query = strtolower($hashtag_query);
				}
				if(in_array($hashtag_query, $display_hashtags)) {
				if (array_key_exists('media', $search['entities'])) {
				$entitymedia = $search['entities']['media'];
				$img_string.="[";
				// echo var_dump($entitymedia);
				foreach ($entitymedia as $twimg) {
					// echo $twimg["type"];
					$image_link = $twimg["media_url_https"];
					// echo $image_link;
					$img_string.="'$image_link', ";
				}
				$img_string = substr($img_string, 0, -1)."],";
				// $image_link = $entitymedia["media_url_https"];
				// echo ($image_link);
			} else {
				$img_string.="[],";
			}
					$tweet = addslashes($search['text']);
					$tweet = preg_replace('~[\r\n]+~', ' ', $tweet);
					$username = addslashes($search['user']['screen_name']);
					$time = $search['created_at'];
					$tweet_string .="'$tweet', ";
					$user_string .="'$username', ";
					$time_string .="'$time', ";
					break;
				}
			}
		} else {
			if (array_key_exists('media', $search['entities'])) {
				$entitymedia = $search['entities']['media'];
				$img_string.="[";
				// echo var_dump($entitymedia);
				foreach ($entitymedia as $twimg) {
					// echo $twimg["type"];
					$image_link = $twimg["media_url_https"];
					// echo $image_link;
					$img_string.="'$image_link', ";
				}
				$img_string = substr($img_string, 0, -1)."],";
				// $image_link = $entitymedia["media_url_https"];
				// echo ($image_link);
			} else {
				$img_string.="[],";
			}
			$tweet = addslashes($search['text']);
			$tweet = preg_replace('~[\r\n]+~', ' ', $tweet);
			$username = addslashes($search['user']['screen_name']);
			$time = $search['created_at'];
			$tweet_string .="'$tweet', ";
			$user_string .="'$username', ";
			$time_string .="'$time', ";
		}

	}
		$img_string = substr($img_string, 0, -1)."]</script>";
		echo $img_string;
		echo substr($time_string, 0, -2)."];</script>";
		echo substr($user_string, 0, -2)."];</script>";
		echo substr($tweet_string, 0, -2)."];</script>";
	} 
	
	?>  



	<script>

	// twitticker
	
	var TWEET_LINE_LENGTH = 140;
	var tweet_filled_entries = false; //if there are enough tweets for this "screen"

	if (userArray) {
		var twtext = "<ul>";
		for (tweet in userArray) {
			tweet_time = moment(timeArray[tweet]).fromNow();
			if (imgArray[tweet].length != 0) {
				if (tweet_filled_entries) {
					twtext += "</li>"
					tweet_filled_entries = false;
				}
				for (img in imgArray[tweet]) {
					twtext += "<li class='eventitem' style='word-wrap: break-word'>";
					twtext += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweet_time.toUpperCase()+ ")</span><br><br>"
					twtext += "<img class='twitter-image' src=" + imgArray[tweet][img] + " ></img>";
					twtext += "<span class='twtweet twimage'><br>" + tweetArray[tweet] + "</span>";
					twtext += "</li>";
				}
				tweet_filled_entries = false;
			} else if (tweetArray[tweet].length > TWEET_LINE_LENGTH) {
				if (tweet_filled_entries) {
					twtext += "</li>"
					tweet_filled_entries = false;
				}
				twtext += "<li class='eventitem' style='word-wrap: break-word'>";
				twtext += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweet_time.toUpperCase()+ ")</span><br>"
				twtext += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
				twtext += "</li>";	
				tweet_filled_entries = false;			
			} else if (!tweet_filled_entries) {
				twtext += "<li class='eventitem' style='word-wrap: break-word'>";
				twtext += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweet_time.toUpperCase()+ ")</span><br>"
				twtext += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
				twtext += "<br><br>"
				tweet_filled_entries = true;
			} else if (tweet_filled_entries) {
				twtext += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweet_time.toUpperCase()+ ")</span><br>"
				twtext += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
				twtext += "</li>";
				tweet_filled_entries - false;
			}

		}
		if (tweet_filled_entries) {
			twtext += "</li>"
		}
		twtext += "</ul>"
		$('#twitter-block').html(twtext);
	} else {
		$('#twitter-block').html("Twitter data failed to load...")
	}






</script>

	<script type="text/javascript">

		//new idea brief for next time
		//we have two arrays and we fetch a new array or something

		var public_spreadsheet_url = 'https://docs.google.com/spreadsheets/d/11Z_TJTHhb7Ivuq5swt5HYnJTSl9-cGMo3kKQ5768VUM/pubhtml';
		  var array = []; //i need a better name; array for info
		  function startTicker() {
		  	Tabletop.init( { key: public_spreadsheet_url,
		  		callback: showInfo,
		  		simpleSheet: true } )
		  }

		  function showInfo(data, tabletop) {
		  	newArray = []
		  	$.each(data, function(index, item) {
		  		newArray.push(data[index].Announcements)
		  	})


		  	if(_.isEqual(array.slice(0).sort(), newArray.slice(0).sort())) {
		  	} else {
		  		array = newArray;
		  		callTicker();
		  	}
		  }

		  function callTicker() {
		  	var html = ""
		  	$.each(array, function(index, item) {
		  		html += "<li> &nbsp;&nbsp;&nbsp;&nbsp; " + array[index] + "</li>"
		  	})
		 		$('#n-ticker').append(html);
		 		$('#n-ticker').webTicker('update', html, 'swap', true, false)
		 	}

		 	$('#n-ticker').webTicker({
		 		height: '36px',
		 		speed: 75,
		 		hoverpause: false,
		 		duplicate: true,
		 		startEmpty: false,
		 	});

		 </script>
		 
		 <?php
		 $now = gmdate("Y-m-d\TH:i:s\Z");
		 $cal_entries = 10;
		 $cal_link = "https://www.googleapis.com/calendar/v3/calendars/$calendar/events?key=$cal_apikey&timeMin=$now&maxResults=$cal_entries&singleEvents=true&orderBy=startTime";
		 $results = json_decode(file_get_contents($cal_link), true);

		 $cal_event = "<script> var eventName = [";
		 $cal_start = "<script> var eventStart = [";
		 $cal_end = "<script> var eventEnd = [";

		 foreach ($results["items"] as $cal_item) {
		 	$evt_name = addslashes($cal_item["summary"]);
		 	$evt_name = preg_replace('~[\r\n]+~', ' ', $evt_name);
		 	$evt_start = $cal_item["start"]["date"];
		 	$evt_end = $cal_item["end"]["date"];

		 	$cal_event .= "'$evt_name',";
		 	$cal_start .= "'$evt_start',";
		 	$cal_end .= "'$evt_end',";
		 }
		 echo substr($cal_event, 0, -2)."'];</script>";
		 echo substr($cal_start, 0, -2)."'];</script>";
		 echo substr($cal_end, 0, -2)."'];</script>";

		 ?>

		 

		 <script>
		 	$(document).ready(function() {
		 	currentTime();
		 	startTicker();
		 	updateSchedule();
		 	getAQI();
		 	getCal();
			playMedia(); //need a way to update
			getWeather();

			$("#calendar-block").unslider({
				autoplay: true,
				infinite: true,
				arrows: false,
			nav: false,
			delay: 4500
		});

			$("#twitter-block").unslider({
				autoplay: true,
				infinite: true,
				arrows: false,
			// nav: false,
			delay: 8000,
			animation: 'fade',
			animateHeight: true
		});

		var timeUpdate = setInterval(currentTime, 200);
		var aqiRefresh = setInterval(getAQI, 1000 * 1800); //update every half hour
		var tickerRefresh = setInterval(startTicker, 1000 * 60 * 10); //10 min update interval *one minute for testing
		var weatherRefresh = setInterval(getWeather, 1000 * 60 * 20); //20 min update interval
		
	});

	// 
	
</script>