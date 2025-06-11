<!-- trash -->
<!-- CH: Redivivus Bin; FR: Corbeille; BE: Corbeille; RO: Coșul de reciclare; MD: Coșul de reciclare; BR: Lixeira de reciclagem; PT: Contentor; LK: पुनर्चक्रण बिन; IN: रीसायकल बिन; TR: Geri Dönüşüm Kutusu; ES: Papelera de reciclaje; MX: Papelera de reciclaje; IT: Pattumiera; DE: Papierkorb; AT: Papierkorb; GR: Κάδος Ανακύκλωσης; CY: Κάδος Ανακύκλωσης; RU: Корзина; UA: Кошик; CN: 回收站; KR: 휴지통; JP: ごみ箱; AE: إمساك الدفاتر -->
<?php
$line1Size=70;$recycleDir='./.trash/';
$recycleList=str_replace($recycleDir,'',(glob($recycleDir.'*_fragment.json')));
$elemString=term('Total elements:',$settings,$session).' '.count($recycleList);
$sizeRecBin=0; foreach ($recycleList as $val) {
    $sizeRecBin+=filesize($val);
} $sizeString=sizestr($sizeRecBin,$settings['locale']['size'],$session['units']); $diskSpace=term('Free disk space:',$settings,$session).' '.sizestr(disk_free_space('/'),$settings['locale'],$session['units']);
?>
<p align="center">
    <?=$elemString;?> <?=term('(',$settings,$session).$sizeString.term(')',$settings,$session);?> <input type="button" value="<?=term('Clear',$settings,$session);?>" onmouseover="soundButton();" onclick="getdir('d','','.trash','from','','here',false);"><br><?=$diskSpace;?>
</p>
<?php foreach ($recycleList as $val) { ?>
    <p align="center" class="block">
    <input type="button" name="<?=$recycleDir.$val;?>" value="<?=str_replace('_fragment.json', '', $val);?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPath(this.name,'','false');">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=str_replace('_fragment.json', '', $val);?>" onmouseover="soundButton();" class="power" onclick="restore(this.name);" src="<?=$prefix[3].'update.png';?>">
        <input type="image" name="<?=$recycleDir.$val;?>" onmouseover="soundButton();" class="power" onclick="del(this.name,'rw'); window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
    <?php } ?></p>
<?php } ?>