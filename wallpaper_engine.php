<?php /* INCLUDE PHP BACKEND FUNCTIONS */
include 'functions.php';
/* GET CURRENT USERNAME FROM BROWSER COOKIE */
$cookie=(isset($_COOKIE['user']))?$_COOKIE['user']:'root';
/* GET APP-WIDE SETTINGS AND CONFIGURATION */
$userSettings=fileopen('settings.json');
/* GET USER SESSION PARAMETERS */
$userData=arropen($cookie.'_session.json',json_encode($userSettings['defaults']),'DEFAULT');
/* SET CURRENT TIMEZONE AS DEFAULT */
date_default_timezone_set(dec_tz($userData['timezone']));
/* COMPLEX CALCULATIONS TO GET BACKGROUND BASED ON SETTINGS */
$showFilename=getback($userData);$variations=getways($showFilename,$userData);$brightAvaFore=((lux($userData['fore_text_color']))?'ava.':'abc.');$brightAvaBack=((lux($userData['back_text_color']))?'ava.':'abc.');
/* GET TABLES OF CONTENTS MAP AND MODELS LIBRARY */
$cont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$exem=exemplar(str_replace('./','',(glob('./*.models.json'))));
/* WITH ALIASES AND SHORTCUTS IT'S EASIER TO WORK WITH CODE */
$uni=$userData['units'];$loc=$userSettings['locale'];
/* IN CASE THE CONTENTS MAP HAS THE CURRENT BACKGROUND POSITION */
if (isset($cont[$showFilename])) {
    $ent=$exem[$cont[$showFilename]];
    $showLine=modelcard($cont[$showFilename],$cont,$exem,$userData,$userSettings);
    $showHead=(isset($ent['language'][$uni]['title']))?$ent['language'][$uni]['title']:$cont[$showFilename]; $showBody=(isset($ent['language'][$uni]['memoir']))?$ent['language'][$uni]['memoir']:((isset($ent['memoir']))?$ent['memoir']:$showLine);
    $showURLMaison=(isset($ent['maison']))?$ent['maison']:"";
    if (isset($ent['insignia'])) {
        $assignAvatar1=$brightAvaFore.$ent['insignia'].'.png';
        $assignAvatar2=$brightAvaBack.$ent['insignia'].'.png';
    } else {
        $assignAvatar1=(isset($ent['nsfw']))?$brightAvaFore.'Lady.png':$brightAvaFore.$userData['avatar'].'.png';
        $assignAvatar2=(isset($ent['nsfw']))?$brightAvaBack.'Lady.png':$brightAvaBack.$userData['avatar'].'.png';
    }
/* WHERE CONTENT NOT FOUND, USER DATA IS SHOWN */ } else {
    $showHead=locTitle($userData,'title');$showBody="";$showURLMaison="";
    $assignAvatar1=$brightAvaFore.$userData['avatar'].'.png';
    $assignAvatar2=$brightAvaBack.$userData['avatar'].'.png';
} $personAvatar1=$brightAvaFore.$userData['avatar'].'.png';
$personAvatar2=$brightAvaBack.$userData['avatar'].'.png';
/* ¶ 0 */ echo locTitle($userData,'title')."\r\n\r\n".
/* ¶ 1 */ $showFilename."\r\n\r\n".
/* ¶ 2 */ $assignAvatar1."\r\n\r\n".
/* ¶ 3 */ $assignAvatar2."\r\n\r\n".
/* ¶ 4 */ $userData['position']."\r\n\r\n".
/* ¶ 5 */ $userData['censor'].":".$variations."\r\n\r\n".
/* ¶ 6 */ ((lux($userData['fore_text_color']))?'iso.':'iec.').";".((lux($userData['fore_text_color']))?'rtd.':'rtc.').";".$brightAvaFore."\r\n\r\n".
/* ¶ 7 */ $showHead."\r\n\r\n".
/* ¶ 8 */ $showBody."\r\n\r\n".
/* ¶ 9 */ $personAvatar1."\r\n\r\n".
/* ¶ 10 */ $personAvatar2."\r\n\r\n".
/* ¶ 11 */ $showURLMaison."\r\n\r\n".
/* ¶ 12 */ $userData['banner'];