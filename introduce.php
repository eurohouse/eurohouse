<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="shortcut icon" href="euro.png?rev=<?=time();?>" type="image/x-icon">
<?php $background = file_get_contents('background'); ?>
<style>
body {
  background-image: url("<?=$background;?>");
  background-size: cover;
}
</style>
<link rel="stylesheet" type="text/css" href="euro.css?rev=<?=time();?>">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js" type="text/javascript"></script>
<script src="time.js?rev=<?=time();?>"></script>
<script src="eurohmin.js?rev=<?=time();?>"></script>
