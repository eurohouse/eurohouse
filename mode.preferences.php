<!-- settings -->
<!-- GR: Πίνακας Ελέγχου; CY: Πίνακας Ελέγχου; FR: Panneau de contrôle; BE: Panneau de contrôle; IT: Pannello di controllo; PT: Painel de controlo; BR: Painel de controle; IN: कंट्रोल पैनल; LK: नियन्त्रण पटल; RS: Контролна табла; ES: Panel de control; MX: Panel de control; DE: Schalttafel; AT: Schalttafel; CH: Occasus Generalis; RO: Panou de control; MD: Panou de control; UA: Панель управління; NP: ཚོད་འཛིན་སྒྲོམ་གཞི།; TR: Kontrol Paneli; RU: Панель управления; CN: 应用程序偏好设置; KR: 프로그램 설정; JP: 番組設定; AE: تفضيلات التطبيق -->
<p align='center'>
<input type="button" onmouseover="soundButton();" onclick="applyTheme(setSizeSequence.value, setColorSequence.value); setdata('specimen', encodeURIComponent(setSpecimen.value));" value="<?=term('Apply', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="rename_user(setUsername.value, setPassword.value); omniAuthRequest('signin', setUsername.value, setPassword.value);" value="<?=term('Update', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setSizeSequence.value = '7 0 180 14 14 14 17 16 15 18 14 14 14'; setColorSequence.value = 'C0BFC0|605F60|E5E5E5|FFFFFF|FFFFFF|000000|FFFFFF|000000|403F40|D5D5D5'; applyTheme(setSizeSequence.value, setColorSequence.value); setSpecimen.value = 'Q F S H Æ Ø Ð Ñ ʒ ʊ ʎ ɸ Σ Φ Ω Θ Г З Х Б ظ ض ؤ ل 인 방 학 적 中 京 日 木 𐎁 𐎛 𐎍 𐎄 🍷 ☕️ 🍾 🍫'; setdata('specimen', setSpecimen.value);" value="<?=term('Reset', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setdata('font_ascii', 'flexo.ttf'); setdata('font_latin', 'flexo.ttf'); setdata('font_phone', 'arialuni.ttf'); setdata('font_greek', 'ubuntu.ttf'); setdata('font_cyril', 'ubuntu.ttf'); setdata('font_arabi', 'arialuni.ttf'); setdata('font_korea', 'arialuni.ttf'); setdata('font_china', 'arialuni.ttf'); setdata('font_other', 'arialuni.ttf'); setdata('font_emoji', 'twemoji.ttf'); window.location.reload();" value="<?=term('Clear', $settings['vocabulary'], $session['units']);?>"><br>
<label><?=term('Specimen Text:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setSpecimen" style="width:64%;" value="<?=$session['specimen'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('specimen', encodeURIComponent(this.value));
} else if (event.keyCode == 27) {
    this.value = 'Q F S H Æ Ø Ð Ñ ʒ ʊ ʎ ɸ Σ Φ Ω Θ Г З Х Б ظ ض ؤ ل 인 방 학 적 中 京 日 木 𐎁 𐎛 𐎍 𐎄 🍷 ☕️ 🍾 🍫'; setdata('specimen', this.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="number" min='0' max='9' step='1' id="setMagnitude" style="width:14%;" value="<?=$session['magnitude'];?>" oninput="setdata('magnitude', setMagnitude.value); handleInput(this.value, true);" onkeydown="if (event.keyCode == 27) {
    setMagnitude.value = 5;
    setdata('magnitude', setMagnitude.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}"><br>
<label><?=term('Font Configuration:', $settings['vocabulary'], $session['units']);?></label><br>
<select id="setUTF0" style="width:15%;" onchange="setdata('font_ascii', setUTF0.options[setUTF0.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_ascii']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF1" style="width:15%;" onchange="setdata('font_latin', setUTF1.options[setUTF1.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_latin']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF2" style="width:15%;" onchange="setdata('font_phone', setUTF2.options[setUTF2.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_phone']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF3" style="width:15%;" onchange="setdata('font_greek', setUTF3.options[setUTF3.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_greek']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF4" style="width:15%;" onchange="setdata('font_cyril', setUTF4.options[setUTF4.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_cyril']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<br>
<select id="setUTF5" style="width:15%;" onchange="setdata('font_arabi', setUTF5.options[setUTF5.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_arabi']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF6" style="width:15%;" onchange="setdata('font_korea', setUTF6.options[setUTF6.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_korea']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF7" style="width:15%;" onchange="setdata('font_china', setUTF7.options[setUTF7.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_china']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF8" style="width:15%;" onchange="setdata('font_other', setUTF8.options[setUTF8.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_other']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select>
<select id="setUTF9" style="width:15%;" onchange="setdata('font_emoji', setUTF9.options[setUTF9.selectedIndex].id); window.location.reload();">
<?php foreach ($lockFonts as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['font_emoji']) == $value) { ?> selected <?php } ?>>
<?=$value;?>
</option>
<?php } ?>
</select><br>
<label><?=term('Sound Effects:', $settings['vocabulary'], $session['units']);?></label><br>
<select id="setAlarmSound" style="width:15%;" onchange="setdata('alarm_sound', setAlarmSound.options[setAlarmSound.selectedIndex].id); omniListen(setAlarmSound.options[setAlarmSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['alarm_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setTickingSound" style="width:15%;" onchange="setdata('ticking_sound', setTickingSound.options[setTickingSound.selectedIndex].id); omniListen(setTickingSound.options[setTickingSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['ticking_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setBackgroundSound" style="width:15%;" onchange="setdata('background_sound', setBackgroundSound.options[setBackgroundSound.selectedIndex].id); omniListen(setBackgroundSound.options[setBackgroundSound.selectedIndex].id, true);"><?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['background_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setFocusSound" style="width:15%;" onchange="setdata('focus_sound', setFocusSound.options[setFocusSound.selectedIndex].id); omniListen(setFocusSound.options[setFocusSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['focus_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setTypeSound" style="width:15%;" onchange="setdata('type_sound', setTypeSound.options[setTypeSound.selectedIndex].id); omniListen(setTypeSound.options[setTypeSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['type_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select><br>
<select id="setErrorSound" style="width:15%;" onchange="setdata('error_sound', setErrorSound.options[setErrorSound.selectedIndex].id); omniListen(setErrorSound.options[setErrorSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['error_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setNotifySound" style="width:15%;" onchange="setdata('notify_sound', setNotifySound.options[setNotifySound.selectedIndex].id); omniListen(setNotifySound.options[setNotifySound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['notify_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setBindSound" style="width:15%;" onchange="setdata('bind_sound', setBindSound.options[setBindSound.selectedIndex].id); omniListen(setBindSound.options[setBindSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['bind_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setHitSound" style="width:15%;" onchange="setdata('hit_sound', setHitSound.options[setHitSound.selectedIndex].id); omniListen(setHitSound.options[setHitSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['hit_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setSufferSound" style="width:15%;" onchange="setdata('suffer_sound', setSufferSound.options[setSufferSound.selectedIndex].id); omniListen(setSufferSound.options[setSufferSound.selectedIndex].id, true);">
<?php foreach ($lockSounds as $key=>$value) { ?>
<option id="<?=$value.$suffix;?>" <?php if (withReq($session['suffer_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<br><label><?=term('User Interface:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setSizeSequence" style="width:80%;" value="<?=$session['radius'].' '.$session['box_shadow'].' '.$session['gradient_deg'].' '.$session['back_size'].' '.$session['fore_size'].' '.$session['input_size'].' '.$session['head1_size'].' '.$session['head2_size'].' '.$session['head3_size'].' '.$session['disp_size'].' '.$session['priv1_size'].' '.$session['priv2_size'].' '.$session['priv3_size'];?>" onkeydown="if (event.keyCode == 13) {
    applyTheme(setSizeSequence.value, setColorSequence.value);
} else if (event.keyCode == 27) {
    setSizeSequence.value = '7 0 180 14 14 14 17 16 15 18 14 14 14'; applyTheme(setSizeSequence.value, setColorSequence.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);"><br>
<label><?=term('Color Scheme:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setColorSequence" style="width:80%;" value="<?=$session['back_color'].'|'.$session['fore_color'].'|'.$session['input_color'].'|'.$session['back_text_color'].'|'.$session['fore_text_color'].'|'.$session['input_text_color'].'|'.$session['blank_color'].'|'.$session['blank_text_color'].'|'.$session['arc_fore_color'].'|'.$session['arc_input_color'];?>" onkeydown="
if (event.keyCode == 13) {
    applyTheme(setSizeSequence.value, setColorSequence.value);
} else if (event.keyCode == 27) {
    setColorSequence.value = 'C0BFC0|605F60|E5E5E5|FFFFFF|FFFFFF|000000|FFFFFF|000000|403F40|D5D5D5'; applyTheme(setSizeSequence.value, setColorSequence.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);"><br>
<label><?=term('Update Password:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" placeholder="<?=term('Change your current username...', $settings['vocabulary'], $session['units']);?>" id="setUsername" style="width:40%;" value="<?=$sessionID;?>" onkeydown="if (event.keyCode == 13) {
    setPassword.focus();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="password" placeholder="<?=term('Set a password for your account...', $settings['vocabulary'], $session['units']);?>" id="setPassword" style="width:40%;" value="" onkeydown="if (event.keyCode == 13) {
    rename_user(setUsername.value, setPassword.value);
    omniAuthRequest('signin', setUsername.value, setPassword.value);
} else if (event.keyCode == 27) {
    setPassword.value = '';
    setUsername.focus();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
</p>