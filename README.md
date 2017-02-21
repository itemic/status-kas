# KAS Digital Signage
This document was last updated on Feb 21, 2017.

#### 02 21 2017
* Basic installation info.

## Installation and Setup
Set the `web` folder as the root. The `config` file should be on the same level as the root. As it is not the root, there will be no access to it besides through the server-side PHP code.

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
- MOV
- YouTube
- Google Slides (to be discussed)

To ensure that the videos/pictures take up the full screen, use a 16:9 aspect ratio.

**Update frequency**: Custom. The Slides Canvas updates live. The media folder will be checked every time the page plays every video/image from the folder. A manual refresh will work as well.

**Important:** Although there are a few tests to see whether the media is being displayed right now, do not remove (or move) media files while they are being displayed. If something needs to be removed, remove it once it is no longer on the screen. If it absolutely needs to be removed straightaway, a manual refresh may be needed.

#### Setting media location
The default file location is currently `media` in the root directory (`web`). To change where files are found, change `media[file_location]` in the configuration file.

It is possible to have multiple directories within the media folder.

#### YouTube support
YouTube links are supported as well. It is recommended that the basic YouTube URL format is used, although shortened/share/embed links may also work.

Recommended format: `https://www.youtube.com/watch?v=ID`.

These URLs should be placed in a plaintext file. Each line should only have 1 link. By default, it is also in the `media` folder.

The config setting `media[yt_filelist]` specifies the location of this plaintext file.

The order of the media files is the order in the array.
#### Image duration
The configuration entry for image duration is `media[image_duration]`. Units in milliseconds.

#### Google Slides Canvas
There is also support for a Google Slides slideshow (referred to as to the Slides canvas) for fast/live updates.

1. Get a Google Slides embed link from `File > Publish to the web...` and check "Start slideshow as soon as the player loads." Change the length per slide if necessary, and copy the embed link.
2. Set the config entry `media[slides_canvas]` to the copied embed link.
3. Check the embed link: does it include `/pub?` somewhere in the URL? If it does, change it to `/embed?`. Alternatively, instead of copying the embed link from the first tab `(Link)` in `Publish to the web...`, go to the second tab `(Embed)`, and copy the URL starting from `src=""` in the iframe embed code.
3. Set `media[slides_duration]` to the same value as the one in the embed link, and also set `media[slides_count]` to the number of slides in the slideshow.

The Slides canvas is always the first thing that is displayed before anything else. To disable the canvas, replace the embed link in `media[slides_canvas]` with the empty string `""`.

Due to the way this embed link works, there is no way of determining how many slides a slideshow has, so ensure that the right `media` variables are set.

#### Precedence

The Slides canvas is shown first, followed by the files in the `media` folder, followed by YouTube URLs.

#### Display Modes
Fullscreen mode turns the focus to only the media slideshow and a small clock overlay. To display fullscreen mode, append `?mode=fullscreen` to the URL.

#### Placeholders
In the case where there is no media in the folder, a placeholder image (`img/placeholder`) is shown. The display will check for new media every 10 seconds, so do not be alarmed if it does not appear right away.

Larger videos may take some time to load, so the placeholder image may appear in its place. This is especially the case when there are subdirectories within the media folder.

### Schedule and Clock

The clock shows the date and time. The schedule section shows the current block for MS and HS students.

The schedule data comes from `scheduledisplay.json` which contains the blocks and time intervals for each block.

**Update frequency:** varies. Clock updates five times a second and the schedule updates twice a minute to ensure it is updated on time.
#### Schedule Editor
There is a very basic schedule editor included for quick changes to the current schedule (mainly names). This can be accessed at `/scheduler.php`.

It does not support adding custom schedules. Its primary task is to change block names or times if necessary. However, as of 2/20/2017, there is no input validation.

It also does not support adding of schedules.

If anything is messed up (i.e. if something is deleted), there is a Reset Schedule to Defaults button that updates `scheduledisplay.json` with the defaults file, `schedule.json`.

#### Custom Schedules
The `scheduledisplay.json` file also supports custom schedules should it be necessary. Add to the array a new entry with key `XSYYYYMMDD`, where `XS` is either `MS` for middle school or `HS` for high school, and `YYYYMMDD` is the date for the schedule change.

The value should be an array of arrays of the different blocks. Each block should have a `start`, `end`, and `block` key. The `start` and `end` keys should have values that are `HH:mm`, and the `block` key needs the name of the block.

Manual refreshes are required to update the custom schedule. In some cases, the cache might need to be cleared.
### Weather
The weather block uses Dark Sky APIs to get the current weather conditions and temperature. It also uses the Taiwan Air Quality Monitoring Network (TAQM) to retrieve the current AQI in Zuoying.

Both the weather and AQI are processed together. The AQI takes a bit more time to process, so it takes a bit longer for this component to fully load.

Be advised that Dark Sky only allows 1000 free calls a day (hard cap can be set; default: 1000), so this would be (without any refreshes), 288 calls. If this were to be opened up to the public additional calls may need to be purchased.

**Update frequency:** 5 minutes.
### Calendar
The calendar shows the next few upcoming events. Events that are currently in progress (i.e. happening today or within the date range) are highlighted.

The maximum number of entries shown can be changed with the config setting `calendar[entries]`.

**Update frequency:** 2 hours

### Twitter
This component displays tweets from a public Twitter list. Tweets can be filtered if wanted.

**Update frequency:** 20 minutes

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
