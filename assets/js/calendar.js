// var calendarKey = "kas.kh.edu.tw_iv193c4dfh6prrut4cn5f1k8h4@group.calendar.google.com";
// var APIkey = "AIzaSyAhLZQoSUvAJrXgpqNlilhgcxng1tAuj4o";
// var numOfResults = 5;

// var calJson = "https://www.googleapis.com/calendar/v3/calendars/" + calendarKey + "/events?key=" + APIkey + "&timeMin=" + new Date().toISOString() + "&maxResults=" + numOfResults + "&singleEvents=true&orderBy=startTime";


// // console.log(calJson);

// function getCal() {
// 	$.ajax({
// 		url: calJson,
// 		dataType: "jsonp",
// 		success: function(caldata) {
// 			var calText = "<ul>"
// 			for (evt in caldata.items) {
// 				calText+="<li class='eventitem'>";
// 				var eventName = caldata.items[evt].summary;
// 				var eventDate = caldata.items[evt].start.date;
// 				calText += "<span class='caldate'>" + eventDate + "</span><br>";
// 				calText += "<span class='calevent'>" + eventName + "</span><br>";
// 				calText += "</li>";
// 			}
// 			calText += "</ul>"
// 			$('#calendar-block').append(calText);
// 			document.getElementById('calendar-block').html=calText;
// 			createTicker();

// 		}
// 	});
// }
// // getCal();