
// USE MOMENTJS FOR THIS
// FOR PRINTING, SET A MAX LINE SIZE
// IF EXCEED THAT, MULTILINE EVENT (BUT ONLY SHOW ONE)
// OTHERWISE YOU CAN SHOW TWO EVENTS

//EXAMPLE
// FEBRUARY 20
// Single Line
// FEBRUARY 21
// Single Line

// OR
// MARCH 3
// This is multiline
// event only

var LINE_LENGTH = 16;

		 	function cmprDate(start, length) {
		 		var today = moment().format("YYYY-MM-DD");
		 		var start = moment(start).format("YYYY-MM-DD");
		 		var end = moment(start).format("YYYY-MM-DD");
		 		moment(end).add(length, 'days').format("YYYY-MM-DD")
		 		alert(start + " < " + today + " < " + end)
		 		if (moment(start).isSame(today)) {
		 			// alert("TRUE sam")
		 			return true;
		 			
		 		}
		 		if (moment(today).isBetween(start, end)) {
		 			
		 			// alert("TRUE btw")
		 			return true;
		 			
		 		}
		 		// alert("Falso")
		 		return false;
		 	}

		 	function getCal() {
	// RIGHT NOW THIS RELIES ON THE FACT THAT CALENDAR EVENTS ARE 'all day' events!	
	var calText = "<ul>"
	var isBreak = true;
	for (evt in eventName) {
		var startDate = moment(eventStart[evt]).format("YYYY-MM-DD");
		var endDate = moment(eventEnd[evt]).format("YYYY-MM-DD");
		var deltaDays = moment(endDate).diff(startDate, 'days');
		var isMultiDayEvent = (deltaDays > 1);
		var lastDate = moment(startDate);
		lastDate = moment(lastDate).add(deltaDays-1, "days").format("YYYY-MM-DD");
		
		if (isBreak) {
			calText+="<li class='eventitem' style='word-wrap: break-word'>"
		}
		
		if (cmprDate(startDate, deltaDays)) {
			if (isMultiDayEvent) {
				calText += "<span class='caldate today'>" + startDate + "</span> <span class='caldate today' style='font-size: 75%'>to " + lastDate + "</span><br>";
			} else {
				calText += "<span class='caldate today'>" + startDate + "</span><br>";				
			}
			calText += "<span class='calevent today'>" + eventName[evt] + "</span><br>";
			if (isBreak) {
				// calText += "<br>";
				isBreak = false;
			} else {
				calText += "</li>";	
				isBreak = true;
			}
		} else {
			if (isMultiDayEvent) {
				calText += "<span class='caldate'>" + startDate + " </span> <span  class='caldate' style='font-size: 75%'>to " + lastDate + "</span><br>";
			} else {
				calText += "<span class='caldate'>" + startDate + "</span><br>";
			}
			
			calText += "<span class='calevent'>" + eventName[evt] + "</span><br>";
			if (isBreak) {
				// calText += "<br>";
				isBreak = false;
			} else {
				calText += "</li>";	
				isBreak = true;
			}
		}

	}
	if (isBreak) {
		calText += "</li>";
	}
	calText += "</ul>"
	$('#calendar-block').html(calText);
}
