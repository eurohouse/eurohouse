<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$nu=$userSettings['reserve']['unauthorized'];
$su=$userSettings['reserve']['superuser'];
$cookie=whichCookie($nu);
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
date_default_timezone_set(dec_tz($userData['timezone']));
$showFilename=getback($userData);
$variations=getways($showFilename,$userData);
$cont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$exem=exemplar(str_replace('./','',(glob('./*.models.json'))));
$uni=$userData['units']; $loc=$userSettings['locale'];
$pref=prefixes($userData); $fore=$pref[1]; $back=$pref[0];
if (isset($cont[$showFilename])) {
    $ent=$exem[$cont[$showFilename]];
    $showLine=modelcard($cont[$showFilename],$cont,$exem,$userData,$userSettings)['line'];
    $showHead=(isset($ent['language'][$uni]['title']))?$ent['language'][$uni]['title']:$cont[$showFilename]; $showBody=(isset($ent['language'][$uni]['memoir']))?$ent['language'][$uni]['memoir']:((isset($ent['memoir']))?$ent['memoir']:$showLine);
    $showURLMaison=(isset($ent['maison']))?$ent['maison']:"";
    if (isset($ent['insignia'])) {
        $assignAvatar1=$fore.$ent['insignia'].'.png';
        $assignAvatar2=$back.$ent['insignia'].'.png';
    } else {
        $assignAvatar1=(isset($ent['nsfw']))?$fore.'Lady.png':$fore.$userData['avatar'].'.png';
        $assignAvatar2=(isset($ent['nsfw']))?$back.'Lady.png':$back.$userData['avatar'].'.png';
    }
} else {
    $showHead=localizedTitle($userData,'title');
    $showBody=""; $showURLMaison="";
    $assignAvatar1=$fore.$userData['avatar'].'.png';
    $assignAvatar2=$back.$userData['avatar'].'.png';
} $personAvatar1=$fore.$userData['avatar'].'.png';
$personAvatar2=$back.$userData['avatar'].'.png';
/* ¶ 0 */ echo localizedTitle($userData,'title')."\r\n\r\n".
/* ¶ 1 */ $showFilename."\r\n\r\n".
/* ¶ 2 */ $assignAvatar1."\r\n\r\n".
/* ¶ 3 */ $assignAvatar2."\r\n\r\n".
/* ¶ 4 */ $userData['position']."\r\n\r\n".
/* ¶ 5 */ $variations."\r\n\r\n".
/* ¶ 6 */ $showHead."\r\n\r\n".
/* ¶ 7 */ $showBody."\r\n\r\n".
/* ¶ 8 */ $personAvatar1."\r\n\r\n".
/* ¶ 9 */ $personAvatar2."\r\n\r\n".
/* ¶ 10 */ $showURLMaison."\r\n\r\n".
/* ¶ 11 */ $userData['banner'];