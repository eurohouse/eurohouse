<!-- appstore -->
<!-- CH: Emporium Programmata; FR: Boutique de logiciels; BE: Boutique de logiciels; RO: Magazin de software; MD: Magazin de software; BR: Loja de software; PT: Loja de software; LK: सॉफ्टवेयर स्टोर; IN: सॉफ्टवेयर स्टोर; TR: Yazılım Mağazası; ES: Tienda de software; MX: Tienda de software; IT: Negozio di software; DE: Softwaremarkt; AT: Softwaremarkt; GR: Εμπορείο λογισμικού; CY: Εμπορείο λογισμικού; RU: Магазин приложений; UA: Магазин додатків; CN: 应用商店; KR: 앱스토어; JP: アプリストア; AE: متجر التطبيقات -->
<?php
$line1Size = 70;
foreach ($settings['payload'] as $key=>$val) {
?><p align='center'><?=$key;?><br>
<?php foreach ($val as $ch) { ?>
    <input type="button" name="<?=$ch;?>" value="<?=$ch;?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();">
    <?php
    if ((isset($_SESSION['user'])) && ($sessionID == 'root')) {
        $pkgID = explode('/', $ch)[count(explode('/', $ch))-1];
        if (file_exists($pkgID.'.pkg')) { ?>
            <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name, 'get ');" src="<?=$prefix.'delete.png'.$suffix;?>">
        <?php } else { ?>
            <input type="image" name="<?=$ch;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name, 'get ');" src="<?=$prefix.'update.png'.$suffix;?>">
        <?php }} ?>
    <?php } ?></p>
<?php } ?>