<?php
$postFile = $_REQUEST['name'];
$postOpen = file_get_contents($postFile);
$postSplit = explode(' =//= ', $postOpen);
$postTitle = $postSplit[0];
$postAuthor = $postSplit[1];
$postSubtitle = $postSplit[2];
$postMetadata = $postSplit[3];
$postPicture = $postSplit[4];
$postMusic = $postSplit[5];
$postContents = $postSplit[6];
$postRemarks = $postSplit[7];
$postLinks = $postSplit[8];
$postCredits = $postSplit[9];
$uriList = explode(' :: ', $postLinks);
$uriCount = count($uriList);
?>
<html>
<head>
<title><?=$postTitle;?></title>
<?php include 'introduce.php'; ?>
<style>
body {
  background-image: url(<?=$postPicture;?>);
}
audio {
  display: none;
}
</style>
</head>
<body>
<div class='desk'>
<p class='title' align=center><?=$postTitle;?><br>
<font class='author'><?=$postAuthor;?></font><br>
<font class='subtitle'><?=$postSubtitle;?></font></p>
<hr>
<p><?=$postContents;?></p>
<hr>
<p><?=$postRemarks;?></p>
<ol>
<?php
if ($uriCount > 0) {
    foreach ($uriList as $key=>$uriUnit) {
        $uriSplit = explode('>', $uriUnit);
        $uriName = $uriSplit[0];
        $uriLink = $uriSplit[1]; ?>
        <li><a href="<?=$uriLink;?>"><?=$uriName;?></a></li>
<?php }} ?>
</ol>
<p class='credits' align=center><?=$postCredits;?></p>
<audio id="audio" autoplay loop src="<?=$postMusic;?>">
</div>
<?php include 'dock.php'; ?>
</body>
</html>
