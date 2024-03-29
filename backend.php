<?php
error_reporting(0); $websiteID = basename(__DIR__);
include 'functions.php'; $settings = fileopen('settings.json');
$backloadString = implode(' ', $settings['payload']['backward']);
$forloadString = implode(',', $settings['payload']['forward']);
if (!file_exists('get.php')) {
    express(explode(',', $forloadString));
    header("Location: index.php");
} initiate('tmp,log'); $timezoneDatabase = fileopen('timezone.json');
ini_set("session.gc_maxlifetime", $settings['lifetime']['garbage_collector']);
ini_set("session.cookie_lifetime", $settings['lifetime']['cookie_default']);
session_start(); wasAuth();
$sessionID = (isset($_SESSION['user'])) ? $_SESSION['user'] : 'root';
setcookie('user', $sessionID, time() + $settings['lifetime']['cookie_lengthen']);
$session = arropen($sessionID.'_session.json', json_encode($settings['defaults']), true);
$bindData = arropen('binding.json', "{\"root\":\"root\"}");
$handledID = (isset($bindData[$sessionID]) && ($bindData[$sessionID] != $sessionID)) ? $bindData[$sessionID] : $sessionID; $powersData = arropen('dominion.json', "{\"root\":0}");
$timezone = dec_tz($session['timezone']); date_default_timezone_set($timezone);
$requestInitData = $settings['initialize']; $prefix = 'iso.';
$request = []; foreach ($requestInitData as $requestID=>$requestValue) {
    $request[$requestID] = ($_REQUEST[$requestID]) ? $_REQUEST[$requestID] : $requestValue;
} $avaPrefix = (lux($session['back_text_color'])) ? 'ava.' : 'abc.';
$abcPrefix = (lux($session['fore_text_color'])) ? 'ava.' : 'abc.';
$prefix = (lux($session['fore_text_color'])) ? 'iso.' : 'iec.';
$reticlePrefix = (lux($session['fore_text_color'])) ? 'rtd.' : 'rtc.';
$themePrefix = $session['theme'].'.';
$portfolioPrefix = (($themePrefix == 'iec') || ($themePrefix == 'iso')) ? 'org.' : ((themed($themePrefix, 'head,left0,left90,left180,left270,right0,right90,right180,right270')) ? $themePrefix : 'org.'); $suffix = '?rev='.time();
$degKoeff = (isset($settings['locale']['angle'][$units]['coefficient'])) ? $settings['locale']['angle'][$units]['coefficient'] : $settings['locale']['angle']['default']['coefficient']; $degPreSign = (isset($settings['locale']['angle'][$units]['sign']['pre'])) ? $settings['locale']['angle'][$units]['sign']['pre'] : $settings['locale']['angle']['default']['sign']['pre']; $degSign = (isset($settings['locale']['angle'][$units]['sign']['post'])) ? $settings['locale']['angle'][$units]['sign']['post'] : $settings['locale']['angle']['default']['sign']['post'];
$sup = ($session['lock']) ? sprintf("%02d", $session['hour']) : (($session['benchmark'] > 0) ? hourize(date('s'), date('i'), $session['benchmark']) : date('H'));
$background = daily($session['background'], $session['entry'], $sup);
$numeral = (isset($settings['locale']['numeral'][$session['units']])) ? $settings['locale']['numeral'][$session['units']] : $settings['locale']['numeral']['default'];
$olympus = str_replace('./','',(glob('./*.*.00.png')));
$kaiser = str_replace('./','',(glob('./'.$avaPrefix.'*.png')));
$amour = str_replace('./','',(glob('./'.$reticlePrefix.'*.png')));
$homer = str_replace('./','',(glob('./*.{ttf,ttc,otf}', GLOB_BRACE))); natcasesort($homer); array_unique($homer); $orpheus = str_replace('./','',(glob('./*.{wav,snd,au,ac3,oga,wma,mka}', GLOB_BRACE))); natcasesort($orpheus); array_unique($orpheus);
$musicBox = str_replace('./','',(glob('./*.{mp3,aac,flac,ogg}', GLOB_BRACE))); natcasesort($musicBox); array_unique($musicBox); $thematic = str_replace('./','',(glob('./*.start.png'))); $allUsers = str_replace('./','',(glob('./*_session.json')));
