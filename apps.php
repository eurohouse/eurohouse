<?php
if (file_exists('noedit')) {} else {
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Applications</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function add(str) {
  var str = encodeURIComponent(str);
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.location.reload();
    }
  };
  xmlhttp.open("POST","add.php?str="+str,true);
  xmlhttp.send();
}
function remove(str) {
  var str = encodeURIComponent(str);
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.location.reload();
    }
  };
  xmlhttp.open("POST","rem.php?str="+str,true);
  xmlhttp.send();
}
function info(str) {
  var str = encodeURIComponent(str);
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       xmlhttp.open("POST","appinfo.php?str="+str,true);
       xmlhttp.send();
    }
  }
  window.location.href = "appinfo.php?str="+str;
}
</script>
</head>
<body>
<div class='frontrow'>
<h1 align=center>Applications</h1>
<p>
<label>Add app link: </label>
<input class="text" id="name" type="text" placeholder="filename>iconname>appname" style="width:60%;">
<input type='button' class='east' id="addButton" onclick="var stri = document.getElementById('name').value; add(stri); location.reload;" value="+" style="width:30px;">
</p>
</div>
<div class='appline'>
<?php
$apps = file_get_contents('apps.list');
$appslist = explode(";", $apps);
foreach ($appslist as $key=>$string) {
    $strparts = explode(">", $string);
    $filelink = $strparts[0];
    $iconlink = $strparts[1];
    $namelink = $strparts[2];
    $partscount = count($strparts);
    $str = $string;
?>
<p align=center>
<div class="icon">
<a href="<?=$filelink;?>">
<img style="height: 92px;" class="hover" title="<?=$namelink;?>" src="<?=$iconlink;?>?rev=<?=time();?>">
</a>
<p align=center>
<input class='south' name="<?=$str;?>" type=
<?php
if ($partscount == 3) {
    $showmode = "button";
} else {
    $showmode = "hidden";
}
echo $showmode;
?> id="removeButton" onclick="remove(this.name);" value="-" style="width:30px;">
<input id='infoButton' class='west' name="<?=$str;?>" type='button' onclick="info(this.name);" value="i" style="width:30px;">
</p>
</div>
<?php } ?>
</p>
</div>
</body>
</html>
<?php } ?>
