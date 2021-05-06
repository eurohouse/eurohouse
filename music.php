<?php
$dir = '.';
$list = str_replace($dir.'/','',(glob($dir.'/*.flac')));
?>
<html>
<head>
<title>Music</title>
<?php include 'introduce.php'; ?>
<style>
table, td, th, tr {
  text-align: center;
}
</style>
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
</head>
<body>
<div class='desk'>
<table width="100%">
<thead>
<tr>
<th width="2%">Icon</th>
<th width="10%">Filename</th>
<th width="5%">Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($list as $key=>$value) { ?>
    <tr>
    <td>
    <a href="euromusic.png">
    <img class=hover width=48px height=48px src="euromusic.png?rev=<?=time();?>">
    </a>
    </td>
    <td>
    <a href=<?=$value;?>>
    <?=$value;?>
    </a>
    </td>
    <td>
    <input id="playButton" class='east' onclick="play(this.name);" type="button" name=<?=$value;?> value=">">
    <input id="pauseButton" class='south' onclick="pause(this.name);" type="button" name=<?=$value;?> value="II">
    </td>
    </tr>
<?php } ?>
</tbody>
</table>
<audio id="audio">
</div>
<?php include 'dock.php'; ?>
</body>
</html>
