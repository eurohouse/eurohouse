<?php
include 'functions.php';
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json');
$userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), 'DEFAULT');
$timezone = dec_tz($userData['timezone']); date_default_timezone_set($timezone);
$substitute = ($userData['lock']) ? sprintf("%02d", $userData['hour']) : ((($userData['benchmark'] > 0) && ($userData['benchmark'] < 5)) ? hourize(date('s'), date('i'), $userData['benchmark']) : date('H')); $brightSysIcon = ((lux($userData['fore_text_color'])) ? 'iso.' : 'iec.');
$brightRetIcon = ((lux($userData['fore_text_color'])) ? 'rtd.' : 'rtc.');
$brightAvaFore = ((lux($userData['fore_text_color'])) ? 'ava.' : 'abc.');
$brightAvaBack = ((lux($userData['back_text_color'])) ? 'ava.' : 'abc.');
$showFilename = daily($userData['background'], $userData['entry'], $substitute);
$variations = ($userData['censor'] != 0) ? '' : implode(';', str_replace(explode('.', $showFilename)[0].'.'.explode('.', $showFilename)[1].'.'.substr(explode('.', $showFilename)[2], 0, 2), '', str_replace('.png', '', str_replace('./', '', (glob('./'.explode('.', $showFilename)[0].'.'.explode('.', $showFilename)[1].'.'.substr(explode('.', $showFilename)[2], 0, 2).'*.png'))))));
$cont = exemplar(str_replace('./','',(glob('./*.contents.json'))));
$exem = exemplar(str_replace('./','',(glob('./*.models.json'))));
$uni = $userData['units']; $loc = $userSettings['locale'];
$voc = $userSettings['vocabulary'];
$anno = (isset($loc['anno'][$uni])) ? $loc['anno'][$uni] : $loc['anno']['default'];
if (isset($cont[$showFilename])) {
    $ent = $exem[$cont[$showFilename]];
    $showHead = (isset($ent['language'][$uni]['title'])) ? $ent['language'][$uni]['title'] : $cont[$showFilename]; if (isset($ent['height'])) {
        $showLength = (isset($loc['length'][$uni])) ? ((isset($loc['length'][$uni]['inch'])) ? incher($ent['height']) : round(($ent['height'] * $loc['length'][$uni]['coefficient']), 2).' '.$loc['length'][$uni]['sign']) : round(($ent['height'] * $loc['length']['default']['coefficient']), 2).' '.$loc['length']['default']['sign']; $showLengthLine = ' '.$showLength;
    } else { $showLengthLine = ''; }
    if (isset($ent['weight'])) {
        $showMass = (isset($loc['mass'][$uni])) ? (round($ent['weight'] * $loc['mass'][$uni]['coefficient']).' '.$loc['mass'][$uni]['sign']) : round($ent['weight'] * $loc['mass']['default']['coefficient']).' '.$loc['mass']['default']['sign'];
        $showMassLine = $showMass;
    } else { $showMassLine = ''; }
    if (isset($ent['sizes'])) {
        $showSizes = (isset($loc['length'][$uni]['inch'])) ? (round(explode('-', $ent['sizes'])[0] * $loc['length'][$uni]['coefficient']).'-'.round(explode('-', $ent['sizes'])[1] * $loc['length'][$uni]['coefficient']).'-'.round(explode('-', $ent['sizes'])[2] * $loc['length'][$uni]['coefficient'])) : (explode('-', $ent['sizes'])[0].'-'.explode('-', $ent['sizes'])[1].'-'.explode('-', $ent['sizes'])[2]); $showSizesLine = '('.$showSizes.')';
    } else { $showSizesLine = ''; }
    if (isset($ent['shoe_size'])) {
        $showShoeSize = (isset($loc['shoe_size'][$uni])) ? (($ent['shoe_size'] + $loc['shoe_size'][$uni]).' '.$uni) : ($ent['shoe_size'] + $loc['shoe_size']['default']).' '.$uni;
    } else { $showShoeSize = ''; }
    if (isset($ent['birthday'])) {
        $bday = (isset($ent['birthday'])) ? $ent['birthday'] : 'January 1, 1970'; $showBirthAge = (round((time()-strtotime($bday))/(3600*24*365.25)));
        $showBirthDay = date('j', strtotime($bday));
        $showBirthMonth = date('n', strtotime($bday));
        $showBirthCycle = date('z', strtotime($bday));
        $showBirthCake = (($showBirthDay == date('j')) && ($showBirthMonth == date('n'))) ? "🎂" : "";
        if (in_array($uni, $loc['anno_ind']['space'])) {
            $showBirthAgeDisp = $showBirthAge.' '.$anno;
        } elseif (in_array($uni, $loc['anno_ind']['concat'])) {
            $showBirthAgeDisp = $anno.$showBirthAge;
        } else {
            $showBirthAgeDisp = $anno.' '.$showBirthAge;
        } $showBdayLine = zodiacSign($showBirthCycle).' '.$showBirthAgeDisp.' '.$showBirthCake;
    } else { $showBdayLine = ''; }
    $showLine = $showHead.' '.$showBdayLine.' '.$showLengthLine.' '.$showMassLine.' '.$showSizesLine.' '.$showShoeSize;
    $showBody = (isset($ent['language'][$uni]['memoir'])) ? $ent['language'][$uni]['memoir'] : ((isset($ent['memoir'])) ? $ent['memoir'] : $showLine);
    $showURLMaison = (isset($ent['maison'])) ? $ent['maison'] : "";
    if (isset($ent['insignia'])) {
        $assignAvatar1 = $brightAvaFore.$ent['insignia'].'.png';
        $assignAvatar2 = $brightAvaBack.$ent['insignia'].'.png';
    } else {
        $assignAvatar1 = $brightAvaFore.$userSettings['defaults']['avatar'].'.png';
        $assignAvatar2 = $brightAvaBack.$userSettings['defaults']['avatar'].'.png';
    }
} else {
    $showHead = $userSettings['defaults']['title'];
    $showBody = ""; $showURLMaison = "";
    $assignAvatar1 = $brightAvaFore.$userSettings['defaults']['avatar'].'.png'; $assignAvatar2 = $brightAvaBack.$userSettings['defaults']['avatar'].'.png';
} $personAvatar1 = $brightAvaFore.$userData['avatar'].'.png';
$personAvatar2 = $brightAvaBack.$userData['avatar'].'.png';
/* ¶ 0 */ echo $userData['title']."\r\n\r\n".
/* ¶ 1 */ $showFilename."\r\n\r\n".
/* ¶ 2 */ $assignAvatar1."\r\n\r\n".
/* ¶ 3 */ $assignAvatar2."\r\n\r\n".
/* ¶ 4 */ $userData['position']."\r\n\r\n".
/* ¶ 5 */ $userData['censor'].":".$variations."\r\n\r\n".
/* ¶ 6 */ $brightSysIcon.";".$brightRetIcon."\r\n\r\n".
/* ¶ 7 */ $showHead."\r\n\r\n".
/* ¶ 8 */ $showBody."\r\n\r\n".
/* ¶ 9 */ $personAvatar1."\r\n\r\n".
/* ¶ 10 */ $personAvatar2."\r\n\r\n".
/* ¶ 11 */ $showURLMaison;