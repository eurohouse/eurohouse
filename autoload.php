<?php
if (!file_exists('get.php')) {
    foreach ($settings['payload']['app_store']['forward'] as $key=>$val) {
        $mirrorURIs=(is_array($val))?$val:(($val!='')?[$val]:[]);
        if (urlStatusCode($key)) { gitExec($key);
        } else {
            foreach ($mirrorURIs as $uri) {
                if (urlStatusCode($uri)) { gitExec($uri);
                } else { continue; }
            }
        }
    } header("Location: index.php");
}