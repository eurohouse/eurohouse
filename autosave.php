<?php
// SUBJECT_DATA
file_put_contents($subject.'/rating', $subRating);
chmod($subject.'/rating', 0777);
file_put_contents($subject.'/energy', $subEnergy);
chmod($subject.'/energy', 0777);
file_put_contents($subject.'/mode', $subMode);
chmod($subject.'/mode', 0777);
file_put_contents($subject.'/system', $subSystem);
chmod($subject.'/system', 0777);
file_put_contents($subject.'/gender', $subGender);
chmod($subject.'/gender', 0777);
file_put_contents($subject.'/type', $subType);
chmod($subject.'/type', 0777);
file_put_contents($subject.'/name', $subName);
chmod($subject.'/name', 0777);
if ($subSystem == 'Metric') {
    file_put_contents($subject.'/worth.eur', $subWorth);
    chmod($subject.'/worth.eur', 0777);
    file_put_contents($subject.'/x.m', $subX);
    chmod($subject.'/x.m', 0777);
    file_put_contents($subject.'/y.m', $subY);
    chmod($subject.'/y.m', 0777);
    file_put_contents($subject.'/z.m', $subZ);
    chmod($subject.'/z.m', 0777);
    file_put_contents($subject.'/reach.m', $subReach);
    chmod($subject.'/reach.m', 0777);
} elseif ($subSystem == 'Imperial') {
    file_put_contents($subject.'/worth.usd', $subWorth);
    chmod($subject.'/worth.usd', 0777);
    file_put_contents($subject.'/x.ft', $subX);
    chmod($subject.'/x.ft', 0777);
    file_put_contents($subject.'/y.ft', $subY);
    chmod($subject.'/y.ft', 0777);
    file_put_contents($subject.'/z.ft', $subZ);
    chmod($subject.'/z.ft', 0777);
    file_put_contents($subject.'/reach.ft', $subReach);
    chmod($subject.'/reach.ft', 0777);
}
// OBJECT_DATA
file_put_contents($object.'/rating', $objRating);
chmod($object.'/rating', 0777);
file_put_contents($object.'/energy', $objEnergy);
chmod($object.'/energy', 0777);
file_put_contents($object.'/mode', $objMode);
chmod($object.'/mode', 0777);
file_put_contents($object.'/system', $objSystem);
chmod($object.'/system', 0777);
file_put_contents($object.'/gender', $objGender);
chmod($object.'/gender', 0777);
file_put_contents($object.'/type', $objType);
chmod($object.'/type', 0777);
file_put_contents($object.'/name', $objName);
chmod($object.'/name', 0777);
if ($objSystem == 'Metric') {
    file_put_contents($object.'/worth.eur', $objWorth);
    chmod($object.'/worth.eur', 0777);
    file_put_contents($object.'/x.m', $objX);
    chmod($object.'/x.m', 0777);
    file_put_contents($object.'/y.m', $objY);
    chmod($object.'/y.m', 0777);
    file_put_contents($object.'/z.m', $objZ);
    chmod($object.'/z.m', 0777);
    file_put_contents($object.'/reach.m', $objReach);
    chmod($object.'/reach.m', 0777);
} elseif ($objSystem == 'Imperial') {
    file_put_contents($object.'/worth.usd', $objWorth);
    chmod($object.'/worth.usd', 0777);
    file_put_contents($object.'/x.ft', $objX);
    chmod($object.'/x.ft', 0777);
    file_put_contents($object.'/y.ft', $objY);
    chmod($object.'/y.ft', 0777);
    file_put_contents($object.'/z.ft', $objZ);
    chmod($object.'/z.ft', 0777);
    file_put_contents($object.'/reach.ft', $objReach);
    chmod($object.'/reach.ft', 0777);
}
