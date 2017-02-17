<?php 


$schedule = file_get_contents("scheduletest.json", true);
$schedule = json_decode($schedule, true);
// var_dump($schedule);

// echo $schedule["MonHS"][7]["block"];

function cleanup($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


if(isset($_POST['submitBlock'])) {
	$schedule[$_POST['day']][$_POST['itr']]["block"] = cleanup($_POST['blockform']);
	$schedule[$_POST['day']][$_POST['itr']]["start"] = cleanup($_POST['startform']);
	$schedule[$_POST['day']][$_POST['itr']]["end"] = cleanup($_POST['endform']);
	$new = json_encode($schedule);
	file_put_contents('scheduletest.json', $new);
}

if(isset($_POST['delete'])) {
	unset($schedule[$_POST['dayheader']]);
	$new = json_encode($schedule);
	file_put_contents('scheduletest.json', $new);
}

if(isset($_POST['reset'])) {
	$defaults = file_get_contents("schedule.json", true);
	$defaults = json_decode($defaults, true);
	// var_dump($defaults);
	file_put_contents('scheduletest.json', json_encode($defaults));
}

echo "<form action='' method='post'>
	<input type='submit' name='reset' value='Reset to default values'>
	</form>";
	echo "<br>";

foreach($schedule as $day => $sched) {
	echo $day;
	echo "<form action='' method='post'>
	<input type='hidden' value='$day' name='dayheader'>
	<input type='submit' name='delete' value='Remove Schedule'>
	</form>";
	echo "<br>";
	$i = 0;
	foreach($sched as $block) {
		$start_time = $block['start'];
		$end_time = $block['end'];
		$block_name = $block['block'];
		$hiddenvalue = "[\"$day\"][$i][\"block\"]";
		echo "From $start_time to $end_time: $block_name.";
		// echo $hiddenvalue;
		echo "<form action='' method='post'>
		<input type='hidden' value='$day' name='day'>
		<input type='hidden' value='$i' name='itr'>
		Edit Block: <input type='text' name='blockform' value='$block_name'>
		Start: <input type='text' name='startform' value='$start_time'>
		End: <input type='text' name='endform' value='$end_time'><input type='submit' name='submitBlock'></form>";
		echo "<br>";
		$i = $i + 1;
	}
	$i = 0;
	echo "<br>";
}


?>