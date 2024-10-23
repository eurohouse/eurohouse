<?php
include 'functions.php';
$userSettings = fileopen('settings.json');
$usersList = str_replace('./.store/','',(glob('./*_session.json')));
$allContent = ""; $othCT = $othAH = '';
foreach ($usersList as $key=>$value) {
    $testArr = arropen($value, json_encode($userSettings['defaults']), 'DEFAULT');
    $othTZ = dec_tz($testArr['timezone']);
    date_default_timezone_set($othTZ);
    $othCT .= date('H')." ";
    $othAH .= implode(' ', explode(',', $testArr['active_hours']))."\r\n";
} echo $othCT."\r\n\r\n". // Read Line 0
$othAH; // Read Line 1