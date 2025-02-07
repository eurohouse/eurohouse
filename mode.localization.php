<!-- locale -->
<!-- GR: Γλωσσικά και περιφερειακά πρότυπα; CY: Γλωσσικά και περιφερειακά πρότυπα; DE: Lokalisierung; AT: Lokalisierung; CH: Eligere Lingua; FR: Normes linguistiques et régionales; BE: Normes linguistiques et régionales; IT: Lingua e standard regionali; ES: Idioma y estándares regionales; MX: Idioma y estándares regionales; RO: Localizare; MD: Localizare; RU: Язык и региональные стандарты; UA: Мова та регіональні стандарти; TR: Dil ve bölgesel standartlar; PT: Línguas e padrões regionais; BR: idiomas e padrões regionais; NP: སྐད་ཡིག་དང་ས་ཁུལ་གྱི་ཚད་གཞི།; TR: Dil ve bölgesel standartlar; LK: भाषा तथा क्षेत्रीय मानक; CN: 黄金十亿国家; KR: 황금십억나라; JP: 黄金十億の国; AE: المليار الذهبي -->
<p align="center">
<?php $arr=fileopen('i18n.json');
function hdisum(array $arr) {
    $res=0; foreach ($arr as $key=>$val) {
        $res+=(isset($val['Human Development Index']))?$val['Human Development Index']:0;
    } return $res;
}
function hdiadd(array $arr) {
    foreach ($arr as $key=>$val) {
        $lem=(isset($val['Life Expectancy']['Male']))?$val['Life Expectancy']['Male']:32.5;
        $lef=(isset($val['Life Expectancy']['Female']))?$val['Life Expectancy']['Female']:37.5;
        $lei=(((($lem+$lef)/2)-20)/65);
        $mysm=(isset($val['School Years']['Average']['Male']))?$val['School Years']['Average']['Male']:10;
        $mysm=(isset($val['School Years']['Average']['Female']))?$val['School Years']['Average']['Female']:5;
        $eysm=(isset($val['School Years']['Expected']['Male']))?$val['School Years']['Expected']['Male']:11.5;
        $eysf=(isset($val['School Years']['Expected']['Female']))?$val['School Years']['Expected']['Female']:6.5;
        $ei=((((($mysm+$mysf)/2)/15)+((($eysm+$eysf)/2)/18))/2);
        $gnim=(isset($val['Gross National Income']['Male']))?$val['Gross National Income']['Male']:7500;
        $gnim=(isset($val['Gross National Income']['Female']))?$val['Gross National Income']['Female']:2500;
        $ii=((log(($gnim+$gnif)/2)-log(100))/log(750));
        $arr[$key]['Human Development Index']=round((($lei*$ei*$ii)**(1/3)),3);
    } return $arr;
} function onlydev(array $arr) {
    foreach ($arr as $key=>$val) {
        $res=(isset($val['Human Development Index']))?$val['Human Development Index']:0; if ($res<0.8) { unset($arr[$key]); }
    } return $arr;
} function onlyhdi(array $arr) {
    $res=[]; foreach ($arr as $key=>$val) {
        $rs1=(isset($val['Human Development Index']))?$val['Human Development Index']:0; $rs2=(isset($val['Continent']))?$val['Continent']:'Worldwide'; $res[$key]['Human Development Index']=$rs1; $res[$key]['Continent']=$rs2;
    } return $res;
} /*$arr=hdiadd($arr); $dev=onlydev($arr);
$fmar=($request['lock']!='false')?$dev:$arr;
$fnar=($request['lock']!='false')?onlyhdi($dev):onlyhdi($arr);
$fnar['UN']['Human Development Index']=round((hdisum($arr)/count($arr)),3);
$fnar['UN']['Continent']='Worldwide';
$fnar['EU']['Human Development Index']=round((hdisum($dev)/count($dev)),3);
$fnar['EU']['Continent']='Europe';
arsort($fnar); $fnar['AQ']['Human Development Index']='N/A';
$fnar['AQ']['Continent']='Antarctica';
foreach ($fnar as $key=>$value) {
    $shc=((isset($settings['locale']['continent'][$session['units']][$value['Continent']]))?$settings['locale']['continent'][$session['units']][$value['Continent']]:$value['Continent']);
    $shh=$value['Human Development Index'];
    $shth=term('HDI',$settings['vocabulary'],$session['units']);
    $shdh=$key.' ('.$shc.') '.$shth.' '.$shh;
*/ ?>
<img name="<?=$key;?>" style="height:17%;opacity:<?=(in_array($key,explode(',',$session['units_list'])))?1:0.5;?>;" title="<?=$shdh;?>" src="<?='Flag.'.$key.'.png';?>" onclick="setdata('units_list',arrangeMenu(sysDefUnitsList.value,this.name)); if (this.style.opacity==0.5) { this.style.setProperty('opacity',1); } else { this.style.setProperty('opacity',0.5); }">
<?php } ?>
</p>