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
					}
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
			if (event.data == 0) {
				playMedia();
			}
		}