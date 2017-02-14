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
	require_once('../config/mediahandler.php');

	$config = require('../config/config.php');

	?>


	<?php
	$mode = $_GET["mode"];

	// $alt = $config['mode']['altmode'];
	if ($mode == "fullscreen") {
		include("fullscreen.php");
	} else if ($mode == "alt1") {
		include("altmode1.php");
	} else if ($mode == "alt2") {
		include("altmode2.php");
	} else {
		include("dashboard.php");
	}



	
	 
	 ?>

	 <script>
        var canvas = $('#canvas');
        
        var imgsrc = '<img src="$" alt="" class="img-responsive center-block"/>';
        var vidsrc = '<video autoplay class="embed-responsive-item"><source src="$" type="video/mp4"></source></video>';
        var ytsrc = '<iframe id="yt" src="$"></iframe>'
        var gssrc = '<iframe src="$" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>'
        // var gssrc = '<iframe src="$" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>'
        var current = -1;
        var imgTypes = ["png", "jpg", "jpeg"];
        var vidTypes = ["mp4", "mov", "m4v", "webm"];
        var player;





		// SECTION FOR WORKING ON CANVAS
		// http://stackoverflow.com/questions/13807788/web-based-fullscreen-slideshow-with-video-elements (cc-by-sa 3.0)


	</script>

	

</body>
</html>