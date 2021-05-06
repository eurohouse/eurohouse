<?php
$id = $_REQUEST['id'];
$content = file_get_contents($id.'/rating');
$content = $content - 1;
file_put_contents($id.'/rating', $content);
chmod($id.'/rating', 0777);
