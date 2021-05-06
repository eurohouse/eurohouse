<html>
<head>
<?php include 'incl.php'; ?>
<title>Date and Time</title>
<link rel="shortcut icon" href="time.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
</head>
<body onload=display_ct()>
<p align=center><span class='large' id='ct'></span></p>
<p align=center><canvas id="canvas" width="250%" height="250%" style="background-color:#333"></canvas></p>
<script src="clock.js"></script>
</body>
</html>
