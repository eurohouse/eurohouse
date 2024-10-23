<?php
include 'functions.php';
$usersList = str_replace('./.store/','',(glob('./.store/*_store.json'))); $allContent = ""; foreach ($usersList as $key=>$value) {
    $otherData = fileopen($value.'_session.json');
    $otherTimezone = dec_tz($otherData['timezone']); date_default_timezone_set($otherTimezone);
    $hoursAct = $otherData['active_hours']." ";
    $hoursNow = date('H')." ";
} echo $hoursNow."\r\n\r\n". // Read Line 0
$hoursAct; // Read Line 1