<?php
include 'functions.php';
$cookie=(isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings=fileopen('settings.json');
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
$timezone=dec_tz($userData['timezone']); date_default_timezone_set($timezone);
if ($userData['memo']!='') {
    $valueTime=$userData['memo']; if (time()>=$valueTime) {
        $ongoingSignature=1; $incomingSignature=0; $alarmInTime=0;
    } else {
        $ongoingSignature=0; $incomingSignature=1; $alarmInTime=$valueTime-time();
    }
} else {
    $ongoingSignature=0; $incomingSignature=0; $alarmInTime=0;
} $dateTimeCode=$ongoingSignature.$incomingSignature.date('w');
$dateTimeStr=($userData['timedisp']!=0)?date($userData['date_format']):date($userData['time_format']);
if ($userData['vintage']!=0) {
    $vintageBackdropFilter="blur(0.".round($userData['magnitude']/1.5)."px)";
    $vintageBackdropOpacity="0.".round($userData['magnitude']/1.5);
    $overlayBeforeBackground="repeating-linear-gradient(90deg, #000".$userData['magnitude']." 0 ".round($userData['magnitude']/2.5)."px, transparent ".round($userData['magnitude']/3.5)."px 35vmin)";$overlayBeforeAnimation="vlines 0.45s steps(1) infinite";
    $overlayAfterBackground="repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00003%, transparent 0.0005%, transparent 0.00095%), repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00005%, transparent 0.00015%, transparent 0.0009%)";
    $overlayAfterAnimation="grains 0.5s steps(1) infinite";
} else {
    $vintageBackdropFilter="none";$vintageBackdropOpacity="none";
    $overlayBeforeBackground="none";$overlayBeforeAnimation="none";
    $overlayAfterBackground="none";$overlayAfterAnimation="none";
} $voc=$userSettings['vocabulary'];$uni=$userData['units'];$terms=[];
$terms[]=(isset($voc[$uni]['Debit'])) ? $voc[$uni]['Debit']:'Debit';
$terms[]=(isset($voc[$uni]['Credit'])) ? $voc[$uni]['Credit']:'Credit';
$terms[]=(isset($voc[$uni]['Balance'])) ? $voc[$uni]['Balance']:'Balance';
$terms[]=(isset($voc[$uni]['Name'])) ? $voc[$uni]['Name']:'Name';
$terms[]=(isset($voc[$uni]['Amount'])) ? $voc[$uni]['Amount']:'Amount';
$terms[]=(isset($voc[$uni]['Price'])) ? $voc[$uni]['Price']:'Price';
$terms[]=(isset($voc[$uni]["The market is closed."]))?$voc[$uni]["The market is closed."] : "The market is closed.";
$terms[]=(isset($voc[$uni]['Active Hours:']))?$voc[$uni]['Active Hours:']:'Active Hours:';
$terms[]=(isset($voc[$uni]['Agent']))?$voc[$uni]['Agent']:'Agent';
/* ¶ 0 */ echo $dateTimeStr."\r\n\r\n".
/* ¶ 1 */ $dateTimeCode." ".$userData['observe'].$userData['spectate']." ".rgbap($userData['back_color'],$userData['opacity'])."\r\n\r\n".
/* ¶ 2 */ hHmMsS($alarmInTime)."\r\n\r\n".
/* ¶ 3 */ $vintageBackdropFilter.";".$vintageBackdropOpacity.";".$overlayBeforeBackground.";".$overlayBeforeAnimation.";".$overlayAfterBackground.";".$overlayAfterAnimation."\r\n\r\n".
/* ¶ 4 */ $userData['audio_volume'].' '.$userData['audio_speed'].' '.$userData['video_volume'].' '.$userData['video_speed'].' '.$userData['alarm_volume'].' '.$userData['timer_volume'].' '.$userData['loop_volume'].' '.$userData['rest_volume']."\r\n\r\n".
/* ¶ 5 */ $terms[0].' | '.$terms[1].' | '.$terms[2].' | '.$terms[3].' | '.$terms[4].' | '.$terms[5].' | '.$terms[6].' | '.$terms[7].' | '.$terms[8]."\r\n\r\n". // Read Line 5
/* ¶ 6 */ $userData['pangram_'.(($userSettings['pangram'][$uni]) ? $userSettings['pangram'][$uni] : $userSettings['pangram']['default'])];