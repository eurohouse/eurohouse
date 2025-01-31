<!-- access -->
<!-- GR: Τοπικοί χρήστες και ομάδες; DE: Lokale Benutzer und Gruppen; AT: Lokale Benutzer und Gruppen; CY: Τοπικοί χρήστες και ομάδες; CH: Administrare Usuarem; ES: Usuarios locales y grupos; MX: Usuarios locales y grupos; FR: Utilisateurs et groupes locaux; BE: Utilisateurs et groupes locaux; TR: Yerel kullanıcılar ve gruplar; IT: Utenti e gruppi locali; RO: Utilizatori și grupuri locale; MD: Utilizatori și grupuri locale; LK: स्थानीयप्रयोक्तारः समूहाः च; IN: स्थानीय उपयोगकर्ता और समूह; RU: Локальные пользователи и группы; RS: Локални корисници и групе; NP: ས་གནས་ཀྱི་སྤྱོད་མཁན་དང་སྡེ་ཚན།; BR: Usuários e grupos locais; PT: Utilizadores e grupos locais; UA: Локальні користувачі та групи; CN: 本地用户和组; KR: 로컬 사용자; JP: ローカルユーザ; AE: المستخدمون المحليون -->
<?php $relBind = str_replace('_session.json', '', $allUsers);
foreach ($relBind as $key=>$value) {
    $relTitle = (@json_decode(file_get_contents($value.'_session.json'), true) != null) ? json_decode(file_get_contents($value.'_session.json'), true)['title'] : $value; ?><p align='center' class='block'>
    <input type="button" value="<?=$value.'@'.$websiteID.':'.$request['path'].(($value == 'root')?'#':'$');?>" style="width:70%;" onmouseover="soundButton();"><?php if (isAuth()) { ?>
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isFriends(this.name))?sysDefPrefix.value+'user.png':sysDefPrefix.value+'anonym.png'; toggleFriend(this.name);" src="<?=$prefix.'user.png';?>">
    <?php if ($sessionID == 'root') { ?>
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); window.location.reload();" src="<?=$prefix.'delete.png';?>">
    <?php } else {
        if ($value == $sessionID) { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name); omniAuthRequest('signout', '', '');" src="<?=$prefix.'delete.png';?>">
        <?php } else { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png';?>">
        <?php }}} else { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="bind(sysDefSessionID.value, this.name);" src="<?=$prefix.'chain.png';?>">
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json', '', 'false');" src="<?=$prefix.'info.png';?>">
    <?php } ?>
</p><?php } ?>