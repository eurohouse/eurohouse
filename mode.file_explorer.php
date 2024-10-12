<!-- directory -->
<!-- GR: Εξερεύνηση αρχείων; CY: Εξερεύνηση αρχείων; DE: Datei-Explorer; CH: Explorare Documentas; AT: Datei-Explorer; IT: Esplora risorse; FR: Explorateur de fichiers; BE: Explorateur de fichiers; ES: Explorador de archivos; RU: Файловый проводник; TR: Dosya Gezgini; LK: सञ्चिका अन्वेषकः; IN: फाइल ढूँढने वाला; NP: ཡིག་ཆ་འཚོལ་ཞིབ་ཆས།; RO: Explorator de fișiere; MD: Explorator de fișiere; BR: Explorador de arquivos; PT: Explorador de ficheiros; MX: Explorador de archivos; UA: Файловий провідник; CN: 文件管理器; KR: 파일 관리자; JP: ファイル管理; AE: مستكشف الملفات -->
<?php $line1Size = 64; $line2Size = 16;
include 'file_manager.php'; foreach ($index as $key=>$value) {
    $mediaFileExtension = pathinfo($value, PATHINFO_EXTENSION);
    $mediaFileBasename = basename($value, '.'.$mediaFileExtension);
    $mediaFilename = $request['path'].'/'.$value; $mediaFileTitle = $value;
    $mediaFileSize = filesize($mediaFilename);
    $mediaFileSizeStr = sizestr($mediaFileSize, $settings['locale']['size'], $session['units']); ?>
<p align='center' class='block'>
<?php if (is_dir($mediaFilename)) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'directory.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPathDir(this.name, requestMode.value);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } else {
    if ((in_array($mediaFileExtension, duplex($settings['collections']['music']))) || (in_array($mediaFileExtension, duplex($settings['collections']['audio'])))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'audio.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniListen(this.name, true);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix.'play.png';?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix.'pause.png';?>">
<?php } elseif ((in_array($mediaFileExtension, duplex($settings['collections']['movie']))) || (in_array($mediaFileExtension, duplex($settings['collections']['video'])))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'video.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniRead('media_player', this.name, 'true');">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['midi']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'midi.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="playMIDI(this.name);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="playMIDI(this.name);" src="<?=$prefix.'play.png';?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="pauseMIDI();" src="<?=$prefix.'pause.png';?>">
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['font']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'font.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniRead('font_book', this.name, 'true');">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['data']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'database.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPath(this.name, '', 'false');">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['script']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'script.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href = this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['book']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'book.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href = this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['archive']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'archive.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href = this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'bfc') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'briefcase.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href = this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (($mediaFileExtension == 'lnk') || ($mediaFileExtension == 'url')) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'link.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href = this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'pkg') {
    $mediaPkgInfo = (@json_decode(file_get_contents($mediaFileBasename.'.pkg'), true) != null) ? json_decode(file_get_contents($mediaFileBasename.'.pkg'), true) : [];
    $mediaPkgHost = $mediaPkgInfo['host'];
    $mediaPkgAuthor = $mediaPkgInfo['author'];
    $mediaPkgBranch = $mediaPkgInfo['branch'];
    $mediaPkgRun = (isset($mediaPkgInfo['run']) && ($mediaPkgInfo['run'] != "")) ? $mediaPkgInfo['run'] : "index.php?mode=object_info&sort=&group=&angle=".$request['angle']."&input=".$mediaFileBasename.".pkg&output=".$request['output']."&args=&lock=false&ref=".$request['mode']."&path=".$request['path']; ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'package.png';?>">
    <input type="button" name="<?=$mediaPkgRun;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href=this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('i', '<?=$mediaPkgHost;?>', 'from', this.name, '<?=$mediaPkgBranch;?>', '<?=$mediaPkgAuthor;?>', false);" src="<?=$prefix.'update.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('d', '', this.name, 'from', '', 'here', false);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['image']))) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'image.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href=this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'mac') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'bash.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="executeFile(this.name);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } elseif ($mediaFileExtension == 'pro') { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'speed.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="executeFile(this.name, '', true, true);">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php } else { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" src="<?=$prefix.'text.png';?>">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileTitle;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="window.location.href=this.name;">
    <input type="button" name="<?=$mediaFilename;?>" value="<?=$mediaFileSizeStr;?>" style="width:<?=$line2Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png';?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'delete.png';?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
<?php }} ?></p>
<?php } ?>