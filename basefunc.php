<?php
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
