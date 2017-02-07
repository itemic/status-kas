<?php
$config = require_once("../config/config.php");



$now = gmdate("Y-m-d\TH:i:s\Z");
$api_key = $config["calendar_api"]["api_key"];
$calendar_link = $config["calendar_api"]["calendar"];
$cal_entries = $config["calendar"]["entries"];
$cal_link = "https://www.googleapis.com/calendar/v3/calendars/$calendar_link/events?key=$api_key&timeMin=$now&maxResults=$cal_entries&singleEvents=true&orderBy=startTime";
$results = json_decode(file_get_contents($cal_link), true);

$cal_event = array();
$cal_start = array();
$cal_end = array();

foreach ($results["items"] as $cal_item) {
 	$evt_name = addslashes($cal_item["summary"]);
 	$evt_name = preg_replace('~[\r\n]+~', ' ', $evt_name);
 	$evt_start = $cal_item["start"]["date"];
 	$evt_end = $cal_item["end"]["date"];

 	array_push($cal_event, $evt_name);
 	array_push($cal_start, $evt_start);
 	array_push($cal_end, $evt_end);
 }

$data = [$cal_event, $cal_start, $cal_end];
echo json_encode($data);

?>