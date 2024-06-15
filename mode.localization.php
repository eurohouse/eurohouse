<!-- locale -->
<!-- RU: Язык и региональные стандарты; CN: 黄金十亿国家; KR: 황금십억나라; JP: 黄金十億の国; AE: المليار الذهبي -->
<p align="center">
<?php $arr = fileopen('HDI.json'); $dev = $arr;
foreach ($arr as $key=>$value) {
    if ($value < 0.8) {
        unset($dev[$key]);
    } $arr['UN'] = round((array_sum($arr) / count($arr)), 3);
    $arr['EU'] = round((array_sum($dev) / count($dev)), 3);
    $arr['AQ'] = 0; arsort($arr);
    if ($request['lock'] != 'false') {
        if ($value < 0.8) {
            unset($arr[$key]);
        }
    }
} ?>
<?php foreach ($arr as $key=>$value) { ?>
<img name="<?=$key;?>" style="height:17%;position:relative;opacity:<?=(in_array($key, explode(',', $session['units_list']))) ? 1 : 0.5;?>;" title="<?=$key.': '.$value;?>" src="<?='Flag.'.$key.'.png'.$suffix;?>" onclick="setdata('units_list', arrangeMenu(sysDefUnitsList.value, this.name)); this.style.setProperty('opacity', <?=(in_array($key, explode(',', $session['units_list']))) ? 0.5 : 1;?>);">
<?php } ?>
</p>