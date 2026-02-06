<!-- trash -->
<!-- CH: Redivivus Bin; FR: Corbeille; BE: Corbeille; RO: Coșul de reciclare; MD: Coșul de reciclare; BR: Lixeira de reciclagem; PT: Contentor; LK: पुनर्चक्रण बिन; IN: रीसायकल बिन; TR: Geri Dönüşüm Kutusu; ES: Papelera de reciclaje; MX: Papelera de reciclaje; IT: Pattumiera; DE: Papierkorb; AT: Papierkorb; GR: Σκουπίδια; CY: Σκουπίδια; RU: Корзина; UA: Кошик; CN: 回收站; KR: 휴지통; JP: ごみ箱 -->
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
    <?=$elemString;?> <?=term('(',$settings,$session).$sizeString.term(')',$settings,$session);?> <input type="button" value="<?=term('Clear',$settings,$session);?>" onmouseover="soundButton();" onclick="clearRecycleBin();"><br><?=$diskSpace;?>
</p>
<?php foreach ($recycleBinList as $val) { ?>
    <p align="center" class="block">
    <input type="button" name="<?=$recycleBinFile;?>" value="<?=$val;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPath(this.name,this.value,'false');">
    <?php if (isAuthorized()) { ?>
        <input type="image" name="<?=$val;?>" onmouseover="soundButton();" class="power" onclick="restoreFromRecycleBin(this.name);" src="<?=$prefix[3].'update.png';?>">
        <input type="image" name="<?=$val;?>" onmouseover="soundButton();" class="power" onclick="destroyFromRecycleBin(this.name);" src="<?=$prefix[3].'trash.png';?>">
    <?php } ?></p>
<?php } ?>