<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonMusic" class="power" onclick="soundClick(); var objCmdTxt=(authstate())?omniBox:omniBoxAuthLogin; seekMusic(objCmdTxt.value);" src="<?=$prefix[3].'music.png';?>" title="<?=term('Random Track',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonImage" class="power" onclick="soundClick(); var objCmdTxt=(authstate())?omniBox:omniBoxAuthLogin; if (sysDefBackground.value!='') { setdata('background',''); } else { seekImage(objCmdTxt.value); }" src="<?=$prefix[3].(($session['background']!='')?'paint.png':'image.png');?>" title="<?=term('Random Background',$settings,$session);?>">
    <select id="wallpaperCollection" style="width:57%;" onchange="soundClick(); setdata('background_buffer',this.options[this.selectedIndex].id);">
    <?php foreach ($userSubscr['background'] as $key=>$val) { ?>
    <option disabled><?=wallpaperTitle($val,'collection',$settings,$session);?></option>
    <?php foreach (str_replace('./','',(glob('./'.$key.'.*.00.png'))) as $value) { ?>
        <option id="<?=$value;?>" <?php if ((explode('.',$value)[0]==explode('.',$session['background_buffer'])[0])&&(explode('.',$value)[1]==explode('.',$session['background_buffer'])[1])) { ?> selected="selected" <?php } ?>>
            <?=wallpaperTitle($value,'series',$settings,$session);?>
        </option>
    <?php }} ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonShuffle" class="power" onclick="soundClick(); setdata('shuffle',flip(sysDefShuffle.value));" src="<?=$prefix[3].(($session['shuffle']!=0)?'shuffle.png':'update.png');?>" title="<?=term('Audio Playlist Shuffle/Repeat',$settings,$session);?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="soundClick(); setdata('observe',flip(sysDefObserve.value));" src="<?=$prefix[3].'power.png';?>" title="<?=term('Observe Background View',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <?php if (isAuthorized()) { ?>
        <input type="image" onmouseover="soundButton();" id="buttonAuth" class="power" onclick="soundClick(); if (authstate()) { omniAuthRequest(); } else { omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString()); }" src="<?=$prefix[3].'user.png';?>" title="<?=term('Sign In/Out',$settings,$session);?>">
        <input type='text' id="omniBox" style="width:65%;" placeholder="<?=term("Type anything and press ENTER",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { omniEnter();
        } else if (event.keyCode==27) { omniBox.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonEnter" class="power" onclick="soundClick(); omniEnter();" src="<?=$prefix[3].'return.png';?>" title="<?=term('Execute Command',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="soundClick(); omniBox.value=''; omniBox.focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Console',$settings,$session);?>">
    <?php } else { ?>
        <input type="image" onmouseover="soundButton();" id="buttonSuggest" class="power" onclick="soundClick(); omniSuggest();" src="<?=$prefix[3].'dice.png';?>" title="<?=term('Suggest Username',$settings,$session);?>">
        <input type='text' id="omniBoxAuthLogin" style="width:33%;" placeholder="<?=term('Username',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
            omniBoxAuthPass.value=''; omniBoxAuthPass.focus();
        } else if (event.keyCode==27) { omniBoxAuthLogin.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type='password' id="omniBoxAuthPass" style="width:32%;" placeholder="<?=term('Password',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
            omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString());
        } else if (event.keyCode==27) {
            omniBoxAuthPass.value=''; omniBoxAuthLogin.focus();
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        } else if (event.keyCode==113) { seekMusic(omniBoxAuthPass.value);
        } else if (event.keyCode==115) { seekImage(omniBoxAuthPass.value);
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonAuth" class="power" onclick="soundClick(); if (authstate()) { omniAuthRequest('signout','',''); } else { omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString()); }" src="<?=$prefix[3].'user.png';?>" title="<?=term('Sign In/Out',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="soundClick(); omniBoxAuthPass.value=''; omniBoxAuthLogin.value=''; omniBoxAuthLogin.focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Sign In Form',$settings,$session);?>">
    <?php } ?>
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutoplay" class="power" onclick="soundClick(); setdata('autoplay',flip(sysDefAutoplay.value));" src="<?=$prefix[3].(($session['autoplay'])?'autopause.png':'autoplay.png');?>" title="<?=term('Enable Autoplay',$settings,$session);?>">
    <input type='button' id="currentTime" style="width:66%;" onclick="soundClick(); setdata('timedisp',flip(sysDefTimedisp.value));" value="<?=date(($session['timedisp']!=0)?$session['date_format']:$session['time_format']);?>">
    <input type="image" id="buttonPrev" onmouseover="soundButton();" class="power" onclick="soundClick(); omniPlaylist(-2);" src="<?=$prefix[3].'rew.png';?>" title="<?=term('Previous Track',$settings,$session);?>">
    <input type="image" id="buttonNext" onmouseover="soundButton();" class="power" onclick="soundClick(); omniPlaylist(-1);" src="<?=$prefix[3].'ff.png';?>" title="<?=term('Next Track',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type='button' id="alarmTime" style="width:30%;" onclick="soundClick(); setdata('memo',''); pauseAudio(alarmPlayer);" value="00:00">
    <input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="soundClick(); if (sysDefPlaying.value!=0) { omniPause(); } else { omniListen(atob(sysDefMelody.value),false,sysDefCurrent.value); } setdata('playing',flip(sysDefPlaying.value));" src="<?=$prefix[3].(($session['playing']!=0)?'pause.png':'play.png');?>" title="<?=term('Audio Play/Pause',$settings,$session);?>">
    <input type="image" id="buttonBackSound" onmouseover="soundButton();" class="power" onclick="soundClick(); setdata('loop',flip(sysDefLoop.value));" src="<?=$prefix[3].'disk.png';?>" title="<?=term('Enable Loop Music',$settings,$session);?>">
    <select id="avatarPicker" style="width:27%;" onchange="setdata('avatar',avatarPicker.options[avatarPicker.selectedIndex].id);">
    <?php foreach ($userSubscr['avatar'] as $key=>$value) { ?>
    <option id="<?=explode('.',$value)[1];?>" <?php if ($session['avatar']==explode('.',$value)[1]) { ?> selected <?php } ?>><?=explode('.',$value)[1];?></option><?php } ?>
    </select>
    <input type="image" onmouseover="soundButton();" id="buttonMute" class="power" onclick="soundClick(); setdata('mute',flip(sysDefMute.value));" src="<?=$prefix[3].(($session['mute']!=0)?'audio.png':'error.png');?>" title="<?=term('Mute Audio',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonSpectate" class="power" onclick="soundClick(); setdata('spectate',flip(sysDefSpectate.value));" src="<?=$prefix[3].'unpower.png';?>" title="<?=term('Spectate Mode',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" id="userAvatarBadge" onmouseover="soundButton();" class="power" src="<?=$prefix[1].$session['avatar'].'.png';?>" onclick="soundClick(); setdata('grid',flip(sysDefGrid.value)); window.location.reload();" title="<?=term('Show/Hide User Avatar',$settings,$session);?>">
    <select id="setUnits" style="width:16%;" onchange="setdata('units',setUnits.options[setUnits.selectedIndex].id); window.location.reload();">
    <?php foreach (explode(',',$session['units_list']) as $selID) { ?>
        <option id="<?=$selID;?>" <?php if ($session['units']==$selID) { ?> selected <?php } ?>><?=$selID;?></option>
    <?php } ?></select>
    <select id="setTheme" style="width:32%;" onchange="setdata('theme',setTheme.options[setTheme.selectedIndex].id); window.location.reload();">
    <?php foreach ((str_replace('./','',(glob('./*.start.png')))) as $key=>$value) { ?>
        <option id="<?=explode('.',$value)[0];?>" <?php if ($session['theme']==explode('.',$value)[0]) { ?> selected <?php } ?>><?=explode('.',$value)[0];?></option>
    <?php } ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonLock" class="power" onclick="soundClick(); invertLockRequest();" src="<?=$prefix[3].(($request['lock']!='false')?'lock.png':'key.png');?>" title="<?=term('Expand/Collapse Enhanced View',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonMenu" class="power" onclick="soundClick(); setdata('menu_view',nextImage('thumb;menu;list',sysDefMenuView.value)); window.location.reload();" src="<?=$prefix[3].$session['menu_view'].'.png';?>" title="<?=term('Icons/List Menu View',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="soundClick(); getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5('backward').toString()).value,'get ',0);" src="<?=$prefix[3].'world.png';?>" title="<?=term('Eurohouse Update',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="soundClick(); omniBack(sysDefParent.value);" src="<?=$prefix[3].((file_exists('mode.'.$request['mode'].'.php'))?'escape.png':'forward.png');?>" title="<?=term('Go Back/Go Forward',$settings,$session);?>">
    </p>
</div>