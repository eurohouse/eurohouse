<?php
// Requesting file to move
$name = $_REQUEST['name'];
$to = $_REQUEST['to'];
// Moving file to destination directory and/or with new filename
if (file_exists('noedit')) {} else {
    rename($name, $to);
    chmod($to, 0777);
}
