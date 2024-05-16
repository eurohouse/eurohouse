<?php
$id = $_REQUEST['id'];
$to = $_REQUEST['to'];
$price = $_REQUEST['price'];
$cash = $_REQUEST['cash'];
$pass = $_REQUEST['pass'];
$type = $_REQUEST['type'];
$total = $cash; $amount = $price;
if (file_exists($id.'_'.$type.'_'.$to)) {
    $check = file_get_contents($id.'_'.$type.'_'.$to);
    if ($check == $pass) {
        if ($type == 'account') {
            if (($cash >= $price) && ($cash > 0) && ($price > 0)) {
                $total = $cash - $price; $amount = $price + $price; $stat = 0;
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
                $stat = 51;
            }
        } elseif ($type == 'password') {
            if (($cash >= $price) && ($cash > 0) && ($price > 0)) {
                $total = $cash - $price; $amount = $price + $price; $stat = 0;
                file_put_contents($id.'_password', md5($check)); chmod($id.'_password', 0777); chmod($id.'_'.$type.'_'.$to, 0777); unlink($id.'_'.$type.'_'.$to);
            } else {
                $stat = 51;
            }
        }
    } else {
        $stat = 403;
    }
} else {
    $stat = 404;
} echo $stat."\r\n".$total."\r\n".$amount;