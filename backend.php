<?php error_reporting(0); $websiteID=basename(__DIR__);
include 'functions.php'; $settings=fileopen('settings.json');
include 'autoload.php';
if (!file_exists('.tmp')) {
    mkdir('.tmp'); chmod('.tmp',0777);
} foreach ($settings['viewport'] as $key=>$val) { $viewportStr.=$key.'='.$val.', '; } $viewportParam=substr($viewportStr,0,-2);
foreach ($settings['collections'] as $key=>$value) {
    $settings['collections'][$key]=strtoupper($value).','.$value;
} $updateChannel=[]; foreach ($settings['payload']['app_store'] as $key=>$val) {
    $updateChannel[$key]=implode(' ',array_keys($val));
} $downloadChannel=[]; foreach ($settings['payload']['play_store'] as $key=>$val) {
    $downloadChannel[$key]=implode(' ',array_keys($val));
} ini_set("session.gc_maxlifetime",$settings['lifetime']['garbage_collector']);
ini_set("session.cookie_lifetime",$settings['lifetime']['cookie_default']);
session_start(); wasAuthRequest();
$nulluser=$settings['reserve']['unauthorized'];
$superuser=$settings['reserve']['superuser'];
$sessionID=whichSession($nulluser);
setcookie('user',$sessionID,time()+$settings['lifetime']['cookie_lengthen']);
$session=fileopen($sessionID.'_files/profile.json',json_encode($settings['defaults']),'create backup restore fallback');
$metadata=fileopen($sessionID.'_files/metadata.json',json_encode($settings['metadata']),'create');
date_default_timezone_set(base64_decode($session['timezone']));
$request=$postRequest=[];
foreach ($settings['initialize']['GET'] as $requestID=>$requestValue) { $request[$requestID]=($_GET[$requestID])?$_GET[$requestID]:$requestValue; }
foreach ($settings['initialize']['POST'] as $requestID=>$requestValue) { $postRequest[$requestID]=($_POST[$requestID])?$_POST[$requestID]:$requestValue; } wasFileRequest();
$prefix=prefixes($session); $themePrefix=(file_exists($session['theme'].'.package.json'))?$session['theme'].'.':$prefix[3];
$ersatzPrefix=(($themePrefix=='iec')||($themePrefix=='iso'))?'org.':((themed($themePrefix,'head'))?$themePrefix:'org.');
$portfolioPrefix=(($themePrefix=='iec')||($themePrefix=='iso'))?'org.':((themed($themePrefix,'torso,left0,left90,left180,left270,right0,right90,right180,right270'))?$themePrefix:'org.');
$background=dailyWallpaper($session);
$subscr=fileopen($sessionID.'_files/subscription.json',json_encode($settings['subscriptions']),'create');
$userSubscr=userSubscr($subscr,$settings['collections'],$prefix);
$usersList=str_replace('_files','',str_replace('./','',(glob('./*_files',GLOB_ONLYDIR)))); natcasesort($usersList); $vis=visitor($sessionID);