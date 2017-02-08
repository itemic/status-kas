# KAS Digital Signage
This document was last updated on Feb 8, 2017.
## Installation and Setup
TBA.
## Overview
The digital signage system consists of several major components, each described in their respective sub-section in the **Components** section below. The data is customizable from a `config.php` file.
## Components
### Banner
The banner is always displayed at the top of the page and usually contains the school logo. It is expected to be invariant and not change from time to time.
### News Ticker
The news ticker displays information in a scrolling text manner.  It can be updated easily and thus can be used to display announcements.

The ticker data entries come from a Google Sheets spreadsheet. To add or remove entries, edit the cells in the first column. (The first cell in each column will not be displayed, so in this case, only edit cells from A2 onwards.)

The spreadsheet needs to be a public, published spreadsheet so it can be accessed by the page. You can publish a Google Sheets spreadsheet in `File > Publish to the web...`. 

To change the spreadsheet data source, copy the public link as shown in the `Publish to the web...` pop-up and update the configuration entry `news_ticker[spreadsheet_url]` in `config.php`.

**Update frequency**: 10 minutes. A manual refresh will also update the data entries.
### Media Slideshow
The Media Slideshow displays a series of images and videos in a looping slideshow.

The slideshow supports the following file types:

- PNG
- JPG/JPEG
- MP4
- M4V
- YouTube
- Google Slides (to be discussed)

To ensure that the videos/pictures take up the full screen, use a 16:9 aspect ratio.

**Update frequency**: manual. The Slides canvas updates live.

#### Setting media location
The default file location is currently `/media/` in the root directory (`web`). To change where files are found, change `media[file_location]` in the configuration file.

#### Setting media files
The array `media[media_objects]` contains strings of the filenames that will be displayed. The filenames are relative to the media location as discussed above.

The order of the media files is the order in the array.

*Changes will be made to this in the future – all the files within the media directory will be displayed and this will be deprecated.*

#### Image duration
The configuration entry for image duration is `media[image_duration]`. Units in milliseconds.

#### YouTube
YouTube links are supported as well in `media[media_objects]`. Try to use the standard YouTube URL but the code should able to find the yID.

Recommended format: `https://www.youtube.com/watch?v=ID`.

#### Google Slides Canvas
There is also support for a Google Slides slideshow (referred to as to the Slides canvas) for fast/live updates.

1. Get a Google Slides embed link from `File > Publish to the web...` and check "Start slideshow as soon as the player loads." Change the length per slide if necessary, and copy the embed link.
2. Set the config entry `media[slides_canvas]` to the copied embed link.
3. Set `media[slides_duration]` to the same value as the one in the embed link, and also set `media[slides_count]` to the number of slides in the slideshow.

The Slides canvas is always the first thing that is displayed before anything else. To disable the canvas, replace the embed link in `media[slides_canvas]` with the empty string `""`.

Due to the way this embed link works, there is no way of determining how many slides a slideshow has, so ensure that the right `media` variables are set.

#### Fullscreen
Fullscreen mode turns the focus to only the media slideshow and a small clock overlay. To enable fullscreen mode, set `mode[fullscreen]` to `true`.

### Schedule and Clock

The clock shows the date and time. The schedule section shows the current block for MS and HS students.

The schedule data comes from `schedule.json` which contains the blocks and time intervals for each block.

**Update frequency:** varies. Clock updates five times a second and the schedule updates twice a minute to ensure it is updated on time.

#### Custom Schedules
The `schedule.json` file also supports custom schedules should it be necessary. Add to the array a new entry with key `XSYYYYMMDD`, where `XS` is either `MS` for middle school or `HS` for high school, and `YYYYMMDD` is the date for the schedule change.

The value should be an array of arrays of the different blocks. Each block should have a `start`, `end`, and `block` key. The `start` and `end` keys should have values that are `HH:mm`, and the `block` key needs the name of the block.

Manual refreshes are required to update the custom schedule. In some cases, the cache might need to be cleared.
### Weather
The weather block uses Dark Sky APIs to get the current weather conditions and temperature. It also uses the Taiwan Air Quality Monitoring Network (TAQM) to retrieve the current AQI in Zuoying.

Both the weather and AQI are processed together. The AQI takes a bit more time to process, so it takes a bit longer for this component to fully load.

**Update frequency:** 20 minutes.
### Calendar
The calendar shows the next few upcoming events. Events that are currently in progress (i.e. happening today or within the date range) are highlighted.

The maximum number of entries shown can be changed with the config setting `calendar[entries]`.

**Update frequency:** 24 hours, or manual.

### Twitter
This component displays tweets from a public Twitter list. Tweets can be filtered if wanted.

**Update frequency:** 2 hours.

#### Setting up a Twitter list
1. Set `twitter[slug]` to the name of the Twitter list[^This is not actually the name, but the last part of the URL when visiting the list on the web. It is usually the name of the list with spaces replaced with dashes (-).]. 
2. Set `twitter[owner]` to the list owner's username.

To show tweets retweeted by the people in the list, change `twitter[include_rts]` to `true`.

#### Hashtag filters
There is also functionality to only display tweets with specific hashtags. Set `twitter[filter_hashtags]` to `true` if this functionality is desired. Then, add hashtags without the # to `twitter[display_hashtags]`. Tweets will only be shown if they contain hashtags within this array. Hashtags are not case sensitive, unless `twitter[case_sensitive]` is `true`.

#### Tweet count
The API grabs the latest tweets from the list, up to 200. To set the number of tweets to be shown, change `twitter[tweet_count]`. However, if `filter_hashtags` is enabled, note that the `tweet_count` is not the number of tweets after filtering, but before filtering. In reality, there would be fewer tweets[^Unlikely, but sometimes there could be the same amount of tweets.]. When hashtag filtering is enabled, set `tweet_count` to a higher value (recommended: 150).

## APIs used
Below are the APIs used, and where they are used in the project.
### Twitter
Used in the Twitter component.

To set these keys, set the values in `twitter_api` in `config.php`.
### Weather
Used in the Weather component and is powered by Dark Sky.

To set these keys, set the values in `weather_api` in `config.php`. The geographical coordinates can also be set under `weather_api[lat]` and `weather_api[lon]`.
### Air Quality
Used in the Weather component.

To change the key, edit `weather_api[aqi]`.

### Calendar

Used in the Calendar component.

To set these keys, set the values in `calendar_api` in `config.php`.
### News Ticker
Used in the News Ticker component.

This is just a public spreadsheet link as described in **Components**.

## Additional Notes
* A copy of `config.php` is included with the keys stripped out. This file is `configx.php`. 

## Todos
* Change array of items to be everything within directory, with additional YouTube array instead.