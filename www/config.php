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
$filter_hashtags = true; // false not working yet
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
// Indices are useful for sorting (TODO)
$media_objects = array(
	1 => "https://www.youtube.com/watch?v=uuC4YLLkqME",
	2 => "https://www.youtube.com/watch?v=Rykmwn0SMU",
	);

// Google Slides embed link goes here. As of now,
// the plan is to have this slides canvas take place
// before/after any of the media objects if it exists.
// This only supports one Google slide
$slides_canvas = "";

// I can't get the number of slides from the embed link
// Requires manual refresh.
$number_of_slides = 1;

// How long each slide should appear for
$slide_duration = 1000;
?>