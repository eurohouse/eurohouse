<!-- files -->
<!-- GR: Διαχείριση αρχείων; CY: Διαχείριση αρχείων; DE: Dateimanager; AT: Dateimanager; IT: Gestore dell'archivio; CH: Administrare Documentas; FR: Gestionnaire de fichiers; BE: Gestionnaire de fichiers; ES: Administrador de archivos; MX: Administrador de archivos; PT: Gestor de arquivos; BR: Gerenciador de arquivos; NP: ཡིག་ཆའི་དོ་དམ་པ།; TR: Dosya yöneticisi; LK: सञ्चिकाप्रबन्धकः; RO: Manager de fișiere; MD: Manager de fișiere; IN: फ़ाइल मैनेजर; RU: Файловый менеджер; UA: Файловий менеджер; CN: 文件查找器; KR:  파일 찾기; JP: ファイル検索; AE: باحث الملفات -->
<?php $iconSize=45; include 'file_manager.php'; ?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:6%;">
            <?=term('Icon',$settings['vocabulary'],$session['units']);?>
        </th>
        <th style="width:18%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(2,'T');">
                <?=term('Size',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('Rights',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:8%;">
            <?=term('Actions',$settings['vocabulary'],$session['units']);?>
        </th>
    </tr>
</thead>
<tbody>
<?php
foreach ($index as $key=>$value) {
    $mediaFileTitle=$value;
    $mediaFileExtension=pathinfo($value,PATHINFO_EXTENSION);
    $mediaFileBasename=basename($value,'.'.$mediaFileExtension);
    $mediaFilename=$request['path'].'/'.$value;
    $mediaFileSize=(is_dir($mediaFilename))?dir_size($mediaFilename):filesize($mediaFilename);
    $mediaFileSizeStr=sizestr($mediaFileSize,$settings['locale']['size'],$session['units']);
    $mediaFilePerms=substr(sprintf('%o',fileperms($mediaFilename)),-4);
    ?>
    <tr>
    <?php
    if (is_dir($mediaFilename)) {
        $mediaFileFavicon=(file_exists($mediaFilename.'/favicon.png'))?$mediaFilename.'/favicon.png':$themePrefix.'directory.png';
        ?>
        <td>
            <a href="<?=$mediaFileFavicon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><a href="javascript:omniPathDir(%22<?=$mediaFilename;?>%22,requestMode.value);"><?=$mediaFileTitle;?></a></td>
        <td><?=$mediaFileSizeStr;?></td>
        <td><?=$mediaFilePerms;?></td>
        <td>
            <p align='center' class='block'>
                <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                <?php if (isUserRoot()) { ?>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="getdir('d','',this.name,'from','','here',false);" src="<?=$prefix.'trash.png';?>">
                <?php } else { ?>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                <?php } ?>
            </p>
        </td>
    <?php } else {
        if (in_array($mediaFileExtension,duplex($settings['collections']['music']))) {
            $mediaFileFavicon=$themePrefix.'music.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:omniListen(%22<?=$mediaFilename;?>%22,true);"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix.'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix.'pause.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['movie']))) { $mediaFileFavicon=$themePrefix.'movie.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:omniRead('media_player',%22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['sound']))) { $mediaFileFavicon=$themePrefix.'audio.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:omniListen(%22<?=$mediaFilename;?>%22,true);"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix.'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix.'pause.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['video']))) { $mediaFileFavicon=$themePrefix.'video.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:omniRead('media_player',%22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['midi']))) { $mediaFileFavicon=$themePrefix.'midi.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:playMIDI(%22<?=$mediaFilename;?>%22);"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="playMIDI(this.name);" src="<?=$prefix.'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="pauseMIDI();" src="<?=$prefix.'pause.png';?>">
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['font']))) { $mediaFileFavicon=$themePrefix.'font.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:omniRead('font_book',%22<?=$mediaFilename;?>%22, 'true');"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['data']))) { $mediaFileFavicon=$themePrefix.'database.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:omniPath(%22<?=$mediaFilename;?>%22,'','false');"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['script']))) { $mediaFileFavicon=$themePrefix.'script.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension, duplex($settings['collections']['book']))) { $mediaFileFavicon=$themePrefix.'book.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name, 'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['archive']))) { $mediaFileFavicon=$themePrefix.'archive.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='bfc') { $mediaFileFavicon=$themePrefix.'briefcase.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (($mediaFileExtension=='lnk')||($mediaFileExtension=='url')) { $mediaFileFavicon=$themePrefix.'link.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'false');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='pkg') {
            $mediaPkgInfo=(@json_decode(file_get_contents($mediaFileBasename.'.pkg'),true)!=null)?json_decode(file_get_contents($mediaFileBasename.'.pkg'),true):[]; $mediaPkgHost=$mediaPkgInfo['host'];
            $mediaPkgAuthor=$mediaPkgInfo['author'];
            $mediaPkgBranch=$mediaPkgInfo['branch'];
            $mediaPkgRun=(isset($mediaPkgInfo['run'])&&($mediaPkgInfo['run']!=""))?$mediaPkgInfo['run']:"index.php?mode=object_info&sort=&group=&angle=".$request['angle']."&input=".$mediaFileBasename.".pkg&output=".$request['output']."&args=&lock=false&ref=".$request['mode']."&path=".$request['path'];
            $mediaFileFavicon=(file_exists($mediaPkgInfo['favicon']))?$mediaPkgInfo['favicon']:$themePrefix.'package.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" loading="lazy" src="<?=$mediaFileFavicon;?>" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaPkgRun;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('i','<?=$mediaPkgHost;?>','from',this.name,'<?=$mediaPkgBranch;?>','<?=$mediaPkgAuthor;?>',false);" src="<?=$prefix.'update.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('d','',this.name,'from','','here',false);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif (in_array($mediaFileExtension,duplex($settings['collections']['image']))) { $mediaFileFavicon=$mediaFilename; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='mac') { $mediaFileFavicon=$themePrefix.'bash.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:executeFile(%22<?=$mediaFilename;?>%22);"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } elseif ($mediaFileExtension=='pro') { $mediaFileFavicon=$themePrefix.'speed.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="javascript:executeFile(%22<?=$mediaFilename;?>%22,'',true,true);"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php } else { $mediaFileFavicon = $themePrefix.'text.png'; ?>
            <td>
                <a href="<?=$mediaFileFavicon;?>">
                    <img style="width:<?=$iconSize;?>%;" src="<?=$mediaFileFavicon;?>" loading="lazy" onmouseover="soundButton();">
                </a>
            </td>
            <td><a href="<?=$mediaFilename;?>"><?=$mediaFileTitle;?></a></td>
            <td><?=$mediaFileSizeStr;?></td>
            <td><?=$mediaFilePerms;?></td>
            <td>
                <p align='center' class='block'>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniRead('text_editor',this.name,'true');" src="<?=$prefix.'book.png';?>">
                    <?php if (isUserRoot()) { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="recycle(this.name);" src="<?=$prefix.'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name,'','true');" src="<?=$prefix.'info.png';?>">
                    <?php } ?>
                </p>
            </td>
        <?php }
    } ?>
    </tr>
<?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="2"><?=term('Total elements:',$settings['vocabulary'],$session['units']).' '.$searchFilesCount;?></th>
        <th style="width:25%;" colspan="3"><?=$searchFilesSize;?></th>
    </tr>
</tfoot>
</table>