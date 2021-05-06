<?php
if (file_exists('noedit')) {} else {
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>HSIS Beside Utility</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function secure() {
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
function kill() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      window.location.href = "../hsis.php";
    }
  };
  xmlhttp.open("POST","kill.php",true);
  xmlhttp.send();
}
</script>
</head>
<body>
<h1><img class='hover' style="height:64px;" src='security.png?rev=<?=time();?>'>
Security Zone</h1>
<form id="form" name="form">
<label>Enter password: </label>
<input class="text" type='password' placeholder="Type your password" id="pass" style="width:295px;" value="" onkeydown="if (event.keyCode == 13) { secure(); }">
<p></p>
<input class="east" id="submit" style="width:130px;height:40px;" onclick="secure();" type="button" value="Secure">
<input class="center" id="back" style="width:130px;height:40px;" onclick="window.history.back();" type="button" value="Back">
</form>
<h1 class='red'><img class='hover' style="height:64px;" src='danger.png?rev=<?=time();?>'>
DANGER ZONE!</h1>
<p class='red'>WARNING! This will completely DESTROY ALL DATA in this directory including the directory herself. PROCEED ONLY IF you don't need this profile anymore, have no personal data and documents saved there or have created it by mistake. Be careful when you make such decision and make sure you know what you're doing!</p>
<input class="south" id="remove" style="width:130px;height:40px;" onclick="kill();" type="button" value="Remove">
<input class="center" id="back" style="width:130px;height:40px;" onclick="window.history.back();" type="button" value="Back">
</body>
</html>
<?php } ?>
