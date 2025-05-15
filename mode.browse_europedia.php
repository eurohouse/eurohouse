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
        <?php if ($session['censor']!=0) { ?>
        <th style="width:8%;">
            <a href="javascript:SortTable(2,'T');">
                <?=term('Description',$ssVC,$ssUN);?>
            </a>
        </th>
        <?php } else { ?>
        <th style="width:6%;">
            <a href="javascript:SortTable(2,'N');">
                <?=term('Height',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(3,'N');">
                <?=term('Weight',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(4,'N');">
                <?=term('Body Sizes',$ssVC,$ssUN);?>
            </a>
        </th>
        <th style="width:6%;">
            <a href="javascript:SortTable(5,'N');">
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
            <td><?=(isset($value['height']))?((isset($ssLC['length'][$ssUN]))?((isset($ssLC['length'][$ssUN]['inch']))?incher($value['height']):(round(($value['height']*$ssLC['length'][$ssUN]['coefficient']),2)).' '.$ssLC['length'][$ssUN]['sign']):(round(($value['height']*$ssLC['length']['default']['coefficient']),2)).' '.$ssLC['length']['default']['sign']):'';?></td>
            <td><?=(isset($value['weight']))?((isset($ssLC['mass'][$ssUN]))?(round($value['weight']*$ssLC['mass'][$ssUN]['coefficient'])).' '.$ssLC['mass'][$ssUN]['sign'] : (round($value['weight']*$ssLC['mass']['default']['coefficient'])).' '.$ssLC['mass']['default']['sign']) : '';?></td>
            <td><?php $koeff=(isset($ssLC['body_sizes'][$ssUN]['coefficient']))?$ssLC['body_sizes'][$ssUN]['coefficient']:$ssLC['body_sizes']['default']['coefficient'];
            $sizes=(isset($value['sizes']))?((round((explode('-',$value['sizes'])[0]*$koeff))).'-'.(round((explode('-',$value['sizes'])[1]*$koeff))).'-'.(round((explode('-',$value['sizes'])[2]*$koeff)))):''; echo $sizes; ?></td>
            <td><?=(isset($value['shoe_size']))?((isset($ssLC['shoe_size'][$ssUN]))?($value['shoe_size']+$ssLC['shoe_size'][$ssUN]).' '.$ssUN:($value['shoe_size']+$ssLC['shoe_size']['default']).' '.$ssUN):'';?></td>
        <?php } ?>
    </tr><?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:25%;" colspan="6"><?=term('Total elements:',$settings['vocabulary'],$session['units']).' '.count($exemplarArr);?></th>
    </tr>
</tfoot>
</table>
<?php } ?>