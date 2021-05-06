<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/wp.*.png')));
?>
<html>
<head>
<title>Change Background</title>
<?php include 'introduce.php'; ?>
<script>
function set(back) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      window.location.reload(true);
    }
  };
  xmlhttp.open("POST","paint.php?back="+back,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<div class='desk'>
<?php
foreach($list as $key=>$value) { ?>
<img class="hover" height=35% name="<?=$value;?>" src="<?=$value;?>?rev=<?=time();?>" onclick="set(this.name);">
<?php } ?>
</div>
<?php include 'dock.php'; ?>
</body>
</html>
