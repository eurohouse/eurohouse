<?php
$subRating = file_get_contents($subject.'/rating');
$subEnergy = file_get_contents($subject.'/energy');
$subMode = file_get_contents($subject.'/mode');
$subSystem = file_get_contents($subject.'/system');
$subGender = file_get_contents($subject.'/gender');
$subType = file_get_contents($subject.'/type');
$subName = file_get_contents($subject.'/name');
if ($subSystem == 'Metric') {
    $subWorth = file_get_contents($subject.'/worth.eur');
    $subWorthSign = '€';
    $subX = file_get_contents($subject.'/x.m');
    $subY = file_get_contents($subject.'/y.m');
    $subZ = file_get_contents($subject.'/z.m');
    $subReach = file_get_contents($subject.'/reach.m');
} elseif ($subSystem == 'Imperial') {
    $subWorth = file_get_contents($subject.'/worth.usd');
    $subWorthSign = '$';
    $subX = file_get_contents($subject.'/x.ft');
    $subY = file_get_contents($subject.'/y.ft');
    $subZ = file_get_contents($subject.'/z.ft');
    $subReach = file_get_contents($subject.'/reach.ft');
}
