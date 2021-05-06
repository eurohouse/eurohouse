<?php
$dir = '.';
$files = str_replace('./','',(glob($dir.'/*.q')));
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Quotes</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?php
foreach ($files as $key=>$value) { ?>
    <?=file_get_contents($value);?>
    <p></p>
<?php } ?>
</body>
</html>
