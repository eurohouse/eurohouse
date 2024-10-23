<?php
include 'functions.php';
$userSettings = fileopen('settings.json');
$usersList = str_replace('./.store/','',(glob('./.store/*_store.json')));
$allContent = ""; foreach ($usersList as $key=>$value) {
    $jsonTestArr = arropen($value.'_session.json', $userSettings, 'DEFAULT');
    $allContent .= $jsonTestArr['active_hours']."\r\n\r\n";
} echo $allContent; // Read All Lines At Once