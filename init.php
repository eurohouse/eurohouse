<?php
$name = $_POST['name'];
$type = $_POST['type'];
$title = $_POST['title'];
$description = $_POST['description'];
$format = file_get_contents('format');
$system = file_get_contents('system');
$mode = file_get_contents('mode');
if ($system == 'Metric') {
    $moneyUnit = 'eur';
    $spaceUnit = 'm';
} elseif ($system == 'Imperial') {
    $moneyUnit = 'usd';
    $spaceUnit = 'ft';
}
// Initializing a new entity
if (file_exists($name)) {
} else {
    mkdir($name);
    chmod($name, 0777);
    file_put_contents($name.'/type', $type);
    chmod($name.'/type', 0777);
    file_put_contents($name.'/rating', 0);
    chmod($name.'/rating', 0777);
    file_put_contents($name.'/description', $description);
    chmod($name.'/description', 0777);
    file_put_contents($name.'/name', $title);
    chmod($name.'/name', 0777);
    copy('format', $name.'/format');
    chmod($name.'/format', 0777);
    copy('system', $name.'/system');
    chmod($name.'/system', 0777);
    copy('mode', $name.'/mode');
    chmod($name.'/mode', 0777);
    copy('period', $name.'/period');
    chmod($name.'/period', 0777);
    copy('worth.'.$moneyUnit, $name.'/worth.'.$moneyUnit);
    chmod($name.'/worth.'.$moneyUnit, 0777);
    copy('x.'.$spaceUnit, $name.'/x.'.$spaceUnit);
    chmod($name.'/x.'.$spaceUnit, 0777);
    copy('y.'.$spaceUnit, $name.'/y.'.$spaceUnit);
    chmod($name.'/y.'.$spaceUnit, 0777);
    copy('z.'.$spaceUnit, $name.'/z.'.$spaceUnit);
    chmod($name.'/z.'.$spaceUnit, 0777);
    copy('ammo.spare', $name.'/ammo.spare');
    chmod($name.'/ammo.spare', 0777);
    copy('heal.spare', $name.'/heal.spare');
    chmod($name.'/heal.spare', 0777);
    copy('sups.spare', $name.'/sups.spare');
    chmod($name.'/sups.spare', 0777);
    copy('spec.spare', $name.'/spec.spare');
    chmod($name.'/spec.spare', 0777);
    copy('get.php', $name.'/get.php');
    chmod($name.'/get.php', 0777);
    copy('backup.list', $name.'/backup.list');
    chmod($name.'/backup.list', 0777);
    file_put_contents($name.'/apps.list', '');
    chmod($name.'/apps.list', 0777);
    header('Location: '.$name.'/get.php?pkg=base&dist=unswp');
}
