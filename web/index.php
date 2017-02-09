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
	if ($config['mode']['fullscreen']) {
		// echo "<script>var fullscreen = true</script>";

		include('fullscreen.php');	
	} else {
		// echo "<script>var fullscreen = false</script>";
		include ('dashboard.php');

	}
	 
	 ?>
	 <script>
        var canvas = $('#canvas');



		// SECTION FOR WORKING ON CANVAS
		// http://stackoverflow.com/questions/13807788/web-based-fullscreen-slideshow-with-video-elements (cc-by-sa 3.0)


	</script>

	

</body>
</html>