<?php
$name = $_REQUEST['name'];
if (file_exists('noedit')) {} else {
$slot = file_get_contents($name);
$list = explode(';', $slot);
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Slot Menu</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
</head>
<body>
<?php
foreach ($list as $key=>$value) {
$piece = explode('>', $value);
$link = $piece[0];
$title = $piece[1];
?>
<a class="large" href="<?=$link;?>"><?=$title;?></a>
<br>
<?php } ?>
</body>
</html>
<?php } ?>
