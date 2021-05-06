<?php
$gender = file_get_contents('gender');
if (file_exists('noedit')) {} else {
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Switch Gender</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started';?>
<p></p>
<?='Preparing to switch the entity gender';?>
<br>
<?php
echo('The entity gender was set to '.$gender);
if ($gender == "Masculine") {
    $antipode = "Feminine";
} elseif ($gender == "Feminine") {
    $antipode = "Masculine";
}
file_put_contents('gender', $antipode);
chmod('gender', 0777); ?>
<p></p>
<?='The entity gender is now set as '.$antipode;?>
</body>
</html>
<?php } ?>
