<?php
$config = require_once("../config/config.php");

$api = $config['weather_api']['api_key'];
$lat = $config['weather_api']['lat'];
$lon = $config['weather_api']['lon'];
$aqikey = $config['weather_api']['aqi'];
// echo $forecastio;
$weatherURL = "https://api.darksky.net/forecast/$api/$lat,$lon?units=si";
$weatherresults = json_decode(file_get_contents($weatherURL), true);
$current_temp = ($weatherresults["currently"]["temperature"]);
//aqi
$aqiURL = "https://opendata.epa.gov.tw/webapi/api/rest/datastore/355000000I-000259?filters=SiteName%20eq%20'%E5%B7%A6%E7%87%9F'&format=json&token=$aqikey";
//https://opendata.epa.gov.tw/Data/Contents/ATM00679/ AQI Source

$aqi_results = json_decode(file_get_contents($aqiURL), true);
$current_aqi = $aqi_results["result"]["records"][0]["AQI"];


if (!$current_temp) {
	$current_temp = "--";
} else {
	$current_temp = round($current_temp);
}
$current_icon = $weatherresults["currently"]["icon"];

if (!$current_aqi) {
	$current_aqi = '';
}




// echo $weatherURL;
echo "$current_temp,$current_icon,$current_aqi";
// echo "<script>var now_temp = '$current_temp'; var now_icon = '$current_icon'</script>";
?>