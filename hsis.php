<?php
$dir = '.';
$platform = file_get_contents('platform');
$version = file_get_contents('version');
if (file_exists('noedit')) { ?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Unlock This Entity</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function unlock() {
  var password = document.getElementById("pass").value;
  var dataString = 'password=' + password;
  $.ajax({
    type: "POST",
    url: "lock.php",
    data: dataString,
    cache: false,
    success: function(html) {
        window.location.href = 'hsis.php';
    }
  });
  return false;
}
</script>
</head>
<body>
<h1 align=center>
<img class='hover' style="height:64px;" src='security.png?rev=<?=time();?>'>
Unlock This Entity</h1>
<p align=center>
<label>Enter password: </label>
<input class="text" type='password' placeholder="Type the password" id="pass" style="width:295px;" value="" onkeydown="if (event.keyCode == 13) { unlock(); }">
<input class="east" id="unlock" onclick="unlock();" type="button" value=">">
</p>
</div>
</body>
</html>
<?php } else { ?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>HSIS</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function search(q) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       xmlhttp.open("GET","find.php?q="+q,true);
       xmlhttp.send();
    }
  };
  window.location.href = "find.php?q="+q;
}
</script>
</head>
<body>
<h1>Welcome to HSIS Menu</h1>
<label>Find: </label>
<input class='searchbar' autofocus type='text' id='find' value="" onkeydown="if (event.keyCode == 13) {
  window.location.href='search.php?q='+document.getElementById('find').value;
}">
<p>
<a class="large" href="stat.php">Stats</a>
<a class="large" href="reg.php">Register</a>
<a class="large" href="info.php">Info</a>
<a class="large" href="apps.php">Apps</a>
<a class="large" href="packages.php">Packages</a>
<a class="large" href="getman.php">Get</a>
<a class="large" href="setup.php">Setup</a>
</p>
<p>
<a class="large" href="convert.php">Convert</a>
<a class="large" href="switch.php">Switch</a>
<a class="large" href="gender.php">Gender</a>
<a class="large" href="edit.php?name=new">Edit</a>
<a class="large" href="beside.php">Beside</a>
<a class="large" href="start.php">Platform</a>
</p>
<p>Current platform installed: <?=$platform.' '.$version;?> (<a href="release.php">See Release file</a>)</p>
</body>
</html>
<?php } ?>
