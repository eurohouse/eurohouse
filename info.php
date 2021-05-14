<?php
date_default_timezone_set('UTC');
$props = file_get_contents('info.list');
$parts = explode(";", $props);
$system = file_get_contents('system');
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Entity Info</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<p>
<?php
foreach($parts as $key=>$part) {
    $explode = explode(">", $part);
    $prop = $explode[0];
    $mode = $explode[1];
    $title = $explode[2];
    if ($mode == 'this') {
        $value = basename(dirname(__FILE__));
    } elseif ($mode == 'now') {
        $value = date($format);
    } elseif ($mode == 'value') {
        $value = file_get_contents($prop);
    } elseif ($mode == 'eval') {
        $eval = file_get_contents($prop);
        $value = eval($eval);
    } elseif ($mode == 'hex') {
        $hex = file_get_contents($prop);
        $value = bin2hex($hex);
    } elseif ($mode == 'md5') {
        $md5 = file_get_contents($prop);
        $value = md5($md5);
    } elseif ($mode == 'date') {
        $value = file_get_contents($prop);
        $format = $value;
    } elseif ($mode == 'temper') {
        if ($system == 'Metric') {
            $temper = file_get_contents($prop.'.c');
            $value = $temper.'°C';
        } elseif ($system == 'Imperial') {
            $temper = file_get_contents($prop.'.f');
            $value = $temper.'°F';
        }
    } elseif ($mode == 'money') {
        if ($system == 'Metric') {
            $money = file_get_contents($prop.'.eur');
            $value = '€'.$money;
        } elseif ($system == 'Imperial') {
            $money = file_get_contents($prop.'.usd');
            $value = '$'.$money;
        }
    } elseif ($mode == 'size') {
        if ($system == 'Metric') {
            $length = file_get_contents('length.m');
            $width = file_get_contents('width.m');
            $height = file_get_contents('height.m');
        } elseif ($system == 'Imperial') {
            $length = file_get_contents('length.ft');
            $width = file_get_contents('width.ft');
            $height = file_get_contents('height.ft');
        }
        $value = $length.'x'.$width.'x'.$height;
    } elseif ($mode == 'coord') {
        if ($system == 'Metric') {
            $x = file_get_contents('x.m');
            $y = file_get_contents('y.m');
            $z = file_get_contents('z.m');
        } elseif ($system == 'Imperial') {
            $x = file_get_contents('x.ft');
            $y = file_get_contents('y.ft');
            $z = file_get_contents('z.ft');
        }
        $value = '{'.$x.';'.$y.';'.$z.'}';
    } elseif ($mode == 'space') {
        if ($system == 'Metric') {
            $spaceExt = 'm';
        } elseif ($system == 'Imperial') {
            $spaceExt = 'ft';
        }
        $space = file_get_contents($prop.'.'.$spaceExt);
        $value = $space.' '.$spaceExt;
    } else {
        $value = file_get_contents($prop);
    }
    $content = $title.': '.$value;
    echo $content;
    ?>
<br>
<?php } ?>
</p>
</body>
</html>
