<!-- playstore -->
<!-- CH: Taberna Ludorum; FR: Magasin de jeux; BE: Magasin de jeux; RO: Magazin de jocuri; MD: Magazin de jocuri; BR: Loja de Jogos; PT: Loja de Jogos; LK: गेम स्टोर; IN: खेल की दुकान; NP: རྩེད་མོའི་ཚོང་ཁང་།; TR: Oyun Mağazası; ES: Tienda de juegos; MX: Tienda de juegos; IT: Negozio di giochi; DE: Spieleladen; AT: Spieleladen; GR: Παιχνίδια; CY: Παιχνίδια; RU: Магазин игр; UA: Магазин ігор; CN: 游戏商店; KR: 게임 스토어; JP: ゲームストア -->
<?php $lineSize=62;
foreach ($settings['payload'][$request['mode']] as $key=>$channel) { ?>
<p align='center' class='block'>
    <a href="javascript:getPkgSequence('get -i '+downloadChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a><br>
    <?php foreach ($channel as $uri=>$uris) {
        $uriPart=parse_url($uri);
	    $pkgID=array_reverse(explode('/',$uriPart['path']))[0]; ?>
        <input type="image" onmouseover="soundButton();" class="power" src="<?=$prefix[3].'package.png';?>">
        <input type="button" name="<?=$uri;?>" value="<?=$uri;?>" style="width:<?=$lineSize;?>%;" onmouseover="soundButton();" onclick="clip(this.name);">
        <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.png';?>"><?php if (file_exists($pkgID.'.package.json')) { ?>
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