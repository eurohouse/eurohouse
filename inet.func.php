<?php
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
