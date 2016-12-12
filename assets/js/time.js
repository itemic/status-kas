const dayOfWeek = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

window.setUp = function() {
	myTime
}

window.myTime = function() {
    var today = new Date();
    var hh = today.getHours();
    var mm = today.getMinutes();
    var ss = today.getSeconds();

    var ap;
    var clock;

    var month = months[today.getMonth()];
    var day = dayOfWeek[today.getDay()];
    day = day.charAt(0).toUpperCase() + day.slice(1);
    var date = today.getDate();
    var year = today.getFullYear();

    var suffix;
    if (date == 1 || date == 21 || date == 31) 	{ suffix = "st"; } else
    if (date == 2 || date == 22)				{ suffix = "nd"; } else 
    if (date == 3 || date == 23)				{ suffix = "rd"; } else
    											{ suffix = "th"; }

	if (mm < 10) {mm = "0" + mm};
    if (ss < 10) {ss = "0" + ss};

    // -------- Twelve Hour Code -------- //
    // Uncomment for 12-hour clock
    if (hh > 12) {
    	hh = hh % 12 || 12
    	ap = "pm";
    } else {
    	ap = "am";
    }
    // ------ ------ ------ ------ ------ //
	clock = hh + ":" + mm; // no seconds
	clock = hh + ":" + mm + ":" + ss;

	var calendar = day +", " + month + " " + date + suffix + ", " + year;
    if (ap) {
    	document.getElementById("ampm").textContent=ap;
    }
    document.getElementById("time").textContent=clock;
    document.getElementById("cal").textContent = calendar;
    var timeout = setTimeout(myTime, 200);
    updateSchedule();

    // only actually change the content on the hour
    if (mm == 00) {
   	    updateSchedule();
    }
}

function updateSchedule() {
	document.getElementById("ms").textContent = new Schedule(schedule).currentBlock("MS");
    document.getElementById("hs").textContent = new Schedule(schedule).currentBlock("HS");
}

function Schedule(schedule) {
	this.schedule = schedule;

	this.currentBlock = function(division) {
		var today = new Date();

		// only update schedule once a minute



		var dayScheduleType = dayOfWeek[today.getDay()] + division;
		var block;
		if(dayScheduleType in schedule) {
			//if it's on saturday or not recognized
			var jsonSchedule = schedule[dayScheduleType];
			for (var interval in schedule[dayScheduleType]) {
			if (today >= parseTimeString(jsonSchedule[interval][0]) && today < parseTimeString(jsonSchedule[interval][1])) {
				// Check if the current time is within range
				block = interval;
				break;
			}
		}
		} 

		if(!block) {
			//if it's not a block 
			block = "--";
		}
		return block;
	}
}

function testOut() {
	// var block = schedule["mondayHS"]
	var sc = new Schedule(schedule);
	console.log(sc.currentBlock("HS"));

}











