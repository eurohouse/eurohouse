<?php
include 'functions.php';
$usersList = str_replace('./.book/','',(glob('./.book/*_book.json')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $jsonTestArr = jsonopen('./.book/'.$value);
    $allContent .= $jsonTestArr."\r\n\r\n";
}
echo $allContent;