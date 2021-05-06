<?php
$mode = file_get_contents('mode');
if (file_exists('noedit')) {} else {
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Switch Mode</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started';?>
<p></p>
<?='Preparing to switch the entity mode';?>
<br>
<?php
echo('The entity mode was set to '.$mode);
if ($mode == "Light") {
    $antigon = 'dark';
    $antipode = "Dark";
} elseif ($mode == "Dark") {
    $antigon = 'light';
    $antipode = "Light";
}
file_put_contents('mode', $antipode);
chmod('mode', 0777); ?>
<p></p>
<?='The entity mode is now set as '.$antipode;?>
</body>
</html>
<?php } ?>
