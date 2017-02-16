
content = "";
// TIME/CALENDAR RELATED

function currentTime() {
    var now = moment();
    var clock = now.format("h:mm")
    var calendar = now.format("ddd MMM Do Y")

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
    var customSchedule = division + todays_date
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
    console.log(content);
    var regex = /(?:\.([^.]+))?$/;
    if (content.length != 0) {
        ++current;
        if (content.length == current) {
            content = processMedia();
            current = 0;
        }

        var source = null;
        var file = content[current];
        if (file !== undefined) {
            //look if the file is undefined we want source to stay null!
            var extension = regex.exec(file)[1].toLowerCase();
            if (imgTypes.includes(extension)) {
                source = imgsrc.replace('$', file);
            }

            if (vidTypes.includes(extension)) {
                source = vidsrc.replace('$', file);
                // canvas.getContext('2d').fillText("MEMES");
                // var context = document.getElementById('canvas');
                // context.getContext('2d');
            }

            if (file.includes("youtube.com")) {
                file = file + "?enablejsapi=1&autoplay=1";
                source = ytsrc.replace('$', file);

            }

            if (file.includes("docs.google.com")) {
                source = gssrc.replace('$', file);

            }
        }



    if (null !== source) {

        canvas.html(source);



        // alert(source);
        // alert('<iframe src="https://docs.google.com/presentation/d/1Wrto7IPH_g2snRRy1T-UxChEji7he3ejX0KcJn1mhx8/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>')
        // canvas.html('<iframe src="https://docs.google.com/presentation/d/1Wrto7IPH_g2snRRy1T-UxChEji7he3ejX0KcJn1mhx8/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>')
        if (imgTypes.includes(extension)) {
            //it's a photo!
            setTimeout(function() {playMedia();}, imgDuration);
        }

        if (vidTypes.includes(extension)) {
            var videoElement = document.getElementById("videosource");

            setTimeout(function() {
                console.log(videoElement.readyState);
                if (videoElement.readyState < 3) {
                    playMedia();
                }
            }, 5000)

            videoElement.addEventListener("waiting", function() {
                playMedia();
            }, false)


            canvas.find('video').bind("ended", function() {
                playMedia();
            });
        }

        if (file.includes("youtube")) {
            var checkYouTube = setInterval(function () {
                if (isYTready) {
                player = new YT.Player('yt', {
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    },
                    playerVars: {'autoplay': 1, 'controls': 1}
                });
                clearInterval(checkYouTube);
            }
            }, 100);


            // if (isYTready) {
            //     player = new YT.Player('yt', {
            //         events: {
            //             'onReady': onPlayerReady,
            //             'onStateChange': onPlayerStateChange
            //         },
            //         playerVars: {'autoplay': 1, 'controls': 0}
            //     });
            // } else {
            //     console.log("not ready")
            // }

        }

        if (file.includes("docs.google.com")) {
            //presentation :o
            setTimeout(function() {playMedia();}, slidesDuration);
        }
    } else {
        playMedia();
    }
} else {
    source = imgsrc.replace('$', "img/placeholder.png");
    canvas.html(source);
    setTimeout(function() {content = processMedia(); current = 0; playMedia();}, 1000 * 8) //poll every 8 sec
}
}


// CALENDAR

var LINE_LENGTH = 48;





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
                // console.log("end")
                playMedia();
            }
        }




