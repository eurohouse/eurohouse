<?php
$usersList = str_replace('./.book/','',(glob('./.book/*_book.log')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $allContent .= file_get_contents('./.book/'.$value)."\r\n\r\n";
}
echo $allContent;