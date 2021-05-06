<?php
$mimetype = mime_content_type($value);
$filesize = filesize($value);
$pathinfo = pathinfo($value);
$extension = $pathinfo['extension'];
if ($mimetype == "inode/directory" || $mimetype == "directory") {
    if (file_exists($value.'/favicon.png')) {
        $icon = $value.'/favicon.png';
        $type = 'directory';
    } else {
        $icon = 'directory.png';
        $type = 'directory';
    }
} elseif ($mimetype == "application/octet-stream") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/plain") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/html") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "text/xml") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "text/css") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/x-asm") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/csv") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/x-log") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/x-java") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/javascript") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "text/php") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "text/x-php") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "font/ttf") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "font/otf") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "font/woff2") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "font/sfnt") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/vnd.ms-opentype") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/xml") {
    $icon = 'text.png';
    $type = 'text';
} elseif ($mimetype == "application/zip") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/x-compress") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/rar") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/tar") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/x-bzip2") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/gzip") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/php") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/x-php") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/x-httpd-php") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/x-httpd-php-source") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/pdf") {
    $icon = 'book.png';
    $type = 'app';
} elseif ($mimetype == "application/epub+zip") {
    $icon = 'book.png';
    $type = 'app';
} elseif ($mimetype == "application/photoshop") {
    $icon = 'picture.png';
    $type = 'app';
} elseif ($mimetype == "application/x-photoshop") {
    $icon = 'picture.png';
    $type = 'app';
} elseif ($mimetype == "application/psd") {
    $icon = 'book.png';
    $type = 'app';
} elseif ($mimetype == "application/rtf") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/vnd.oasis.opendocument.presentation") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/vnd.oasis.opendocument.spreadsheet") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "application/vnd.oasis.opendocument.text") {
    $icon = 'app.png';
    $type = 'app';
} elseif ($mimetype == "image/png") {
    $icon = $value;
    $type = 'picture';
} elseif ($mimetype == "image/jpeg") {
    $icon = $value;
    $type = 'picture';
} elseif ($mimetype == "image/gif") {
    $icon = $value;
    $type = 'picture';
} elseif ($mimetype == "image/bmp") {
    $icon = $value;
    $type = 'picture';
} elseif ($mimetype == "image/tiff") {
    $icon = $value;
    $type = 'picture';
} elseif ($mimetype == "image/psd") {
    $icon = 'picture.png';
    $type = 'app';
} elseif ($mimetype == "image/vnd.adobe.photoshop") {
    $icon = 'picture.png';
    $type = 'app';
} elseif ($mimetype == "image/vnd.djvu") {
    $icon = 'book.png';
    $type = 'app';
} elseif ($mimetype == "audio/aac") {
    $icon = 'music.png';
    $type = 'music';
} elseif ($mimetype == "audio/aiff") {
    $icon = 'music.png';
    $type = 'music';
} elseif ($mimetype == "audio/basic") {
    $icon = 'sound.png';
    $type = 'sound';
} elseif ($mimetype == "audio/mpeg") {
    $icon = 'music.png';
    $type = 'music';
} elseif ($mimetype == "audio/m4a") {
    $icon = 'sound.png';
    $type = 'sound';
} elseif ($mimetype == "audio/ogg") {
    $icon = 'sound.png';
    $type = 'sound';
} elseif ($mimetype == "audio/flac") {
    $icon = 'music.png';
    $type = 'music';
} elseif ($mimetype == "audio/x-flac") {
    $icon = 'music.png';
    $type = 'music';
} elseif ($mimetype == "audio/wav") {
    $icon = 'sound.png';
    $type = 'sound';
} elseif ($mimetype == "audio/midi") {
    $icon = 'midi.png';
    $type = 'midi';
} elseif ($mimetype == "audio/x-midi") {
    $icon = 'midi.png';
    $type = 'midi';
} elseif ($mimetype == "audio/mid") {
    $icon = 'midi.png';
    $type = 'midi';
} elseif ($mimetype == "video/avi") {
    $icon = 'video.png';
    $type = 'video';
} elseif ($mimetype == "video/flv") {
    $icon = 'video.png';
    $type = 'video';
} elseif ($mimetype == "video/ogg") {
    $icon = 'video.png';
    $type = 'video';
} elseif ($mimetype == "video/mpeg") {
    $icon = 'video.png';
    $type = 'video';
} elseif ($mimetype == "video/mp4") {
    $icon = 'video.png';
    $type = 'video';
} elseif ($mimetype == "video/3gpp") {
    $icon = 'video.png';
    $type = 'video';
} elseif ($mimetype == "video/quicktime") {
    $icon = 'video.png';
    $type = 'video';
} else {
    $icon = 'text.png';
    $type = 'text';
}
if ($extension == 'uri') {
    $icon = 'link.png';
    $type = 'link';
} elseif ($extension == 'pkg') {
    $icon = 'package.png';
    $type = 'package';
} elseif ($extension == 'post') {
    $icon = 'blog.png';
    $type = 'post';
} elseif ($extension == 'book') {
    $icon = 'book.png';
    $type = 'book';
} elseif ($extension == 'slot') {
    $icon = 'slot.png';
    $type = 'slot';
} elseif ($extension == 'poll') {
    $icon = 'poll.png';
    $type = 'poll';
} elseif ($extension == 'm') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'ft') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'cm') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'in') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'km') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'mi') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'kg') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'lb') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'g') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'ct') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'ml') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'fo') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'm2') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'sqft') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'm3') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'cuft') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'km2') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'sqmi') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'km3') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'cumi') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'ms') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'fts') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'kmh') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'mph') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'deg') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'rad') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'c') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'f') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'breu') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'brus') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'fteu') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'ftus') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'eur') {
    $icon = 'value.png';
    $type = 'value';
} elseif ($extension == 'usd') {
    $icon = 'value.png';
    $type = 'value';
}
if ($type == 'text') {
    $link = 'edit.php?name='.$value;
} elseif ($type == 'image') {
    $link = $value;
} elseif ($type == 'music') {
    $link = "javascript:play('".$value."');";
} elseif ($type == 'sound') {
    $link = "javascript:play('".$value."');";
} elseif ($type == 'midi') {
    $link = "javascript:playMIDI('".$value."');";
} elseif ($type == 'video') {
    $link = 'watch.php?name='.$value;
} elseif ($type == 'app') {
    $link = $value;
} elseif ($type == 'package') {
    $pkgBase = basename($value, '.pkg');
    $link = 'pkginfo.php?pkg='.$pkgBase;
} elseif ($type == 'post') {
    $link = 'read.php?name='.$value;
} elseif ($type == 'book') {
    $link = 'read.php?name='.$value;
} elseif ($type == 'slot') {
    $link = 'slot.php?name='.$value;
} elseif ($type == 'poll') {
    $link = 'poll.php?name='.$value;
} elseif ($type == 'value') {
    $link = 'value.php?name='.$value;
} elseif ($type == 'link') {
    $cont = file_get_contents($value);
    $div = explode('>', $cont);
    $link = $div[1];
} else {
    $link = $value;
}
?>
