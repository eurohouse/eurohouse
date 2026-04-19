<?php include 'functions.php';
echo /* ¶ 0 */ json_encode(exemplar(str_replace('./','',(glob('./*.contents.json')))),JSON_UNESCAPED_UNICODE)."\r\n\r\n".
/* ¶ 1 */ json_encode(exemplar(str_replace('./','',(glob('./*.models.json')))),JSON_UNESCAPED_UNICODE);