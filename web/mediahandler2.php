<?php
	$config = require_once("../config/config.php");

	//matching YouTube URL
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
	$media_content = array();
	$slides_canvas = $config['media']['slides_canvas'];

	$is_connected = @fsockopen("www.youtube.com", 80);
	if ($is_connected) {
		fclose($is_connected);
		$is_connected = true;
	} else {
		$is_connected = false;
	}

	if ($slides_canvas && $is_connected) {
		array_push($media_content,$slides_canvas);
	}

	foreach (preg_grep('/^([^.])/', scandir($config['media']['file_location'])) as $media_file) {
		$ext = pathinfo($media_file, PATHINFO_EXTENSION);
		if (in_array(strtolower($ext), $valid_extension)) {
			$media_dir = $config['media']['file_location']."/".$media_file;
			array_push($media_content, $media_dir);
		}

	}

	if ($is_connected) {
		// ONLY get YOUTUBE Links if we're connected to Internet...
		$weblinks = fopen($config['media']['yt_filelist'], 'r');
			while ($line = fgets($weblinks)) {
				$yid = youtube_id_from_url($line);
				// echo $yid;
				if ($yid) {
					// it's a youtube link
					$youtube_link = "https://www.youtube.com/embed/$yid";
					// echo $youtube_link;
					array_push($media_content, $youtube_link);
				}
			}
		fclose($weblinks);
	}

	echo json_encode($media_content);





?>