<!-- appstore -->
<!-- CH: Taberna applicationum; FR: Boutique de logiciels; BE: Boutique de logiciels; RO: Magazin de software; MD: Magazin de software; BR: Loja de software; PT: Loja de software; LK: सॉफ्टवेयर स्टोर; IN: सॉफ्टवेयर स्टोर; TR: Yazılım Mağazası; ES: Tienda de software; MX: Tienda de software; IT: Negozio di software; DE: Software-Shop; AT: Software-Shop; GR: Προγράμματα; CY: Προγράμματα; RU: Магазин приложений; UA: Магазин додатків; CN: 应用商店; KR: 앱 스토어; JP: アプリストア -->
<?php $lineSize=62;
foreach ($settings['payload'][$request['mode']] as $key=>$channel) { ?>
<p align='center' class='block'>
    <a href="javascript:getPkgSequence('get -i '+updateChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a><br>
    <?php foreach ($channel as $uri=>$uris) {
        $uriPart=parse_url($uri);
	    $pkgID=array_reverse(explode('/',$uriPart['path']))[0]; ?>
        <input type="image" onmouseover="soundButton();" class="power" src="<?=$prefix[3].'package.png';?>">
        <input type="button" name="<?=$uri;?>" value="<?=$uri;?>" style="width:<?=$lineSize;?>%;" onmouseover="soundButton();" onclick="clip(this.name);">
        <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.png';?>">
        <?php if (file_exists($pkgID.'.package.json')) { ?>
            <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.png';?>">
        <?php } else { ?>
            <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.png';?>">
        <?php } ?><br><?php foreach ($uris as $mirror) {
            $mirrorUriPart=parse_url($mirror);
	        $mirrorID=array_reverse(explode('/',$mirrorUriPart['path']))[0]; ?>
            <input type="image" onmouseover="soundButton();" class="power" src="<?=$prefix[3].'link.png';?>">
            <input type="button" name="<?=$mirror;?>" value="<?=$mirror;?>" style="width:<?=$lineSize;?>%;" onmouseover="soundButton();" onclick="clip(this.name);">
            <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.png';?>">
            <?php if (file_exists($mirrorID.'.package.json')) { ?>
                <input type="image" name="<?=$mirrorID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.png';?>">
            <?php } else { ?>
                <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.png';?>">
            <?php } ?><br>
        <?php }
    } ?>
</p><?php } ?>