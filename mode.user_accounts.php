<!-- user -->
<!-- GR: Λογαριασμοί χρηστών; CY: Λογαριασμοί χρηστών; DE: Benutzerkonten; AT: Benutzerkonten; FR: Comptes utilisateur; BE: Comptes utilisateur; CH: Explorare Usuarem; IT: Profili utente; LK: उपयोक्तृलेखाः; TR: Kullanıcı hesapları; IN: उपयोगकर्ता खाते; PT: Contas de utilizador; BR: Contas de usuário; ES: Cuentas de usuario; MX: Cuentas de usuario; RO: Conturi de utilizator; MD: Conturi de utilizator; UA: Облікові записи користувачів; NP: སྤྱོད་མཁན་གྱི་ཁ་བྱང་།; RU: Учётные записи пользователей; RS: Кориснички налози; CN: 用户账户经理; KR: 사용자 계정; JP: ユーザーアカウント; AE: حسابات المستخدمين -->
<?php
$iconSize = 50;
$indexUsers = str_replace('_session.json', '', $allUsers);
?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:10%;">
            <?=term('Icon', $settings['vocabulary'], $session['units']);?>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(1, 'T');">
                <?=term('Name', $settings['vocabulary'], $session['units']);?>
            </a>
        </th>
        <th style="width:10%;">
            <a href="javascript:SortTable(2, 'T');">
                <?=term('Username', $settings['vocabulary'], $session['units']);?>
            </a>
        </th>
        <th style="width:10%;">
            <?=term('Actions', $settings['vocabulary'], $session['units']);?>
        </th>
    </tr>
</thead>
<tbody>
<?php
foreach ($indexUsers as $key=>$value) {
    $profData = (@json_decode(file_get_contents($value.'_session.json'), true) != null) ? json_decode(file_get_contents($value.'_session.json'), true) : $settings['defaults'];
    $profTitle = $profData['title'];
    $profIcon = (file_exists($avaPrefix.$profData['avatar'].'.png')) ? $avaPrefix.$profData['avatar'].'.png' : $avaPrefix.$settings['defaults']['avatar'].'.png';
    ?>
    <tr>
        <td>
            <a href="<?=$profIcon;?>">
                <img style="width:<?=$iconSize;?>%;" src="<?=$profIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><?=$profTitle;?></td>
        <td><?='@'.$value;?></td>
        <td>
        <p align='center' class='block'>
        <?php if (isAuth()) { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isFriends(this.name))?sysDefPrefix.value+'user.png':sysDefPrefix.value+'anonym.png'; toggleFriend(this.name);" src="<?=$prefix.'user.png';?>">
        <?php if ($sessionID == 'root') { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); window.location.reload();" src="<?=$prefix.'delete.png';?>">
        <?php } else {
            if ($value == $sessionID) { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); omniAuthRequest('signout', '', '');" src="<?=$prefix.'delete.png';?>">
            <?php } else { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png';?>">
            <?php }
        }} else { ?>
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="bind(sysDefSessionID.value, this.name);" src="<?=$prefix.'chain.png';?>">
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png';?>">
        <?php } ?>
        </p>
        </td>
    </tr>
    <?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:50%;" colspan="4"><?=term('Total elements:', $settings['vocabulary'], $session['units']).' '.count($indexUsers);?></th>
    </tr>
</tfoot>
</table>