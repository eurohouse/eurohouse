<?php error_reporting(0); $websiteID=basename(__DIR__);
include 'functions.php'; $settings=fileopen('settings.json');
$backloadString=implode(' ',$settings['payload']['app_store']['backward']);
$forloadString=implode(',',$settings['payload']['app_store']['forward']);
$dataLoad=$settings['dataload'];
$updateChannel=thirdParty('app_store',$settings['payload']);
foreach ($settings['collections'] as $key=>$value) {
    $settings['collections'][$key]=strtoupper($value).','.$value;
} if (!file_exists('get.php')) {
    express(explode(',',$backloadString)); header("Location: index.php");
} initDataDirs('tmp,trash');
foreach ($settings['viewport'] as $key=>$val) { $viewportStr.=$key.'='.$val.', '; } $viewportParam=substr($viewportStr,0,-2);
$downloadChannel=thirdParty('play_store',$settings['payload']);
ini_set("session.gc_maxlifetime",$settings['lifetime']['garbage_collector']);ini_set("session.cookie_lifetime",$settings['lifetime']['cookie_default']);
session_start(); wasAuthRequest();
$nulluser=$settings['reserve']['unauthorized'];
$superuser=$settings['reserve']['superuser'];
$sessionID=whichSession($nulluser);
setcookie('user',$sessionID,time()+$settings['lifetime']['cookie_lengthen']);
$session=fileopen($sessionID.'_files/session.json',json_encode($settings['defaults'])); $metadata=fileopen($sessionID.'_files/metadata.json',json_encode($settings['metadata'])); $finLang=terms($settings,$session);
$bindData=fileopen('binding.json'); $powersData=fileopen('dominion.json');
$automateData=fileopen('automator.json'); $toolboxData=fileopen('toolbox.json');
date_default_timezone_set(dec_tz($session['timezone']));
$request=$postRequest=[];
foreach ($settings['initialize']['GET'] as $requestID=>$requestValue) { $request[$requestID]=($_GET[$requestID])?$_GET[$requestID]:$requestValue; }
foreach ($settings['initialize']['POST'] as $requestID=>$requestValue) { $postRequest[$requestID]=($_POST[$requestID])?$_POST[$requestID]:$requestValue; } wasFileRequest();
$prefix=prefixes($session); $themePrefix=(file_exists($session['theme'].'.pkg'))?$session['theme'].'.':$prefix[3];
$portfolioPrefix=(($themePrefix=='iec')||($themePrefix=='iso'))?'org.':((themed($themePrefix,'head,left0,left90,left180,left270,right0,right90,right180,right270'))?$themePrefix:'org.');
$background=getback($session);
$locks=fileopen($sessionID.'_files/lock.json',json_encode($settings['locks'])); $userLocks=userlocks($locks,$settings['collections'],$prefix);
