<?php
include 'functions.php';
$usersList = str_replace('./.log/','',(glob('./.log/*_msgbox.json')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $jsonTestArr = jsonopen('./.log/'.$value);
    $allContent .= $jsonTestArr."\r\n\r\n";
}
echo $allContent;