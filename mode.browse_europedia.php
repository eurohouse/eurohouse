<!-- world -->
<!-- CH: Explorare Europedia; DE: Entdecken Sie Europedia; AT: Entdecken Sie Europedia; GR: Εξερευνήστε Ευρωπαιδεία; CY: Εξερευνήστε Ευρωπαιδεία; FR: Parcourir Europedia; BE: Parcourir Europedia; IT: Sfoglia Europadia; ES: Explora Europadia; MX: Explora Europadia; BR: Explorar a Europadia; PT: Explorar a Europadia; RO: Explorați Europedia; MD: Explorați Europedia; TR: Europedia'yı keşfedin; IN: यूरोपियाडिया का अन्वेषण करें; LK: यूरोपडिया अन्वेषणं कुर्वन्तु; NP: ཡོ་རོབ་གླིང་ལ་མྱུལ་ཞིང༌།; RU: Просмотр Европедии; UA: Досліджуйте Europedia; CN: 浏览元素 Europedia; KR: 요소 찾아보기 Europedia; JP: 要素の閲覧 Europedia; AE: تصفح عناصر Europedia -->
<!-- <ref> -->
<!-- true -->
<?php $iconSize=50;$flagSize=($session['censor'])?2:4;
$ssLC=$settings['locale'];$ssVC=$settings['vocabulary'];
$exemplarArr=exemplar(str_replace('./','',(glob('./*.models.json'))));
$contentsArr=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$ssUN=$session['units']; if ($request['group']!='') {
    foreach ($contentsArr as $key=>$value) {
        if ($value!=$request['group']) { unset($contentsArr[$key]); }
    } ?>
    <table style="width:100%;" id="table">
    <thead>
    <tr>
        <th style="width:40%;"><?=term('Image',$ssVC,$ssUN);?></th>
        <th style="width:5%;"><?=term('Actions',$ssVC,$ssUN);?></th>
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
        <?=term('Total elements:', $ssVC,$ssUN).' '.count($contentsArr);?><br>
        <?=modelcard($request['group'],$contentsArr,$exemplarArr,$session,$settings);?>
    </th></tr>
</tfoot>
</table>
<?php } else {
    foreach ($exemplarArr as $key=>$value) {
        if ($session['censor']!=0) {
            if (isset($value['nsfw'])) { unset($exemplarArr[$key]); }
        } else {
            if (!isset($value['nsfw'])) { unset($exemplarArr[$key]); }
        }
    } ?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:<?=$flagSize;?>%;">
            <?=term('Flag',$ssVC,$ssUN);?>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:9%;">
            <a href="javascript:SortTable(2,'T');">
                <?=term('Birthday',$ssVC,$ssUN);?>
            </a>
        </th>
        <?php if ($session['censor']!=0) { ?>
        <th style="width:8%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('Description',$ssVC,$ssUN);?>
            </a>
        </th>
        <?php } else { ?>
        <th style="width:6%;">
            <a href="javascript:SortTable(4,'N');">
                <?=term('Height',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(5,'N');">
                <?=term('Weight',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:7%;">
            <a href="javascript:SortTable(6,'N');">
                <?=term('Body Sizes',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(7,'N');">
                <?=term('Shoe Size',$ssVC,$ssUN);?>
            </a>
        </th>
        <?php } ?>
    </tr>
</thead>
<tbody><?php foreach ($exemplarArr as $key=>$value) {
        $ccAV=(file_exists('Flag.'.$value['country'].'.png'))?'Flag.'.$value['country'].'.png':'Flag.UN.png';
        $mmTL=(isset($value['language'][$ssUN]['title']))?$value['language'][$ssUN]['title']:$key;
        $mmDC=(isset($value['language'][$ssUN]['memoir']))?$value['language'][$ssUN]['memoir']:((isset($value['memoir']))?$value['memoir']:''); ?>
    <tr>
        <td><a href="<?=$ccAV;?>">
            <img style="width:<?=$iconSize;?>%;" src="<?=$ccAV;?>" loading="lazy" onmouseover="soundButton();">
        </a></td>
        <td><a href="javascript:omniSwitch(%22<?=$key;?>%22);">
            <?=$mmTL;?>
        </a></td>
        <?php if ($session['censor']!=0) { ?>
        <td>
            <?php if (isset($value['maison'])) { ?><a href="<?=$value['maison'];?>"><?php } ?>
                <?=fixedSize($mmDC,0,180);?>
            <?php if (isset($value['maison'])) { ?></a><?php } ?>
        </td>
        <?php } else { ?>
            <td><?php $bday=(isset($value['birthday']))?chooseCalendar($value['birthday'],$session,$settings):''; ?></td>
            <td><?php $sign=(isset($ssLC['length'][$ssUN]['sign']))?$ssLC['length'][$ssUN]['sign']:$ssLC['length']['default']['sign']; $koeff=(isset($ssLC['length'][$ssUN]['coefficient']))?$ssLC['length'][$ssUN]['coefficient']:$ssLC['length']['default']['coefficient']; if (isset($value['height'])) {
                if (isset($ssLC['length'][$ssUN]['inch'])) {
                    $height=incher($value['height']);
                } else { $height=(round(($value['height']*$koeff),2)).' '.$sign; }
            } else { $height=''; } echo $height; ?></td>
            <td><?php $sign=(isset($ssLC['mass'][$ssUN]['sign']))?$ssLC['mass'][$ssUN]['sign']:$ssLC['mass']['default']['sign']; $koeff=(isset($ssLC['mass'][$ssUN]['coefficient']))?$ssLC['mass'][$ssUN]['coefficient']:$ssLC['mass']['default']['coefficient'];
            $weight=(isset($value['weight']))?round($value['weight']*$koeff).' '.$sign:' ';
            echo $weight; ?>
            <td><?php $koeff=(isset($ssLC['body_sizes'][$ssUN]['coefficient']))?$ssLC['body_sizes'][$ssUN]['coefficient']:$ssLC['body_sizes']['default']['coefficient'];
            $sizes=(isset($value['sizes']))?((round((explode('-',$value['sizes'])[0]*$koeff))).'-'.(round((explode('-',$value['sizes'])[1]*$koeff))).'-'.(round((explode('-',$value['sizes'])[2]*$koeff)))):''; echo $sizes; ?></td>
            <td><?php $koeff=(isset($ssLC['shoe_size'][$ssUN]))?$ssLC['shoe_size'][$ssUN]:$ssLC['shoe_size']['default']; $shoeSize=(isset($value['shoe_size']))?(($value['shoe_size']+$koeff).' '.$ssUN):' '; echo $shoeSize; ?></td>
        <?php } ?>
    </tr><?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="7"><?=term('Total elements:',$settings['vocabulary'],$session['units']).' '.count($exemplarArr);?></th>
    </tr>
</tfoot>
</table>
<?php } ?>