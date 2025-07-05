<!-- user -->
<!-- GR: Λογαριασμοί χρηστών; CY: Λογαριασμοί χρηστών; DE: Benutzerkonten; AT: Benutzerkonten; FR: Comptes utilisateur; BE: Comptes utilisateur; CH: Explorare Usuarem; IT: Profili utente; LK: उपयोक्तृलेखाः; TR: Kullanıcı hesapları; IN: उपयोगकर्ता खाते; PT: Contas de utilizador; BR: Contas de usuário; ES: Cuentas de usuario; MX: Cuentas de usuario; RO: Conturi de utilizator; MD: Conturi de utilizator; UA: Облікові записи користувачів; NP: སྤྱོད་མཁན་གྱི་ཁ་བྱང་།; RU: Учётные записи пользователей; RS: Кориснички налози; CN: 用户账户经理; KR: 사용자 계정; JP: ユーザーアカウント; AE: حسابات المستخدمين -->
<?php $indexUsers=str_replace('_files','',str_replace('./','',(glob('./*_files',GLOB_ONLYDIR)))); ?>
<table style="width:100%;" id="table">
<thead>
    <tr>
        <th style="width:10%;">
            <?=term('Icon',$settings,$session);?>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(1,'T');">
                <?=term('Name',$settings,$session);?>
            </a>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(2,'T');">
                <?=term('Project Name',$settings,$session);?>
            </a>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('Username',$settings,$session);?>
            </a>
        </th>
        <th style="width:10%;">
            <?=term('Actions',$settings,$session);?>
        </th>
    </tr>
</thead>
<tbody>
<?php
foreach ($indexUsers as $key=>$value) {
    $profData=fileopen($value.'_files/session.json',$settings['defaults']);
    $profIcon=(file_exists($prefix[0].$profData['avatar'].'.png'))?$prefix[0].$profData['avatar'].'.png':$prefix[0].$settings['defaults']['avatar'].'.png';
    ?>
    <tr>
        <td>
            <a href="<?=$profIcon;?>">
                <img style="width:50%;" src="<?=$profIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><?=titleCommand('[project|title]',$settings,$profData);?></td>
        <td><?=titleCommand('[codename:]',$settings,$profData).titleCommand('[project]',$settings,$profData);?></td>
        <td><?=$value;?></td>
        <td>
        <p align='center' class='block'>
            <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="bind(sysDefSessionID.value,this.name);" src="<?=$prefix[3].'chain.png';?>">
            <?php if (isAuthorized()) {
                if (isUserRoot($superuser)) { ?>
                    <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name);window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                <?php } else {
                    if ($value==$sessionID) { ?>
                        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(sysDefSessionID.value);" src="<?=$prefix[3].'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_files/session.json','','false');" src="<?=$prefix[3].'info.png';?>">
                    <?php }
                }
            } else { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_files/session.json','','false');" src="<?=$prefix[3].'info.png';?>">
        <?php } ?>
        </p>
        </td>
    </tr>
    <?php } ?>
</tbody>
<tfoot>
    <tr>
        <th style="width:50%;" colspan="5"><?=term('Total elements:',$settings,$session).' '.count($indexUsers);?></th>
    </tr>
</tfoot>
</table>