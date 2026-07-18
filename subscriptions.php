<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/profile.json',json_encode($userSettings['defaults']));
$subscrArr=fileopen($cookie.'_files/subscription.json',json_encode($userSettings['subscriptions'])); $userSubscr=userSubscr($subscrArr,$userSettings['collections'],prefixes($userData));
echo /* ¶ 0 */ implode(',',prefixes($userData))."\r\n\r\n".
/* ¶ 1 */ json_encode($userSubscr,JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 2 */ json_encode(visitor($cookie),JSON_UNESCAPED_UNICODE);