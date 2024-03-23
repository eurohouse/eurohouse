<?php
function eurarr($name): array {
    $arr = explode('|[1]|', (file_get_contents($name)));
    $obj = []; foreach ($arr as $line) {
        $obj[explode('|[>]|', $line)[0]] = explode('|[>]|', $line)[1];
    } return $obj;
}
function hHmMsS(int $num): string {
    return sprintf('%02d:%02d:%02d', (round($num)/3600), (round($num)/60%60), round($num)%60);
}
function isModel(array $ent): bool {
    return (intval(isset($ent['height']))+intval(isset($ent['weight']))+intval(isset($ent['sizes']))+intval(isset($ent['shoe_size']))+intval(isset($ent['nsfw']))>0);
}
function zodiacSign($d) {
    if (($d > 355) || ($d < 19)) {
        $r = "♑️";
    } elseif (($d > 18) && ($d < 49)) {
        $r = "♒️";
    } elseif (($d > 48) && ($d < 80)) {
        $r = "♓️";
    } elseif (($d > 79) && ($d < 110)) {
        $r = "♈️";
    } elseif (($d > 109) && ($d < 141)) {
        $r = "♉️";
    } elseif (($d > 140) && ($d < 172)) {
        $r = "♊️";
    } elseif (($d > 171) && ($d < 204)) {
        $r = "♋️";
    } elseif (($d > 203) && ($d < 235)) {
        $r = "♌️";
    } elseif (($d > 234) && ($d < 266)) {
        $r = "♍️";
    } elseif (($d > 265) && ($d < 296)) {
        $r = "♎️";
    } elseif (($d > 295) && ($d < 326)) {
        $r = "♏️";
    } elseif (($d > 325) && ($d < 356)) {
        $r = "♐️";
    } return $r;
}
function withReq($name) {
    if (strpos($name, '?') !== false) {
        $res = explode('?', $name)[0];
    } else {
        $res = $name;
    } return $res;
}
function enc_tz($tz): string {
    if (strpos($tz, '+') !== false) {
        $res = '-'.explode('+', $tz)[1];
    } elseif (strpos($tz, '-') !== false) {
        $res = explode('-', $tz)[1];
    } else {
        $res = 0;
    } return $res;
}
function dec_tz($tz): string {
    if ($tz == 0) {
        $res = 'Etc/GMT';
    } elseif ($tz < 0) {
        $res = 'Etc/GMT'.'+'.abs($tz);
    } else {
        $res = 'Etc/GMT'.'-'.abs($tz);
    } return $res;
}
function french(array $voc, $units = 'EU'): string {
    $yearQ = ((date('Y') % 4 == 0) && (date('Y') % 400 == 0)) ? 366 : 365;
    $curD = (date('z') < 265) ? round(360 * ((date('z') + 101) / $yearQ)) : round(360 * ((date('z') - 264) / $yearQ));
    $showD = (($curD % 30) > 0) ? ($curD % 30) : 30;
    if (isset($voc['locale']['french'][$units][ceil($curD / 30) - 1])) {
        $showM = $voc['locale']['french'][$units][ceil($curD / 30) - 1];
    } else {
        $showM = $voc['locale']['french']['default'][ceil($curD / 30) - 1];
    } return $showD.' '.$showM;
}
function valstr(array $arr, $y, $x): string {
    $lines = ''; foreach ($arr as $key=>$val) {
        $lines .= $key.$x.$val.$y;
    } return $lines;
}
function valarr(string $str, $y, $x): array {
    $arr = explode($y, $str);
    $new = []; foreach ($arr as $val) {
        $newstr = explode($x, $val);
        $new[$newstr[0]] = $newstr[1];
    } return $new;
}
function exemplar(array $arr): array {
    $new = []; foreach ($arr as $exem) {
        $ober = (@json_decode(file_get_contents($exem), true) != null) ? json_decode(file_get_contents($exem), true) : []; foreach ($ober as $key=>$val) { $new[$key] = $val; }
    } return $new;
}
function sizestr(string $val, array $voc, $units = 'EU') {
    $unitB = (isset($voc['B'][$units]['sign'])) ? $voc['B'][$units]['sign'] : 'B';
    $unitKB = (isset($voc['KB'][$units]['sign'])) ? $voc['KB'][$units]['sign'] : 'KB';
    $valKB = (isset($voc['KB'][$units]['value'])) ? $voc['KB'][$units]['value'] : 1024;
    $unitMB = (isset($voc['MB'][$units]['sign'])) ? $voc['MB'][$units]['sign'] : 'MB';
    $valMB = (isset($voc['MB'][$units]['value'])) ? $voc['MB'][$units]['value'] : 1048576;
    $unitGB = (isset($voc['GB'][$units]['sign'])) ? $voc['GB'][$units]['sign'] : 'GB';
    $valGB = (isset($voc['GB'][$units]['value'])) ? $voc['GB'][$units]['value'] : 1073741824;
    $unitTB = (isset($voc['TB'][$units]['sign'])) ? $voc['TB'][$units]['sign'] : 'TB';
    $valTB = (isset($voc['TB'][$units]['value'])) ? $voc['TB'][$units]['value'] : 1099511627776;
    $unitPB = (isset($voc['PB'][$units]['sign'])) ? $voc['PB'][$units]['sign'] : 'PB';
    $valPB = (isset($voc['PB'][$units]['value'])) ? $voc['PB'][$units]['value'] : 1125899906842624;
    $unitEB = (isset($voc['EB'][$units]['sign'])) ? $voc['EB'][$units]['sign'] : 'EB';
    $valEB = (isset($voc['EB'][$units]['value'])) ? $voc['EB'][$units]['value'] : 1152921504606847000;
    $unitZB = (isset($voc['ZB'][$units]['sign'])) ? $voc['ZB'][$units]['sign'] : 'ZB';
    $valZB = (isset($voc['ZB'][$units]['value'])) ? $voc['ZB'][$units]['value'] : 1.1805916207174113e+21;
    $unitYB = (isset($voc['YB'][$units]['sign'])) ? $voc['YB'][$units]['sign'] : 'YB';
    $valYB = (isset($voc['YB'][$units]['value'])) ? $voc['YB'][$units]['value'] : 1.2089258196146292e+24;
    if ($val < $valKB) {
        $res = $val.' '.$unitB;
    } else {
        if ($val < $valMB) {
            $res = round(($val / $valKB), 2).' '.$unitKB;
        } else {
            if ($val < $valGB) {
                $res = round(($val / $valMB), 2).' '.$unitMB;
            } else {
                if ($val < $valTB) {
                    $res = round(($val / $valGB), 2).' '.$unitGB;
                } else {
                    if ($val < $valPB) {
                        $res = round(($val / $valTB), 2).' '.$unitTB;
                    } else {
                        if ($val < $valEB) {
                            $res = round(($val / $valPB), 2).' '.$unitPB;
                        } else {
                            if ($val < $valZB) {
                                $res = round(($val / $valEB), 2).' '.$unitEB;
                            } else {
                                if ($val < $valYB) {
                                    $res = round(($val / $valZB), 2).' '.$unitZB;
                                } else {
                                    $res = round(($val / $valYB), 2).' '.$unitYB;
                                }
                            }
                        }
                    }
                }
            }
        }
    } return $res;
}
function initiate($str = 'tmp') {
    $arr = explode(',', $str); foreach ($arr as $dir) {
        if (!file_exists('./.'.$dir)) {
            mkdir('./.'.$dir); chmod('./.'.$dir, 0777);
        }
    }
}
function horizontal($a, $circle = 6.285714285714286) {
    $part = 4 * ($a / $circle); if ($part < 1) {
        $res = 'u';
    } elseif ($part >= 1 && $part < 2) {
        $res = 'r';
    } elseif ($part >= 2 && $part < 3) {
        $res = 'd';
    } elseif ($part >= 3 && $part < 4) {
        $res = 'l';
    } else {
        $res = 'u';
    } return $res;
}
function paging($name, $opt = [0, 2]): array {
    $arr = preg_split("/\r\n|\n|\r/", (file_get_contents($name)));
    $obj = []; foreach ($opt as $n) { $obj[$n] = $arr[$n]; } return $obj;
}
function pages($name): array {
    $arr = preg_split("/\r\n|\n|\r/", (file_get_contents($name))); return $arr;
}
function textopen($name, $default = '') {
    $fileOpen = (file_exists($name)) ? file_get_contents($name) : $default;
    return ($fileOpen != '') ? $fileOpen : $default;
}
function fileopen($name, $default = '') {
    $fileOpen = (file_exists($name)) ? file_get_contents($name) : $default;
    return (@unserialize($fileOpen) !== false) ? unserialize($fileOpen) : ((@json_decode($fileOpen, true) != null) ? json_decode($fileOpen, true) : ((@eurarr($name) !== null) ? eurarr($name) : ((@paging($name) !== null) ? paging($name) : $fileOpen)));
}
function arropen($name, $default = '{}') {
    if (!file_exists($name)) {
        file_put_contents($name, $default); chmod($name, 0777);
    } $test = file_get_contents($name);
    if (@json_decode($test, true) != null) {
        file_put_contents($name.'.bak', $test); chmod($name.'.bak', 0777);
    } else {
        rename($name.'.bak', $name); chmod($name, 0777);
    } $tryit = json_decode(file_get_contents($name), true);
    file_put_contents($name, json_encode(eqarr(json_decode($default, true), $tryit))); chmod($name, 0777);
    $res = json_decode(file_get_contents($name), true); return $res;
}
function eqarr(array $src, array $des) {
    foreach ($src as $key=>$val) {
        if (!isset($des[$key])) {
            $des[$key] = $val;
        }
    } foreach ($des as $key=>$val) {
        if (!isset($src[$key])) {
            unset($des[$key]);
        }
    } return $des;
}
function incher($num, $koeff = 3.28084, $denom = 12) {
    $modul = round(($num * $koeff), 1);
    $nat = explode('.', $modul)[0];
    $frac = round($denom * (explode('.', $modul)[1] / 10));
    return $nat."' ".$frac."\"";
}
function circumflex($val, $def) {
    return (strpos($val, ' ^') !== false) ? [explode(' ^', $val)[0],explode(' ^', $val)[1]] : [$val, $def];
}
function lux($hex): bool {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
    return (($r + $g + $b) > 382);
}
function themed(string $theme, string $assets = 'head'): bool {
    $arr = explode(',', $assets);
    $basket = true;
    foreach ($arr as $val) {
        $basket = $basket && file_exists($theme.$val.'.png');
    } return $basket;
}
function spaces($str) {
    if (strpos($str, '_') !== false) {
        $arr = explode('_', $str);
        $res = [];
        foreach ($arr as $val) {
            $res[] = ucfirst($val);
        }
        $result = implode(' ', $res);
    } else {
        $result = ucfirst($str);
    } return $result;
}
function camel($str) {
    if (strpos($str, '_') !== false) {
        $arr = explode('_', $str);
        $res = '';
        foreach ($arr as $val) {
            $res .= ucfirst($val);
        } $result = $res;
    } else {
        $result = ucfirst($str);
    } return $result;
}
function daily($name, $add, $hour): string {
    $num = str_replace('./', '', (glob('./'.explode('.', $name)[0].'.'.explode('.', $name)[1].'.{00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23}.png', GLOB_BRACE)));
    $fin = sprintf("%02d", (floor(count($num)*($hour/24))));
    $back = ($add != '') ? ((file_exists(explode('.', $name)[0].'.'.explode('.', $name)[1].'.'.$fin.$add.'.png')) ? explode('.', $name)[0].'.'.explode('.', $name)[1].'.'.$fin.$add.'.png' : explode('.', $name)[0].'.'.explode('.', $name)[1].'.'.$fin.'.png') : explode('.', $name)[0].'.'.explode('.', $name)[1].'.'.$fin.'.png';
    return $back;
}
function wasAuth() {
    if (isset($_REQUEST['auth']) && isset($_REQUEST['login']) && isset($_REQUEST['password'])) {
        $auth = $_REQUEST['auth']; $login = $_REQUEST['login']; $pass = $_REQUEST['password']; $logpass = textopen($login.'_password', '');
        if ($auth == 'signup') {
            if (!file_exists($login.'_password')) {
                file_put_contents($login.'_password', $pass);
                chmod($login.'_password', 0777);
            }
        } elseif ($auth == 'signin') {
            if ($pass == $logpass) {
                $_SESSION['user'] = $login;
            }
        } elseif ($auth == 'signout') {
            unset($_SESSION['user']);
        }
    }
}
function express(array $for) {
    foreach ($for as $key=>$pkg) {
        if (strpos($pkg, '>') !== false) {
            $strlo = explode('>', $pkg); $uri = $strlo[0]; $branch = $strlo[1];
            $urilo = explode('/', $uri); if (count($urilo) > 2) {
                $repo = $urilo[count($urilo) - 1]; $user = $urilo[count($urilo) - 2];
                $host = str_replace('/'.$user.'/'.$repo, '', $uri);
            } else {
                $host = 'https://github.com'; $user = $urilo[0]; $repo = $urilo[1];
            }
        } else {
            $uri = $pkg; $branch = ''; $urilo = explode('/', $uri); if (count($urilo) > 2) {
                $repo = $urilo[count($urilo) - 1]; $user = $urilo[count($urilo) - 2];
                $host = str_replace('/'.$user.'/'.$repo, '', $uri);
            } else {
                $host = 'https://github.com'; $user = $urilo[0]; $repo = $urilo[1];
            }
        } $hostArray = explode('://', $host);
        $socketOpen = fsockopen($hostArray[1], 80, $errno, $errstr, 10);
        if ($socketOpen != false) {
            $fileback = str_replace('./','',(glob('./*.txt')));
            foreach ($fileback as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777); rename($file, $file.'.bak');
                    chmod($file.'.bak', 0777);
                }
            } if (file_exists($repo.'.pkg')) {
                $files = explode(';', fileopen($repo.'.pkg')['files']);
                foreach ($files as $key=>$file) {
                    if (file_exists($file)) {
                        chmod($file, 0777); unlink($file);
                    }
                } chmod($repo.'.pkg', 0777); unlink($repo.'.pkg');
            } if (file_exists($repo)) {
                chmod($repo, 0777); rename($repo, $repo.'.d');
            } if ($branch != '') {
                exec('git clone -b '.$branch.' '.$host.'/'.$user.'/'.$repo);
            } else {
                exec('git clone '.$host.'/'.$user.'/'.$repo);
            } chmod($repo, 0777); exec('mv '.$repo.'/* $PWD');
            exec('chmod -R 777 .'); exec('rm -rf '.$repo); if (file_exists($repo.'.d')) {
                chmod($repo.'.d', 0777); rename($repo.'.d', $repo);
            } $filepass = str_replace('./','',(glob('./*.md')));
            foreach ($filepass as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777); unlink($file);
                }
            } $filerest = str_replace('./','',(glob('./*.txt.bak')));
            foreach ($filerest as $key=>$file) {
                if (file_exists($file)) {
                    chmod($file, 0777); rename($file, str_replace('.txt.bak', '.txt', $file));
                    chmod(str_replace('.txt.bak', '.txt', $file), 0777);
                }
            }
        }
    }
}
function wordfx($word, $sup, array $voc, $title, $units = 'EU') {
    $preg = preg_match_all('/\[[^\]]*\]/', $word, $matches);
    for ($i = 0; $i < count($matches[0]); $i++) {
        $full = $matches[0][$i]; switch ($full) {
            case '[year]': $res = date('Y'); break;
            case '[id]': $res = $sup; break;
            case '[uname -a]': $res = php_uname('a'); break;
            case '[uname -s]': $res = php_uname('s'); break;
            case '[uname -n]': $res = php_uname('n'); break;
            case '[uname -r]': $res = php_uname('r'); break;
            case '[uname -v]': $res = php_uname('v'); break;
            case '[uname -m]': $res = php_uname('m'); break;
            case '[french]': $res = french($voc, $units); break;
            case '[semester]':
                $res = (isset($voc['locale']['semester'][$units][date('n')-1])) ? $voc['locale']['semester'][$units][date('n')-1] : $voc['locale']['semester']['default'][date('n')-1]; break;
            case '[quarter]':
                $res = (isset($voc['locale']['quarter'][$units][date('n')-1])) ? $voc['locale']['quarter'][$units][date('n')-1] : $voc['locale']['quarter']['default'][date('n')-1]; break;
            case '[title]': $res = $title; break;
        } $word = str_replace($full, $res, $word);
    } return $word;
}
function titler($name, array $voc, $title, $units = 'EU') {
    $domain = explode('.', $name)[0]; $volume = explode('.', $name)[1];
    $collection = fileopen($domain.'.collection.json', '{}');
    return (isset($collection[$volume]['language'][$units])) ? wordfx($collection[$volume]['language'][$units], $volume, $voc, $title, $units) : ((isset($collection[$volume]['title'])) ? wordfx($collection[$volume]['title'], $volume, $voc, $title, $units) : $name);
}
