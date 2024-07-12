<!-- locale -->
<!-- GR: Γλωσσικά και περιφερειακά πρότυπα; CY: Γλωσσικά και περιφερειακά πρότυπα; DE: Lokalisierung; FR: Normes linguistiques et régionales; IT: Lingua e standard regionali; ES: Idioma y estándares regionales; MX: Idioma y estándares regionales; RO: Localizare; MD: Localizare; RU: Язык и региональные стандарты; TR: Dil ve bölgesel standartlar; PT: Línguas e padrões regionais; BR: idiomas e padrões regionais; NP: སྐད་ཡིག་དང་ས་ཁུལ་གྱི་ཚད་གཞི།; TR: Dil ve bölgesel standartlar; LK: भाषा तथा क्षेत्रीय मानक; CN: 黄金十亿国家; KR: 황금십억나라; JP: 黄金十億の国; AE: المليار الذهبي -->
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
<img name="<?=$key;?>" style="height:17%;position:relative;opacity:<?=(in_array($key, explode(',', $session['units_list']))) ? 1 : 0.5;?>;" title="<?=$key.': '.$value;?>" src="<?='Flag.'.$key.'.png'.$suffix;?>" onclick="setdata('units_list', arrangeMenu(sysDefUnitsList.value, this.name)); if (this.style.opacity == 0.5) { this.style.setProperty('opacity', 1); } else { this.style.setProperty('opacity', 0.5); }">
<?php } ?>
</p>