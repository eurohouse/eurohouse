<?php
$back = $_REQUEST['back'];
file_put_contents('background', $back);
chmod('background', 0777);
