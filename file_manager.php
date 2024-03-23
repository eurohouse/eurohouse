<?php
$output = str_replace(';', '', $request['output']);
if (strpos($output, ',') !== false) {
    $outputArr = explode(',', $output);
    $index = []; foreach ($outputArr as $outputValue) {
        if (strpos($outputValue, ':') !== false) {
            $strposIndex = explode(':', $outputValue);
            $outputVal = $strposIndex[0]; $outputArg = $strposIndex[1];
        } else {
            $outputVal = $outputValue; $outputArg = null;
        } if (file_exists($outputVal.'.pkg')) {
            $pkgFileOpen = eurarr($outputVal.'.pkg');
            $pkgFileArr = explode(';', $pkgFileOpen['files']);
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
                foreach ($pkgFileArr as $pkgOneFile) {
                    $index[] = $pkgOneFile;
                }
            }
        } elseif (isset($settings['collections'][$outputVal])) {
            $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$settings['collections'][$outputVal].'}*', GLOB_BRACE)));
            foreach ($indexArr as $indexFile) {
                $index[] = $indexFile;
            }
        } else {
            $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$outputVal.'}*', GLOB_BRACE)));
            foreach ($indexArr as $indexFile) {
                $index[] = $indexFile;
            }
        }
    }
} else {
    $outputValue = $output;
    if (strpos($outputValue, ':') !== false) {
        $strposIndex = explode(':', $outputValue);
        $outputVal = $strposIndex[0]; $outputArg = $strposIndex[1];
    } else {
        $outputVal = $outputValue; $outputArg = null;
    } if (file_exists($outputVal.'.pkg')) {
        $pkgFileOpen = eurarr($outputVal.'.pkg');
        $pkgFileArr = explode(';', $pkgFileOpen['files']);
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
            foreach ($pkgFileArr as $pkgOneFile) {
                $index[] = $pkgOneFile;
            }
        }
    } elseif (isset($settings['collections'][$outputVal])) {
        $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$settings['collections'][$outputVal].'}*', GLOB_BRACE))); foreach ($indexArr as $indexFile) {
            $index[] = $indexFile;
        }
    } else {
        $indexArr = str_replace($request['path'].'/','',(glob($request['path'].'/*{'.$outputVal.'}*', GLOB_BRACE))); foreach ($indexArr as $indexFile) {
            $index[] = $indexFile;
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
