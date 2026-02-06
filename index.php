<?php include 'backend.php'; ?>
<html>
<head>
    <meta name="viewport" content="<?=$viewportParam;?>">
    <meta charset="UTF-8">
    <title><?=$session['title'].' (@'.$sessionID.') · Eurohouse UX/UI';?></title>
    <link rel="shortcut icon" href="<?=$prefix[3].'.'.$session['avatar'].'.png';?>" type="image/x-icon">
    <?php include 'wardrobe.php';
    foreach ($settings['libraries']['domestic'] as $key=>$val) { ?>
        <script src="<?=$key;?>" <?=$val;?>></script>
    <?php }
    foreach ($settings['libraries']['foreign'] as $key=>$val) { ?>
        <script src="<?=$key;?>" <?=$val;?>></script>
    <?php }
    include 'frontend.php'; include 'startup.php'; ?>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-QPPGNT8232"></script>
<script>
    window.dataLayer=(window.dataLayer||[]);
    function gtag() { dataLayer.push(arguments); }
    gtag('js',new Date()); gtag('config','G-QPPGNT8232');
</script>
<body>
    <div class='overlay'>
        <?php foreach ($request as $key=>$value) { ?>
            <input type='hidden' id="<?='request'.ucfirst($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($postRequest as $key=>$value) { ?>
            <input type='hidden' id="<?='postRequest'.snakeToCamel($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($session as $key=>$value) { ?>
            <input type='hidden' id="<?='sysDef'.snakeToCamel($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($subscr as $key=>$value) { ?>
            <input type='hidden' id="<?='sysDefSubscription'.snakeToCamel($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($updateChannel as $key=>$value) { ?>
            <input type='hidden' id='<?='updateChannel'.md5($key);?>' value="<?=$value;?>">
        <?php }
        foreach ($downloadChannel as $key=>$value) { ?>
            <input type='hidden' id='<?='downloadChannel'.md5($key);?>' value="<?=$value;?>">
        <?php } ?>
        <input type='hidden' id='sysDefPangram' value="">
        <input type='hidden' id='sysDefEffects' value="">
        <input type='hidden' id='sysDefBackload' value="<?=$backloadString;?>">
        <input type='hidden' id='sysDefPrefData' value="<?=valstr($prefix,';',':');?>">
        <input type='hidden' id='sysDefPrefix' value="<?=$prefix[3];?>">
        <input type='hidden' id='sysDefAva0Prefix' value="<?=$prefix[0];?>">
        <input type='hidden' id='sysDefAva1Prefix' value="<?=$prefix[1];?>">
        <input type='hidden' id='sysDefPic0Prefix' value="<?=$prefix[2];?>">
        <input type='hidden' id='sysDefPic1Prefix' value="<?=$prefix[3];?>">
        <input type='hidden' id='sysDefNullUserName' value="<?=$nulluser;?>">
        <input type='hidden' id='sysDefSuperUserName' value="<?=$superuser;?>">
        <input type='hidden' id="sysDefModelData" value="">
        <input type='hidden' id="sysDefContentData" value="">
        <input type='hidden' id="sysDefIpData" value="<?=json_encode($vis,JSON_UNESCAPED_UNICODE);?>">
        <input type='hidden' id="sysDefSubscriptions" value="<?=json_encode($userSubscr,JSON_UNESCAPED_UNICODE);?>">
        <input type='hidden' id="sysDefIsSession" value="<?=isAuthorized();?>">
        <input type='hidden' id="sysDefSessionID" value="<?=$sessionID;?>">
        <input type='hidden' id="sysDefPostBackEff" value="0">
        <input type='hidden' id="sysDefPostTickEff" value="0">
        <input type='hidden' id="sysDefUsersList" value="<?=implode(',',$usersList)?>">
        <input type='hidden' id="sysDefMetaData" value="<?=json_encode($metadata,JSON_UNESCAPED_UNICODE);?>"><input type='hidden' id="sysDefMetaList" value="<?=implode(' | ',array_keys($metadata));?>">
        <input type='hidden' id="sysDefMsgCounter" value="0">
        <input type='hidden' id="sysDefMsgMaxCount" value="0">
        <input type='hidden' id="sysDefMsgCurrent" value="">
        <input type='hidden' id="sysDefCodexBox" value="<?=implode(';',(str_replace('./','',(glob('./*.mac')))));?>">
        <input type='hidden' id="sysDefSpeechBox" value="<?=implode(';',(str_replace('./','',(glob('./*.pro')))));?>">
        <input type='hidden' id="sysDefMessengerJSONs" value="">
        <input type='hidden' id="sysDefMyMessengerData" value="">
        <input type='hidden' id="sysDefPostMyMessengerData" value="">
        <input type='hidden' id='sysDefAvatarIcons' value="<?=implode(';',(str_replace('./','',(glob('./'.$prefix[0].'*.png')))));?>">
        <form id="upload" method="POST" style="display:none;">
            <input type="file" name="file" id="filebrowser" onchange='uploadFile();'>
        </form>
        <p align='center' class='block'>
            <input type="image" onmouseover="soundButton();" class="power" style="display:none;" id="powerButton" onclick="soundClick(); setdata('observe', flip(sysDefObserve.value));" src="<?=$prefix[3].'power.png';?>">
        </p>
        <div class='topbar'><?php
        if (file_exists('mode.'.$request['mode'].'.php')) {
            $isModeNull=0;
            $curModeFile=paging('mode.'.$request['mode'].'.php',[2,3]);
            if (strpos($curModeFile[2],'-->')!==false) {
                $curMode1=str_replace(' -->','',str_replace('<!-- ','',$curModeFile[2]));
                $parent=($curMode1=='<ref>')?$request['ref']:$curMode1;
            } else { $parent='main_menu'; }
            $isRef=(strpos($curModeFile[3],'-->')!==false)?str_replace(' -->','',str_replace('<!-- ','',$curModeFile[3])):'false';
        } else { $isModeNull=1; $parent='main_menu';$isRef='false'; } ?>
        <input type='hidden' id='sysDefParent' value="<?=$parent;?>">
        <input type='hidden' id='sysDefIsRef' value="<?=$isRef;?>">
        <input type='hidden' id='sysDefIsModeNull' value="<?=$isModeNull;?>">
        <?php include 'dashboard.php'; ?>
        </div>
        <div class='upperGap'>
            <span id='showUsUrgent' class="urgent" onclick="clip(this.innerText);"></span>
            <audio id="audioPlayer" style="width:80%;position:relative;" preservesPitch="<?=boolval($session['preserves_pitch']);?>" volume="<?=$session['audio_volume'];?>" playbackRate="<?=$session['audio_speed'];?>" onended="if (sysDefAutoplay.value!=0) { omniPlaylist(sysDefShuffle.value); }" ontimeupdate="savePlayState();" onpause="setdata('playing',0); $('#buttonPlay').attr('src',sysDefPrefix.value+'play.png');" onplay="setdata('playing',1); $('#buttonPlay').attr('src',sysDefPrefix.value+'pause.png');" onvolumechange="setdata('audio_volume',this.volume);" onratechange="setdata('audio_speed',this.playbackRate);" onloadedmetadata="setdata('duration',this.duration);">
        </div>
        <div class='panel'>
            <?php include (file_exists('mode.'.$request['mode'].'.php'))?'mode.'.$request['mode'].'.php':'welcome_screen.php'; ?>
        </div>
        <div class='lowerGap'>
            <span class="marquee" id='showUsText' onclick="clip(this.innerText);"></span>
        </div>
        <audio id="backgroundPlayer" src="<?=$session['background_sound'];?>" onended="playAudio(this,this.src);">
        <audio id="tickerPlayer" src="<?=$session['ticking_sound'];?>" onended="playAudio(this,this.src);">
        <audio id="alarmPlayer" src="<?=$session['alarm_sound'];?>" onended="$('#buttonAlarm').attr('src',sysDefPrefix.value+'call.png');" onplay="$('#buttonAlarm').attr('src',sysDefPrefix.value+'dial.png');" onpause="$('#buttonAlarm').attr('src',sysDefPrefix.value+'call.png');">
        <audio id="soundPlayer"><audio id="typePlayer">
        <audio id="errorPlayer"><audio id="notifyPlayer">
    </div>
</body>
</html>