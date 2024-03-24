<?php include 'backend.php'; ?>
<html><head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title><?=$session['title'].' (@'.$sessionID.') · Eurohouse UX/UI';?></title>
<link rel="shortcut icon" href="favicon.png?rev=<?=time();?>" type="image/x-icon">
<?php include 'wardrobe.php'; ?>
<script src="jquery.js?rev=<?=time();?>"></script>
<script src="backend.js?rev=<?=time();?>"></script>
<script src="frontend.js?rev=<?=time();?>"></script>
<script src="tablesort.js?rev=<?=time();?>"></script>
<script src="nerdamer.js?rev=<?=time();?>"></script>
<script src="algebra.js?rev=<?=time();?>"></script>
<script src="calculus.js?rev=<?=time();?>"></script>
<script src="solve.js?rev=<?=time();?>"></script>
<script src="aframe.js?rev=<?=time();?>"></script>
<script src="crypto.js?rev=<?=time();?>"></script>
<script src="http://www.midijs.net/lib/midi.js"></script>
<?php include 'frontend.php'; include 'commands.php'; ?>
</head><body><div class='overlay'><?php
foreach ($request as $key=>$value) { ?>
    <input type='hidden' id="<?='request'.ucfirst($key);?>" value="<?=$value;?>">
<?php } foreach ($session as $key=>$value) { ?>
    <input type='hidden' id="<?='sysDef'.camel($key);?>" value="<?=$value;?>">
<?php } ?><input type='hidden' id='sysDefBackload' value="<?=$backloadString;?>">
<input type='hidden' id='sysDefPrefix' value="<?=$prefix;?>">
<input type='hidden' id='sysDefReticlePrefix' value="<?=$reticlePrefix;?>">
<input type='hidden' id='sysDefSuffix' value="<?=$suffix;?>">
<input type='hidden' id="sysDefIsSession" value="<?=(isset($_SESSION['user']));?>">
<input type='hidden' id="sysDefSessionID" value="<?=$sessionID;?>">
<input type='hidden' id="sysDefHandledID" value="<?=$handledID;?>">
<input type='hidden' id="sysDefPostBackEff" value="0">
<input type='hidden' id="sysDefPostTickEff" value="0">
<input type='hidden' id="sysDefVarsArr" value="">
<input type='hidden' id="sysDefMsgCounter" value="0">
<input type='hidden' id="sysDefBindData" value="<?=valstr($bindData,';',':');?>"><input type='hidden' id="sysDefPowersData" value="<?=valstr($powersData,';',':');?>">
<input type='hidden' id="sysDefMsgData" value="<?=fileopen('./.log/msgbox.log', '');?>"><input type='hidden' id="sysDefMusicBox" value="<?=implode('//', $musicBox);?>">
<input type='hidden' id="sysDefSubP" value="<?=$powersData[$sessionID];?>"><input type='hidden' id="sysDefPostBindData" value="<?=valstr($bindData,';',':');?>"><input type='hidden' id="sysDefPostPowersData" value="<?=valstr($powersData,';',':');?>"><input type='hidden' id="sysDefPostMsgData" value="<?=fileopen('./.log/msgbox.log', '');?>"><input type='hidden' id="sysDefPostSubP" value="<?=$powersData[$sessionID];?>">
<input type='hidden' id='sysDefAvatarIcons' value="<?=implode(';', $kaiser);?>"><p align='center' class='block'><input hidden type="image" onmouseover="soundButton();" class="power" id="powerButton" onclick="setdata('observe', flip(sysDefObserve.value));" src="<?=$prefix.'power.png'.$suffix;?>"></p>
<div class='topbar'><?php if (file_exists('mode.'.$request['mode'].'.php')) {
    $curModeFile = paging('mode.'.$request['mode'].'.php', [2,3]); if (strpos($curModeFile[2], '-->') !== false) {
        $curMode1 = str_replace(' -->', '', str_replace('<!-- ', '', $curModeFile[2])); $parent = ($curMode1 == '<ref>') ? $request['ref'] : $curMode1;
    } else {
        $parent = 'main_menu';
    } $isRef = (strpos($curModeFile[3], '-->') !== false) ? str_replace(' -->', '', str_replace('<!-- ', '', $curModeFile[3])) : 'false';
} else {
    $parent = 'main_menu'; $isRef = 'false';
} ?><input type='hidden' id='sysDefParent' value="<?=$parent;?>"><input type='hidden' id='sysDefIsRef' value="<?=$isRef;?>">
<div class='topBarItem'><p align='center' class='block'>
    <select id="ErotoOlympus" style="width:50%;position:relative;" onchange="setdata('background', ErotoOlympus.options[ErotoOlympus.selectedIndex].id);">
    <?php foreach (categories($olympus) as $key=>$val) { ?>
    <option disabled><?=titled($val, $session['units']);?></option>
    <?php foreach (categoryList($key) as $value) { ?>
    <option id="<?=$value.$suffix;?>" <?php if ((explode('.', $value)[0] == explode('.', $background)[0]) && (explode('.', $value)[1] == explode('.', $background)[1])) { ?> selected="selected" <?php } ?>><?=titler($value, $settings, $session['title'], $session['units']);?></option>
    <?php }} ?>
    </select>
    <select id="TimeZoneChoose" style="width:26%;position:relative;" onchange="setdata('timezone', TimeZoneChoose.options[TimeZoneChoose.selectedIndex].id);">
    <?php foreach ($timezoneDatabase as $key=>$value) { ?>
        <option id="<?=$key;?>" <?php if (enc_tz($timezone) == $key) { ?> selected="selected" <?php } ?>><?=$value['sign'].$value['offset'].':00';?></option>
    <?php } ?>
    </select>
    <input type="image" id="buttonLock" onmouseover="soundButton();" class="power" onclick="setdata('lock', flip(sysDefLock.value));" src="<?=($session['lock'] != 0) ? $prefix.'key.png'.$suffix : $prefix.'lock.png'.$suffix;?>">
    <input type="image" id="buttonObserve" onmouseover="soundButton();" class="power" onclick="setdata('observe', flip(sysDefObserve.value));" src="<?=$prefix.'power.png'.$suffix;?>">
