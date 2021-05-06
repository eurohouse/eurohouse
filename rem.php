<?php
$string = $_REQUEST['str'];
$content = file_get_contents('apps.list');
$content = str_replace($string.';', '', $content);
file_put_contents('apps.list', $content);
chmod('apps.list', 0777);
