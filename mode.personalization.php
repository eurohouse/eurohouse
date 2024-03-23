<!-- database -->
<!-- RU: Персонализация; CN: 个性化和元数据; KR: 个性化和元数据; JP: 个性化和元数据; AE: إضفاء الطابع الشخصي -->
<p align='center'>
<img style="height:11%;position:relative;" id="chooseReticle1" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_1'].'.png'.$suffix;?>" onclick="setdata('reticle', chooseReticle1.src.split('.')[1]);">
<img style="height:11%;position:relative;" id="chooseReticle2" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_2'].'.png'.$suffix;?>" onclick="setdata('reticle', chooseReticle2.src.split('.')[1]);">
<img style="height:11%;position:relative;" id="chooseReticle3" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_3'].'.png'.$suffix;?>" onclick="setdata('reticle', chooseReticle3.src.split('.')[1]);">
<img style="height:11%;position:relative;" id="chooseReticle4" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_4'].'.png'.$suffix;?>" onclick="setdata('reticle', chooseReticle4.src.split('.')[1]);">
<img style="height:11%;position:relative;" id="chooseReticle5" onmouseover="soundButton();" src="<?=$reticlePrefix.$session['reticle_choice_5'].'.png'.$suffix;?>" onclick="setdata('reticle', chooseReticle5.src.split('.')[1]);"><br>
<input type="button" onmouseover="soundButton();" onclick="setdata('date_format', setDateFormat.value); setdata('time_format', setTimeFormat.value); setdata('position', setImagePosition.value); setdata('title', encodeURIComponent(setTitle.value)); setdata('description', encodeURIComponent(setDescription.value));" value="<?=term('Apply', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setdata('units_list', setLanguages.value); setdata('menu', setMenuItems.value); window.location.reload();" value="<?=term('Update', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setDateFormat.value = 'Y-m-d'; setdata('date_format', setDateFormat.value); setTimeFormat.value = 'H:i:s'; setdata('time_format', setTimeFormat.value); setImagePosition.value = '50% 25%'; setdata('position', setImagePosition.value);" value="<?=term('Reset', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="setLanguages.value = 'EU,US,RU,CN'; setdata('units_list', setLanguages.value); setMenuItems.value = 'file_finder,browse_europedia,preferences,personalization,news_feed,user_accounts'; setdata('menu', setMenuItems.value); window.location.reload();" value="<?=term('Clear', $settings['vocabulary'], $session['units']);?>"><br>
<label><?=term('Name/Position:', $settings['vocabulary'], $session['units']);?></label><br>
<input type="text" id="setTitle" style="width:46%;" value="<?=$session['title'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('title', encodeURIComponent(this.value));
} else if (event.keyCode == 27) {
    this.value = 'Eurohouse'; setdata('title', this.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="text" id="setImagePosition" style="width:30%;" value="<?=$session['position'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('position', this.value);
} else if (event.keyCode == 27) {
    this.value = '50% 25%'; setdata('position', this.value);
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="soundButton(true);">
<br><label><?=term('Description:', $settings['vocabulary'], $session['units']);?></label><br>
<textarea id="setDescription" style="width:78%;height:25%;" placeholder="<?=term('What\'s on your mind...', $settings['vocabulary'], $session['units']);?>" onkeydown="if (event.keyCode == 27) {
    setDescription.value = ''; setdata('description', '');
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<?=$session['description'];?></textarea><br>
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
    this.value = 'EU,US,RU,CN';
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
    this.value = 'file_finder,browse_europedia,preferences,personalization,news_feed,user_accounts';
    setdata('menu', this.value);
    window.location.reload();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<select id="setGender" style="width:30%;position:relative;" onchange="setdata('gender', setGender.options[setGender.selectedIndex].id); window.location.reload();">
<?php foreach ($settings['genders'] as $key=>$value) { ?>
<option id="<?=$key;?>" <?php if ($session['gender'] == $key) { ?> selected <?php } ?>>
<?=(isset($value[$session['units']])) ? $value[$session['units']] : $value['default'];?></option><?php } ?></select><br>
<label><?=term('Your Reticles:', $settings['vocabulary'], $session['units']);?></label><br>
<select id="setReticle1" style="width:15%;position:relative;" onchange="setdata('reticle_choice_1', setReticle1.options[setReticle1.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_1'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle2" style="width:15%;position:relative;" onchange="setdata('reticle_choice_2', setReticle2.options[setReticle2.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_2'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle3" style="width:15%;position:relative;" onchange="setdata('reticle_choice_3', setReticle3.options[setReticle3.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_3'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle4" style="width:15%;position:relative;" onchange="setdata('reticle_choice_4', setReticle4.options[setReticle4.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_4'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
<select id="setReticle5" style="width:15%;position:relative;" onchange="setdata('reticle_choice_5', setReticle5.options[setReticle5.selectedIndex].id);">
<?php foreach ($amour as $key=>$value) { ?>
<option id="<?=explode('.', $value)[1];?>" <?php if ($session['reticle_choice_5'] == explode('.', $value)[1]) { ?> selected <?php } ?>>
<?=explode('.', $value)[1];?></option><?php } ?></select>
</p>