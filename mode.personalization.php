<!-- speed -->
<!-- GR: Εξατομίκευση; CY: Εξατομίκευση; IT: Personalizzazione; FR: Personnalisation; BE: Personnalisation; LK: व्यक्तिगतकरणम्; IN: वैयक्तिकरण; CH: Occasus Personalis; TR: Kişiselleştirme; RO: Personalizare; MD: Personalizare; RS: Персонализација; NP: མི་སྒེར་ཅན་བཟོ་བ།; BR: Personalização; PT: Personalização; UA: Персоналізація; ES: Personalización; MX: Personalización; DE: Personalisierung; AT: Personalisierung; RU: Персонализация; CN: 个性化和元数据; KR: 개인화하다; JP: カスタマイズする; AE: إضفاء الطابع الشخصي -->
<p align='center'>
<img style="height:11%;" id="chooseReticle1" name="<?=$session['reticle_choice_1'];?>" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_1'].'.png';?>" onclick="setdata('reticle', chooseReticle1.name);">
<img style="height:11%;" id="chooseReticle2" name="<?=$session['reticle_choice_2'];?>" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_2'].'.png';?>" onclick="setdata('reticle', chooseReticle2.name);">
<img style="height:11%;" id="chooseReticle3" name="<?=$session['reticle_choice_3'];?>" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_3'].'.png';?>" onclick="setdata('reticle', chooseReticle3.name);">
<img style="height:11%;" id="chooseReticle4" name="<?=$session['reticle_choice_4'];?>" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_4'].'.png';?>" onclick="setdata('reticle', chooseReticle4.name);">
<img style="height:11%;" id="chooseReticle5" name="<?=$session['reticle_choice_5'];?>" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_5'].'.png';?>" onclick="setdata('reticle', chooseReticle5.name);"><br>
<input type="button" onmouseover="soundButton();" onclick="setdata('date_format', setDateFormat.value); setdata('time_format', setTimeFormat.value); setdata('title', encodeURIComponent(setTitle.value)); setdata('project', encodeURIComponent(setProjectTitle.value));" value="<?=term('Apply', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setdata('units_list', setLanguages.value); setdata('menu', setMenuItems.value); setdata('titles', encodeURIComponent(setLocalizedTitles.value)); setdata('projects', encodeURIComponent(setLocalizedProjectTitles.value)); window.location.reload();" value="<?=term('Update', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setDateFormat.value = 'Y-m-d'; setdata('date_format', setDateFormat.value); setTimeFormat.value = 'H:i:s'; setdata('time_format', setTimeFormat.value);" value="<?=term('Reset', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setLanguages.value = 'EU,US'; setdata('units_list', setLanguages.value); window.location.reload();" value="<?=term('Clear', $settings['vocabulary'], $session['units']);?>"><br>
<label><?=term('Titles:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setTitle" style="width:40%;" value="<?=$session['title'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('title', encodeURIComponent(this.value));
} else if (event.keyCode == 27) {
    this.value = ''; setdata('title', this.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="text" id="setProjectTitle" style="width:40%;" value="<?=$session['project'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('project', encodeURIComponent(this.value));
} else if (event.keyCode == 27) {
    this.value = ''; setdata('project', this.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);"><br>
<label><?=term('Localized Titles:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setLocalizedTitles" style="width:40%;" value="<?=$session['titles'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('titles', setLocalizedTitles.value); window.location.reload();
} else if (event.keyCode == 27) {
    this.value = ''; setdata('titles', this.value); window.location.reload();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="text" id="setLocalizedProjectTitles" style="width:40%;" value="<?=$session['projects'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('projects', this.value); window.location.reload();
} else if (event.keyCode == 27) {
    this.value = ''; setdata('projects', this.value); window.location.reload();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);"><br>
<label><a href="https://www.php.net/manual/en/datetime.format.php">ISO 8601</a> <?=term('&', $settings['vocabulary'], $session['units']);?> <a href="https://www.iso.org/obp/ui/#iso:pub:PUB500001:en">ISO 3166</a></label><br>
<input type="text" id="setDateFormat" style="width:25%;" value="<?=$session['date_format'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('date_format', setDateFormat.value);
} else if (event.keyCode == 27) {
    this.value = 'Y-m-d'; setdata('date_format', 'Y-m-d');
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="text" id="setTimeFormat" style="width:25%;" value="<?=$session['time_format'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('time_format', setTimeFormat.value);
} else if (event.keyCode == 27) {
    this.value = 'H:i:s'; setdata('time_format', 'H:i:s');
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="text" id="setLanguages" style="width:25%;" value="<?=$session['units_list'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('units_list', setLanguages.value); window.location.reload();
} else if (event.keyCode == 27) {
    this.value = 'EU,US';
    setdata('units_list', this.value);
    window.location.reload();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);"><br>
<label><?=term('Menu Items List:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setMenuItems" style="width:46%;" value="<?=$session['menu'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('menu', setMenuItems.value); window.location.reload();
} else if (event.keyCode == 27) {
    this.value = 'file_finder,preferences';
    setdata('menu', this.value);
    window.location.reload();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<select id="setUserType" style="width:30%;" onchange="setdata('user_type', setUserType.options[setUserType.selectedIndex].id); window.location.reload();">
<?php foreach ($settings['user_types'] as $key=>$value) { ?>
<option id="<?=$key;?>" <?php if ($session['user_type'] == $key) { ?> selected <?php } ?>>
<?=(isset($value[$session['units']])) ? $value[$session['units']] : $value['default'];?></option><?php } ?></select><br>
<label><?=term('Your Reticles:', $settings['vocabulary'], $session['units']);?></label><br>
<select id="setReticle1" style="width:15%;" onchange="setdata('reticle_choice_1', setReticle1.options[setReticle1.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_1'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle2" style="width:15%;" onchange="setdata('reticle_choice_2', setReticle2.options[setReticle2.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_2'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle3" style="width:15%;" onchange="setdata('reticle_choice_3', setReticle3.options[setReticle3.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_3'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle4" style="width:15%;" onchange="setdata('reticle_choice_4', setReticle4.options[setReticle4.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_4'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle5" style="width:15%;" onchange="setdata('reticle_choice_5', setReticle5.options[setReticle5.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_5'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
</p>