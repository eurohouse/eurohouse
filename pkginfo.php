<?php
$pkg = $_REQUEST['pkg'];
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Package Info</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started';?>
<br>
<?='Obtaining '.$pkg.' package info...';?>
<p></p>
<?php
$list = file_get_contents($pkg.'.pkg');
$files = explode(";", $list);
foreach($files as $file) {
    if (strpos($file, '#') !== false) {
        $folder = str_replace('#', '', $file);
        $adddir = $folder.'/';
        echo $adddir;
    } elseif (strpos($file, '>') !== false) {
        echo $file;
    } elseif (strpos($file, '~') !== false) {
        $newfile = str_replace('~', '', $file);
        $addnew = $newfile.'*';
        echo $addnew;
    } else {
        echo $file;
    }
    ?>
    <br>
<?php } ?>
</body>
</html>
