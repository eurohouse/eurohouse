<?php include 'backend.php'; ?>
<html><head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta charset="UTF-8">
<title><?=$session['title'].' (@'.$sessionID.') · Eurohouse UX/UI';?></title>
<link rel="shortcut icon" href="favicon.png?rev=<?=time();?>" type="image/x-icon">
<?php include 'wardrobe.php'; foreach ($settings['libraries']['domestic'] as $val) { ?>
    <script src="<?=$val;?>?rev=<?=time();?>"></script>
<?php } foreach ($settings['libraries']['foreign'] as $val) { ?>
    <script src="<?=$val;?>"></script>
<?php } include 'frontend.php'; include 'startup.php'; ?>
</head>
<body>
<div class='overlay'><?php foreach ($request as $key=>$value) { ?>
    <input type='hidden' id="<?='request'.ucfirst($key);?>" value="<?=$value;?>">
<?php } foreach ($postRequest as $key=>$value) { ?>
    <input type='hidden' id="<?='postRequest'.camel($key);?>" value="<?=$value;?>">
<?php } foreach ($session as $key=>$value) { ?>
    <input type='hidden' id="<?='sysDef'.camel($key);?>" value="<?=$value;?>">
<?php } foreach ($metadata as $key=>$value) { ?>
    <input type='hidden' id="<?='meta'.camel($key);?>" value="<?=$value;?>">
<?php } foreach ($locks as $key=>$value) { ?>
    <input type='hidden' id="<?='lock'.camel($key);?>" value="<?=$value;?>">
<?php } foreach ($updateChannel as $key=>$value) { ?>
    <input type='hidden' id='<?='updateChannel'.camel($key);?>' value="<?=$value;?>">
<?php } ?>
<input type='hidden' id='sysDefBackload' value="<?=$backloadString;?>">
<input type='hidden' id='sysDefPrefix' value="<?=$prefix;?>">
<input type='hidden' id='sysDefReticlePrefix' value="<?=$reticlePrefix;?>">
<input type='hidden' id='sysDefSuffix' value="<?=$suffix;?>">
<input type='hidden' id="sysDefIsSession" value="<?=isAuth();?>">
<input type='hidden' id="sysDefSessionID" value="<?=$sessionID;?>">
<input type='hidden' id="sysDefPostBackEff" value="0">
<input type='hidden' id="sysDefPostTickEff" value="0">
<input type='hidden' id="sysDefVarsArr" value="">
<input type='hidden' id="sysDefUsersList" value="">
<input type='hidden' id="sysDefBooksList" value="">
<input type='hidden' id="sysDefStoreList" value="">
<input type='hidden' id="sysDefMailingJSONs" value="">
<input type='hidden' id="sysDefBookKeepJSONs" value="">
<input type='hidden' id="sysDefStoreJSONs" value="">
<input type='hidden' id="sysDefBindData" value="<?=valstr($bindData,';',':');?>">
<input type='hidden' id="sysDefPowersData" value="<?=valstr($powersData,';',':');?>">
<input type='hidden' id="sysDefAutoData" value="<?=valstr($automateData,';',':');?>">
<input type='hidden' id="sysDefAutoState" value="<?=$automateData[$sessionID];?>">
<input type='hidden' id="sysDefFriendData" value="<?=valstr($friendData,';',':');?>">
<input type='hidden' id="sysDefBookKeep" value="">
<input type='hidden' id="sysDefMsgData" value="">
<input type='hidden' id="sysDefUserStore" value="">
<input type='hidden' id="sysDefMsgCounter" value="0">
<input type='hidden' id="sysDefMusicBox" value="<?=implode('//', $musicBox);?>">
<input type='hidden' id="sysDefSoundBox" value="<?=implode('//', $orpheus);?>">
<input type='hidden' id="sysDefCodexBox" value="<?=implode('//', $codexBox);?>">
<input type='hidden' id="sysDefSpeechBox" value="<?=implode('//', $speechBox);?>">
<input type='hidden' id="sysDefPostBindData" value="<?=valstr($bindData,';',':');?>">
<input type='hidden' id="sysDefPostPowersData" value="<?=valstr($powersData,';',':');?>">
<input type='hidden' id="sysDefPostMsgData" value="">
<input type='hidden' id="sysDefPostBookKeep" value="">
<input type='hidden' id='sysDefAvatarIcons' value="<?=implode(';', $kaiser);?>">
<form id="upload" method="POST" style="display:none;">
<input type="file" name="file" id="filebrowser" onchange='uploadFile();'>
</form>
<p align='center' class='block'>
<input hidden type="image" onmouseover="soundButton();" class="power" id="powerButton" onclick="setdata('observe', flip(sysDefObserve.value));" src="<?=$prefix.'power.png'.$suffix;?>">
</p>
<div class='topbar'>
<?php if (file_exists('mode.'.$request['mode'].'.php')) {
    $curModeFile = paging('mode.'.$request['mode'].'.php', [2,3]); if (strpos($curModeFile[2], '-->') !== false) {
        $curMode1 = str_replace(' -->', '', str_replace('<!-- ', '', $curModeFile[2])); $parent = ($curMode1 == '<ref>') ? $request['ref'] : $curMode1;
    } else {
        $parent = 'main_menu';
    } $isRef = (strpos($curModeFile[3], '-->') !== false) ? str_replace(' -->', '', str_replace('<!-- ', '', $curModeFile[3])) : 'false';
} else {
    $parent = 'main_menu'; $isRef = 'false';
} ?>
<input type='hidden' id='sysDefParent' value="<?=$parent;?>">
<input type='hidden' id='sysDefIsRef' value="<?=$isRef;?>">
<?php include 'dashboard.php'; ?>
</div>
<div class='upperGap'>
<span id='showUsUrgent' style="cursor:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></span>
<audio id="audioPlayer" style="width:80%;position:relative;" preservesPitch="<?=boolval($session['pitch_lock']);?>" volume="<?=$session['audio_volume'];?>" playbackRate="<?=$session['audio_speed'];?>" onended="if (sysDefAutoplay.value != 0) {
    if (sysDefShuffle.value != 0) {
        songIndex();
    } else {
        omniListen(this.src, true);
    }
}" ontimeupdate="savePlayState();" onpause="setdata('playing', 0); $('#buttonPlay').attr('src', sysDefPrefix.value+'play.png'+sysDefSuffix.value);" onplay="setdata('playing', 1); $('#buttonPlay').attr('src', sysDefPrefix.value+'pause.png'+sysDefSuffix.value);" onvolumechange="setdata('audio_volume', this.volume);" onratechange="setdata('audio_speed', this.playbackRate);">
</div>
<div class='panel'><?php
if (file_exists('mode.'.$request['mode'].'.php')) {
    include 'mode.'.$request['mode'].'.php';
} else {
    include 'welcome.php';
} ?></div>
<div class='lowerGap'><span id='showUsText' style="cursor:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></span></div>
<audio id="backgroundPlayer" src="<?=$session['background_sound'];?>" volume="<?=$session['loop_volume'];?>" onended="playAudio(this, this.src);">
<audio id="tickerPlayer" src="<?=$session['ticking_sound'];?>" volume="<?=$session['timer_volume'];?>" onended="playAudio(this, this.src);">
<audio id="alarmPlayer" src="<?=$session['alarm_sound'];?>" volume="<?=$session['alarm_volume'];?>" onended="$('#buttonAlarm').attr('src', sysDefPrefix.value+'call.png'+sysDefSuffix.value);" onplay="$('#buttonAlarm').attr('src', sysDefPrefix.value+'dial.png'+sysDefSuffix.value);" onpause="$('#buttonAlarm').attr('src', sysDefPrefix.value+'call.png'+sysDefSuffix.value);">
<audio id="soundPlayer" volume="<?=$session['rest_volume'];?>"><audio id="typePlayer" volume="<?=$session['rest_volume'];?>">
<audio id="errorPlayer" volume="<?=$session['rest_volume'];?>"><audio id="notifyPlayer" volume="<?=$session['rest_volume'];?>">
<audio id="bindPlayer" volume="<?=$session['rest_volume'];?>"><audio id="hitPlayer" volume="<?=$session['rest_volume'];?>">
<audio id="sufferPlayer" volume="<?=$session['rest_volume'];?>">
</body>
</html>