</p></div>
<div class='topBarItem'><p align='center' class='block'>
    <?php if (isset($_SESSION['user'])) { ?>
        <input type='text' id="omniBox" style="width:67%;position:relative;" placeholder="Type expression and press ENTER" value="" onkeydown="
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
        <input type="image" onmouseover="soundButton();" id="buttonBackspace" class="power" onclick="
        document.getElementById('omniBox').value = '';
        document.getElementById('omniBox').focus();
        " src="<?=$prefix.'backspace.png'.$suffix;?>">
    <?php } else { ?>
        <input type='text' id="omniBoxAuthLogin" style="width:34%;position:relative;" placeholder="Username" value="" onkeydown="if (event.keyCode == 13) {
            document.getElementById('omniBoxAuthPass').value = '';
            document.getElementById('omniBoxAuthPass').focus();
        } else if (event.keyCode == 27) {
            document.getElementById('omniBoxAuthLogin').value = '';
        } else if (event.keyCode == 8) {
            handleInput(this.value);
        } else if (event.keyCode == 46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value, true);">
        <input type='password' id="omniBoxAuthPass" style="width:33%;position:relative;" placeholder="Password" value="" onkeydown="
        if (event.keyCode == 13) {
            omniAuthRequest('signin', omniBoxAuthLogin.value, omniBoxAuthPass.value);
        } else if (event.keyCode == 27) {
            document.getElementById('omniBoxAuthPass').value = '';
            document.getElementById('omniBoxAuthLogin').focus();
        } else if (event.keyCode == 8) {
            handleInput(this.value);
        } else if (event.keyCode == 46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value, true);">
        <input type="image" onmouseover="soundButton();" id="buttonLogin" class="power" onclick="omniAuthRequest('signin', omniBoxAuthLogin.value, omniBoxAuthPass.value);" src="<?=$prefix.'user.png'.$suffix;?>">
        <input type="image" onmouseover="soundButton();" id="buttonRegister" class="power" onclick="omniAuthRequest('signup', omniBoxAuthLogin.value, omniBoxAuthPass.value);" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" onmouseover="soundButton();" id="buttonCancelSignin" class="power" onclick="
        document.getElementById('omniBoxAuthPass').value = '';
        document.getElementById('omniBoxAuthLogin').value = '';
        document.getElementById('omniBoxAuthLogin').focus();
        " src="<?=$prefix.'backspace.png'.$suffix;?>">
    <?php } ?>
