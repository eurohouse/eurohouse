<?php include 'functions.php';
$usersList=str_replace('_files','',str_replace('./','',(glob('./*_files',GLOB_ONLYDIR)))); natcasesort($usersList);
$usersData=[]; foreach ($usersList as $perUser) {
    $jsonTest=fileopen('./'.$perUser.'_files/messenger.json','{"":""}','backup raw restore'); if (@json_decode($jsonTest,true)!=null) {
        $usersData[$perUser]=json_decode($jsonTest,true);
    } else { $usersData[$perUser]=[''=>'']; }
} echo /* ¶ 0 */ json_encode($usersData,JSON_UNESCAPED_UNICODE);