<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$dataLoad=$userSettings['dataload'];
$poweredData=arropen('dominion.json');
$usersList=array_keys($poweredData); natcasesort($usersList);
$usersData=[]; foreach ($dataLoad as $ind=>$itm) {
    $usersData=[]; foreach ($usersList as $key=>$value) {
        $jsonTest=jsonopen('./'.$value.'_'.$itm.'.json',true);
        if (@json_decode($jsonTest,true)!=null) {
            $usersData[$value]=json_decode($jsonTest,true);
        } else { $usersData[$value]=[''=>'']; }
    } echo json_encode($usersData,JSON_UNESCAPED_UNICODE)."\r\n\r\n";
}
