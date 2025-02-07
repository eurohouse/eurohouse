<?php
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
function userlocks($arr,$col,$ava) {
    $res=[]; foreach ($arr as $key=>$val) {
        $lib=($key=='avatar')?str_replace('./','',(glob('./'.$ava.'*.png'))):(($key=='background')?str_replace('./','',(glob('./*.*.00.png'))):str_replace('./','',(glob('./*.{'.duplex($col[$key],true).'}',GLOB_BRACE))));
        if ($key=='background') { $res[$key]=excpkg($lib,$arr[$key],'COLLECTION');
        } else { $res[$key]=excpkg($lib,$arr[$key]); }
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
                $res=sizestr(disk_free_space('/'),$voc['locale'],$ses['units']); break;
            case '[french]':
                // Display date in French Republican Calendar format
                $res=french($voc,$ses['units']); break;
            case '[month]':
                // Get current month
                $res=(isset($voc['locale']['month'][$ses['units']][date('n')-1]))?$voc['locale']['month'][$ses['units']][date('n')-1]:$voc['locale']['month']['default'][date('n')-1]; break;
            case '[semester]':
                // Get current range of two seasons, namely Fall/Winter and Spring/Summer
                $qN=date('n')-1;$qM=intval(($qN>1)&&($qN<8));
                $res=(isset($voc['locale']['semester'][$ses['units']][$qM]))?$voc['locale']['semester'][$ses['units']][$qM]:$voc['locale']['semester']['default'][$qM]; break;
            case '[quarter]':
                // Get current season, namely Winter, Spring, Summer and Fall
                $qN=date('n')-1;$qM=(($qN>1)&&($qN<5))?1:((($qN>4)&&($qN<8))?2:((($qN>7)&&($qN<11))?3:0));
                $res=(isset($voc['locale']['quarter'][$ses['units']][$qM]))?$voc['locale']['quarter'][$ses['units']][$qM]:$voc['locale']['quarter']['default'][$qM]; break;
            default:
                // Get arbitrary user profile property
                $uni=$ses['units'];$vom=$voc['vocabulary'];
                $entl=(strpos($full,':')!==false)?str_replace(':','',str_replace(']','',str_replace('[','',$full))):str_replace(']','',str_replace('[','',$full));
                $entr=valarr($ses[$entl.'s'],' | ',' - ');
                $itl=(isset($entr[$ses['units']]))?$entr[$uni]:(($ses[$entl])?$ses[$entl]:'');
                $vun=(strpos($full,':')!==false)?(($itl!='')?((isset($vom[$uni][': ']))?$vom[$uni][': ']:': '):''):'';
                $res=(in_array($uni,$voc['locale']['colon_ind']))?$vun.$itl:$itl.$vun; break;
        } $word=str_replace($full,$res,$word);
    } return $word;
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
