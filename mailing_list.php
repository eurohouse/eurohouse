<?php
include 'functions.php';
$usersList = str_replace('./.msgbox/','',(glob('./.msgbox/*_msgbox.json')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $jsonTestArr = jsonopen('./.msgbox/'.$value);
    $allContent .= $jsonTestArr."\r\n\r\n";
}
echo $allContent;