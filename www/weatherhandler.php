<?php
$requestURL = "https://api.darksky.net/forecast/$forecastio/$lat,$lon?units=si";
$weatherresults = json_decode(file_get_contents($requestURL), true);
$current_temp = round($weatherresults["currently"]["temperature"]);
$current_cond = $weatherresults["currently"]["summary"];
$current_icon = $weatherresults["currently"]["icon"];
echo "<script>var now_temp = '$current_temp'; var now_cond = '$current_cond'; var now_icon = '$current_icon'</script>";

?>
<script>
function getWeather() {
			var skycons = new Skycons({"color": "white"});
			// var iconhtml = '<i class="wi wi-forecast-io-' + now_icon + '"></i>';
			// skycons matches better but weathericons are kept in case it works better
			var iconhtml = '<canvas id="skycon" width="48" height="48"></canvas>'
			// now_temp = 40
			document.getElementById('temp').textContent=now_temp + "°C" ;
			document.getElementById('weathericon').innerHTML=iconhtml;
			// document.getElementById('weatherconditions').innerHTML=now_cond.toUpperCase();
			skycons.set("skycon", now_icon);
			skycons.play();
}
</script>