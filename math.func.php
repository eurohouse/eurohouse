<?php
function dir_size($path) {
    $bytestotal=0;$path=realpath($path);
    if (($path!==false)&&($path!='')&&file_exists($path)) {
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::UNIX_PATHS)) as $object) {
            $bytestotal+=$object->getSize();
        }
    } return $bytestotal;
}
function hHmMsS(int $num): string {
    return sprintf('%02d:%02d:%02d',(round($num)/3600),(round($num)/60%60),round($num)%60);
}
function enc_tz($tz): string {
    if (strpos($tz,'+')!==false) {
        $res='-'.explode('+',$tz)[1];
    } elseif (strpos($tz,'-')!==false) {
        $res=explode('-',$tz)[1];
    } else { $res=0; } return $res;
}
function dec_tz($tz): string {
    return ($tz==0)?'Etc/GMT':(($tz<0)?'Etc/GMT'.'+'.abs($tz):'Etc/GMT'.'-'.abs($tz));
}
function offnum($pos=0,$all=360,$off=90) {
    return abs(($pos+$all-abs($off))%$all);
}
function frndOf($arr,$id,$it) {
    $ind=$arr[$id];$ls=explode(',',$ind); return (in_array($it,$ls));
}
function sizestr(string $val,array $voc,$units='EU') {
    $unitB=(isset($voc['B'][$units]['sign']))?$voc['B'][$units]['sign']:'B';
    $unitKB=(isset($voc['KB'][$units]['sign']))?$voc['KB'][$units]['sign']:'KB';
    $valKB=(isset($voc['KB'][$units]['value']))?$voc['KB'][$units]['value']:1024;
    $unitMB=(isset($voc['MB'][$units]['sign']))?$voc['MB'][$units]['sign']:'MB';
    $valMB=(isset($voc['MB'][$units]['value']))?$voc['MB'][$units]['value']:1048576;
    $unitGB=(isset($voc['GB'][$units]['sign']))?$voc['GB'][$units]['sign']:'GB';
    $valGB=(isset($voc['GB'][$units]['value']))?$voc['GB'][$units]['value']:1073741824;
    $unitTB=(isset($voc['TB'][$units]['sign']))?$voc['TB'][$units]['sign']:'TB';
    $valTB=(isset($voc['TB'][$units]['value']))?$voc['TB'][$units]['value']:1099511627776;
    $unitPB=(isset($voc['PB'][$units]['sign']))?$voc['PB'][$units]['sign']:'PB';
    $valPB=(isset($voc['PB'][$units]['value']))?$voc['PB'][$units]['value']:1125899906842624;
    $unitEB=(isset($voc['EB'][$units]['sign']))?$voc['EB'][$units]['sign']:'EB';
    $valEB=(isset($voc['EB'][$units]['value']))?$voc['EB'][$units]['value']:1152921504606847000;
    $unitZB=(isset($voc['ZB'][$units]['sign']))?$voc['ZB'][$units]['sign']:'ZB';
    $valZB=(isset($voc['ZB'][$units]['value']))?$voc['ZB'][$units]['value']:1.1805916207174113e+21;
    $unitYB=(isset($voc['YB'][$units]['sign']))?$voc['YB'][$units]['sign']:'YB';
    $valYB=(isset($voc['YB'][$units]['value']))?$voc['YB'][$units]['value']:1.2089258196146292e+24;
    $res=($val<$valKB)?$val.' '.$unitB:(($val<$valMB)?round(($val/$valKB),2).' '.$unitKB:(($val<$valGB)?round(($val/$valMB),2).' '.$unitMB:(($val<$valTB)?round(($val/$valGB),2).' '.$unitGB:(($val<$valPB)?round(($val/$valTB),2).' '.$unitTB:(($val<$valEB)?round(($val/$valPB), 2).' '.$unitPB:(($val<$valZB)?round(($val/$valEB),2).' '.$unitEB:(($val<$valYB)?round(($val/$valZB),2).' '.$unitZB:round(($val/$valYB),2).' '.$unitYB))))))); return $res;
}
function horizontal($a,$circle=6.285714285714286) {
    return floor(4*($a/$circle));
}
function hourize($sec,$min,$mod) {
    return ((($sec/(60/(12/$mod)))%(24/(2**$mod)))+((24/(2**$mod))*($min%(2**$mod))));
}
function incher($num,$koeff=3.28084,$denom=12) {
    $modul=round(($num*$koeff),1);$nat=explode('.',$modul)[0];
    $frac=round($denom*(explode('.',$modul)[1]/10));
    return $nat."' ".$frac."\"";
}
function lux($hex): bool {
    if (strlen($hex)<7) {
        $r=hexdec(substr($hex,1,1).'F');
        $g=hexdec(substr($hex,2,1).'F');
        $b=hexdec(substr($hex,3,1).'F');
    } else {
        $r=hexdec(substr($hex,1,2));
        $g=hexdec(substr($hex,3,2));
        $b=hexdec(substr($hex,5,2));
    } return (($r+$g+$b)>382);
}
function rgbap($hex,$opa) {
    $fst=substr($hex,0,7);
    $lst=($opa=='IF')?'00':(($opa=='FI')?'FF':dechex($opa));
    return strtoupper($fst.$lst);
}
function themed(string $theme,string $assets='head'): bool {
    $arr=explode(',',$assets);$basket=true;
    foreach ($arr as $val) {
        $basket=$basket&&file_exists($theme.$val.'.png');
    } return $basket;
}
function daily($name,$add,$hour): string {
    $num=str_replace('./','',(glob('./'.explode('.',$name)[0].'.'.explode('.',$name)[1].'.{00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23}.png',GLOB_BRACE)));
    $fin=sprintf("%02d",(floor(count($num)*($hour/24))));
    $back=($add!='')?((file_exists(explode('.',$name)[0].'.'.explode('.', $name)[1].'.'.$fin.$add.'.png'))?explode('.',$name)[0].'.'.explode('.',$name)[1].'.'.$fin.$add.'.png':explode('.',$name)[0].'.'.explode('.', $name)[1].'.'.$fin.'.png'):explode('.',$name)[0].'.'.explode('.',$name)[1].'.'.$fin.'.png'; return $back;
}
