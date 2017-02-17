<!doctype HTML> 
<html>

<!-- NOTE: INSTEAD OF ECHOING IT ALL, MAKE SEVERAL VARS AND ECHO THEM IN THE END TO MAKE THE LOOPS WORK BETTER :) -->
	<head>
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-material-design.css">
		<link rel="stylesheet" href="/css/ripples.css">
		<script src="/js/material.js" ></script>
		<script src="/js/ripples.js" ></script>
		<?php
		$schedule = file_get_contents("scheduletest.json", true);
		$schedule = json_decode($schedule, true);
		?>
	</head>
	<body>
	<div class="container">
		<div class="page-header">
		<div class="row">
		<h2>ScheduleEdit</h2>
		<p class="text-primary">ScheduleEdit@KAS provides you with a quick way to change the current bell schedule. It is still in beta testing and will probably always be in beta but it's still pretty nice.</p>
		<div class="alert alert-warning">
		  <h4>Warning!</h4>
  			<p>I'll have some warning message here later.</p>
  			</div>
		</div>
		</div>

		<?php 
			foreach($schedule as $day => $sched) {
				echo "<div class='row'>
			<div class='panel panel-info'>
				<div class='panel-heading'>
				<h3 class='panel-title'>$day
				</h3>
				</div>
				<div class='panel-body'>";
				// echo "<a href='javascript:void(0)' class='btn btn-default btn-sm btn-danger btn-raised'>Remove</a>";
				echo "<table class='table table-striped table-hover'>
				<thead>
				<tr>
				<th>Start</th>
				<th>Finish</th>
				<th>Block</th>
				<th>Settings</th>
				</tr>
				</thead>";
					$i=0;
					foreach($sched as $block) {
						
						$start_time = $block['start'];
						$end_time = $block['end'];
						$block_name = $block['block'];
						echo "<tr>";
						echo "<td class='col-md-2' style='vertical-align: middle'>$start_time</td>";
						echo "<td class='col-md-2' style='vertical-align: middle'>$end_time</td>";
						echo "<td class='col-md-2' style='vertical-align: middle'>$block_name</td>";
						echo "<td class='col-md-4'><button type='button' class='btn btn-info btn-raised btn-sm' data-toggle='modal' data-target='#myModal'>Edit</button><button type='button' class='btn btn-danger btn-sm btn-raised' data-toggle='modal' data-target='#myModal'>Remove</button></td>";
						echo "</tr>";

					}
					echo "</table>";
				echo "
				</div>
					</div>

					</div>";
			}


		?>		
	</div>
	</body>


</html>


<?php 
// foreach($schedule as $day => $sched) {
// 	echo $day;
// 	echo "<form action='' method='post'>
// 	<input type='hidden' value='$day' name='dayheader'>
// 	<input type='submit' name='delete' value='Remove Schedule'>
// 	</form>";
// 	echo "<br>";
// 	$i = 0;
// 	foreach($sched as $block) {
		// $start_time = $block['start'];
		// $end_time = $block['end'];
		// $block_name = $block['block'];
// 		$hiddenvalue = "[\"$day\"][$i][\"block\"]";
// 		echo "From $start_time to $end_time: $block_name.";
// 		// echo $hiddenvalue;
// 		echo "<form action='' method='post'>
// 		<input type='hidden' value='$day' name='day'>
// 		<input type='hidden' value='$i' name='itr'>
// 		Edit Block: <input type='text' name='blockform' value='$block_name'>
// 		Start: <input type='text' name='startform' value='$start_time'>
// 		End: <input type='text' name='endform' value='$end_time'><input type='submit' name='submitBlock'></form>";
// 		echo "<br>";
// 		$i = $i + 1;
// 	}
// 	$i = 0;
// 	echo "<br>";
// }



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