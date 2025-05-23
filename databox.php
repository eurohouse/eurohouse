<?php include 'functions.php';
$cookie=(isset($_COOKIE['user']))?$_COOKIE['user']:'root';
$userSettings=fileopen('settings.json');
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
$bindingData=arropen('binding.json',"{\"root\":\"root\"}");
$poweredData=arropen('dominion.json',"{\"root\":0}");
$autoData=arropen('automator.json',"{\"root\":\"manual\"}");
$toolData=arropen('toolbox.json',"{\"root\":\"\"}");
$pref=prefixes($userData); $locksArr=arropen($cookie.'_lock.json',json_encode($userSettings['locks']),'DEFAULT');
$userLocks=userlocks($locksArr,$userSettings['collections'],$pref); $notesArr=arropen($cookie.'_metadata.json',json_encode($userSettings['metadata']),'CUSTOM');
$tutorArr=arropen('tutorial.json',"{\"\":\"\"}",'CUSTOM');
$newsData=arropen('changelog.json',"{\"\":\"\"}",'CUSTOM');
$listExem=exemplar(str_replace('./','',(glob('./*.models.json')))); foreach ($listExem as $key=>$value) {
    if (!isset($value['nsfw'])) { unset($listExem[$key]); }
} $listCont=exemplar(str_replace('./','',(glob('./*.contents.json')))); foreach ($listCont as $key=>$value) {
    if (!isset($listExem[$value])) { unset($listCont[$key]); }
} $newsFeed=jsonopen('./'.$cookie.'_msgbox.json',true);
$userBook=jsonopen('./'.$cookie.'_book.json',true);
$userStore=jsonopen('./'.$cookie.'_store.json',true);
$localesArr=arropen('./i18n.json');
$currentTimes=[]; foreach ($poweredData as $key=>$value) {
    if (file_exists($key.'_session.json')) {
        $testArr=arropen($key.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
    } else { $testArr=['timezone'=>0,'avatar'=>'NULL']; }
    date_default_timezone_set(dec_tz($testArr['timezone']));
    $currentTimes[$key]=date('H');
} $activeIPs=markWebsiteVisit();
$usersList=array_keys($poweredData);natcasesort($usersList);
/* ¶ 0 */ echo $cookie."\r\n\r\n".
/* ¶ 1 */ implode(',',$pref)."\r\n\r\n".
/* ¶ 2 */ valstr($bindingData,';',':')."\r\n\r\n".
/* ¶ 3 */ valstr($poweredData,';',':')."\r\n\r\n".
/* ¶ 4 */ valstr($autoData,';',':')."\r\n\r\n".
/* ¶ 5 */ valstr($toolData,';',':')."\r\n\r\n".
/* ¶ 6 */ json_encode($userLocks,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 7 */ implode('//',(str_replace('./','',(glob('./*.mac')))))."\r\n\r\n".
/* ¶ 8 */ implode('//',(str_replace('./','',(glob('./*.pro')))))."\r\n\r\n".
/* ¶ 9 */ implode(',',$usersList)."\r\n\r\n".
/* ¶ 10 */ valstr($currentTimes,';',':')."\r\n\r\n".
/* ¶ 11 */ json_encode($notesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 12 */ json_encode($tutorArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 13 */ json_encode($newsData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 14 */ json_encode($activeIPs,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 15 */ json_encode($localesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 16 */ json_encode($listExem,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 17 */ json_encode($listCont,JSON_UNESCAPED_UNICODE);
