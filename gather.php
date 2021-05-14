<?php
$id = basename(dirname(__FILE__));
$name = file_get_contents('name');
$type = file_get_contents('type');
$description = file_get_contents('description');
$rating = file_get_contents('rating');
$format = file_get_contents('format');
$system = file_get_contents('system');
$mode = file_get_contents('mode');
$gender = file_get_contents('gender');
if ($system == 'Metric') {
    $worthExt = 'eur';
    $worthSign = '€';
    $spaceExt = 'm';
    $spaceSign = 'm';
} elseif ($system == 'Imperial') {
    $worthExt = 'usd';
    $worthSign = '$';
    $spaceExt = 'ft';
    $spaceSign = 'ft';
}
$worth = file_get_contents('worth.'.$worthExt);
$x = file_get_contents('x.'.$spaceExt);
$y = file_get_contents('x.'.$spaceExt);
$z = file_get_contents('x.'.$spaceExt);
$reach = file_get_contents('reach.'.$spaceExt);
$stepMin = file_get_contents('stmin.'.$spaceExt);
$stepMax = file_get_contents('stmax.'.$spaceExt);
$step = rand($stepMin, $stepMax);
