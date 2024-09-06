<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonRandom" class="power" onclick="songIndex('random');" src="<?=$prefix.'dice.png'.$suffix;?>">
    <select id="ErotoOlympus" style="width:32%;" onchange="setdata('background', ErotoOlympus.options[ErotoOlympus.selectedIndex].id);">
    <?php foreach (categories($olympus, $locks['background']) as $key=>$val) { ?>
    <option disabled><?=titled($val, $session['units']);?></option>
    <?php foreach (categoryList($key) as $value) { ?>
    <option id="<?=$value.$suffix;?>" <?php if ((explode('.', $value)[0] == explode('.', $background)[0]) && (explode('.', $value)[1] == explode('.', $background)[1])) { ?> selected="selected" <?php } ?>><?=titler($value, $settings, $session['title'], $session['units']);?></option>
    <?php }} ?>
    </select>
    <input type="number" min='-11' max='12' step='1' id="setTimeZone" style="width:10%;" value="<?=$session['timezone'];?>" oninput="setdata('timezone', pad(setTimeZone.value, 2)); handleInput(this.value, true);" onkeydown="if (event.keyCode == 27) {
        setTimeZone.value = 0; setdata('timezone', setTimeZone.value);
    } else if (event.keyCode == 8) {
        handleInput(this.value);
    } else if (event.keyCode == 46) {
        handleInput(this.value);
    }">
    <input type="image" id="buttonLock" onmouseover="soundButton();" class="power" onclick="setdata('lock', flip(sysDefLock.value));" src="<?=($session['lock'] != 0) ? $prefix.'key.png'.$suffix : $prefix.'lock.png'.$suffix;?>">
    <input type="image" id="buttonOnReload" onmouseover="soundButton();" class="power" onclick="setdata('reload', flip(sysDefReload.value));" src="<?=($session['reload'] != 0) ? $prefix.'character.png'.$suffix : $prefix.'font.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonSongIndex" class="power" onclick="setdata('song_index', nextImage(';random;next;prev',sysDefSongIndex.value));" src="<?php if ($session['song_index'] == 'random') {
        echo $prefix.'dice.png'.$suffix;
    } elseif ($session['song_index'] == 'prev') {
        echo $prefix.'rew.png'.$suffix;
    } elseif ($session['song_index'] == 'next') {
        echo $prefix.'ff.png'.$suffix;
    } else {
        echo $prefix.'code.png'.$suffix;
    } ?>">
    <input type="image" id="buttonChild" onmouseover="soundButton();" class="power" onclick="setdata('censor', flip(sysDefCensor.value));" src="<?=($session['censor'] != 0) ? $prefix.'weather.png'.$suffix : $prefix.'tree.png'.$suffix;?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="setdata('observe', flip(sysDefObserve.value));" src="<?=$prefix.'power.png'.$suffix;?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <?php if (isAuth()) { ?>
        <input type="image" onmouseover="soundButton();" id="buttonChat" class="power" onclick="setdata('chat', flip(sysDefChat.value)); omniBox.focus();" src="<?=($session['chat'] != 0) ? $prefix.'book.png'.$suffix : $prefix.'bash.png'.$suffix;?>">
        <input type='text' id="omniBox" style="width:60%;" placeholder="<?=term('Type expression and press ENTER', $settings['vocabulary'], $session['units']);?>" value="" onkeydown="
        if (event.keyCode == 13) {
            omniEnter();
        } else if (event.keyCode == 27) {
            document.getElementById('omniBox').value = '';
        } else if (event.keyCode == 8) {
            handleInput(this.value);
        } else if (event.keyCode == 46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value, true);">
        <input type="image" onmouseover="soundButton();" id="buttonEnter" class="power" onclick="omniEnter();" src="<?=$prefix.'return.png'.$suffix;?>">
        <input type="image" onmouseover="soundButton();" id="buttonKeyboard" class="power" onclick="document.getElementById('omniBox').focus();" src="<?=$prefix.'keyboard.png'.$suffix;?>">
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="document.getElementById('omniBox').value = '';
        document.getElementById('omniBox').focus();" src="<?=$prefix.'backspace.png'.$suffix;?>">
    <?php } else { ?>
        <input type='text' id="omniBoxAuthLogin" style="width:34%;" placeholder="<?=term('Username', $settings['vocabulary'], $session['units']);?>" value="" onkeydown="if (event.keyCode == 13) {
            document.getElementById('omniBoxAuthPass').value = '';
            document.getElementById('omniBoxAuthPass').focus();
        } else if (event.keyCode == 27) {
            document.getElementById('omniBoxAuthLogin').value = '';
        } else if (event.keyCode == 8) {
            handleInput(this.value);
        } else if (event.keyCode == 46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value, true);">
        <input type='password' id="omniBoxAuthPass" style="width:34%;" placeholder="<?=term('Password', $settings['vocabulary'], $session['units']);?>" value="" onkeydown="
        if (event.keyCode == 13) {
            omniAuthRequest('signin', omniBoxAuthLogin.value, CryptoJS.SHA256(omniBoxAuthPass.value).toString());
        } else if (event.keyCode == 27) {
            document.getElementById('omniBoxAuthPass').value = '';
            document.getElementById('omniBoxAuthLogin').focus();
        } else if (event.keyCode == 8) {
            handleInput(this.value);
        } else if (event.keyCode == 46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value, true);">
        <input type="image" onmouseover="soundButton();" id="buttonLogin" class="power" onclick="omniAuthRequest('signin', omniBoxAuthLogin.value, CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix.'user.png'.$suffix;?>">
        <input type="image" onmouseover="soundButton();" id="buttonRegister" class="power" onclick="omniAuthRequest('signup', omniBoxAuthLogin.value, CryptoJS.SHA256(omniBoxAuthPass.value).toString());" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" onmouseover="soundButton();" id="buttonCancelSignin" class="power" onclick="document.getElementById('omniBoxAuthPass').value = '';
        document.getElementById('omniBoxAuthLogin').value = '';
        document.getElementById('omniBoxAuthLogin').focus();" src="<?=$prefix.'backspace.png'.$suffix;?>">
    <?php } ?>
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonTime" class="power" onclick="setdata('benchmark', flip(sysDefBenchmark.value));" src="<?=$prefix.'time.png'.$suffix;?>">
    <input type='button' id="currentTime" style="width:31%;" onclick="setdata('timedisp', flip(sysDefTimedisp.value));" value="00:00:00">
    <input type="image" id="buttonPrev" onmouseover="soundButton();" class="power" onclick="songIndex('prev');" src="<?=$prefix.'rew.png'.$suffix;?>">
    <input type="image" id="buttonNext" onmouseover="soundButton();" class="power" onclick="songIndex('next');" src="<?=$prefix.'ff.png'.$suffix;?>">
    <input type="number" min='0' max='23' step='1' id="setTimeHour" style="width:10%;" value="<?=$session['hour'];?>" oninput="setdata('hour', pad(setTimeHour.value, 2));
    handleInput(this.value, true);" onkeydown="if (event.keyCode == 27) {
        setTimeHour.value = 12; setdata('hour', setTimeHour.value);
    } else if (event.keyCode == 8) {
        handleInput(this.value);
    } else if (event.keyCode == 46) {
        handleInput(this.value);
    }">
    <input type="image" onmouseover="soundButton();" id="buttonVintage" class="power" onclick="setdata('vintage', flip(sysDefVintage.value));" src="<?=$prefix.'diamante.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonGloss" class="power" onclick="setdata('gloss', flip(sysDefGloss.value));" src="<?=($session['gloss'] != 0) ? $prefix.'parfum.png'.$suffix : $prefix.'idea.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonAugment" class="power" onclick="setdata('entry', nextImage(sysDefVarsArr.value, sysDefEntry.value));" src="<?=$prefix.'spade.png'.$suffix;?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutoplay" class="power" onclick="setdata('autoplay', flip(sysDefAutoplay.value));" src="<?=$prefix.'autoplay.png'.$suffix;?>">
    <input type='button' id="alarmTime" style="width:31%;" onclick="setdata('memo', ''); pauseAudio(alarmPlayer);" value="00:00:00">
    <input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="if (sysDefPlaying.value == 1) {
        omniPause();
    } else {
        omniListen(hex2bin(sysDefMelody.value));
    }" src="<?=$prefix.'play.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonPitched" class="power" onclick="setdata('pitch_lock', flip(sysDefPitchLock.value));" src="<?=($session['pitch_lock']) ? $prefix.'microphone.png'.$suffix : $prefix.'volume.png'.$suffix;?>">
    <select id="avatarPicker" style="width:19%;" onchange="setdata('avatar', avatarPicker.options[avatarPicker.selectedIndex].id);">
    <?php foreach (excpkg($kaiser, $locks['avatar']) as $key=>$value) { ?>
    <option id="<?=explode('.', $value)[1];?>" <?php if ($session['avatar'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
        <?=explode('.', $value)[1];?>
    </option>
    <?php } ?>
    </select>
    <input type="image" id="buttonAlarm" onmouseover="soundButton();" class="power" onclick="if (alarmPlayer.paused) {
        playAudio(alarmPlayer, sysDefAlarmSound.value);
    } else {
        pauseAudio(alarmPlayer);
    }" src="<?=$prefix.'call.png'.$suffix;?>">
    <input type="image" id="buttonMute" onmouseover="soundButton();" class="power" onclick="setdata('mute', flip(sysDefMute.value));" src="<?=$prefix.'music.png'.$suffix;?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" id="buttonAutomator" class="power" onclick="automate();" src="<?=($automateData[$sessionID] == 'auto') ? $prefix.'wheel.png'.$suffix : $prefix.'steer.png'.$suffix;?>">
    <input type='button' id="showUsInfoPower" style="width:29%;" value="<?=intval($powersData[$sessionID]);?>">
    <input type="image" onmouseover="soundButton();" id="buttonBroke" class="power" onclick="unbind(sysDefSessionID.value);" src="<?=$prefix.'chain.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonReticle" class="power" onclick="dominate(sysDefSessionID.value, arrjob(sysDefBindData.value,';',':')[sysDefSessionID.value], 1, 1, 0); playAudio(hitPlayer, sysDefHitSound.value);" src="<?=$reticlePrefix.$session['reticle'].'.png'.$suffix;?>">
    <input type='button' id="showUsInfoBond" style="width:30%;" value="<?='@'.$sessionID;?>">
    <input type="image" onmouseover="soundButton();" id="buttonPrivate" class="power" onclick="setdata('private', flip(sysDefPrivate.value));" src="<?=($session['private'] != 0) ? $prefix.'home.png'.$suffix : $prefix.'world.png'.$suffix;?>">
    </p>
</div>
<div class='topBarItem'>
    <p align='center' class='block'>
    <input type="image" id="userAvatarBadge" onmouseover="soundButton();" class="power" src="<?=$abcPrefix.$session['avatar'].'.png'.$suffix;?>" onclick="setdata('spectate', flip(sysDefSpectate.value));">
    <select id="setUnits" style="width:14%;" onchange="setdata('units', setUnits.options[setUnits.selectedIndex].id); if (sysDefReload.value != 0) { window.location.reload(); }">
    <?php foreach (explode(',', $session['units_list']) as $selID) { ?>
    <option id="<?=$selID;?>" <?php if ($session['units'] == $selID) { ?> selected <?php } ?>><?=$selID;?></option>
    <?php } ?>
    </select>
    <select id="setTheme" style="width:18%;" onchange="setdata('theme', setTheme.options[setTheme.selectedIndex].id);window.location.reload();">
    <?php foreach ($thematic as $key=>$value) { ?>
        <option id="<?=explode('.', $value)[0];?>" <?php if ($session['theme'] == explode('.', $value)[0]) { ?> selected <?php } ?>><?=explode('.', $value)[0];?></option>
    <?php } ?></select>
    <input type="image" onmouseover="soundButton();" id="buttonReqLock" class="power" onclick="if (requestLock.value == 'true') {
        omniLock('false');
    } else {
        omniLock('true');
    }" src="<?=($request['lock'] == 'true') ? $prefix.'collapse.png'.$suffix : $prefix.'expand.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonFaceoff" class="power" onclick="setdata('faceoff', flip(sysDefFaceoff.value)); window.location.reload();
    " src="<?php if ($session['faceoff'] == 1) {
        echo $prefix.'maximize.png'.$suffix;
    } else {
        echo $prefix.'restore.png'.$suffix;
    } ?>">
    <input type="image" onmouseover="soundButton();" id="buttonIconsList" class="power" onclick="setdata('icons', flip(sysDefIcons.value));window.location.reload();" src="<?php if ($session['icons'] == 1) {
        echo $prefix.'menu.png'.$suffix;
    } else {
        echo $prefix.'list.png'.$suffix;
    } ?>">
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="systemUpdate(sysDefBackload.value);window.location.reload();" src="<?=$prefix.'update.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonUserStatus" class="power" onclick="omniAuthRequest('signout','','');" src="<?php if (isAuth()) {
        echo $prefix.'user.png'.$suffix;
    } else {
        echo $prefix.'anonym.png'.$suffix;
    } ?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="omniBack(sysDefParent.value);" src="<?=$prefix.'escape.png'.$suffix;?>">
    </p>
</div>