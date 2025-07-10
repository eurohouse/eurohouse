<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/session.json',json_encode($userSettings['defaults']),'mirror'); $alarmInTime=($userData['memo']!='')?((time()>=$userData['memo'])?-1:($userData['memo']-time())):0;
$dateStr=chooseCalendar(time(),$userData,$userSettings);
$timeStr=timedate(time(),$userData,$userSettings);
if ($userData['vintage']!=0) {
    $videoArr=[
        "blur(0.".round($userData['magnitude']/1.5)."px)",
        "0.".round($userData['magnitude']/1.5),
        "repeating-linear-gradient(90deg, #000".$userData['magnitude']." 0 ".round($userData['magnitude']/2.5)."px, transparent ".round($userData['magnitude']/3.5)."px 35vmin)",
        "vlines 0.45s steps(1) infinite",
        "repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00003%, transparent 0.0005%, transparent 0.00095%), repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00005%, transparent 0.00015%, transparent 0.0009%)",
        "grains 0.5s steps(1) infinite"
    ];
} else { $videoArr=["none","none","none","none","none","none"]; }
$voc=$userSettings['vocabulary'];$uni=$userData['units'];
$audioArr=[ $userData['audio_volume'],$userData['audio_speed'],$userData['video_volume'],$userData['video_speed'] ];
$finTerms=terms($userSettings,$userData);
/* ¶ 0 */ echo $timeStr."\r\n\r\n".
/* ¶ 1 */ $dateStr."\r\n\r\n".
/* ¶ 2 */ hhmmss($alarmInTime)."\r\n\r\n".
/* ¶ 3 */ alphaChannel($userData['back_color'],$userData['opacity'])."\r\n\r\n".
/* ¶ 4 */ json_encode($videoArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 5 */ json_encode($audioArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 6 */ json_encode($finTerms,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 7 */ $userData['pangram_'.(($userSettings['pangram'][$uni])?$userSettings['pangram'][$uni]:$userSettings['pangram']['default'])]."\r\n\r\n".
/* ¶ 8 */ json_encode($userSettings['locks_icons'],JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 9 */ implode(',',$userSettings['dataload']);
