<!-- dice -->
<!-- RU: Участвовать в опросе; CN: 竞争性在线调查; TW: 竞争性在线调查; JP: 竞争性在线调查; AE: استطلاع على الانترنت -->
<!-- <ref> -->
<!-- true -->
<?php $pollArray = json_decode(file_get_contents($request['input']), true);
$pollIndex = $pollArray['options']; $pollType = $pollArray['type'];
$pollCloseCase = $pollArray['range']; $pollMaximum = max($pollIndex); $pollMinimum = min($pollIndex);
$pollBroad = $pollMaximum - $pollMinimum;
if ($pollType == 'start_duel' || $pollType == 'init_duel') { ?>
<p align='center'><?php $ksWrite = '';
    foreach ($pollIndex as $key=>$value) {
        $ksTitle = circumflex($key, $settings['defaults']['avatar'])[0];
        $ksWrite .= $ksTitle.' vs ';
    } echo substr($ksWrite, 0, -4).'<br>'; $ksLog = '';
    foreach ($pollIndex as $key=>$value) {
        $ksLog .= $value.' : ';
    } echo substr($ksLog, 0, -3);
    if ($pollBroad >= $pollCloseCase) {
        echo '<br>'.circumflex(array_search($pollMaximum, $pollIndex), $settings['defaults']['avatar'])[0].' wins!';
    } ?></p><p align='center'><?php
    foreach ($pollIndex as $key=>$value) {
        $ksTitle = circumflex($key, $settings['defaults']['avatar'])[0];
        $ksIMG = circumflex($key, $settings['defaults']['avatar'])[1];
    ?><img style="height:36%;position:relative;" onmouseover="soundButton();" name="<?=$request['input'];?>" id="<?=$key;?>" title="<?=$ksTitle;?>" src="<?=$avaPrefix.$ksIMG.'.png'.$suffix;?>" onclick="poll(this.name, this.id, false);"><?php } ?></p><?php } else {
        arsort($pollIndex, SORT_NUMERIC);
        foreach ($pollIndex as $key=>$value) { ?>
    <p align='center'>
    <input style="width:58%;" type="button" name="<?=$request['input'];?>" id="<?=$key;?>" value="<?=$key;?>" onmouseover="soundButton();">
    <input style="width:32%;" type="button" name="<?=$request['input'];?>" id="<?=$key;?>" value="<?=$value;?>" onmouseover="soundButton();" onclick="poll(this.name, this.id, false);">
    </p><?php }} ?>