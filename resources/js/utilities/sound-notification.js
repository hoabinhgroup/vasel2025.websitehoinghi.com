const SOUNDURL = "https://soundbible.com/mp3/analog-watch-alarm_daniel-simion.mp3";

function playSoundNotification() {
  // var audio = new Audio(SOUNDURL);
	// audio.play();
	var media = document.getElementById('audiotag');
	console.log('media', media);
	media.muted = false;
	const playPromise = media.play();
	  if (playPromise !== null){
	  playPromise.catch(() => { media.play(); })
	}
}

export { playSoundNotification };
