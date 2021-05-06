<?php
// Requesting new directory creation
$name = $_REQUEST['name'];
// Creating a new empty directory
if (file_exists('noedit')) {} else {
    mkdir($name);
    chmod($name, 0777);
}
