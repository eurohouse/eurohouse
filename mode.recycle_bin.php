<!-- trash -->
<!-- AD: Papelera de reciclaje; AG: Papelera de reciclaje; AT: Papierkorb; BE: Corbeille; BR: Contentor; CH: Redivivus Bin; CL: Papelera de reciclaje; CN: 回收站; CO: Papelera de reciclaje; CU: Papelera de reciclaje; CY: Σκουπίδια; DD: Papierkorb; DE: Papierkorb; DR: Papierkorb; ES: Papelera de reciclaje; FR: Corbeille; GR: Σκουπίδια; IN: रीसायकल बिन; IT: Pattumiera; JP: ごみ箱; KP: 휴지통; KR: 휴지통; LK: पुनर्चक्रण बिन; MC: Corbeille; MD: Coșul de reciclare; MX: Papelera de reciclaje; PT: Contentor; RO: Coșul de reciclare; RU: Корзина; SM: Pattumiera; SP: Redivivus Bin; TR: Geri Dönüşüm Kutusu; UA: Кошик; VA: Redivivus Bin -->
<?php
$line1Size=70;
$recycleBinFile='./'.$sessionID.'_files/recycle_bin.json';
$recycleBinContent=fileopen($recycleBinFile);
$recycleBinList=getPaths($recycleBinContent);
$elemString=term('Total elements:',$settings,$session).' '.count($recycleBinList);
$sizeString=sizestr(filesize($recycleBinFile),$settings['locale']['size'],$session['units']);
$diskSpace=term('Free disk space:',$settings,$session).' '.sizestr(disk_free_space('/'),$settings['locale']['size'],$session['units']);
?>
<p align="center">
    <?=$elemString;?> <?=term('(',$settings,$session).$sizeString.term(')',$settings,$session);?> <input type="button" value="<?=term('Clear',$settings,$session);?>" onmouseover="soundButton();" onclick="recycleBin.clear();"><br><?=$diskSpace;?>
</p>
<?php foreach ($recycleBinList as $val) { ?>
    <p align="center" class="block">
    <input type="button" name="<?=$recycleBinFile;?>" value="<?=$val;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPath(this.name,this.value,'false');">
    <?php if (isAuthorized()) { ?>
        <input type="image" name="<?=$val;?>" onmouseover="soundButton();" class="power" onclick="recycleBin.restore(this.name);" src="<?=$prefix[3].'update.png';?>">
        <input type="image" name="<?=$val;?>" onmouseover="soundButton();" class="power" onclick="recycleBin.destroy(this.name);" src="<?=$prefix[3].'trash.png';?>">
    <?php } ?></p>
<?php } ?>