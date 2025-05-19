<?php include 'functions.php';
$cookie=(isset($_COOKIE['user']))?$_COOKIE['user']:'root';
$userSettings=fileopen('settings.json');
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
if ($userData['memo']!='') {
    if (time()>=$userData['memo']) {
        $ongo=1; $inco=0; $alarmInTime=0;
    } else {
        $ongo=0; $inco=1; $alarmInTime=$userData['memo']-time();
    }
} else { $ongo=0; $inco=0; $alarmInTime=0; }
if ($userData['calendar']=='Julian') {
    $dateStr=timedate($userData['date_format'],$userSettings,$userData['units'],$userData['timezone'],(intval(date('Y')/100)-7),$userData['roman']);
} elseif ($userData['calendar']=='French') {
    $dateStr=french($userSettings,$userData['units']);
} else {
    $dateStr=timedate($userData['date_format'],$userSettings,$userData['units'],$userData['timezone'],$userData['roman']);
} $timeStr=timedate($userData['time_format'],$userSettings,$userData['units'],$userData['timezone'],$userData['roman']);
if ($userData['vintage']!=0) {
    $videoArr=[
        "blur(0.".round($userData['magnitude']/1.5)."px)","0.".round($userData['magnitude']/1.5),"repeating-linear-gradient(90deg, #000".$userData['magnitude']." 0 ".round($userData['magnitude']/2.5)."px, transparent ".round($userData['magnitude']/3.5)."px 35vmin)",
        "vlines 0.45s steps(1) infinite","repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00003%, transparent 0.0005%, transparent 0.00095%), repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00005%, transparent 0.00015%, transparent 0.0009%)",
        "grains 0.5s steps(1) infinite"
    ];
} else { $videoArr=["none","none","none","none","none","none"]; }
$voc=$userSettings['vocabulary'];$uni=$userData['units'];
$audioArr=[ $userData['audio_volume'],$userData['audio_speed'],$userData['video_volume'],$userData['video_speed'] ];
$finTerms=[
    term('Debit',$voc,$uni),
    term('Credit',$voc,$uni),
    term('Balance',$voc,$uni),
    term('Name',$voc,$uni),
    term('Amount',$voc,$uni),
    term('Price',$voc,$uni),
    term('The market is closed.',$voc,$uni),
    term('Active Hours:',$voc,$uni),
    term('Agent',$voc,$uni),
    term('Press any key to continue...',$voc,$uni),
    term('',$userSettings['locale']['cli'],$uni,$userData['mode'])
];
/* ¶ 0 */ echo $timeStr."\r\n\r\n".
/* ¶ 1 */ $dateStr."\r\n\r\n".
/* ¶ 2 */ hhmmss($alarmInTime,true)."\r\n\r\n".
/* ¶ 3 */ $ongo.$inco.$userData['observe'].$userData['spectate'].$userData['censor'].date('ILw')."\r\n\r\n".
/* ¶ 4 */ alphaChannel($userData['back_color'],$userData['opacity'])."\r\n\r\n".
/* ¶ 5 */ json_encode($videoArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 6 */ json_encode($audioArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 7 */ json_encode($finTerms,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 8 */ $userData['pangram_'.(($userSettings['pangram'][$uni])?$userSettings['pangram'][$uni]:$userSettings['pangram']['default'])]."\r\n\r\n".
/* ¶ 9 */ json_encode($userSettings['locks_icons'],JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 10 */ implode(',',$userSettings['dataload']);