</p></div>
<div class='topBarItem'><p align='center' class='block'>
    <input type='button' id="currentTime" style="width:33%;position:relative;" onclick="setdata('timedisp', flip(sysDefTimedisp.value));" value="00:00:00">
    <input type="image" onmouseover="soundButton();" id="buttonTime" class="power" onclick="setdata('benchmark', nextImage('0;2;4', sysDefBenchmark.value));" src="<?=$prefix.'time.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonAutoplay" class="power" onclick="setdata('autoplay', flip(sysDefAutoplay.value));" src="<?=$prefix.'autoplay.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonVintage" class="power" onclick="if ((sysDefSepia.value > 0) && (sysDefGrayscale.value > 0)) { setdata('vintage', 0); setdata('sepia', 0); setdata('grayscale', 0); } else { setdata('vintage', 1); setdata('sepia', 50); setdata('grayscale', 50); }" src="<?=$prefix.'diamante.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonGloss" class="power" onclick="setdata('gloss', flip(sysDefGloss.value));" src="<?=$prefix.'parfum.png'.$suffix;?>">
    <input type="number" min='0' max='9' step='1' id="setMagnitude" style="width:8%;" value="<?=$session['magnitude'];?>" oninput="setdata('magnitude', setMagnitude.value); handleInput(this.value, true);" onkeydown="if (event.keyCode == 27) {
        setMagnitude.value = 7; setdata('magnitude', '7');
    } else if (event.keyCode == 8) {
        handleInput(this.value);
    } else if (event.keyCode == 46) {
        handleInput(this.value);
    }">
    <input type="number" min='0' max='23' step='1' id="setTimeHour" style="width:8%;" value="<?=$session['hour'];?>" oninput="setdata('hour', pad(setTimeHour.value, 2)); handleInput(this.value, true);" onkeydown="if (event.keyCode == 27) {
        setTimeHour.value = 12; setdata('hour', '12');
    } else if (event.keyCode == 8) {
        handleInput(this.value);
    } else if (event.keyCode == 46) {
        handleInput(this.value);
    }">
    <input type="image" onmouseover="soundButton();" id="buttonAugment" class="power" onclick="setdata('entry', nextImage(sysDefVarsArr.value, sysDefEntry.value));" src="<?=$prefix.'spade.png'.$suffix;?>">
