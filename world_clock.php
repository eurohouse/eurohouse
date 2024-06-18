<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), true);
$timezone = dec_tz($userData['timezone']);
date_default_timezone_set($timezone);
if ($userData['memo'] != '') {
    $valueTime = $userData['memo']; if (time() >= $valueTime) {
        $ongoingSignature = 1; $incomingSignature = 0; $alarmInTime = 0;
    } else {
        $ongoingSignature = 0; $incomingSignature = 1; $alarmInTime = $valueTime - time();
    }
} else {
    $ongoingSignature = 0; $incomingSignature = 0; $alarmInTime = 0;
}
$dateTimeCode = $ongoingSignature.$incomingSignature.date('w');
$dateTimeStr = ($userData['timedisp'] != 0) ? date($userData['date_format']) : date($userData['time_format']);
if ($userData['vintage'] != 0) {
    $vintageBackdropFilter = "blur(0.".round($userData['magnitude']/1.5)."px)";
    $overlayBeforeBackground = "repeating-linear-gradient(90deg, #000".$userData['magnitude']." 0 ".round($userData['magnitude']/2.5)."px, transparent ".round($userData['magnitude']/3.5)."px 35vmin)";
    $overlayBeforeAnimation = "vlines 0.45s steps(1) infinite";
    $overlayAfterBackground = "repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00003%, transparent 0.0005%, transparent 0.00095%), repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00005%, transparent 0.00015%, transparent 0.0009%)";
    $overlayAfterAnimation = "grains 0.5s steps(1) infinite";
} else {
    $vintageBackdropFilter = "none"; $overlayBeforeBackground = "none";
    $overlayBeforeAnimation = "none"; $overlayAfterBackground = "none";
    $overlayAfterAnimation = "none";
}
echo $dateTimeStr."\r\n\r\n".
$dateTimeCode." ".$userData['observe'].$userData['spectate']."\r\n\r\n".
hHmMsS($alarmInTime)."\r\n\r\n".
$vintageBackdropFilter.";".$overlayBeforeBackground.";".$overlayBeforeAnimation.";".$overlayAfterBackground.";".$overlayAfterAnimation."\r\n\r\n".
$userData['audio_volume'].' '.$userData['audio_speed'].' '.$userData['audio_balance'].' '.$userData['video_volume'].' '.$userData['video_speed'].' '.$userData['video_balance']."\r\n\r\n";