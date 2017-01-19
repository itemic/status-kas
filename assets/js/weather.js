var weatherApikey = "aaa5dabae3d52948d6e95364427ad305"
var weatherurl = "http://api.openweathermap.org/data/2.5/weather?q=Kaohsiung&units=metric&APPID="
var jsonweather = weatherurl+weatherApikey;

function getWeather2() {
	$.ajax({
		url: jsonweather,
		dataType: "jsonp",
		success: function(jcal) {
			var currentTemperature = Math.round(jcal.main.temp);
			var currentWeatherId = jcal.weather[0].id;
			var weatherType = jcal.weather[0].main;
			var icon = "wi-owm-"+currentWeatherId;
			if (currentWeatherId== 701) {icon = "wi-fog";} //API for "mist isn't best fit I don't think
			var iconhtml = '<i class="wi ' + icon + '"></i>';
			// console.log(currentWeather);
			// $('#temp').html(currentTemperature);
			document.getElementById('temp').textContent=currentTemperature;
			document.getElementById('weathericon').innerHTML=iconhtml;
			document.getElementById('weatherconditions').innerHTML=weatherType;
		}
	})
}

