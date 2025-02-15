<?php
include 'functions.php';
$cookie=(isset($_COOKIE['user']))?$_COOKIE['user']:'root';
$userSettings=fileopen('settings.json');
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
$bindingData=arropen('binding.json',"{\"root\":\"root\"}");
$poweredData=arropen('dominion.json',"{\"root\":0}");
$autoData=arropen('automator.json',"{\"root\":\"manual\"}");
$frndData=arropen('friendship.json',"{\"root\":\"\"}");
$toolData=arropen('toolbox.json',"{\"root\":\"\"}");
$callData=arropen('calling.json',"{\"root\":\"root\"}");
$avaPref=(lux($userData['back_text_color']))?'ava.':'abc.';
$locksArr=arropen($cookie.'_lock.json',json_encode($userSettings['locks']),'DEFAULT');
$userLocks=userlocks($locksArr,$userSettings['collections'],$avaPref);
$notesArr=arropen($cookie.'_metadata.json',json_encode($userSettings['metadata']),'CUSTOM');
$notesList=implode(' | ',array_keys($notesArr));
$notesJSON=file_get_contents($cookie.'_metadata.json');
$tutorArr=arropen('tutorial.json',"{\"\":\"\"}",'CUSTOM');
$tutorList=implode(' | ',array_keys($tutorArr));
$tutorJSON=jsonline('tutorial.json');
$codexBoxArr=str_replace('./','',(glob('./*.mac')));
$speechBoxArr=str_replace('./','',(glob('./*.pro')));
$usersList=implode(',',str_replace('_msgbox.json','',str_replace('./.msgbox/','',(glob('./.msgbox/*_msgbox.json')))));
$booksList=implode(',',str_replace('_book.json','',str_replace('./.book/','',(glob('./.book/*_book.json')))));
$storeList=implode(',',str_replace('_store.json','',str_replace('./.store/','',(glob('./.store/*_store.json')))));
$listExem=exemplar(str_replace('./','',(glob('./*.models.json'))));
$listCont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
/*foreach ($listCont as $key=>$value) {
    if (!in_array(explode('.',$key)[0],explode(',',$userLocks['background']))) {
        unset($listCont[$key]);
    }
} foreach ($listExem as $key=>$value) {
    if (!in_array($key,$listCont)) {
        unset($listExem[$key]);
    }
} foreach ($listExem as $key=>$value) {
    if (!isset($value['nsfw'])) { unset($listExem[$key]); }
}*/
$newsFeed=jsonopen('./.msgbox/'.$cookie.'_msgbox.json',true);
$userBook=jsonopen('./.book/'.$cookie.'_book.json',true);
$userStore=jsonopen('./.store/'.$cookie.'_store.json',true);
$localesArr=arropen('./i18n.json');
$sessList=str_replace('./','',(glob('./*_session.json')));
$currentTimes=$currentAvatars=[]; foreach ($sessList as $key=>$value) {
    $testArr=arropen($value,json_encode($userSettings['defaults']),'DEFAULT');
    $timeZones=dec_tz($testArr['timezone']);
    date_default_timezone_set($timeZones);$currentTimes[]=date('H');
    $currentAvatars[]=$testArr['avatar'];
} $activeIPs=vismark('visitors.json');
/* ¶ 0 */ echo $cookie."\r\n\r\n".
/* ¶ 1 */ valstr($bindingData,';',':')."\r\n\r\n".
/* ¶ 2 */ valstr($poweredData,';',':')."\r\n\r\n".
/* ¶ 3 */ valstr($autoData,';',':')."\r\n\r\n".
/* ¶ 4 */ valstr($frndData,';',':')."\r\n\r\n".
/* ¶ 5 */ valstr($toolData,';',':')."\r\n\r\n".
/* ¶ 6 */ valstr($callData,';',':')."\r\n\r\n".
/* ¶ 7 */ $newsFeed."\r\n\r\n".
/* ¶ 8 */ $userBook."\r\n\r\n".
/* ¶ 9 */ $userStore."\r\n\r\n".
/* ¶ 10 */ json_encode($userLocks,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 11 */ implode('//',$codexBoxArr)."\\\\".implode('//',$speechBoxArr)."\r\n\r\n".
/* ¶ 12 */ $usersList.";".$booksList.";".$storeList."\r\n\r\n".
/* ¶ 13 */ implode(' ',$currentTimes)."\r\n\r\n".
/* ¶ 14 */ $notesList."\r\n\r\n".
/* ¶ 15 */ $notesJSON."\r\n\r\n".
/* ¶ 16 */ $tutorList."\r\n\r\n".
/* ¶ 17 */ $tutorJSON."\r\n\r\n".
/* ¶ 18 */ implode(' ',$currentAvatars)."\r\n\r\n".
/* ¶ 19 */ json_encode($activeIPs,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 20 */ json_encode($localesArr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 21 */ json_encode($listExem,JSON_UNESCAPED_UNICODE);
