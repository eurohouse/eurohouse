<?php
// Getting content request
$content = $_REQUEST['content'];
// Saving content
file_put_contents('journal', $content);
chmod('journal', 0777);
