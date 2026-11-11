<?php
foreach ($settings['payload']['app_store']['forward'] as $key=>$val) {
    $urlEndPt=array_reverse(explode('/',parse_url($key)['path']))[0];
    $missingFiles=array_filter(pkgFiles($urlEndPt),function($file) {
        return !file_exists($file);
    }); if (!empty($missingFiles)) {
        $mirrorURIs=(is_array($val))?$val:(($val!='')?[$val]:[]);
        if (urlStatusCode($key)) { gitExec($key);
        } else {
            foreach ($mirrorURIs as $uri) {
                if (urlStatusCode($uri)) { gitExec($uri);
                } else { continue; }
            }
        }
    }
}