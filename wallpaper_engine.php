<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$appTitle=fileopen('eurohouse.package.json')['title'];
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/profile.json',json_encode($userSettings['defaults'])); date_default_timezone_set(base64_decode($userData['timezone']));
$showFilename=dailyWallpaper($userData); $uni=$userData['units'];
$cont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$exem=exemplar(str_replace('./','',(glob('./*.models.json'))));
$pref=prefixes($userData);
if (isset($cont[$showFilename])) {
    $ent=$exem[$cont[$showFilename]];
    $mod=modelcard($cont[$showFilename],$cont,$exem,$userData,$userSettings); $showHead=$mod['title'];
    $showBody=$mod['text']; $showURL=$mod['url'];
    $assignAvatar=$pref[0].$mod['avatar'].'.png';
} else {
    $showHead=localizedTitle($userData,'title');
    $showBody=titleCommand('[codename:]',$userSettings,$userData).titleCommand('[project|title]',$userSettings,$userData); $showURL="";
    $assignAvatar=$pref[0].$userData['avatar'].'.png';
} echo
/* ¶ 0 */ localizedTitle($userData,'title')."\r\n\r\n".
/* ¶ 1 */ $showFilename."\r\n\r\n".
/* ¶ 2 */ $assignAvatar."\r\n\r\n".
/* ¶ 3 */ $showHead."\r\n\r\n".
/* ¶ 4 */ $showBody."\r\n\r\n".
/* ¶ 5 */ $showURL;
