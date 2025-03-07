<?php
include 'functions.php'; $userSettings=fileopen('settings.json');
$usersList=str_replace('./','',(glob('./*_session.json')));
$activeHours=''; foreach ($usersList as $key=>$value) {
    $testArr=arropen($value,json_encode($userSettings['defaults']),'DEFAULT');
    $userTimeZone=dec_tz($testArr['timezone']);
    date_default_timezone_set($userTimeZone);
    $activeHours.=$testArr['active_hours']."\r\n\r\n";
} echo $activeHours;