// WEATHER
function getWeather() {
            var skycons = new Skycons({"color": "white"});
            // var iconhtml = '<i class="wi wi-forecast-io-' + now_icon + '"></i>';
            // skycons matches better but weathericons are kept in case it works better
            var iconhtml = '<canvas id="skycon" width="48" height="48"></canvas>'
            var weatherRequest = 'weatherhandler.php'
            $.get(weatherRequest, {}, function(response, status) {
                if(status === 'success') {
                    var data = response.split(",")
                    var temp = data[0];
                    var now_icon = data[1];
                    var aqi = data[2];

                    document.getElementById('temp').textContent=temp + "°C" ;
                    document.getElementById('weathericon').innerHTML=iconhtml;
                    skycons.set("skycon", now_icon);
                    skycons.play();


                    // AQI PORTION
                    var aqiquality;
                    if (aqi==="") {
                        aqi = "--"
                    } else if (aqi < 51) {
                        $('#aqi').addClass("air-good")
                        document.getElementById('aqi').className="air-good";
                    } else if (aqi < 101) {
                        $('#aqi').addClass("air-moderate")
                        document.getElementById('aqi').className="air-moderate";
                    } else if (aqi < 151) {
                        $('#aqi').addClass("air-unhealthsensitive")
                        document.getElementById('aqi').className="air-unhealthsensitive";
                    } else if (aqi < 201) {
                        $('#aqi').addClass("air-unhealthy")
                        document.getElementById('aqi').className="air-unhealthy";
                    } else if (aqi < 301) {
                        $('#aqi').addClass("air-veryunhealthy")
                        document.getElementById('aqi').className="air-veryunhealthy";
                    } else {
                        $('#aqi').addClass("air-hazardous")
                        document.getElementById('aqi').className="air-hazardous";
                    }
                    document.getElementById('aqi').className+=" data";
                    $('#aqi').html(aqi);
                    document.getElementById('aqi').html=aqi;
                

                } else {
                    document.getElementById('temp').textContent= "Error loading weather..." ;
                    document.getElementById('aqi').textContent= "Error loading AQI...";
                }
            })
            
            
}

// TWITTER
function getTwitter() {
            var twitterRequest = 'twitterhandler.php'
            $.get(twitterRequest, {}, function(response, status) {
                if(status === 'success') {
                    var data = JSON.parse(response);
                    // console.log(data);
                    tweetArray = data[0];
                    userArray = data[1];
                    imageArray = data[2];
                    timeArray = data[3];
                    // console.log(tweetArray);
                    // console.log(userArray);
                    // console.log(imageArray)
                    // console.log(timeArray);
                    var TWEET_LINE_LENGTH = 140;
                    var tweetFilled = false;

                    if (userArray) {
                        var tweetText = "<ul>";
                        for (tweet in userArray) {
                            tweetTime = moment(timeArray[tweet]).fromNow();
                            if (imageArray[tweet].length != 0) {
                                if (tweetFilled) {
                                    tweetText += "</li>"
                                    tweetFilled = false;
                                }
                                for (image in imageArray[tweet]) {
                                    tweetText += "<li class='eventitem' style='word-wrap: break-word'>";
                                    tweetText += "<span class='twuser'>@"+ userArray[tweet].toUpperCase() + " (" + tweetTime.toUpperCase() + ")</span><br>"
                                    tweetText += "<img class='twitter-image' src='"+imageArray[tweet][image] + "'</span>";
                                    tweetText += "<span class='twtweet twimage'><br>" + tweetArray[tweet] + "</span>";
                                    tweetText += "</li>"
                                }
                                tweetFilled = false;
                            } else if (tweetArray[tweet].length > TWEET_LINE_LENGTH) {
                                if (tweetFilled) {
                                    tweetText += "</li>";
                                    tweetFilled = false;
                                }
                                //241+
                                tweetText += "<li class='event item' style='word-wrap: break-word'>";
                                tweetText += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweetTime.toUpperCase() + ")</span><br>";
                                tweetText += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
                                tweetText += "</li>";
                                tweetFilled = false;
                            } else if (!tweetFilled) {
                                tweetText += "<li class='event item' style='word-wrap: break-word'>";
                                tweetText += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweetTime.toUpperCase() + ")</span><br>";
                                tweetText += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
                                tweetText += "<br><br>";
                                tweetFilled = true;                                
                            } else if (tweetFilled) {
                                tweetText += "<span class='twuser'>@" + userArray[tweet].toUpperCase() + " (" + tweetTime.toUpperCase() + ")</span><br>";
                                tweetText += "<span class='twtweet'>" + tweetArray[tweet] + "</span>";
                                tweetText += "</li>";
                                tweetFilled = false;
                            }
                        }
                        if (tweetFilled) {
                            tweetText += "</li>";
                        }
                        tweetText += "</ul>"
                        $('#twitter-block').html(tweetText);
                    } else {
                        $('#twitter-block').html("Twitter failed to load...");
                    }
                    beginTwitterSlider();


                }
                else {
                }
            })
}

function beginTwitterSlider() {
        slider = $("#twitter-block").unslider({
                autoplay: true,
                // infinite: true,
                arrows: false,
            nav: false,
            delay: 5000,
            animation: 'fade',
            animateHeight: true
        });

      
}

function updateSlider() {
    var original = '<div class="slider" id="twitter-block">Updating...</div>'
    $('#twitter-wrapper').html(original);
    getTwitter();
}


