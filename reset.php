<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*', GLOB_ONLYDIR)));
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Reset Entities</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='Webshop Console started';?>
<br>
<?php
echo 'Resetting entities...';
foreach ($list as $key=>$name) { ?>
    <p></p>
    <?='Parsing '.$name.'...';?>
    <br>
    <?php
    $system = file_get_contents($name.'/system');
    echo 'The entity current system is '.$system;
    ?>
    <br>
    <?php
    if ($system == 'Metric') {
        $moneyExt = 'eur';
        $spaceExt = 'm';
    } elseif ($system == 'Imperial') {
        $moneyExt = 'usd';
        $spaceExt = 'ft';
    }
    file_put_contents($name.'/rating', '0');
    chmod($name.'/rating', 0777);
    file_put_contents($name.'/worth.'.$moneyExt, '0');
    chmod($name.'/worth.'.$moneyExt, 0777);
    file_put_contents($name.'/x.'.$spaceExt, '0');
    chmod($name.'/x.'.$spaceExt, 0777);
    file_put_contents($name.'/y.'.$spaceExt, '0');
    chmod($name.'/y.'.$spaceExt, 0777);
    file_put_contents($name.'/z.'.$spaceExt, '0');
    chmod($name.'/z.'.$spaceExt, 0777);
    file_put_contents($name.'/ammo.spare', '0');
    chmod($name.'/ammo.spare', 0777);
    file_put_contents($name.'/heal.spare', '0');
    chmod($name.'/heal.spare', 0777);
    file_put_contents($name.'/sups.spare', '0');
    chmod($name.'/sups.spare', 0777);
    file_put_contents($name.'/spec.spare', '0');
    chmod($name.'/spec.spare', 0777);
    echo 'All necessary values of entities have been reset';
    ?>
    <br>
    <?=$name.' has been fixed';?>
    <p></p>
<?php } ?>
</body>
</html>
