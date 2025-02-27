<?php
// EXECUTE REQUESTS
function wasAuth() {
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
function isAuth() { return (isset($_SESSION['user'])); }
function whichSess() {
    return (isset($_SESSION['user']))?$_SESSION['user']:'root';
}
function isAdmin() {
    return ((isset($_SESSION['user']))&&($_SESSION['user']=='root'));
}
function withReq($name) {
    if (strpos($name,'?')!==false) {
        $res=explode('?',$name)[0];
    } else { $res=$name; } return $res;
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
    elseif (preg_match('/macintosh|mac os x/i',$ua)) return 'macOS';
    elseif (preg_match('/windows|win32/i',$ua)) return 'Windows';
    return 'Other';
}
function vismark($name,$data='') {
    $test=arropen($name,'{}','');
    if ($data!='') {
        $isoCC=(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])))['geoplugin_countryCode'];
        $getWB=browserName($_SERVER['HTTP_USER_AGENT']);
        $getPF=platformName($_SERVER['HTTP_USER_AGENT']);
        $test[$_SERVER['REMOTE_ADDR'].'/'.$getWB.'/'.$getPF]=[
            "Username"=>$data,"Country"=>$isoCC
        ];file_put_contents($name,json_encode($test,JSON_UNESCAPED_UNICODE));chmod($name,0777);
    } return arropen($name,'{}','');
}
function parseReq($uri): array {
    $prot=explode('://',$uri)[0];$rest=explode('://',$uri)[1];
    $parts=explode('/',$rest);$prest=$parts;
    $host=$parts[0]; if (count($parts)>2) {
        $repo=$parts[count($parts)-1];
        unset($prest[count($prest)-1]);
        unset($prest[0]);$user=implode('/',$prest);
    } elseif (count($parts)==2) {
        $repo=$parts[1];$user='';
    } return ['host'=>$host,'prot'=>$prot,'repo'=>$repo,'user'=>$user];
}
function express(array $for) {
    foreach ($for as $pkg) {
        if (strpos($pkg,'>')!==false) {
            $uri=explode('>',$pkg)[0];$branch=explode('>',$pkg)[1];
            $host=parseReq($uri)['host'];$prot=parseReq($uri)['prot'];
            $repo=parseReq($uri)['repo'];$user=parseReq($uri)['user'];
        } else {
            $branch='';$host=parseReq($pkg)['host'];$prot=parseReq($pkg)['prot'];
            $repo=parseReq($pkg)['repo'];$user=parseReq($pkg)['user'];
        } $socketOpen=fsockopen($host,80,$errno,$errstr,10);
        if ($socketOpen!=false) {
            foreach ((str_replace('./','',(glob('./*.txt')))) as $file) {
                if (file_exists($file)) {
                    chmod($file,0777);rename($file,$file.'.bak');
                    chmod($file.'.bak',0777);
                }
            } if (file_exists($repo.'.pkg')) {
                foreach ((explode(';',fileopen($repo.'.pkg')['files'])) as $file) {
                    if (file_exists($file)) { chmod($file,0777); unlink($file); }
                } chmod($repo.'.pkg',0777); unlink($repo.'.pkg');
            } if (file_exists($repo)) { chmod($repo,0777); rename($repo,$repo.'.d'); }
            if ($branch!='') {
                exec('git clone -b '.$branch.' '.$prot.'://'.$host.'/'.$user.'/'.$repo);
            } else {
                exec('git clone '.$prot.'://'.$host.'/'.$user.'/'.$repo);
            } chmod($repo, 0777); exec('mv '.$repo.'/* $PWD');
            exec('chmod -R 777 .'); exec('rm -rf '.$repo);
            if (file_exists($repo.'.d')) {
                chmod($repo.'.d',0777); rename($repo.'.d',$repo);
            }
            foreach ((str_replace('./','',(glob('./*.md')))) as $file) {
                if (file_exists($file)) { chmod($file,0777); unlink($file); }
            } foreach ((str_replace('./','',(glob('./*.txt.bak')))) as $file) {
                if (file_exists($file)) {
                    chmod($file,0777); rename($file,str_replace('.txt.bak','.txt',$file));
                    chmod(str_replace('.txt.bak','.txt',$file),0777);
                }
            }
        }
    }
}
// BASIC DATA TYPES EXCHANGE
function pkgf($pkg,$ar=false) {
    if (@json_decode(file_get_contents($pkg.'.pkg'),true)!=null) {
        $pkgf=json_decode(file_get_contents($pkg.'.pkg'),true);
        $pkgl=(isset($pkgf['files']))?$pkgf['files']:'';
    } else { $pkgl=''; }
    $pkgr=($ar!==false)?explode(';',$pkgl):$pkgl;
    return $pkgr;
}
function excpkg(array $arr,$exc='',$flg=''): array {
    $new=$fin=$prt=$sup=$res=[];
    if ($flg=='COLLECTION') {
        foreach ($arr as $exem) {
            $el=explode('.', $exem)[0]; if ($exc!='') {
                if (strpos($exc,',')!==false) {
                    if (in_array($el,explode(',',$exc))) { $new[$el]=$exem; }
                } else {
                    if ($el==$exc) { $new[$el]=$exem; }
                }
            } else { $new[$el]=$exem; } $sup[$el]=$exem;
        } $res=(!empty($new))?$new:$sup;
    } elseif ($flg=='SERIES') {
        foreach ($arr as $exem) {
            $el=explode('.',$exem)[0]; if ($exc!='') {
                if (strpos($exc,',')!==false) {
                    if (in_array($el,explode(',',$exc))) {
                        $new[$exem]=$exem;
                    }
                } else {
                    if ($el==$exc) { $new[$exem]=$exem; }
                }
            } else { $new[$exem]=$exem; } $sup[$exem]=$exem;
        } $res=(!empty($new))?$new:$sup;
    } else {
        if ($exc!='') {
            if (strpos($exc,',')!==false) {
                foreach (explode(',',$exc) as $iter=>$pkg) {
                    $new=($iter==0)?pkgf($pkg,true):array_merge($new,pkgf($pkg,true));
                }
            } else { $new=pkgf($exc,true); }
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
function initiate($str='tmp') {
    $arr=explode(',',$str); foreach ($arr as $dir) {
        if (!file_exists('./.'.$dir)) {
            mkdir('./.'.$dir); chmod('./.'.$dir, 0777);
        }
    }
}
function paging($name,$opt=[0,2]): array {
    $arr=preg_split("/\r\n|\n|\r/",(file_get_contents($name)));$obj=[];
    foreach ($opt as $n) { $obj[$n]=$arr[$n]; } return $obj;
}
function pages($name): array {
    return preg_split("/\r\n|\n|\r/",(file_get_contents($name)));
}
function textopen($name,$default='') {
    $fileOpen=(file_exists($name))?file_get_contents($name):$default;
    return ($fileOpen!='')?$fileOpen:$default;
}
function fileopen($name,$default='') {
    $fileOpen=(file_exists($name))?file_get_contents($name):$default;
    return (@unserialize($fileOpen)!==false)?unserialize($fileOpen):((@json_decode($fileOpen,true)!=null)?json_decode($fileOpen,true):(((@paging($name)!==null)?paging($name):$fileOpen)));
}
function arropen($name,$default='{}',$exec='') {
    if (!file_exists($name)) {
        file_put_contents($name,$default); chmod($name,0777);
    } $test=file_get_contents($name);
    if (@json_decode($test,true)!=null) {
        file_put_contents($name.'.bak',$test); chmod($name.'.bak',0777);
    } else {
        copy($name.'.bak',$name); chmod($name,0777);
    } if ($exec=='DEFAULT') {
        $tryit=json_decode(file_get_contents($name),true);
        file_put_contents($name,json_encode(equarr(json_decode($default,true),$tryit)));
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
function jsonline($name) {
    $test=file_get_contents($name); $res="{\"\":\"\"}";
    if (@json_decode($test,true)!=null) {
        $arr=json_decode($test,true);$res=json_encode($arr);
    } return $res;
}
function equarr(array $src,array $des) {
    foreach ($src as $key=>$val) {
        if (!isset($des[$key])) { $des[$key]=$val; }
    } foreach ($des as $key=>$val) {
        if (!isset($src[$key])) { unset($des[$key]); }
    } return $des;
}
// LOADING DATA DYNAMICALLY WITH THESE FUNCTIONS
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
// MISCELLANEOUS FUNCTIONS
function modelcard($id,$cont,$exem,$ses,$sti) {
    $uni=$ses['units']; $loc=$sti['locale']; $voc=$sti['vocabulary'];
    $anno=(isset($loc['anno'][$uni]))?$loc['anno'][$uni]:$loc['anno']['default']; if (isset($exem[$id])) { $ent=$exem[$id];
        $hd=(isset($ent['language'][$uni]['title']))?$ent['language'][$uni]['title']:$id;
        $len=(isset($ent['height']))?((isset($loc['length'][$uni]))?((isset($loc['length'][$uni]['inch']))?incher($ent['height']):round(($ent['height']*$loc['length'][$uni]['coefficient']),2).' '.$loc['length'][$uni]['sign']):round(($ent['height']*$loc['length']['default']['coefficient']),2).' '.$loc['length']['default']['sign']):'';
        $mas=(isset($ent['weight']))?((isset($loc['mass'][$uni]))?(round($ent['weight']*$loc['mass'][$uni]['coefficient']).' '.$loc['mass'][$uni]['sign']):round($ent['weight']*$loc['mass']['default']['coefficient']).' '.$loc['mass']['default']['sign']):'';
        $szs=(isset($ent['sizes']))?((isset($loc['length'][$uni]['inch']))?(round(explode('-',$ent['sizes'])[0]*$loc['length'][$uni]['coefficient']).'-'.round(explode('-',$ent['sizes'])[1]*$loc['length'][$uni]['coefficient']).'-'.round(explode('-',$ent['sizes'])[2]*$loc['length'][$uni]['coefficient'])):(explode('-',$ent['sizes'])[0].'-'.explode('-',$ent['sizes'])[1].'-'.explode('-',$ent['sizes'])[2])):'';
        $shs=(isset($ent['shoe_size']))?((isset($loc['shoe_size'][$uni]))?(($ent['shoe_size']+$loc['shoe_size'][$uni]).' '.$uni):($ent['shoe_size']+$loc['shoe_size']['default']).' '.$uni):''; if (isset($ent['birthday'])) {
            $bday=(isset($ent['birthday']))?$ent['birthday']:'January 1, 1970';
            $ba=(round((time()-strtotime($bday))/(3600*24*365.25)));
            $bd=date('j',strtotime($bday)); $bm=date('n',strtotime($bday));
            $bc=date('z',strtotime($bday)); $bk=(($bd==date('j'))&&($bm==date('n')))?"🎂":"";
            if (in_array($uni,$loc['anno_ind']['space'])) { $dp=$ba.' '.$anno;
            } elseif (in_array($uni,$loc['anno_ind']['concat'])) { $dp=$anno.$ba;
            } else { $dp=$anno.' '.$ba; }
            $bl=zodiacSign($bc).' ('.date($ses['date_format'],strtotime($bday)).') '.$dp.' '.$bk;
        } else { $bl=''; } $dl=$hd.' '.$bl.' '.$len.' '.$mas.' '.$szs.' '.$shs;
    } else { $dl=''; } return $dl;
}
function onlylocks($arr) {
    $res=[]; foreach ($arr as $key=>$val) {
        if (str_starts_with($key,'lock_')!==false) { $res[$key]=$val; }
    } return $res;
}
function userlocks($arr,$col,$ava) {
    $res=[]; $prep=onlylocks($arr); foreach ($prep as $key=>$val) {
        $lib=($key=='lock_avatar')?str_replace('./','',(glob('./'.$ava.'*.png'))):(($key=='lock_background')?str_replace('./','',(glob('./*.*.00.png'))):str_replace('./','',(glob('./*.{'.duplex($col[$key],true).'}',GLOB_BRACE))));
        if ($key=='lock_background') { $res[$key]=excpkg($lib,$prep[$key],'COLLECTION');
        } else { $res[$key]=excpkg($lib,$prep[$key]); }
        natcasesort($res[$key]); array_unique($res[$key]);
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
function duplex($list,bool $txt=false) {
    $text=str_replace('.','',$list);
    return ($txt!=false)?$text:explode(',',$text);
}
function escHTML($str) {
    return str_replace(' -->','',str_replace('<!-- ','',$str));
}
function zodiacSign($d) {
    if (($d>355)||($d<19)) { $r="♑️";
    } elseif (($d>18)&&($d<49)) { $r="♒️";
    } elseif (($d>48)&&($d<80)) { $r="♓️";
    } elseif (($d>79)&&($d<110)) { $r="♈️";
    } elseif (($d>109)&&($d<141)) { $r="♉️";
    } elseif (($d>140)&&($d<172)) { $r="♊️";
    } elseif (($d>171)&&($d<204)) { $r="♋️";
    } elseif (($d>203)&&($d<235)) { $r="♌️";
    } elseif (($d>234)&&($d<266)) { $r="♍️";
    } elseif (($d>265)&&($d<296)) { $r="♎️";
    } elseif (($d>295)&&($d<326)) { $r="♏️";
    } elseif (($d>325)&&($d<356)) { $r="♐️";
    } return $r;
}
function french(array $voc,$units='EU'): string {
    $allYear=365+date('L');$newYear=263+date('L');
    $curDate=offnum(date('z'),$allYear,$newYear);
    if ($curDate<=0) {
        $curMonth=(count($voc['locale']['french']['default'])-1);
        $showDate=(5+date('L'));
    } else {
        $curMonth=(ceil($curDate/30)-1);
        $showDate=((($curDate % 30)>0)?($curDate%30):30);
    } if (isset($voc['locale']['french'][$units][$curMonth])) {
        $showMonth=$voc['locale']['french'][$units][$curMonth];
    } else { $showMonth=$voc['locale']['french']['default'][$curMonth];
    } return $showDate.' '.$showMonth;
}
function spaces($str) {
    if (strpos($str,'_')!==false) {
        $arr=explode('_',$str);$res=[];
        foreach ($arr as $val) { $res[]=ucfirst($val); }
        $result=implode(' ',$res);
    } else { $result=ucfirst($str); }
    return $result;
}
function camel($str) {
    if (strpos($str, '_')!==false) {
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
            case '[free_disk_space]':
                // Get free disk space on web server
                $res=sizestr(disk_free_space('/'),$loc,$uni); break;
            case '[french]':
                // Display date in French Republican Calendar format
                $res=french($voc,$uni); break;
            case '[month]':
                // Get current month
                $res=(isset($loc['month'][$uni][date('n')-1]))?$loc['month'][$uni][date('n')-1]:$loc['month']['default'][date('n')-1]; break;
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
                $entl=(strpos($full,':')!==false)?str_replace(':','',str_replace(']','',str_replace('[','',$full))):str_replace(']','',str_replace('[','',$full)); $itl=locTitle($ses,$entl);
                $vun=(strpos($full,':')!==false)?(($itl!='')?((isset($vom[$uni][': ']))?$vom[$uni][': ']:': '):''):''; $res=(in_array($uni,$loc['colon_ind']))?$vun.$itl:$itl.$vun; break;
        } $word=str_replace($full,$res,$word);
    } return $word;
}
function locTitle(array $ses,$entl) {
    $uni=$ses['units']; $entr=valarr($ses[$entl.'s'],' | ',' - ');
    $itl=(isset($entr[$uni]))?$entr[$uni]:(($ses[$entl]!='')?$ses[$entl]:'');
    return $itl;
}
function titler($name,array $voc,array $ses) {
    $domain=explode('.',$name)[0];$volume=explode('.',$name)[1];
    $collection=fileopen($domain.'.collection.json','{}');
    return (isset($collection[$volume]['language'][$ses['units']]))?wordfx($collection[$volume]['language'][$ses['units']],$volume,$voc,$ses):((isset($collection[$volume]['title']))?wordfx($collection[$volume]['title'],$volume,$voc,$ses):$name);
}
function titled($name,$units='EU') {
    $domain=explode('.',$name)[0];
    $domFile=(@json_decode(file_get_contents($domain.'.pkg'),true)!=null)?json_decode(file_get_contents($domain.'.pkg'),true):[];
    if (isset($domFile['language'])) {
        $lang=valarr($domFile['language'],'. ',' - ');
        $res=(isset($lang[$units]))?$lang[$units]:$domFile['title'];
    } else { $res = $domFile['title']; } return $res;
}
function term($word,array $voc,$units='EU') {
    return (isset($voc[$units][$word]))?$voc[$units][$word]:$word;
}
function localword($word,array $voc,$units='EU') {
    return (isset($voc[$word][$units]))?$voc[$word][$units]:$voc[$word]['default'];
}