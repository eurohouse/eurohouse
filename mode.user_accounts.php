<!-- user -->
<!-- GR: Λογαριασμοί χρηστών; CY: Λογαριασμοί χρηστών; DE: Benutzerkonten; AT: Benutzerkonten; FR: Comptes utilisateur; BE: Comptes utilisateur; CH: Explorare Usuarem; IT: Profili utente; LK: उपयोक्तृलेखाः; TR: Kullanıcı hesapları; IN: उपयोगकर्ता खाते; PT: Contas de utilizador; BR: Contas de usuário; ES: Cuentas de usuario; MX: Cuentas de usuario; RO: Conturi de utilizator; MD: Conturi de utilizator; UA: Облікові записи користувачів; NP: སྤྱོད་མཁན་གྱི་ཁ་བྱང་།; RU: Учётные записи пользователей; RS: Кориснички налози; CN: 用户账户经理; KR: 사용자 계정; JP: ユーザーアカウント; AE: حسابات المستخدمين -->
<?php $preStyle = "white-space:pre-wrap;word-wrap:break-word;";
$relBind = str_replace('_session.json', '', $allUsers); ?>
<table style="width:98%;" id="table"><thead><tr>
    <th style="width:10%;<?=$preStyle;?>"><a href="javascript:SortTable(0, 'T');"><?=term('Name', $settings['vocabulary'], $session['units']);?>
    </a></th>
    <th style="width:10%;<?=$preStyle;?>"><a href="javascript:SortTable(1, 'T');"><?=term('Username', $settings['vocabulary'], $session['units']);?></a></th>
    <th style="width:10%;"><?=term('Actions', $settings['vocabulary'], $session['units']);?></th>
    </tr></thead><tbody>
    <?php foreach ($relBind as $key=>$value) {
        $relTitle = (@json_decode(file_get_contents($value.'_session.json'), true) != null) ? json_decode(file_get_contents($value.'_session.json'), true)['title'] : $value; ?>
        <tr><td><?=$relTitle;?></td>
        <td><?='@'.$value;?></td><td>
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
    <?php } ?></p>
</td></tr><?php } ?>
</tbody></table>