<?php include 'functions.php';
echo /* ¶ 0 */ json_encode(exemplar(str_replace('./','',(glob('./*.contents.json')))),JSON_UNESCAPED_UNICODE);