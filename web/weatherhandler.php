<?php
error_reporting(~0);
ini_set('display_errors', 1);
$config = require_once("../config/config.php");

$api = $config['weather_api']['api_key'];
$lat = $config['weather_api']['lat'];
$lon = $config['weather_api']['lon'];
$aqikey = $config['weather_api']['aqi'];
// echo $forecastio;
$weatherURL = "https://api.darksky.net/forecast/$api/$lat,$lon?units=si";
$weatherresults = json_decode(file_get_contents($weatherURL), true);
$current_temp = round($weatherresults["currently"]["temperature"]);
$current_icon = $weatherresults["currently"]["icon"];

//aqi
$aqiURL = "http://opendata.epa.gov.tw/ws/Data/REWIQA/?\$filter=SiteName%20eq%20'%E5%B7%A6%E7%87%9F'&format=json&token=$aqikey";

$aqi_results = json_decode(file_get_contents($aqiURL), true);
$current_aqi = $aqi_results[0]["AQI"];


// echo $weatherURL;
echo "$current_temp,$current_icon,$current_aqi";
// echo "<script>var now_temp = '$current_temp'; var now_icon = '$current_icon'</script>";
?>
