<?php error_reporting(0); $websiteID=basename(__DIR__);
include 'functions.php'; $settings=fileopen('settings.json');
$backloadString=implode(' ',$settings['payload']['backward']);
$forloadString=implode(',',$settings['payload']['forward']);
$updateChannel=[]; foreach ($settings['payload'] as $key=>$val) { $updateChannel[$key]=implode(' ',$val); }
foreach ($settings['collections'] as $key=>$value) { $settings['collections'][$key]=strtoupper($value).','.$value; }
if (!file_exists('get.php')) { express(explode(',',$forloadString)); header("Location: index.php"); } initiate('tmp,msgbox,book,store,trash');
foreach ($settings['viewport'] as $key=>$val) { $viewportStr.=$key.'='.$val.', '; } $viewportParam=substr($viewportStr,0,-2);
ini_set("session.gc_maxlifetime",$settings['lifetime']['garbage_collector']);ini_set("session.cookie_lifetime",$settings['lifetime']['cookie_default']);
session_start(); wasAuth(); $sessionID=whichSess();
setcookie('user',$sessionID,time()+$settings['lifetime']['cookie_lengthen']);
$session=arropen($sessionID.'_session.json',json_encode($settings['defaults']),'DEFAULT'); $metadata=arropen($sessionID.'_metadata.json',json_encode($settings['metadata']),'CUSTOM');
$tutorial=arropen('tutorial.json',"{\"\":\"\"}",'CUSTOM');
$newsData=arropen('changelog.json',"{\"\":\"\"}",'CUSTOM');
$bindData=arropen('binding.json',"{\"root\":\"root\"}");
$powersData=arropen('dominion.json',"{\"root\":0}");
$automateData=arropen('automator.json',"{\"root\":\"manual\"}");
$friendData=arropen('friendship.json',"{\"root\":\"\"}");
$toolboxData=arropen('toolbox.json',"{\"root\":\"\"}");
$callData=arropen('calling.json',"{\"root\":\"root\"}");
date_default_timezone_set(dec_tz($session['timezone']));
$activeIPs=vismark('visitors.json',$sessionID);
$request=$postRequest=[];
foreach ($settings['initialize']['GET'] as $requestID=>$requestValue) { $request[$requestID]=($_GET[$requestID])?$_GET[$requestID]:$requestValue; }
foreach ($settings['initialize']['POST'] as $requestID=>$requestValue) { $postRequest[$requestID]=($_POST[$requestID])?$_POST[$requestID]:$requestValue; }
if ((!empty($_FILES['file']['tmp_name']))&&(!empty($_POST['path']))) { $filename=$_FILES["file"]["name"];
    $path=$_POST['path']; if ($path!="/") { $path.="/"; }
    chmod($_FILES["file"]["tmp_name"],0777);
    move_uploaded_file($_FILES["file"]["tmp_name"],$path.$filename);
    chmod($path.$filename,0777);
} $avaPrefix=(lux($session['back_text_color']))?'ava.':'abc.';
$abcPrefix=(lux($session['fore_text_color']))?'ava.':'abc.';
$prefix=(lux($session['fore_text_color']))?'iso.':'iec.';
$reticlePrefix=(lux($session['fore_text_color']))?'rtd.':'rtc.';
$themePrefix=(file_exists($session['theme'].'.pkg'))?$session['theme'].'.':$prefix; $portfolioPrefix=(($themePrefix=='iec')||($themePrefix=='iso'))?'org.':((themed($themePrefix,'head,left0,left90,left180,left270,right0,right90,right180,right270'))?$themePrefix:'org.');
$background=getback($session);
$locks=arropen($sessionID.'_lock.json',json_encode($settings['locks']),'DEFAULT'); $userLocks=userlocks($locks,$settings['collections'],$avaPrefix);
