<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/session.json',json_encode($userSettings['defaults']));
$bindingData=fileopen('binding.json');
$poweredData=fileopen('dominion.json');
$autoData=fileopen('automator.json');
$toolData=fileopen('toolbox.json');
$pref=prefixes($userData); $locksArr=fileopen($cookie.'_files/lock.json',json_encode($userSettings['locks']));
$userLocks=userlocks($locksArr,$userSettings['collections'],$pref); $notesArr=fileopen($cookie.'_files/metadata.json',json_encode($userSettings['metadata']));
$listExem=exemplar(str_replace('./','',(glob('./*.models.json'))));
foreach ($listExem as $key=>$value) {
    if (!isset($value['nsfw'])) { unset($listExem[$key]); }
} $listCont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
foreach ($listCont as $key=>$value) {
    if (!isset($listExem[$value])) { unset($listCont[$key]); }
} $listDefExem=exemplar(str_replace('./','',(glob('./*.models.json'))));
foreach ($listDefExem as $key=>$value) {
    if (isset($value['nsfw'])) { unset($listDefExem[$key]); }
} $listDefCont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
foreach ($listDefCont as $key=>$value) {
    if (!isset($listDefExem[$value])) { unset($listDefCont[$key]); }
} $newsFeed=jsonopen('./'.$cookie.'_files/msgbox.json',true);
$userBook=jsonopen('./'.$cookie.'_files/book.json',true);
$userStore=jsonopen('./'.$cookie.'_files/store.json',true);
$localesArr=fileopen('./i18n.json');
$publicUserData=[]; foreach ($poweredData as $key=>$value) {
    if (file_exists($key.'_files/session.json')) {
        $testArr=fileopen($key.'_files/session.json',json_encode($userSettings['defaults']));
    } date_default_timezone_set(dec_tz($testArr['timezone']));
    $publicUserData['hh'][$key]=date('H'); $publicUserData['hour'][$key]=date('H');
    $publicUserData['date'][$key]=chooseCalendar(time(),$testArr,$userSettings); $publicUserData['time'][$key]=timedate(time(),$testArr,$userSettings);
    foreach ($userSettings['public_user_data'] as $pub) {
        $publicUserData[$pub][$key]=$testArr[$pub];
    }
} $usersList=array_keys($poweredData);natcasesort($usersList);
/* ¶ 0 */ echo $cookie."\r\n\r\n".
/* ¶ 1 */ implode(',',$pref)."\r\n\r\n".
/* ¶ 2 */ json_encode($bindingData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 3 */ json_encode($poweredData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 4 */ json_encode($autoData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 5 */ json_encode($toolData,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
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
