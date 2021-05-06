<?php
$str = $_REQUEST['str'];
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Application Info</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started!';?>
<br>
<?php
$string = $str;
$explode = explode(">", $str);
$link = $explode[0];
$icon = $explode[1];
$description = $explode[2];
echo('Obtaining '.$link.' app info...');
?>
<p></p>
<?=$string;?>
<p></p>
<?='Link: '.$link;?>
<br>
<?='Icon: '.$icon;?>
<br>
<?='Name: '.$description;?>
</body>
</html>
