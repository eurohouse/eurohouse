<!-- access -->
<!-- GR: Βιομετρία σώματος; DE: Körperbiometrie; AT: Körperbiometrie; CY: Βιομετρία σώματος; CH: Corpus Biometrics; ES: Biometría corporal; MX: Biometría corporal; FR: Biométrie corporelle; BE: Biométrie corporelle; TR: Vücut Biyometrikleri; IT: Biometria corporea; RO: Biometria corpului; MD: Biometria corpului; LK: शरीर बायोमेट्रिक्स; IN: शारीरिक बायोमेट्रिक्स; RU: Телесная биометрия; RS: Биометрија тела; NP: གཟུགས་པོའི་སྐྱེ་དངོས་ཚད་འཇལ།; BR: Biometria Corporal; PT: Biometria Corporal; UA: Біометрія тіла; CN: 身体生物识别; KR: 신체 생체 인식; JP: 身体生体認証; AE: القياسات الحيوية للجسم -->
<?php $maple=arropen($sessionID.'_maple.json'); ?>
<table id="maple" style="width:100%;">
<thead>
    <th>
        <?php foreach ($maple[array_key_first($maple)] as $eno=>$prp) { ?><td><?=$eno;?></td><?php } ?>
    </th>
</thead>
<tbody>
    <?php foreach ($maple as $key=>$ent) { ?>
    <tr>
        <td><?=$key;?></td>
        <?php foreach ($ent as $eno=>$val) { ?>
            <td><?=$val;?></td>
        <?php } ?>
    </tr>
    <?php } ?>
</tbody>
</table>