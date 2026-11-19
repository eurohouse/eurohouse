<?php
foreach ($settings['payload']['app_store']['forward'] as $key=>$val) {
    $urlEndPt=array_reverse(explode('/',parse_url($key)['path']))[0];
    $noPkgFile=!file_exists($urlEndPt.'.package.json');
    $missingFiles=array_filter(pkgFiles($urlEndPt),function($file) {
        return !file_exists($file);
    }); if ($noPkgFile||!empty($missingFiles)) {
        $mirrorURIs=(is_array($val))?$val:(($val!='')?[$val]:[]);
        if (urlStatusCode($key)) {
            if ($noPkgFile) {
                $repoFiles=gitExec($key,'check');
                $anyFile=false;
                foreach ($repoFiles as $file) {
                    if (file_exists($file)) { $anyFile=true; break; }
                }
                if (!$anyFile) { gitExec($key); }
            } else { gitExec($key); }
        } else {
            foreach ($mirrorURIs as $uri) {
                if (urlStatusCode($uri)) {
                    if ($noPkgFile) {
                        $repoFiles=gitExec($uri,'check');
                        $anyFile=false;
                        foreach ($repoFiles as $file) {
                            if (file_exists($file)) { $anyFile=true; break; }
                        }
                        if (!$anyFile) { gitExec($uri); }
                    } else { gitExec($uri); }
                } else { continue; }
            }
        }
    }
}
