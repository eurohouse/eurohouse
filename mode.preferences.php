<!-- settings -->
<!-- GR: Πίνακας Ελέγχου; CY: Πίνακας Ελέγχου; FR: Panneau de contrôle; BE: Panneau de contrôle; IT: Pannello di controllo; PT: Painel de controlo; BR: Painel de controle; IN: कंट्रोल पैनल; LK: नियन्त्रण पटल; RS: Контролна табла; ES: Panel de control; MX: Panel de control; DE: Schalttafel; AT: Schalttafel; CH: Occasus Generalis; RO: Panou de control; MD: Panou de control; UA: Панель управління; NP: ཚོད་འཛིན་སྒྲོམ་གཞི།; TR: Kontrol Paneli; RU: Панель управления; CN: 应用程序偏好设置; KR: 프로그램 설정; JP: 番組設定; AE: تفضيلات التطبيق -->
<p align='center'>
<input type='image' id='prefsBtnApply' onmouseover="soundButton();" class="power" onclick="setdata('box_shadow', setBoxShadow.value); setdata('text_box_shadow', setTextBoxShadow.value); setdata('radius', setBorderRadius.value); setdata('gradient', setGradDeg.value); setdata('magnitude', setMagnitude.value); setdata('specimen', encodeURIComponent(setSpecimen.value));" src="<?=$prefix.'return.png';?>">
<input type='image' id='prefsBtnApplySizes' onmouseover="soundButton();" class="power" onclick="setdata('back_size', setBackSize.value); setdata('fore_size', setForeSize.value); setdata('input_size', setInputSize.value); setdata('head1_size', setHead1Size.value); setdata('head2_size', setHead2Size.value); setdata('head3_size', setHead3Size.value); setdata('disp_size', setDispSize.value);" src="<?=$prefix.'ruler.png';?>">
<input type='image' id='prefsBtnApplyColors' onmouseover="soundButton();" class="power" onclick="setdata('back_color', setBackColor.value); setdata('fore_color', setForeColor.value); setdata('input_color', setInputColor.value); setdata('back_text_color', setBackTextColor.value); setdata('fore_text_color', setForeTextColor.value); setdata('input_text_color', setInputTextColor.value); setdata('blank_color', setBlankColor.value); setdata('blank_text_color', setBlankTextColor.value); setdata('arc_fore_color', setArcForeColor.value); setdata('arc_input_color', setArcInputColor.value);" src="<?=$prefix.'paint.png';?>">
<input type='image' id='prefsBtnUpdate' onmouseover="soundButton();" class="power" onclick="rename_user(setUsername.value, setPassword.value); omniAuthRequest('signin', setUsername.value, CryptoJS.SHA256(setPassword.value).toString());" src="<?=$prefix.'lock.png';?>">
<input type='image' id='prefsBtnReload' onmouseover="soundButton();" class="power" onclick="window.location.reload();" src="<?=$prefix.'update.png';?>">
<input type='image' id='prefsBtnReset' onmouseover="soundButton();" class="power" onclick="setSpecimen.value = 'Q F S H Æ Ø Ð Ñ ʒ ʊ ʎ ɸ Σ Φ Ω Θ Г З Х Б خالد 인 방 학 적 中 网 あ オ რ Ֆ ט भो 🍷 ☕️ 🍾 🍫'; setdata('specimen', setSpecimen.value);" src="<?=$prefix.'backspace.png';?>">
<input type='image' id='prefsBtnClear' onmouseover="soundButton();" class="power" onclick="setdata('font_ascii', 'flexo.ttf'); setdata('font_latin', 'flexo.ttf'); setdata('font_phone', 'arialuni.ttf'); setdata('font_greek', 'ubuntu.ttf'); setdata('font_cyril', 'ubuntu.ttf'); setdata('font_arabi', 'arialuni.ttf'); setdata('font_korea', 'arialuni.ttf'); setdata('font_china', 'arialuni.ttf'); setdata('font_other', 'arialuni.ttf'); setdata('font_emoji', 'twemoji.ttf');" src="<?=$prefix.'error.png';?>"><br>
<label><?=term('Specimen Text:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setSpecimen" style="width:86%;" value="<?=$session['specimen'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('specimen', encodeURIComponent(this.value));
} else if (event.keyCode == 27) {
    this.value = 'Q F S H Æ Ø Ð Ñ ʒ ʊ ʎ ɸ Σ Φ Ω Θ Г З Х Б خالد 인 방 학 적 中 网 あ オ რ Ֆ ט भो 🍷 ☕️ 🍾 🍫';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);"><br>
