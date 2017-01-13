<div class="container-fluid" style="height: 100%">
		<div class="row margin-spacing">
			<div class="col-md-9">
				<div class="row" style="height:5%">
					<img src="../assets/pics/topbanner.png" class="img-responsive center-block" alt="kas logo" style="width:55%"/>

				</div>
				<div class="row vertical-align">
					<div class="text-center news-ticker" id="n-ticker">COOL NEWS TICKER</div>
				</div>
				<div class="row vertical-align margin-spacing">
					<div class="col-md-12 text-center embed-responsive embed-responsive-16by9">
						<div id="canvas"><!-- VIDEO --></div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="row margin-spacing text-center">
					<div class="col-md-12">
						<span id="time"></span> <span id="ampm"></span><br>
						<span id="cal"></span>
					</div>
				</div>
				
				<div class="row text-center margin-spacing">
					<div class="col-md-6">
						<div class="text-center">
							<span class="data-header">MS Block</span><br>
							<span id="ms" class="data"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-center">
							<span class="data-header">HS Block</span><br>
							<span id="hs" class="data"></span>
						</div>
					</div>
				</div>
				<div class="row vertical-align margin-spacing icon-spacing">
					<div class="icon col-md-3" id="weathericon">
						<i class="fa fa-cloud"></i>
					</div>
					<div class="col-md-9">
						<span class="data" id="aqi"></span> <span class="data-header">Air Quality</span><br>
						<span class="data" id="temp"></span><span class="data-header">°C</span><br>
					</div>
				</div>
				<div class="row margin-spacing icon-spacing text-left" >
					<div class="icon col-md-3">
						<i class="fa fa-calendar"></i>
					</div>
					<div class="col-md-9">
						<div class="slider" id="calendar-block">
							CALENDAR
						</div>
					</div>
				</div>
				<div class="row margin-spacing icon-spacing">
					<div class="icon col-md-3">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</div>
					<div class="col-md-9">
						<div class="slider" id="twitter-block">
							TWITTER
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
	$getfield = "?slug=$twitter_slug&owner_screen_name=$twitter_owner&include_rts=$include_rts";
	$requestMethod = 'GET';

	$twitter = new TwitterAPIExchange($settings);
	$response = $twitter->setGetfield($getfield)
	->buildOauth($url, $requestMethod)
	->performRequest();

	$results = json_decode($response, true);

	if (!$case_sensitive_hashtags) {
		$display_hashtags = array_map('strtolower', $display_hashtags);
	}
	$hashtags_to_show = ["KAStw", "KAStech"];
	$tweet_string = "<script>var tweetArray =[";
	$user_string = "<script>var userArray =[";
	foreach ($results as $search) {

		if ($filter_hashtags) {
			$entityhashtags = $search['entities']['hashtags'];
			foreach ($entityhashtags as $hashtag) {
				$hashtag_query = $hashtag['text'];
				if (!$case_sensitive_hashtags) {
					$hashtag_query = strtolower($hashtag_query);
				}
				if(in_array($hashtag_query, $display_hashtags)) {
					$tweet = addslashes($search['text']);
					$tweet = preg_replace('~[\r\n]+~', ' ', $tweet);
					$username = addslashes($search['user']['screen_name']);
					$tweet_string .="'$tweet', ";
					$user_string .="'$username', ";
					break;
				}
			}
		} else {
			$tweet = addslashes($search['text']);
			$tweet = preg_replace('~[\r\n]+~', ' ', $tweet);
			$username = addslashes($search['user']['screen_name']);
			$tweet_string .="'$tweet', ";
			$user_string .="'$username', ";
		}



	}
	echo substr($user_string, 0, -2)."];</script>";
	echo substr($tweet_string, 0, -2)."];</script>";
	?>  



	<script>

	// twitticker
	var twtext = "<ul>";
	for (tweet in userArray) {
		// alert("this a thingo");
		twtext += "<li class='eventitem' style='word-wrap: break-word'>";
		twtext += "<span class='twuser'>@" + userArray[tweet] + "</span><br>"
		twtext += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
		twtext += "</li>";
	}
	twtext += "</ul>";
	$('#twitter-block').html(twtext);

</script>



<!--  -->


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
		 		startEmpty: true,
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
		 		myTime();
		 		startTicker();
		 		getAQI();
		 		getCal();
			playMedia(); //need a way to update
			getWeather();
		var q = setTimeout(function(){
			$("#calendar-block").unslider({
				autoplay: true,
				infinite: true,
				arrows: false,
			// nav: false,
			delay: 4500
		});
		}, 500);  // no idea why cant load normally

		var q = setTimeout(function(){
			$("#twitter-block").unslider({
				autoplay: true,
				infinite: true,
				arrows: false,
			// nav: false,
			delay: 8000,
			animation: 'fade',
			animateHeight: true
		});
		}, 500);  

		startTicker();
		updateSchedule();
		var timeUpdate = setInterval(myTime, 200);
		var aqiRefresh = setInterval(getAQI, 1000 * 1800); //update every half hour
		var tickerRefresh = setInterval(startTicker, 1000 * 60 * 10); //10 min update interval *one minute for testing
		var weatherRefresh = setInterval(getWeather, 1000 * 1200); //20 min update interval
		
		// var calendarRefresh = setInterval(getCal, 1000 * 3600 * 4); // unlikely that this needs to be updated frequently
	});

	// 
	
</script>