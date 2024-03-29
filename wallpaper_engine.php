<?php
include 'functions.php'; $cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = fileopen('settings.json'); $userData = arropen($cookie.'_session.json', json_encode($userSettings['defaults']), true);
$timezone = dec_tz($userData['timezone']); date_default_timezone_set($timezone);
$substitute = ($userData['lock']) ? sprintf("%02d", $userData['hour']) : (($userData['benchmark'] > 0) ? hourize(date('s'), date('i'), $userData['benchmark']) : date('H'));
$brightSysIcon = ((lux($userData['fore_text_color'])) ? 'iso.' : 'iec.');
$brightRetIcon = ((lux($userData['fore_text_color'])) ? 'rtd.' : 'rtc.');
$brightAvaFore = ((lux($userData['fore_text_color'])) ? 'ava.' : 'abc.');
$brightAvaBack = ((lux($userData['back_text_color'])) ? 'ava.' : 'abc.');
$showFilename = daily($userData['background'], $userData['entry'], $substitute);
$variations = implode(';', str_replace(explode('.', $showFilename)[0].'.'.explode('.', $showFilename)[1].'.'.substr(explode('.', $showFilename)[2], 0, 2), '', str_replace('.png', '', str_replace('./', '', (glob('./'.explode('.', $showFilename)[0].'.'.explode('.', $showFilename)[1].'.'.substr(explode('.', $showFilename)[2], 0, 2).'*.png'))))));
$cont = exemplar(str_replace('./','',(glob('./*.contents.json'))));
$exem = exemplar(str_replace('./','',(glob('./*.models.json'))));
$uni = $userData['units']; $loc = $userSettings['locale'];
if (isset($cont[$showFilename])) {
    $ent = $exem[$cont[$showFilename]];
    $showHead = (isset($ent['language'][$uni]['title'])) ? $ent['language'][$uni]['title'] : $cont[$showFilename];
    if (isModel($ent)) {
        $showLength = (isset($loc['length'][$uni])) ? ((isset($loc['length'][$uni]['inch'])) ? incher($ent['height']) : round(($ent['height'] * $loc['length'][$uni]['coefficient']), 2).' '.$loc['length'][$uni]['sign']) : round(($ent['height'] * $loc['length']['default']['coefficient']), 2).' '.$loc['length']['default']['sign'];
        $showMass = (isset($loc['mass'][$uni])) ? (round($ent['weight'] * $loc['mass'][$uni]['coefficient']).' '.$loc['mass'][$uni]['sign']) : round($ent['weight'] * $loc['mass']['default']['coefficient']).' '.$loc['mass']['default']['sign'];
        $showSizes = (isset($loc['length'][$uni]['inch'])) ? (round(explode('-', $ent['sizes'])[0] * $loc['length'][$uni]['coefficient']).'-'.round(explode('-', $ent['sizes'])[1] * $loc['length'][$uni]['coefficient']).'-'.round(explode('-', $ent['sizes'])[2] * $loc['length'][$uni]['coefficient'])) : (explode('-', $ent['sizes'])[0].'-'.explode('-', $ent['sizes'])[1].'-'.explode('-', $ent['sizes'])[2]);
        $showShoeSize = (isset($loc['shoe_size'][$uni])) ? (($ent['shoe_size'] + $loc['shoe_size'][$uni]).' '.$uni) : ($ent['shoe_size'] + $loc['shoe_size']['default']).' '.$uni;
        $bday = (isset($ent['birthday'])) ? $ent['birthday'] : 'January 1, 1970'; $showBirthAge = (round((time()-strtotime($bday))/(3600*24*365.25)));
        $showBirthDay = date('j', strtotime($bday)); $showBirthMonth = date('n', strtotime($bday));
        $showBirthCycle = date('z', strtotime($bday));
        $showBirthCake = (($showBirthDay == date('j')) && ($showBirthMonth == date('n'))) ? "🎂" : "";
        $showBody = (isset($ent['language'][$uni]['memoir'])) ? $ent['language'][$uni]['memoir'] : ((isset($ent['memoir'])) ? $ent['memoir'] : ($showHead.' '.zodiacSign($showBirthCycle).' '.$showBirthAge.' '.$showBirthCake.' '.$showLength.' '.$showMass.' ('.$showSizes.') '.$showShoeSize));
    } else {
        $showBody = (isset($ent['language'][$uni]['memoir'])) ? $ent['language'][$uni]['memoir'] : ((isset($ent['memoir'])) ? $ent['memoir'] : "");
    }
    if (isset($ent['insignia'])) {
        $assignAvatar1 = $brightAvaFore.$ent['insignia'].'.png';
        $assignAvatar2 = $brightAvaBack.$ent['insignia'].'.png';
    } else {
        $assignAvatar1 = $brightAvaFore.$userSettings['defaults']['avatar'].'.png';
        $assignAvatar2 = $brightAvaBack.$userSettings['defaults']['avatar'].'.png';
    }
} else {
    $showHead = $userSettings['defaults']['title'];
    $showBody = "";
    $assignAvatar1 = $brightAvaFore.$userSettings['defaults']['avatar'].'.png';
    $assignAvatar2 = $brightAvaBack.$userSettings['defaults']['avatar'].'.png';
}
$personAvatar1 = $brightAvaFore.$userData['avatar'].'.png';
$personAvatar2 = $brightAvaBack.$userData['avatar'].'.png';
echo $userData['title']."\r\n\r\n".$showFilename."\r\n\r\n".$assignAvatar1."\r\n\r\n".$assignAvatar2."\r\n\r\n".$userData['position']."\r\n\r\n".$variations."\r\n\r\n".$brightSysIcon.";".$brightRetIcon."\r\n\r\n".$showHead."\r\n\r\n".$showBody."\r\n\r\n".$personAvatar1."\r\n\r\n".$personAvatar2;
