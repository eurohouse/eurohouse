<?php
$pkg = $_REQUEST['pkg'];
$dist = $_REQUEST['dist'];
// Make sure pkg and dist fields are not empty to prevent this script from going haywire, moving system files to the current directory.
if ($pkg != "" && $dist != "") {
    // Backing up important data
    $backupList = file_get_contents('backup.list');
    $backup = explode(';', $backupList);
    foreach ($backup as $key=>$file) {
        if (file_exists($file)) {
            rename($file, $file.'.bak');
            chmod($file.'.bak', 0777);
        }
    }
    // Downloading new package from its GitHub repository
    $gitRequest = 'https://www.github.com/'.$dist.'/'.$pkg;
    exec('git clone '.$gitRequest);
    chmod($pkg, 0777);
    exec('mv '.$pkg.'/* $PWD');
    exec('chmod -R 777 .');
    exec('rm -rf '.$pkg);
    // Removing source Readme file
    if (file_exists('readme.md')) {
        chmod('readme.md', 0777);
        unlink('readme.md');
    }
    if (file_exists('README.md')) {
        chmod('README.md', 0777);
        unlink('README.md');
    }
    // Restoring files from backups
    foreach ($backup as $key=>$file) {
        if (file_exists($file.'.bak')) {
            rename($file.'.bak', $file);
            chmod($file, 0777);
        }
    }
    // Adding application shortcuts
    $apps = file_get_contents('apps.list');
    if (file_exists($pkg.'.pkg')) {
        $list = file_get_contents($pkg.'.pkg');
        $files = explode(';', $list);
        foreach ($files as $file) {
            if (strpos($file, '>') !== false) {
                $apps = $apps.$file.';';
            } elseif (strpos($file, '~') !== false) {
                $newfile = str_replace('~', '', $file);
                if (file_exists($newfile.'.bak')) {
                    rename($newfile.'.bak', $newfile);
                    chmod($newfile, 0777);
                }
            }
        }
        // Saving list of apps
        file_put_contents('apps.list', $apps);
        chmod('apps.list', 0777);
    }
    // Saving get package config file
    file_put_contents('get.cfg', $dist.'/'.$pkg);
    chmod('get.cfg', 0777);
}
