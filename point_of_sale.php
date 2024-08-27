<?php
include 'functions.php';
function pos_suffice($seller, $buyer, $price) {
    return (($buyer >= $price) && ($buyer > 0) && ($seller >= 0));
}
function pos_account($seller, $buyer) {
    if ($seller.'_session.json.bak') {
        chmod($seller.'_session.json.bak', 0777);
        copy($seller.'_session.json.bak', $buyer.'_session.json.bak');
        chmod($buyer.'_session.json.bak', 0777);
    } chmod($seller.'_session.json', 0777);
    copy($seller.'_session.json', $buyer.'_session.json');
    chmod($buyer.'_session.json', 0777);
}
function pos_passwd($user, $content) {
    file_put_contents($user.'_password', $content);
    chmod($user.'_password', 0777);
} $seller = $_REQUEST['seller']; $buyer = $_REQUEST['buyer'];
$type = $_REQUEST['type']; $prix = $_REQUEST['price'];
$pass = $_REQUEST['pass'];
$pwr = arropen('dominion.json', "{\"root\":0}");
$ocrd = (isset($pwr[$seller])) ? $pwr[$seller] : 0;
$scrd = (isset($pwr[$buyer])) ? $pwr[$buyer] : 0;
if ($type == 'account') {
    if (pos_suffice($ocrd, $scrd, $prix)) {
        $amount = $prix; pos_account($seller, $buyer);
        pos_passwd($buyer, $pass);
    } else {
        $amount = 'INSUFFICIENT FUNDS ('.$scrd.' < '.$prix.')';
    }
} elseif ($type == 'password') {
    if (pos_suffice($ocrd, $scrd, $prix)) {
        $amount = $prix; pos_passwd($seller, $pass);
    } else {
        $amount = 'INSUFFICIENT FUNDS ('.$scrd.' < '.$prix.')';
    }
} else {
    if (pos_suffice($ocrd, $scrd, $prix)) {
        $amount = $prix;
    } else {
        $amount = 'INSUFFICIENT FUNDS ('.$scrd.' < '.$prix.')';
    }
} echo $amount;
