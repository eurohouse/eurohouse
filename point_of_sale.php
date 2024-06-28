<?php
include 'functions.php';
function pos_account($seller, $buyer) {
    if ($seller.'_session.json.bak') {
        chmod($seller.'_session.json.bak', 0777);
        copy($seller.'_session.json.bak', $buyer.'_session.json.bak');
        chmod($buyer.'_session.json.bak', 0777);
    }
    chmod($seller.'_session.json', 0777);
    copy($seller.'_session.json', $buyer.'_session.json');
    chmod($buyer.'_session.json', 0777);
}
function pos_passwd($user, $content) {
    file_put_contents($user.'_password', md5($content));
    chmod($user.'_password', 0777);
}
function pos_soldout($user, $type) {
    chmod($user.'_'.$type.'.exch', 0777);
    unlink($user.'_'.$type.'.exch');
}
$seller = $_REQUEST['seller']; $buyer = $_REQUEST['buyer'];
$pass = $_REQUEST['pass']; $type = $_REQUEST['type'];
$pwr = arropen('dominion.json', "{\"root\":0}");
$ocrd = (isset($pwr[$seller])) ? $pwr[$seller] : 0;
$scrd = (isset($pwr[$buyer])) ? $pwr[$buyer] : 0;
if (file_exists($seller.'_'.$type.'.exch')) {
    $check = file_get_contents($seller.'_'.$type.'.exch');
    if ($check == $pass) {
        if ($type == 'account') {
            $prix = $ocrd;
            if (($scrd >= $prix) && ($scrd > 0) && ($ocrd > 0)) {
                $amount = $prix;
                pos_account($seller, $buyer);
                pos_passwd($buyer, $check);
                pos_soldout($seller, $type);
            } else {
                $amount = 'INSUFFICIENT FUNDS ('.$scrd.' < '.$prix.')';
            }
        } elseif ($type == 'password') {
            $prix = $ocrd;
            if (($scrd >= $prix) && ($scrd > 0) && ($ocrd > 0)) {
                $amount = $prix;
                pos_passwd($seller, $check);
                pos_soldout($seller, $type);
            } else {
                $amount = 'INSUFFICIENT FUNDS ('.$scrd.' < '.$prix.')';
            }
        }
    } else {
        $amount = 'ACCESS DENIED';
    }
} else {
    $amount = 'ITEM NOT FOUND';
}
echo $amount;
