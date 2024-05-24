<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), true);
$bindingData = arropen('binding.json', "{\"root\":\"root\"}");
$poweredData = arropen('dominion.json', "{\"root\":0}");
$autoData = arropen('automator.json', "{\"root\":\"manual\"}");
$frndData = arropen('friendship.json', "{\"root\":\"\"}");
$autoUsers = []; $autoObjects = [];
foreach ($autoData as $key=>$value) {
    if ($value == 'auto') {
        $autoUsers[] = $key;
    }
}
foreach ($poweredData as $key=>$value) {
    $autoObjects[] = $key;
}
$sub = $autoUsers[rand(0, (count($autoUsers)-1))];
$obj = $autoObjects[rand(0, (count($autoObjects)-1))];
$han = $autoObjects[rand(0, (count($autoObjects)-1))];
if (($sub == $obj) || ($poweredData[$sub] < 0) || (frndOf($frndData, $sub, $obj)) || (frndOf($frndData, $sub, $han))) {
    $subUser = $autoUsers[rand(0, (count($autoUsers)-1))];
    $objUser = $autoObjects[rand(0, (count($autoObjects)-1))];
    $handle = $autoObjects[rand(0, (count($autoObjects)-1))];
    $status = 200;
} else {
    $subUser = "";
    $objUser = "";
    $handle = "";
    $status = 500;
}
echo $subUser."\r\n".$objUser."\r\n".$handle."\r\n".$status;
