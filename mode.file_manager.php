<!-- files -->
<!-- GR: Διαχειριστής Αρχείων; CY: Διαχειριστής Αρχείων; DE: Dateimanager; AT: Dateimanager; IT: Gestore dell'archivio; CH: Administrare Documentas; FR: Gestionnaire de fichiers; BE: Gestionnaire de fichiers; ES: Administrador de archivos; MX: Administrador de archivos; PT: Gestor de arquivos; BR: Gerenciador de arquivos; NP: ཡིག་ཆའི་དོ་དམ་པ།; TR: Dosya yöneticisi; LK: सञ्चिकाप्रबन्धकः; RO: Manager de fișiere; MD: Manager de fișiere; IN: फ़ाइल मैनेजर; RU: Файловый менеджер; UA: Файловий менеджер; CN: 文件查找器; KR:  파일 찾기; JP: ファイル検索 -->
<?php $iconSize=45; if (strpos($request['output'],',')!==false) {
    $outputArr=explode(',',$request['output']);
    $index=[]; $bytes=0;
    foreach ($outputArr as $outputValue) {
        if (strpos($outputValue,':')!==false) {
            $strposIndex=explode(':',$outputValue);
            $outputVal=$strposIndex[0];
            $outputArg=$strposIndex[1];
        } else {
            $outputVal=$outputValue; $outputArg=null;
        } if (file_exists($outputVal.'.package.json')) {
            $pkgFileArr=pkgFiles($outputVal);
            if (count($pkgFileArr)>1) {
                unset($pkgFileArr[count($pkgFileArr)-1]);
            } if (file_exists($outputVal.'.collection.json')) {
                foreach ($pkgFileArr as $pkgOneFile) {
                    if (pathinfo($pkgOneFile,PATHINFO_EXTENSION)=='png') {
                        $indexFileParts=explode('.',$pkgOneFile);
                        if (count($indexFileParts)==4) {
                            if ($outputArg!==null) {
                                if ($indexFileParts[1]==$outputArg) {
                                    $index[]=$pkgOneFile;
                                    $bytes+=filesize($request['path'].'/'.$val);
                                }
                            } else {
                                $index[]=$pkgOneFile;$bytes+=filesize($request['path'].'/'.$val);
                            }
                        }
                    }
                }
            } else {
                foreach ($pkgFileArr as $pkgOneFile) {
                    $index[]=$pkgOneFile;
                    $bytes+=filesize($request['path'].'/'.$val);
                }
            }
        } elseif (isset($settings['collections'][$outputVal])) {
            $indexArr=str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$settings['collections'][$outputVal].'}*',GLOB_BRACE))); foreach ($indexArr as $indexFile) {
                $index[]=$indexFile;
                $bytes+=filesize($request['path'].'/'.$val);
            }
        } elseif ($outputVal=='/') {
            $indexArr=str_replace($request['path'].'/','',(glob($request['path'].'/*',GLOB_ONLYDIR)));
            foreach ($indexArr as $indexFile) {
                $index[]=$indexFile;
                $bytes+=filesize($request['path'].'/'.$val);
            }
        } else {
            $indexArr=str_replace($request['path'].'/','',(glob($request['path'].'/*'))); foreach ($indexArr as $key=>$val) {
                if (strpos(strtolower($val),strtolower($outputVal))!==false) {
                    $index[]=$val;
                    $bytes+=filesize($request['path'].'/'.$val);
                }
            }
        }
    }
} else {
    $outputValue=$request['output'];
    $index=[]; $bytes=0;
    if (strpos($outputValue,':')!==false) {
        $strposIndex=explode(':',$outputValue);
        $outputVal=$strposIndex[0]; $outputArg=$strposIndex[1];
    } else {
        $outputVal=$outputValue; $outputArg=null;
    } if (file_exists($outputVal.'.package.json')) {
        $pkgFileArr=pkgFiles($outputVal);
        if (count($pkgFileArr)>1) {
            unset($pkgFileArr[count($pkgFileArr)-1]);
        } if (file_exists($outputVal.'.collection.json')) {
            foreach ($pkgFileArr as $pkgOneFile) {
                if (pathinfo($pkgOneFile,PATHINFO_EXTENSION)=='png') {
                    $indexFileParts=explode('.',$pkgOneFile);
                    if (count($indexFileParts)==4) {
                        if ($outputArg!==null) {
                            if ($indexFileParts[1]==$outputArg) {
                                $index[]=$pkgOneFile;
                                $bytes+=filesize($request['path'].'/'.$val);
                            }
                        } else {
                            $index[]=$pkgOneFile;$bytes+=filesize($request['path'].'/'.$val);
                        }
                    }
                }
            }
        } else {
            foreach ($pkgFileArr as $pkgOneFile) {
                $index[]=$pkgOneFile;
                $bytes+=filesize($request['path'].'/'.$val);
            }
        }
    } elseif (isset($settings['collections'][$outputVal])) {
        $indexArr=str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$settings['collections'][$outputVal].'}*', GLOB_BRACE))); foreach ($indexArr as $indexFile) {
            $index[]=$indexFile;
            $bytes+=filesize($request['path'].'/'.$val);
        }
    } elseif ($outputVal=='/') {
        $indexArr=str_replace($request['path'].'/','',(glob($request['path'].'/*',GLOB_ONLYDIR))); foreach ($indexArr as $indexFile) {
            $index[]=$indexFile;
            $bytes+=filesize($request['path'].'/'.$val);
        }
    } else {
        $indexArr=str_replace($request['path'].'/','',(glob($request['path'].'/*'))); foreach ($indexArr as $key=>$val) {
            if (strpos(strtolower($val),strtolower($outputVal))!==false) {
                $index[]=$val;
                $bytes+=filesize($request['path'].'/'.$val);
            }
        }
    }
} if (!empty($index)) {
    natcasesort($index); array_unique($index);
    usort($index,function ($a,$b) {
        if ($a==$b) {
            return 0;
        } elseif (is_dir($a)&&is_dir($b)) {
            return strcmp($a,$b);
        } elseif (!is_dir($a)&&!is_dir($b)) {
            return strcmp($a,$b);
        } elseif (is_dir($a)) {
            return -1;
        } else {
            return 1;
        }
    });
} $searchFilesCount=(!empty($index))?count($index):0;
$searchFilesSize=sizestr($bytes,$settings['locale']['size'],$session['units']); ?>
<input type='hidden' id='sysDefFilesCount' value="<?=$searchFilesCount;?>">
<input type='hidden' id='sysDefFilesSize' value="<?=$searchFilesSize;?>">
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
<p align='center' class='block'>
    <input type="text" id="searchBox" style="width:62%;" placeholder="<?=term("Search certain files in the directory",$settings,$session);?>" value="<?=$request['output'];?>" onkeydown="if (event.keyCode==13) {
        omniDisp(searchBox.value);
    } else if (event.keyCode==27) {
        document.getElementById('searchBox').value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonSearch" onmouseover="soundButton();" src="<?=$prefix[3].'search.png';?>" onclick="omniDisp(searchBox.value);">
    <input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('searchBox').value=''; document.getElementById('searchBox').focus();"></p>
</div>
<div class='customPanel' id='searchResults' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
<table style="width:100%;" id="table" class="wrapper">
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
    if (is_dir($mediaFilename)) {
        $themedIcon=$themePrefix.'directory.png'; $themedLink='javascript:omniDir(%22'.$mediaFilename.'/%22);';
    } elseif (is_link($mediaFilename)) {
        $themedIcon=$themePrefix.'link.png'; $themedLink='javascript:omniDir(%22'.$mediaFilename.'/%22);';
    } else {
        if (in_array($mediaFileExtension,fileExt($settings['collections']['music']))) {
            $themedIcon=$themePrefix.'music.png';
            $themedLink="javascript:omniListen(%22".$mediaFilename."%22,true);";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['sound']))) {
            $themedIcon=$themePrefix.'audio.png';
            $themedLink="javascript:omniListen(%22".$mediaFilename."%22,true);";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['movie']))) {
            $themedIcon=$themePrefix.'movie.png';
            $themedLink="javascript:omniRead('media_player',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['video']))) {
            $themedIcon=$themePrefix.'video.png';
            $themedLink="javascript:omniRead('media_player',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['midi']))) {
            $themedIcon=$themePrefix.'midi.png';
            $themedLink="javascript:playMIDI(%22".$mediaFilename."%22);";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['image']))) {
            $themedIcon=(path_rel($mediaFilename))?$mediaFilename:$themePrefix.'image.png';
            $themedLink=$themedIcon;
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['font']))) {
            $themedIcon=$themePrefix.'font.png';
            $themedLink="javascript:omniRead('font_book',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['data']))) {
            $themedIcon=$themePrefix.'database.png';
            $themedLink="javascript:omniPath(%22".$mediaFilename."%22,'','false');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['script']))) {
            $themedIcon=$themePrefix.'script.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'false');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['markdown']))) {
            $themedIcon=$themePrefix.'help.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['archive']))) {
            $themedIcon=$themePrefix.'archive.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['disk_image']))) {
            $themedIcon=$themePrefix.'disk.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['book']))) {
            $themedIcon=$themePrefix.'book.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['briefcase']))) {
            $themedIcon=$themePrefix.'briefcase.png';
            $themedLink="javascript:omniRead('text_editor',%22".$mediaFilename."%22,'true');";
        } elseif (in_array($mediaFileExtension,fileExt($settings['collections']['cabinet']))) {
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
        <td>
            <p align='center' class='block'>
                <?php if (in_array($mediaFileExtension,fileExt($settings['collections']['music'].','.$settings['collections']['sound']))) { ?>
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniListen(this.name);" src="<?=$prefix[3].'play.png';?>">
                    <input type="image" name="<?=$mediaFilename;?>" onmouseover="soundButton();" class="power" onclick="omniPause();" src="<?=$prefix[3].'pause.png';?>">
                <?php } elseif ($mediaFileExtension=='pkg') { ?>
                    <input type="image" name="<?=$mediaFileData['host'].'/'.$mediaFileData['author'].'/'.$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get(this.name,'i','','<?=$mediaFileData['branch'];?>'); window.location.reload();" src="<?=$prefix[3].'update.png';?>">
                    <input type="image" name="<?=$mediaFileBasename;?>" onmouseover="soundButton();" class="power" onclick="get('','u',this.name); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
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
</div>