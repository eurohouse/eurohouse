<!-- world -->
<!-- RU: Просмотр Европедии; CN: 浏览元素 Europedia; KR: 浏览元素 Europedia; JP: 浏览元素 Europedia; AE: تصفح عناصر Europedia -->
<?php $imgWSize = 20;
$exemplarArr = exemplar(str_replace('./','',(glob('./*.models.json'))));
$contentsArr = exemplar(str_replace('./','',(glob('./*.contents.json')))); if ($request['group'] != '') {
foreach ($contentsArr as $key=>$value) {
if ($value != $request['group']) { unset($contentsArr[$key]); }
} ?><p align='center' class='block'>
<?php foreach ($contentsArr as $key=>$value) {
?><a href="<?=$key;?>"><img style="width:<?=$imgWSize;?>%;position:relative;" src="<?=$key.$suffix?>" onmouseover="soundButton();"></a>
<?php } ?></p><?php } else {
$iconSize = 50; $preAvaSize = 25;
$preStyle = "white-space:pre-wrap;word-wrap:break-word;";
$showLocale = $settings['locale'];
foreach ($exemplarArr as $key=>$value) {
    if (!isModel($value)) { unset($exemplarArr[$key]); }
} ?><table style="width:90%;" id="table">
<thead><tr>
    <th style="width:16%;"><?=term('Image', $settings['vocabulary'], $session['units']);?></th>
    <th style="width:7%;"><?=term('Flag', $settings['vocabulary'], $session['units']);?></th>
    <th style="width:12%;<?=$preStyle;?>"><a href="javascript:SortTable(2, 'T');"><?=term('Name', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;<?=$preStyle;?>"><a href="javascript:SortTable(3, 'N');"><?=term('Height', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;<?=$preStyle;?>"><a href="javascript:SortTable(4, 'N');"><?=term('Weight', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;<?=$preStyle;?>"><a href="javascript:SortTable(5, 'N');"><?=term('Shoe Size', $settings['vocabulary'], $session['units']);?></a></th>
</tr></thead>
<tbody><?php foreach ($exemplarArr as $key=>$value) {
    $modelCountryCode = $value['country'];
    $countryAva = (file_exists('Flag.'.$modelCountryCode.'.png')) ? 'Flag.'.$modelCountryCode.'.png' : 'Flag.UN.png';
    $letModelIMG = array_search($key, $contentsArr);
    $modelAva = (file_exists($letModelIMG)) ? $letModelIMG : $themePrefix.'image.png'; ?>
    <tr><td><a href="<?=$modelAva;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$modelAva.$suffix;?>" onmouseover="soundButton();"></a></td>
    <td><a href="<?=$countryAva;?>"><img style="width:<?=$preAvaSize;?>%;" src="<?=$countryAva.$suffix;?>" onmouseover="soundButton();"></a></td>
    <td><a href="javascript:omniSwitch(%22<?=$key;?>%22);"><?=$key;?></a></td>
    <td><?=(isset($showLocale['length'][$session['units']])) ? ((isset($showLocale['length'][$session['units']]['inch'])) ? incher($value['height']) : (round(($value['height'] * $showLocale['length'][$session['units']]['coefficient']), 2))) : (round(($value['height'] * $showLocale['length']['default']['coefficient']), 2));?></td>
    <td><?=(isset($showLocale['mass'][$session['units']])) ? (round($value['weight'] * $showLocale['mass'][$session['units']]['coefficient'])) : (round($value['weight'] * $showLocale['mass']['default']['coefficient']));?></td>
    <td><?=(isset($showLocale['shoe_size'][$session['units']])) ? ($value['shoe_size'] + $showLocale['shoe_size'][$session['units']]) : ($value['shoe_size'] + $showLocale['shoe_size']['default']);?></td></tr>
<?php } ?></tbody></table><?php } ?>