function getCalendar() {
    var calendarRequest = 'calendarhandler.php';
    $.get(calendarRequest, {}, function(response, status) {
         if(status === 'success') {
            var data = JSON.parse(response);
            var eventName = data[0];
            var eventStart = data[1];
            var eventEnd = data[2];

            var calText = "<ul>"
            var isBreak = true;
            var filledEntries = false;
            var closingRequired = false
            var numOfEntries = 0;
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
                if(eventName[evt].length > LINE_LENGTH) {

                //+2
                if (numOfEntries == 0) {
                    //start a new li
                    calText+="<li class='eventitem' style='word-wrap: break-word'>"
                    if (isMultiDayEvent) {
                        calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                    } else {
                        calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                    }
                    calText += "<br>"+todayEventSelector + eventName[evt] + "<br><br></span><br><br>";
                    numOfEntries=2;
                    closingRequired = true;
                } 
                // else if (numOfEntries == 1) {
                //     //don't start a new li or close it
                //     if (isMultiDayEvent) {
                //         calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                //     } else {
                //         calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                //     }
                //     calText += "<br>"+todayEventSelector + eventName[evt] + "<br></span><br>";
                //     calText +="</li>"
                //     numOfEntries=0;
                //     closingRequired = false;
                // } 
                else {
                    //close the li, then start a new one
                    calText +="</li>"
                    calText+="<li class='eventitem' style='word-wrap: break-word'>"
                    if (isMultiDayEvent) {
                        calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                    } else {
                        calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                    }
                    calText += "<br>"+todayEventSelector + eventName[evt] + "<br><br></span><br><br>";
                    numOfEntries=2;
                    closingRequired = true;

                }

            } else {
                //+1
                if (numOfEntries == 0) {
                    //start a new one, don't close it
                    calText+="<li class='eventitem' style='word-wrap: break-word'>"
                    if (isMultiDayEvent) {
                        calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                    } else {
                        calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                    }
                    calText += "<br>"+todayEventSelector + eventName[evt] + "<br><br></span><br><br>";
                    numOfEntries=1;
                    closingRequired = true;
                } else if (numOfEntries == 1) {
                    // dont start, dont close
                    if (isMultiDayEvent) {
                        calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                    } else {
                        calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                    }
                    calText += "<br>"+todayEventSelector + eventName[evt] + "<br><br></span><br><br>";
                    numOfEntries++;
                    closingRequired = true;
                } 
                // else if (numOfEntries == 2) {
                //     if (isMultiDayEvent) {
                //         calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                //     } else {
                //         calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                //     }
                //     calText += "<br>"+todayEventSelector + eventName[evt] + "<br></span><br>";
                //     calText +="</li>"
                //     numOfEntries=0;
                //     closingRequired = false;
                // } 
                else {
                    // close, and start a new one
                    calText +="</li>"
                    calText+="<li class='eventitem' style='word-wrap: break-word'>"
                    if (isMultiDayEvent) {
                        calText += todayDateSelector + startFormat.toUpperCase() + " </span>" + finalDateSelector + "to " + endFormat.toUpperCase() + "</span>";
                    } else {
                        calText += todayDateSelector + startFormat.toUpperCase() + "</span>";
                    }
                    calText += "<br>"+todayEventSelector + eventName[evt] + "<br><br></span><br><br>";
                    numOfEntries=1;
                    closingRequired = true;

                }
                
            }
                // TODO: Check if event is ongoing - if it is then do stuff
                // if (cmprDate(startDate, deltaDays)) 
            }
            if (closingRequired) {
                calText += "</li>";
            }
            calText += "</ul>"
            $('#calendar-block').html(calText);
            beginCalendarSlider();
         } else {

         }
     })
}

function beginCalendarSlider () {

    $("#calendar-block").unslider({
        autoplay: true,
        infinite: true,
        arrows: false,
        nav: false,
        delay: 4500
    });

}

function updateCalendar() {
    var original = '<div class="slider" id="calendar-block">Updating calendar...</div>'
    $('#calendar-wrapper').html(original);
    getCalendar();
}

function processMedia() {
    var data;
    $.ajax({
        async: false,
        url: "mediahandler2.php",
        type: "POST",
        dataType: "json",
        success: function(response) {
            data = response;
        }
    })
    return data;
}



