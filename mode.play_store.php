<!-- playstore -->
<!-- CH: Taberna applicationum tertiae partis; FR: Boutique de logiciels tiers; BE: Boutique de logiciels tiers; RO: Magazin de software terț; MD: Magazin de software terț; BR: Loja de software de terceiros; PT: Loja de software de terceiros; LK: तृतीयपक्षीय एप् स्टोर; IN: तृतीय-पक्ष ऐप स्टोर; TR: Üçüncü Taraf Yazılım Mağazası; ES: Tienda de software de terceros; MX: Tienda de software de terceros; IT: Negozio di software di terze parti; DE: Software-Shop eines Drittanbieters; AT: Software-Shop eines Drittanbieters; GR: Κατάστημα εφαρμογών τρίτων; CY: Κατάστημα εφαρμογών τρίτων; RU: Магазин сторонних приложений; UA: Магазин сторонніх додатків; CN: 第三方应用商店; KR: 타사 앱 스토어; JP: サードパーティのアプリストア; AE: متجر تطبيقات الطرف الثالث -->
<?php $line1Size=64; foreach ($settings['get_games'] as $key=>$val) { ?>
<p align='center' class='block'>
    <a href="javascript:getPkgSequence('get -i '+gamesChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a><br>
    <?php foreach ($val as $ch) {
        $pkgID=explode('/',$ch)[count(explode('/',$ch))-1]; ?>
        <input type="button" name="<?=$ch;?>" value="<?=$ch;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();" onclick="clip(this.name);">
        <input type="image" name="<?=$ch;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.png';?>"><?php if (file_exists($pkgID.'.pkg')) { ?>
            <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.png';?>">
        <?php } else { ?>
            <input type="image" name="<?=$ch;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.png';?>">
    <?php }} ?>
</p>
<?php } ?>