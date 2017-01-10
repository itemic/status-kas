<!doctype HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>KAS Live</title>
	<link href="assets/css/bootstrap-theme.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

	<!-- Jquery -->
	<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   
	integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>


	<script src="assets/js/time.js" ></script>
	<script src="assets/js/weather.js" ></script>
	<!-- <script src="assets/js/calendar.js" ></script> -->
	<script src="assets/js/airquality.js" ></script>
	<script src="assets/js/mediaplay.js" ></script>
	<script src="assets/js/jquery.vticker.min.js"></script>
	<script src="assets/js/unslider-master/src/js/unslider.js"></script>

	<link rel="stylesheet" href="assets/js/unslider-master/dist/css/unslider.css">
	<link rel="stylesheet" href="assets/css/weather-icons.css">
	<link rel="stylesheet" href="assets/js/unslider-master/dist/css/unslider-dots.css">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

	<script src="assets/js/tabletop-master/src/tabletop.js"></script>
	<script src="assets/js/underscore.js"></script>
	<script src="assets/js/jquery.webticker.min.js"></script>
	<script src="https://use.fontawesome.com/31f4a97978.js"></script>
	
	
</head>
<body>
	<div class="container-fluid">
		<div class="row margin-spacing">
			<div class="col-md-9">
				<div class="row">
					<img src="assets/media/kas.png" class="img-responsive center-block" alt="kas logo" style="width:22.5%"/>

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
			</div>
		</div>

	</div>

<!-- get ready for twitter -->
	<script></script>
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
$tweet_string = "<script> var tweetArray =[";
$user_string = "<script>var userArray =[";
foreach ($results['statuses'] as $search) {
    $tweet = $search['text'];
    $username = $search['user']['screen_name'];
    $tweet_string .="'$tweet', ";
    $user_string .="'$username', ";

}	
	echo substr($user_string, 0, -2)."];</script>";
	echo substr($tweet_string, 0, -2)."];</script>";
?>  

<script>
// console.log(tweetArray);
// console.log(userArray);
// var tweethtml = "<ul class='slider'>"
// // for (tweet in tweetArray) {
// // 	tweethtml = tweethtml + "<span style='font-weight: bold; font-size: 16px; line-height: 50%'>@" + userArray[tweet] + "</span><br>" + "<span style='color:white;'>" + tweetArray[tweet] + "</span><br>";
// // }
// for (tweet in tweetArray) {
// 	tweethtml = tweethtml + "<li class='eventitem'>" + tweetArray[tweet] + "<br>@" + userArray[tweet] + "</li>";
// }
// tweethtml = tweethtml + "</ul>"
// $('#twt').html(tweethtml);
</script>

<script>
	// twitticker
	// alert(tweetArray);
	var twtext = "<ul>";
	for (tweet in tweetArray) {
		// alert("this a thingo");
		twtext += "<li class='eventitem' style='word-wrap: break-word'>";
		twtext += "<span style='font-size: 16px; line-height=55%; font-weight: bold'>@" + userArray[tweet] + "</span><br>"
		twtext += tweetArray[tweet];
		twtext += "</li>";
	}
	twtext += "</ul>";
	$('#twitter-block').html(twtext);
	// alert(twtext);

