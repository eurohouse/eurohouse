<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), 'DEFAULT');
$bindingData = arropen('binding.json', "{\"root\":\"root\"}");
$poweredData = arropen('dominion.json', "{\"root\":0}");
$autoData = arropen('automator.json', "{\"root\":\"manual\"}");
$frndData = arropen('friendship.json', "{\"root\":\"\"}");
$toolData = arropen('toolbox.json', "{\"root\":\"\"}");
$callData = arropen('calling.json', "{\"root\":\"root\"}");
$avaPref = (lux($userData['back_text_color'])) ? 'ava.' : 'abc.';
$locksArr = arropen($cookie.'_lock.json', json_encode($userSettings['locks']), 'DEFAULT');
$notesArr = arropen($cookie.'_metadata.json', json_encode($userSettings['metadata']), 'CUSTOM');
$notesList = implode(' | ', array_keys($notesArr));
$notesJSON = file_get_contents($cookie.'_metadata.json');
$codexBoxArr = str_replace('./','',(glob('./*.mac')));
$speechBoxArr = str_replace('./','',(glob('./*.pro')));
$usersList = implode(',',str_replace('_msgbox.json','',str_replace('./.msgbox/','',(glob('./.msgbox/*_msgbox.json')))));
$booksList = implode(',',str_replace('_book.json','',str_replace('./.book/','',(glob('./.book/*_book.json')))));
$storeList = implode(',',str_replace('_store.json','',str_replace('./.store/','',(glob('./.store/*_store.json')))));
$newsFeed = jsonopen('./.msgbox/'.$cookie.'_msgbox.json', true);
$userBook = jsonopen('./.book/'.$cookie.'_book.json', true);
$userStore = jsonopen('./.store/'.$cookie.'_store.json', true);
$othCT = ''; foreach ($usersList as $key=>$value) {
    $testArr = arropen($value, json_encode($userSettings['defaults']), 'DEFAULT');
    $othTZ = dec_tz($testArr['timezone']);
    date_default_timezone_set($othTZ);
    $othCT = $othCT.date('H').' ';
} echo $cookie."\r\n\r\n". // Read Line 0
valstr($bindingData,';',':')."\r\n\r\n". // Read Line 1
valstr($poweredData,';',':')."\r\n\r\n". // Read Line 2
valstr($autoData,';',':')."\r\n\r\n". // Read Line 3
valstr($frndData,';',':')."\r\n\r\n". // Read Line 4
valstr($toolData,';',':')."\r\n\r\n". // Read Line 5
valstr($callData,';',':')."\r\n\r\n". // Read Line 6
$newsFeed."\r\n\r\n". // Read Line 7
$userBook."\r\n\r\n". // Read Line 8
$userStore."\r\n\r\n". // Read Line 9
json_encode(userlocks($locksArr, $userSettings['collections'], $avaPref), JSON_UNESCAPED_UNICODE)."\r\n\r\n". // Read Line 10
implode('//', $codexBoxArr)."\\\\".implode('//', $speechBoxArr)."\r\n\r\n". // Read Line 11
$usersList.";".$booksList.";".$storeList."\r\n\r\n". // Read Line 12
$notesList."\r\n\r\n". // Read Line 13
$notesJSON."\r\n\r\n". // Read Line 14
rtrim($othCT); // Read Line 15