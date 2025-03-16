<?php include 'functions.php';
$cookie=(isset($_COOKIE['user']))?$_COOKIE['user']:'root';
$userSettings=fileopen('settings.json');
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
date_default_timezone_set(dec_tz($userData['timezone']));
if ($userData['memo']!='') {
    if (time()>=$userData['memo']) { $ongo=1;$inco=0;$alarmInTime=0;
    } else { $ongo=0;$inco=1;$alarmInTime=$userData['memo']-time(); }
} else { $ongo=0;$inco=0;$alarmInTime=0; }
$dateTimeStr=($userData['timedisp']!=0)?date($userData['date_format']):date($userData['time_format']); if ($userData['vintage']!=0) {
    $v00="blur(0.".round($userData['magnitude']/1.5)."px)";$v01="0.".round($userData['magnitude']/1.5);$ol00="repeating-linear-gradient(90deg, #000".$userData['magnitude']." 0 ".round($userData['magnitude']/2.5)."px, transparent ".round($userData['magnitude']/3.5)."px 35vmin)";$ol01="vlines 0.45s steps(1) infinite";$ol10="repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00003%, transparent 0.0005%, transparent 0.00095%), repeating-conic-gradient(#00000".$userData['magnitude']." 0%, transparent 0.00005%, transparent 0.00015%, transparent 0.0009%)";$ol11="grains 0.5s steps(1) infinite";
} else { $v00=$v01=$ol00=$ol01=$ol10=$ol11="none"; }
$voc=$userSettings['vocabulary'];$uni=$userData['units'];
/* ¶ 0 */ echo $dateTimeStr."\r\n\r\n".
/* ¶ 1 */ hHmMsS($alarmInTime,true)." ".$ongo.$inco.date('w')." ".$userData['observe'].$userData['spectate']." ".rgbap($userData['back_color'],$userData['opacity'])."\r\n\r\n".
/* ¶ 2 */ $v00.";".$v01.";".$ol00.";".$ol01.";".$ol10.";".$ol11."\r\n\r\n".
/* ¶ 3 */ $userData['audio_volume'].' '.$userData['audio_speed'].' '.$userData['video_volume'].' '.$userData['video_speed'].' '.$userData['alarm_volume'].' '.$userData['timer_volume'].' '.$userData['loop_volume'].' '.$userData['rest_volume']."\r\n\r\n".
/* ¶ 4 */ term('Debit',$voc,$uni).' | '.term('Credit',$voc,$uni).' | '.term('Balance',$voc,$uni).' | '.term('Name',$voc,$uni).' | '.term('Amount',$voc,$uni).' | '.term('Price',$voc,$uni).' | '.term('The market is closed.',$voc,$uni).' | '.term('Active Hours:',$voc,$uni).' | '.term('Agent',$voc,$uni).' | '.term('Press any key to continue...',$voc,$uni).' | '.termCmd($userData['mode'],$userSettings['locale']['cli'],$uni)."\r\n\r\n".
/* ¶ 5 */ $userData['pangram_'.(($userSettings['pangram'][$uni])?$userSettings['pangram'][$uni]:$userSettings['pangram']['default'])]."\r\n\r\n".
/* ¶ 6 */ json_encode($userSettings['locks_icons'],JSON_UNESCAPED_UNICODE);