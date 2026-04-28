<!-- user -->
<!-- GR: Δημογραφία; CY: Δημογραφία; DE: Benutzerkonten; AT: Benutzerkonten; FR: Utilisateurs; BE: Utilisateurs; CH: Usoribus; IT: Utenti; LK: उपयोक्तारः; TR: Kullanıcılar; IN: उपयोगकर्ताओं; PT: Usuários; BR: Usuários; ES: Usuarios; MX: Usuarios; RO: Utilizatori; MD: Utilizatori; UA: Користувачі; NP: སྤྱོད་མཁན།; RU: Пользователи; RS: Корисници; CN: 用户; KR: 사용자; JP: ユーザー -->
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
        <th style="width:10%;">
            <a href="javascript:SortTable(3,'T');">
                <?=term('Timezone',$settings,$session);?>
            </a>
        </th>
        <th style="width:10%;">
            <a href="javascript:SortTable(4,'T');">
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
    $profData=fileopen($value.'_files/profile.json',$settings['defaults']);
    $profIcon=(file_exists($prefix[0].$profData['avatar'].'.png'))?$prefix[0].$profData['avatar'].'.png':$prefix[0].$settings['defaults']['avatar'].'.png';
    ?>
    <tr>
        <td>
            <a href="<?=$profIcon;?>">
                <img style="width:50%;" src="<?=$profIcon;?>" loading="lazy" onmouseover="soundButton();">
            </a>
        </td>
        <td><?=titleCommand('[title]',$settings,$profData);?></td>
        <td><?=titleCommand('[codename:]',$settings,$profData).titleCommand('[project|title]',$settings,$profData);?></td>
        <td><?=l10nEnt('timezones',base64_decode($profData['timezone']),$settings,$profData);?></td>
        <td><?=$value;?></td>
        <td>
        <p align='center' class='block'>
            <?php if (isAuthorized()) {
                if (isUserRoot($superuser)) { ?>
                    <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(this.name);window.location.reload();" src="<?=$prefix[3].'trash.png';?>">
                <?php } else {
                    if ($value==$sessionID) { ?>
                        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="delete_user(sysDefSessionID.value);" src="<?=$prefix[3].'trash.png';?>">
                    <?php } else { ?>
                        <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_files/profile.json','','false');" src="<?=$prefix[3].'info.png';?>">
                    <?php }
                }
            } else { ?>
                <input type="image" name="<?=$value;?>" onmouseover="soundButton();" class="power" onclick="omniPath(this.name+'_files/profile.json','','false');" src="<?=$prefix[3].'info.png';?>">
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