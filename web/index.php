<?php 	header("X-Frame-Options: GOFORIT"); ?>
<!doctype HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>KAS Live</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	
	<!-- Jquery -->

	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="status.js" ></script>
	<script src="/js/moment.js" ></script>
	<script src="/js/skycons.js" ></script>
	<script src="/js/jquery.vticker.min.js"></script>
	<script src="/js/unslider-master/src/js/unslider.js"></script>
	<script src="/js/tabletop-master/src/tabletop.js"></script>
	<script src="/js/underscore.js"></script>
	<script src="/js/jquery.webticker.min.js"></script>
	<!-- <script src="https://use.fontawesome.com/31f4a97978.js"></script> -->
	
	<link rel="stylesheet" href="/js/unslider-master/dist/css/unslider.css">
	<link rel="stylesheet" href="/js/unslider-master/dist/css/unslider-dots.css">




	<script src="/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>

	<?php

	$config = require('../config/config.php');
	$imgduration = $config['media']['image_duration'];
	$slidesduration = $config['media']['slides_duration'];
	$numOfSlides = $config['media']['slides_count'];
	$totalduration = $slidesduration * $numOfSlides
	
	
	$mode = $_GET["mode"];
	echo "<script>imgDuration = $imgduration; slidesDuration = $totalduration</script>";


	// $alt = $config['mode']['altmode'];
	if ($mode == "fullscreen") {
		include("fullscreen.php");
	} else {
		include("dashboard.php");
	}



	
	 
	 ?>

	 <script>
        // var canvas = $('#canvas');
        

        canvas = $('#canvas');
  
        // var canvas = $('#canvas');
        var imgsrc = '<img src="$" alt="" class="img-responsive center-block"/>';
        var vidsrc = '<video autoplay class="embed-responsive-item" id="videosource"  preload="auto"><source src="$" type="video/mp4"></source></video>';
        var ytsrc = '<iframe id="yt" src="$"></iframe>'
        var gssrc = '<iframe src="$" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>'
        // var gssrc = '<iframe src="$" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>'
        var current = -1;
        var imgTypes = ["png", "jpg", "jpeg"];
        var vidTypes = ["mp4", "mov", "m4v", "webm"];
        var player;




        //SHARED SCRIPT
        $(document).ready(function() {
        	currentTime();
			content = processMedia();
			playMedia(); //need a way to update

        	var timeUpdate = setInterval(currentTime, 200);
        })



	</script>

	

</body>
</html>