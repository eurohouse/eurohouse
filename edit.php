<?php
$name = $_REQUEST['name'];
if (file_exists('noedit')) {} else {
$content = file_get_contents($name);
?>
<html>
<head>
<title>Text Editor</title>
<?php include 'incl.php'; ?>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
  function create() {
  document.getElementById('filename').value = "";
  document.getElementById('content').value = "";
}
function save() {
  // Entering form data
  var name = filename.value;
  var content = encodeURIComponent(document.getElementById('content').value);
  // Assembling form data
  var dataString = 'name=' + name + '&content=' + content;
  // Requesting AJAX PHP
  $.ajax({
    type: "POST",
    url: "write.php",
    data: dataString,
    cache: false,
    success: function(html) {}
  });
  return false;
}
function mkdir(name) {
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
  }
  xmlhttp.open("POST","mkdir.php?name="+name,true);
  xmlhttp.send();
}
function move(name, to) {
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
  }
  xmlhttp.open("POST","move.php?name="+name+"&to="+to,true);
  xmlhttp.send();
}
function copy(name, to) {
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
  }
  xmlhttp.open("POST","copy.php?name="+name+"&to="+to,true);
  xmlhttp.send();
}
function remove(name) {
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
  }
  xmlhttp.open("POST","delete.php?name="+name,true);
  xmlhttp.send();
}
function info(name) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       xmlhttp.open("POST","fileinfo.php?name="+name,true);
       xmlhttp.send();
    }
  }
  window.location.href = "fileinfo.php?name="+name;
}
</script>
</head>
<body>
<form id="form" name="form">
<img class='hover' title="New" width=9% src="text.png?rev=<?=time();?>" id="newButton" onclick="create();">
<img class='hover' title="Open" width=9% src="directory.png?rev=<?=time();?>" id="filesButton" onclick="var fn = filename.value; window.location.href='edit.php?name='+fn;">
<img class='hover' title="Save" width=9% src="save.png?rev=<?=time();?>" id="saveButton" onclick="save();">
<img class='hover' title="Create Directory" width=10% src="mkdir.png?rev=<?=time();?>" id="mkdirButton" onclick="var fn = filename.value; mkdir(fn)">
<img class='hover' title="Move" width=9% src="move.png?rev=<?=time();?>" id="moveButton" onclick="var fn = filename.value; var to = content.value; move(fn,to);">
<img class='hover' title="Copy" width=9% src="copy.png?rev=<?=time();?>" id="copyButton" onclick="var fn = filename.value; var to = content.value; copy(fn,to);">
<img class='hover' title="Delete" width=9% src="delete.png?rev=<?=time();?>" id="removeButton" onclick="var fn = filename.value; remove(fn)">
<img class='hover' title="Properties" width=9% src="info.png?rev=<?=time();?>" id="infoButton" onclick="var fn = filename.value; info(fn);">
<img class='hover' title="Return to Main Menu" width=9% src="menu.png?rev=<?=time();?>" id="menuButton" onclick="window.location.href='hsis.php';">
<br>
<label>Filename: </label>
<input class="text" size=30 id="filename" style="width:80%;" type="text" value="<?=$name;?>">
<br>
<textarea class="text" id="content" style="width:100%;height:70%;">
<?=$content;?>
</textarea>
<p></p>
</form>
</body>
</html>
<?php } ?>
