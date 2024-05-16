<!-- music -->
<!-- RU: Домашний кинотеатр; CN: 家庭媒体播放器; KR: 미디어 플레이어; JP: メディアプレーヤー; AE: مشغل الوسائط -->
<!-- <ref> -->
<!-- true -->
<p align="center" class="block"><video style="width:92%;height:90%;" id="video" volume="<?=$session['video_volume'];?>" balance="<?=$session['video_balance'];?>" playbackRate="<?=$session['video_speed'];?>" src="<?=$request['input'];?>" controls autoplay="yes" onended="if (sysDefAutoplay.value != 0) { replayVideo(this); }" onvolumechange="setdata('video_volume', this.volume);" onratechange="setdata('video_speed', this.playbackRate);"></p>