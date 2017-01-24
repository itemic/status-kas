function rawTime() {
	var clock = moment().format("hh:mm");
    var ap = moment().format("a");
    if (ap) {
    	document.getElementById("overlayampm").textContent=ap;
    }
    document.getElementById("overlaytime").textContent=clock;
}
function currentTime() {
    var now = moment();
    var clock = now.format("hh:mm")
    var calendar = now.format("dddd MMMM Do Y")

    var ap = now.format("A");
    if (ap) {
    	// ap = ":"+ss + " " +ap;
    	document.getElementById("ampm").textContent=ap;
    }

// This does nothing at all ;)
    if (now.month() == 03 && now.date() == 01) {
        $('*').css('font-family', 'Comic Sans MS')
        document.getElementById("cal").textContent = "HAPPY APRIL FOOLS " + now.year();

    } else {
        document.getElementById("cal").textContent = calendar.toUpperCase();
    }

    document.getElementById("time").textContent=clock;

    

    // refresh this 
    if (now.second() == 00 || now.second() == 30) {
   	    updateSchedule();
    }
}

function updateSchedule() {
	$.getJSON("schedule.json", function(data) {
        document.getElementById("ms").textContent = getSchedule(data, "MS");
        document.getElementById("hs").textContent = getSchedule(data, "HS");
	})

}

function getSchedule(data, division) {
    // FORMAT OF SCHEDULE FILE
    // XXYYYYMMDD{M|H}S for custom days
    // ddd{H|M}S for regular days (ddd = Sun, Mon, etc.)
    var todays_date = moment().format("YYYYMMDD");
    var todays_day = moment().format("ddd");
    var customSchedule = "XX" + todays_date + division
    var dailySchedule = todays_day + division;
    // First check for custom days
    // alert("o")
    if (customSchedule in data) {
        todays_schedule = data[customSchedule];
    } else {
        todays_schedule = data[dailySchedule]; // THIS HAS TO EXIST
    }
    // alert(todays_schedule)
    var current_time = moment();
    // current_time.set({'second': 0}) //so it updates on the minute
    var start_time = moment(current_time);
    var end_time = moment(current_time);
    var current_block;
    for (interval in todays_schedule) {
        var start = moment(todays_schedule[interval]['start'], "HH:mm");
        var end = moment(todays_schedule[interval]['end'], "HH:mm");
        var thisblock = todays_schedule[interval]['block']
        // console.log(start_time  + "< " + current_time + " " + thisblock + " < " + end_time)
        start_time.set({'hour': start.hour(), 'minute': start.minute()})
        end_time.set({'hour': end.hour(), 'minute': end.minute()})
        // if (current_time.isBetween(start_time, end_time, "[)")) {
        if (current_time.isSameOrAfter(start_time) && current_time.isBefore(end_time)) {
            current_block = todays_schedule[interval]['block'];
            // alert(division + "we set! " + todays_schedule[interval]['block'])
            break;
        }

    }
    if (!current_block) {
        current_block = "--";
    }
    return current_block

}




