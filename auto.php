<?php
$dir = '.';
$entities = str_replace($dir.'/','',(glob($dir.'/*', GLOB_ONLYDIR)));
$system = file_get_contents('system');
$count = count($entities);
$all = $count - 1;
$timer = 0;
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Auto Action</title>
<link rel="shortcut icon" href="auto.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<div class='window'>
<?php
$period = file_get_contents('period');
while($timer < $period) {
    $subject = $entities[rand(0, $all)];
    include 'autosubopen.php';
    $object = $entities[rand(0, $all)];
    include 'autoobjopen.php';
    $subData = $subject.'('.$subRating.'){'.$subX.';'.$subY.';'.$subZ.'} '.$subWorthSign.$subWorth.' '.$subSystem.' '.$subMode.' '.$subGender;
    echo chr(91).$timer.'/'.$period.chr(93).' '.$subData;
    ?><br>
    <?php
    include 'autosave.php';
    $timer++;
}
?>
</div>
</body>
</html>
