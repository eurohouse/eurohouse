<!-- world -->
<!-- CH: Explorare Galleria; DE: Bildergalerie; AT: Bildergalerie; GR: Συλλογή Εικόνων; CY: Συλλογή Εικόνων; FR: Galerie de Photos; BE: Galerie de Photos; IT: Galleria Fotografica; ES: Galería de Imágenes; MX: Galería de Imágenes; BR: Galeria de Imagens; PT: Galeria de Imagens; RO: Galerie de Imagini; MD: Galerie de Imagini; TR: Resim Galerisi; IN: चित्र गैलरी; LK: चित्रशाला; NP: པར་རིས་འགྲེམས་སྟོན།; RU: Картинная галерея; UA: Картинна галерея; CN: 图片库; KR: 화랑; JP: 画像ギャラリー; AE: معرض الصور -->
<!-- <ref> -->
<!-- true -->
<?php
$iconSize=50; $flagSize=4; $ssLC=$settings['locale'];
$exemplarArr=exemplar(str_replace('./','',(glob('./*.models.json'))));
$contentsArr=exemplar(str_replace('./','',(glob('./*.contents.json'))));
if ($request['group']!='') {
    foreach ($contentsArr as $key=>$value) {
        if ($value!=$request['group']) { unset($contentsArr[$key]); }
    } ?>
    <table style="width:100%;" id="table">
    <thead>
    <tr>
        <th style="width:40%;"><?=term('Image',$settings,$session);?></th>
        <th style="width:5%;"><?=term('Actions',$settings,$session);?></th>
    </tr>
    </thead>
    <tbody><?php foreach ($contentsArr as $key=>$value) { ?>
    <tr>
        <td><a href="<?=$key;?>">
            <img style="width:<?=$iconSize;?>%;" src="<?=$key;?>" loading="lazy" onmouseover="soundButton();">
        </a></td>
        <td><p align='center' class='block'>
            <input type="image" name="<?=$key;?>" onmouseover="soundButton();" class="power" onclick="setdata('background',this.name);" src="<?=$prefix[3].'image.png';?>">
            <input type="image" onmouseover="soundButton();" class="power" onclick="setdata('background','');" src="<?=$prefix[3].'backspace.png';?>">
        </p></td>
    </tr><?php } ?>
</tbody>
<tfoot>
    <tr><th style="width:25%;" colspan="3">
        <?=term('Total elements:',$settings,$session).' '.count($contentsArr);?><br>
        <?=modelcard($request['group'],$contentsArr,$exemplarArr,$session,$settings)['zodiac'];?>
    </th></tr>
</tfoot>
</table>
<?php } else {
    if ($request['sort']!='') {
        if (isListLocales($request['sort'])) {
        } elseif (isListCollections($request['sort'])) {
            $exemplarArr=exemplar(str_replace('./','',(glob('./{'.$request['sort'].'}.models.json',GLOB_BRACE))));
        } else {
            $exemplarArr=searchElements($exemplarArr,$request['sort']);
        }
    } foreach ($exemplarArr as $key=>$value) {
        if ($request['sort']!='') {
            if (isListLocales($request['sort'])) {
                if (!in_array($value['country'],explode(',',$request['sort']))) { unset($exemplarArr[$key]); }
            }
        }
    } ?>
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
<p align='center' class='block'>
<input type="text" id="searchBox" style="width:62%;" placeholder="<?=term("Search certain models or objects by keywords",$settings,$session);?>" value="<?=$request['sort'];?>" onkeydown="if (event.keyCode==13) {
    omniSort(searchBox.value);
} else if (event.keyCode==27) {
    document.getElementById('searchBox').value='';
} else if (event.keyCode==8) {
    handleInput(this.value);
} else if (event.keyCode==46) {
    handleInput(this.value);
}" oninput="handleInput(this.value,true);">
<input type="image" class="power" id="buttonSearch" onmouseover="soundButton();" src="<?=$prefix[3].'search.png';?>" onclick="omniSort(searchBox.value);">
<input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('searchBox').value=''; document.getElementById('searchBox').focus();"></p>
</div>
<div class='customPanel' id='searchResults' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:<?=$flagSize;?>%;">
            <?=term('Flag',$settings,$session);?>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(2,'N');">
                <?=term('Age',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(3,'N');">
                <?=term('Days',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(4,'N');">
                <?=term('Height',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(5,'N');">
                <?=term('Weight',$settings,$session);?>
            </a>
        </th>
        <th style="width:7%;">
            <a href="javascript:SortTable(6,'N');">
                <?=term('Body Sizes',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(7,'N');">
                <?=term('Shoe Size',$settings,$session);?>
            </a>
        </th>
    </tr>
</thead>
<tbody>
<?php foreach ($exemplarArr as $key=>$value) {
    $flag=(file_exists('Flag.'.$value['country'].'.png'))?'Flag.'.$value['country'].'.png':'Flag.UN.png'; $mod=modelcard($key,$contentsArr,$exemplarArr,$session,$settings); ?>
    <tr>
        <td>
            <img style="width:60%;position:relative;" src="<?=$flag;?>" loading="lazy" onmouseover="soundButton();">
        </td>
        <td>
            <a href="javascript:omniGroup(%22<?=$key;?>%22);"><?=$mod['zodiac'];?></a>
        </td>
        <td><?=$mod['age'];?></td>
        <td><?=$mod['days'];?></td>
        <td><?=$mod['height'];?></td>
        <td><?=$mod['weight'];?></td>
        <td><?=$mod['sizes'];?></td>
        <td><?=$mod['shoe_size'];?></td>
    </tr>
<?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="7"><?=term('Total elements:',$settings,$session).' '.count($exemplarArr);?></th>
    </tr>
</tfoot>
</table>
</div>
<?php } ?>