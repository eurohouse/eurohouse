<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonRandom" class="power" onclick="songIndex('random');" src="<?=$prefix.'dice.png';?>" title="<?=term('Random Track',$settings['vocabulary'],$session['units']);?>">
    <select id="ErotoOlympus" style="width:32%;" onchange="setdata('background',ErotoOlympus.options[ErotoOlympus.selectedIndex].id);"><?php foreach ($userLocks['background'] as $key=>$val) { ?>
    <option disabled><?=titled($val,$session['units']);?></option>
    <?php foreach (catlist($key) as $value) { ?>
    <option id="<?=$value;?>" <?php if ((explode('.',$value)[0]==explode('.',$background)[0])&&(explode('.',$value)[1]==explode('.',$background)[1])) { ?> selected="selected" <?php } ?>><?=titler($value,$settings,$session);?></option><?php }} ?>
    </select><input type="number" min='-11' max='12' step='1' id="setTimeZone" style="width:10%;" value="<?=$session['timezone'];?>" oninput="setdata('timezone',pad(setTimeZone.value,-2)); handleInput(this.value,true);" onkeydown="if (event.keyCode==27) {
        setTimeZone.value=0; setdata('timezone',setTimeZone.value);
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }"><input type="image" id="buttonLock" onmouseover="soundButton();" class="power" onclick="setdata('lock',flip(sysDefLock.value));" src="<?=$prefix.(($session['lock']!=0)?'key.png':'lock.png');?>">
    <input type="image" id="buttonOnReload" onmouseover="soundButton();" class="power" onclick="setdata('reload',flip(sysDefReload.value));" src="<?=$prefix.(($session['reload']!=0)?'bluetooth.png':'radio.png');?>">
    <input type="image" onmouseover="soundButton();" id="buttonSongIndex" class="power" onclick="setdata('song_index', nextImage(';random',sysDefSongIndex.value));" src="<?=$prefix.(($session['song_index']=='random')?'shuffle.png':'update.png');?>"><input type="image" id="buttonChild" onmouseover="soundButton();" class="power" onclick="setdata('censor',flip(sysDefCensor.value)); if (sysDefReload.value!=0) { window.location.reload(); }" src="<?=$prefix.(($session['censor']!=0)?'briefcase.png':'cabinet.png');?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="setdata('observe',flip(sysDefObserve.value));" src="<?=$prefix.'power.png';?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <?php if (isAuth()) { ?>
        <input type="image" onmouseover="soundButton();" id="buttonChat" class="power" onclick="setdata('chat',flip(sysDefChat.value)); omniBox.focus();" src="<?=$prefix.(($session['chat']!=0)?'book.png':'bash.png');?>">
        <input type='text' id="omniBox" style="width:59%;" placeholder="<?=term('Type expression and press ENTER',$settings['vocabulary'],$session['units']);?>" value="" onkeydown="if (event.keyCode==13) { omniEnter();
        } else if (event.keyCode==27) {
            document.getElementById('omniBox').value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } else if (event.keyCode==113) {
            setdata('chat',flip(sysDefChat.value)); omniBox.focus();
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonEnter" class="power" onclick="omniEnter();" src="<?=$prefix.'return.png';?>">
        <input type="image" onmouseover="soundButton();" id="buttonKeyboard" class="power" onclick="document.getElementById('omniBox').focus();" src="<?=$prefix.'keyboard.png';?>"><input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="document.getElementById('omniBox').value='';
        document.getElementById('omniBox').focus();" src="<?=$prefix.'backspace.png';?>">
    <?php } else { ?>
        <input type='text' id="omniBoxAuthLogin" style="width:34%;" placeholder="<?=term('Username',$settings['vocabulary'],$session['units']);?>" value="" onkeydown="if (event.keyCode==13) {
            document.getElementById('omniBoxAuthPass').value='';
            document.getElementById('omniBoxAuthPass').focus();
        } else if (event.keyCode==27) {
            document.getElementById('omniBoxAuthLogin').value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type='password' id="omniBoxAuthPass" style="width:34%;" placeholder="<?=term('Password',$settings['vocabulary'],$session['units']);?>" value="" onkeydown="if (event.keyCode==13) {
            omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
        } else if (event.keyCode==27) {
            document.getElementById('omniBoxAuthPass').value='';
            document.getElementById('omniBoxAuthLogin').focus();
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } else if (event.keyCode==113) {
            omniAuthRequest('signup',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonLogin" class="power" onclick="omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix.'user.png';?>"><input type="image" onmouseover="soundButton();" id="buttonRegister" class="power" onclick="omniAuthRequest('signup',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix.'book.png';?>"><input type="image" onmouseover="soundButton();" id="buttonCancelSignin" class="power" onclick="document.getElementById('omniBoxAuthPass').value='';
        document.getElementById('omniBoxAuthLogin').value='';
        document.getElementById('omniBoxAuthLogin').focus();" src="<?=$prefix.'backspace.png';?>">
    <?php } ?>
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonTime" class="power" onclick="setdata('benchmark',nextImage('0;2',sysDefBenchmark.value));" src="<?=$prefix.'time.png';?>">
    <input type='button' id="currentTime" style="width:30%;" onclick="setdata('timedisp',flip(sysDefTimedisp.value));" value="00:00:00">
    <input type="image" id="buttonPrev" onmouseover="soundButton();" class="power" onclick="songIndex('prev');" src="<?=$prefix.'rew.png';?>">
    <input type="image" id="buttonNext" onmouseover="soundButton();" class="power" onclick="songIndex('next');" src="<?=$prefix.'ff.png';?>">
    <input type="number" min='0' max='23' step='1' id="setTimeHour" style="width:12%;" value="<?=$session['hour'];?>" oninput="setdata('hour',pad(setTimeHour.value,-2));
    handleInput(this.value,true);" onkeydown="if (event.keyCode==27) {
        setTimeHour.value=12; setdata('hour',setTimeHour.value);
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }"><input type="image" onmouseover="soundButton();" id="buttonVintage" class="power" onclick="setdata('vintage',flip(sysDefVintage.value));" src="<?=$prefix.'diamante.png';?>">
    <input type="image" onmouseover="soundButton();" id="buttonGloss" class="power" onclick="setdata('gloss',flip(sysDefGloss.value));" src="<?=$prefix.(($session['gloss']!=0)?'parfum.png':'deparfum.png');?>"><input type="image" onmouseover="soundButton();" id="buttonAugment" class="power" onclick="setdata('entry',nextImage(sysDefVarsArr.value,sysDefEntry.value));" src="<?=$prefix.'spade.png';?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutoplay" class="power" onclick="setdata('autoplay',flip(sysDefAutoplay.value));" src="<?=$prefix.'autoplay.png';?>">
    <input type='button' id="alarmTime" style="width:30%;" onclick="setdata('memo',''); pauseAudio(alarmPlayer);" value="00:00:00"><input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="if (sysDefPlaying.value==1) { omniPause(); } else { omniListen(dtw(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value)); }" src="<?=$prefix.'play.png';?>">
    <input type="image" id="buttonMuteBack" onmouseover="soundButton();" class="power" onclick="setdata('loop',flip(sysDefLoop.value));" src="<?=$prefix.'disk.png';?>">
    <input type="image" onmouseover="soundButton();" id="buttonPitched" class="power" onclick="setdata('pitch_lock',flip(sysDefPitchLock.value));" src="<?=$prefix.(($session['pitch_lock']!=0)?'midi.png':'volume.png');?>">
    <select id="avatarPicker" style="width:12%;" onchange="setdata('avatar',avatarPicker.options[avatarPicker.selectedIndex].id); if (sysDefReload.value!=0) { window.location.reload(); }">
    <?php foreach ($userLocks['avatar'] as $key=>$value) { ?>
    <option id="<?=explode('.', $value)[1];?>" <?php if ($session['avatar']==explode('.',$value)[1]) { ?> selected <?php } ?>>
        <?=explode('.',$value)[1];?>
    </option><?php } ?></select>
    <input type="image" id="buttonAlarm" onmouseover="soundButton();" class="power" onclick="if (alarmPlayer.paused) {
        playAudio(alarmPlayer,sysDefAlarmSound.value);
    } else { pauseAudio(alarmPlayer); }" src="<?=$prefix.'call.png';?>"><input type="image" id="buttonMute" onmouseover="soundButton();" class="power" onclick="setdata('mute',flip(sysDefMute.value));" src="<?=$prefix.'music.png';?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutomator" class="power" onclick="automate();" src="<?=$prefix.(($automateData[$sessionID]=='auto')?'wheel.png':'steer.png');?>"><input type='button' id="showUsInfoPower" style="width:31%;" value="<?=intval($powersData[$sessionID]);?>">
    <input type="image" onmouseover="soundButton();" id="buttonBroke" class="power" onclick="var uli=(sysDefUsersList.value).split(',');
    var bdi=arrjob(sysDefBindData.value,';',':');
    if (bdi[sysDefSessionID.value]!=sysDefSessionID.value) {
        unbind(sysDefSessionID.value);
    } else {
        bind(sysDefSessionID.value,uli[rand(0,(uli.length-1))]);
    }" src="<?=$prefix.'chain.png';?>">
    <input type="image" onmouseover="soundButton();" id="buttonReticle" class="power" onclick="dominate(sysDefSessionID.value,arrjob(sysDefBindData.value,';',':')[sysDefSessionID.value],arrjob(sysDefToolData.value,';',':')[sysDefSessionID.value]); playAudio(hitPlayer,sysDefHitSound.value);" src="<?=$reticlePrefix.$session['reticle'].'.png';?>">
    <input type="image" onmouseover="soundButton();" id="buttonBanner" class="power" onclick="setdata('banner','');" src="<?=$prefix.(($session['banner']!='')?'idea.png':'bulb.png');?>"><input type='button' id="showUsInfoBond" style="width:20%;" value="<?=$sessionID;?>"><input type="image" onmouseover="soundButton();" id="buttonSpectate" class="power" onclick="setdata('spectate',flip(sysDefSpectate.value));" src="<?=$prefix.'unpower.png';?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" id="userAvatarBadge" onmouseover="soundButton();" class="power" src="<?=$abcPrefix.$session['avatar'].'.png';?>" onclick="setdata('face',flip(sysDefFace.value)); window.location.reload();"><select id="setUnits" style="width:13%;" onchange="setdata('units',setUnits.options[setUnits.selectedIndex].id); if (sysDefReload.value!=0) { window.location.reload(); }">
    <?php foreach (explode(',',$session['units_list']) as $selID) { ?>
    <option id="<?=$selID;?>" <?php if ($session['units']==$selID) { ?> selected <?php } ?>><?=$selID;?></option><?php } ?></select>
    <select id="setTheme" style="width:20%;" onchange="setdata('theme',setTheme.options[setTheme.selectedIndex].id); window.location.reload();"><?php foreach ($thematic as $key=>$value) { ?>
        <option id="<?=explode('.',$value)[0];?>" <?php if ($session['theme']==explode('.',$value)[0]) { ?> selected <?php } ?>><?=explode('.',$value)[0];?></option>
    <?php } ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonReqLock" class="power" onclick="if (requestLock.value=='true') { omniLock('false'); } else { omniLock('true'); }" src="<?=$prefix.(($request['lock']=='true')?'collapse.png':'expand.png');?>">
    <input type="image" onmouseover="soundButton();" id="buttonMaximize" class="power" onclick="setdata('apps',flip(sysDefApps.value)); window.location.reload();" src="<?=$prefix.(($session['apps']!=0)?'restore.png':'maximize.png');?>">
    <input type="image" onmouseover="soundButton();" id="buttonMenuStyle" class="power" onclick="setdata('icons',flip(sysDefIcons.value)); window.location.reload();" src="<?=$prefix.(($session['icons']!=0)?'menu.png':'list.png');?>">
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="systemUpdate(sysDefBackload.value); window.location.reload();" src="<?=$prefix.'world.png';?>">
    <input type="image" onmouseover="soundButton();" id="buttonUserStatus" class="power" onclick="omniAuthRequest('signout','','');" src="<?=$prefix.((isAuth())?'user.png':'anonym.png');?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="omniBack(sysDefParent.value);" src="<?=$prefix.'escape.png';?>">
    </p>
</div>