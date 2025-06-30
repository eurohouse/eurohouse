<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonMusic" class="power" onclick="var objCmdTxt=(authstate())?omniBox:omniBoxAuthLogin; seekMusic(objCmdTxt.value);" src="<?=$prefix[3].'music.png';?>" title="<?=term('Random Track',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonBanner" class="power" onclick="var objCmdTxt=(authstate())?omniBox:omniBoxAuthLogin; if (sysDefBanner.value!='') { setdata('banner',''); } else { seekBanner(objCmdTxt.value); }" src="<?=$prefix[3].(($session['banner']!='')?'paint.png':'image.png');?>" title="<?=term('Random Banner',$settings,$session);?>">
    <select id="ErotoOlympus" style="width:41%;" onchange="setdata('background',ErotoOlympus.options[ErotoOlympus.selectedIndex].id);"><?php foreach ($userLocks['background'] as $key=>$val) { ?>
    <option disabled><?=titled($val,$session['units']);?></option>
    <?php foreach (catlist($key) as $value) { ?>
    <option id="<?=$value;?>" <?php if ((explode('.',$value)[0]==explode('.',$background)[0])&&(explode('.',$value)[1]==explode('.',$background)[1])) { ?> selected="selected" <?php } ?>><?=titler($value,$settings,$session);?></option><?php }} ?>
    </select>
    <input type="number" min='-11' max='12' step='1' id="setTimeZone" style="width:10%;" value="<?=$session['timezone'];?>" onchange="setTimeZone.value=pad(setTimeZone.value,-2);" oninput="setdata('timezone',pad(setTimeZone.value,-2)); handleInput(this.value,true);" onkeydown="if (event.keyCode==27) {
        setTimeZone.value=0; setdata('timezone',pad(setTimeZone.value,-2));
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    } keyPressed();">
    <input type="image" id="buttonReload" onmouseover="soundButton();" class="power" onclick="setdata('reload',flip(sysDefReload.value));" src="<?=$prefix[3].(($session['reload']!=0)?'bluetooth.png':'radio.png');?>" title="<?=term('With/Without Page Reload',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonIndex" class="power" onclick="setdata('song_index', nextImage(';random',sysDefSongIndex.value));" src="<?=$prefix[3].(($session['song_index']=='random')?'shuffle.png':'update.png');?>" title="<?=term('Audio Playlist Shuffle/Repeat',$settings,$session);?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="setdata('observe',flip(sysDefObserve.value));" src="<?=$prefix[3].'power.png';?>" title="<?=term('Observe Background View',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <?php if (isAuthorized()) { ?>
        <input type="image" onmouseover="soundButton();" id="buttonCommand" class="power" onclick="seekCode(omniBox.value);" src="<?=$prefix[3].'start.png';?>" title="<?=term('Random Code',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonCompose" class="power" onclick="compose(sysDefSessionID.value,omniBox.value);" src="<?=$prefix[3].'forward.png';?>" title="<?=term('Compose Message',$settings,$session);?>">
        <input type='text' id="omniBox" style="width:52%;" placeholder="<?=term('Type command or expression and press ENTER',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { omniEnter(); } else if (event.keyCode==27) { omniBox.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } else if (event.keyCode==113) { seekMusic(omniBox.value);
        } else if (event.keyCode==115) { seekBanner(omniBox.value);
        } else if (event.keyCode==118) { seekCode(omniBox.value);
        } keyPressed();" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonEnter" class="power" onclick="omniEnter();" src="<?=$prefix[3].'return.png';?>" title="<?=term('Enter Command/Message',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonAuth" class="power" onclick="if (authstate()) { omniAuthRequest('signout','',''); } else { omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString()); }" src="<?=$prefix[3].'user.png';?>" title="<?=term('Sign In/Out',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="omniBox.value=''; omniBox.focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Console',$settings,$session);?>">
    <?php } else { ?>
        <input type="image" onmouseover="soundButton();" id="buttonCommand" class="power" onclick="seekCode(omniBoxAuthLogin.value);" src="<?=$prefix[3].'start.png';?>" title="<?=term('Random Code',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonSuggest" class="power" onclick="omniSuggest();" src="<?=$prefix[3].'dice.png';?>" title="<?=term('Suggest Username',$settings,$session);?>">
        <input type='text' id="omniBoxAuthLogin" style="width:30%;" placeholder="<?=term('Username',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
            omniBoxAuthPass.value=''; omniBoxAuthPass.focus();
        } else if (event.keyCode==27) { omniBoxAuthLogin.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } else if (event.keyCode==113) { seekMusic(omniBoxAuthLogin.value);
        } else if (event.keyCode==115) { seekBanner(omniBoxAuthLogin.value);
        } else if (event.keyCode==118) { seekCode(omniBoxAuthLogin.value);
        } keyPressed();" oninput="handleInput(this.value,true);">
        <input type='password' id="omniBoxAuthPass" style="width:30%;" placeholder="<?=term('Password',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
            if (event.code=='NumpadEnter') {
                omniAuthRequest('signup',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
            } else {
                omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
            }
        } else if (event.keyCode==27) { omniBoxAuthPass.value=''; omniBoxAuthLogin.focus();
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } else if (event.keyCode==113) { seekMusic(omniBoxAuthPass.value);
        } else if (event.keyCode==115) { seekBanner(omniBoxAuthPass.value);
        } else if (event.keyCode==118) { seekCode(omniBoxAuthLogin.value);
        } keyPressed();" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonAuth" class="power" onclick="if (authstate()) { omniAuthRequest('signout','',''); } else { omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString()); }" src="<?=$prefix[3].'user.png';?>" title="<?=term('Sign In/Out',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonRegister" class="power" onclick="omniAuthRequest('signup',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix[3].'book.png';?>" title="<?=term('Sign Up/Create Account',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="omniBoxAuthPass.value=''; omniBoxAuthLogin.value=''; omniBoxAuthLogin.focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Sign In Form',$settings,$session);?>">
    <?php } ?>
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutoplay" class="power" onclick="setdata('autoplay',flip(sysDefAutoplay.value));" src="<?=$prefix[3].(($session['autoplay'])?'autopause.png':'autoplay.png');?>" title="<?=term('Enable Autoplay',$settings,$session);?>">
    <input type='button' id="currentTime" style="width:52%;" onclick="setdata('timedisp',flip(sysDefTimedisp.value));" value="<?=date(($session['timedisp']!=0)?$session['date_format']:$session['time_format']);?>">
    <input type="image" id="buttonPrev" onmouseover="soundButton();" class="power" onclick="songIndex('prev');" src="<?=$prefix[3].'rew.png';?>" title="<?=term('Previous Track',$settings,$session);?>">
    <input type="image" id="buttonNext" onmouseover="soundButton();" class="power" onclick="songIndex('next');" src="<?=$prefix[3].'ff.png';?>" title="<?=term('Next Track',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonVintage" class="power" onclick="setdata('vintage',flip(sysDefVintage.value));" src="<?=$prefix[3].'diamante.png';?>" title="<?=term('Enable Vintage Effects',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonGloss" class="power" onclick="setdata('gloss',flip(sysDefGloss.value));" src="<?=$prefix[3].(($session['gloss']!=0)?'parfum.png':'deparfum.png');?>" title="<?=term('Enable Gloss/Gradient',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type='button' id="alarmTime" style="width:28%;" onclick="setdata('memo',''); pauseAudio(alarmPlayer);" value="00:00">
    <input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="if (sysDefPlaying.value==1) { omniPause(); } else { omniListen(demorse(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value)); }" src="<?=$prefix[3].(($session['playing']!=0)?'pause.png':'play.png');?>" title="<?=term('Audio Play/Pause',$settings,$session);?>">
    <input type="image" id="buttonMute" onmouseover="soundButton();" class="power" onclick="setdata('loop',flip(sysDefLoop.value));" src="<?=$prefix[3].'disk.png';?>" title="<?=term('Enable Loop Music',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonPitch" class="power" onclick="setdata('preserves_pitch',flip(sysDefPreservesPitch.value));" src="<?=$prefix[3].(($session['preserves_pitch']!=0)?'midi.png':'volume.png');?>" title="<?=term('Preserve Pitch',$settings,$session);?>">
    <select id="avatarPicker" style="width:42%;" onchange="setdata('avatar',avatarPicker.options[avatarPicker.selectedIndex].id); if (sysDefReload.value!=0) { window.location.reload(); }"><?php foreach ($userLocks['avatar'] as $key=>$value) { ?>
    <option id="<?=explode('.', $value)[1];?>" <?php if ($session['avatar']==explode('.',$value)[1]) { ?> selected <?php } ?>><?=explode('.',$value)[1];?></option><?php } ?>
    </select>
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutomator" class="power" onclick="automate(sysDefSessionID.value);" src="<?=$prefix[3].(($automateData[$sessionID]=='auto')?'wheel.png':'steer.png');?>" title="<?=term('Enable User Auto Mode',$settings,$session);?>">
    <input type='button' id="showUsInfoPower" style="width:32%;" value="<?=intval($powersData[$sessionID]);?>">
    <input type="image" onmouseover="soundButton();" id="buttonReticle" class="power" onclick="var uli=(sysDefUsersList.value).split(','),bdi=strarr(sysDefBindData.value,';',':'); delete uli[sysDefSessionID.value]; if (bdi[sysDefSessionID.value]!=sysDefSessionID.value) { bind(sysDefSessionID.value,sysDefSessionID.value); } else { bind(sysDefSessionID.value,uli[rand(0,(uli.length))]); } dominate(sysDefSessionID.value,strarr(sysDefBindData.value,';',':')[sysDefSessionID.value],strarr(sysDefToolData.value,';',':')[sysDefSessionID.value]); playAudio(hitPlayer,sysDefHitSound.value);" src="<?=$prefix[5].$session['reticle'].'.png';?>" title="<?=term('Hit Another User',$settings,$session);?>">
    <input type='button' id="showUsInfoBond" style="width:28%;" onclick="clip(sysDefSessionID.value);" value="<?=$sessionID;?>">
    <input type="image" onmouseover="soundButton();" id="buttonSpectate" class="power" onclick="setdata('spectate',flip(sysDefSpectate.value));" src="<?=$prefix[3].'unpower.png';?>" title="<?=term('Spectate Mode',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" id="userAvatarBadge" onmouseover="soundButton();" class="power" src="<?=$prefix[1].$session['avatar'].'.png';?>" onclick="setdata('face',flip(sysDefFace.value)); window.location.reload();" title="<?=term('Show/Hide User Avatar',$settings,$session);?>">
    <select id="setUnits" style="width:14%;" onchange="setdata('units',setUnits.options[setUnits.selectedIndex].id); if (sysDefReload.value!=0) { window.location.reload(); }">
    <?php foreach (explode(',',$session['units_list']) as $selID) { ?>
        <option id="<?=$selID;?>" <?php if ($session['units']==$selID) { ?> selected <?php } ?>><?=$selID;?></option>
    <?php } ?></select>
    <select id="setTheme" style="width:37%;" onchange="setdata('theme',setTheme.options[setTheme.selectedIndex].id); window.location.reload();">
    <?php foreach ((str_replace('./','',(glob('./*.start.png')))) as $key=>$value) { ?>
        <option id="<?=explode('.',$value)[0];?>" <?php if ($session['theme']==explode('.',$value)[0]) { ?> selected <?php } ?>><?=explode('.',$value)[0];?></option>
    <?php } ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonLock" class="power" onclick="invertLockRequest();" src="<?=$prefix[3].(($request['lock']!='false')?'restore.png':'maximize.png');?>" title="<?=term('Expand/Collapse Enhanced View',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonMenu" class="power" onclick="setdata('icons',flip(sysDefIcons.value)); window.location.reload();" src="<?=$prefix[3].(($session['icons']!=0)?'menu.png':'list.png');?>" title="<?=term('Icons/List Menu View',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="systemUpdate(sysDefBackload.value); window.location.reload();" src="<?=$prefix[3].'world.png';?>" title="<?=term('Eurohouse Update',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="omniBack(sysDefParent.value);" src="<?=$prefix[3].'escape.png';?>" title="<?=term('Go Back',$settings,$session);?>">
    </p>
</div>