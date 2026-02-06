<!-- appstore -->
<!-- CH: Taberna applicationum; FR: Boutique de logiciels; BE: Boutique de logiciels; RO: Magazin de software; MD: Magazin de software; BR: Loja de software; PT: Loja de software; LK: सॉफ्टवेयर स्टोर; IN: सॉफ्टवेयर स्टोर; TR: Yazılım Mağazası; ES: Tienda de software; MX: Tienda de software; IT: Negozio di software; DE: Software-Shop; AT: Software-Shop; GR: Προγράμματα; CY: Προγράμματα; RU: Магазин приложений; UA: Магазин додатків; CN: 应用商店; KR: 앱 스토어; JP: アプリストア -->
<table style="width:100%;" id="table" class="wrapper">
<thead>
    <tr>
        <th style="width:8%;">
            <?=term('Icon',$settings,$session);?>
        </th>
        <th style="width:12%;">
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
<?php $iconSize=40;
$entryIcon=$themePrefix.'appstore.png';
foreach ($settings['payload'][$request['mode']] as $key=>$channel) { ?>
    <tr>
        <td>
            <a href="<?=$entryIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$entryIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><a href="javascript:getPkgSequence('get -i '+updateChannel<?=md5($key);?>.value,'get ',0);"><?=$key;?></a></td>
        <td><input type="image" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+updateChannel<?=md5($key);?>.value,'get ',0);" src="<?=$prefix[3].'world.png';?>"></td>
    </tr>
    <tr>
    <?php foreach ($channel as $uri=>$uris) {
        $uriPart=parse_url($uri);
	    $pkgID=array_reverse(explode('/',$uriPart['path']))[0]; $uriLink='javascript:clip(%22'.$uri.'%22);'; $themedIcon=$themePrefix.'package.png'; ?>
        <td>
            <a href="<?=$themedIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$themedIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><a href="<?=$uriLink;?>"><?=$uri;?></a></td>
        <td>
            <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.png';?>">
        <?php if (file_exists($pkgID.'.package.json')) { ?>
            <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.png';?>">
        <?php } else { ?>
            <input type="image" name="<?=$uri;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.png';?>">
        <?php } ?>
        </td>
    </tr>
    <?php foreach ($uris as $mirror) {
        $mirrorUriPart=parse_url($mirror);
	    $mirrorID=array_reverse(explode('/',$mirrorUriPart['path']))[0]; $mirrorLink='javascript:clip(%22'.$mirror.'%22);'; $themedIcon=$themePrefix.'link.png'; ?>
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
        <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'world.png';?>">
        <?php if (file_exists($mirrorID.'.package.json')) { ?>
            <input type="image" name="<?=$mirrorID;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -d '+this.name,'get ');" src="<?=$prefix[3].'trash.png';?>">
        <?php } else { ?>
            <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power" onclick="getPkgSequence('get -i '+this.name,'get ');" src="<?=$prefix[3].'update.png';?>">
        <?php } ?>
        </td>
        </tr>
    <?php }} ?>
<?php } ?>
</tbody>
</table>