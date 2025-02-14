<!-- access -->
<!-- GR: Βιομετρία σώματος; DE: Körperbiometrie; AT: Körperbiometrie; CY: Βιομετρία σώματος; CH: Corpus Biometrics; ES: Biometría corporal; MX: Biometría corporal; FR: Biométrie corporelle; BE: Biométrie corporelle; TR: Vücut Biyometrikleri; IT: Biometria corporea; RO: Biometria corpului; MD: Biometria corpului; LK: शरीर बायोमेट्रिक्स; IN: शारीरिक बायोमेट्रिक्स; RU: Телесная биометрия; RS: Биометрија тела; NP: གཟུགས་པོའི་སྐྱེ་དངོས་ཚད་འཇལ།; BR: Biometria Corporal; PT: Biometria Corporal; UA: Біометрія тіла; CN: 身体生物识别; KR: 신체 생체 인식; JP: 身体生体認証; AE: القياسات الحيوية للجسم -->
<script>
function mapleExec(input) {
    var mc=input.split(': ');
    var ma=mc[0],md=mc[1].split(' = ');
    ordarr(sysDefSessionID.value+'_maple.json','add',ma+'/'+md[0],md[1]); window.location.reload();
}
function mapleDel(id) {
    ordarr(sysDefSessionID.value+'_maple.json','drop',id,''); window.location.reload();
}
</script>
<?php $maple=arropen($sessionID.'_maple.json'); ?>
<p align='center' class='block'>
<input class="text" id="mapleCmd" style="width:65%;" type="text" value="" onkeydown="if (event.keyCode == 13) { mapleExec(mapleCmd.value); } else if (event.keyCode == 27) { mapleCmd.value='';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value);
}" oninput="handleInput(this.value,true);">
<input type="image" id="mapleExec" onmouseover="soundButton();" class="power" onclick="mapleExec(mapleCmd.value);" src="<?=$prefix.'return.png';?>">
<input type="image" id="mapleExec" onmouseover="soundButton();" class="power" onclick="mapleCmd.focus();" src="<?=$prefix.'keyboard.png';?>">
<input type="image" id="mapleExec" onmouseover="soundButton();" class="power" onclick="mapleCmd.value=''; mapleCmd.focus();" src="<?=$prefix.'backspace.png';?>">
</p>
<table id="maple" style="width:100%;">
<thead>
    <th>
        <?php foreach ($maple[array_key_first($maple)] as $eno=>$prp) { ?><td><?=$eno;?></td><?php } ?>
        <td><?=term('Actions', $settings['vocabulary'], $session['units']);?></td>
    </th>
</thead>
<tbody>
    <?php foreach ($maple as $key=>$ent) { ?>
    <tr>
        <td><?=$key;?></td>
        <?php foreach ($ent as $eno=>$val) { ?>
            <td><?=$val;?></td>
        <?php } ?>
        <td>
        <input type="image" name="<?=$key;?>" onmouseover="soundButton();" class="power" onclick="mapleDel(this.name);" src="<?=$prefix.'delete.png';?>">
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>