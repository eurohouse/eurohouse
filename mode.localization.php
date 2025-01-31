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
        $lem=(isset($val['Life Expectancy']['Male']))?$val['Life Expectancy']['Male']:(65-2.5);
        $lef=(isset($val['Life Expectancy']['Female']))?$val['Life Expectancy']['Female']:(65+2.5); $lei=(((($lem+$lef)/2)-20)/65);
        $mys=(isset($val['School Years']['Average']))?$val['School Years']['Average']:(15/2);
        $eys=(isset($val['School Years']['Expected']))?$val['School Years']['Expected']:(18/2); $ei=((($mys/15)+($eys/18))/2);
        $gni=(isset($val['Gross National Income']))?$val['Gross National Income']:100; $ii=((log($gni)-log(100))/log(750));
        $arr[$key]['Human Development Index']=round((($lei*$ei*$ii)**(1/3)),3);
    } return $arr;
} function onlydev(array $arr) {
    foreach ($arr as $key=>$val) {
        $res=(isset($val['Human Development Index']))?$val['Human Development Index']:0; if ($res<0.8) { unset($arr[$key]); }
    } return $arr;
} function onlyhdi(array $arr) {
    $res=[]; foreach ($arr as $key=>$val) {
        $rs1=(isset($val['Human Development Index']))?$val['Human Development Index']:0; $rs2=(isset($val['Continent']))?$val['Continent']:'Worldwide';
        $res[$key]['Human Development Index']=$rs1; $res[$key]['Continent']=$rs2;
    } return $res;
} $arr=hdiadd($arr); $dev=onlydev($arr);
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
    $shta=term('Average',$settings['vocabulary'],$session['units']);
    $shte=term('Expected',$settings['vocabulary'],$session['units']);
    $shtg=term('GNI PPP per capita',$settings['vocabulary'],$session['units']);
    $shtm=localword('male',$settings['sex_life'],$session['units']);
    $shtf=localword('female',$settings['sex_life'],$session['units']);
    $shr=(isset($fmar[$key]['Life Expectancy']['Male'])&&isset($fmar[$key]['Life Expectancy']['Female']))?$fmar[$key]['Life Expectancy']['Male'].' '.$shtm.' '.$fmar[$key]['Life Expectancy']['Female'].' '.$shtf:'';
    $she=(isset($fmar[$key]['School Years']['Average'])&&isset($fmar[$key]['School Years']['Expected']))?$fmar[$key]['School Years']['Average'].' '.$shta.' '.$fmar[$key]['School Years']['Expected'].' '.$shte:'';
    $shg=(isset($fmar[$key]['Gross National Income']))?$shtg.' $'.$fmar[$key]['Gross National Income']:'';
    $shdh=$key.' ('.$shc.') '.$shth.' '.$shh."\r\n".$shr."\r\n".$she."\r\n".$shg;
?>
<img name="<?=$key;?>" style="height:17%;opacity:<?=(in_array($key,explode(',',$session['units_list'])))?1:0.5;?>;" title="<?=$shdh;?>" src="<?='Flag.'.$key.'.png';?>" onclick="setdata('units_list',arrangeMenu(sysDefUnitsList.value,this.name)); if (this.style.opacity==0.5) { this.style.setProperty('opacity',1); } else { this.style.setProperty('opacity',0.5); }">
<?php } ?>
</p>