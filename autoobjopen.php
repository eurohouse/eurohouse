<?php
$objRating = file_get_contents($object.'/rating');
$objEnergy = file_get_contents($object.'/energy');
$objMode = file_get_contents($object.'/mode');
$objSystem = file_get_contents($object.'/system');
$objGender = file_get_contents($object.'/gender');
$objType = file_get_contents($object.'/type');
$objName = file_get_contents($object.'/name');
if ($objSystem == 'Metric') {
    $objWorth = file_get_contents($object.'/worth.eur');
    $objWorthSign = '€';
    $objX = file_get_contents($object.'/x.m');
    $objY = file_get_contents($object.'/y.m');
    $objZ = file_get_contents($object.'/z.m');
    $objReach = file_get_contents($object.'/reach.m');
} elseif ($objSystem == 'Imperial') {
    $objWorth = file_get_contents($object.'/worth.usd');
    $objWorthSign = '$';
    $objX = file_get_contents($object.'/x.ft');
    $objY = file_get_contents($object.'/y.ft');
    $objZ = file_get_contents($object.'/z.ft');
    $objReach = file_get_contents($object.'/reach.ft');
}
