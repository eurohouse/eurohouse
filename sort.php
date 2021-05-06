<?php
$category = $_REQUEST['id'];
$catName = $category.'.poll';
$catOpen = file_get_contents($catName);
$catExp = explode(' =//= ', $catOpen);
$value = $catExp[0];
$select = $catExp[1];
$range = $catExp[2];
$explode = explode(";", $select);
foreach ($explode as $key=>$item) {
    $id = $item;
    $rating = file_get_contents($id.'/rating');
    $ids .= $id.',';
    $ratings .= $rating.',';
}
$ids = str_replace(',,', '', $ids);
$ratings = str_replace(',,', '', $ratings);
$exp_ids = explode(",", $ids);
$exp_ratings = explode(",", $ratings);
$maxValue = max($exp_ratings);
$maxIndex = array_search($maxValue, $exp_ratings);
$maxObject = $exp_ids[$maxIndex];
$minValue = min($exp_ratings);
$minIndex = array_search($minValue, $exp_ratings);
$minObject = $exp_ids[$minIndex];
if ($maxValue - $minValue >= $range) {
    $select = str_replace($minObject.';', '', $select);
    file_put_contents($minObject.'/rating', '-666');
    chmod($minObject.'/rating', 0777);
}
file_put_contents($category.'.poll', $maxObject.' =//= '.$select.' =//= '.$range);
chmod($category.'.poll', 0777);
