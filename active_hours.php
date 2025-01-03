<?php
include 'functions.php';
$userSettings = fileopen('settings.json');
$usersList = str_replace('./','',(glob('./*_session.json')));
$othAH = ''; foreach ($usersList as $key=>$value) {
    $testArr = arropen($value, json_encode($userSettings['defaults']), 'DEFAULT');
    $othTZ = dec_tz($testArr['timezone']);
    date_default_timezone_set($othTZ);
    $othAH .= $testArr['active_hours']."\r\n\r\n";
} echo $othAH; // Read All Lines At Once