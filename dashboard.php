<div class='topBarItem'>
    <p align='center' class='block'>
    <select id="wallpaperCollection" style="width:70%;text-align:<?=$session['dropdown_align'];?>;" onchange="setdata('background_buffer',this.options[this.selectedIndex].id);">
    <?php foreach ($userSubscr['background'] as $key=>$val) { ?>
    <option disabled><?=titlePkgEnt($val,'collection',$settings,$session);?></option>
    <?php foreach (str_replace('./','',(glob('./'.$key.'.*.00.png'))) as $value) { ?>
        <option id="<?=$value;?>" <?php if ((explode('.',$value)[0]==explode('.',$session['background_buffer'])[0])&&(explode('.',$value)[1]==explode('.',$session['background_buffer'])[1])) { ?> selected="selected" <?php } ?>>
            <?=titlePkgEnt($value,'series',$settings,$session);?>
        </option>
    <?php }} ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonShuffle" class="power" onclick="soundClick(); setdata('shuffle',flip(sysDefShuffle.value));" src="<?=$prefix[3].(($session['shuffle']!=0)?'shuffle.png':'update.png');?>" title="<?=term('Audio Playlist Shuffle/Repeat',$settings,$session);?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="soundClick(); setdata('observe',flip(sysDefObserve.value));" src="<?=$prefix[3].'power.png';?>" title="<?=term('Observe Background View',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <?php if (isAuthorized()) { ?>
        <input type='text' id="omniBox" style="width:70%;" placeholder="<?=term("Type anything and press ENTER",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { omniEnter();
        } else if (event.keyCode==27) { omniBox.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" id="buttonEnter" class="power" onclick="soundClick(); omniEnter();" src="<?=$prefix[3].'return.png';?>" title="<?=term('Execute Command',$settings,$session);?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="soundClick(); omniBox.value=''; omniBox.focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Console',$settings,$session);?>">
    <?php } else { ?>
        <input type='text' id="omniBoxAuthLogin" style="width:35%;" placeholder="<?=term('Username',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
            omniBoxAuthPass.value=''; omniBoxAuthPass.focus();
        } else if (event.keyCode==27) { omniBoxAuthLogin.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type='password' id="omniBoxAuthPass" style="width:35%;" placeholder="<?=term('Password',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
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
    <input type='button' id="currentTime" style="width:62%;" onclick="soundClick(); setdata('timedisp',flip(sysDefTimedisp.value));" value="<?=date(($session['timedisp']!=0)?$session['date_format']:$session['time_format']);?>">
    <input type="image" id="buttonPrev" onmouseover="soundButton();" class="power" onclick="soundClick(); omniPlaylist(-2);" src="<?=$prefix[3].'rew.png';?>" title="<?=term('Previous Track',$settings,$session);?>">
    <input type="image" id="buttonNext" onmouseover="soundButton();" class="power" onclick="soundClick(); omniPlaylist(-1);" src="<?=$prefix[3].'ff.png';?>" title="<?=term('Next Track',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonSlideshow" class="power" onclick="soundClick(); if (sysDefBackground.value!='') { setdata('background',''); } else { setdata('slideshow',nextImage('0;5',sysDefSlideshow.value)); }" src="<?=$prefix[3].(($session['background']!='')?'image.png':(($session['slideshow'])?'speed.png':'time.png'));?>" title="<?=term('Toggle Slideshow/Dynamic Wallpaper',$settings,$session);?>">
    <input type='button' id="alarmTime" style="width:36%;" onclick="soundClick(); setdata('memo',''); pauseAudio(alarmPlayer);" value="00:00">
    <input id="showUserAvatarBadge" type='image' onmouseover="soundButton();" class="power" src="<?=$prefix[0].$session['avatar'].'.png';?>" title="<?=term('User Avatar',$settings,$session);?>" onclick="soundClick(); setdata('face',flip(sysDefFace.value));">
    <select id="setUnits" style="width:16%;" onchange="setdata('units',setUnits.options[setUnits.selectedIndex].id);">
    <?php foreach (explode(',',$session['units_list']) as $selID) { ?>
        <option id="<?=$selID;?>" <?php if ($session['units']==$selID) { ?> selected <?php } ?>><?=$selID;?></option>
    <?php } ?>
    </select>
    <input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="soundClick(); if (sysDefPlaying.value!=0) { omniPause(); } else { omniListen(demorse(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value),false,sysDefCurrent.value); } setdata('playing',flip(sysDefPlaying.value));" src="<?=$prefix[3].(($session['playing']!=0)?'pause.png':'play.png');?>" title="<?=term('Audio Play/Pause',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonSpectate" class="power" onclick="soundClick(); setdata('spectate',flip(sysDefSpectate.value));" src="<?=$prefix[3].'unpower.png';?>" title="<?=term('Spectate Mode',$settings,$session);?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAuthState" class="power" onclick="soundClick(); if (authstate()) { omniAuthRequest(); } else { omniAuthRequest('signin',omniBoxAuthLogin.value,CryptoJS.SHA256(omniBoxAuthPass.value).toString()); }" src="<?=$prefix[3].((isAuthorized())?'user.png':'anonym.png');?>" title="<?=term('Sign In/Out',$settings,$session);?>">
    <input type='button' id="usernameBanner" style="width:43%;" onclick="soundClick(); clip(this.value);" value="<?=$sessionID;?>">
    <input type="image" onmouseover="soundButton();" id="buttonRequestLock" class="power" onclick="soundClick(); invertLockRequest();" src="<?=$prefix[3].(($request['lock']!='false')?'lock.png':'key.png');?>" title="<?=term('Expand/Collapse Enhanced View',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonMenu" class="power" onclick="soundClick(); setdata('menu_view',nextImage('thumb;menu;list',sysDefMenuView.value)); window.location.reload();" src="<?=$prefix[3].$session['menu_view'].'.png';?>" title="<?=term('Icons/List Menu View',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="soundClick(); getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5('backward').toString()).value,'get ',0);" src="<?=$prefix[3].'world.png';?>" title="<?=term('Eurohouse Update',$settings,$session);?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="soundClick(); omniBack(sysDefParent.value);" src="<?=$prefix[3].((file_exists('mode.'.$request['mode'].'.php'))?'escape.png':'forward.png');?>" title="<?=term('Go Back/Go Forward',$settings,$session);?>">
    </p>
</div>
