<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/profile.json',json_encode($userSettings['defaults'])); $pref=prefixes($userData);
$subscrArr=fileopen($cookie.'_files/subscription.json',json_encode($userSettings['subscriptions']));
$userSubscr=userSubscr($subscrArr,$userSettings['collections'],$pref);
echo /* ¶ 0 */ implode(',',$pref)."\r\n\r\n".
/* ¶ 1 */ json_encode($userSubscr,JSON_UNESCAPED_UNICODE);