// TIME/CALENDAR RELATED

function currentTime() {
    var now = moment();
    var clock = now.format("hh:mm")
    var calendar = now.format("dddd MMMM Do Y")

    var ap = now.format("A");
    if (!!document.getElementById("ampm")) {
    	document.getElementById("ampm").textContent=ap;
    } else {
        document.getElementById("overlayampm").textContent=ap;
    }

// This does nothing at all ;)
    if (now.month() == 03 && now.date() == 01) {
        $('*').css('font-family', 'Comic Sans MS')
        if (!!document.getElementById("cal")) {
            document.getElementById("cal").textContent = "HAPPY APRIL FOOLS " + now.year();
        }

    } else {
        if (!!document.getElementById("cal")) {
            document.getElementById("cal").textContent = calendar.toUpperCase();
        } else {

        }
    }
        if (!!document.getElementById("time")) {
            document.getElementById("time").textContent=clock;
        } else {
            document.getElementById("overlaytime").textContent=clock;
        }
    

    // refresh this twice a minute manually
    if (now.second() == 00 || now.second() == 30) {
   	    updateSchedule();
    }
}

function updateSchedule() {
	$.getJSON("schedule.json", function(data) {
        if (!!document.getElementById("hs") && !!document.getElementById("ms")) {
        document.getElementById("ms").textContent = getSchedule(data, "MS");
        document.getElementById("hs").textContent = getSchedule(data, "HS");
    }
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
        var start = moment(todays_schedule[interval]['start'], "HH:mm");
        var end = moment(todays_schedule[interval]['end'], "HH:mm");
        var thisblock = todays_schedule[interval]['block']
        start_time.set({'hour': start.hour(), 'minute': start.minute()})
        end_time.set({'hour': end.hour(), 'minute': end.minute()})
        // Current block is found!
        if (current_time.isSameOrAfter(start_time) && current_time.isBefore(end_time)) {
            current_block = todays_schedule[interval]['block'];
            break;
        }

    }
    if (!current_block) {
        current_block = "--"; //afterschool, night, any time without a specified block
    }
    return current_block

}


// MEDIA
function playMedia() {
    if (content.length != 0) {
        ++current;
        if (content.length == current) {
            current = 0;
        }

        var source = null;
        var file = content[current];
        var extension = regex.exec(file)[1];
        if (imgTypes.includes(extension)) {
            source = imgsrc.replace('$', file);
        }

        if (vidTypes.includes(extension)) {
            source = vidsrc.replace('$', file);
        }

        if (file.includes("youtube.com")) {
            file = file + "?enablejsapi=1&autoplay=1";
            source = ytsrc.replace('$', file);
        // alert(file);
    }

    if (file.includes("docs.google.com")) {
        source = gssrc.replace('$', file);
    }

    // alert(file);

    if (null !== source) {
        canvas.html(source);
        if (imgTypes.includes(extension)) {
            //it's a photo!
            setTimeout(function() {playMedia();}, imgDuration);
        }

        if (vidTypes.includes(extension)) {
            //it's a video!
            canvas.find('video').bind("ended", function() {
                playMedia();
            });
        }

        if (file.includes("youtube")) {
            if (isYTready) {
                player = new YT.Player('yt', {
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    },
                    playerVars: {'autoplay': 1, 'controls': 0}
                });
            }

        }

        if (file.includes("docs.google.com")) {
            //presentation :o
            setTimeout(function() {playMedia();}, slidesDuration);
        }
    }
}
}

// CALENDAR

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



// YouTube loading
    var yttag = document.createElement('script');
    yttag.src = 'https://www.youtube.com/iframe_api';
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(yttag, firstScriptTag);
        // console.log(document.getElementsByTagName('script')[0]);

        var isYTready=false;

        function onYouTubeIframeAPIReady() {
            isYTready=true;
        }

        function onPlayerReady(event) {
            
        }

        function onPlayerStateChange(event) {
            if (event.data == 0)  {
                playMedia();
            }
        }

// AIR QUALITY
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

// WEATHER
function getWeather() {
            var skycons = new Skycons({"color": "white"});
            // var iconhtml = '<i class="wi wi-forecast-io-' + now_icon + '"></i>';
            // skycons matches better but weathericons are kept in case it works better
            var iconhtml = '<canvas id="skycon" width="48" height="48"></canvas>'
            var weatherRequest = '../../www/weatherhandler.php'
            $.get(weatherRequest, {}, function(response, status) {
                if(status === 'success') {
                    var data = response.split(",")
                    var temp = data[0];
                    var now_icon = data[1];
                    var icon = '<i class="wi wi-forecast-io-' + now_icon + '"></i>';
                    //echoed is text, so then take the text and fill it in eh
                    document.getElementById('temp').textContent=temp + "°C" ;
                    document.getElementById('weathericon').innerHTML=icon;
                    skycons.set("skycon", now_icon);
                    skycons.play();
                }
                else {
                    document.getElementById('temp').textContent= "Error loading weather..." ;
                }
            })
            
            // document.getElementById('weatherconditions').innerHTML=now_cond.toUpperCase();
            
}