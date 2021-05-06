<?php
$name = $_REQUEST['name'];
$format = file_get_contents('format');
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>File Info</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started';?>
<br>
<?='Obtaining '.$name.' information...';?>
<p></p>
<?php echo 'Filename: '.$name; ?>
<br>
<?php
$mimetype = mime_content_type($name);
echo 'Type: '.$mimetype;
?>
<br>
<?php
$filesize = filesize($name);
echo 'Size: '.$filesize.' B';
?>
<br>
<?php
$fileperms = fileperms($name);
$filemode = substr(sprintf('%o', $fileperms), -4);
echo 'Mode: '.$filemode;
?>
<br>
<?php
$accessed = date($format, fileatime($name));
echo 'Accessed: '.$accessed;
?>
<br>
<?php
$created = date($format, filectime($name));
echo 'Created: '.$created;
?>
<br>
<?php
$modified = date($format, filemtime($name));
echo 'Modified: '.$modified;
?>
<br>
</body>
</html>
