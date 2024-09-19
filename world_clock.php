<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), 'DEFAULT');
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
} $dateTimeCode = $ongoingSignature.$incomingSignature.date('w');
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
} $voc = $userSettings['vocabulary']; $uni = $userData['units'];
$termSen = (isset($voc[$uni]['Sender'])) ? $voc[$uni]['Sender'] : 'Sender';
$termRec = (isset($voc[$uni]['Recipient'])) ? $voc[$uni]['Recipient'] : 'Recipient';
$termDeb = (isset($voc[$uni]['Debit'])) ? $voc[$uni]['Debit'] : 'Debit';
$termCre = (isset($voc[$uni]['Credit'])) ? $voc[$uni]['Credit'] : 'Credit';
$termBal = (isset($voc[$uni]['Balance'])) ? $voc[$uni]['Balance'] : 'Balance';
$termDat = (isset($voc[$uni]['Date'])) ? $voc[$uni]['Date'] : 'Date';
$termArt = (isset($voc[$uni]['Article'])) ? $voc[$uni]['Article'] : 'Article';
$termNom = (isset($voc[$uni]['Name'])) ? $voc[$uni]['Name'] : 'Name';
$termType = (isset($voc[$uni]['Type'])) ? $voc[$uni]['Type'] : 'Type';
$termQua = (isset($voc[$uni]['Quantity'])) ? $voc[$uni]['Quantity'] : 'Quantity';
$termPri = (isset($voc[$uni]['Price'])) ? $voc[$uni]['Price'] : 'Price';
$termOper = (isset($voc[$uni]['User Operation:'])) ? $voc[$uni]['User Operation:'] : 'User Opeation:';
$termScore = (isset($voc[$uni]['User Score Tab:'])) ? $voc[$uni]['User Score Tab:'] : 'User Score Tab:';
for ($i = 0; $i < 7; $i++) {
    $wd[$i] = ((isset($userSettings['locale']['weekday'][$uni][$i])) ? $userSettings['locale']['weekday'][$uni][$i] : $userSettings['locale']['weekday']['default'][$i]);
} echo $dateTimeStr."\r\n\r\n".
$dateTimeCode." ".$userData['observe'].$userData['spectate']."\r\n\r\n".
hHmMsS($alarmInTime)."\r\n\r\n".
$vintageBackdropFilter.";".$overlayBeforeBackground.";".$overlayBeforeAnimation.";".$overlayAfterBackground.";".$overlayAfterAnimation."\r\n\r\n".
$userData['audio_volume'].' '.$userData['audio_speed'].' '.$userData['video_volume'].' '.$userData['video_speed'].' '.$userData['alarm_volume'].' '.$userData['timer_volume'].' '.$userData['loop_volume'].' '.$userData['rest_volume']."\r\n\r\n".
$termDat.' | '.$termSen.' | '.$termRec.' | '.$termDeb.' | '.$termCre.' | '.$termBal.' | '.$termOper.' | '.$termScore.' | '.$termArt.' | '.$termNom.' | '.$termType.' | '.$termQua.' | '.$termPri."\r\n\r\n".
implode(' ', $wd)."\r\n\r\n".
$userData['pangram_'.(($userSettings['pangram'][$uni]) ? $userSettings['pangram'][$uni] : $userSettings['pangram']['default'])];