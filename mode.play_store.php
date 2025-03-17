<!-- playstore -->
<!-- CH: Emporium Localis; FR: Point de vente; BE: Point de vente; RO: Punctul de vânzare; MD: Punctul de vânzare; BR: Ponto de venda; PT: Ponto de venda; LK: विक्रयबिन्दुः; IN: बिक्री केन्द्र; TR: Satış noktası; ES: Punto de venta; MX: Punto de venta; IT: Punto di vendita; DE: Verkaufsstelle; AT: Verkaufsstelle; GR: Σημείο πώλησης; CY: Σημείο πώλησης; RU: Торговая точка; UA: Торгова точка; CN: 销售点; KR: 판매 시점; JP: 販売時点; AE: نقطة البيع -->
<?php $line1Size=64; foreach ($settings['get_games'] as $key=>$val) { ?>
<p align='center' class='block'>
    <a href="javascript:getPkgSequence('get -i '+gamesChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a><br>
    <?php foreach ($val as $ch) {
        $pkgID=explode('/',$ch)[count(explode('/',$ch))-1]; ?>
        <input type="button" name="<?=$ch;?>" value="<?=$ch;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="clip(this.name);">
        <input type="image" name="<?=$ch;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix.'world.png';?>"><?php if (file_exists($pkgID.'.pkg')) { ?>
            <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix.'trash.png';?>">
        <?php } else { ?>
            <input type="image" name="<?=$ch;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix.'update.png';?>">
    <?php }} ?>
</p>
<?php } ?>