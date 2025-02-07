<?php
error_reporting(0); $websiteID=basename(__DIR__);
include 'functions.php'; $viewportStr='';
$settings=fileopen('settings.json');
foreach ($settings['workers'] as $key=>$val) {
    require $val.'.func.php';
} $backloadString=implode(' ',$settings['payload']['backward']);
$forloadString=implode(',',$settings['payload']['forward']);
$updateChannel=[];$viewportArr=$settings['viewport'];
foreach ($settings['payload'] as $key=>$val) {
    $updateChannel[$key] = implode(' ',$val);
} foreach ($settings['collections'] as $key=>$value) {
    $settings['collections'][$key]=strtoupper($value).','.$value;
} if (!file_exists('get.php')) {
    express(explode(',',$forloadString)); header("Location: index.php");
} initiate('tmp,msgbox,book,store,trash'); foreach ($viewportArr as $key=>$val) {
    $viewportStr.=$key.'='.$val.', ';
} $viewportParam=substr($viewportStr,0,-2);
ini_set("session.gc_maxlifetime",$settings['lifetime']['garbage_collector']);
ini_set("session.cookie_lifetime",$settings['lifetime']['cookie_default']);
session_start(); wasAuth(); $sessionID=whichSess();
setcookie('user',$sessionID,time()+$settings['lifetime']['cookie_lengthen']);
$session=arropen($sessionID.'_session.json',json_encode($settings['defaults']),'DEFAULT');
$metadata=arropen($sessionID.'_metadata.json',json_encode($settings['metadata']),'CUSTOM');
$metaList=implode(' | ',array_keys($metadata));
$metaJSON=file_get_contents($cookie.'_metadata.json');
$tutorial=arropen('tutorial.json',"{\"\":\"\"}",'CUSTOM');
$tutorList=implode(' | ',array_keys($tutorial));
$tutorJSON=jsonline('tutorial.json');
$bindData=arropen('binding.json',"{\"root\":\"root\"}");
$powersData=arropen('dominion.json',"{\"root\":0}");
$automateData=arropen('automator.json',"{\"root\":\"manual\"}");
$friendData=arropen('friendship.json',"{\"root\":\"\"}");
$toolboxData=arropen('toolbox.json',"{\"root\":\"\"}");
$callData=arropen('calling.json',"{\"root\":\"root\"}");
$timezone=dec_tz($session['timezone']);
date_default_timezone_set($timezone);
$activeIPs=vismark('visitors.json',$sessionID);
$prefix='iso.';$request=$postRequest=[];
foreach ($settings['initialize']['GET'] as $requestID=>$requestValue) {
    $request[$requestID]=($_GET[$requestID])?$_GET[$requestID]:$requestValue;
} foreach ($settings['initialize']['POST'] as $requestID=>$requestValue) {
    $postRequest[$requestID]=($_POST[$requestID])?$_POST[$requestID]:$requestValue;
} if ((!empty($_FILES['file']['tmp_name']))&&(!empty($_POST['path']))) {
    $filename=$_FILES["file"]["name"];
    $path=$_POST['path']; if ($path!="/") { $path.="/"; }
    chmod($_FILES["file"]["tmp_name"],0777);
    move_uploaded_file($_FILES["file"]["tmp_name"],$path.$filename);
    chmod($path.$filename,0777);
} $avaPrefix=(lux($session['back_text_color']))?'ava.':'abc.';
$abcPrefix=(lux($session['fore_text_color']))?'ava.':'abc.';
$prefix=(lux($session['fore_text_color']))?'iso.':'iec.';
$reticlePrefix=(lux($session['fore_text_color']))?'rtd.':'rtc.';
$themePrefix=(file_exists($session['theme'].'.pkg')) ? $session['theme'].'.' : $prefix;
$portfolioPrefix=(($themePrefix=='iec')||($themePrefix=='iso'))?'org.':((themed($themePrefix,'head,left0,left90,left180,left270,right0,right90,right180,right270'))?$themePrefix:'org.');
$degKoeff=(isset($settings['locale']['angle'][$units]['coefficient']))?$settings['locale']['angle'][$units]['coefficient']:$settings['locale']['angle']['default']['coefficient'];
$degPreSign=(isset($settings['locale']['angle'][$units]['sign']['pre']))?$settings['locale']['angle'][$units]['sign']['pre']:$settings['locale']['angle']['default']['sign']['pre'];
$degSign=(isset($settings['locale']['angle'][$units]['sign']['post']))?$settings['locale']['angle'][$units]['sign']['post']:$settings['locale']['angle']['default']['sign']['post'];
$sup=($session['lock'])?sprintf("%02d", $session['hour']):((($session['benchmark']>0)&&($session['benchmark']<5))?hourize(date('s'),date('i'),$session['benchmark']):date('H'));
$background=($session['banner']!='')?$session['banner']:daily($session['background'],$session['entry'],$sup);
$numeral=(isset($settings['locale']['numeral'][$session['units']]))?$settings['locale']['numeral'][$session['units']]:$settings['locale']['numeral']['default'];
$olympus=str_replace('./','',(glob('./*.*.00.png')));
$kaiser=str_replace('./','',(glob('./'.$avaPrefix.'*.png')));
$amour=str_replace('./','',(glob('./'.$reticlePrefix.'*.png')));
$homer=str_replace('./','',(glob('./*.{'.duplex($settings['collections']['font'],true).'}',GLOB_BRACE)));
$orpheus=str_replace('./','',(glob('./*.{'.duplex($settings['collections']['audio'],true).'}',GLOB_BRACE)));
$musicBox=str_replace('./','',(glob('./*.{'.duplex($settings['collections']['music'],true).'}',GLOB_BRACE)));
$locks=arropen($sessionID.'_lock.json',json_encode($settings['locks']),'DEFAULT');
$userLocks=userlocks($locks,$settings['collections'],$avaPrefix);
$codexBox=str_replace('./','',(glob('./*.mac')));
$speechBox=str_replace('./','',(glob('./*.pro')));
$thematic=str_replace('./','',(glob('./*.start.png')));
$allUsers=str_replace('./','',(glob('./*_session.json')));
