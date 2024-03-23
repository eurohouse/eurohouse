<!-- files -->
<!-- RU: Файловый менеджер; CN: 文件查找器; TW:  文件查找器; JP: 文件查找器; AE: باحث الملفات -->
<?php $preStyle = "white-space:pre-wrap;word-wrap:break-word;";
$iconSize = 50; include 'file_manager.php'; ?>
<table style="width:100%;" id="table">
<thead><tr>
<th style="width:7%;">Icon</th>
<th style="width:20%;<?=$preStyle;?>">
    <a href="javascript:SortTable(1, 'T');">Name</a>
</th>
<th style="width:8%;">
    <a href="javascript:SortTable(2, 'T');">Size</a>
</th>
<th style="width:6%;">
    <a href="javascript:SortTable(3, 'N');">Mode</a>
</th>
<th style="width:10%;">Actions</th>
</tr></thead>
<tbody>
<?php foreach ($index as $key=>$value) {
    $mediaFileTitle = $value;
    $mediaFileExtension = pathinfo($value, PATHINFO_EXTENSION);
    $mediaFileBasename = basename($value, '.'.$mediaFileExtension);
    $mediaFilename = $request['path'].'/'.$value;
    $mediaFilePerms = substr(sprintf('%o', fileperms($mediaFilename)), -4); $mediaFileSize = filesize($mediaFilename);
    $mediaFileSizeStr = sizestr($mediaFileSize, $settings['locale']['size'], $session['units']); ?>
    <tr><?php
    if (is_dir($mediaFilename)) {
    $mediaFileFavicon = (file_exists($mediaFilename.'/favicon.png')) ? $mediaFilename.'/favicon.png' : $themePrefix.'directory.png'; ?>
<td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniPathDir(%22<?=$mediaFilename;?>%22, requestMode.value);"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
<td><p align='center' class='block'>
<?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
<?php } else { ?>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
<?php } ?>
</p>
</td>
<?php
} else {
    if ($mediaFileExtension == 'mp3' || $mediaFileExtension == 'aac' || $mediaFileExtension == 'flac' || $mediaFileExtension == 'ogg') {
        $mediaFileFavicon = $themePrefix.'music.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniListen(%22<?=$mediaFilename;?>%22, true);"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix.'play.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix.'pause.png'.$suffix;?>">
    </p></td>
    <?php } elseif ($mediaFileExtension == 'mp4' || $mediaFileExtension == 'mkv' || $mediaFileExtension == 'webm') {
        $mediaFileFavicon = $themePrefix.'film.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniRead('media_player', %22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p></td>
    <?php } elseif ($mediaFileExtension == 'wav' || $mediaFileExtension == 'snd' || $mediaFileExtension == 'au' || $mediaFileExtension == 'ac3' || $mediaFileExtension == 'oga' || $mediaFileExtension == 'wma' || $mediaFileExtension == 'mka') {
        $mediaFileFavicon = $themePrefix.'music.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniListen(%22<?=$mediaFilename;?>%22, true);"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix.'play.png'.$suffix;?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix.'pause.png'.$suffix;?>">
    </p></td>
    <?php } elseif ($mediaFileExtension == 'mov' || $mediaFileExtension == 'qt' || $mediaFileExtension == 'wmv' || $mediaFileExtension == '3gp' || $mediaFileExtension == 'avi') {
    $mediaFileFavicon = $themePrefix.'film.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniRead('media_player', %22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p></td>
    <?php } elseif ($mediaFileExtension == 'mid' || $mediaFileExtension == 'midi' || $mediaFileExtension == 'rmi') {
        $mediaFileFavicon = $themePrefix.'midi.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:playMIDI(%22<?=$mediaFilename;?>%22);"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="playMIDI(this.name);" src="<?=$prefix.'play.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="pauseMIDI(this.name);" src="<?=$prefix.'pause.png'.$suffix;?>">
    </p></td>
    <?php } elseif ($mediaFileExtension == 'ttf' || $mediaFileExtension == 'otf' || $mediaFileExtension == 'ttc' || $mediaFileExtension == 'fon') {
        $mediaFileFavicon = $themePrefix.'font.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniRead('font_book', %22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p></td>
    <?php } elseif ($mediaFileExtension == 'json' || $mediaFileExtension == 'yaml' || $mediaFileExtension == 'yml' || $mediaFileExtension == 'xml') {
        $mediaFileFavicon = $themePrefix.'database.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniPath(%22<?=$mediaFilename;?>%22, '', 'false');"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p></td>
    <?php } elseif ($mediaFileExtension == 'js' || $mediaFileExtension == 'ts' || $mediaFileExtension == 'css' || $mediaFileExtension == 'csv' || $mediaFileExtension == 'htm' || $mediaFileExtension == 'html' || $mediaFileExtension == 'php' || $mediaFileExtension == 'cs' || $mediaFileExtension == 'c' || $mediaFileExtension == 'cpp' || $mediaFileExtension == 'h' || $mediaFileExtension == 'sh') {
        $mediaFileFavicon = $themePrefix.'bash.png'; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'false');" src="<?=$prefix.'book.png'.$suffix;?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } ?>
    </p>
    </td>
    <?php } elseif ($mediaFileExtension == 'poll') {
    $pollFileOpen = arropen($mediaFilename);
    $mediaFileFavicon = $themePrefix.'dice.png'; ?>
    <td>
    <a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="javascript:omniRead('online_poll', %22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td>
    <p align='center' class='block'>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p>
    </td>
    <?php } elseif ($mediaFileExtension == 'pkg') {
    $mediaPkgInfo = eurarr($mediaFileBasename.'.pkg');
    $mediaPkgHost = $mediaPkgInfo['host'];
    $mediaPkgAuthor = $mediaPkgInfo['author'];
    $mediaPkgBranch = $mediaPkgInfo['branch'];
    $mediaPkgRun = (isset($mediaPkgInfo['run']) && ($mediaPkgInfo['run'] != "")) ? $mediaPkgInfo['run'] : "index.php?mode=object_info&sort=&group=&angle=".$request['angle']."&input=".$mediaFileBasename.".pkg&output=".$request['output']."&args=&lock=false&ref=".$request['mode']."&path=".$request['path'];
    if (file_exists($mediaPkgInfo['favicon'])) {
        $mediaFileFavicon = $mediaPkgInfo['favicon'];
    } else {
        $mediaFileFavicon = $themePrefix.'package.png';
    }
    ?>
    <td>
    <a href="<?=$mediaFileFavicon;?>">
    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();">
    </a>
    </td>
    <td>
    <a style="<?=$preStyle;?>" href="<?=$mediaPkgRun;?>"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('i', '<?=$mediaPkgHost;?>', 'from', this.name, '<?=$mediaPkgBranch;?>', '<?=$mediaPkgAuthor;?>', false);" src="<?=$prefix.'update.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('d', '', this.name, 'from', '', 'here', false);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p>
    </td>
    <?php } elseif ($mediaFileExtension == 'bmp' || $mediaFileExtension == 'dib' || $mediaFileExtension == 'gif' || $mediaFileExtension == 'ico' || $mediaFileExtension == 'cur' || $mediaFileExtension == 'ani' || $mediaFileExtension == 'jpg' || $mediaFileExtension == 'jpeg' || $mediaFileExtension == 'psd' || $mediaFileExtension == 'svg' || $mediaFileExtension == 'webp' || $mediaFileExtension == 'png' || $mediaFileExtension == 'tif' || $mediaFileExtension == 'tiff') {
        $mediaFileFavicon = $mediaFilename; ?>
    <td><a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a></td><td><a style="<?=$preStyle;?>" href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td><td><?=$mediaFileSizeStr;?></td><td><?=$mediaFilePerms;?></td>
    <td><p align='center' class='block'>
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor', this.name, 'true');" src="<?=$prefix.'book.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } else { ?>
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'false');" src="<?=$prefix.'database.png'.$suffix;?>">
        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
        <?php } ?>
    </p>
    </td>
    <?php
    } else {
        $mediaFileFavicon = $themePrefix.'text.png';
    ?>
    <td>
    <a href="<?=$mediaFileFavicon;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon.$suffix;?>" onmouseover="soundButton();"></a>
    </td>
    <td>
    <a style="<?=$preStyle;?>" href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a>
    </td>
    <td><?=$mediaFileSizeStr;?></td>
    <td><?=$mediaFilePerms;?></td>
    <td>
    <p align='center' class='block'>
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name, '', 'true');" src="<?=$prefix.'info.png'.$suffix;?>">
    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    </p>
    </td>
<?php }} ?>
</tr>
<?php } ?>
</tbody>
</table>