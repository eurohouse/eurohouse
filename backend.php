<?php error_reporting(0); $websiteID=basename(__DIR__);
include 'functions.php'; $settings=fileopen('settings.json');
$backloadString=implode(' ',$settings['payload']['backward']);
$forloadString=implode(',',$settings['payload']['forward']);
$dataLoad=$settings['dataload'];
$updateChannel=[]; foreach ($settings['payload'] as $key=>$val) { $updateChannel[$key]=implode(' ',$val); }
foreach ($settings['collections'] as $key=>$value) { $settings['collections'][$key]=strtoupper($value).','.$value; }
if (!file_exists('get.php')) { express(explode(',',$backloadString)); header("Location: index.php"); }
initDataDirs('tmp,trash');
foreach ($settings['viewport'] as $key=>$val) { $viewportStr.=$key.'='.$val.', '; } $viewportParam=substr($viewportStr,0,-2);
$gamesChannel=[]; foreach ($settings['get_games'] as $key=>$val) { $gamesChannel[$key]=implode(' ',$val); }
ini_set("session.gc_maxlifetime",$settings['lifetime']['garbage_collector']);ini_set("session.cookie_lifetime",$settings['lifetime']['cookie_default']);
session_start(); wasAuthRequest();
$nuUser=$settings['reserve']['unauthorized'];
$suUser=$settings['reserve']['superuser'];
$sessionID=whichSession($nuUser);
setcookie('user',$sessionID,time()+$settings['lifetime']['cookie_lengthen']);
$session=arropen($sessionID.'_session.json',json_encode($settings['defaults']),'DEFAULT'); $metadata=arropen($sessionID.'_metadata.json',json_encode($settings['metadata']),'CUSTOM');
$finLang=terms($settings,$session);
$tutorial=arropen('tutorial.json',"{\"\":\"\"}",'CUSTOM');
$newsData=arropen('changelog.json',"{\"\":\"\"}",'CUSTOM');
$bindData=arropen('binding.json');
$powersData=arropen('dominion.json');
$automateData=arropen('automator.json');
$toolboxData=arropen('toolbox.json');
date_default_timezone_set(dec_tz($session['timezone']));
$request=$postRequest=[];
foreach ($settings['initialize']['GET'] as $requestID=>$requestValue) { $request[$requestID]=($_GET[$requestID])?$_GET[$requestID]:$requestValue; }
foreach ($settings['initialize']['POST'] as $requestID=>$requestValue) { $postRequest[$requestID]=($_POST[$requestID])?$_POST[$requestID]:$requestValue; }
if ((!empty($_FILES['file']['tmp_name']))&&(!empty($_POST['path']))) { $filename=$_FILES["file"]["name"];
    $path=$_POST['path']; if ($path!="/") { $path.="/"; }
    chmod($_FILES["file"]["tmp_name"],0777);
    move_uploaded_file($_FILES["file"]["tmp_name"],$path.$filename);
    chmod($path.$filename,0777);
} $prefix=prefixes($session); $themePrefix=(file_exists($session['theme'].'.pkg'))?$session['theme'].'.':$prefix[3];
$portfolioPrefix=(($themePrefix=='iec')||($themePrefix=='iso'))?'org.':((themed($themePrefix,'head,left0,left90,left180,left270,right0,right90,right180,right270'))?$themePrefix:'org.');
$background=getback($session);
$locks=arropen($sessionID.'_lock.json',json_encode($settings['locks']),'DEFAULT');
$userLocks=userlocks($locks,$settings['collections'],$prefix);
