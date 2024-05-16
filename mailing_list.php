<?php
$usersList = str_replace('./.log/','',(glob('./.log/*_msgbox.log')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $allContent .= file_get_contents('./.log/'.$value)."\r\n\r\n";
}
echo $allContent;