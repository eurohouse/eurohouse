<?php
$usersList = str_replace('./.log/','',(glob('./.log/*_msgbox.json')));
$allContent = "";
foreach ($usersList as $key=>$value) {
    $jsonTestArr = file_get_contents('./.log/'.$value);
    $allContent .= $jsonTestArr."\r\n\r\n";
}
echo $allContent;