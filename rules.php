<?php
$dir = '.';
$files = str_replace('./','',(glob($dir.'/*.rule')));
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Code of Conduct</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?php
foreach ($files as $key=>$name) {
$value = file_get_contents($name);
$vdel = explode(' =//= ', $value);
$vheader = $vdel[0];
$vtext = $vdel[1];
?>
    <?=$vheader;?>
    <br>
    <?=$vtext;?>
    <p></p>
<?php } ?>
</body>
</html>
