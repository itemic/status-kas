<?php

// ///////////////////// //
// TWITTER FEED SETTINGS //
// ///////////////////// //

// Name of the Twitter list
$twitter_slug = "kaohsiung-american-school";
// echo $twitter_slug;
// Owner of the Twitter list
$twitter_owner = "VictorBoulanger";
// Whether or not to include retweets from the list
$include_rts = false;
// Only display tweets with specified hashtags
$filter_hashtags = false; // false not working yet
// Hashtags to be displayed
$display_hashtags = array(
	"KAStw",
	"KAStech"
	);
// Match the case of hashtags
$case_sensitive_hashtags = false;

// //////////////////// //
// MEDIAPLAYER SETTINGS //
// //////////////////// //

// Place where the media files are stored
$file_location = "../assets/media/";

// All media to be shown in the player
// Supports jpg, png, mp4, and YouTube links
$media_objects = array(
	1 => "",
	2 => "",
	);
?>