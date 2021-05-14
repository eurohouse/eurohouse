<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*', GLOB_ONLYDIR)));
if (file_exists('noedit')) {} else {
$system = file_get_contents('system');
if ($system == 'Metric') {
    $worthSign = '€';
} elseif ($system == 'Imperial') {
    $worthSign = '$';
}
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Stats</title>
<link rel="shortcut icon" href="hsis.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<style>
table, td, th, tr {
  text-align: center;
}
</style>
<script>
function upvote(id) {
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
  xmlhttp.open("POST","upvote.php?id="+id,true);
  xmlhttp.send();
}
function downvote(id) {
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
  xmlhttp.open("POST","downvote.php?id="+id,true);
  xmlhttp.send();
}
function menu(id) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       xmlhttp.open("GET",id+"/menu.php",true);
       xmlhttp.send();
    }
  };
  window.location.href = id+"/menu.php";
}
function hsis(id) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
       xmlhttp.open("GET",id+"/hsis.php",true);
       xmlhttp.send();
    }
  };
  window.location.href = id+"/hsis.php";
}
function share(id) {
  var ret = window.location.href.replace('/stat.php','');
  var copy = ret + '/' + id;
  navigator.clipboard.writeText(copy);
}
</script>
</head>
<body>
<table id="table" width="100%">
<thead>
<tr>   
<th width=2%>Icon</th> 
<th width=10%>
<a href="javascript:SortTable(1,'T');">ID</a>
</th>
<th width=6%>
<a href="javascript:SortTable(2,'N');">Worth (<?=$worthSign;?>)</a>
</th>
<th width=4%>
<a href="javascript:SortTable(3,'N');">Rating</a>
</th>
<th width=15%>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($list as $key=>$value) { ?>
<tr>
<td>
<?php
if (file_exists($value.'/favicon.png')) {
    $icon = $value.'/favicon.png';
} else {
        $icon = 'entity.png';
}
?>
<a href="<?=$icon;?>">
<img class=hover width=48px height=48px src="<?=$icon;?>?rev=<?=time();?>">
</a>
</td>
<td>
<a href="<?=$value;?>"><?=$value;?></a>
</td>
<td>
<?php
$itemSystem = file_get_contents($value.'/system');
if ($itemSystem == 'Metric' && $system == 'Metric') {
    $filename = $value.'/worth.eur';
    $content = file_get_contents($filename);
    $result = round($content, 2);
} elseif ($itemSystem == 'Imperial' && $system == 'Imperial') {
    $filename = $value.'/worth.usd';
    $content = file_get_contents($filename);
    $result = round($content, 2);
} elseif ($itemSystem == 'Metric' && $system == 'Imperial') {
    $filename = $value.'/worth.eur';
    $content = file_get_contents($filename);
    $formula = $content * 1.146;
    $result = round($formula, 2);
} elseif ($itemSystem == 'Imperial' && $system == 'Metric') {
    $filename = $value.'/worth.usd';
    $content = file_get_contents($filename);
    $formula = $content / 1.146;
    $result = round($formula, 2);
}
echo $result;
?>
</td>
<td>
<?php
$filename = $value.'/rating';
$content = file_get_contents($filename);
echo $content;
?>
</td>
<td>
<input id="downvoteButton" class='south' onclick="downvote(this.name);" type="button" title="Downvote" name=<?=$value;?> value="-" style="width:30px;">
<input id="upvoteButton" class='east' onclick="upvote(this.name);" type="button" title="Upvote" name=<?=$value;?> value="+" style="width:30px;">
<input id="menuButton" class='west' onclick="menu(this.name);" type="button" title="Menu" name=<?=$value;?> value="#" style="width:32px;">
<input id="hsisButton" class='center' onclick="hsis(this.name);" type="button" title="HSIS" name=<?=$value;?> value="H" style="width:32px;">
<input id="shareButton" class='north' onclick="share(this.name);" type="button" title="Share" name="<?=$value;?>" value=">" style="width:32px;">
</td>
</tr>
<?php } ?>
</tbody>
</table>
</body>
</html>
<?php } ?>
