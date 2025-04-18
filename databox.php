<?php include 'functions.php';
$cookie=(isset($_COOKIE['user']))?$_COOKIE['user']:'root';
$userSettings=fileopen('settings.json');
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
$bindingData=arropen('binding.json',"{\"root\":\"root\"}");
$poweredData=arropen('dominion.json',"{\"root\":0}");
$autoData=arropen('automator.json',"{\"root\":\"manual\"}");
$frndData=arropen('friendship.json',"{\"root\":\"\"}");
$toolData=arropen('toolbox.json',"{\"root\":\"\"}");
$callData=arropen('calling.json',"{\"root\":\"root\"}");
$avaPref=(isColorLight($userData['back_text_color']))?'ava.':'abc.';
$pref=(isColorLight($session['fore_text_color']))?'iso.':'iec.';
$locksArr=arropen($cookie.'_lock.json',json_encode($userSettings['locks']),'DEFAULT');
$userLocks=userlocks($locksArr,$userSettings['collections'],$avaPref,$pref);
$notesArr=arropen($cookie.'_metadata.json',json_encode($userSettings['metadata']),'CUSTOM');
$tutorArr=arropen('tutorial.json',"{\"\":\"\"}",'CUSTOM');
$newsData=arropen('changelog.json',"{\"\":\"\"}",'CUSTOM');
$listCont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$listExem=exemplar(str_replace('./','',(glob('./*.models.json'))));
foreach ($listExem as $key=>$value) {
    if (!isset($value['nsfw'])) { unset($listExem[$key]); }
} $contKeys=$contVals=[]; foreach ($listExem as $key=>$value) {
    $contKeys=array_keys($listCont,$key);
    $contVals=array_merge($contVals,(array_fill_keys($contKeys,$key)));
} $localesArr=arropen('./i18n.json');
$currentTimes=$currentTimesActive=$currentAvatars=[];
foreach ($poweredData as $key=>$value) {
    if (file_exists($key.'_session.json')) {
        $testArr=arropen($key.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
    } else { $testArr=['timezone'=>0,'avatar'=>'NULL']; }
    date_default_timezone_set(dec_tz($testArr['timezone']));
    $currentTimes[$key]=date('H');
    $currentTimesActive[$key]=$testArr['active_hours'];
    $currentAvatars[$key]=$testArr['avatar'];
} $activeIPs=markWebsiteVisit('visitors.json');
$usersList=array_keys($poweredData); natcasesort($usersList);
$usersData=[];$jsonPerStr='';
foreach ($userSettings['user_info'] as $ind=>$itm) {
    $usersData=[]; foreach ($usersList as $key=>$value) {
        $jsonTestArr=jsonopen($value.'_'.$itm.'.json',true);
        $usersData[$value]=json_decode($jsonTestArr,true);
    } $jsonPerStr.=json_encode($usersData,JSON_UNESCAPED_UNICODE)."\r\n";
}
/* ¶ 0 */ echo $cookie."\r\n\r\n".
/* ¶ 1 */ valstr($bindingData,';',':')."\r\n\r\n".
/* ¶ 2 */ valstr($poweredData,';',':')."\r\n\r\n".
/* ¶ 3 */ valstr($autoData,';',':')."\r\n\r\n".
/* ¶ 4 */ valstr($frndData,';',':')."\r\n\r\n".
/* ¶ 5 */ valstr($toolData,';',':')."\r\n\r\n".
/* ¶ 6 */ valstr($callData,';',':')."\r\n\r\n".
/* ¶ 7 */ json_encode($userLocks,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 8 */ implode('//',(str_replace('./','',(glob('./*.mac')))))."\\\\".implode('//',(str_replace('./','',(glob('./*.pro')))))."\r\n\r\n".
/* ¶ 9 */ implode(',',$usersList)."\r\n\r\n".
/* ¶ 10 */ valstr($currentTimes,';',':')."\r\n\r\n".
/* ¶ 11 */ valstr($currentTimesActive,';',':')."\r\n\r\n".
/* ¶ 12 */ valstr($currentAvatars,';',':')."\r\n\r\n".
/* ¶ 13 */ json_encode($notesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 14 */ json_encode($tutorArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 15 */ json_encode($newsData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 16 */ json_encode($activeIPs,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 17 */ json_encode($localesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 18 */ json_encode($listExem,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 19 */ json_encode($contVals,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 20 */ $jsonPerStr;
