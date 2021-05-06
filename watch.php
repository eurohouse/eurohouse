<?php
$filename = $_REQUEST['name'];
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Watch</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
</head>
<body>
<video style="width:100%;height:100%;" id="video" src="<?=$filename;?>" controls autoplay="yes">
</body>
</html>
