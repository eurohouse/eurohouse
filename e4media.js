function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('pitch_lock',sysDefPitchLock.value);
    setdata('video_volume',sysDefVideoVolume.value);
    setdata('video_speed',sysDefVideoSpeed.value);
}
function omniListen(input,scratch=false,pos=false) {
    playAudio(audioPlayer,input); if (isInt(pos)) {
        audioPlayer.currentTime=parseInt(pos);
    } else {
        if (scratch) { audioPlayer.currentTime=0;
        } else { audioPlayer.currentTime=parseInt(sysDefCurrent.value); }
    } setdata('melody',etw(input,sysDefSessionID.value,sysDefNumeric.value));
    setdata('pitch_lock',sysDefPitchLock.value);
    setdata('audio_volume',sysDefAudioVolume.value);
    setdata('audio_speed',sysDefAudioSpeed.value);
}
function songIndex(mode='') {
    var lxn=lockarr('music');
    var nxp=sysDefUpNext.value;
    var nxt=(nxp.includes('//'))?nxp.split('//'):((nxp!='')?[nxp]:[]);
    var mel=dtw(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
    var ind=arraySearch(((mel.startsWith(requestPath.value+'/'))?mel.replace(requestPath.value+'/',''):mel),lxn);
    if (nxp!='') {
        if (nxt[0]!='') {
            omniListen(dtw(nxt[0],sysDefSessionID.value,sysDefNumeric.value),true);
        } setdata('up_next',arrangeMenu(sysDefUpNext.value,nxt[0],'//'));
    } else {
        if (mode=='next') {
            omniListen((((ind>=(lxn.length-1))||(ind===false))?lxn[0]:lxn[parseInt(ind)+1]),true);
        } else if (mode=='prev') {
            omniListen((((ind<=0)||(ind===false))?lxn[lxn.length-1]:lxn[parseInt(ind)-1]),true);
        } else if (mode=='random') { omniListen(lxn[rand(0,lxn.length)],true);
        } else { omniListen(mel,true); }
    }
}
function omniPause() { pauseAudio(audioPlayer); }
function audioPosition(sec) {
    if (audioPlayer.duration>sec) {
        audioPlayer.currentTime=(sec.includes('-'))?(audioPlayer.duration-parseInt(sec.replace('-',''))):(((sec.includes('+')))?(parseInt(sec.replace('+',''))):(parseInt(sec)));
    }
}
function savePlayState() { setdata('current',audioPlayer.currentTime); }
function soundButton(bulk=false) {
    if (bulk!=false) {
        playAudio(soundPlayer,sysDefFocusSound.value);
    } else {
        if (sysDefMute.value==0) {
            playAudio(soundPlayer,sysDefFocusSound.value);
        }
    }
}
function handleInput(val,bulk=false) {
    if (bulk!=false) {
        playAudio(typePlayer,sysDefTypeSound.value);
    } else {
        if (val.length==0) {
            playAudio(errorPlayer,sysDefErrorSound.value);
        }
    }
}