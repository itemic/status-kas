

<div class="container-fluid" style="margin: 0;padding:0; right: 0; bottom: 0">
	<div class="embed-responsive embed-responsive-16by9">
		<div id="canvas" ><!-- VIDEO --></div>
	</div>

	
	<div class="overlay">
		<span id="overlaytime"></span>
		<span id="overlayampm"></span>
	</div>

</div>


<script>
	$(document).ready(function() {
		currentTime();
		playMedia();
		var timeUpdate = setInterval(currentTime, 200);

	})
</script>