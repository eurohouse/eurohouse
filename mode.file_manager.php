<!-- files -->
<!-- GR: Διαχείριση αρχείων; CY: Διαχείριση αρχείων; DE: Dateimanager; AT: Dateimanager; IT: Gestore dell'archivio; CH: Administrare Documentas; FR: Gestionnaire de fichiers; BE: Gestionnaire de fichiers; ES: Administrador de archivos; MX: Administrador de archivos; PT: Gestor de arquivos; BR: Gerenciador de arquivos; NP: ཡིག་ཆའི་དོ་དམ་པ།; TR: Dosya yöneticisi; LK: सञ्चिकाप्रबन्धकः; RO: Manager de fișiere; MD: Manager de fișiere; IN: फ़ाइल मैनेजर; RU: Файловый менеджер; UA: Файловий менеджер; CN: 文件查找器; KR:  파일 찾기; JP: ファイル検索; AE: باحث الملفات -->
<?php $iconSize=45; include 'file_manager.php'; ?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:8%;">
            <?=term('Icon',$settings['vocabulary'],$session['units']);?>
        </th>
        <th style="width:12%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(2,'N');">
                <?=term('Size',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:10%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('MIME',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:4%;">
            <a href="javascript:SortTable(4,'N');">
                <?=term('Rights',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:6%;">
            <?=term('Actions',$settings['vocabulary'],$session['units']);?>
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
    $mediaFilePerms=substr(sprintf('%o',fileperms($mediaFilename)),-4);
    ?><tr>
    <?php if (is_dir($mediaFilename)) { ?>
        <td>
            <a href="<?=$themePrefix.'directory.png';?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'directory.png';?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td>
            <a href="javascript:omniPathDir(%22<?=$mediaFilename;?>/%22,requestMode.value);">
                <?=$mediaFileTitle;?>
            </a>
        </td>
        <td><?=$mediaFileSizeStr;?></td>
        <td><?=$mediaFileMIME;?></td>
        <td><?=$mediaFilePerms;?></td>
        <td>
            <p align='center' class='block'>
                <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
            </p>
        </td>
    <?php } else {
        if (in_array($mediaFileExtension,duplex($settings['collections']['music']))) { ?>
            <td>
                <a href="<?=$themePrefix.'music.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'music.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniListen(%22<?=$mediaFilename;?>%22,true);">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix[3].'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix[3].'pause.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['movie']))) { ?>
            <td>
                <a href="<?=$themePrefix.'movie.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'movie.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('media_player',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['sound']))) { ?>
            <td>
                <a href="<?=$themePrefix.'audio.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'audio.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniListen(%22<?=$mediaFilename;?>%22,true);">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix[3].'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix[3].'pause.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['video']))) { ?>
            <td>
                <a href="<?=$themePrefix.'video.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'video.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('media_player',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['midi']))) { ?>
            <td>
                <a href="<?=$themePrefix.'midi.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'midi.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:playMIDI(%22<?=$mediaFilename;?>%22);">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="playMIDI(this.name);" src="<?=$prefix[3].'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="pauseMIDI();" src="<?=$prefix[3].'pause.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['font']))) { ?>
            <td>
                <a href="<?=$themePrefix.'font.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'font.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('font_book',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['data']))) { ?>
            <td>
                <a href="<?=$themePrefix.'database.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'database.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniPath(%22<?=$mediaFilename;?>%22,'','false');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix[3].'book.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['script']))) { ?>
            <td>
                <a href="<?=$themePrefix.'script.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'script.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('text_editor',%22<?=$mediaFilename;?>%22,'false');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix[3].'book.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); wimdow.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['book']))) { ?>
            <td>
                <a href="<?=$themePrefix.'book.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'book.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="<?=$mediaFilename;?>">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['archive']))) { ?>
            <td>
                <a href="<?=$themePrefix.'archive.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'archive.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('text_editor',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='bfc') { ?>
            <td>
                <a href="<?=$themePrefix.'briefcase.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'briefcase.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('text_editor',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['link']))) { ?>
            <td>
                <a href="<?=$themePrefix.'link.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'link.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('text_editor',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='pkg') {
            $mediaPkg=basename($mediaFilename,'.pkg');
            $mediaPkgInfo=fileopen($mediaFilename);
            $mediaPkgRun=(isset($mediaPkgInfo['run'])&&($mediaPkgInfo['run']!=""))?$mediaPkgInfo['run']:"index.php?mode=object_info&sort=&group=&angle=".$request['angle']."&input=".$mediaFilename."&output=".$request['output']."&args=&lock=false&ref=".$request['mode']."&path=".$request['path']; $mediaFileFavicon=(file_exists($mediaPkgInfo['favicon']))?$mediaPkgInfo['favicon']:$themePrefix.'package.png'; ?><td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" loading="lazy" src="<?=$mediaFileFavicon;?>" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="<?=$mediaPkgRun;?>">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaPkg;?>" onmouseover="soundButton();" class="power" onclick="get('i','<?=$mediaPkgInfo['host'];?>','from',this.name,'<?=$mediaPkgInfo['branch'];?>','<?=$mediaPkgInfo['author'];?>'); window.location.reload();" src="<?=$prefix[3].'update.png';?>">
                    <input type="image" name="<?=$mediaPkg;?>" onmouseover="soundButton();" class="power" onclick="get('d','',this.name,'from','','here'); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['image']))) {
            $mediaIMG=(path_rel($mediaFilename))?$mediaFilename:$themePrefix.'image.png'; ?>
            <td>
                <a href="<?=$mediaIMG;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaIMG;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="<?=$mediaIMG;?>">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='mac') { ?>
            <td>
                <a href="<?=$themePrefix.'bash.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'bash.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:executeFile(%22<?=$mediaFilename;?>%22);">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix[3].'book.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='pro') { ?>
            <td>
                <a href="<?=$themePrefix.'speed.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'speed.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:executeFile(%22<?=$mediaFilename;?>%22,'',true,true);">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix[3].'book.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php } else { ?>
            <td>
                <a href="<?=$themePrefix.'text.png';?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$themePrefix.'text.png';?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td>
                <a href="javascript:omniRead('text_editor',%22<?=$mediaFilename;?>%22,'true');">
                    <?=$mediaFileTitle;?>
                </a>
            </td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFileMIME;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix[3].'info.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,sysDefSessionID.value); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                </p>
            </td>
        <?php }
    } ?>
    </tr>
<?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="3"><?=term('Total elements:',$settings['vocabulary'],$session['units']).' '.$searchFilesCount;?></th>
        <th style="width:25%;" colspan="3"><?=$searchFilesSize;?></th>
    </tr>
</tfoot>
</table>