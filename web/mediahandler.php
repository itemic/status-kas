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

	if ($is_connected) {
		$slidelinks = fopen($config['media']['slides_filelist'], r);
		// $line = fgets($slidelinks); // just the first one ok
		while ($line = fgets($slidelinks)) {
			if ($line) {
			$querystring = array();
			$slides_data_array = explode(" ", trim($line));
			//FORMAT: num of slides, length of slides, slide link
			$numOfSlides = $slides_data_array[0];
			$urlOfSlides = $slides_data_array[1];
			parse_str($urlOfSlides, $querystring);
			$lenOfSlides = $querystring["delayms"];

			$slides_values = array($numOfSlides, $lenOfSlides, $urlOfSlides);

			if (sizeof($slides_data_array) == 2) {
			array_push($media_content,$slides_values);
		}
		}
		}


	}
	$file_root = $config['media']['file_location'];
	$all_files = array_slice(scandir($file_root), 2);

	foreach ($all_files as $media_file) {
		// echo "Is $media_file a directory? ";
		// echo is_dir($file_root."/".$media_file);
		if (is_dir($file_root."/".$media_file)) {
			// echo "$media_file is a directory.";
			$sub = array_slice(scandir($file_root."/".$media_file), 2);
			foreach ($sub as $sub_file) {
				// echo $sub_file;
				$ext = pathinfo($sub_file, PATHINFO_EXTENSION);
				if (in_array(strtolower($ext), $valid_extension)) {
				array_push($media_content,$file_root."/".$media_file."/".$sub_file);
				}
			}
		} else {
			$ext = pathinfo($media_file, PATHINFO_EXTENSION);
			if (in_array(strtolower($ext), $valid_extension)) {
			array_push($media_content,$media_file);
			}
		}
	}

	// $all_files = getDirContents($config['media']['file_location']);
	// foreach ($all_files as $media_file) {
	// 	$ext = pathinfo($media_file, PATHINFO_EXTENSION);
	// 	if (in_array(strtolower($ext), $valid_extension)) {
	// 		array_push($media_content,$media_file);
	// 	}
	// }


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



// FUNCTION CREDITS: http://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function
// credits to Hors Sujet for getDirContents();
	function getDirContents($dir, &$results = array()){
    $files = scandir($dir);
    $contents = array();
    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
    foreach($results as $key => $value) {
    	// echo $value . "         ";
    	$value = str_replace($_SERVER['DOCUMENT_ROOT'],'',$value);
    	// echo $value . " ";
    	array_push($contents, $value);
    }

    // var_dump($contents);
    // echo $value . " ";
    return $contents;
}





?>