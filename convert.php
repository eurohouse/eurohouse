<?php
$system = file_get_contents('system');
$dir = '.';
$MetricUnits = file_get_contents('metric');
$ImperialUnits = file_get_contents('imperial');
if ($system == "Metric") {
    $list = str_replace($dir.'/','',(glob($dir.'/*.{'.$MetricUnits.'}', GLOB_BRACE)));
} elseif ($system == "Imperial") {
    $list = str_replace($dir.'/','',(glob($dir.'/*.{'.$ImperialUnits.'}', GLOB_BRACE)));
}
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Convert Values</title>
<link rel="shortcut icon" href="hcli.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hcli.css?rev=<?=time();?>">
</head>
<body>
<?='HSIS Web Console started';?>
<br>
<?='Preparing to convert values';?>
<br>
<?='The entity measurement system was set to '.$system;?>
<p></p>
<?php
foreach ($list as $key=>$value) {
    echo 'Parsing '.$value.'...';
    $content = file_get_contents($value);
    $extension = pathinfo($value, PATHINFO_EXTENSION);
    $basename = basename($value, $extension);
    ?>
    <br>
    <?php
    $oldname = $basename.$extension;
    if ($system == "Metric") {
        $antigona = "Imperial";
        if ($extension == 'm') {
            $antigon = 'ft';
            $formula = $content * 3.281;
            $iunit = 'm';
            $ounit = 'ft';
        } elseif ($extension == 'cm') {
            $antigon = 'in';
            $formula = $content / 2.54;
            $iunit = 'cm';
            $ounit = 'in';
        } elseif ($extension == 'km') {
            $antigon = 'mi';
            $formula = $content / 1.609;
            $iunit = 'km';
            $ounit = 'mi';
        } elseif ($extension == 'kg') {
            $antigon = 'lb';
            $formula = $content * 2.205;
            $iunit = 'kg';
            $ounit = 'lb';
        } elseif ($extension == 'g') {
            $antigon = 'ct';
            $formula = (3*$content)/125;
            $iunit = 'g';
            $ounit = 'ct';
        } elseif ($extension == 'ml') {
            $antigon = 'fo';
            $formula = $content / 29.574;
            $iunit = 'ml';
            $ounit = 'fl oz';
        } elseif ($extension == 'm2') {
            $antigon = 'sqft';
            $formula = $content * 10.764;
            $iunit = 'm²';
            $ounit = 'sq ft';
        } elseif ($extension == 'm3') {
            $antigon = 'cuft';
            $formula = $content * 35.315;
            $iunit = 'm³';
            $ounit = 'cu ft';
        } elseif ($extension == 'km2') {
            $antigon = 'sqmi';
            $formula = $content / 2.59;
            $iunit = 'km²';
            $ounit = 'sq mi';
        } elseif ($extension == 'km3') {
            $antigon = 'cumi';
            $formula = $content / 4.168;
            $iunit = 'km³';
            $ounit = 'cu mi';
        } elseif ($extension == 'ms') {
            $antigon = 'fts';
            $formula = $content * 3.281;
            $iunit = 'm/s';
            $ounit = 'fts';
        } elseif ($extension == 'kmh') {
            $antigon = 'mph';
            $formula = $content / 1.609;
            $iunit = 'km/h';
            $ounit = 'mph';
        } elseif ($extension == 'deg') {
            $antigon = 'rad';
            $formula = $content * (22/7)/180;
            $iunit = '°';
            $ounit = 'rad';
        } elseif ($extension == 'c') {
            $antigon = 'f';
            $formula = ($content * (9/5)) + 32;
            $iunit = '°C';
            $ounit = '°F';
        } elseif ($extension == 'breu') {
            $antigon = 'brus';
            $formula = $content * 0.45;
            $iunit = 'EU';
            $ounit = 'US';
        } elseif ($extension == 'fteu') {
            $antigon = 'ftus';
            $formula = $content - 61/2;
            $iunit = 'EU';
            $ounit = 'US';
        } elseif ($extension == 'eur') {
            $antigon = 'usd';
            $formula = $content * 1.146;
            $iunit = '€';
            $ounit = '$';
        }
    } if ($system == "Imperial") {
        $antigona = "Metric";
        if ($extension == 'ft') {
            $antigon = 'm';
            $formula = $content / 3.281;
            $iunit = 'ft';
            $ounit = 'm';
        } elseif ($extension == 'in') {
            $antigon = 'cm';
            $formula = $content * 2.54;
            $iunit = 'in';
            $ounit = 'cm';
        } elseif ($extension == 'mi') {
            $antigon = 'km';
            $formula = $content * 1.609;
            $iunit = 'mi';
            $ounit = 'km';
        } elseif ($extension == 'lb') {
            $antigon = 'kg';
            $formula = $content / 2.205;
            $iunit = 'lb';
            $ounit = 'kg';
        } elseif ($extension == 'ct') {
            $antigon = 'g';
            $formula = $content / 24 * 1000;
            $iunit = 'ct';
            $ounit = 'g';
        } elseif ($extension == 'fo') {
            $antigon = 'ml';
            $formula = $content * 29.574;
            $iunit = 'fl oz';
            $ounit = 'ml';
        } elseif ($extension == 'sqft') {
            $antigon = 'm2';
            $formula = $content / 10.764;
            $iunit = 'sq ft';
            $ounit = 'm²';
        } elseif ($extension == 'cuft') {
            $antigon = 'm3';
            $formula = $content / 35.315;
            $iunit = 'cu ft';
            $ounit = 'm³';
        } elseif ($extension == 'sqmi') {
            $antigon = 'km2';
            $formula = $content * 2.59;
            $iunit = 'sq mi';
            $ounit = 'km²';
        } elseif ($extension == 'cumi') {
            $antigon = 'km3';
            $formula = $content * 4.168;
            $iunit = 'cu mi';
            $ounit = 'km³';
        } elseif ($extension == 'fts') {
            $antigon = 'ms';
            $formula = $content / 3.281;
            $iunit = 'fts';
            $ounit = 'm/s';
        } elseif ($extension == 'mph') {
            $antigon = 'kmh';
            $formula = $content * 1.609;
            $iunit = 'mph';
            $ounit = 'kmh';
        } elseif ($extension == 'rad') {
            $antigon = 'deg';
            $formula = $content * 180/(22/7);
            $iunit = 'rad';
            $ounit = '°';
        } elseif ($extension == 'f') {
            $antigon = 'c';
            $formula = ($content - 32)*(5/9);
            $iunit = '°F';
            $ounit = '°C';
        } elseif ($extension == 'brus') {
            $antigon = 'breu';
            $formula = $content * (2 + 8/36);
            $iunit = 'US';
            $ounit = 'EU';
        } elseif ($extension == 'ftus') {
            $antigon = 'fteu';
            $formula = $content + 61/2;
            $iunit = 'US';
            $ounit = 'EU';
        } elseif ($extension == 'usd') {
            $antigon = 'eur';
            $formula = $content / 1.146;
            $iunit = '$';
            $ounit = '€';
        }
    }
    $newname = $basename.$antigon;
    echo($oldname.' => '.$newname);
    ?>
    <br>
    <?php
    if ($extension == 'usd' && $antigon == 'eur') {
        echo $iunit.$content.' = '.$ounit.$formula;
    } elseif ($extension == 'eur' && $antigon == 'usd') {
        echo $iunit.$content.' = '.$ounit.$formula;
    } else {
        echo $content.' '.$iunit.' = '.$formula.' '.$ounit;
    }
    file_put_contents($newname, $formula);
    chmod($newname, 0777);
    chmod($oldname, 0777);
    unlink($oldname);
    ?>
    <p></p>
<?php } ?>
<p></p>
<?php echo 'All values are successfully converted';
if ($system == "Metric") {
    $antipode = "Imperial";
} elseif ($system == "Imperial") {
    $antipode = "Metric";
}
file_put_contents('system', $antipode);
chmod('system', 0777);
?>
<br>
<?='The entity measurements system is set to '.$antipode;?>
</body>
</html>
