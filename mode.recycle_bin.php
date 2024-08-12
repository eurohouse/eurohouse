<!-- delete -->
<!-- CH: Redivivus Bin; FR: Corbeille; BE: Corbeille; RO: Coșul de reciclare; MD: Coșul de reciclare; BR: Lixeira de reciclagem; PT: Contentor; LK: पुनर्चक्रण बिन; IN: रीसायकल बिन; TR: Geri Dönüşüm Kutusu; ES: Papelera de reciclaje; MX: Papelera de reciclaje; IT: Pattumiera; DE: Papierkorb; AT: Papierkorb; GR: Κάδος Ανακύκλωσης; CY: Κάδος Ανακύκλωσης; RU: Корзина; UA: Кошик; CN: 回收站; KR: 휴지통; JP: ごみ箱; AE: إمساك الدفاتر -->
<?php
$line1Size = 70;
$recycleDir = str_replace('./.trash/','',(glob('./.trash/*_fragment.json')));
$sizeString = sizestr(dir_size('./.trash/'), $settings['locale']['size'], $session['units']);
?>
<p align="center"><?=$sizeString;?></p>
<?php
foreach ($recycleDir as $key=>$val) { ?>
    <p align="center" class="block">
    <input type="button" name="<?='./.trash/'.$val;?>" value="<?=str_replace('_fragment.json', '', $val);?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="omniPath(this.name,'','false');">
    <?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
        <input type="image" name="<?=str_replace('_fragment.json', '', $val);?>" onmouseover="soundButton();" class="power" onclick="restore(this.name);" src="<?=$prefix.'update.png'.$suffix;?>">
        <input type="image" name="<?='./.trash/'.$val;?>" onmouseover="soundButton();" class="power" onclick="del(this.name);" src="<?=$prefix.'delete.png'.$suffix;?>">
    <?php } ?>
    </p>
<?php } ?>