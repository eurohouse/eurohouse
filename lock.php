<?php
$password = $_POST['password'];
if (file_exists('noedit')) {
    $security = file_get_contents('password');
    if (md5($password) == $security) {
        chmod('noedit', 0777);
        unlink('noedit');
        chmod('password', 0777);
        unlink('password');
    }
} else {
    file_put_contents('noedit', '');
    chmod('noedit', 0777);
    file_put_contents('password', md5($password));
    chmod('password', 0777);
}
