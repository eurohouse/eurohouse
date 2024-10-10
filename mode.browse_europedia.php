<!-- world -->
<!-- CH: Explorare Europedia; DE: Entdecken Sie Europedia; AT: Entdecken Sie Europedia; GR: Εξερευνήστε Ευρωπαιδεία; CY: Εξερευνήστε Ευρωπαιδεία; FR: Parcourir Europedia; BE: Parcourir Europedia; IT: Sfoglia Europadia; ES: Explora Europadia; MX: Explora Europadia; BR: Explorar a Europadia; PT: Explorar a Europadia; RO: Explorați Europedia; MD: Explorați Europedia; TR: Europedia'yı keşfedin; IN: यूरोपियाडिया का अन्वेषण करें; LK: यूरोपडिया अन्वेषणं कुर्वन्तु; NP: ཡོ་རོབ་གླིང་ལ་མྱུལ་ཞིང༌།; RU: Просмотр Европедии; UA: Досліджуйте Europedia; CN: 浏览元素 Europedia; KR: 요소 찾아보기 Europedia; JP: 要素の閲覧 Europedia; AE: تصفح عناصر Europedia -->
<?php $imgWSize = 20;
$exemplarArr = exemplar(str_replace('./','',(glob('./*.models.json'))));
$contentsArr = exemplar(str_replace('./','',(glob('./*.contents.json'))));
if ($request['group'] != '') {
    foreach ($contentsArr as $key=>$value) {
        if ($value != $request['group']) { unset($contentsArr[$key]); }
    } ?><p align='center' class='block'>
<?php foreach ($contentsArr as $key=>$value) { ?>
    <a href="<?=$key;?>"><img style="width:<?=$imgWSize;?>%;" loading="lazy" src="<?=$key?>" onmouseover="soundButton();"></a>
<?php } ?></p><?php } else {
    $iconSize = 50; $preAvaSize = 25;
    $preStyle = "white-space:pre-wrap;word-wrap:break-word;";
    $showLocale = $settings['locale'];
    foreach ($exemplarArr as $key=>$value) {
        if ($session['censor'] != 0) {
            if (isset($value['nsfw'])) { unset($exemplarArr[$key]); }
        } else {
            if (!isset($value['nsfw'])) { unset($exemplarArr[$key]); }
        }
    } ?><table style="width:90%;" id="table"><thead><tr>
    <th style="width:16%;"><?=term('Image', $settings['vocabulary'], $session['units']);?></th><th style="width:7%;"><?=term('Flag', $settings['vocabulary'], $session['units']);?></th><th style="width:12%;<?=$preStyle;?>"><a href="javascript:SortTable(2, 'T');"><?=term('Name', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;<?=$preStyle;?>"><a href="javascript:SortTable(3, 'N');"><?=term('Height', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;<?=$preStyle;?>"><a href="javascript:SortTable(4, 'N');"><?=term('Weight', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;<?=$preStyle;?>"><a href="javascript:SortTable(5, 'N');"><?=term('Shoe Size', $settings['vocabulary'], $session['units']);?></a></th>
    </tr></thead>
    <tbody><?php foreach ($exemplarArr as $key=>$value) {
        $modelCountryCode = $value['country'];
        $countryAva = (file_exists('Flag.'.$modelCountryCode.'.png')) ? 'Flag.'.$modelCountryCode.'.png' : 'Flag.UN.png';
        $letModelIMG = array_search($key, $contentsArr);
        $letModelTitle = (isset($exemplarArr[$key]['language'][$session['units']]['title'])) ? $exemplarArr[$key]['language'][$session['units']]['title'] : $key;
        $modelAva = (file_exists($letModelIMG)) ? $letModelIMG : $themePrefix.'image.png'; ?>
    <tr><td><a href="<?=$modelAva;?>"><img style="width:<?=$iconSize;?>%;" loading="lazy" src="<?=$modelAva;?>" onmouseover="soundButton();"></a></td>
    <td><a href="<?=$countryAva;?>"><img style="width:<?=$preAvaSize;?>%;" src="<?=$countryAva;?>" loading="lazy" onmouseover="soundButton();"></a></td>
    <td><a href="javascript:omniSwitch(%22<?=$key;?>%22);"><?=$letModelTitle;?></a></td>
    <td><?=(isset($value['height'])) ? ((isset($showLocale['length'][$session['units']])) ? ((isset($showLocale['length'][$session['units']]['inch'])) ? incher($value['height']) : (round(($value['height'] * $showLocale['length'][$session['units']]['coefficient']), 2))) : (round(($value['height'] * $showLocale['length']['default']['coefficient']), 2))) : 'N/A';?></td>
    <td><?=(isset($value['weight'])) ? ((isset($showLocale['mass'][$session['units']])) ? (round($value['weight'] * $showLocale['mass'][$session['units']]['coefficient'])) : (round($value['weight'] * $showLocale['mass']['default']['coefficient']))) : 'N/A';?></td>
    <td><?=(isset($value['shoe_size'])) ? ((isset($showLocale['shoe_size'][$session['units']])) ? ($value['shoe_size'] + $showLocale['shoe_size'][$session['units']]) : ($value['shoe_size'] + $showLocale['shoe_size']['default'])) : 'N/A';?></td></tr>
<?php } ?></tbody></table><?php } ?>