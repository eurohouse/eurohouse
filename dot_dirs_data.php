<?php
include 'functions.php';
$userSettings=fileopen('settings.json');
$dotDirs=$userSettings['dot_dirs'];
$poweredData=arropen('dominion.json',"{\"root\":0}");
$usersList=array_keys($poweredData); natcasesort($usersList);
$usersData=[]; foreach ($dotDirs as $ind=>$itm) {
    $usersData=[]; foreach ($usersList as $key=>$value) {
        $jsonTestArr=jsonopen('./.'.$itm.'/'.$value.'_'.$itm.'.json',true);
        $jsonPerUser=json_decode($jsonTestArr,true);
        $usersData[$value]=$jsonPerUser;
    } echo json_encode($usersData,JSON_UNESCAPED_UNICODE)."\r\n\r\n";
}
