<!-- locale -->
<!-- GR: Γλωσσικά και περιφερειακά πρότυπα; CY: Γλωσσικά και περιφερειακά πρότυπα; DE: Lokalisierung; AT: Lokalisierung; CH: Eligere Lingua; FR: Normes linguistiques et régionales; BE: Normes linguistiques et régionales; IT: Lingua e standard regionali; ES: Idioma y estándares regionales; MX: Idioma y estándares regionales; RO: Localizare; MD: Localizare; RU: Язык и региональные стандарты; UA: Мова та регіональні стандарти; TR: Dil ve bölgesel standartlar; PT: Línguas e padrões regionais; BR: idiomas e padrões regionais; NP: སྐད་ཡིག་དང་ས་ཁུལ་གྱི་ཚད་གཞི།; TR: Dil ve bölgesel standartlar; LK: भाषा तथा क्षेत्रीय मानक; CN: 黄金十亿国家; KR: 황금십억나라; JP: 黄金十億の国; AE: المليار الذهبي -->
<p align="center">
<?php $arr=fileopen('i18n.json');$arr['UN']['Continent']='Worldwide';
$arr['EU']['Continent']='Europe';$arr['AQ']['Continent']='Antarctica';
sort($arr); foreach ($arr as $key=>$value) { ?>
    <img name="<?=$key;?>" style="height:17%;opacity:<?=(in_array($key,explode(',',$session['units_list'])))?1:0.5;?>;" title="<?=$key.' ('.term($value['Continent'],$settings['locale']['continent'],$session['units']).')';?>" src="<?='Flag.'.$key.'.png';?>" onclick="setdata('units_list',arrangeMenu(sysDefUnitsList.value,this.name)); if (this.style.opacity==0.5) { this.style.setProperty('opacity',1); } else { this.style.setProperty('opacity',0.5); }">
<?php } ?>
</p>