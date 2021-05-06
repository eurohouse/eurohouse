<?php
$catName = $_REQUEST['name'];
$catOpen = file_get_contents($catName);
$category = basename($catName, '.poll');
$catExp = explode(' =//= ', $catOpen);
$value = $catExp[0];
$select = $catExp[1];
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Vote</title>
<link rel="shortcut icon" href="poll.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script>
function vote(id) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
    }
  }
  xmlhttp.open("POST","vote.php?id="+id,true);
  xmlhttp.send();
}
function sort(id) {
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
  xmlhttp.open("POST","sort.php?id="+id,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<?=$category.'='.$value;?>
<table id="table" width="100%">
<thead>
<tr>
<th>Icon</th>
<th>Name</th>
<th>Value</th>
<th>Rating</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$explode = explode(";", $select);
foreach($explode as $key=>$item) {
?>
<tr id="<?=$item;?>">
<td>
<a href=<?php echo $item; ?>>
<img class=hover width=48px height=48px src="
<?php
if (file_exists($item.'/favicon.png')) {
    echo $item.'/favicon.png';
} else {
    echo 'entity.png';
}
?>?rev=<?=time();?>">
</a>
</td>
<td>
<a href="<?=$item;?>">
<?php
$filename = $item.'/name';
if (file_exists($filename)) {
    $content = file_get_contents($filename);
} else {
    $content = '';
}
echo $content;
?>
</a>
</td>
<td>
<a href="<?=$item; ?>"><?=$item;?></a>
</td>
<td>
<?php
$filename = $item.'/rating';
$content = file_get_contents($filename);
echo $content;
?>
</td>
<td>
<input class="button" id="<?=$category;?>" onclick="vote(this.name);sort(this.id);" type="button" name=<?=$item;?> value="Vote">
</td>
</tr>
<?php } ?>
</tbody>
</table>
</body>
</html>
