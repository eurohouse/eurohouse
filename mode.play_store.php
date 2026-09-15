<!-- playstore -->
<!-- AD: Tienda de juegos; AG: Tienda de juegos; AT: Spieleladen; BE: Magasin de jeux; BR: Loja de Jogos; CH: Taberna Ludorum; CL: Tienda de juegos; CN: 游戏商店; CO: Tienda de juegos; CU: Tienda de juegos; CY: Παιχνίδια; DD: Spieleladen; DE: Spieleladen; DR: Spieleladen; ES: Tienda de juegos; FR: Magasin de jeux; GR: Παιχνίδια; IN: खेल की दुकान; IT: Negozio di giochi; JP: ゲームストア; KP: 게임 스토어; KR: 게임 스토어; LK: गेम स्टोर; MC: Magasin de jeux; MD: Magazin de jocuri; MX: Tienda de juegos; NP: རྩེད་མོའི་ཚོང་ཁང་།; PT: Loja de Jogos; RO: Magazin de jocuri; RU: Магазин игр; SM: Negozio di giochi; SP: Taberna Ludorum; TR: Oyun Mağazası; UA: Магазин ігор; VA: Taberna Ludorum -->
<table style="width:100%;" id="table" class="wrapper">
<thead>
    <tr>
        <th style="width:8%;">
            <?=term('Icon',$settings,$session);?>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('URL',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <?=term('Actions',$settings,$session);?>
        </th>
    </tr>
</thead>
<tbody>
<?php $iconSize=30;
$entryIcon=$themePrefix.'playstore.webp';
foreach ($settings['payload'][$request['mode']] as $key=>$channel) { ?>
    <tr>
        <td>
            <a href="<?=$entryIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$entryIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><a href="javascript:getPkgSequence('get -i '+downloadChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a></td>
        <td><input type="image" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+downloadChannel<?=md5($key);?>.value,'get ',0);" src="<?=$prefix[3].'world.webp';?>"></td>
    </tr>
    <tr>
    <?php foreach ($channel as $uri=>$uris) {
        $uriPart=parse_url($uri);
	    $pkgID=array_reverse(explode('/',$uriPart['path']))[0]; $uriLink='javascript:clip(%22'.$uri.'%22);'; $themedIcon=$themePrefix.'package.webp'; ?>
        <td>
            <a href="<?=$themedIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$themedIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><a href="<?=$uriLink;?>"><?=$uri;?></a></td>
        <td>
            <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.webp';?>">
        <?php if (file_exists($pkgID.'.package.json')) { ?>
            <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.webp';?>">
        <?php } else { ?>
            <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.webp';?>">
        <?php } ?>
        </td>
    </tr>
    <?php foreach ($uris as $mirror) {
        $mirrorUriPart=parse_url($mirror);
	    $mirrorID=array_reverse(explode('/',$mirrorUriPart['path']))[0]; $mirrorLink='javascript:clip(%22'.$mirror.'%22);'; $themedIcon=$themePrefix.'link.webp'; ?>
        <tr>
        <td>
            <a href="<?=$themedIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$themedIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td>
            <a href="<?=$mirrorLink;?>"><?=$mirror;?></a>
        </td>
        <td>
        <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.webp';?>">
        <?php if (file_exists($mirrorID.'.package.json')) { ?>
            <input type="image" name="<?=$mirrorID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.webp';?>">
        <?php } else { ?>
            <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.webp';?>">
        <?php } ?>
        </td>
        </tr>
    <?php }} ?>
<?php } ?>
</tbody>
</table>