var schedule = {
	"mondayHS": {
		"A": 		["8:00", "8:50"],
		"A>B": 		["8:50", "8:55"],
		"B": 		["8:55", "9:45"],
		"B>E": 		["9:45", "9:50"],
		"E": 		["9:50", "10:40"],
		"Break": 	["10:40", "10:55"],
		"D": 		["10:55", "11:45"],
		"D>C": 		["11:45", "11:50"],
		"C": 		["11:50", "12:40"],
		"Lunch": 	["12:40", "13:15"],
		"F": 		["13:15", "14:05"],
		"F>G": 		["14:05", "14:10"],
		"G": 		["14:10", "15:00"]
	},
	"mondayMS": {
		"A": 		["8:00", "8:50"],
		"A>B": 		["8:50", "8:55"],
		"B": 		["8:55", "9:45"],
		"B>E": 		["9:45", "9:50"],
		"E": 		["9:50", "10:40"],
		"Break": 	["10:40", "10:55"],
		"D": 		["10:55", "11:45"],
		"Lunch": 	["11:45", "12:20"],
		"C": 		["12:20", "13:10"],
		"C>F": 		["13:10", "13:15"],
		"F": 		["13:15", "14:05"],
		"F>G": 		["14:05", "14:10"],
		"G": 		["14:10", "15:00"]
	},
	"tuesdayHS": {
		"B": 		["8:00", "9:30"],
		"Break": 	["9:30", "9:45"],
		"D": 		["9:45", "11:15"],
		"D>C": 		["11:15", "11:20"],
		"C": 		["11:20", "12:50"],
		"Lunch": 	["12:50", "13:25"],
		"Lunch>E":	["13:25", "13:30"],
		"E": 		["13:30", "15:00"]
	},
	"tuesdayMS": {
		"B": 		["8:00", "9:30"],
		"Break": 	["9:30", "9:45"],
		"D": 		["9:45", "11:15"],
		"Lunch":	["11:15", "11:50"],
		"Lunch>C":	["11:50", "11:55"],
		"C": 		["11:55", "13:25"],
		"C>E":		["13:25", "13:30"],
		"E": 		["13:30", "15:00"]
	},
	"wednesdayHS": {
		"F": 		["8:00", "9:30"],
		"Break": 	["9:30", "9:45"],
		"G": 		["9:45", "11:15"],
		"G>Flex":	["11:15", "11:20"],
		"Flex": 	["11:20", "12:05"],
		"Flex>Adv": ["12:05", "12:10"],
		"Advisory": ["12:10", "12:50"],
		"Lunch": 	["12:50", "13:25"],
		"Lunch>A":	["13:25", "13:30"],
		"A": 		["13:30", "15:00"]
	},
	"wednesdayMS": {
		"F": 		["8:00", "9:30"],
		"Break": 	["9:30", "9:45"],
		"G": 		["9:45", "11:15"],
		"G>Adv": 	["11:15", "11:20"],
		"Advisory": ["11:20", "12:05"],
		"Lunch": 	["12:05", "12:40"],
		"Lunch>Flx":["12:40", "12:45"],
		"Flex": 	["12:45", "13:25"],
		"Flex>A":	["13:25", "13:30"],
		"A": 		["13:30", "15:00"]
	},
	"thursdayHS": {
		"B": 		["8:00", "8:50"],
		"B>D": 		["8:50", "8:55"],
		"D": 		["8:55", "9:45"],
		"D>E": 		["9:45", "9:50"],
		"E": 		["9:50", "10:40"],
		"Break": 	["10:40", "10:55"],
		"F": 		["10:55", "11:45"],
		"F>G": 		["11:45", "11:50"],
		"G": 		["11:50", "12:40"],
		"Lunch": 	["12:40", "13:15"],
		"A": 		["13:15", "14:05"],
		"A>C": 		["14:05", "14:10"],
		"C": 		["14:10", "15:00"]
	},
	"thursdayMS": {
		"B": 		["8:00", "8:50"],
		"B>D": 		["8:50", "8:55"],
		"D": 		["8:55", "9:45"],
		"D>E": 		["9:45", "9:50"],
		"E": 		["9:50", "10:40"],
		"Break": 	["10:40", "10:55"],
		"F": 		["10:55", "11:45"],
		"Lunch": 	["11:45", "12:20"],
		"G": 		["12:20", "13:10"],
		"G>A": 		["13:10", "13:15"],
		"A": 		["13:15", "14:05"],
		"A>C": 		["14:05", "14:10"],
		"C": 		["14:10", "15:00"]
	},
	"fridayHS": {
		"D": 		["8:00", "8:50"],
		"D>E": 		["8:50", "8:55"],
		"E": 		["8:55", "9:45"],
		"E>F": 		["9:45", "9:50"],
		"F": 		["9:50", "10:40"],
		"Break": 	["10:40", "10:55"],
		"G": 		["10:55", "11:45"],
		"G>A": 		["11:45", "11:50"],
		"A": 		["11:50", "12:40"],
		"Lunch": 	["12:40", "13:15"],
		"C": 		["13:15", "14:05"],
		"C>B": 		["14:05", "14:10"],
		"B": 		["14:10", "15:00"]
	},
	"fridayMS": {
		"D": 		["8:00", "8:50"],
		"D>E": 		["8:50", "8:55"],
		"E": 		["8:55", "9:45"],
		"E>F": 		["9:45", "9:50"],
		"F": 		["9:50", "10:40"],
		"Break": 	["10:40", "10:55"],
		"G": 		["10:55", "11:45"],
		"Lunch": 	["11:45", "12:20"],
		"G": 		["12:20", "13:10"],
		"G>C": 		["13:10", "13:15"],
		"C": 		["13:15", "14:05"],
		"C>B": 		["14:05", "14:10"],
		"B": 		["14:10", "15:00"]
	}


}


function parseTimeString(timeStr) {
	//format is [h]h:mm
	if (timeStr.length == 4) {
		var hour = timeStr[0];
		var min = timeStr.slice(2,4);
		// console.log(hour);
		// console.log(min);
	} else {
		var hour = timeStr.slice(0,2);
		var min = timeStr.slice(3, 5);
		// console.log(hour);
		// console.log(min);
	}

	var today = new Date();
	today.setHours(hour, min, 0, 0);
	// console.log(today);
	return today;
}






