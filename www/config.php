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
$filter_hashtags = false; // 
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
	// "https://www.youtube.com/watch?v=GeoUELDgyM4",
	"timetabletest.png",
	"floormap.png",
	"upcoming.png",
	"schedulechange.png"
	// "kas.png",
	//"../pics/topbanner.png"
	);


// Default duration for photo in slideshow
$default_duration = 4500;


// Google Slides embed link goes here. As of now,
// the plan is to have this slides canvas take place
// before/after any of the media objects if it exists.
// This only supports one Google Slides presentation.
$slides_canvas = "https://docs.google.com/presentation/d/1BXimfuzoYSf-9dRwqtAD8f0SH5uJsmnzHe0lGFKW7WM/embed?start=true&loop=false&delayms=5000";
// $slides_canvas = "";

// NOTE: Ensure that there are values here even if
// there is no slideshow necessary. 
// ($slides_canvas can be left blank) 

// I can't get the number of slides from the embed link
// Requires manual refresh.
$number_of_slides = 2;

// How long each slide should appear for
// This is part of the embed link as well.
// Ensure that this value matches the one in the 
// embed link
$slide_duration = 5000;

// /////////////////// //
// FULLSCREEN SETTINGS //
// /////////////////// //

// Enable to only show the mediaplayer
$fullscreen_mode = false;
?>