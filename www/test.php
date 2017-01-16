<!doctype HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>KAS Live</title>
	<link href="../assets/css/bootstrap-theme.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

	<!-- Jquery -->
	<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   
	integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>


	<script src="../assets/js/time.js" ></script>
	<script src="../assets/js/weather.js" ></script>
	<script src="../assets/js/calendar.js" ></script>
	<script src="../assets/js/airquality.js" ></script>
	<script src="../assets/js/mediaplay.js" ></script>
	<script src="../assets/js/jquery.vticker.min.js"></script>
	<script src="../assets/js/unslider-master/src/js/unslider.js"></script>

	<link rel="stylesheet" href="../assets/js/unslider-master/dist/css/unslider.css">
	<link rel="stylesheet" href="../assets/css/weather-icons.css">
	<link rel="stylesheet" href="../assets/js/unslider-master/dist/css/unslider-dots.css">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

	<script src="../assets/js/tabletop-master/src/tabletop.js"></script>
	<script src="../assets/js/underscore.js"></script>
	<script src="../assets/js/jquery.webticker.min.js"></script>
	<script src="https://use.fontawesome.com/31f4a97978.js"></script>
</head>
<body>

	<?php
	require_once('keys.php');	
	require_once('config.php');	
	require_once('mediahandler.php');
	?>


	<?php
	if ($fullscreen_mode) {
		include('body_full.php');	
	} else {
		include ('body_main.php');
	}
	 
	 ?>
	 <script>

		// SECTION FOR WORKING ON CANVAS
		// http://stackoverflow.com/questions/13807788/web-based-fullscreen-slideshow-with-video-elements (cc-by-sa 3.0)
		var canvas = $('#canvas');
		var imgsrc = '<img src="$" alt="" class="img-responsive center-block"/>';
		var vidsrc = '<video autoplay class="embed-responsive-item"><source src="$" type="video/mp4"></source></video>';
		var ytsrc = '<iframe id="yt" src="$"></iframe>'
		var gssrc = '<iframe src="$" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>'
		var current = -1;
		var regex = /(?:\.([^.]+))?$/;
		var imgTypes = ["png", "jpg", "jpeg"];
		var vidTypes = ["mov", "mp4", "m4v"];
		var player;

	</script>

	

</body>
</html>