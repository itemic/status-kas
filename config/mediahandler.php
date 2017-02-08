<?php
	$config = require_once("../config/config.php");



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

	$valid_extension = array("png", "jpg", "jpeg", "mov", "mp4", "m4v", "webm");
	$mediaplayer_str = "<script> var content = [";

	$img_duration = $config['media']['image_duration'];
	$slides_canvas = $config['media']['slides_canvas'];
	$slides_count = $config['media']['slides_count'];
	$slides_duration = $config['media']['slides_duration'];


	$duration_str = "<script>";
	$duration_str.="var imgDuration=$img_duration;";
	if ($slides_canvas) {
		$mediaplayer_str.="'$slides_canvas', ";
		$total_slide_time = $slides_count * $slide_duration;
		$duration_str.="slidesDuration = $total_slide_time;";
	} else {
		$duration_str.="slidesDuration = 0;";
	}
	$duration_str.= "</script>";
	echo $duration_str;
	foreach (preg_grep('/^([^.])/', scandir($config['media']['file_location'])) as $media_file) {
		$ext = pathinfo($media_file, PATHINFO_EXTENSION);
		if (in_array(strtolower($ext), $valid_extension)) {
			$media_dir = $config['media']['file_location']."/".$media_file;
			$mediaplayer_str.="'$media_dir', ";
		}

	}
	$weblinks = fopen($config['media']['yt_filelist'], 'r');
	while ($line = fgets($weblinks)) {
		$yid = youtube_id_from_url($line);
		// echo $yid;
		if ($yid) {
			// it's a youtube link
			$youtube_link = "https://www.youtube.com/embed/$yid";
			// echo $youtube_link;
			$mediaplayer_str.="'$youtube_link', ";
		}
	}
	fclose($weblinks);
	// $mediaplayer_str = substr($mediaplayer_str, 0, -2);
	$mediaplayer_str.="];</script>";
	echo $mediaplayer_str;
	?>