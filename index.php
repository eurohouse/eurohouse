<?php include 'backend.php'; ?>
<html>
    <head>
        <meta name="viewport" content="<?=$viewportParam;?>">
        <meta charset="UTF-8">
        <title><?=$session['title'].' (@'.$sessionID.') · Eurohouse UX/UI';?></title>
        <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
        <?php include 'wardrobe.php';
        foreach ($settings['libraries']['domestic'] as $val) {
        ?><script src="<?=$val;?>"></script><?php }
        foreach ($settings['libraries']['foreign'] as $val) {
        ?><script src="<?=$val;?>"></script><?php }
        include 'frontend.php'; include 'startup.php';
        ?>
    </head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QPPGNT8232"></script>
    <script>
        window.dataLayer=window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js',new Date()); gtag('config','G-QPPGNT8232');
    </script>
    <body>
    <div class='overlay'>
        <input type='hidden' id='sysDefDotDirs' value="<?=implode(',',$dotDirsList);?>">
        <?php foreach ($request as $key=>$value) { ?>
            <input type='hidden' id="<?='request'.ucfirst($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($postRequest as $key=>$value) { ?>
            <input type='hidden' id="<?='postRequest'.snakeToCamel($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($session as $key=>$value) { ?>
            <input type='hidden' id="<?='sysDef'.snakeToCamel($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($locks as $key=>$value) { ?>
            <input type='hidden' id="<?='lock'.snakeToCamel($key);?>" value="<?=$value;?>">
        <?php }
        foreach ($updateChannel as $key=>$value) { ?>
            <input type='hidden' id='<?='updateChannel'.md5($key);?>' value="<?=$value;?>">
        <?php }
        foreach ($gamesChannel as $key=>$value) { ?>
            <input type='hidden' id='<?='gamesChannel'.md5($key);?>' value="<?=$value;?>">
        <?php }
        foreach ($dotDirsList as $key=>$value) { ?>
            <input type='hidden' id='<?='sysDefMy'.ucfirst($value).'Data';?>' value="">
            <input type='hidden' id='<?='sysDef'.ucfirst($value).'JSONs';?>' value="">
        <?php } ?>
        <input type='hidden' id='sysDefBackload' value="<?=$backloadString;?>">
        <input type='hidden' id='sysDefPrefix' value="<?=$prefix;?>">
        <input type='hidden' id='sysDefAvaPrefix' value="<?=$avaPrefix;?>">
        <input type='hidden' id='sysDefReticlePrefix' value="<?=$reticlePrefix;?>">
        <input type='hidden' id="sysDefIpData" value="<?=valstr($activeIPs,'; ',' ');?>">
        <input type='hidden' id="sysDefHdiData" value="">
        <input type='hidden' id="sysDefModelData" value="">
        <input type='hidden' id="sysDefContentData" value="">
        <input type='hidden' id="sysDefAvatarsNow" value="">
        <input type='hidden' id="sysDefHoursNow" value="">
        <input type='hidden' id="sysDefHoursActive" value="">
        <input type='hidden' id="sysDefLockData" value="">
        <input type='hidden' id="sysDefLockIcons" value="">
        <input type='hidden' id="sysDefIsSession" value="<?=isAuthorized();?>">
        <input type='hidden' id="sysDefSessionID" value="<?=$sessionID;?>">
        <input type='hidden' id="sysDefPostBackEff" value="0">
        <input type='hidden' id="sysDefPostTickEff" value="0">
        <input type='hidden' id="sysDefVarsArr" value="">
        <input type='hidden' id="sysDefUsersList" value="">
        <input type='hidden' id="sysDefBindData" value="<?=valstr($bindData,';',':');?>">
        <input type='hidden' id="sysDefPowersData" value="<?=valstr($powersData,';',':');?>">
        <input type='hidden' id="sysDefAutoData" value="<?=valstr($automateData,';',':');?>">
        <input type='hidden' id="sysDefAutoState" value="<?=$automateData[$sessionID];?>">
        <input type='hidden' id="sysDefFriendData" value="<?=valstr($friendData,';',':');?>">
        <input type='hidden' id="sysDefToolData" value="<?=valstr($toolboxData,';',':');?>">
        <input type='hidden' id="sysDefCallData" value="<?=valstr($callData,';',':');?>">
        <input type='hidden' id="sysDefMetaData" value="<?=json_encode($metadata,JSON_UNESCAPED_UNICODE);?>"><input type='hidden' id="sysDefMetaList" value="<?=implode(' | ',array_keys($metadata));?>">
        <input type='hidden' id="sysDefTutorData" value="<?=json_encode($tutorial,JSON_UNESCAPED_UNICODE);?>">
        <input type='hidden' id="sysDefTutorList" value="<?=implode(' | ',array_keys($tutorial));?>">
        <input type='hidden' id="sysDefNewsData" value="<?=json_encode($newsData,JSON_UNESCAPED_UNICODE);?>">
        <input type='hidden' id="sysDefMsgCounter" value="0">
        <input type='hidden' id="sysDefMsgMaxCount" value="0">
        <input type='hidden' id="sysDefCodexBox" value="<?=implode('//',(str_replace('./','',(glob('./*.mac')))));?>">
        <input type='hidden' id="sysDefSpeechBox" value="<?=implode('//',(str_replace('./','',(glob('./*.pro')))));?>">
        <input type='hidden' id="sysDefPostBindData" value="<?=valstr($bindData,';',':');?>">
        <input type='hidden' id="sysDefPostPowersData" value="<?=valstr($powersData,';',':');?>">
        <input type='hidden' id="sysDefPostToolData" value="<?=valstr($toolboxData,';',':');?>">
        <input type='hidden' id="sysDefPostMyMsgboxData" value="">
        <input type='hidden' id="sysDefPostMyBookData" value="">
        <input type='hidden' id='sysDefAvatarIcons' value="<?=implode(';',(str_replace('./','',(glob('./'.$avaPrefix.'*.png')))));?>">
        <form id="upload" method="POST" style="display:none;">
            <input type="file" name="file" id="filebrowser" onchange='uploadFile();'>
        </form>
        <p align='center' class='block'>
            <input type="image" onmouseover="soundButton();" class="power" style="display:none;" id="powerButton" onclick="setdata('observe', flip(sysDefObserve.value));" src="<?=$prefix.'power.png';?>">
        </p>
        <div class='topbar'>
        <?php
        if (file_exists('mode.'.$request['mode'].'.php')) {
            $curModeFile = paging('mode.'.$request['mode'].'.php', [2,3]);
            if (strpos($curModeFile[2], '-->') !== false) {
                $curMode1 = str_replace(' -->', '', str_replace('<!-- ', '', $curModeFile[2]));
                $parent = ($curMode1 == '<ref>') ? $request['ref'] : $curMode1;
            } else {
                $parent = 'main_menu';
            }
            $isRef = (strpos($curModeFile[3], '-->') !== false) ? str_replace(' -->', '', str_replace('<!-- ', '', $curModeFile[3])) : 'false';
        } else {
            $parent = 'main_menu'; $isRef = 'false';
        }
        ?>
        <input type='hidden' id='sysDefParent' value="<?=$parent;?>">
        <input type='hidden' id='sysDefIsRef' value="<?=$isRef;?>">
        <?php include 'dashboard.php'; ?>
        </div>
        <div class='upperGap'>
            <span id='showUsUrgent' class="urgent" onclick="navigator.clipboard.writeText(this.innerText);"></span>
            <audio id="audioPlayer" style="width:80%;position:relative;" preservesPitch="<?=boolval($session['pitch_lock']);?>" volume="<?=$session['audio_volume'];?>" playbackRate="<?=$session['audio_speed'];?>" onended="if (sysDefAutoplay.value!=0) { songIndex(sysDefSongIndex.value); }" ontimeupdate="savePlayState();" onpause="setdata('playing',0); $('#buttonPlay').attr('src',sysDefPrefix.value+'play.png');" onplay="setdata('playing',1); $('#buttonPlay').attr('src',sysDefPrefix.value+'pause.png');" onvolumechange="setdata('audio_volume',this.volume);" onratechange="setdata('audio_speed',this.playbackRate);">
        </div>
        <div class='panel'>
            <?php if (file_exists('mode.'.$request['mode'].'.php')) {
                include 'mode.'.$request['mode'].'.php';
            } else { include 'welcome.php'; } ?>
        </div>
        <div class='lowerGap'>
            <span class="marquee" id='showUsText' onclick="navigator.clipboard.writeText(this.innerText);"></span>
        </div>
        <audio id="backgroundPlayer" src="<?=$session['background_sound'];?>" onended="playAudio(this,this.src);">
        <audio id="tickerPlayer" src="<?=$session['ticking_sound'];?>" onended="playAudio(this,this.src);">
        <audio id="alarmPlayer" src="<?=$session['alarm_sound'];?>" onended="$('#buttonAlarm').attr('src',sysDefPrefix.value+'call.png');" onplay="$('#buttonAlarm').attr('src',sysDefPrefix.value+'dial.png');" onpause="$('#buttonAlarm').attr('src',sysDefPrefix.value+'call.png');">
        <audio id="soundPlayer">
        <audio id="typePlayer">
        <audio id="errorPlayer">
        <audio id="notifyPlayer">
        <audio id="bindPlayer">
        <audio id="hitPlayer">
        <audio id="sufferPlayer">
    </div>
    </body>
</html>