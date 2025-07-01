<?php
function wasAuthRequest() {
    if ((isset($_POST['auth']))&&(isset($_POST['login']))&&(isset($_POST['password']))) {
        $auth=$_POST['auth'];$login=$_POST['login'];$pass=$_POST['password'];
        if (($auth=='signup')&&($login!='')&&($pass!='')) {
            if (!file_exists($login.'_password')) {
                file_put_contents($login.'_password',$pass);
                chmod($login.'_password',0777);
            }
        } elseif (($auth=='signin')&&($login!='')&&($pass!='')) {
            $logpass=textopen($login.'_password','');
            if ($pass==$logpass) {
                $_SESSION['user']=$login;
            }
        } elseif (($auth=='signout')&&($login=='')&&($pass=='')) {
            unset($_SESSION['user']);
        }
    }
}
function isAuthorized() { return (isset($_SESSION['user'])); }
function whichSession($def) {
    return (isset($_SESSION['user']))?$_SESSION['user']:$def;
}
function whichCookie($def) {
    return (isset($_COOKIE['user']))?$_COOKIE['user']:$def;
}
function isUserRoot($def) {
    return ((isset($_SESSION['user']))&&($_SESSION['user']==$def));
}
function browserName($ua) {
    if (preg_match('/opera|opr/i',$ua)) return 'Opera';
    elseif (preg_match('/edge/i',$ua)) return 'Edge';
    elseif (preg_match('/chrome/i',$ua)) return 'Chrome';
    elseif (preg_match('/safari/i',$ua)) return 'Safari';
    elseif (preg_match('/firefox/i',$ua)) return 'Firefox';
    elseif (preg_match('/msie|trident/i',$ua)) return 'IE';
    return 'Other';
}
function platformName($ua) { 
    if (preg_match('/linux/i',$ua)) return 'Linux';
    elseif (preg_match('/bsd/i',$ua)) return 'BSD';
    elseif (preg_match('/macintosh|mac os x/i',$ua)) return 'macOS';
    elseif (preg_match('/windows|win32/i',$ua)) return 'Windows';
    return 'Other';
}
function parseRequestURI($uri): array {
    $prot=explode('://',$uri)[0]; $rest=explode('://',$uri)[1];
    $parts=explode('/',$rest); $prest=$parts;
    $host=$parts[0]; if (count($parts)>2) {
        $repo=$parts[count($parts)-1];
        unset($prest[count($prest)-1]);
        unset($prest[0]); $user=implode('/',$prest);
    } elseif (count($parts)==2) { $repo=$parts[1];$user=''; }
    return ['host'=>$host,'prot'=>$prot,'repo'=>$repo,'user'=>$user];
}
function express(array $for) {
    foreach ($for as $pkg) {
        if (strpos($pkg,'>')!==false) {
            $uri=explode('>',$pkg)[0];$branch=explode('>',$pkg)[1];
            $host=parseRequestURI($uri)['host'];
            $prot=parseRequestURI($uri)['prot'];
            $repo=parseRequestURI($uri)['repo'];
            $user=parseRequestURI($uri)['user'];
        } else {
            $branch='';$host=parseRequestURI($pkg)['host'];$prot=parseRequestURI($pkg)['prot'];
            $repo=parseRequestURI($pkg)['repo'];
            $user=parseRequestURI($pkg)['user'];
        } $socketOpen=fsockopen($host,80,$errno,$errstr,10);
        if ($socketOpen!=false) {
            if (file_exists($repo.'.pkg')) {
                $package=fileopen($repo.'.pkg');
                $files=explode(';',$pkgfile['files']);
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        chmod($file,0777); unlink($file);
                    }
                } chmod($repo.'.pkg',0777); unlink($repo.'.pkg');
            } if (file_exists($repo)) {
                chmod($repo,0777); rename($repo,$repo.'-backup');
            } if ($branch!='') {
                exec('git clone -b '.$branch.' '.$prot.'://'.$host.'/'.$user.'/'.$repo);
            } else {
                exec('git clone '.$prot.'://'.$host.'/'.$user.'/'.$repo);
            } chmod($repo,0777); exec('mv '.$repo.'/* $PWD');
            exec('chmod -vR 777 .'); exec('rm -vr '.$repo);
            if (file_exists($repo.'-backup')) {
                chmod($repo.'-backup',0777); rename($repo.'-backup',$repo);
            }
        }
    }
}
function packageFiles($pkg): array {
    if (@json_decode(file_get_contents($pkg.'.pkg'),true)!=null) {
        $pkgf=json_decode(file_get_contents($pkg.'.pkg'),true);
        $pkgl=(isset($pkgf['files']))?$pkgf['files']:'';
    } else { $pkgl=''; } return explode(';',$pkgl);
}
function excludePackages(array $arr,$cat,$exc=''): array {
    $new=$fin=$sup=$res=[]; if ($cat=='background') {
        foreach ($arr as $exem) {
            if ($exc!='') {
                if (strpos($exc,'!')!==false) {
                    $exr=str_replace('!','',$exc);
                    $new[explode('.',$exem)[0]]=$exem;
                    if (strpos($exr,',')!==false) {
                        if (in_array(explode('.',$exem)[0],explode(',',$exr))) { unset($new[explode('.',$exem)[0]]); }
                    } else {
                        if (explode('.',$exem)[0]==$exr) { unset($new[explode('.',$exem)[0]]); }
                    }
                } else {
                    if (strpos($exc,',')!==false) {
                        if (in_array(explode('.',$exem)[0],explode(',',$exc))) { $new[explode('.',$exem)[0]]=$exem; }
                    } else {
                        if (explode('.',$exem)[0]==$exc) { $new[explode('.',$exem)[0]]=$exem; }
                    }
                }
            } else { $new[explode('.',$exem)[0]]=$exem; }
            $sup[explode('.',$exem)[0]]=$exem;
        } $res=(!empty($new))?$new:$sup;
    } else {
        if ($exc!='') {
            if (strpos($exc,'!')!==false) {
                $exr=str_replace('!','',$exc); $new=$arr;
                if (strpos($exr,',')!==false) {
                    foreach (explode(',',$exr) as $iter=>$pkg) {
                        $new=array_diff($new,packageFiles($pkg));
                    }
                } else { $new=array_diff($new,packageFiles($exr)); }
            } else {
                if (strpos($exc,',')!==false) {
                    foreach (explode(',',$exc) as $iter=>$pkg) {
                        $new=($iter==0)?packageFiles($pkg,true):array_merge($new,packageFiles($pkg));
                    }
                } else { $new=packageFiles($exc); }
            }
        } else { $new=$arr; } foreach ($new as $val) {
            if (in_array($val,$arr)!==false) { $fin[]=$val; }
        } $res=(!empty($fin))?array_unique($fin):array_unique($arr);
    } return $res;
}
function valstr(array $arr,$y,$x): string {
    $lines=''; foreach ($arr as $key=>$val) {
        $lines.=$key.$x.$val.$y;
    } return $lines;
}
function valarr(string $str,$y,$x): array {
    $arr=explode($y,$str);
    $newArr=[]; foreach ($arr as $val) {
        $newStr=explode($x,$val);
        $newArr[$newStr[0]]=$newStr[1];
    } return $newArr;
}
function initDataDirs($str='tmp') {
    $arr=explode(',',$str); foreach ($arr as $dir) {
        if (!file_exists('./.'.$dir)) {
            mkdir('./.'.$dir); chmod('./.'.$dir, 0777);
        }
    }
}
function paging($name,$opt=[]): array {
    $arr=preg_split("/\r\n|\n|\r/",(file_get_contents($name)));
    $obj=[]; if (!empty($opt)) {
        foreach ($opt as $n) { $obj[$n]=$arr[$n]; }
    } else {
        foreach ($arr as $n=>$m) { $obj[$n]=$m; }
    } return $obj;
}
function xmlToArray(SimpleXMLElement $xml): array {
    $parser=function (SimpleXMLElement $xml,array $collection=[]) use (&$parser) {
        $nodes=$xml->children();
        $attributes=$xml->attributes();
        if (0!==count($attributes)) {
            foreach ($attributes as $attrName=>$attrValue) {
                $collection['attributes'][$attrName]=strval($attrValue);
            }
        }
        if (0===$nodes->count()) {
            $collection['value']=strval($xml);
            return $collection;
        }
        foreach ($nodes as $nodeName=>$nodeValue) {
            if (count($nodeValue->xpath('../'.$nodeName))<2) {
                $collection[$nodeName]=$parser($nodeValue);
                continue;
            } $collection[$nodeName][]=$parser($nodeValue);
        } return $collection;
    };
    return [ $xml->getName()=>$parser($xml) ];
}
function textopen($name,$default='') {
    $fileOpen=(file_exists($name))?file_get_contents($name):$default;
    return ($fileOpen!='')?$fileOpen:$default;
}
function fileopen($name,$default='') {
    $content=(file_exists($name))?file_get_contents($name):$default;
    if ((class_exists('SimpleXMLElement'))&&(@xmlToArray(new SimpleXMLElement($content))!==null)) {
        $result=xmlToArray(new SimpleXMLElement($content));
    } elseif (@unserialize($content)!==false) {
        $result=unserialize($content);
    } elseif (@json_decode($content,true)!=null) {
        $result=json_decode($content,true);
    } elseif (@paging($name)!==null) {
        $result=paging($name);
    } else { $result=$content; }
    return $result;
}
function arropen($name,$default="{\"\":\"\"}",$exec='') {
    if (!file_exists($name)) {
        file_put_contents($name,$default); chmod($name,0777);
    } $test=file_get_contents($name);
    if (@json_decode($test,true)!=null) {
        file_put_contents($name.'.bak',$test); chmod($name.'.bak',0777);
    } else {
        copy($name.'.bak',$name); chmod($name,0777);
    } if ($exec=='DEFAULT') {
        $tryit=json_decode(file_get_contents($name),true);
        file_put_contents($name,json_encode(mirrorArrays(json_decode($default,true),$tryit)));
        chmod($name,0777); $res=$tryit;
    } elseif ($exec=='JSON') {
        $tryit=file_get_contents($name);$res=$tryit;
    } else {
        $tryit=json_decode(file_get_contents($name),true);$res=$tryit;
    } return $res;
}
function jsonopen($name,$empt=false) {
    $test=file_get_contents($name);
    if (@json_decode($test,true)!=null) {
        file_put_contents($name.'.bak',$test);
        chmod($name.'.bak',0777);
    } elseif ($test=='{}') {
        if ($empt!==false) {
            copy($name.'.bak',$name); chmod($name,0777);
        } else {
            file_put_contents($name.'.bak',$test); chmod($name.'.bak',0777);
        }
    } else { copy($name.'.bak',$name); chmod($name,0777);
    } return file_get_contents($name);
}
function mirrorArrays(array $src,array $des) {
    foreach ($src as $key=>$val) {
        if (!isset($des[$key])) { $des[$key]=$val; }
    } foreach ($des as $key=>$val) {
        if (!isset($src[$key])) { unset($des[$key]); }
    } return $des;
}

