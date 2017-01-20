const dayOfWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
// const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];

function rawTime() {
	var clock = moment().format("hh:mm");
    var ap = moment().format("a");
    if (ap) {
    	document.getElementById("overlayampm").textContent=ap;
    }
    document.getElementById("overlaytime").textContent=clock;
}
function currentTime() {
    var clock = moment().format("hh:mm");
    var calendar = moment().format("dddd, MMMM Do, Y")
    var ap = moment().format("A");
    if (ap) {
    	// ap = ":"+ss + " " +ap;
    	document.getElementById("ampm").textContent=ap;
    }
    document.getElementById("time").textContent=clock;
    document.getElementById("cal").textContent = calendar;

    // refresh this 
    if (moment().second() == 00 || moment().second() == 30) {
   	    updateSchedule();
    }
}

function updateSchedule() {
	$.getJSON("classes.json", function(data) {
        // for (thing in data) {
        //     alert(thing)
        // }
        document.getElementById("ms").textContent = getSchedule(data, "MS");
        document.getElementById("hs").textContent = getSchedule(data, "HS");
	// document.getElementById("ms").textContent = new Schedule(data).currentBlock("MS");
    // document.getElementById("hs").textContent = new Schedule(data).currentBlock("HS");
	})

}

function getSchedule(data, division) {
    //FORMAT OF SCHEDULE FILE
    // XXYYYYMMDD{M|H}S for custom days
    // ddd{H|M}S for regular days (ddd = Sun, Mon, etc.)
    var todays_date = moment().format("YYYYMMDD");
        var todays_day = moment().format("ddd");

    var customSchedule = "XX" + todays_date + division
    var dailySchedule = todays_day + division;
    // First check for custom days
    if (customSchedule in data) {
        todays_schedule = data[customSchedule];
    } else {
        todays_schedule = data[dailySchedule]; // THIS HAS TO EXIST
    }
    var current_time = moment();
    var start_time = moment(current_time);
    var end_time = moment(current_time);
    var current_block;
    for (interval in todays_schedule) {
        var start = moment(todays_schedule[interval][0], "H:mm");
        var end = moment(todays_schedule[interval][1], "H:mm");
        start_time.set({'hour': start.hour(), 'minute': start.minute(), 'second': start.second()})
        end_time.set({'hour': end.hour(), 'minute': end.minute(), 'second': end.second()})
        if (current_time.isBetween(start_time, end_time)) {
            current_block = interval;
            break;
        }

    }
    if (!current_block) {
        current_block = "--";
    }
    return current_block
    //with a bell schedule object, now we want to see what time range it falls between
}

// function Schedule(schedule) {
// 	this.schedule = schedule;

// 	this.currentBlock = function(division) {
// 		var today = new Date();
// 		// only update schedule once a minute



// 		var dayScheduleType = dayOfWeek[today.getDay()] + division;
// 		var block;
// 		if(dayScheduleType in schedule) {
// 			//if it's on saturday or not recognized
// 			var jsonSchedule = schedule[dayScheduleType];
// 			for (var interval in schedule[dayScheduleType]) {
// 			if (today >= parseTimeString(jsonSchedule[interval][0]) && today < parseTimeString(jsonSchedule[interval][1])) {
// 				// Check if the current time is within range
// 				block = interval;
// 				break;
// 			}
// 		}
// 		} 

// 		if(!block) {
// 			//if it's not a block 
// 			block = "--";
// 		}
// 		return block;
// 	}
// }


function parseTimeString(timeStr) {
	//format is [h]h:mm
	if (timeStr.length == 4) {
		var hour = timeStr[0];
		var min = timeStr.slice(2,4);
	} else {
		var hour = timeStr.slice(0,2);
		var min = timeStr.slice(3, 5);
	}

	var today = new Date();
	today.setHours(hour, min, 0, 0);
	return today;
}