<label><?=term('Font Configuration:', $settings['vocabulary'], $session['units']);?></label><br>
<select id="setUTF0" style="width:15%;" onchange="setdata('font_ascii', setUTF0.options[setUTF0.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_ascii']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF1" style="width:15%;" onchange="setdata('font_latin', setUTF1.options[setUTF1.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_latin']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF2" style="width:15%;" onchange="setdata('font_phone', setUTF2.options[setUTF2.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_phone']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF3" style="width:15%;" onchange="setdata('font_greek', setUTF3.options[setUTF3.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_greek']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF4" style="width:15%;" onchange="setdata('font_cyril', setUTF4.options[setUTF4.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_cyril']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select><br>
<select id="setUTF5" style="width:15%;" onchange="setdata('font_arabi', setUTF5.options[setUTF5.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_arabi']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF6" style="width:15%;" onchange="setdata('font_korea', setUTF6.options[setUTF6.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_korea']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF7" style="width:15%;" onchange="setdata('font_china', setUTF7.options[setUTF7.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_china']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF8" style="width:15%;" onchange="setdata('font_other', setUTF8.options[setUTF8.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_other']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select>
<select id="setUTF9" style="width:15%;" onchange="setdata('font_emoji', setUTF9.options[setUTF9.selectedIndex].id);">
<?php foreach ($userLocks['font'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['font_emoji']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option>
<?php } ?></select><br>
<label><?=term('Sound Effects:', $settings['vocabulary'], $session['units']);?></label><br>
<select id="setAlarmSound" style="width:15%;" onchange="setdata('alarm_sound', setAlarmSound.options[setAlarmSound.selectedIndex].id); omniListen(setAlarmSound.options[setAlarmSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['alarm_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setTickingSound" style="width:15%;" onchange="setdata('ticking_sound', setTickingSound.options[setTickingSound.selectedIndex].id); omniListen(setTickingSound.options[setTickingSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['ticking_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setBackgroundSound" style="width:15%;" onchange="setdata('background_sound', setBackgroundSound.options[setBackgroundSound.selectedIndex].id); omniListen(setBackgroundSound.options[setBackgroundSound.selectedIndex].id, true);"><?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['background_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setFocusSound" style="width:15%;" onchange="setdata('focus_sound', setFocusSound.options[setFocusSound.selectedIndex].id); omniListen(setFocusSound.options[setFocusSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['focus_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setTypeSound" style="width:15%;" onchange="setdata('type_sound', setTypeSound.options[setTypeSound.selectedIndex].id); omniListen(setTypeSound.options[setTypeSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['type_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select><br>
<select id="setErrorSound" style="width:15%;" onchange="setdata('error_sound', setErrorSound.options[setErrorSound.selectedIndex].id); omniListen(setErrorSound.options[setErrorSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['error_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setNotifySound" style="width:15%;" onchange="setdata('notify_sound', setNotifySound.options[setNotifySound.selectedIndex].id); omniListen(setNotifySound.options[setNotifySound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['notify_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setBindSound" style="width:15%;" onchange="setdata('bind_sound', setBindSound.options[setBindSound.selectedIndex].id); omniListen(setBindSound.options[setBindSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['bind_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setHitSound" style="width:15%;" onchange="setdata('hit_sound', setHitSound.options[setHitSound.selectedIndex].id); omniListen(setHitSound.options[setHitSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['hit_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select>
<select id="setSufferSound" style="width:15%;" onchange="setdata('suffer_sound', setSufferSound.options[setSufferSound.selectedIndex].id); omniListen(setSufferSound.options[setSufferSound.selectedIndex].id, true);">
<?php foreach ($userLocks['sound'] as $key=>$value) { ?>
<option id="<?=$value;?>" <?php if (withReq($session['suffer_sound']) == $value) { ?> selected <?php } ?>>
<?=$value;?></option><?php } ?></select><br>
<label><?=term('User Interface:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setBoxShadow" style="width:27%;" value="<?=$session['box_shadow'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('box_shadow', this.value);
} else if (event.keyCode == 27) {
    this.value = 'inset 0px 0px #FFFFFF, inset 0px 0px #FFFFFF';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setTextBoxShadow" style="width:27%;" value="<?=$session['text_box_shadow'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('text_box_shadow', this.value);
} else if (event.keyCode == 27) {
    this.value = 'inset 0px 0px #FFFFFF, inset 0px 0px #FFFFFF';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setTextShadow" style="width:27%;" value="<?=$session['text_shadow'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('text_shadow', this.value);
} else if (event.keyCode == 27) {
    this.value = '#000000 3px 3px 3px, #000000 -3px -3px 3px, #000000 3px -3px 3px, #000000 -3px 3px 3px';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);"><br>
<input type="text" id="setBorderRadius" style="width:15%;" value="<?=$session['radius'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('radius', this.value);
} else if (event.keyCode == 27) { this.value = '7';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setBackSize" style="width:15%;" value="<?=$session['back_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('back_size', this.value);
} else if (event.keyCode == 27) { this.value = '14';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setForeSize" style="width:15%;" value="<?=$session['fore_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('fore_size', this.value);
} else if (event.keyCode == 27) { this.value = '14';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setInputSize" style="width:15%;" value="<?=$session['input_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('input_size', this.value);
} else if (event.keyCode == 27) { this.value = '14';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="number" min='0' max='9' step='1' id="setMagnitude" style="width:14%;" value="<?=$session['magnitude'];?>" oninput="setdata('magnitude', setMagnitude.value); handleInput(this.value, true);" onkeydown="if (event.keyCode == 27) { this.value = 5;
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }"><br>
<input type="text" id="setGradDeg" style="width:15%;" value="<?=$session['gradient'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('gradient', this.value);
} else if (event.keyCode == 27) { this.value = '180';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="text" id="setHead1Size" style="width:15%;" value="<?=$session['head1_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('head1_size', this.value);
} else if (event.keyCode == 27) { this.value = '17';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setHead2Size" style="width:15%;" value="<?=$session['head2_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('head2_size', this.value);
} else if (event.keyCode == 27) { this.value = '16';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setHead3Size" style="width:15%;" value="<?=$session['head3_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('head3_size', this.value);
} else if (event.keyCode == 27) { this.value = '15';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setDispSize" style="width:15%;" value="<?=$session['disp_size'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('disp_size', this.value);
} else if (event.keyCode == 27) { this.value = '18';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);"><br>
<input type="text" id="setBackColor" style="width:15%;" value="<?=$session['back_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('back_color', this.value);
} else if (event.keyCode == 27) { this.value = 'C0BFC0';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setForeColor" style="width:15%;" value="<?=$session['fore_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('fore_color', this.value);
} else if (event.keyCode == 27) { this.value = '605F60';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setInputColor" style="width:15%;" value="<?=$session['input_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('input_color', this.value);
} else if (event.keyCode == 27) { this.value = 'E5E5E5';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setArcForeColor" style="width:15%;" value="<?=$session['arc_fore_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('arc_fore_color', this.value);
} else if (event.keyCode == 27) { this.value = '403F40';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setArcInputColor" style="width:15%;" value="<?=$session['arc_input_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('arc_input_color', this.value);
} else if (event.keyCode == 27) { this.value = 'D5D5D5';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);"><br>
<input type="text" id="setBackTextColor" style="width:15%;" value="<?=$session['back_text_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('back_text_color', this.value);
} else if (event.keyCode == 27) { this.value = 'FFFFFF';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setForeTextColor" style="width:15%;" value="<?=$session['fore_text_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('fore_text_color', this.value);
} else if (event.keyCode == 27) { this.value = 'FFFFFF';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setInputTextColor" style="width:15%;" value="<?=$session['input_text_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('input_text_color', this.value);
} else if (event.keyCode == 27) { this.value = '000000';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setBlankColor" style="width:15%;" value="<?=$session['blank_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('blank_color', this.value);
} else if (event.keyCode == 27) { this.value = 'FFFFFF';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="text" id="setBlankTextColor" style="width:15%;" value="<?=$session['blank_text_color'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('blank_text_color', this.value);
} else if (event.keyCode == 27) { this.value = '000000';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);"><br>
<label><?=term('Update Password:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" placeholder="<?=term('Change your current username...', $settings['vocabulary'], $session['units']);?>" id="setUsername" style="width:42%;" value="<?=$sessionID;?>" onkeydown="if (event.keyCode == 13) { setPassword.focus(); } else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);">
<input type="password" placeholder="<?=term('Set a password for your account...', $settings['vocabulary'], $session['units']);?>" id="setPassword" style="width:42%;" value="" onkeydown="if (event.keyCode == 13) {
    rename_user(setUsername.value, setPassword.value);
    omniAuthRequest('signin', setUsername.value, CryptoJS.SHA256(setPassword.value).toString());
} else if (event.keyCode == 27) {
    setPassword.value = ''; setUsername.focus();
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value); }" oninput="handleInput(this.value, true);"></p>