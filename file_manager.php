<?php
if (strpos($request['output'], ',') !== false) {
    $outputArr = explode(',', $request['output']); $index = [];
    foreach ($outputArr as $outputValue) {
        if (strpos($outputValue, ':') !== false) {
            $strposIndex = explode(':', $outputValue);
            $outputVal = $strposIndex[0]; $outputArg = $strposIndex[1];
        } else {
            $outputVal = $outputValue; $outputArg = null;
        }
        if (file_exists($outputVal.'.pkg')) {
            $pkgFileArr = pkgf($outputVal, true);
            if (count($pkgFileArr) > 1) {
                unset($pkgFileArr[count($pkgFileArr)-1]);
            } if (file_exists($outputVal.'.collection.json')) {
                foreach ($pkgFileArr as $pkgOneFile) {
                    if (pathinfo($pkgOneFile, PATHINFO_EXTENSION) == 'png') {
                        $indexFileParts = explode('.', $pkgOneFile);
                        if (count($indexFileParts) == 4) {
                            if ($outputArg !== null) {
                                if ($indexFileParts[1] == $outputArg) {
                                    $index[] = $pkgOneFile;
                                }
                            } else {
                                $index[] = $pkgOneFile;
                            }
                        }
                    }
                }
            } else {
                foreach ($pkgFileArr as $pkgOneFile) { $index[] = $pkgOneFile; }
            }
        } elseif (isset($settings['collections'][$outputVal])) {
            $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$settings['collections'][$outputVal].'}*', GLOB_BRACE)));
            foreach ($indexArr as $indexFile) { $index[] = $indexFile; }
        } elseif ($outputVal == '/') {
            $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*', GLOB_ONLYDIR)));
            foreach ($indexArr as $indexFile) { $index[] = $indexFile; }
        } else {
            $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*')));
            foreach ($indexArr as $key=>$val) {
                if (strpos(strtolower($val), strtolower($outputVal)) !== false) {
                    $index[] = $val;
                }
            }
        }
    }
} else {
    $outputValue = $request['output'];
    if (strpos($outputValue, ':') !== false) {
        $strposIndex = explode(':', $outputValue);
        $outputVal = $strposIndex[0]; $outputArg = $strposIndex[1];
    } else {
        $outputVal = $outputValue; $outputArg = null;
    }
    if (file_exists($outputVal.'.pkg')) {
        $pkgFileArr = pkgf($outputVal, true);
        if (count($pkgFileArr) > 1) { unset($pkgFileArr[count($pkgFileArr)-1]); }
        if (file_exists($outputVal.'.collection.json')) {
            foreach ($pkgFileArr as $pkgOneFile) {
                if (pathinfo($pkgOneFile, PATHINFO_EXTENSION) == 'png') {
                    $indexFileParts = explode('.', $pkgOneFile);
                    if (count($indexFileParts) == 4) {
                        if ($outputArg !== null) {
                            if ($indexFileParts[1] == $outputArg) {
                                $index[] = $pkgOneFile;
                            }
                        } else {
                            $index[] = $pkgOneFile;
                        }
                    }
                }
            }
        } else {
            foreach ($pkgFileArr as $pkgOneFile) { $index[] = $pkgOneFile; }
        }
    } elseif (isset($settings['collections'][$outputVal])) {
        $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$settings['collections'][$outputVal].'}*', GLOB_BRACE)));
        foreach ($indexArr as $indexFile) { $index[] = $indexFile; }
    } elseif ($outputVal == '/') {
        $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*', GLOB_ONLYDIR)));
        foreach ($indexArr as $indexFile) { $index[] = $indexFile; }
    } else {
        $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*')));
        foreach ($indexArr as $key=>$val) {
            if (strpos(strtolower($val), strtolower($outputVal)) !== false) {
                $index[] = $val;
            }
        }
    }
} natcasesort($index); array_unique($index);
usort($index, function ($a, $b) {
    if ($a == $b) {
        return 0;
    } elseif (is_dir($a) && is_dir($b)) {
        return strcmp($a, $b);
    } elseif (!is_dir($a) && !is_dir($b)) {
        return strcmp($a, $b);
    } elseif (is_dir($a)) {
        return -1;
    } else {
        return 1;
    }
});
