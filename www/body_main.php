<div class="container-fluid">
		<div class="row">
			<div class="col-md-9">
				<div class="row" id="banner-module">
					<img src="../assets/pics/topbanner.png" class="img-responsive center-block" alt="kas logo" style="min-height:calc(19.5%); max-height:calc(19.5%)"/>

				</div>
				<div class="row vertical-align" id="ticker-module">
					<div class="text-center news-ticker" id="n-ticker" style="min-height:calc(5%); max-height:calc(5%);">Loading ticker...</div>
				</div>
				<div class="row vertical-align">
					<div class="col-md-12 text-center embed-responsive embed-responsive-16by9" style="min-height:calc(75%); max-height:calc(75%)">
						<div id="canvas" style="overflow: hidden;"><!-- VIDEO --></div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="row module-spacing text-center" id="time-module" style="min-height:calc(25%); max-height:calc(25%)">
					<div class="col-md-12">
						<span id="cal"></span><br>
						<span id="time"></span> <span id="ampm"></span>
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
				</div>
				<div class="row vertical-align icon-spacing module-spacing" id="weather-module" style="min-height:calc(15%); max-height:calc(15%)">
					<div class="icon col-md-2" id="weathericon">
						<i class="fa fa-cloud"></i>
					</div>
					<div class="col-md-10" style="line-height: 12px">
						<span class="data" id="aqi"></span> <span class="data-header">Air Quality</span><br>
						<span class="data" id="temp"></span><span class="data-header">°C (</span><span class="data-header" id="weatherconditions"></span><span class="data-header">) </span><span class="data-header" style="font-size: 16px; font-style: italic; text-align: right"><br>Powered by Dark Sky</span><br>
					</div>
				</div>
				<div class="row icon-spacing text-left module-spacing" id="calendar-module" >
					<div class="icon col-md-2">
						<i class="fa fa-calendar"></i>
					</div>
					<div class="col-md-10">
						<div class="slider" id="calendar-block">
							Unable to load calendar...
						</div>
					</div>
				</div>
				<div class="row icon-spacing module-spacing" id="twitter-module">
					<div class="icon col-md-2">
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
		echo "<script>var tweetArray; var userArray; var imgArray;</script>";
	$tweet_string = "<script>tweetArray =[";
	$user_string = "<script>userArray =[";
	$img_string = "<script>imgArray = [";
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
					$tweet_string .="'$tweet', ";
					$user_string .="'$username', ";
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
			$tweet_string .="'$tweet', ";
			$user_string .="'$username', ";
		}

	}
		$img_string = substr($img_string, 0, -1)."]</script>";
		echo $img_string;
		echo substr($user_string, 0, -2)."];</script>";
		echo substr($tweet_string, 0, -2)."];</script>";
	} else {
	}
	
	?>  



	<script>

	// twitticker

		

	if (userArray) {
	var twtext = "<ul>";
		for (tweet in userArray) {
		// alert("this a thingo");
		if (imgArray[tweet].length != 0) {
			// alert(imgArray[tweet]);
			// alert(imgArray[tweet].length)
			for (img in imgArray[tweet]) {
				twtext += "<li class='eventitem' style='word-wrap: break-word'>";
				twtext += "<img src=" + imgArray[tweet][img] + " height=350></img>";
				twtext += "</li>";
			}
		} else {
		twtext += "<li class='eventitem' style='word-wrap: break-word'>";
		twtext += "<span class='twuser'>@" + userArray[tweet] + "</span><br>"
		twtext += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
		twtext += "</li>";
	}
	}
	twtext += "</ul>";
	$('#twitter-block').html(twtext);
	} else {
	$('#twitter-block').html("Twitter data failed to load...")
	}
	

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
		 		startEmpty: false,
		 	});

		 </script>

<?php include("weatherhandler.php"); ?>

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
		var q = setTimeout(function(){
			$("#calendar-block").unslider({
				autoplay: true,
				infinite: true,
				arrows: false,
			nav: false,
			delay: 4500
		});
		}, 500);  // no idea why cant load normally

		var q = setTimeout(function(){
			$("#twitter-block").unslider({
				autoplay: true,
				infinite: true,
				arrows: false,
			nav: false,
			delay: 8000,
			animation: 'fade',
			animateHeight: true
		});
		}, 500);  

		startTicker();
		updateSchedule();
		var timeUpdate = setInterval(currentTime, 200);
		var aqiRefresh = setInterval(getAQI, 1000 * 1800); //update every half hour
		var tickerRefresh = setInterval(startTicker, 1000 * 60 * 10); //10 min update interval *one minute for testing
		var weatherRefresh = setInterval(getWeather, 1000 * 1200); //20 min update interval
		
	});

	// 
	
</script>