<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$notesArr=fileopen($cookie.'_files/metadata.json',json_encode($userSettings['metadata'])); echo /* ¶ 0 */ json_encode($notesArr,JSON_UNESCAPED_UNICODE);