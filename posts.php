<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*.post')));
?>
<html>
<head>
<title>Blog Posts</title>
<?php include 'introduce.php'; ?>
<style>
table, td, th, tr {
  text-align: center;
}
</style>
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
</script>
</head>
<body>
<div class='desk'>
<table width="100%">
<thead>
<tr>
<th width="2%">Icon</th>
<th width="10%">Author</th>
<th width="10%">Record</th>
<th width="5%">Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($list as $key=>$value) {
$postOpen = file_get_contents($value);
$postSplit = explode(' =//= ', $postOpen);
$postTitle = $postSplit[0];
$postAuthor = $postSplit[1];
?>
    <tr>
    <td>
    <a href="euroblog.png">
    <img class=hover width=48px height=48px src="euroblog.png?rev=<?=time();?>">
    </a>
    </td>
    <td>
    <a href="<?='post.php?name='.$value;?>">
    <?=$postAuthor;?>
    </a>
    </td>
    <td>
    <a href="<?='post.php?name='.$value;?>">
    <?=$postTitle;?>
    </a>
    </td>
    <td>
    <input id="editButton" class='west' onclick="edit(this.name);" type="button" name=<?=$value;?> value="#">
    <input id="removeButton" class='south' onclick="remove(this.name);" type="button" name=<?=$value;?> value="-">
    </td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>
<?php include 'dock.php'; ?>
</body>
</html>
