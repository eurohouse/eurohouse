<!-- world -->
<!-- CH: Explorare Europedia; DE: Entdecken Sie Europedia; AT: Entdecken Sie Europedia; GR: Εξερευνήστε Ευρωπαιδεία; CY: Εξερευνήστε Ευρωπαιδεία; FR: Parcourir Europedia; BE: Parcourir Europedia; IT: Sfoglia Europadia; ES: Explora Europadia; MX: Explora Europadia; BR: Explorar a Europadia; PT: Explorar a Europadia; RO: Explorați Europedia; MD: Explorați Europedia; TR: Europedia'yı keşfedin; IN: यूरोपियाडिया का अन्वेषण करें; LK: यूरोपडिया अन्वेषणं कुर्वन्तु; NP: ཡོ་རོབ་གླིང་ལ་མྱུལ་ཞིང༌།; RU: Просмотр Европедии; UA: Досліджуйте Europedia; CN: 浏览元素 Europedia; KR: 요소 찾아보기 Europedia; JP: 要素の閲覧 Europedia; AE: تصفح عناصر Europedia -->
<!-- <ref> -->
<!-- true -->
<?php
$iconSize=50; $flagSize=2**(1+($session['nsfw']));
$ssLC=$settings['locale'];
$exemplarArr=exemplar(str_replace('./','',(glob('./*.models.json'))));
$contentsArr=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$ssUN=$session['units'];
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
            <input type="image" name="<?=$key;?>" onmouseover="soundButton();" class="power" onclick="setdata('banner',this.name);" src="<?=$prefix[3].'return.png';?>">
            <input type="image" onmouseover="soundButton();" class="power" onclick="setdata('banner','');" src="<?=$prefix[3].'backspace.png';?>">
        </p></td>
    </tr><?php } ?>
</tbody>
<tfoot>
    <tr><th style="width:25%;" colspan="3">
        <?=term('Total elements:',$settings,$session).' '.count($contentsArr);?><br>
        <?=modelcard($request['group'],$contentsArr,$exemplarArr,$session,$settings)['line'];?>
    </th></tr>
</tfoot>
</table>
<?php } else {
    foreach ($exemplarArr as $key=>$value) {
        if ($request['sort']=='nsfw') {
            if (!isset($value['nsfw'])) { unset($exemplarArr[$key]); }
        } elseif ($request['sort']=='safe') {
            if (isset($value['nsfw'])) { unset($exemplarArr[$key]); }
        }
    } ?>
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
        <th style="width:9%;">
            <a href="javascript:SortTable(2,'N');">
                <?=term('Age',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(3,'N');">
                <?=term('Height',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(4,'N');">
                <?=term('Weight',$settings,$session);?>
            </a>
        </th>
        <th style="width:7%;">
            <a href="javascript:SortTable(5,'N');">
                <?=term('Body Sizes',$settings,$session);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(6,'N');">
                <?=term('Shoe Size',$settings,$session);?>
            </a>
        </th>
    </tr>
</thead>
<tbody>
<?php foreach ($exemplarArr as $key=>$value) {
    $ava=(file_exists('Flag.'.$value['country'].'.png'))?'Flag.'.$value['country'].'.png':'Flag.UN.png';
    $mod=modelcard($key,$contentsArr,$exemplarArr,$session,$settings);
    ?>
    <tr>
        <td>
            <a href="<?=$ava;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$ava;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td>
            <a href="javascript:omniGroup(%22<?=$key;?>%22);">
                <?=$mod['title'];?>
            </a>
        </td>
        <td><?=$mod['anno'];?></td>
        <td><?=$mod['height'];?></td>
        <td><?=$mod['weight'];?></td>
        <td><?=$mod['body'];?></td>
        <td><?=$mod['shoe'];?></td>
    </tr>
<?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="7"><?=term('Total elements:',$settings,$session).' '.count($exemplarArr);?></th>
    </tr>
</tfoot>
</table>
<?php } ?>