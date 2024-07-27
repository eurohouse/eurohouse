<?php
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = json_decode(file_get_contents('settings.json'), true);
$userData = (@json_decode(file_get_contents($cookie . '_session.json'), true) != null) ? json_decode(file_get_contents($cookie . '_session.json'), true) : $userSettings['defaults'];
echo $enterBicolor = $userData['back_color'].dechex($userData['opacity']);