<?php
include 'functions.php';
$id = $_REQUEST['id'];
$to = $_REQUEST['to'];
$pass = $_REQUEST['pass'];
$type = $_REQUEST['type'];
$pwr = arropen('dominion.json', "{\"root\":0}");
$smo = (is_int($pwr_id)) ? $pwr[$id] : 0;
$omo = (is_int($pwr_id)) ? $pwr[$to] : 0;
$total = $cash; $amount = $price;
if (file_exists($id.'_'.$type.'_'.$to)) {
    $check = file_get_contents($id.'_'.$type.'_'.$to);
    if ($check == $pass) {
        if ($type == 'account') {
            $prix = $omo;
            if (($smo >= $prix) && ($smo > 0) && ($omo > 0)) {
                $amo = $prix;
                if ($id.'_session.json.bak') {
                    chmod($id.'_session.json.bak', 0777);
                    copy($id.'_session.json.bak', $to.'_session.json.bak');
                    chmod($to.'_session.json.bak', 0777);
                }
                chmod($id.'_session.json', 0777);
                copy($id.'_session.json', $to.'_session.json');
                chmod($to.'_session.json', 0777);
                file_put_contents($to.'_password', md5($check)); chmod($to.'_password', 0777); chmod($id.'_'.$type.'_'.$to, 0777); unlink($id.'_'.$type.'_'.$to);
            } else {
                $amo = 0;
            }
        } elseif ($type == 'password') {
            $prix = $omo;
            if (($smo >= $prix) && ($smo > 0) && ($omo > 0)) {
                $amo = $prix;
                file_put_contents($id.'_password', md5($check)); chmod($id.'_password', 0777);
                chmod($id.'_'.$type.'_'.$to, 0777);
                unlink($id.'_'.$type.'_'.$to);
            } else {
                $amo = 0;
            }
        }
    } else {
        $amo = 0;
    }
} else {
    $amo = 0;
}
echo $amo;