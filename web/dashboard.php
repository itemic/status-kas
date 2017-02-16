
<div class="container-fluid" id="whole-thing" style="height: 100%">
		<div class="row">
			<div class="col-md-9">
				<div class="row" id="banner-module" style=" height: 20vh">
					<img id="banner-img" style="height: 20vh"; src="../img/topbanner.png" class="img-responsive center-block" alt="kas logo"/>

				</div>
				<div class="row" id="ticker-module">
					<div class="text-center news-ticker" id="n-ticker"></div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center embed-responsive embed-responsive-16by9" style="height: 810px; min-height:calc(75%); max-height:calc(75%)">
						
						<div id="canvas" ><!-- VIDEO --></div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="row module-spacing text-center" id="time-module" >
					<div class="col-md-12">
						<span id="cal"></span><br>
						<span id="time"></span> <span id="ampm"></span>
						<div class="col-md-6">
						<div class="text-center">
							<span class="data-header">MS BLOCK</span><br>
							<span id="ms" class="data"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-center">
							<span class="data-header">HS BLOCK</span><br>
							<span id="hs" class="data"></span>
						</div>
					</div>
					</div>
				</div>
				<div class="row icon-spacing module-spacing outer-icon" id="calendar-module">
					<div class="icon col-md-2">
						<div class="icon"><i class="fa fa-calendar"></i></div>
					</div>
					<div class="col-md-10">
					<div id="calendar-wrapper">
						<div class="slider" id="calendar-block">
							Unable to load calendar...
						</div>						
					</div>

					</div>
				</div>
				<div class="row icon-spacing module-spacing" id="weather-module">
			
					<div class="col-md-2 icon" id="weathericon">
						<i class="fa fa-cloud"></i>
					</div>
					<div class="col-md-4">
						<span class="data" id="temp"></span><br>
						<span class="micro-weather-text">Powered by Dark Sky</span>

					</div>

					<div class="col-md-2 icon" id="aqiicon">
						<i class="fa fa-leaf"></i>
					</div>

					<div class="col-md-4">
						<span class="data" id="aqi"></span><br>
						<span class="micro-weather-text">Air Quality Index</span>
					</div>


				</div>


				<div class="row icon-spacing module-spacing" id="twitter-module">
					<div class="icon col-md-2 tw-icon">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</div>
					<div class="col-md-10">
						<div id="twitter-wrapper"> 
							<div class="slider" id="twitter-block">
								Twitter data failed to load.
							</div>
						</div>
					</div>

				</div>
				
			</div>
		</div>
	</div>



	<script type="text/javascript">

		//new idea brief for next time
		//we have two arrays and we fetch a new array or something

		var public_spreadsheet_url = "<?php echo $config['news_ticker']['spreadsheet_url']; ?>";
		  var array = []; //i need a better name; array for info
		  function startTicker() {
		  	Tabletop.init( { key: public_spreadsheet_url,
		  		callback: showInfo,
		  		simpleSheet: true } )
		  }

		  function showInfo(data, tabletop) {
		  	newArray = []
		  	$.each(data, function(index, item) {
		  		newArray.push(data[index].Announcements)
		  	})


		  	if(_.isEqual(array.slice(0).sort(), newArray.slice(0).sort())) {
		  	} else {
		  		array = newArray;
		  		callTicker();
		  	}
		  }

		  function callTicker() {
		  	var html = ""
		  	$.each(array, function(index, item) {
		  		html += "<li> &nbsp;&nbsp;&nbsp;&nbsp; " + array[index] + "</li>"
		  	})
		 		$('#n-ticker').append(html);
		 		$('#n-ticker').webTicker('update', html, 'swap', true, false)
		 	}

		 	$('#n-ticker').webTicker({
		 		height: '36px',
		 		speed: 75,
		 		hoverpause: false,
		 		duplicate: true,
		 		startEmpty: false,
		 	});

		 </script>
		 


		 <script>
		 	$(document).ready(function() {
		 	currentTime();
		 	startTicker();
		 	updateSchedule();
		 	getCalendar();
			getWeather();
			getTwitter();


		
			//twitter refresh every 20 minutes
		var twitterUpdate = setInterval(updateSlider, 1000 * 60 * 20); 
		var calendarUpdate = setInterval(updateCalendar, 1000 * 60 * 60 * 2) //calendar update every two hours
		var timeUpdate = setInterval(currentTime, 200);
		var tickerRefresh = setInterval(startTicker, 1000 * 60 * 5); //5 min update interval *one minute for testing
		var weatherRefresh = setInterval(getWeather, 1000 * 60 * 5); //5 min update interval
		
	});

	// 
	
</script>