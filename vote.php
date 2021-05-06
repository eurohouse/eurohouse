<?php
$entity = $_REQUEST['id'];
$rating = file_get_contents($entity.'/rating');
$rating = $rating + 1;
file_put_contents($entity.'/rating', $rating);
chmod($entity.'/rating', 0777);
