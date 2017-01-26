<?php
require_once("keys.php");
$weatherURL = "https://api.darksky.net/forecast/$forecastio/$lat,$lon?units=si";
$weatherresults = json_decode(file_get_contents($weatherURL), true);
$current_temp = round($weatherresults["currently"]["temperature"]);
$current_icon = $weatherresults["currently"]["icon"];
// echo $weatherURL;
echo "$current_temp,$current_icon";
// echo "<script>var now_temp = '$current_temp'; var now_icon = '$current_icon'</script>";
?>
