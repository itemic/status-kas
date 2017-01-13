
		 	function addDays(date, days) {
		 		var result = new Date(date);
		 		result.setDate(result.getDate() + days)
		 		return result;
		 	}

		 	function cmprDate(start, length) {
		 		var today = new Date();
		 		var end = addDays(start, length);

		 		today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
		 		start = new Date(start.getFullYear(), start.getMonth(), start.getDate());
		 		end = new Date(end.getFullYear(), end.getMonth(), end.getDate());

		 		if (start === today) {
		 			return true;
		 		}
		 		if ((start < today) && (today <= end)) {
		 			return true;
		 		}
		 		return false;
		 	}

		 	function getCal() {
	// RIGHT NOW THIS RELIES ON THE FACT THAT CALENDAR EVENTS ARE 'all day' events!	
	var calText = "<ul>"
	var isBreak = true;
	// var today = new Date();
	for (evt in eventName) {
		if (isBreak) {
			calText+="<li class='eventitem' style='word-wrap: break-word'>"
		}
		var startDate = new Date(eventStart[evt]);
		var endDate = new Date(eventEnd[evt]);
		var deltaDays = (endDate - startDate)/(1000*60*60*24) - 1;
		var isMultiDayEvent = (deltaDays > 0);
		var lastDate = addDays(startDate, deltaDays).toLocaleDateString('en-US');
		// alert(endDate + " " + addDays(startDate, deltaDays));
		if (cmprDate(startDate, deltaDays)) {
			if (isMultiDayEvent) {
				calText += "<span class='caldate today'>" + startDate.toLocaleDateString('en-US') + "</span> <span class='caldate today' style='font-size: 75%'>to " + lastDate + "</span><br>";
			} else {
				calText += "<span class='caldate today'>" + startDate.toLocaleDateString('en-US') + "</span><br>";				
			}
			calText += "<span class='calevent today'>" + eventName[evt] + "</span><br>";
			if (isBreak) {
				calText += "<br>";
				isBreak = false;
			} else {
				calText += "</li>";	
				isBreak = true;
			}
		} else {
			if (isMultiDayEvent) {
				calText += "<span class='caldate'>" + startDate.toLocaleDateString('en-US') + " </span> <span  class='caldate' style='font-size: 75%'>to " + lastDate + "</span><br>";
			} else {
				calText += "<span class='caldate'>" + startDate.toLocaleDateString('en-US') + "</span><br>";
			}
			
			calText += "<span class='calevent'>" + eventName[evt] + "</span><br>";
			if (isBreak) {
				calText += "<br>";
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
