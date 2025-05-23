<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonRandom" class="power" onclick="songIndex('random');" src="<?=$prefix[3].'dice.png';?>" title="<?=term('Random Track',$settings['vocabulary'],$session['units']);?>">
    <select id="ErotoOlympus" style="width:35%;" onchange="setdata('background',ErotoOlympus.options[ErotoOlympus.selectedIndex].id);"><?php foreach ($userLocks['background'] as $key=>$val) { ?>
    <option disabled><?=titled($val,$session['units']);?></option>
    <?php foreach (catlist($key) as $value) { ?>
    <option id="<?=$value;?>" <?php if ((explode('.',$value)[0]==explode('.',$background)[0])&&(explode('.',$value)[1]==explode('.',$background)[1])) { ?> selected="selected" <?php } ?>><?=titler($value,$settings,$session);?></option><?php }} ?>
    </select><input type="number" min='-11' max='12' step='1' id="setTimeZone" style="width:10%;" value="<?=$session['timezone'];?>" onchange="setTimeZone.value=pad(setTimeZone.value,-2);" oninput="setdata('timezone',pad(setTimeZone.value,-2)); handleInput(this.value,true);" onkeydown="if (event.keyCode==27) {
        setTimeZone.value=0; setdata('timezone',pad(setTimeZone.value,-2));
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    } keyPressed();">
    <input type="image" id="buttonLock" onmouseover="soundButton();" class="power" onclick="setdata('lock',flip(sysDefLock.value));" src="<?=$prefix[3].(($session['lock']!=0)?'key.png':'lock.png');?>" title="<?=term('Lock On Wallpaper Position',$settings['vocabulary'],$session['units']);?>">
    <input type="image" id="buttonOnReload" onmouseover="soundButton();" class="power" onclick="setdata('reload',flip(sysDefReload.value));" src="<?=$prefix[3].(($session['reload']!=0)?'bluetooth.png':'radio.png');?>" title="<?=term('With/Without Page Reload',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonSongIndex" class="power" onclick="setdata('song_index', nextImage(';random',sysDefSongIndex.value));" src="<?=$prefix[3].(($session['song_index']=='random')?'shuffle.png':'update.png');?>" title="<?=term('Audio Playlist Shuffle/Repeat',$settings['vocabulary'],$session['units']);?>">
    <input type="image" id="buttonChild" onmouseover="soundButton();" class="power" onclick="setdata('censor',flip(sysDefCensor.value)); if (sysDefReload.value!=0) { window.location.reload(); }" src="<?=$prefix[3].(($session['censor']!=0)?'briefcase.png':'cabinet.png');?>" title="<?=term('Censor NSFW Content',$settings['vocabulary'],$session['units']);?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="setdata('observe',flip(sysDefObserve.value));" src="<?=$prefix[3].'power.png';?>" title="<?=term('Observe Background View',$settings['vocabulary'],$session['units']);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <?php if (isAuthorized()) { ?>
        <input type="image" onmouseover="soundButton();" id="buttonCommand" class="power" onclick="omniBox.focus();" src="<?=$prefix[3].$session['mode'].'.png';?>" title="<?=term('Command Line Interface Mode',$settings['vocabulary'],$session['units']);?>">
        <input type='text' id="omniBox" style="width:62%;" placeholder="<?=term('',$settings['locale']['cli'],$session['units'],$session['mode']);?>" value="" onkeydown="if (event.keyCode==13) { omniEnter(); } else if (event.keyCode==27) { omniBox.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } keyPressed();" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonEnter" class="power" onclick="omniEnter();" src="<?=$prefix[3].'return.png';?>" title="<?=term('Enter Command/Message',$settings['vocabulary'],$session['units']);?>">
        <input type="image" onmouseover="soundButton();" id="buttonKeyboard" class="power" onclick="document.getElementById('omniBox').focus();" src="<?=$prefix[3].'keyboard.png';?>" title="<?=term('Focus On Console',$settings['vocabulary'],$session['units']);?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="document.getElementById('omniBox').value='';
        document.getElementById('omniBox').focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Console',$settings['vocabulary'],$session['units']);?>">
    <?php } else { ?>
        <input type="image" onmouseover="soundButton();" id="buttonSuggest" class="power" onclick="omniSuggest();" src="<?=$prefix[3].'user.png';?>" title="<?=term('Suggest Username',$settings['vocabulary'],$session['units']);?>">
        <input type='text' id="omniBoxAuthLogin" style="width:31%;" placeholder="<?=term('Username',$settings['vocabulary'],$session['units']);?>" value="" onkeydown="if (event.keyCode==13) {
            omniBoxAuthPass.value=guessUserPass(omniBoxAuthLogin.value); omniBoxAuthPass.focus();
        } else if (event.keyCode==27) {
            omniBoxAuthLogin.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } keyPressed();" oninput="handleInput(this.value,true);">
        <input type='password' id="omniBoxAuthPass" style="width:31%;" placeholder="<?=term('Password',$settings['vocabulary'],$session['units']);?>" value="" onkeydown="if (event.keyCode==13) {
            if (event.code=='NumpadEnter') {
                omniAuthRequest('signup',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
            } else {
                omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
            }
        } else if (event.keyCode==27) {
            omniBoxAuthPass.value=''; omniBoxAuthLogin.focus();
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } keyPressed();" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonLogin" class="power" onclick="omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix[3].'return.png';?>" title="<?=term('Sign In/Authenticate',$settings['vocabulary'],$session['units']);?>">
        <input type="image" onmouseover="soundButton();" id="buttonRegister" class="power" onclick="omniAuthRequest('signup',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix[3].'keyboard.png';?>" title="<?=term('Sign Up/Create Account',$settings['vocabulary'],$session['units']);?>">
        <input type="image" onmouseover="soundButton();" id="buttonCancelSignin" class="power" onclick="document.getElementById('omniBoxAuthPass').value='';
        document.getElementById('omniBoxAuthLogin').value='';
        document.getElementById('omniBoxAuthLogin').focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Sign In Form',$settings['vocabulary'],$session['units']);?>">
    <?php } ?>
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonTime" class="power" onclick="setdata('benchmark',nextImage('0;2',sysDefBenchmark.value));" src="<?=$prefix[3].'time.png';?>" title="<?=term('Slideshow Wallpapers',$settings['vocabulary'],$session['units']);?>">
    <input type='button' id="currentTime" style="width:33%;" onclick="setdata('timedisp',flip(sysDefTimedisp.value));" value="<?=date(($session['timedisp']!=0)?$session['date_format']:$session['time_format']);?>">
    <input type="image" id="buttonPrev" onmouseover="soundButton();" class="power" onclick="songIndex('prev');" src="<?=$prefix[3].'rew.png';?>" title="<?=term('Previous Track',$settings['vocabulary'],$session['units']);?>">
    <input type="image" id="buttonNext" onmouseover="soundButton();" class="power" onclick="songIndex('next');" src="<?=$prefix[3].'ff.png';?>" title="<?=term('Next Track',$settings['vocabulary'],$session['units']);?>">
    <input type="number" min='0' max='23' step='1' id="setTimeHour" style="width:12%;" value="<?=$session['hour'];?>" onchange="setTimeHour.value=pad(setTimeHour.value,-2);" oninput="setdata('hour',pad(setTimeHour.value,-2)); handleInput(this.value,true);" onkeydown="if (event.keyCode==27) {
        setTimeHour.value=12; setdata('hour',pad(setTimeHour.value,-2));
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    } keyPressed();">
    <input type="image" onmouseover="soundButton();" id="buttonVintage" class="power" onclick="setdata('vintage',flip(sysDefVintage.value));" src="<?=$prefix[3].'diamante.png';?>" title="<?=term('Enable Vintage Effects',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonGloss" class="power" onclick="setdata('gloss',flip(sysDefGloss.value));" src="<?=$prefix[3].(($session['gloss']!=0)?'parfum.png':'deparfum.png');?>" title="<?=term('Enable Gloss/Gradient',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonAugment" class="power" onclick="setdata('entry',nextImage(sysDefVarsArr.value,sysDefEntry.value));" src="<?=$prefix[3].'spade.png';?>" title="<?=term('Go My Way',$settings['vocabulary'],$session['units']);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutoplay" class="power" onclick="setdata('autoplay',flip(sysDefAutoplay.value));" src="<?=$prefix[3].(($session['autoplay'])?'autopause.png':'autoplay.png');?>" title="<?=term('Enable Autoplay',$settings['vocabulary'],$session['units']);?>">
    <input type='button' id="alarmTime" style="width:20%;" onclick="setdata('memo',''); pauseAudio(alarmPlayer);" value="00:00"><input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="if (sysDefPlaying.value==1) { omniPause(); } else { omniListen(demorse(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value)); }" src="<?=$prefix[3].(($session['playing']!=0)?'pause.png':'play.png');?>" title="<?=term('Audio Play/Pause',$settings['vocabulary'],$session['units']);?>">
    <input type="image" id="buttonMuteBack" onmouseover="soundButton();" class="power" onclick="setdata('loop',flip(sysDefLoop.value));" src="<?=$prefix[3].'disk.png';?>" title="<?=term('Enable Loop Music',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonPitched" class="power" onclick="setdata('pitch_lock',flip(sysDefPitchLock.value));" src="<?=$prefix[3].(($session['pitch_lock']!=0)?'midi.png':'volume.png');?>" title="<?=term('Preserve Pitch',$settings['vocabulary'],$session['units']);?>">
    <select id="avatarPicker" style="width:25%;" onchange="setdata('avatar',avatarPicker.options[avatarPicker.selectedIndex].id); if (sysDefReload.value!=0) { window.location.reload(); }"><?php foreach ($userLocks['avatar'] as $key=>$value) { ?>
    <option id="<?=explode('.', $value)[1];?>" <?php if ($session['avatar']==explode('.',$value)[1]) { ?> selected <?php } ?>>
        <?=explode('.',$value)[1];?>
    </option><?php } ?></select>
    <input type="image" id="buttonAlarm" onmouseover="soundButton();" class="power" onclick="if (alarmPlayer.paused) {
        playAudio(alarmPlayer,sysDefAlarmSound.value);
    } else { pauseAudio(alarmPlayer); }" src="<?=$prefix[3].'call.png';?>" title="<?=term('Incoming Call',$settings['vocabulary'],$session['units']);?>">
    <input type="image" id="buttonMute" onmouseover="soundButton();" class="power" onclick="setdata('mute',flip(sysDefMute.value));" src="<?=$prefix[3].(($session['mute'])?'audio.png':'music.png');?>" title="<?=term('Mute Audio',$settings['vocabulary'],$session['units']);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutomator" class="power" onclick="automate();" src="<?=$prefix[3].(($automateData[$sessionID]=='auto')?'wheel.png':'steer.png');?>" title="<?=term('Enable User Auto Mode',$settings['vocabulary'],$session['units']);?>">
    <input type='button' id="showUsInfoPower" style="width:34%;" value="<?=intval($powersData[$sessionID]);?>">
    <input type="image" onmouseover="soundButton();" id="buttonBroke" class="power" onclick="var uli=(sysDefUsersList.value).split(','),bdi=strarr(sysDefBindData.value,';',':'); delete uli[sysDefSessionID.value]; if (bdi[sysDefSessionID.value]!=sysDefSessionID.value) { unbind(sysDefSessionID.value); } else { bind(sysDefSessionID.value,uli[rand(0,(uli.length))]); }" src="<?=$prefix[3].'chain.png';?>" title="<?=term('Bind/Unbind Another User',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonReticle" class="power" onclick="dominate(sysDefSessionID.value,strarr(sysDefBindData.value,';',':')[sysDefSessionID.value],strarr(sysDefToolData.value,';',':')[sysDefSessionID.value]); playAudio(hitPlayer,sysDefHitSound.value);" src="<?=$prefix[5].$session['reticle'].'.png';?>" title="<?=term('Hit Another User',$settings['vocabulary'],$session['units']);?>">
    <input type='button' id="showUsInfoBond" style="width:28%;" onclick="clip(sysDefSessionID.value);" value="<?=$sessionID;?>">
    <input type="image" onmouseover="soundButton();" id="buttonSpectate" class="power" onclick="setdata('spectate',flip(sysDefSpectate.value));" src="<?=$prefix[3].'camera.png';?>" title="<?=term('Spectate Mode',$settings['vocabulary'],$session['units']);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" id="userAvatarBadge" onmouseover="soundButton();" class="power" src="<?=$prefix[1].$session['avatar'].'.png';?>" onclick="setdata('face',flip(sysDefFace.value)); window.location.reload();" title="<?=term('Show/Hide User Avatar',$settings['vocabulary'],$session['units']);?>">
    <select id="setUnits" style="width:14%;" onchange="setdata('units',setUnits.options[setUnits.selectedIndex].id); if (sysDefReload.value!=0) { window.location.reload(); }">
    <?php foreach (explode(',',$session['units_list']) as $selID) { ?>
        <option id="<?=$selID;?>" <?php if ($session['units']==$selID) { ?> selected <?php } ?>><?=$selID;?></option>
    <?php } ?></select>
    <select id="setTheme" style="width:22%;" onchange="setdata('theme',setTheme.options[setTheme.selectedIndex].id); window.location.reload();">
    <?php foreach ((str_replace('./','',(glob('./*.start.png')))) as $key=>$value) { ?>
        <option id="<?=explode('.',$value)[0];?>" <?php if ($session['theme']==explode('.',$value)[0]) { ?> selected <?php } ?>><?=explode('.',$value)[0];?></option>
    <?php } ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonReqLock" class="power" onclick="invertLock();" src="<?=$prefix[3].(($request['lock']=='true')?'collapse.png':'expand.png');?>" title="<?=term('Expand/Collapse Enhanced View',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonMaximize" class="power" onclick="setdata('apps',flip(sysDefApps.value)); window.location.reload();" src="<?=$prefix[3].(($session['apps']!=0)?'restore.png':'maximize.png');?>" title="<?=term('Show Third-Party Apps',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonMenuStyle" class="power" onclick="setdata('icons',flip(sysDefIcons.value)); window.location.reload();" src="<?=$prefix[3].(($session['icons']!=0)?'menu.png':'list.png');?>" title="<?=term('Icons/List Menu View',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="systemUpdate(sysDefBackload.value); window.location.reload();" src="<?=$prefix[3].'world.png';?>" title="<?=term('Eurohouse Update',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonUserStatus" class="power" onclick="if (authstate()) { omniAuthRequest('signout','',''); } else { omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString()); }" src="<?=$prefix[3].((isAuthorized())?'logout.png':'login.png');?>" title="<?=term('Sign Out',$settings['vocabulary'],$session['units']);?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="omniBack(sysDefParent.value);" src="<?=$prefix[3].'escape.png';?>" title="<?=term('Go Back',$settings['vocabulary'],$session['units']);?>">
    </p>
</div>