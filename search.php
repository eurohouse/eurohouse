<?php
$index = $_REQUEST['q'];
$dir = '.';
if (file_exists('noedit')) {} else {
    $list = str_replace($dir.'/','',(glob($dir.'/*'.$index.'*')));
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Search</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script src='http://www.midijs.net/lib/midi.js'></script>
<style>
table, td, th, tr {
  text-align: center;
}
</style>
<style>
audio {
  display: none;
}
</style>
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
<script>
function edit(name) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       xmlhttp.open("POST","edit.php?name="+name,true);
       xmlhttp.send();
    }
  }
  window.location.href = "edit.php?name="+name;
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
<script>
function play(id) {
  var x = document.getElementById("audio");
  x.src = id;
  x.play();
}
function pause(id) {
  var x = document.getElementById("audio");
  x.pause();
}
</script>
<script>
function playMIDI(id) {
  MIDIjs.play(id);
}
function pauseMIDI(id) {
  MIDIjs.pause(id);
}
</script>
</head>
<body>
<label>Find: </label>
<input class='searchbar' autofocus type='text' id='find' value="" onkeydown="if (event.keyCode == 13) {
  window.location.href='search.php?q='+document.getElementById('find').value;
}">
<table id="table" width="100%">
<thead>
<tr>
<th width=1%>Icon</th>
<th width=2%>
<a href="javascript:SortTable(1,'T');">Filename</a>
</th>
<th width=6%>
<a href="javascript:SortTable(2,'T');">Type</a>
</th>
<th width=4%>
<a href="javascript:SortTable(3,'N');">Size</a>
</th>
<th width=15%>Actions</th>
</tr>
</thead>
<tbody>
<?php
foreach ($list as $key=>$value) {
    include 'find.php'; ?>
    <tr>
    <td>
    <a href="<?=$icon;?>">
    <img class=hover width=48px height=48px src="<?=$icon;?>?rev=<?=time();?>">
    </a>
    </td>
    <td>
    <a href="<?=$link;?>">
    <?=$value;?>
    </a>
    </td>
    <td>
    <?=$type;?>
    </td>
    <td>
    <?=$filesize;?>
    </td>
    <td>
    <input id='editButton' class='west' title="Edit" name="<?=$value;?>" type="button" value="#" onclick="edit(this.name);" style="width:32px;">
    <input id='infoButton' class='center' title="Info" name="<?=$value;?>" type="button" value="i" onclick="info(this.name);" style="width:32px;">
    <input id='removeButton' class='south' title="Remove" name="<?=$value;?>" type=<?php
    if (file_exists($value.'.lock')) {
        $showmode = "hidden";
    } else {
        $showmode = "button";
    }
    echo $showmode;
    ?> value="-" onclick="remove(this.name);window.location.reload();" style="width:32px;">
    </td>
    </tr>
<?php } ?>
</tbody>
</table>
<audio id="audio">
</body>
</html>
<?php } ?>
