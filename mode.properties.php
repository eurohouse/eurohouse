<!-- info -->
<!-- GR: Ταξινόμηση; DE: Objekteigenschaften; AT: Objekteigenschaften; CY: Ταξινόμηση; FR: Propriétés; BE: Propriétés; CH: Notitias Objectum; IT: Proprietà; RU: Свойства; LK: वस्तुगुणाः; IN: वस्तु गुण; ES: Propiedades; MX: Propiedades; PT: Propriedades; BR: Propriedades; RO: Proprietățile; MD: Proprietățile; NP: དངོས་པོའི་ཁྱད་ཆོས།; RS: Својства објекта; UA: Властивості об'єкту; TR: Nesne özellikleri; CN: 文件信息和属性; KR: 파일정보; JP: ファイル情報 -->
<!-- <ref> -->
<!-- true -->
<?php
if ($request['lock']!='false') {
    if ((path_root($request['input']))||($request['input']=='')) {
        $objFile=[
            'free_disk_space'=>sizestr(disk_free_space('/'),$settings['locale']['size'],$session['units']),
            'server_ip'=>$_SERVER['SERVER_ADDR'],
            'remote_ip'=>$_SERVER['REMOTE_ADDR'],
            'uname'=>[
                'a'=>php_uname('a'),'m'=>php_uname('m'),
                'n'=>php_uname('n'),'r'=>php_uname('r'),
                's'=>php_uname('s'),'v'=>php_uname('v'),
            ]
        ];
    } elseif ((is_dir($request['input']))&&(!is_link($request['input']))) {
        $objFile=[
            'name'=>$request['input'],
            'type'=>filetype($request['input']),
            'size'=>dir_size($request['input']),
            'mode'=>substr(sprintf('%o',fileperms($request['input'])),-4)
        ];
    } else {
        $objFile=[
            'name'=>$request['input'],
            'type'=>filetype($request['input']),
            'size'=>filesize($request['input']),
            'mode'=>substr(sprintf('%o',fileperms($request['input'])),-4)
        ];
    }
} else {
    $objFile=fileopen($request['input']);
} if ($request['args']!='') {
    if (strpos($request['args'],'/')!==false) {
        $objReadyArgs=explode('/',$request['args']);
        $objReadyTab=$objFile; $objReadyScope=$objFile;
        foreach ($objReadyArgs as $objReadyArg) {
            $objReadyScope=$objReadyTab[$objReadyArg];
            $objReadyTab=$objReadyScope;
        } $objReadyData=$objReadyScope;
    } else {
        $objReadyScope=$objFile[$request['args']];
        $objReadyData=$objReadyScope;
    }
} else {
    $objReadyData=$objFile;
} if (is_array($objReadyData)) { ?>
    <p align='center' class='block'>
        <input class="text" id="objDataFile" style="width:30%;" type="text" placeholder="<?=term('Name',$settings,$session);?>" value="<?=$request['input'];?>" onkeydown="if (event.keyCode==13) { omniPath(objDataFile.value,objDataPath.value,'false');
        } else if (event.keyCode==27) { this.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input class="text" id="objDataPath" style="width:30%;" type="text" placeholder="<?=term('Path',$settings,$session);?>" value="<?=$request['args'];?>" onkeydown="if (event.keyCode==13) { omniPath(objDataFile.value,objDataPath.value,'false');
        } else if (event.keyCode==27) { this.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" class="power" onclick="omniPath(objDataFile.value,objDataPath.value,'false');" src="<?=$prefix[3].'open.png';?>">
        <input type="image" onmouseover="soundButton();" class="power" onclick="data(objDataFile.value,'add',objDataPath.value,objDataValue.value,((superuser())?'rw':sysDefSessionID.value),'r');" src="<?=$prefix[3].'save.png';?>"><br>
        <input class="text" id="objDataValue" style="width:60%;" type="text" placeholder="<?=term('Value',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
            data(objDataFile.value,'add',objDataPath.value,objDataValue.value,((superuser())?'rw':sysDefSessionID.value),'r');
        } else if (event.keyCode==27) { this.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="image" onmouseover="soundButton();" class="power" onclick="data(objDataFile.value,'pack',objDataPath.value,objDataValue.value,((superuser())?'rw':sysDefSessionID.value),'r');" src="<?=$prefix[3].'plus.png';?>">
        <input type="image" onmouseover="soundButton();" class="power" onclick="data(objDataFile.value,'unpack',objDataPath.value,objDataValue.value,((superuser())?'rw':sysDefSessionID.value),'r');" src="<?=$prefix[3].'min.png';?>">
    </p><?php
    foreach ($objReadyData as $key=>$value) {
        $goArg=($request['args']!='')?$request['args'].'/'.$key:$key;
    ?><p align='center'>
    <input type="button" name="<?=$goArg;?>" value="<?=$key;?>" style="width:30%;" onmouseover="soundButton();" onclick="omniPath(requestInput.value,this.name,requestLock.value);">
    <input type="button" name="<?=$goArg;?>" value="<?=$value;?>" style="width:50%;" onmouseover="soundButton();" onclick="omniPath(requestInput.value,this.name,requestLock.value);">
    <?php if ($request['lock']=='false') { ?>
    <input type="image" name="<?=$goArg;?>" onmouseover="soundButton();" class="power" onclick="data(objDataFile.value,'drop',this.name,objDataValue.value,((superuser())?'rw':sysDefSessionID.value),'r');" src="<?=$prefix[3].'trash.png';?>">
    <?php } ?>
</p><?php }
} else { ?>
<p align='center'><?=$objReadyData;?></p>
<?php } ?>