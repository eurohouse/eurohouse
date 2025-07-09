<!-- appstore -->
<!-- CH: Taberna applicationum; FR: Boutique de logiciels; BE: Boutique de logiciels; RO: Magazin de software; MD: Magazin de software; BR: Loja de software; PT: Loja de software; LK: सॉफ्टवेयर स्टोर; IN: सॉफ्टवेयर स्टोर; TR: Yazılım Mağazası; ES: Tienda de software; MX: Tienda de software; IT: Negozio di software; DE: Software-Shop; AT: Software-Shop; GR: Κατάστημα λογισμικού; CY: Κατάστημα λογισμικού; RU: Магазин приложений; UA: Магазин додатків; CN: 应用商店; KR: 앱 스토어; JP: アプリストア; AE: متجر التطبيقات -->
<?php $line1Size=64; foreach ($settings['payload'][$request['mode']] as $key=>$val) { ?>
<p align='center' class='block'>
    <a href="javascript:getPkgSequence('get -i '+updateChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a><br>
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