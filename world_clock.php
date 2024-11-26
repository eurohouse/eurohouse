<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), 'DEFAULT');
$timezone = dec_tz($userData['timezone']); date_default_timezone_set($timezone);
if ($userData['memo'] != '') {
    $valueTime = $userData['memo']; if (time() >= $valueTime) {
        $ongoingSignature = 1; $incomingSignature = 0; $alarmInTime = 0;
    } else {
        $ongoingSignature = 0; $incomingSignature = 1; $alarmInTime = $valueTime - time();
    }
} else {
    $ongoingSignature = 0; $incomingSignature = 0; $alarmInTime = 0;
} $dateTimeCode = $ongoingSignature.$incomingSignature.date('w');
$dateTimeStr = ($userData['timedisp'] != 0) ? date($userData['date_format']) : date($userData['time_format']); if ($userData['vintage'] != 0) {
    $vintageBackdropFilter = "blur(0.".round($userData['magnitude']/1.5)."px)";
    $overlayBeforeBackground = "repeating-linear-gradient(90deg, #000".$userData['magnitude']." 0 ".round($userData['magnitude']/2.5)."px, transparent ".round($userData['magnitude']/3.5)."px 35vmin)";
    $overlayBeforeAnimation = "vlines 0.45s steps(1) infinite";
    $overlayAfterBackground = "repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00003%, transparent 0.0005%, transparent 0.00095%), repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00005%, transparent 0.00015%, transparent 0.0009%)";
    $overlayAfterAnimation = "grains 0.5s steps(1) infinite";
} else {
    $vintageBackdropFilter = "none"; $overlayBeforeBackground = "none";
    $overlayBeforeAnimation = "none"; $overlayAfterBackground = "none";
    $overlayAfterAnimation = "none";
} $voc = $userSettings['vocabulary']; $uni = $userData['units'];
$termDeb = (isset($voc[$uni]['Debit'])) ? $voc[$uni]['Debit'] : 'Debit';
$termCre = (isset($voc[$uni]['Credit'])) ? $voc[$uni]['Credit'] : 'Credit';
$termBal = (isset($voc[$uni]['Balance'])) ? $voc[$uni]['Balance'] : 'Balance';
$termNom = (isset($voc[$uni]['Name'])) ? $voc[$uni]['Name'] : 'Name';
$termQua = (isset($voc[$uni]['Amount'])) ? $voc[$uni]['Amount'] : 'Amount';
$termPri = (isset($voc[$uni]['Price'])) ? $voc[$uni]['Price'] : 'Price';
$termOper = (isset($voc[$uni]['User Operation:'])) ? $voc[$uni]['User Operation:'] : 'User Opeation:';
$termScore = (isset($voc[$uni]['User Score Tab:'])) ? $voc[$uni]['User Score Tab:'] : 'User Score Tab:';
$termClosed = (isset($voc[$uni]["The market is closed."])) ? $voc[$uni]["The market is closed."] : "The market is closed.";
$termActive = (isset($voc[$uni]['Active Hours:'])) ? $voc[$uni]['Active Hours:'] : 'Active Hours:';
echo $dateTimeStr."\r\n\r\n". // Read Line 0
$dateTimeCode." ".$userData['observe'].$userData['spectate']." ".rgbap($userData['back_color'], $userData['opacity'])."\r\n\r\n". // Read Line 1
hHmMsS($alarmInTime)."\r\n\r\n". // Read Line 2
$vintageBackdropFilter.";".$overlayBeforeBackground.";".$overlayBeforeAnimation.";".$overlayAfterBackground.";".$overlayAfterAnimation."\r\n\r\n". // Read Line 3
$userData['audio_volume'].' '.$userData['audio_speed'].' '.$userData['video_volume'].' '.$userData['video_speed'].' '.$userData['alarm_volume'].' '.$userData['timer_volume'].' '.$userData['loop_volume'].' '.$userData['rest_volume']."\r\n\r\n". // Read Line 4
$termDeb.' | '.$termCre.' | '.$termBal.' | '.$termNom.' | '.$termQua.' | '.$termPri.' | '.$termOper.' | '.$termScore.' | '.$termClosed.' | '.$termActive."\r\n\r\n". // Read Line 5
$userData['pangram_'.(($userSettings['pangram'][$uni]) ? $userSettings['pangram'][$uni] : $userSettings['pangram']['default'])]; // Read Line 6