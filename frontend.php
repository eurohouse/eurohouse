<script>
function lockdata() {
    var obj={
        <?php $iter=0; foreach ($locks as $key=>$value) {
            echo "'".$key."': lock".camel($key).".value".((count($locks)==($iter-1))?'':','); $iter++;
        } $iter=0; ?>
    }; return obj;
}
function userdata() {
    var obj = {
        <?php $iter=0; foreach ($settings['defaults'] as $key=>$value) {
            echo "'".$key."': sysDef".camel($key).".value".((count($settings['defaults'])==($iter-1))?'':','); $iter++;
        } $iter=0; ?>
    }; return obj;
}
function setlock(ent,val) {
    var obj=lockdata(); obj[ent]=val;
    set(sysDefSessionID.value+'_lock.json',JSON.stringify(obj),true);
    <?php foreach ($locks as $key=>$value) {
        echo "lock".camel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent,val) {
    var obj=userdata(); obj[ent]=val;
    set(sysDefSessionID.value+'_session.json',JSON.stringify(obj),true);
    <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".camel($key).".value = obj['".$key."'];";
    } ?> if (ent=='audio_volume') { audioPlayer.volume = val; }
    if (ent=='audio_speed') { audioPlayer.playbackRate=val; }
    if (ent=='alarm_volume') { alarmPlayer.volume=val; }
    if (ent=='timer_volume') { tickerPlayer.volume=val; }
    if (ent=='loop_volume') { backgroundPlayer.volume=val; }
    if (ent=='rest_volume') {
        soundPlayer.volume=typePlayer.volume=errorPlayer.volume=notifyPlayer.volume=bindPlayer.volume=hitPlayer.volume=sufferPlayer.volume=val;
    } if (ent=='pitch_lock') { audioPlayer.preservesPitch=(val!=0)?true:false; } if (requestMode.value=='sticky_notes') {
        if (ent=='numeric') { myNotesRad.value=val; }
    } if (requestMode.value=='media_player') {
        if (ent=='video_volume') { video.volume=val; }
        if (ent=='video_speed') { video.playbackRate=val; }
        if (ent=='pitch_lock') { video.preservesPitch=(val!=0)?true:false; }
    } if (requestMode.value=='volume_control') {
        if (ent=='audio_volume') { audioVolInd.value=val; audioVolRange.value=val; }
        if (ent=='audio_speed') { audioRatInd.value=val; audioRatRange.value=val; }
        if (ent=='video_volume') { videoVolInd.value=val; videoVolRange.value=val; }
        if (ent=='video_speed') { videoRatInd.value=val; videoRatRange.value=val; }
        if (ent=='alarm_volume') { alarmVolInd.value=val; alarmVolRange.value=val; }
        if (ent=='timer_volume') { timerVolInd.value=val; timerVolRange.value=val; }
        if (ent=='loop_volume') { loopVolInd.value=val; loopVolRange.value=val; }
        if (ent=='rest_volume') { restVolInd.value=val; restVolRange.value=val; }
    } if (requestMode.value=='visual_effects') {
        if (ent=='opacity') { opacityRange.value=val; }
        if (ent=='blur') { blurRange.value=val; }
        if (ent=='brightness') { brightnessRange.value=val; }
        if (ent=='saturation') { saturationRange.value=val; }
        if (ent=='contrast') { contrastRange.value=val; }
        if (ent=='sepia') { sepiaRange.value=val; }
        if (ent=='grayscale') { grayscaleRange.value=val; }
        if (ent=='hue') { hueRange.value=val; }
    }
}
</script>