</p></div>
<div class='topBarItem'><p align='center' class='block'>
    <input type='button' id="alarmTime" style="width:33%;position:relative;" onclick="setdata('memo', ''); pauseAudio(alarmPlayer);" value="00:00:00">
    <input type="image" onmouseover="soundButton();" id="buttonPlus" class="power" onclick="setdata('memo', (Math.round(Date.now() / 1000) + 10));" src="<?=$prefix.'plus.png'.$suffix;?>">
    <input type="image" id="buttonPlay" onmouseover="soundButton();" class="power" onclick="if (sysDefPlaying.value == 1) {
        omniPause();
    } else {
        omniListen(hex2bin(sysDefMelody.value));
    }" src="<?=$prefix.'play.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonOnend" class="power" onclick="audioPosition('-30');" src="<?=$prefix.'ff.png'.$suffix;?>">
    <select id="avatarPicker" style="width:16%;position:relative;" onchange="setdata('avatar', avatarPicker.options[avatarPicker.selectedIndex].id);">
    <?php foreach ($kaiser as $key=>$value) { ?>
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
</p></div>
<div class='topBarItem'><p align='center' class='block'>
    <input type="image" id="userAvatarBadge" onmouseover="soundButton();" class="power" src="<?=$abcPrefix.$session['avatar'].'.png'.$suffix;?>" onclick="setdata('personal', flip(sysDefPersonal.value));">
    <input type='button' id="showUsInfoPower" style="width:28%;position:relative;" value="<?=intval($powersData[$sessionID]);?>">
    <input type="image" onmouseover="soundButton();" id="buttonBroke" class="power" onclick="bind(sysDefSessionID.value);" src="<?=$prefix.'chain.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonReticle" class="power" onclick="dominate(1, 2, 0);" src="<?=$reticlePrefix.$session['reticle'].'.png'.$suffix;?>">
    <input type='button' id="showUsInfoBond" style="width:30%;position:relative;" value="<?='@'.$sessionID;?>">
    <input type="image" id="buttonSpectate" onmouseover="soundButton();" class="power" onclick="setdata('spectate', flip(sysDefSpectate.value));" src="<?=$prefix.'power.png'.$suffix;?>">
</p></div>
<div class='topBarItem'><p align='center' class='block'>
    <select id="setUnits" style="width:20%;position:relative;" onchange="setdata('units', setUnits.options[setUnits.selectedIndex].id);window.location.reload();">
    <?php foreach (explode(',', $session['units_list']) as $selID) { ?>
    <option id="<?=$selID;?>" <?php if ($session['units'] == $selID) { ?> selected <?php } ?>><?=$selID;?></option>
    <?php } ?>
    </select>
    <select id="setTheme" style="width:20%;position:relative;" onchange="setdata('theme', setTheme.options[setTheme.selectedIndex].id);window.location.reload();">
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
    <input type="image" onmouseover="soundButton();" id="buttonUpdate" class="power" onclick="systemUpdate(sysDefBackload.value);window.location.reload();" src="<?=$prefix.'world.png'.$suffix;?>">
    <input type="image" onmouseover="soundButton();" id="buttonUserStatus" class="power" onclick="omniAuthRequest('signout','','');" src="<?php if (isset($_SESSION['user'])) {
        echo $prefix.'user.png'.$suffix;
    } else {
        echo $prefix.'anonym.png'.$suffix;
    } ?>">
    <input type="image" onmouseover="soundButton();" id="buttonEscape" class="power" onclick="omniBack(sysDefParent.value);" src="<?=$prefix.'escape.png'.$suffix;?>">
</p></div></div>
<div class='upperGap'><span id='showUsUrgent' style="cursor:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></span><audio id="audioPlayer" style="width:80%;position:relative;" onended="if (sysDefAutoplay.value != 0) { playAudio(this, this.src); }" ontimeupdate="savePlayState();" onpause="setdata('playing', 0); $('#buttonPlay').attr('src', sysDefPrefix.value+'play.png'+sysDefSuffix.value);" onplay="setdata('playing', 1); $('#buttonPlay').attr('src', sysDefPrefix.value+'pause.png'+sysDefSuffix.value);"></div>
<div class='panel'><?php
if (file_exists('mode.'.$request['mode'].'.php')) {
    include 'mode.'.$request['mode'].'.php';
} else {
    include 'welcome.php';
} ?></div>
<div class='lowerGap'><span id='showUsText' style="cursor:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></span></div>
<audio id="backgroundPlayer" src="<?=$session['background_sound'];?>" onended="playAudio(this, this.src);">
<audio id="tickerPlayer" src="<?=$session['ticking_sound'];?>" onended="playAudio(this, this.src);">
<audio id="alarmPlayer" src="<?=$session['alarm_sound'];?>" onended="$('#buttonAlarm').attr('src', sysDefPrefix.value+'call.png'+sysDefSuffix.value);" onplay="$('#buttonAlarm').attr('src', sysDefPrefix.value+'dial.png'+sysDefSuffix.value);" onpause="$('#buttonAlarm').attr('src', sysDefPrefix.value+'call.png'+sysDefSuffix.value);">
<audio id="soundPlayer"><audio id="typePlayer"><audio id="errorPlayer">
<audio id="notifyPlayer"><audio id="bindPlayer">
<audio id="hitPlayer"><audio id="sufferPlayer">
</body>
</html>