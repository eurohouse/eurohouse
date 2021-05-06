<?php
$platform = file_get_contents('platform');
$version = file_get_contents('version');
$release = file_get_contents('release.txt');
$reldel = explode(' =//= ', $release);
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Release File</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
</head>
<body>
<h1><?=$platform;?> <?=$version;?>: What's New?</h1>
<ul>
<?php foreach ($reldel as $key=>$value) { ?>
<li>
<?=$value;?>
</li>
<?php } ?>
</ul>
</body>
</html>
