
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

var LINE_LENGTH = 28;

function getCal() {
	// RIGHT NOW THIS RELIES ON THE FACT THAT CALENDAR EVENTS ARE 'all day' events!	
	var calText = "<ul>"
	var isBreak = true;
	var filledEntries = false;
	var today = moment();
	var todayDate = moment({year: today.year(), month: today.month(), date: today.date()});
	for (evt in eventName) {
		
		var startDate = moment(eventStart[evt]).format("YYYY-MM-DD");
		var endDate = moment(eventEnd[evt]).format("YYYY-MM-DD");
		var deltaDays = moment(endDate).diff(startDate, 'days');
		var isMultiDayEvent = (deltaDays > 1);
		var lastDate = moment(startDate);
		lastDate = moment(lastDate).add(deltaDays-1, "days").format("YYYY-MM-DD");

		startFormat = moment(startDate).format("ddd MMM D ")
		endFormat = moment(lastDate).format("ddd MMM D")

		var todayDateSelector
		var todayCalSelector
		var finalDateSelector

		if (moment(today).isSameOrAfter(startDate) && moment(today).isBefore(endDate)) {
			todayDateSelector = "<span class ='caldate caldate-today'>"
			todayEventSelector = "<span class ='calevent calevent-today'>"
			finalDateSelector = "<span  class='caldate caldate-today'>"
		} else {
			todayDateSelector = "<span class ='caldate'>"
			todayEventSelector = "<span class ='calevent'>"
			finalDateSelector = "<span  class='caldate'>"
		}
		if (eventName[evt].length > LINE_LENGTH) {
			// alert("LONG EVENT");
			if(filledEntries) {
				calText += "</li>"
				filledEntries = false;
			}
			calText+="<li class='eventitem' style='word-wrap: break-word'>"
			if (isMultiDayEvent) {
				calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span><br>";
			} else {
				calText += todayDateSelector + startFormat.toUpperCase() + "</span><br>";
			}
			calText += todayEventSelector + eventName[evt] + "</span></li>";	
		} else if (!filledEntries) {
			// alert("meep")
			calText+="<li class='eventitem' style='word-wrap: break-word'>"
			if (isMultiDayEvent) {
				calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span><br>";
			} else {
				calText += todayDateSelector + startFormat.toUpperCase() + "</span><br>";
			}
			calText += todayEventSelector + eventName[evt] + "</span><br><br>";
			filledEntries = true;
		} else if (filledEntries) {
			if (isMultiDayEvent) {
				calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span><br>";
			} else {
				calText += todayDateSelector + startFormat.toUpperCase() + "</span><br>";
			}
			calText += todayEventSelector + eventName[evt] + "</span></li>";
			filledEntries = false;
		}
		// TODO: Check if event is ongoing - if it is then do stuff
		// if (cmprDate(startDate, deltaDays)) 
	}
	if (filledEntries) {
		calText += "</li>";
	}
	calText += "</ul>"
	$('#calendar-block').html(calText);
}
