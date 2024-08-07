<!-- user -->
<!-- GR: Λογαριασμοί χρηστών; CY: Λογαριασμοί χρηστών; DE: Benutzerkonten; AT: Benutzerkonten; FR: Comptes utilisateur; BE: Comptes utilisateur; CH: Explorare Usuarem; IT: Profili utente; LK: उपयोक्तृलेखाः; TR: Kullanıcı hesapları; IN: उपयोगकर्ता खाते; PT: Contas de utilizador; BR: Contas de usuário; ES: Cuentas de usuario; MX: Cuentas de usuario; RO: Conturi de utilizator; MD: Conturi de utilizator; UA: Облікові записи користувачів; NP: སྤྱོད་མཁན་གྱི་ཁ་བྱང་།; RU: Учётные записи пользователей; RS: Кориснички налози; CN: 用户账户经理; KR: 사용자 계정; JP: ユーザーアカウント; AE: حسابات المستخدمين -->
<?php $preStyle = "white-space:pre-wrap;word-wrap:break-word;";
$iconSize = 50; $relBind = str_replace('_session.json', '', $allUsers); ?>
<table style="width:100%;" id="table">
<thead><tr>
    <th style="width:7%;"><?=term('Icon', $settings['vocabulary'], $session['units']);?></th>
    <th style="width:16%;<?=$preStyle;?>"><a href="javascript:SortTable(1, 'T');"><?=term('Name', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:12%;<?=$preStyle;?>"><a href="javascript:SortTable(2, 'T');"><?=term('Username', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:5%;"><?=term('Actions', $settings['vocabulary'], $session['units']);?></th>
</tr></thead>
<tbody><?php foreach ($relBind as $key=>$value) {
    $cookieLeft = (@json_decode(file_get_contents($value.'_session.json'), true) != null) ? json_decode(file_get_contents($value.'_session.json'), true) : $defaultUserData;
    $attacheID = (isset($bindData[$value]) && ($bindData[$value] != $value)) ? $bindData[$value] : $value;
    $cookieRight = (@json_decode(file_get_contents($attacheID.'_session.json'), true) != null) ? json_decode(file_get_contents($attacheID.'_session.json'), true) : $cookieLeft;
    $cookieLeftAva = (file_exists($avaPrefix.$cookieLeft['avatar'].'.png')) ? $avaPrefix.$cookieLeft['avatar'].'.png' : $avaPrefix.$defaultUserData['avatar'].'.png';
    $powersInd = (is_numeric($powersData[$value])) ? $powersData[$value] : 0; ?><tr>
    <td><a href="<?=$cookieLeftAva;?>"><img style="width:<?=$iconSize;?>%;" src="<?=$cookieLeftAva.$suffix;?>" onmouseover="soundButton();"></a></td>
    <td><?=$cookieLeft['title'];?></td>
    <td><?=$value;?></td><td>
    <p align='center' class='block'>
    <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="bind(sysDefSessionID.value, this.name);" src="<?=$prefix.'chain.png'.$suffix;?>">
    <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isFriends(this.name)) ? sysDefPrefix.value+'user.png'+sysDefSuffix.value : sysDefPrefix.value+'anonym.png'+sysDefSuffix.value; toggleFriend(this.name);" src="<?=$prefix.'user.png'.$suffix;?>">
    <?php if (isAuth()) {
        if ($sessionID == 'root') { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); window.location.reload();" src="<?=$prefix.'delete.png'.$suffix;?>">
        <?php } else {
            if ($value == $sessionID) { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); omniAuthRequest('signout', '', '');" src="<?=$prefix.'delete.png'.$suffix;?>">
            <?php } else { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png'.$suffix;?>">
            <?php }
        }
    } else { ?>
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png'.$suffix;?>">
    <?php } ?>
    </p>
    </td>
</tr>
<?php } ?>
</tbody>
</table>