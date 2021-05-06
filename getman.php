<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*.pkg')));
$getcfg = file_get_contents('get.cfg');
$explode = explode('/', $getcfg);
$opendist = $explode[0];
$openpkg = $explode[1];
if (file_exists('noedit')) {} else {
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Get New Packages</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function get(pkg, dist) {
  pkg = document.getElementById('pkg').value;
  dist = document.getElementById('dist').value;
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       window.location.href = "hsis.php";
    }
  }
  xmlhttp.open("POST","get.php?pkg="+pkg+"&dist="+dist,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<h1>Get New Packages</h1>
<label>Package ID:</label>
<input class="text" size=30 id="pkg" style="width:60%;" type="text" value="<?=$openpkg;?>"><br>
<label>Distributor:</label>
<input class="text" size=30 id="dist" style="width:60%;" type="text" value="<?=$opendist;?>"><p>
<input class="east" type="button" style="width:250px;height:40px;" value="Submit" onclick="get();">
<input class="center" type="button" style="width:130px;height:40px;" value="Back" onclick="window.history.back();">
</body>
</html>
<?php } ?>
