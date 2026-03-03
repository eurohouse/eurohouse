<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/profile.json',json_encode($userSettings['defaults'])); date_default_timezone_set(base64_decode($userData['timezone']));
$alarmInTime=($userData['memo']!='')?((time()>=$userData['memo'])?-1:($userData['memo']-time())):0;
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
$uni=$userData['units']; $vis=visitor(); echo
/* ¶ 0 */ timedate(time(),$userData,$userSettings)."\r\n\r\n".
/* ¶ 1 */ chooseCalendar(time(),$userData,$userSettings)."\r\n\r\n".
/* ¶ 2 */ hhmmss($alarmInTime)."\r\n\r\n".
/* ¶ 3 */ timedate(time(),$userData,$userSettings,'hhmmss')."\r\n\r\n".
/* ¶ 4 */ json_encode($videoArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 5 */ $userData['pangram_'.(($userSettings['pangram'][$uni])?$userSettings['pangram'][$uni]:$userSettings['pangram']['default'])]."\r\n\r\n".
/* ¶ 6 */ json_encode($vis,JSON_UNESCAPED_UNICODE);
