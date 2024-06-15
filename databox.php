<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), true);
$bindingData = arropen('binding.json', "{\"root\":\"root\"}");
$poweredData = arropen('dominion.json', "{\"root\":0}");
$autoData = arropen('automator.json', "{\"root\":\"manual\"}");
$frndData = arropen('friendship.json', "{\"root\":\"\"}");

$musicBoxArr = str_replace('./','',(glob('./*.{'.duplex($userSettings['collections']['music'], true).','.duplex($userSettings['collections']['audio'], true).'}', GLOB_BRACE)));
natcasesort($musicBoxArr); array_unique($musicBoxArr);
$locksArr = arropen($cookie.'_lock.json', json_encode($userSettings['locks']), true);
$museBox = excpkg($musicBoxArr, $locksArr['music']);
$codexBoxArr = str_replace('./','',(glob('./*.mac')));
$speechBoxArr = str_replace('./','',(glob('./*.pro')));
$usersList = implode(',',str_replace('_msgbox.json','',str_replace('./.log/','',(glob('./.log/*_msgbox.json')))));
$booksList = implode(',',str_replace('_book.json','',str_replace('./.book/','',(glob('./.book/*_book.json')))));
$newsFeed = ($userData['private'] != 0) ? file_get_contents('./.log/'.$cookie.'_msgbox.json') : file_get_contents('./.log/msgbox.json');
$userBook = file_get_contents('./.book/'.$cookie.'_book.json');
echo $cookie."\r\n\r\n".
$userData['find']."\r\n\r\n".
valstr($bindingData,';',':')."\r\n\r\n".
valstr($poweredData,';',':')."\r\n\r\n".
valstr($autoData,';',':')."\r\n\r\n".
valstr($frndData,';',':')."\r\n\r\n".
$newsFeed."\r\n\r\n".
$userBook."\r\n\r\n".
implode('//', $museBox)."\r\n\r\n".
implode('//', $codexBoxArr)."\\\\".implode('//', $speechBoxArr)."\r\n\r\n".
$usersList."\r\n\r\n".
$booksList;