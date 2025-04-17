<!-- user -->
<!-- GR: Λογαριασμοί χρηστών; CY: Λογαριασμοί χρηστών; DE: Benutzerkonten; AT: Benutzerkonten; FR: Comptes utilisateur; BE: Comptes utilisateur; CH: Explorare Usuarem; IT: Profili utente; LK: उपयोक्तृलेखाः; TR: Kullanıcı hesapları; IN: उपयोगकर्ता खाते; PT: Contas de utilizador; BR: Contas de usuário; ES: Cuentas de usuario; MX: Cuentas de usuario; RO: Conturi de utilizator; MD: Conturi de utilizator; UA: Облікові записи користувачів; NP: སྤྱོད་མཁན་གྱི་ཁ་བྱང་།; RU: Учётные записи пользователей; RS: Кориснички налози; CN: 用户账户经理; KR: 사용자 계정; JP: ユーザーアカウント; AE: حسابات المستخدمين -->
<?php $indexUsers=str_replace('_session.json','',(str_replace('./','',(glob('./*_session.json'))))); ?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:10%;">
            <?=term('Icon',$settings['vocabulary'],$session['units']);?>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(2,'T');">
                <?=term('Project Name',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('Username',$settings['vocabulary'],$session['units']);?>
            </a>
        </th>
        <th style="width:10%;">
            <?=term('Actions',$settings['vocabulary'],$session['units']);?>
        </th>
    </tr>
</thead>
<tbody>
<?php
foreach ($indexUsers as $key=>$value) {
    $profData=(@json_decode(file_get_contents($value.'_session.json'),true)!=null)?json_decode(file_get_contents($value.'_session.json'),true):$settings['defaults'];
    $profIcon=(file_exists($avaPrefix.$profData['avatar'].'.png'))?$avaPrefix.$profData['avatar'].'.png':$avaPrefix.$settings['defaults']['avatar'].'.png';
    ?>
    <tr>
        <td>
            <a href="<?=$profIcon;?>">
                <img style="width:50%;" src="<?=$profIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><?=localizedTitle($profData,'title');?></td>
        <td><?=titleColon(localizedTitle($profData,'codename'),true,$settings,$session).localizedTitle($profData,'project');?></td>
        <td><?='@'.$value;?></td>
        <td>
        <p align='center' class='block'>
        <?php if (isAuthorized()) { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isFriends(this.name))?sysDefPrefix.value+'user.png':sysDefPrefix.value+'anonym.png';toggleFriend(this.name);" src="<?=$prefix.'user.png';?>">
        <?php if ($sessionID=='root') { ?>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name);window.location.reload();" src="<?=$prefix.'trash.png';?>">
        <?php } else {
            if ($value==$sessionID) { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="setfor(sysDefSessionID.value,sysDefPowersData,'dominion',-666);" src="<?=$prefix.'trash.png';?>">
            <?php } else { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json','','false');" src="<?=$prefix.'info.png';?>">
            <?php }
        }} else { ?>
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="bind(sysDefSessionID.value,this.name);" src="<?=$prefix.'chain.png';?>">
        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_session.json','','false');" src="<?=$prefix.'info.png';?>">
        <?php } ?>
        </p>
        </td>
    </tr>
    <?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:50%;" colspan="5"><?=term('Total elements:', $settings['vocabulary'], $session['units']).' '.count($indexUsers);?></th>
    </tr>
</tfoot>
</table>