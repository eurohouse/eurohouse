<?php
include 'functions.php';
$usersList = str_replace('./.store/','',(glob('./.store/*_store.json')));
$allContent = ""; foreach ($usersList as $key=>$value) {
    $jsonTestArr = jsonopen('./.store/'.$value, true);
    $allContent .= $jsonTestArr."\r\n\r\n";
} echo $allContent; // Read All Lines At Once