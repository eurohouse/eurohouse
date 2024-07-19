<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), 'DEFAULT');
$bindingData = arropen('binding.json', "{\"root\":\"root\"}");
$poweredData = arropen('dominion.json', "{\"root\":0}");
$autoData = arropen('automator.json', "{\"root\":\"manual\"}");
$frndData = arropen('friendship.json', "{\"root\":\"\"}");
$musicBoxArr = str_replace('./','',(glob('./*.{'.duplex($userSettings['collections']['music'], true).'}', GLOB_BRACE)));
$soundBoxArr = str_replace('./','',(glob('./*.{'.duplex($userSettings['collections']['audio'], true).'}', GLOB_BRACE)));
natcasesort($musicBoxArr); array_unique($musicBoxArr);
natcasesort($soundBoxArr); array_unique($soundBoxArr);
$locksArr = arropen($cookie.'_lock.json', json_encode($userSettings['locks']), 'DEFAULT');
$musicBox = excpkg($musicBoxArr, $locksArr['music']);
$soundBox = excpkg($soundBoxArr, $locksArr['sound']);
$codexBoxArr = str_replace('./','',(glob('./*.mac')));
$speechBoxArr = str_replace('./','',(glob('./*.pro')));
$usersList = implode(',',str_replace('_msgbox.json','',str_replace('./.log/','',(glob('./.log/*_msgbox.json')))));
$booksList = implode(',',str_replace('_book.json','',str_replace('./.book/','',(glob('./.book/*_book.json')))));
$newsFeed = ($userData['private'] != 0) ? jsonopen('./.log/'.$cookie.'_msgbox.json') : jsonopen('./.log/msgbox.json');
$userBook = jsonopen('./.book/'.$cookie.'_book.json', true);
echo $cookie."\r\n\r\n".
valstr($bindingData,';',':')."\r\n\r\n".
valstr($poweredData,';',':')."\r\n\r\n".
valstr($autoData,';',':')."\r\n\r\n".
valstr($frndData,';',':')."\r\n\r\n".
$newsFeed."\r\n\r\n".
$userBook."\r\n\r\n".
implode('//', $musicBox)."\\\\".implode('//', $soundBox)."\r\n\r\n".
implode('//', $codexBoxArr)."\\\\".implode('//', $speechBoxArr)."\r\n\r\n".
$usersList."\r\n\r\n".
$booksList;