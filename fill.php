<?php
$installList = file_get_contents('install.list');
$install = explode(';', $installList);
foreach ($install as $key=>$string) {
    $split = explode('>', $string);
    $datafile = $split[0];
    $datatype = $split[1];
    $method = $split[2];
    $condition = $split[3];
    if ($method == 'save') {
        if ($condition == 'if') {
            if ($datatype == 'string') {
                if (file_exists($name.'/'.$datafile)) {
                } else {
                    file_put_contents($name.'/'.$datafile, '');
                    chmod($name.'/'.$datafile, 0777);
                }
            } elseif ($datatype == 'int') {
                if (file_exists($name.'/'.$datafile)) {
                } else {
                    file_put_contents($name.'/'.$datafile, 0);
                    chmod($name.'/'.$datafile, 0777);
                }
            }
        } elseif ($condition == 'do') {
            if ($datatype == 'string') {
                file_put_contents($name.'/'.$datafile, '');
                chmod($name.'/'.$datafile, 0777);
            } elseif ($datatype == 'int') {
                file_put_contents($name.'/'.$datafile, 0);
                chmod($name.'/'.$datafile, 0777);
            }
        }
    } elseif ($method == 'copy') {
        if ($condition == 'if') {
            if (file_exists($name.'/'.$datafile)) {
            } else {
                copy($datafile, $name.'/'.$datafile);
                chmod($name.'/'.$datafile, 0777);
            }
        } elseif ($condition == 'do') {
            copy($datafile, $name.'/'.$datafile);
            chmod($name.'/'.$datafile, 0777);
        }
    }
}
