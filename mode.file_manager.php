<!-- files -->
<!-- GR: Διαχείριση αρχείων; CY: Διαχείριση αρχείων; DE: Dateimanager; AT: Dateimanager; IT: Gestore dell'archivio; CH: Administrare Documentas; FR: Gestionnaire de fichiers; BE: Gestionnaire de fichiers; ES: Administrador de archivos; MX: Administrador de archivos; PT: Gestor de arquivos; BR: Gerenciador de arquivos; NP: ཡིག་ཆའི་དོ་དམ་པ།; TR: Dosya yöneticisi; LK: सञ्चिकाप्रबन्धकः; RO: Manager de fișiere; MD: Manager de fișiere; IN: फ़ाइल मैनेजर; RU: Файловый менеджер; UA: Файловий менеджер; CN: 文件查找器; KR:  파일 찾기; JP: ファイル検索; AE: باحث الملفات -->
<?php $iconSize=45; include 'file_manager.php'; ?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:8%;">
            <?=term('Icon',$settings,$session);?>
        </th>
        <th style="width:12%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$settings,$session);?>
            </a>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(2,'N');">
                <?=term('Size',$settings,$session);?>
            </a>
        </th>
        <th style="width:10%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('MIME',$settings,$session);?>
            </a>
        </th>
        <th style="width:4%;">
            <a href="javascript:SortTable(4,'N');">
                <?=term('Rights',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <?=term('Actions',$settings,$session);?>
        </th>
    </tr>
</thead>
<tbody>
<?php
foreach ($index as $key=>$value) {
    $mediaFileTitle=(path_root($request['path']))?path_trim($value):$value;
    $mediaFileExtension=pathinfo($mediaFileTitle,PATHINFO_EXTENSION);
    $mediaFileBasename=basename($mediaFileTitle,'.'.$mediaFileExtension);
    $mediaFilename=(path_root($request['path']))?'/'.path_trim($value):$request['path'].$value;
    $mediaFileSize=(is_dir($mediaFilename)&&path_rel($mediaFilename))?dir_size($mediaFilename):filesize($mediaFilename);
    $mediaFileSizeStr=sizestr($mediaFileSize,$settings['locale']['size'],$session['units']);
    $mediaFileMIME=mime_content_type($mediaFilename);
    $mediaFilePerms=substr(sprintf('%o',fileperms($mediaFilename)),-4); if (is_dir($mediaFilename)) {
        $themedIcon=$themePrefix.'directory.png'; $themedLink='javascript:omniDir(%22'.$mediaFilename.'/%22);';
    } elseif (is_link($mediaFilename)) {
        $themedIcon=$themePrefix.'link.png'; $themedLink='javascript:omniDir(%22'.$mediaFilename.'/%22);';
    } else {
        if (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['music']))) {
            $themedIcon=$themePrefix.'music.png';
            $themedLink="javascript:omniListen(%22".$mediaFilename."%22,true);";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['sound']))) {
            $themedIcon=$themePrefix.'audio.png';
            $themedLink="javascript:omniListen(%22".$mediaFilename."%22,true);";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['movie']))) {
            $themedIcon=$themePrefix.'movie.png';
            $themedLink="javascript:omniRead('media_player',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['video']))) {
            $themedIcon=$themePrefix.'video.png';
            $themedLink="javascript:omniRead('media_player',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['midi']))) {
            $themedIcon=$themePrefix.'midi.png';
            $themedLink="javascript:playMIDI(%22".$mediaFilename."%22);";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['image']))) {
            $themedIcon=(path_rel($mediaFilename))?$mediaFilename:$themePrefix.'image.png';
            $themedLink=$themedIcon;
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['font']))) {
            $themedIcon=$themePrefix.'font.png';
            $themedLink="javascript:omniRead('font_book',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['data']))) {
            $themedIcon=$themePrefix.'database.png';
            $themedLink="javascript:omniPath(%22".$mediaFilename."%22,'','false');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['script']))) {
            $themedIcon=$themePrefix.'script.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'false');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['markdown']))) {
            $themedIcon=$themePrefix.'help.png';
            $themedLink="javascript:omniRead('markdown_viewer',%22".$mediaFilename."%22,'false');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['archive']))) {
            $themedIcon=$themePrefix.'archive.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['disk_image']))) {
            $themedIcon=$themePrefix.'disk.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['book']))) {
            $themedIcon=$themePrefix.'book.png';
            $themedLink=$mediaFilename;
        } elseif ($mediaFileExtension=='pkg') {
            $mediaFileData=fileopen($mediaFilename);
            $themedLink=(isset($mediaFileData['run'])&&($mediaFileData['run']!=""))?$mediaFileData['run']:"index.php?mode=object_info&sort=&group=&angle=".$request['angle']."&input=".$mediaFilename."&output=".$request['output']."&args=&lock=false&ref=".$request['mode']."&path=".$request['path'];
            $themedIcon=(file_exists($mediaFileData['favicon']))?$mediaFileData['favicon']:$themePrefix.'package.png';
        } elseif ($mediaFileExtension=='bfc') {
            $themedIcon=$themePrefix.'briefcase.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif ($mediaFileExtension=='cab') {
            $themedIcon=$themePrefix.'cabinet.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } else {
            $themedIcon=$themePrefix.'text.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'false');";
        }
    } ?><tr>
        <td>
            <a href="<?=$themedIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$themedIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td>
            <a href="<?=$themedLink;?>"><?=$mediaFileTitle;?></a>
        </td>
        <td><?=$mediaFileSizeStr;?></td>
        <td><?=$mediaFileMIME;?></td>
        <td><?=$mediaFilePerms;?></td>
        <td>
            <p align='center' class='block'>
                <?php if (in_array($mediaFileExtension,removeFileExtDots($settings['collections']['music'].','.$settings['collections']['sound']))) { ?>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix[3].'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix[3].'pause.png';?>">
                <?php } elseif ($mediaFileExtension=='pkg') { ?>
                    <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('i','<?=$mediaFileData['host'];?>','from',this.name,'<?=$mediaFileData['branch'];?>','<?=$mediaFileData['author'];?>'); window.location.reload();" src="<?=$prefix[3].'update.png';?>">
                    <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('d','',this.name,'from','','here'); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                <?php } else { ?>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                <?php } ?>
            </p>
        </td>
    </tr>
<?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="3"><?=term('Total elements:',$settings,$session).' '.$searchFilesCount;?></th>
        <th style="width:25%;" colspan="3"><?=$searchFilesSize;?></th>
    </tr>
</tfoot>
</table>