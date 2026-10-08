<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$requestMode=(isset($_REQUEST['mode']))?$_REQUEST['mode']:'';
$appTitle=fileopen('eurohouse.package.json')['title'];
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/profile.json',json_encode($userSettings['defaults'])); date_default_timezone_set(base64_decode($userData['timezone']));
$showFilename=dailyWallpaper($userData); $uni=$userData['units'];
$curModeFile=(file_exists('mode.'.$requestMode.'.php'))?selectedLines('mode.'.$requestMode.'.php',[1]):selectedLines('welcome_screen.php',[1]);
$curModeLangPack=annotationString($curModeFile[1]);
$curModeLangArr=valarr($curModeLangPack,'; ',': ');
$curModeLangName=(isset($curModeLangArr[$uni]))?$curModeLangArr[$uni]:snakeToSpaces((file_exists('mode.'.$requestMode.'.php'))?$requestMode:'welcome_screen');
$cont=exemplar(str_replace('./','',(glob('./*.contents.json'))));
$exem=exemplar(str_replace('./','',(glob('./*.models.json'))));
$assignUserAvatar=prefixes($userData)[0].$userData['avatar'].'.webp';
$systemIconAvatar=prefixes($userData)[1].$userData['avatar'].'.webp';
$showUserHead=localizedTitle($userData,'title');
$showUserBody=titleCommand('[codename:]',$userSettings,$userData).titleCommand('[project|title]',$userSettings,$userData);
if (isset($cont[$showFilename])) {
    $card=modelcard($cont[$showFilename],$cont,$exem,$userData,$userSettings);
    $showHead=$card['title']; $showBody=$card['text']; $showURL=$card['url'];
    $assignAvatar=prefixes($userData)[0].$card['avatar'].'.webp';
} else {
    $showHead=$showUserHead; $showBody=$showUserBody; $showURL=""; $assignAvatar=$assignUserAvatar;
} echo /* ¶ 0 */ $showUserHead."\r\n\r\n".
/* ¶ 1 */ $showUserBody."\r\n\r\n".
/* ¶ 2 */ $showFilename."\r\n\r\n".
/* ¶ 3 */ $assignUserAvatar."\r\n\r\n".
/* ¶ 4 */ $systemIconAvatar."\r\n\r\n".
/* ¶ 5 */ $assignAvatar."\r\n\r\n".
/* ¶ 6 */ $showHead."\r\n\r\n".
/* ¶ 7 */ $showBody."\r\n\r\n".
/* ¶ 8 */ $showURL."\r\n\r\n".
/* ¶ 9 */ $curModeLangName;
