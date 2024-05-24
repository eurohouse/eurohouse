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
$subUser = $autoUsers[rand(0, (count($autoUsers)-1))];
$objUser = $autoObjects[rand(0, (count($autoObjects)-1))];
$handle = $autoObjects[rand(0, (count($autoObjects)-1))];
if (($subUser == $objUser) || ($poweredData[$subUser] < 0) || (frndOf($frndData, $subUser, $objUser)) || (frndOf($frndData, $subUser, $handle))) {
    $subUser = $autoUsers[rand(0, (count($autoUsers)-1))];
    $objUser = $autoObjects[rand(0, (count($autoObjects)-1))];
    $handle = $autoObjects[rand(0, (count($autoObjects)-1))];
}
echo $subUser."\r\n".$objUser."\r\n".$handle;
