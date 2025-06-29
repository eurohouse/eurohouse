<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$nu=$userSettings['reserve']['unauthorized'];
$su=$userSettings['reserve']['superuser'];
$cookie=whichCookie($nu);
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
$bindingData=arropen('binding.json');
$poweredData=arropen('dominion.json');
$autoData=arropen('automator.json');
$toolData=arropen('toolbox.json');
$pref=prefixes($userData); $locksArr=arropen($cookie.'_lock.json',json_encode($userSettings['locks']),'DEFAULT');
$userLocks=userlocks($locksArr,$userSettings['collections'],$pref); $notesArr=arropen($cookie.'_metadata.json',json_encode($userSettings['metadata']),'CUSTOM');
$listExem=exemplar(str_replace('./','',(glob('./*.models.json')))); foreach ($listExem as $key=>$value) { if (!isset($value['nsfw'])) { unset($listExem[$key]); }}
$listCont=exemplar(str_replace('./','',(glob('./*.contents.json')))); foreach ($listCont as $key=>$value) { if (!isset($listExem[$value])) { unset($listCont[$key]); }}
$listDefExem=exemplar(str_replace('./','',(glob('./*.models.json')))); foreach ($listDefExem as $key=>$value) { if (isset($value['nsfw'])) { unset($listDefExem[$key]); }}
$listDefCont=exemplar(str_replace('./','',(glob('./*.contents.json')))); foreach ($listDefCont as $key=>$value) { if (!isset($listDefExem[$value])) { unset($listDefCont[$key]); }} $newsFeed=jsonopen('./'.$cookie.'_msgbox.json',true);
$userBook=jsonopen('./'.$cookie.'_book.json',true);
$userStore=jsonopen('./'.$cookie.'_store.json',true);
$localesArr=arropen('./i18n.json');
$publicUserData=['times'=>[],'timezones'=>[],'avatars'=>[]];
foreach ($poweredData as $key=>$value) {
    if (file_exists($key.'_session.json')) {
        $testArr=arropen($key.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
    } else { $testArr=['timezone'=>0,'avatar'=>'NULL']; }
    date_default_timezone_set(dec_tz($testArr['timezone']));
    $publicUserData['hh'][$key]=date('H');
    $publicUserData['hour'][$key]=date('H');
    $publicUserData['date'][$key]=chooseCalendar(time(),$testArr,$userSettings); $publicUserData['time'][$key]=timedate(time(),$testArr,$userSettings);
    $publicUserData['tz'][$key]=$testArr['timezone'];
    $publicUserData['timezone'][$key]=$testArr['timezone'];
    $publicUserData['ah'][$key]=$testArr['active_hours'];
    $publicUserData['active_hours'][$key]=$testArr['active_hours'];
    $publicUserData['av'][$key]=$testArr['avatar'];
    $publicUserData['avatar'][$key]=$testArr['avatar'];
} $usersList=array_keys($poweredData);natcasesort($usersList);
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
/* ¶ 10 */ json_encode($publicUserData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 11 */ json_encode($notesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 12 */ json_encode($localesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 13 */ json_encode($listExem,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 14 */ json_encode($listCont,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 15 */ json_encode($listDefExem,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 16 */ json_encode($listDefCont,JSON_UNESCAPED_UNICODE);
