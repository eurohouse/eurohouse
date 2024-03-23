<!-- directory -->
<!-- RU: Файловый проводник; CN: 文件管理器; TW: 文件管理器; JP: 文件管理器; AE: مستكشف الملفات -->
<?php
$line1Size = 35; $line2Size = 15;
$line3Size = 54; include 'file_manager.php';
foreach ($index as $key=>$value) {
    $mediaFileExtension = pathinfo($value, PATHINFO_EXTENSION);
    $mediaFileBasename = basename($value, '.'.$mediaFileExtension);
    $mediaFilename = $request['path'].'/'.$value; $mediaFileTitle = $value;
    $mediaFilePerms = substr(sprintf('%o', fileperms($mediaFilename)), -4); $mediaFileSize = filesize($mediaFilename);
    $mediaFileSizeStr = sizestr($mediaFileSize, $settings['locale']['size'], $session['units']);
    ?>
<p align='center' class='block'>
<?php if (is_dir($mediaFilename)) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'directory.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPathDir(this.name, requestMode.value);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php } else {
    if ($mediaFileExtension == 'mp3' || $mediaFileExtension == 'aac' || $mediaFileExtension == 'flac' || $mediaFileExtension == 'ogg' || $mediaFileExtension == 'wav' || $mediaFileExtension == 'snd' || $mediaFileExtension == 'au' || $mediaFileExtension == 'ac3' || $mediaFileExtension == 'oga' || $mediaFileExtension == 'wma' || $mediaFileExtension == 'mka') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'music.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniListen(this.name, true);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix.'play.png'.$suffix;?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix.'pause.png'.$suffix;?>">
<?php } elseif ($mediaFileExtension == 'mp4' || $mediaFileExtension == 'mkv' || $mediaFileExtension == 'mov' || $mediaFileExtension == 'webm' || $mediaFileExtension == 'qt' || $mediaFileExtension == 'wmv' || $mediaFileExtension == '3gp' || $mediaFileExtension == 'avi') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'film.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniRead('media_player', this.name, 'true');">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'mid' || $mediaFileExtension == 'midi' || $mediaFileExtension == 'rmi') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'midi.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="playMIDI(this.name);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="playMIDI(this.name);" src="<?=$prefix.'play.png'.$suffix;?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="pauseMIDI(this.name);" src="<?=$prefix.'pause.png'.$suffix;?>">
<?php } elseif ($mediaFileExtension == 'ttf' || $mediaFileExtension == 'otf' || $mediaFileExtension == 'ttc' || $mediaFileExtension == 'fon') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'font.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniRead('font_book', this.name, 'true');">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'json' || $mediaFileExtension == 'yaml' || $mediaFileExtension == 'yml' || $mediaFileExtension == 'xml') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'database.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPath(this.name, '', 'false');">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'pkg') {
    $mediaPkgInfo = eurarr($mediaFileBasename.'.pkg');
    $mediaPkgHost = $mediaPkgInfo['host'];
    $mediaPkgAuthor = $mediaPkgInfo['author'];
    $mediaPkgBranch = $mediaPkgInfo['branch'];
    $mediaPkgRun = (isset($mediaPkgInfo['run']) && ($mediaPkgInfo['run'] != "")) ? $mediaPkgInfo['run'] : "index.php?mode=object_info&sort=&group=&angle=".$request['angle']."&input=".$mediaFileBasename.".pkg&output=".$request['output']."&args=&lock=false&ref=".$request['mode']."&path=".$request['path']; ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'package.png'.$suffix;?>">
    <input type="button" name="<?=$mediaPkgRun;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href=this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('i', '<?=$mediaPkgHost;?>', 'from', this.name, '<?=$mediaPkgBranch;?>', '<?=$mediaPkgAuthor;?>', false);" src="<?=$prefix.'update.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('d', '', this.name, 'from', '', 'here', false);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'bmp' || $mediaFileExtension == 'dib' || $mediaFileExtension == 'gif' || $mediaFileExtension == 'ico' || $mediaFileExtension == 'cur' || $mediaFileExtension == 'ani' || $mediaFileExtension == 'jpg' || $mediaFileExtension == 'jpeg' || $mediaFileExtension == 'psd' || $mediaFileExtension == 'svg' || $mediaFileExtension == 'webp' || $mediaFileExtension == 'png' || $mediaFileExtension == 'tif' || $mediaFileExtension == 'tiff') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'image.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href=this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php } else { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'text.png'.$suffix;?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href=this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFilePerms;?>" style="width:<?=$line3Size;?>px;" onmouseover="soundButton();">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
<?php }} ?>
</p>
<?php } ?>