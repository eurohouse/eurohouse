<?php
include 'functions.php';
$userSettings = fileopen('settings.json');
$usersList = str_replace('./.store/','',(glob('./*_session.json')));
$othAH = ""; foreach ($usersList as $key=>$value) {
    $testArr = arropen($value, json_encode($userSettings['defaults']), 'DEFAULT');
    $othTZ = dec_tz($testArr['timezone']);
    date_default_timezone_set($othTZ);
    $othAH .= implode(' ', explode(',', $testArr['active_hours']))."\r\n";
} echo $othAH; // Read All Lines At Once