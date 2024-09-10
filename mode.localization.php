<!-- locale -->
<!-- GR: Γλωσσικά και περιφερειακά πρότυπα; CY: Γλωσσικά και περιφερειακά πρότυπα; DE: Lokalisierung; AT: Lokalisierung; CH: Eligere Lingua; FR: Normes linguistiques et régionales; BE: Normes linguistiques et régionales; IT: Lingua e standard regionali; ES: Idioma y estándares regionales; MX: Idioma y estándares regionales; RO: Localizare; MD: Localizare; RU: Язык и региональные стандарты; UA: Мова та регіональні стандарти; TR: Dil ve bölgesel standartlar; PT: Línguas e padrões regionais; BR: idiomas e padrões regionais; NP: སྐད་ཡིག་དང་ས་ཁུལ་གྱི་ཚད་གཞི།; TR: Dil ve bölgesel standartlar; LK: भाषा तथा क्षेत्रीय मानक; CN: 黄金十亿国家; KR: 황금십억나라; JP: 黄金十億の国; AE: المليار الذهبي -->
<p align="center">
<?php $arr = fileopen('i18n.json');
function hdi2019sum(array $arr) {
    $res = 0; foreach ($arr as $key=>$val) {
        $res += $val['HDI'][2019];
    } return $res;
} $dev = $arr; foreach ($arr as $key=>$value) {
    if ($value['HDI'][2019] < 0.8) { unset($dev[$key]); }
} $arr['UN']['HDI'][2019] = round((hdi2019sum($arr) / count($arr)), 3);
$arr['UN']['Continent'] = 'Worldwide';
foreach ($arr as $key=>$value) {
    if ($request['lock'] != 'false') {
        if ($value['HDI'][2019] < 0.8) { unset($arr[$key]); }
    }
} $arr['EU']['HDI'][2019] = round((hdi2019sum($dev) / count($dev)), 3);
$arr['EU']['Continent'] = 'Europe';
arsort($arr); $arr['AQ']['HDI'][2019] = 'N/A';
$arr['AQ']['Continent'] = 'Antarctica';
foreach ($arr as $key=>$value) {
    if ($request['sort'] != '') {
        if ($value['Continent'] != ucfirst($request['sort'])) { unset($arr[$key]); }
    }
} ?>
<?php foreach ($arr as $key=>$value) { ?>
<img name="<?=$key;?>" style="height:17%;opacity:<?=(in_array($key, explode(',', $session['units_list']))) ? 1 : 0.5;?>;" title="<?=$key.' ('.((isset($settings['locale']['continent'][$session['units']][$value['Continent']])) ? $settings['locale']['continent'][$session['units']][$value['Continent']] : $value['Continent']).') HDI '.$value['HDI'][2019];?>" src="<?='Flag.'.$key.'.png'.$suffix;?>" onclick="setdata('units_list', arrangeMenu(sysDefUnitsList.value, this.name)); if (this.style.opacity == 0.5) { this.style.setProperty('opacity', 1); } else { this.style.setProperty('opacity', 0.5); }">
<?php } ?>
</p>