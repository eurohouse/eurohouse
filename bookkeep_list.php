<?php
$usersList = str_replace('./.book/','',(glob('./.book/*_book.json')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $jsonTestArr = file_get_contents('./.book/'.$value);
    $allContent .= $jsonTestArr."\r\n\r\n";
}
echo $allContent;