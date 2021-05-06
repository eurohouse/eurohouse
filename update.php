<?php
$dir = '.';
$platform = file_get_contents('platform');
$updateSrc = file_get_contents('update.src');
$updateDel = explode('/', $updateSrc);
$openpkg = $updateDel[1];
$opendist = $updateDel[0];
$gitLink = 'https://www.github.com/'.$opendist.'/'.$openpkg;
$backupList = file_get_contents('backup.list');
$backup = explode(';', $backupList);
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Platform Update</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started';?>
<br>
<?='Updating your instance with the new '.$platform.' version';?>
<p></p>
<?='Backing up important files';?>
<br>
<?php
foreach($backup as $key=>$file) {
    if (file_exists($file)) {
        rename($file, $file.'.bak');
        chmod($file.'.bak', 0777);
        echo('> '.$file.' has backed up');
    } else {
        echo('> '.$file.' not found');
    }
    ?>
    <br>
<?php } ?>
<p></p>
<?='Downloading the latest version from GitHub';?>
<br>
<?php
exec('git clone '.$gitLink);
chmod($openpkg, 0777);
echo($gitLink);
?>
<br>
<?php
echo 'Extracting files';
exec('mv '.$openpkg.'/* $PWD');
exec('chmod -R 777 .');
?>
<br>
<?php
echo 'Removing source folder';
exec('rm -rf '.$openpkg); ?>
<br>
<?php
echo 'Removing README file';
if (file_exists('readme.md')) {
    chmod('readme.md', 0777);
    unlink('readme.md');
}
if (file_exists('README.md')) {
    chmod('README.md', 0777);
    unlink('README.md');
}
?>
<p></p>
<?='Restoring files from backup';?>
<br>
<?php
foreach($backup as $key=>$file) {
    if (file_exists($file.'.bak')) {
        rename($file.'.bak', $file);
        chmod($file, 0777);
        echo '> '.$file.' has restored';
    } else {
        echo '> '.$file.'.bak not found';
    }
    ?>
    <br>
<?php } ?>
<p></p>
<?php
$version = file_get_contents('version');
echo $platform.' has successfully updated with version '.$version;
?>
</body>
</html>
