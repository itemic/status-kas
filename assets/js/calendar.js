
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

var LINE_LENGTH = 24;

		 	function cmprDate(start, length) {
		 		var today = moment().format("YYYY-MM-DD");
		 		var start = moment(start).format("YYYY-MM-DD");
		 		var end = moment(start).format("YYYY-MM-DD");
		 		moment(end).add(length, 'days').format("YYYY-MM-DD")
		 		// alert(start + " < " + today + " < " + end)
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
	var filledEntries = false;
	for (evt in eventName) {
		
		var startDate = moment(eventStart[evt]).format("YYYY-MM-DD");
		var endDate = moment(eventEnd[evt]).format("YYYY-MM-DD");
		var deltaDays = moment(endDate).diff(startDate, 'days');
		var isMultiDayEvent = (deltaDays > 1);
		var lastDate = moment(startDate);
		lastDate = moment(lastDate).add(deltaDays-1, "days").format("YYYY-MM-DD");

		startFormat = moment(startDate).format("ddd MMM Do")
		endFormat = moment(lastDate).format("ddd MMM Do")

		var todayDateSelector
		var todayCalSelector
		var finalDateSelector

		if (cmprDate(startDate, deltaDays)) {
			todayDateSelector = "<span class ='caldate today'>"
			todayEventSelector = "<span class ='calevent today'>"
			finalDateSelector = "<span  class='caldate today' style='font-size: 75%'>"
		} else {
			todayDateSelector = "<span class ='caldate'>"
			todayEventSelector = "<span class ='calevent'>"
			finalDateSelector = "<span  class='caldate' style='font-size: 75%'>"
		}
		// if (isBreak) {
		// 	calText+="<li class='eventitem' style='word-wrap: break-word'>"
		// }
		// alert(eventName[evt]);
		if (eventName[evt].length > LINE_LENGTH) {
			// alert("LONG EVENT");
			if(filledEntries) {
				calText += "</li>"
				filledEntries = false;
			}
			calText+="<li class='eventitem' style='word-wrap: break-word'>"
			if (isMultiDayEvent) {
				calText += todayDateSelector + startFormat + " </span>" + finalDateSelector + "to " + endFormat + "</span><br>";
			} else {
				calText += todayDateSelector + startFormat + "</span><br>";
			}
			calText += todayEventSelector + eventName[evt] + "</span></li>";	
		} else if (!filledEntries) {
			// alert("meep")
			calText+="<li class='eventitem' style='word-wrap: break-word'>"
			if (isMultiDayEvent) {
				calText += todayDateSelector + startFormat + " </span>" + finalDateSelector + "to " + endFormat + "</span><br>";
			} else {
				calText += todayDateSelector + startFormat + "</span><br>";
			}
			calText += todayEventSelector + eventName[evt] + "</span><br><br>";
			filledEntries = true;
		} else if (filledEntries) {
			if (isMultiDayEvent) {
				calText += todayDateSelector + startFormat + " </span>" + finalDateSelector + "to " + endFormat + "</span><br>";
			} else {
				calText += todayDateSelector + startFormat + "</span><br>";
			}
			calText += todayEventSelector + eventName[evt] + "</span></li>";
			filledEntries = false;
		}
		// TODO: Check if event is ongoing - if it is then do stuff
		// if (cmprDate(startDate, deltaDays)) 
	}
	if (filledEntries == 1) {
		calText += "</li>";
	}
	calText += "</ul>"
	$('#calendar-block').html(calText);
}