</script>

	<script>
	// YouTube loading
		var yttag = document.createElement('script');
		yttag.src = 'https://www.youtube.com/iframe_api';
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(yttag, firstScriptTag);
		// console.log(document.getElementsByTagName('script')[0]);

		var isYTready=false;

		function onYouTubeIframeAPIReady() {
			// alert("BANG");
			isYTready=true;
		}

		function onPlayerReady(event) {
			
		}

		function onPlayerStateChange(event) {
			if (event.data == 0) {
				playMedia();
			}
		}		
	</script>
	<?php

	function youtube_id_from_url($url) {
            $pattern = 
                '%^# Match any youtube URL
                (?:https?://)?  # Optional scheme. Either http or https
                (?:www\.)?      # Optional www subdomain
                (?:             # Group host alternatives
                  youtu\.be/    # Either youtu.be,
                | youtube\.com  # or youtube.com
                  (?:           # Group path alternatives
                    /embed/     # Either /embed/
                  | /v/         # or /v/
                  | /watch\?v=  # or /watch\?v=
                  )             # End path alternatives.
                )               # End host alternatives.
                ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
                $%x'
                ;
            $result = preg_match($pattern, $url, $matches);
            if ($result) {
                return $matches[1];
            }
            return false;
        }


		// echo scandir();
		$dir = "assets/media/";
		$files = scandir($dir);
		// $files = scandir("http://kas.tw/");
		unset($files[0], $files[1]);
		$string= "<script> var content = [";
		foreach ($files as $items) {
			$ext = pathinfo($items)['extension'];
			// echo $ext == "txt";
			if ($ext == "txt") {
				//read it for youtubies
				$ytfile = file($dir.$items);
				foreach ($ytfile as $item) {
					$yid = youtube_id_from_url($item);
					$ylink=  "http://www.youtube.com/embed/$yid";
					$string.="'$ylink', ";
				}
			} else if ($ext == "png" ||$ext == "jpg" ||$ext == "jpeg" ||$ext == "mov" ||$ext == "mp4" ||$ext == "m4v"){
				$string.= "'$dir$items', ";	
			} else {

			}
			
		}
		echo substr($string, 0, -2)."];</script>";
	?>
	<script>

		// SECTION FOR WORKING ON CANVAS
		// http://stackoverflow.com/questions/13807788/web-based-fullscreen-slideshow-with-video-elements (cc-by-sa 3.0)

		var mediaDir = "/assets/media/"
		var canvas = $('#canvas');
		var imgsrc = '<img src="$" alt="" class="img-responsive center-block"/>';
		var imgDuration = 5000; //ms
		var vidsrc = '<video autoplay class="embed-responsive-item"><source src="$" type="video/mp4"></source></video>';
		var ytsrc = '<iframe id="yt" src="$"></iframe>'
		var current = -1;
		var regex = /(?:\.([^.]+))?$/;
		var imgTypes = ["png", "jpg", "jpeg"];
		var vidTypes = ["mov", "mp4", "m4v"];
		var player;
	
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
		  	array.sort();
		  	newArray.sort();
		  	if(_.isEqual(array, newArray)) {
		  	} else {
		  		array = newArray;
		  		callTicker();
		  	}
		  }

		  function callTicker() {
		  	var html = ""
		  	$.each(array, function(index, item) {
		  		html += "<li> | " + array[index] + "</li>"
		  	})
		 		// $('#tickers').html("");
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
<script>
var calendarKey = "kas.kh.edu.tw_iv193c4dfh6prrut4cn5f1k8h4@group.calendar.google.com";
var APIkey = "AIzaSyAhLZQoSUvAJrXgpqNlilhgcxng1tAuj4o";
var numOfResults = 15;

var calJson = "https://www.googleapis.com/calendar/v3/calendars/" + calendarKey + "/events?key=" + APIkey + "&timeMin=" + new Date().toISOString() + "&maxResults=" + numOfResults + "&singleEvents=true&orderBy=startTime";


// console.log(calJson);

function getCal() {
	$.ajax({
		url: calJson,
		dataType: "jsonp",
		success: function(caldata) {
			var calText = "<ul>"
			for (evt in caldata.items) {
				calText+="<li class='eventitem' style='word-wrap: break-word'>";
				var eventName = caldata.items[evt].summary;
				var eventDate = caldata.items[evt].start.date;
				var evtDate = new Date(eventDate);
				var today = new Date();
				if (evtDate.getFullYear() === today.getFullYear() &&
					evtDate.getMonth() === today.getMonth() &&
					evtDate.getDate() === today.getDate()) {
					
					calText += "<span class='caldate today'>" + eventDate + "</span><br>";
					calText += "<span class='calevent today'>" + eventName + "</span><br>";
					calText += "</li>";

				} else {
					calText += "<span class='caldate'>" + eventDate + "</span><br>";
					calText += "<span class='calevent'>" + eventName + "</span><br>";
					calText += "</li>";
				}
				
			}
			calText += "</ul>"
			$('#calendar-block').html(calText);
			// alert(calText);
			// document.getElementById('calendar-block').html=calText;

		}
	});
}

// getCal();
</script>
<script>

</script>
<script>


	;
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
			nav: false,
		});
		}, 500);  // no idea why cant load normally

		var q = setTimeout(function(){
		$("#twitter-block").unslider({
			autoplay: true,
			infinite: true,
			arrows: false,
			nav: false,
			delay: 4500,
			animation: 'fade',
			animateHeight: true
		});
		}, 500);  
		

		var timeUpdate = setInterval(myTime, 200);
		var aqiRefresh = setInterval(getAQI, 1000 * 1800); //update every half hour
		var tickerRefresh = setInterval(init, 1000 * 600); //10 min update interval
		var weatherRefresh = setInterval(getWeather, 1000 * 1200); //20 min update interval
		
		// var calendarRefresh = setInterval(getCal, 1000 * 3600 * 4); // unlikely that this needs to be updated frequently
	});

	// 
	
</script>
<script></script>

</body>
</html>