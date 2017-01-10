function getAQI() {

	// IDK actually how to use webservices but this seems to work??
	//http://opendata.epa.gov.tw/Data/Details/AQI/?show=all
	$.ajax({
		url: "http://opendata.epa.gov.tw/webapi/api/rest/datastore/355000000I-001805?filters=SiteName%20eq%20'左營'&sort=SiteName&offset=0&format=json&token=+FnNny1OD023y6sJSIyDmA",
		dataType: "jsonp",
		success: function(data) {
		// var json = $.parseJSON(data);
		var json = data;

		for (arr in json.result.records) {
			var site = json.result.records[arr].SiteName;
			if (site == "左營") {
				// var pm = json.result.records[arr]["PM2.5"]
				var aqi = json.result.records[arr]["AQI"]
				// var update = json.result.records[arr]["PublishTime"]
				//TESTING USE BECAUSE ITS DUMB AND NOT WORKING
				// pm = 200	;

				

				var aqiquality;
				if (!aqi) {
					aqiquality = "--"
				} else if (aqi < 51) {
					aqiquality = "Good"
					$('#aqi').addClass("air-good")
					document.getElementById('aqi').className="air-good";
				} else if (aqi < 101) {
					aqiquality = "Moderate"
					$('#aqi').addClass("air-moderate")
					document.getElementById('aqi').className="air-moderate";
				} else if (aqi < 151) {
					aqiquality = "Unhealthy for sensitive groups"
					$('#aqi').addClass("air-unhealthsensitive")
					document.getElementById('aqi').className="air-unhealthsensitive";
				} else if (aqi < 201) {
					aqiquality = "Unhealthy"
					$('#aqi').addClass("air-unhealthy")
					document.getElementById('aqi').className="air-unhealthy";
				} else if (aqi < 301) {
					aqiquality = "Very unhealthy"
					$('#aqi').addClass("air-veryunhealthy")
					document.getElementById('aqi').className="air-veryunhealthy";
				} else {
					aqiquality = "Hazardous"
					$('#aqi').addClass("air-hazardous")
					document.getElementById('aqi').className="air-hazardous";
				}
				document.getElementById('aqi').className+=" data";
				$('#aqi').html(aqi);
				document.getElementById('aqi').html=aqi;

			}
		}
		
	}
});
}