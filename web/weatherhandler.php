<?php

$config = require_once("../config/config.php");

$api = $config['weather_api']['api_key'];
$lat = $config['weather_api']['lat'];
$lon = $config['weather_api']['lon'];
// echo $forecastio;
$weatherURL = "https://api.darksky.net/forecast/$api/$lat,$lon?units=si";
$weatherresults = json_decode(file_get_contents($weatherURL), true);
$current_temp = round($weatherresults["currently"]["temperature"]);
$current_icon = $weatherresults["currently"]["icon"];
// echo $weatherURL;
echo "$current_temp,$current_icon";
// echo "<script>var now_temp = '$current_temp'; var now_icon = '$current_icon'</script>";
?>
