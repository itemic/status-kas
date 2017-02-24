
<!doctype HTML> 
<html>

<!-- NOTE: INSTEAD OF ECHOING IT ALL, MAKE SEVERAL VARS AND ECHO THEM IN THE END TO MAKE THE LOOPS WORK BETTER :) -->
	<head>
		<script src="/js/jquery-3.1.1.min.js"></script>
		<script src="/js/bootstrap.js" ></script>
		<script src="/js/material.js" ></script>
		<script src="/js/ripples.js" ></script>
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-material-design.css">
		<link rel="stylesheet" href="/css/ripples.css">

		<style>
			.btn {
				margin-bottom: 2px;
				margin-top: 2px;
			}

			#logout {
				display: none;
			}
		</style>

		<?php
		$schedule = file_get_contents("scheduledisplay.json", true);
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
  			<p>This schedule editor is only to make quick changes if necessary. It is not meant to be a fully functional schedule editor that enables you to add blocks or schedules. If anything is messed up, simply reset to the default schedule.</p>
  			</div>
  			<form action='scheduler.php' method='post'>
		<button type='submit' name='reset' class='btn btn-warning btn-block btn-raised' >Reset schedule to defaults</button>
		</form>
		</div>

		
		</div>

		<?php 
		$columnloop = true; //true is NEW
			foreach($schedule as $day => $sched) {
				if ($columnloop) {
				echo "<div class='row'>";


				}
				
				echo "<div class=col-md-6>";
			echo "<div class='panel panel-info'>
				<div class='panel-heading'>
				<h3 class='panel-title'>$day
				</h3>
				</div>
				<div class='panel-body'>";
				$table = "<table class='table table-striped table-hover'>
				<thead>
				<tr>
				<th class='col-md-4'>Start</th>
				<th class='col-md-4'>Finish</th>
				<th class='col-md-4'>Block</th>
				<th class='col-md-6'>Settings</th>
				</tr>
				</thead>";
				// echo "<a href='javascript:void(0)' class='btn btn-default btn-sm btn-danger btn-raised'>Remove</a>";
					$i=0;
					foreach($sched as $block) {
						
						$start_time = $block['start'];
						$end_time = $block['end'];
						$block_name = $block['block'];
						$table.="<tr>
						<td class='col-md-4' style='vertical-align: middle'>$start_time</td>
						<td class='col-md-4' style='vertical-align: middle'>$end_time</td>
						<td class='col-md-4' style='vertical-align: middle'>$block_name</td>
						<td class='col-md-6'><button type='button' class='btn btn-info btn-raised btn-sm' data-toggle='modal' data-target='#edit$day$i'>Edit</button>

						";

						$modal.="
        <form action='scheduler.php' method='post'>
						<div class='modal ' id='edit$day$i'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h4 class='modal-title'>Edit Block</h4>
      </div>
      <div class='modal-body'>
        <div class='form-group'>
        <input type='hidden' value='$day' name='day'>
		<input type='hidden' value='$i' name='itr'>
  <label class='control-label' for='focusedInput1' >Block name</label>
  <input class='form-control' id='focusedInput1' type='text' value='$block_name' name='blockform'>
  <label class='control-label' for='focusedInput1' >Start time</label>
  <input class='form-control' id='focusedInput1' type='text' value='$start_time' name='startform'>
  <label class='control-label' for='focusedInput1 '>End time</label>
  <input class='form-control' id='focusedInput1' type='text' value='$end_time' name='endform'>
<label class='control-label' for='focusedInput1 '>Password</label>
  <input class='form-control' id='focusedInput1' type='password' value='' name='password'>
</div>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
		<button type='submit' name='submitBlock' class='btn btn-primary' >Confirm</button>
		<button type='submit' name='deleteBlock' class='btn btn-danger' >Delete</button>
      </div>
    </div>
  </div>
</div>
</form>




						";
							$i = $i + 1;
							

					}
					$table.="</table>";
					echo $table;
					echo $modal;
					$modal = "";
					$i = 0;
				echo "
				</div>



				<div class='panel-footer'>
				<button type='button' class='btn btn-danger btn-sm btn-raised' data-toggle='modal' data-target='#rm$day$i' >Remove</button>

				

				</td>
							</tr></div>


	



							<form action='scheduler.php' method='post'>
						<div class='modal ' id='rm$day$i'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h4 class='modal-title'>Edit Block</h4>
      </div>
      <div class='modal-body'>
      <input type='hidden' value='$day' name='dayheader'>
        Are you sure you want to delete this schedule? ($day)<br>
        <label class='control-label' for='focusedInput1 '>Password</label>
  <input class='form-control' id='focusedInput1' type='password' value='' name='password'>

      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-default' data-dismiss='modal'>Cancel</button>
        <button type='submit' name='delete' class='btn btn-warning' >Delete</button>
      </div>
    </div>
  </div>
</div>
</form>
					</div>

					</div>";
					if ($columnloop) {

								$columnloop = false;
							} else {
							echo "</div>";
								$columnloop = true;
							}
			}



		?>		


	</div>
	<script>$.material.init()</script>
	</body>

<?php 

$config = require('../config/config.php');
$password = $config['schedule']['pword'];



function cleanup($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


if(isset($_POST['submitBlock'])) {

	$block  = cleanup($_POST['blockform']);
	$start = cleanup($_POST['startform']);
	$end = cleanup($_POST['endform']);
	$pword = cleanup($_POST['password']);

	$schedule[$_POST['day']][$_POST['itr']]["block"] = $block;
	$schedule[$_POST['day']][$_POST['itr']]["start"] = $start;
	$schedule[$_POST['day']][$_POST['itr']]["end"] = $end;

	if ($pword == $password) {
	$new = json_encode($schedule);
	file_put_contents('scheduledisplay.json', $new);
	echo "<meta http-equiv='refresh' content='0'>";
}


}


if(isset($_POST['deleteBlock'])) {
	$pword = cleanup($_POST['password']);
	if ($pword == $password) {
	unset($schedule[$_POST['day']][$_POST['itr']]);
	$new = json_encode($schedule);
	file_put_contents('scheduledisplay.json', $new);
	echo "<meta http-equiv='refresh' content='0'>";
}
}

if(isset($_POST['delete'])) {
	$pword = cleanup($_POST['password']);
	if ($pword == $password) {
	unset($schedule[$_POST['dayheader']]);
	$new = json_encode($schedule);
	file_put_contents('scheduledisplay.json', $new);
	echo "<meta http-equiv='refresh' content='0'>";
}

}

if(isset($_POST['reset'])) {
	$defaults = file_get_contents("schedule.json", true);
	$defaults = json_decode($defaults, true);
	file_put_contents('scheduledisplay.json', json_encode($defaults));
	echo "<meta http-equiv='refresh' content='0'>";
}

?>