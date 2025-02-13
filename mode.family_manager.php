<!-- access -->
<!-- GR: Τοπικοί χρήστες και ομάδες; DE: Lokale Benutzer und Gruppen; AT: Lokale Benutzer und Gruppen; CY: Τοπικοί χρήστες και ομάδες; CH: Administrare Usuarem; ES: Usuarios locales y grupos; MX: Usuarios locales y grupos; FR: Utilisateurs et groupes locaux; BE: Utilisateurs et groupes locaux; TR: Yerel kullanıcılar ve gruplar; IT: Utenti e gruppi locali; RO: Utilizatori și grupuri locale; MD: Utilizatori și grupuri locale; LK: स्थानीयप्रयोक्तारः समूहाः च; IN: स्थानीय उपयोगकर्ता और समूह; RU: Локальные пользователи и группы; RS: Локални корисници и групе; NP: ས་གནས་ཀྱི་སྤྱོད་མཁན་དང་སྡེ་ཚན།; BR: Usuários e grupos locais; PT: Utilizadores e grupos locais; UA: Локальні користувачі та групи; CN: 本地用户和组; KR: 로컬 사용자; JP: ローカルユーザ; AE: المستخدمون المحليون -->
<?php
$maple=arropen($sessionID.'_maple.json');
?>
<table id="maple" style="width:100%;">
<tbody>
    <?php foreach ($maple as $key=>$ent) { ?>
    <tr>
        <td><?=$key;?></td>
        <?php foreach ($ent as $eno=>$val) { ?>
            <td><?=$eno;?></td>
            <td><?=$val;?></td>
        <?php } ?>
    </tr>
    <?php } ?>
</tbody>
</table>