function path_root($path) { return preg_match('/^([\/]+)$/i',$path); }
function path_trim($path) { return str_replace('/','',$path); }
function path_rel($path) {
    return (str_starts_with($path,'/')===false);
}
function dir_size($path): int {
    $bytestotal=0;$path=realpath($path);
    if (($path!==false)&&($path!='')&&file_exists($path)) {
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::UNIX_PATHS)) as $object) {
            $bytestotal+=$object->getSize();
        }
    } return $bytestotal;
}
function hhmmss($nums) {
    $hh=$mm=$ss=0;$isHour=floor($nums/3600);
    $hh=sprintf('%02d',floor($nums/3600));
    $num=$nums%3600;$mm=sprintf('%02d',floor($num/60));
    $ss=sprintf('%02d',floor($num%60));
    return ($nums<0)?'--:--':(($isHour==0)?($mm.':'.$ss):($hh.':'.$mm.':'.$ss));
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
function yearday($pos=0,$all=360,$off=90) {
    return abs(($pos+$all-abs($off))%$all);
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
function isColorLight($hex): bool {
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
function alphaChannel($hex,$opa) {
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
function daily($name,$hour): string {
    $num=str_replace('./','',(glob('./'.explode('.',$name)[0].'.'.explode('.',$name)[1].'.{00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23}.png',GLOB_BRACE))); $fin=sprintf("%02d",(floor(count($num)*($hour/24))));
    $back=explode('.',$name)[0].'.'.explode('.',$name)[1].'.'.$fin.'.png'; return $back;
}
function getback(array $ses) {
    return ($ses['banner']!='')?$ses['banner']:daily($ses['background'],((($ses['benchmark']>0)&&($ses['benchmark']<5))?hourize(date('s'),date('i'),$ses['benchmark']):date('H')));
}
function getways($name,array $ses) {
    return implode(';',str_replace(explode('.',$name)[0].'.'.explode('.',$name)[1].'.'.substr(explode('.',$name)[2],0,2),'',str_replace('.png','',str_replace('./','',(glob('./'.explode('.',$name)[0].'.'.explode('.',$name)[1].'.'.substr(explode('.',$name)[2],0,2).'*.png'))))));
}
function modelcard($id,$cont,$exem,$ses,$sti) {
    $uni=$ses['units']; $loc=$sti['locale']; $voc=$sti['vocabulary'];
    $annoInd=(isset($loc['anno'][$uni]))?$loc['anno'][$uni]:$loc['anno']['default']; if (isset($exem[$id])) {
        $ent=$exem[$id];
        $title=(isset($ent['language'][$uni]['title']))?$ent['language'][$uni]['title']:$id;
        $len=(isset($ent['height']))?((isset($loc['length'][$uni]))?((isset($loc['length'][$uni]['inch']))?incher($ent['height']):round(($ent['height']*$loc['length'][$uni]['coefficient']),2).' '.$loc['length'][$uni]['sign']):round(($ent['height']*$loc['length']['default']['coefficient']),2).' '.$loc['length']['default']['sign']):'';
        $mas=(isset($ent['weight']))?((isset($loc['mass'][$uni]))?(round($ent['weight']*$loc['mass'][$uni]['coefficient']).' '.$loc['mass'][$uni]['sign']):round($ent['weight']*$loc['mass']['default']['coefficient']).' '.$loc['mass']['default']['sign']):'';
        $body=(isset($ent['sizes']))?((isset($loc['length'][$uni]['inch']))?(round(explode('-',$ent['sizes'])[0]*$loc['length'][$uni]['coefficient']).'-'.round(explode('-',$ent['sizes'])[1]*$loc['length'][$uni]['coefficient']).'-'.round(explode('-',$ent['sizes'])[2]*$loc['length'][$uni]['coefficient'])):(explode('-',$ent['sizes'])[0].'-'.explode('-',$ent['sizes'])[1].'-'.explode('-',$ent['sizes'])[2])):'';
        $shoe=(isset($ent['shoe_size']))?((isset($loc['shoe_size'][$uni]))?(($ent['shoe_size']+$loc['shoe_size'][$uni]).' '.$uni):($ent['shoe_size']+$loc['shoe_size']['default']).' '.$uni):'';
        $bday=(isset($ent['birthday']))?$ent['birthday']:"now";
        $dday=(isset($ent['deathday']))?$ent['deathday']:"now";
        $tdiff=date_diff(date_create($bday),date_create($dday))->format('%y');
        $cake=((date('j',strtotime($bday))==date('j'))&&(date('n',strtotime($bday))==date('n')))?"🎂":"";
        if (in_array($uni,$loc['anno_ind']['space'])) {
            $annoT=$tdiff.' '.$annoInd;
        } elseif (in_array($uni,$loc['anno_ind']['concat'])) {
            $annoT=$annoInd.$tdiff;
        } else {
            $annoT=$annoInd.' '.$tdiff;
        } $zodT=zodiacSign(date('z',strtotime($bday)));
        $dateT=chooseCalendar(strtotime($bday),$ses,$sti);
        $titleT=((isset($ent['birthday']))?$zodT.' '.$title:$title);
        $res=[
            'title'=>$titleT,
            'line'=>($titleT.' '.$annoT.' ('.$dateT.') '.$len.' '.$mas.' '.$body.' '.$shoe),
            'anno'=>$annoT,'body'=>$body,'shoe'=>$shoe,
            'height'=>$len,'weight'=>$mas
        ];
    } else { $res=[]; } return $res;
}
function userlocks($arr,$col,array $pic) {
    $res=[]; foreach ($arr as $key=>$val) {
        if ($key=='avatar') {
            $lib=str_replace('./','',(glob('./'.$pic[0].'*.png')));
        } elseif ($key=='pictogram') {
            $lib=str_replace('./','',(glob('./'.$pic[3].'*.png')));
        } elseif ($key=='reticle') {
            $lib=str_replace('./','',(glob('./'.$pic[4].'*.png')));
        } elseif ($key=='background') {
            $lib=str_replace('./','',(glob('./*.*.00.png')));
        } else {
            $lib=str_replace('./','',(glob('./*.{'.removeFileExtDots($col[$key],true).'}',GLOB_BRACE)));
        } $res[$key]=excludePackages($lib,$key,$arr[$key]);
    } return $res;
}
function catlist($cat): array {
    return str_replace('./','',(glob('./'.$cat.'.*.00.png')));
}
function exemplar(array $arr): array {
    $newArr=[]; foreach ($arr as $exem) {
        $ober=(@json_decode(file_get_contents($exem),true)!=null)?json_decode(file_get_contents($exem),true):[]; foreach ($ober as $key=>$val) { $newArr[$key]=$val; }
    } return $newArr;
}
function removeFileExtDots($list,bool $strval=false) {
    $text=str_replace('.','',$list);
    return ($strval!=false)?$text:explode(',',$text);
}
function annotationString($str) {
    return str_replace(' -->','',str_replace('<!-- ','',$str));
}
function rom2num($roman) {
    $conv=[
        array("letter"=>'I', "number"=>1),
        array("letter"=>'V', "number"=>5),
        array("letter"=>'X', "number"=>10),
        array("letter"=>'L', "number"=>50),
        array("letter"=>'C', "number"=>100),
        array("letter"=>'D', "number"=>500),
        array("letter"=>'M', "number"=>1000),
        array("letter"=>0, "number"=>0)
    ]; $arabic=0; $state=0;
    $sidx=0; $len=strlen($roman);
    while ($len>=0) {
        $i=0; $sidx=$len;
        while ($conv[$i]['number']>0) {
            if (strtoupper(@$roman[$sidx])==$conv[$i]['letter']) {
                if ($state>$conv[$i]['number']) {
                    $arabic-=$conv[$i]['number'];
                } else {
                    $arabic+=$conv[$i]['number'];
                    $state=$conv[$i]['number'];
                }
            } $i++;
        } $len--;
    } return($arabic);
}
function num2rom($num,$isUpper=true) {
    $n=intval($num);
    $res='';
    $roman_numerals=[
        'M'=>1000,
        'CM'=>900,
        'D'=>500,
        'CD'=>400,
        'C'=>100,
        'XC'=>90,
        'L'=>50,
        'XL'=>40,
        'X'=>10,
        'IX'=>9,
        'V'=>5,
        'IV'=>4,
        'I'=>1
    ];
    foreach ($roman_numerals as $roman=>$number) {
        $matches=intval($n/$number);
        $res.=str_repeat($roman, $matches);
        $n=$n % $number;
    } if($isUpper) return $res;
    else return strtolower($res);
}
function chooseCalendar($time,array $prof,array $voc) {
    if ($prof['calendar']=='Julian') {
        $res=timedate($time,$prof,$voc,'date',(intval(date('Y')/100)-7));
    } elseif ($prof['calendar']=='French') {
        $res=french($time,$prof,$voc);
    } else { $res=timedate($time,$prof,$voc,'date'); }
    return $res;
}
function timedate($time,array $prof,array $voc,$mode='time',$offs=0) {
    $di=DateInterval::createFromDateString($offs.'day');
    $dt=new DateTime('@'.$time,(new DateTimeZone(dec_tz($prof['timezone']))));
    $dt->setTimeZone(new DateTimeZone(dec_tz($prof['timezone'])));
    $dat=date_sub($dt,$di)->format($prof[$mode.'_format']);
    if ($mode=='date') {
        if ($prof['roman']!=0) {
            $arr=preg_match_all('/\d+/',$dat,$matches);
            for ($i=0; $i<count($matches[0]); $i++) {
                $full=$matches[0][$i];
                $dat=str_replace($full,num2rom($full),$dat);
            } $arr=preg_match_all('/[a-zA-Z]+/',$dat,$matches);
            for ($i=0; $i<count($matches[0]); $i++) {
                $full=$matches[0][$i]; $dat=strtoupper($dat);
            }
        } $wek=$voc['locale']['weekday']['default'];
        $pat=$rep=[]; foreach ($wek as $k=>$v) {
            $pat[]='/'.$v.'/'; $rep[]=dayName(($k+1),$voc,$prof['units'],'weekday');
        } $dat=preg_replace($pat,$rep,$dat);
        $mon=$voc['locale']['month']['default'];
        $pat=$rep=[]; foreach ($mon as $k=>$v) {
            $pat[]='/'.$v.'/'; $rep[]=dayName(($k+1),$voc,$prof['units'],'month');
        } $dat=preg_replace($pat,$rep,$dat);
    } return $dat;
}
function zodiacSign($dayYear) {
    if (($dayYear>355)||($dayYear<19)) { $res="♑️";
    } elseif (($dayYear>18)&&($dayYear<49)) { $res="♒️";
    } elseif (($dayYear>48)&&($dayYear<80)) { $res="♓️";
    } elseif (($dayYear>79)&&($dayYear<110)) { $res="♈️";
    } elseif (($dayYear>109)&&($dayYear<141)) { $res="♉️";
    } elseif (($dayYear>140)&&($dayYear<172)) { $res="♊️";
    } elseif (($dayYear>171)&&($dayYear<204)) { $res="♋️";
    } elseif (($dayYear>203)&&($dayYear<235)) { $res="♌️";
    } elseif (($dayYear>234)&&($dayYear<266)) { $res="♍️";
    } elseif (($dayYear>265)&&($dayYear<296)) { $res="♎️";
    } elseif (($dayYear>295)&&($dayYear<326)) { $res="♏️";
    } elseif (($dayYear>325)&&($dayYear<356)) { $res="♐️";
    } return $res;
}
function prefixes(array $prof): array {
    return [
        (isColorLight($prof['back_text_color']))?'ava.':'abc.',
        (isColorLight($prof['fore_text_color']))?'ava.':'abc.',
        (isColorLight($prof['back_text_color']))?'iso.':'iec.',
        (isColorLight($prof['fore_text_color']))?'iso.':'iec.',
        (isColorLight($prof['back_text_color']))?'rtd.':'rtc.',
        (isColorLight($prof['fore_text_color']))?'rtd.':'rtc.'
    ];
}
function french($time,array $prof,array $voc): string {
    $leap=date('L',$time); $day=date('z',$time);
    $allYear=365+$leap; $newYear=263+$leap;
    $curDate=yearday($day,$allYear,$newYear);
    if ($curDate<=0) {
        $curMonth=(count($voc['locale']['french']['default'])-1);
        $showDate=(5+$leap);
    } else {
        $curMonth=(ceil($curDate/30)-1);
        $showDate=((($curDate%30)>0)?($curDate%30):30);
    } if (isset($voc['locale']['french'][$prof['units']][$curMonth])) {
        $showMonth=$voc['locale']['french'][$prof['units']][$curMonth];
    } else { $showMonth=$voc['locale']['french']['default'][$curMonth]; } return $showDate.' '.$showMonth;
}
function dayName($id=1,array $voc,$units='EU',$ent='month') {
    return (isset($voc['locale'][$ent][$units][$id-1]))?$voc['locale'][$ent][$units][$id-1]:$voc['locale'][$ent]['default'][$id-1];
}
function fixedSize($str,$offs=0,$len=1000) {
    $stl=strlen($str);$sts=abs($len-$offs);
    if (($offs<$len)&&($offs>=0)&&($len>0)&&($sts<$stl)) {
        if ($offs>0) {
            $res=($len<$stl)?('...'.substr($str,$offs,$len).'...'):('...'.substr($str,$offs,$stl));
        } else {
            $res=($len<$stl)?(substr($str,0,$len).'...'):(substr($str,0,$stl));
        }
    } else { $res=$str; } return $res;
}
function snakeToSpaces($str) {
    if (strpos($str,'_')!==false) {
        $arr=explode('_',$str);$res=[];
        foreach ($arr as $val) { $res[]=ucfirst($val); }
        $result=implode(' ',$res);
    } else { $result=ucfirst($str); }
    return $result;
}
function snakeToCamel($str) {
    if (strpos($str,'_')!==false) {
        $arr=explode('_',$str);$res='';
        foreach ($arr as $val) { $res.=ucfirst($val); }
        $result=$res;
    } else { $result=ucfirst($str); }
    return $result;
}
function wordfx($word,$sup,array $voc,array $ses) {
    $uni=$ses['units'];$vom=$voc['vocabulary'];$loc=$voc['locale'];
    $preg=preg_match_all('/\[[^\]]*\]/',$word,$matches);
    for ($i=0; $i<count($matches[0]); $i++) {
        $full=$matches[0][$i]; switch ($full) {
            case '[year]': $res=date('Y'); break;
            case '[years]':
                if (date('n')<3) {
                    // Fall/Winter of previous/this year
                    $res=(date('Y')-1).'/'.date('Y');
                } elseif (date('n')>8) {
                    // Fall/Winter of this/next year
                    $res=date('Y').'/'.(date('Y')+1);
                } else {
                    // Spring/Summer of this year
                    $res=date('Y');
                } break;
            case '[newyear]':
                // Past December this year, otherwise next
                $res=(date('n')<12)?date('Y'):(date('Y')+1); break;
            case '[id]': $res=$sup; break;
            // UNIX uname functions to get target server platform data
            case '[uname -a]': $res=php_uname('a'); break;
            case '[uname -s]': $res=php_uname('s'); break;
            case '[uname -n]': $res=php_uname('n'); break;
            case '[uname -r]': $res=php_uname('r'); break;
            case '[uname -v]': $res=php_uname('v'); break;
            case '[uname -m]': $res=php_uname('m'); break;
            case '[app_version]': $res=arropen('eurohouse.pkg')['version']; break;
            case '[sys_version]': $res=arropen('system.pkg')['version']; break;
            case '[server_ip]': $res=$_SERVER['SERVER_ADDR']; break;
            case '[free_disk_space]':
                // Get free disk space on web server
                $res=sizestr(disk_free_space('/'),$loc,$uni); break;
            case '[french]':
                // Display date in French Republican Calendar format
                $res=french(time(),$ses,$voc); break;
            case '[month]': case '[weekday]':
                // Get current month name
                $res=dayName(date('n'),$voc,$uni,str_replace(']','',str_replace('[','',$full))); break;
            case '[semester]':
                // Get current range of two seasons, namely Fall/Winter and Spring/Summer
                $qN=date('n')-1;$qM=intval(($qN>1)&&($qN<8));
                $res=(isset($loc['semester'][$uni][$qM]))?$loc['semester'][$uni][$qM]:$loc['semester']['default'][$qM]; break;
            case '[quarter]':
                // Get current season, namely Winter, Spring, Summer and Fall
                $qN=date('n')-1;$qM=(($qN>1)&&($qN<5))?1:((($qN>4)&&($qN<8))?2:((($qN>7)&&($qN<11))?3:0));
                $res=(isset($loc['quarter'][$uni][$qM]))?$loc['quarter'][$uni][$qM]:$loc['quarter']['default'][$qM]; break;
            default:
                // Get arbitrary user profile property
                if (strpos($full,':')!==false) {
                    $entl=str_replace(':','',str_replace(']','',str_replace('[','',$full)));
                    $itl=localizedTitle($ses,$entl);
                    $res=titleColon($itl,true,$voc,$ses);
                } elseif (strpos($full,'|')!==false) {
                    $entl=str_replace(']','',str_replace('[','',$full)); $entr=explode('|',$entl);
                    foreach ($entr as $ei=>$ed) {
                        $entd=localizedTitle($ses,$ed);
                        if ($entd!='') { break; }
                    } $res=$entd;
                } else {
                    $entl=str_replace(']','',str_replace('[','',$full)); $itl=localizedTitle($ses,$entl,1);
                    $res=titleColon($itl,false,$voc,$ses);
                } break;
        } $word=str_replace($full,$res,$word);
    } return $word;
}
function titleColon($itl,bool $cln=false,array $voc,array $ses) {
    $uni=$ses['units']; $vom=$voc['vocabulary']; $loc=$voc['locale'];
    $vun=($cln)?(($itl!='')?((isset($vom[$uni][': ']))?$vom[$uni][': ']:': '):''):''; return (in_array($uni,$loc['colon_ind']))?$vun.$itl:$itl.$vun;
}
function localizedTitle(array $ses,$entl,$vari=0) {
    $uni=$ses['units']; $entr=valarr($ses[$entl.'s'],';; ',':: ');
    if (isset($entr[$uni])) {
        if (strpos($entr[$uni],'|')!==false) {
            $itd=explode('|',$entr[$uni]);
            if (isset($itd[$vari])) {
                $itl=$itd[$vari];
            } else { $itl=$itd[0]; }
        } else { $itl=$entr[$uni]; }
    } else {
        if ($ses[$entl]!='') {
            $itl=$ses[$entl];
        } else { $itl=''; }
    } return $itl;
}
function titler($name,array $voc,array $ses) {
    $domain=explode('.',$name)[0];$volume=explode('.',$name)[1];
    $collection=fileopen($domain.'.collection.json','{}');
    return (isset($collection[$volume]['language'][$ses['units']]))?wordfx($collection[$volume]['language'][$ses['units']],$volume,$voc,$ses):((isset($collection[$volume]['title']))?wordfx($collection[$volume]['title'],$volume,$voc,$ses):$name);
}
function titled($name,$units='EU') {
    $domain=explode('.',$name)[0];
    $domFile=(@json_decode(file_get_contents($domain.'.pkg'),true)!=null)?json_decode(file_get_contents($domain.'.pkg'),true):[];
    if ((isset($domFile['language']))&&(is_array($domFile['language']))) {
        $lang=$domFile['language'];
        $res=(isset($lang[$units]))?$lang[$units]:$domFile['title'];
    } else { $res=$domFile['title']; } return $res;
}
function term($word='',array $voc,array $ses) {
    $res=(isset($voc['vocabulary'][$ses['units']][$word]))?$voc['vocabulary'][$ses['units']][$word]:$word; return $res;
}
function l10nEnt($cat='',$word='',array $voc,array $ses) {
    return (isset($voc['locale'][$cat][$word][$ses['units']]))?$voc['locale'][$cat][$word][$ses['units']]:$voc['locale'][$cat][$word]['default'];
}
function terms(array $voc,array $ses) {
    $arr=[]; $term=["Debit","Credit","Balance","Agent","Press any key to continue...","Name","Amount","Price","Active Hours:","The market is closed.","Symbolic Digits","Type","Title","Password","What's on your mind?","Type command or expression and press ENTER","Username"]; foreach ($term as $val) { $arr[$val]=term($val,$voc,$ses); } return $arr;
}