<?php
include 'functions.php';
$userSettings = fileopen('settings.json');
$usersList = str_replace('./.store/','',(glob('./.store/*_store.json'))); $allContent = ""; foreach ($usersList as $key=>$value) {
    $otherData = arropen($value.'_session.json', json_encode($userSettings['defaults']), 'DEFAULT');
    $otherTimezone = dec_tz($otherData['timezone']); date_default_timezone_set($otherTimezone);
    $hoursAct = $otherData['active_hours']."\r\n";
    $hoursNow = date('H')." ";
} echo $hoursNow."\r\n\r\n". // Read Line 0
$hoursAct; // Read Line 1