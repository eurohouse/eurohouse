<?php
/* FILES AND DATA */
function valstr(array $arr,$y='; ',$x=': '): string {
    $lines=''; foreach ($arr as $key=>$val) {
        $lines.=$key.$x.$val.$y;
    } return $lines;
}
function valarr(string $str,$y='; ',$x=': '): array {
    $arr=explode($y,$str);
    $newArr=[]; foreach ($arr as $val) {
        $newStr=explode($x,$val);
        $newArr[$newStr[0]]=$newStr[1];
    } return $newArr;
}
function visitor($username='') {
    $vis=fileopen('visitors.json',json_encode($settings['ip_address']),'create');
    if ($username!='') {
        $ip=$_SERVER['REMOTE_ADDR']??'127.0.0.1';
        $ua=$_SERVER['HTTP_USER_AGENT']??'';
        $os='Unknown';
        if (preg_match('/Windows NT 10.0/i',$ua)) $os='Windows 10';
        elseif (preg_match('/Windows NT 6.3/i',$ua)) $os='Windows 8.1';
        elseif (preg_match('/Windows NT 6.2/i',$ua)) $os='Windows 8';
        elseif (preg_match('/Windows NT 6.1/i',$ua)) $os='Windows 7';
        elseif (preg_match('/Windows NT 6.0/i',$ua)) $os='Windows Vista';
        elseif (preg_match('/Windows NT 5.1/i',$ua)) $os='Windows XP';
        elseif (preg_match('/Mac OS X/i',$ua)) $os='macOS';
        elseif (preg_match('/Linux/i',$ua)&&!preg_match('/Android/i',$ua)) $os='Linux';
        elseif (preg_match('/Android/i',$ua)) $os='Android';
        elseif (preg_match('/iPhone|iPad|iPod/i',$ua)) $os='iOS';
        $browser='Unknown';
        if (preg_match('/Edg\/([\d.]+)/i',$ua,$m)) $browser='Edge '.$m[1];
        elseif (preg_match('/Chrome\/([\d.]+)/i',$ua,$m)) $browser='Chrome '.$m[1];
        elseif (preg_match('/Firefox\/([\d.]+)/i',$ua,$m)) $browser='Firefox '.$m[1];
        elseif (preg_match('/Safari\/([\d.]+)/i',$ua)&&!preg_match('/Chrome|Edg/i',$ua)) $browser='Safari '.$m[1];
        elseif (preg_match('/OPR\/([\d.]+)/i',$ua,$m)) $browser='Opera '.$m[1];
        elseif (preg_match('/MSIE ([\d.]+)/i',$ua,$m)) $browser='Internet Explorer '.$m[1];
        $country='UN';
        $context=stream_context_create(['http'=>['timeout'=>5]]);
        $response=@file_get_contents("https://ipapi.co/$ip/country_code/",false,$context);
        if ($response!==false) { $country=trim($response); }
        $vis[$_SERVER['REMOTE_ADDR']]=[
            'user'=>$username,'country'=>$country,
            'os'=>$os,'browser'=>$browser
        ]; if (isset($vis[0])) { unset($vis[0]); }
        file_put_contents('visitors.json',json_encode($vis,JSON_UNESCAPED_UNICODE)); chmod('visitors.json',0777);
    } return $vis;
}
function paging($name,$opt=[]): array {
    $arr=preg_split("/\r\n|\n|\r/",(file_get_contents($name)));
    $obj=[]; if (!empty($opt)) {
        foreach ($opt as $n) { $obj[$n]=$arr[$n]; }
    } else {
        foreach ($arr as $n=>$m) { $obj[$n]=$m; }
    } return $obj;
}
function fileopen($name,$default='',$options='') {
    if (preg_match('/create/i',$options)) {
        if (!file_exists($name)) {
            file_put_contents($name,$default);
            chmod($name,0777);
        } $content=(file_exists($name))?file_get_contents($name):$default;
    } elseif (preg_match('/backup/i',$options)) {
        $content=(file_exists($name))?file_get_contents($name):$default;
        if (@json_decode($content,true)!=null) {
            file_put_contents($name.'.bak',$content);
            chmod($name.'.bak',0777);
        } elseif ($content=='{}') {
            if (preg_match('/restore/i',$options)) {
                copy($name.'.bak',$name); chmod($name,0777);
            } else {
                file_put_contents($name.'.bak',$content);
                chmod($name.'.bak',0777);
            }
        } else {
            if (preg_match('/restore/i',$options)) {
                copy($name.'.bak',$name); chmod($name,0777);
            }
        }
    } else {
        $content=(file_exists($name))?file_get_contents($name):$default;
    } if (@unserialize($content)!==false) {
        $result=(preg_match('/raw|text/i',$options))?$content:unserialize($content);
    } elseif (@json_decode($content,true)!=null) {
        if (preg_match('/union|fallback/i',$options)) {
            if (@json_decode($default,true)!=null) {
                $result=(preg_match('/raw|text/i',$options))?json_encode(mirrorArrays(json_decode($default,true),json_decode($content,true)),JSON_UNESCAPED_UNICODE):mirrorArrays(json_decode($default,true),json_decode($content,true));
            } else {
                $result=(preg_match('/raw|text/i',$options))?$content:json_decode($content,true);
            }
        } else {
            $result=(preg_match('/raw|text/i',$options))?$content:json_decode($content,true);
        }
    } else {
        if (preg_match('/single|oneliner/i',$options)) {
            if (@paging($name)!==null) {
                $result=(preg_match('/raw|text/i',$options))?$content:paging($name,[0]);
            } else { $result=$content; }
        } else {
            if (@paging($name)!==null) {
                $result=(preg_match('/raw|text/i',$options))?$content:paging($name);
            } else { $result=$content; }
        }
    } return $result;
}
function mirrorArrays($arr1,$arr2) {
    foreach ($arr1 as $key=>$val) {
        if (!isset($arr2[$key])) {
            $arr2[$key]=$val;
        }
    } foreach ($arr2 as $key=>$val) {
        if (!isset($arr1[$key])) {
            unset($arr2[$key]);
        }
    } return $arr2;
}
function dir_size($path): int {
    $bytestotal=0;$path=realpath($path);
    if (($path!==false)&&($path!='')&&(file_exists($path))) {
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path,FilesystemIterator::UNIX_PATHS)) as $object) { $bytestotal+=$object->getSize(); }
    } return $bytestotal;
}
/* PACKAGE MANAGER */
function pkgFiles($pkg) {
    if (@json_decode(file_get_contents($pkg.'.package.json'),true)!=null) {
        $pkgf=json_decode(file_get_contents($pkg.'.package.json'),true);
        $pkgl=(isset($pkgf['files']))?$pkgf['files']:[];
    } else { $pkgl=[]; } return $pkgl;
}
function gitExec($url) {
    $urlPart=parse_url($url);
	$urlEndPt=array_reverse(explode('/',$urlPart['path']))[0];
    file_put_contents('get.lock',''); chmod('get.lock',0777);
    $fsockopen=fsockopen($urlPart['host'],80,$errno,$errstr,10);
    if ($fsockopen!=false) {
        if (file_exists($urlEndPt.'.package.json')) {
            $package=(@json_decode(file_get_contents($urlEndPt.'.package.json'),true)!=null)?json_decode(file_get_contents($urlEndPt.'.package.json'),true):['files'=>''];
            foreach ($package['files'] as $file) {
                if (file_exists($file)) {
                    chmod($file,0777); unlink($file);
                }
            } chmod($urlEndPt.'.package.json',0777); unlink($urlEndPt.'.package.json');
        } if (file_exists($urlEndPt)) {
            chmod($urlEndPt,0777); rename($urlEndPt,$urlEndPt.'-backup');
        } exec('git clone '.$url);
        chmod($urlEndPt,0777); exec('mv '.$urlEndPt.'/* $PWD');
        exec('chmod -vR 777 .'); exec('rm -vr '.$urlEndPt);
        if (file_exists($urlEndPt.'-backup')) {
            chmod($urlEndPt.'-backup',0777); rename($urlEndPt.'-backup',$urlEndPt);
        }
    } chmod('get.lock',0777); unlink('get.lock');
}
/* REPOSITORY */
function limitPkg(array $arr,$cat,$exc=''): array {
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
                        $new=array_diff($new,pkgFiles($pkg));
                    }
                } else { $new=array_diff($new,pkgFiles($exr)); }
            } else {
                if (strpos($exc,',')!==false) {
                    foreach (explode(',',$exc) as $iter=>$pkg) {
                        $new=($iter==0)?pkgFiles($pkg,true):array_merge($new,pkgFiles($pkg));
                    }
                } else { $new=pkgFiles($exc); }
            }
        } else { $new=$arr; } foreach ($new as $val) {
            if (in_array($val,$arr)!==false) { $fin[]=$val; }
        } $res=(!empty($fin))?array_unique($fin):array_unique($arr);
    } return $res;
}
function userSubscr($arr,$col,array $pic) {
    $res=[]; foreach ($arr as $key=>$val) {
        if ($key=='avatar') {
            $lib=str_replace('./','',(glob('./'.$pic[0].'*.png')));
        } elseif ($key=='pictogram') {
            $lib=str_replace('./','',(glob('./'.$pic[3].'*.png')));
        } elseif ($key=='background') {
            $lib=str_replace('./','',(glob('./*.*.00.png')));
        } else {
            $lib=str_replace('./','',(glob('./*.{'.fileExt($col[$key],true).'}',GLOB_BRACE)));
        } $res[$key]=limitPkg($lib,$key,$arr[$key]);
    } return $res;
}
function exemplar(array $arr): array {
    $newArr=[]; foreach ($arr as $exem) {
        $ober=fileopen($exem); foreach ($ober as $key=>$val) { $newArr[$key]=$val; }
    } return $newArr;
}
function modelcard($id,$cont,$exem,$ses,$sti) {
    $uni=$ses['units']; $loc=$sti['locale'];
    $voc=$sti['vocabulary'];
    $annoInd=(isset($loc['anno'][$uni]))?$loc['anno'][$uni]:$loc['anno']['default'];
    $daysInd=(isset($loc['days'][$uni]))?$loc['days'][$uni]:$loc['days']['default'];
    if (isset($exem[$id])) {
        $ent=$exem[$id];
        $title=(isset($ent['language'][$uni]['title']))?$ent['language'][$uni]['title']:((isset($ent['title']))?$ent['title']:$id);
        $text=(isset($ent['language'][$uni]['text']))?$ent['language'][$uni]['text']:((isset($ent['text']))?$ent['text']:$title);
        $url=(isset($ent['url']))?$ent['url']:'';
        $ava=(isset($ent['avatar']))?$ent['avatar']:$ses['avatar'];
        $len=(isset($ent['height']))?((isset($loc['length'][$uni]))?((isset($loc['length'][$uni]['inch']))?incher($ent['height']):round(($ent['height']*$loc['length'][$uni]['coefficient']),2).' '.$loc['length'][$uni]['sign']):round(($ent['height']*$loc['length']['default']['coefficient']),2).' '.$loc['length']['default']['sign']):'? '.((isset($loc['length'][$uni]))?$loc['length'][$uni]['sign']:$loc['length']['default']['sign']);
        $mas=(isset($ent['weight']))?((isset($loc['mass'][$uni]))?(round($ent['weight']*$loc['mass'][$uni]['coefficient']).' '.$loc['mass'][$uni]['sign']):round($ent['weight']*$loc['mass']['default']['coefficient']).' '.$loc['mass']['default']['sign']):'? '.((isset($loc['mass'][$uni]))?$loc['mass'][$uni]['sign']:$loc['mass']['default']['sign']);
        $bod=(isset($ent['sizes']))?((isset($loc['length'][$uni]['inch']))?(round(explode('-',$ent['sizes'])[0]*$loc['length'][$uni]['coefficient']).'-'.round(explode('-',$ent['sizes'])[1]*$loc['length'][$uni]['coefficient']).'-'.round(explode('-',$ent['sizes'])[2]*$loc['length'][$uni]['coefficient'])):(explode('-',$ent['sizes'])[0].'-'.explode('-',$ent['sizes'])[1].'-'.explode('-',$ent['sizes'])[2])):'C-W-H';
        $sho=(isset($ent['shoe_size']))?((isset($loc['shoe_size'][$uni]))?(($ent['shoe_size']+$loc['shoe_size'][$uni]).' '.$uni):($ent['shoe_size']+$loc['shoe_size']['default']).' '.$uni):'? '.$uni;
        $bday=(isset($ent['birthday']))?$ent['birthday']:"now";
        $dday=(isset($ent['deathday']))?$ent['deathday']:"now";
        $today=date_create("now");
        $bdT=date_create($bday); $ddT=date_create($dday);
        $annoDiff=(isset($ent['birthday']))?(date_diff($bdT,$ddT)->format('%y')):'?';
        $nextBday=new DateTime();
        $nextBday->setDate($today->format('Y'),$bdT->format('m'),$bdT->format('d'));
        if ($nextBday<$today) {
            $nextBday->modify('+1 year');
        } $interval=$today->diff($nextBday);
        $daysDiff=(isset($ent['birthday']))?($interval->days):'?';
        $cakeT=((date('j',strtotime($bday))==date('j'))&&(date('n',strtotime($bday))==date('n')))?" 🎂":"";
        $annoT=(in_array($uni,$loc['meter_ind']['space']))?$annoDiff.' '.$annoInd:((in_array($uni,$loc['meter_ind']['concat']))?$annoInd.$annoDiff:$annoInd.' '.$annoDiff);
        $daysT=(in_array($uni,$loc['meter_ind']['space']))?$daysDiff.' '.$daysInd:((in_array($uni,$loc['meter_ind']['concat']))?$daysInd.$daysDiff:$daysInd.' '.$daysDiff);
        $zodT=zodiacSign(date('z',strtotime($bday)));
        $dateT=chooseCalendar(strtotime($bday),$ses,$sti);
        $titleZ=((isset($ent['birthday']))?$zodT.' '.$title.$cakeT:$title);
        $textT=((isset($ent['birthday']))?($zodT.' '.$title.$cakeT.' ('.$annoT.((($daysDiff!=0)&&($daysDiff!='?'))?(', '.term('birthday in',$sti,$ses).' '.$daysT):'').')'):$text);
        $res=[
            'title'=>$title,'zodiac'=>$titleZ,
            'text'=>$textT,'url'=>$url,'avatar'=>$ava,
            'age'=>$annoT,'days'=>$daysT,
            'height'=>$len,'weight'=>$mas,
            'sizes'=>$bod,'shoe_size'=>$sho
        ];
    } else {
        $res=[
            'title'=>localizedTitle($ses,'title'),
            'zodiac'=>localizedTitle($ses,'title'),
            'text'=>titleCommand('[codename:]',$sti,$ses).titleCommand('[project|title]',$sti,$ses),
            'url'=>'','avatar'=>$ses['avatar'],
            'age'=>0,'height'=>0,'weight'=>0,
            'sizes'=>'0-0-0','shoe_size'=>0
        ];
    } return $res;
}
function cutstring($text,$offs=0,$end=0) {
    $len=strlen($text);
    if ($offs>0) {
        if (($end>=$len)||($end<=0)) {
            $res='...'.substr($text,$offs,$len);
        } else {
            $res='...'.substr($text,$offs,$end).'...';
        }
    } elseif ($offs==0) {
        if (($end>=$len)||($end<=0)) {
            $res=substr($text,$offs,$len);
        } else {
            $res=substr($text,$offs,$end).'...';
        }
    } else {
        $res='...'.substr($text,$offs);
    } return $res;
}
/* REQUESTS TO SERVER */
function wasAuthRequest() {
    if ((isset($_POST['auth']))&&(isset($_POST['login']))&&(isset($_POST['password']))) {
        $auth=$_POST['auth']; $login=$_POST['login']; $pass=$_POST['password'];
        if ((($auth=='signin')||($auth=='signup'))&&($login!='')&&($pass!='')) {
            if (!file_exists($login.'_files')) {
                mkdir($login.'_files'); chmod($login.'_files',0777);
            } if (file_exists($login.'_files/password')) {
                $passFile=file_get_contents($login.'_files/password');
                if (($pass==$passFile)&&(preg_match('/^[a-f0-9]{64}$/i',$passFile))) {
                    $_SESSION['user']=$login;
                }
            } else {
                file_put_contents($login.'_files/password',$pass);
                chmod($login.'_files/password',0777);
                $passFile=file_get_contents($login.'_files/password');
                if (($pass==$passFile)&&(preg_match('/^[a-f0-9]{64}$/i',$passFile))) {
                    $_SESSION['user']=$login;
                }
            }
        } elseif (($auth=='signout')&&($login=='')&&($pass=='')) {
            if (isset($_SESSION['user'])) { unset($_SESSION['user']); }
        }
    }
}
function wasFileRequest() {
    if ((!empty($_FILES['file']['tmp_name']))&&(!empty($_POST['path']))) { $filename=$_FILES["file"]["name"];
        $path=$_POST['path']; if ($path!="/") { $path.="/"; }
        chmod($_FILES["file"]["tmp_name"],0777);
        move_uploaded_file($_FILES["file"]["tmp_name"],$path.$filename);
        chmod($path.$filename,0777);
    }
}
function urlStatusCode($url,$timeout=5) {
    $context=stream_context_create([
        'http'=>[
            'method'=>'HEAD',
            'timeout'=>$timeout,
        ]
    ]); $headers=@get_headers($url,0,$context);
    if ((!$headers)||(!is_array($headers))||(empty($headers))) {
        return false;
    } preg_match('#^HTTP/\d\.\d\s+(\d+)#',$headers[0],$matches);
    return isset($matches[1])?(int)$matches[1]:false;
}
function isAuthorized() { return (isset($_SESSION['user'])); }
function whichSession($defaultUsername) {
    return (isset($_SESSION['user']))?$_SESSION['user']:$defaultUsername;
}
function whichCookie($defaultUsername) {
    return (isset($_COOKIE['user']))?$_COOKIE['user']:$defaultUsername;
}
function isUserRoot($defaultUsername) {
    return ((isset($_SESSION['user']))&&($_SESSION['user']==$defaultUsername));
}
function getPaths(array $array,string $prefix=''): array {
    $paths=[]; foreach ($array as $key=>$value) {
        $key=(string)$key;
        $currentPath=$prefix?$prefix.'/'.$key:$key;
        if (is_array($value)) {
            $paths=array_merge($paths,getPaths($value,$currentPath));
        } else { $paths[]=$currentPath; }
    } return $paths;
}
function path_root($path) { return preg_match('/^([\/]+)$/i',$path); }
function path_trim($path) { return str_replace('/','',$path); }
function path_rel($path) { return (str_starts_with($path,'/')===false); }
/* CALENDAR/CLOCK AND DATE/TIME */
function hhmmss($nums) {
    $hh=$mm=$ss=0;$isHour=floor($nums/3600);
    $hh=sprintf('%02d',floor($nums/3600));
    $num=$nums%3600;$mm=sprintf('%02d',floor($num/60));
    $ss=sprintf('%02d',floor($num%60));
    return ($nums<0)?'--:--':(($isHour==0)?($mm.':'.$ss):($hh.':'.$mm.':'.$ss));
}
function yearday($pos=0,$all=360,$off=90) {
    return abs(($pos+$all-abs($off))%$all);
}
function chooseCalendar($time,array $prof,array $voc) {
    if ($prof['calendar']=='Julian') {
        $res=timedate($time,$prof,$voc,'date',(intval(date('Y')/100)-7));
    } elseif ($prof['calendar']=='French') {
        $res=french($time,$prof,$voc,true);
    } elseif ($prof['calendar']=='Byzantine Julian') {
        $res=timedate($time,$prof,$voc,'date',(intval(date('Y')/100)-7),-5508);
    } elseif ($prof['calendar']=='Byzantine Gregorian') {
        $res=timedate($time,$prof,$voc,'date',0,-5508);
    } else { $res=timedate($time,$prof,$voc,'date'); }
    return $res;
}
function timedate($time,array $prof,array $voc,$mode='time',$offD=0,$offY=0) {
    $di=DateInterval::createFromDateString($offY.'year '.$offD.'day');
    $dt=new DateTime('@'.$time,(new DateTimeZone(base64_decode($prof['timezone']))));
    $dt->setTimeZone(new DateTimeZone(base64_decode($prof['timezone'])));
    $dat=date_sub($dt,$di)->format(($mode=='hhmmss')?'H:i:s':$prof[$mode.'_format']); if ($mode=='date') {
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
function french($time,array $prof,array $voc,$isYear=false): string {
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
    } else {
        $showMonth=$voc['locale']['french']['default'][$curMonth];
    } $showYear=date('Y',$time)-1791;
    return $showDate.' '.$showMonth.(($isYear)?(', '.$showYear):'');
}
function dayName($id=1,array $voc,$units='EU',$ent='month') {
    return (isset($voc['locale'][$ent][$units][$id-1]))?$voc['locale'][$ent][$units][$id-1]:$voc['locale'][$ent]['default'][$id-1];
}
/* NOMINATIONS */
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
function alphaChannel($hex='#000000',$opa='IF') {
    return strtoupper('#'.(substr($hex,1,6)).((strlen($hex)>7)?(substr($hex,7,9)):(($opa=='IF')?'00':(($opa=='FI')?'FF':dechex($opa)))));
}
function themed(string $theme,string $assets='head'): bool {
    $arr=explode(',',$assets);$basket=true;
    foreach ($arr as $val) {
        $basket=$basket&&file_exists($theme.$val.'.png');
    } return $basket;
}
function dailyWallpaper(array $ses) {
    $backPart=explode('.',$ses['background_buffer']);
    $backBaseName=$backPart[0].'.'.$backPart[1];
    $listHours=str_replace('./','',(glob('./'.$backBaseName.'.{00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23}.png',GLOB_BRACE))); if ($ses['background']!='') {
        $res=$ses['background'];
    } else {
        if (($ses['slideshow']!=0)&&($ses['slideshow']!='')) {
            $secSince00H=date('H')*3600+date('i')*60+date('s');
            $imageIndex=sprintf("%02d",(floor($secSince00H/$ses['slideshow'])%count($listHours)));
        } else {
            $imageIndex=sprintf("%02d",(floor(count($listHours)*(date('H')/24))));
        } $res=$backBaseName.'.'.$imageIndex.'.png';
    } return $res;
}
function searchElements($arr,$keywords='') {
    $words=array_filter(array_map('trim',explode(',',$keywords)));
    if (empty($words)) { return $arr; }
    $result=[]; foreach ($arr as $key=>$item) {
        $matchesAllWords=true;
        foreach ($words as $word) {
            $word=strtolower($word);
            if (strpos(strtolower($key),$word)!==false) { continue; }
            if (is_array($item)&&isset($item['keywords'])) {
                $keywordList=array_map('trim',explode(',',$item['keywords']));
                $keywordList=array_map('strtolower',$keywordList);
                if (in_array($word,$keywordList,true)) { continue; }
            } $matchesAllWords=false; break;
        } if ($matchesAllWords) { $result[$key]=$item; }
    } return $result;
}
function isListCollections($list) {
    $arr=explode(',',$list);
    for ($i=0; $i<count($arr); $i++) {
        if (!file_exists($arr[$i].'.collection.json')) {
            return false;
        }
    } return true;
}
function isListLocales($list) {
    $arr=explode(',',$list);
    for ($i=0; $i<count($arr); $i++) {
        if ((strlen($arr[$i])!=2)&&($arr[$i]!=strtoupper($arr[$i]))) {
            return false;
        }
    } return true;
}
function fileExt($list,bool $strval=false) {
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
    $n=intval($num); $res='';
    $roman_numerals=[
        'M'=>1000,'CM'=>900,'D'=>500,
        'CD'=>400,'C'=>100,'XC'=>90,
        'L'=>50,'XL'=>40,'X'=>10,
        'IX'=>9,'V'=>5,'IV'=>4,'I'=>1
    ]; foreach ($roman_numerals as $roman=>$number) {
        $matches=intval($n/$number);
        $res.=str_repeat($roman,$matches);
        $n=$n%$number;
    } return ($isUpper)?$res:strtolower($res);
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
            case '[server_ip]': $res=$_SERVER['SERVER_ADDR']; break;
            case '[remote_ip]': $res=$_SERVER['REMOTE_ADDR']; break;
            case '[free_disk_space]':
                // Get free disk space on web server
                $res=sizestr(disk_free_space('/'),$loc['size'],$uni); break;
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
                $res=titleCommand($full,$voc,$ses); break;
        } $word=str_replace($full,$res,$word);
    } return $word;
}
function titleCommand($full,array $voc,array $ses) {
    if (strpos($full,'|')!==false) {
        $entl=str_replace(']','',str_replace('[','',$full));
        $entr=explode('|',$entl); foreach ($entr as $itm) {
            $itr=(strpos($itm,':')!==false)?str_replace(':','',$itm):$itm;
            $enti=(strpos($itr,'^')!==false)?explode('^',$itr)[0]:$itr;
            $entj=(strpos($itr,'^')!==false)?explode('^',$itr)[1]:0;
            $itl=localizedTitle($ses,$enti,$entj);
            $entd=titleColon($itl,(strpos($itm,':')!==false),$voc,$ses);
            if ($entd!='') { break; }
        } $res=$entd;
    } elseif (strpos($full,':')!==false) {
        $entl=str_replace(':','',str_replace(']','',str_replace('[','',$full)));
        $enti=(strpos($entl,'^')!==false)?explode('^',$entl)[0]:$entl;
        $entj=(strpos($entl,'^')!==false)?explode('^',$entl)[1]:0;
        $itl=localizedTitle($ses,$enti,$entj);
        $res=titleColon($itl,true,$voc,$ses);
    } else {
        $entl=str_replace(']','',str_replace('[','',$full));
        $enti=(strpos($entl,'^')!==false)?explode('^',$entl)[0]:$entl;
        $entj=(strpos($entl,'^')!==false)?explode('^',$entl)[1]:0;
        $itl=localizedTitle($ses,$enti,$entj);
        $res=titleColon($itl,false,$voc,$ses);
    } return $res;
}
function titleColon($itl,bool $cln=false,array $voc,array $ses) {
    $uni=$ses['units']; $vom=$voc['vocabulary']; $loc=$voc['locale'];
    $vun=($cln)?(($itl!='')?((isset($vom[$uni][': ']))?$vom[$uni][': ']:': '):''):''; return (in_array($uni,$loc['colon_ind']))?$vun.$itl:$itl.$vun;
}
function localizedTitle(array $ses,$entl,$vari=0) {
    $uni=$ses['units']; $entr=valarr($ses[$entl.'s'],'; ',': ');
    if (isset($entr[$uni])) {
        if (strpos($entr[$uni],' | ')!==false) {
            $itd=explode(' | ',$entr[$uni]);
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
function wallpaperTitle($name,$mode='series',array $voc,array $ses) {
    $domain=explode('.',$name)[0]; if ($mode=='series') {
        $volume=explode('.',$name)[1]; $arr=fileopen($domain.'.collection.json','{}'); $res=(isset($arr[$volume]['language'][$ses['units']]))?wordfx($arr[$volume]['language'][$ses['units']],$volume,$voc,$ses):((isset($arr[$volume]['title']))?wordfx($arr[$volume]['title'],$volume,$voc,$ses):$name);
    } else {
        $arr=fileopen($domain.'.package.json','{}');
        if ((isset($arr['language']))&&(is_array($arr['language']))) {
            $res=(isset($arr['language'][$ses['units']]['title']))?$arr['language'][$ses['units']]['title']:$arr['title'];
        } else { $res=$arr['title']; }
    } return $res;
}
function term($word='',array $voc,array $ses) {
    $res=(isset($voc['vocabulary'][$ses['units']][$word]))?$voc['vocabulary'][$ses['units']][$word]:$word; return $res;
}
function l10nEnt($cat='',$word='',array $voc,array $ses) {
    return (isset($voc['locale'][$cat][$word][$ses['units']]))?$voc['locale'][$cat][$word][$ses['units']]:$voc['locale'][$cat][$word]['default'];
}
