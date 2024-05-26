<!-- access -->
<!-- RU: Локальные пользователи и группы; CN: 本地用户和组; KR: 로컬 사용자; JP: ローカルユーザ; AE: المستخدمون المحليون -->
<?php $line1Size = 70;
$relBind = str_replace('_session.json', '', $allUsers);
foreach ($relBind as $key=>$value) {
    $cookieLeft = (@json_decode(file_get_contents($value.'_session.json'), true) != null) ? json_decode(file_get_contents($value.'_session.json'), true) : $defaultUserData;
    $attacheID = (isset($bindData[$value]) && ($bindData[$value] != $value)) ? $bindData[$value] : $value; $cookieRight = (@json_decode(file_get_contents($attacheID.'_session.json'), true) != null) ? json_decode(file_get_contents($attacheID.'_session.json'), true) : $cookieLeft;
    $cookieLeftAva = (file_exists($avaPrefix.$cookieLeft['avatar'].'.png')) ? $avaPrefix.$cookieLeft['avatar'].'.png' : $avaPrefix.$defaultUserData['avatar'].'.png';
    $powersInd = (is_numeric($powersData[$value])) ? $powersData[$value] : 0; ?>
    <p align='center' class='block'>
    <input type="image" onmouseover="soundButton();" class="power" src="<?=$cookieLeftAva.$suffix;?>"><input type="button" value="<?=($value == 'root') ? $value.'@'.$websiteID.':'.$request['path'].'#' : $value.'@'.$websiteID.':'.$request['path'].'$';?>" style="width:<?=$line1Size;?>%;" onmouseover="soundButton();">
    <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="bind(sysDefSessionID.value, this.name);" src="<?=$prefix.'chain.png'.$suffix;?>">
    <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isFriends(this.name)) ? sysDefPrefix.value+'user.png'+sysDefSuffix.value : sysDefPrefix.value+'anonym.png'+sysDefSuffix.value; toggleFriend(this.name);" src="<?=$prefix.'user.png'.$suffix;?>">
    <?php if (isAuth()) {
        if ($sessionID == 'root') { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); window.location.reload();" src="<?=$prefix.'delete.png'.$suffix;?>">
        <?php } else {
            if ($value == $sessionID) { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); omniAuthRequest('signout','','');" src="<?=$prefix.'delete.png'.$suffix;?>">
            <?php } else { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png'.$suffix;?>">
            <?php }
        }
    } else { ?>
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
</p>
<?php } ?>