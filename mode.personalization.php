<!-- speed -->
<!-- GR: Εξατομίκευση; CY: Εξατομίκευση; IT: Personalizzazione; FR: Personnalisation; BE: Personnalisation; LK: व्यक्तिगतकरणम्; IN: वैयक्तिकरण; CH: Occasus Personalis; TR: Kişiselleştirme; RO: Personalizare; MD: Personalizare; RS: Персонализација; NP: མི་སྒེར་ཅན་བཟོ་བ།; BR: Personalização; PT: Personalização; UA: Персоналізація; ES: Personalización; MX: Personalización; DE: Personalisierung; AT: Personalisierung; RU: Персонализация; CN: 个性化和元数据; KR: 개인화하다; JP: カスタマイズする; AE: إضفاء الطابع الشخصي -->
<?php $listReticles=str_replace('./','',(glob('./'.$prefix[4].'*.png'))); ?>
<div class='customPanel' id='pers_rtc' style="width:100%;height:40px;left:0px;top:0px;">
    <p align='center'>
        <img style="height:100%;" id="chooseReticle1" name="<?=$session['reticle_choice_1'];?>" onmouseover="soundButton();" src="<?=$prefix[4].$session['reticle_choice_1'].'.png';?>" onclick="setdata('reticle',chooseReticle1.name);">
        <img style="height:100%;" id="chooseReticle2" name="<?=$session['reticle_choice_2'];?>" onmouseover="soundButton();" src="<?=$prefix[4].$session['reticle_choice_2'].'.png';?>" onclick="setdata('reticle',chooseReticle2.name);">
        <img style="height:100%;" id="chooseReticle3" name="<?=$session['reticle_choice_3'];?>" onmouseover="soundButton();" src="<?=$prefix[4].$session['reticle_choice_3'].'.png';?>" onclick="setdata('reticle',chooseReticle3.name);">
        <img style="height:100%;" id="chooseReticle4" name="<?=$session['reticle_choice_4'];?>" onmouseover="soundButton();" src="<?=$prefix[4].$session['reticle_choice_4'].'.png';?>" onclick="setdata('reticle',chooseReticle4.name);">
        <img style="height:100%;" id="chooseReticle5" name="<?=$session['reticle_choice_5'];?>" onmouseover="soundButton();" src="<?=$prefix[4].$session['reticle_choice_5'].'.png';?>" onclick="setdata('reticle',chooseReticle5.name);">
    </p>
</div>
<div class='customPanel' id='pers_btns' style="width:100%;height:40px;left:0px;top:0px;">
    <p align='center'>
        <input type='image' id='prefsBtnApply' onmouseover="soundButton();" class="power" onclick="setdata('date_format',setDateFormat.value); setdata('time_format',setTimeFormat.value); setdata('active_hours',setActiveHours.value); setdata('currency',setCurrency.value);" src="<?=$prefix[3].'return.png';?>" title="<?=term('Apply Settings',$settings,$session);?>">
        <input type='image' id='prefsBtnUpdate' onmouseover="soundButton();" class="power" onclick="setdata('units_list',setLanguages.value); setdata('menu',setMenuItems.value);" src="<?=$prefix[3].'lock.png';?>" title="<?=term('Update Settings',$settings,$session);?>">
        <input type='image' id='prefsBtnUpdateTitle' onmouseover="soundButton();" class="power" onclick="setdata('title',encodeURIComponent(setTitle.value)); setdata('codename',encodeURIComponent(setCodenameTitle.value)); setdata('project',encodeURIComponent(setProjectTitle.value));" src="<?=$prefix[3].'keyboard.png';?>" title="<?=term('Update Titles',$settings,$session);?>">
        <input type='image' id='prefsBtnUpdateTitles' onmouseover="soundButton();" class="power" onclick="setdata('titles', encodeURIComponent(setLocalizedTitles.value)); setdata('codenames', encodeURIComponent(setLocalizedCodenameTitles.value)); setdata('projects', encodeURIComponent(setLocalizedProjectTitles.value));" src="<?=$prefix[3].'movie.png';?>" title="<?=term('Update Localized Titles',$settings,$session);?>">
        <input type='image' id='prefsBtnReload' onmouseover="soundButton();" class="power" onclick="window.location.reload();" src="<?=$prefix[3].'update.png';?>" title="<?=term('Reload Page',$settings,$session);?>">
        <input type='image' id='prefsBtnReset' onmouseover="soundButton();" class="power" onclick="setDateFormat.value='Y-m-d'; setdata('date_format',setDateFormat.value); setTimeFormat.value='H:i:s'; setdata('time_format',setTimeFormat.value);" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Reset Defaults',$settings,$session);?>">
        <input type='image' id='prefsBtnClear' onmouseover="soundButton();" class="power" onclick="setLanguages.value='EU,US'; setdata('units_list',setLanguages.value);" src="<?=$prefix[3].'error.png';?>" title="<?=term('Reset Default Languages',$settings,$session);?>">
    </p>
</div>
<div class='customPanel' id='pers_tab' style="width:100%;height:60%;left:0px;top:0px;overflow-y:scroll;">
    <p align='center'>
        <label><?=term('Titles:',$settings,$session);?></label><br>
        <input type="text" id="setTitle" style="width:25%;" value="<?=$session['title'];?>" placeholder="<?=term('Title',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('title',encodeURIComponent(this.value));
        } else if (event.keyCode==27) {
            this.value=''; setdata('title',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setCodenameTitle" style="width:25%;" value="<?=$session['codename'];?>" placeholder="<?=term('Codename',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('codename',encodeURIComponent(this.value));
        } else if (event.keyCode==27) {
            this.value=''; setdata('codename',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setProjectTitle" style="width:25%;" value="<?=$session['project'];?>" placeholder="<?=term('Project Name',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('project',encodeURIComponent(this.value));
        } else if (event.keyCode==27) {
            this.value=''; setdata('project',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <label><?=term('Localized Titles:',$settings,$session);?></label><br>
        <input type="text" id="setLocalizedTitles" style="width:25%;" value="<?=$session['titles'];?>" placeholder="<?=term('Localized Titles',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('titles',this.value);
        } else if (event.keyCode==27) {
            this.value=''; setdata('titles',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setLocalizedCodenameTitles" style="width:25%;" value="<?=$session['codenames'];?>" placeholder="<?=term('Localized Codenames',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('codenames',this.value);
        } else if (event.keyCode==27) {
            this.value=''; setdata('codenames',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setLocalizedProjectTitles" style="width:25%;" value="<?=$session['projects'];?>" placeholder="<?=term('Localized Project Names',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('projects',this.value);
        } else if (event.keyCode==27) {
            this.value=''; setdata('projects',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <label>
        <a href="https://www.php.net/manual/en/datetime.format.php"><?=l10nEnt('standards','iso8601',$settings,$session);?></a> <?=term('&',$settings,$session);?> <a href="https://www.iso.org/obp/ui/#iso:pub:PUB500001:en"><?=l10nEnt('standards','iso3166',$settings,$session);?></a>
        </label><br>
        <input type="text" id="setDateFormat" style="width:25%;" value="<?=$session['date_format'];?>" placeholder="<?=term('Date Format',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('date_format',setDateFormat.value);
        } else if (event.keyCode==27) {
            this.value='Y-m-d'; setdata('date_format','Y-m-d');
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setTimeFormat" style="width:25%;" value="<?=$session['time_format'];?>" placeholder="<?=term('Time Format',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('time_format',setTimeFormat.value);
        } else if (event.keyCode==27) {
            this.value='H:i:s'; setdata('time_format','H:i:s');
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setLanguages" style="width:25%;" value="<?=$session['units_list'];?>" placeholder="<?=term('Localizations',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('units_list',setLanguages.value);
        } else if (event.keyCode==27) {
            this.value='EU,US'; setdata('units_list',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <label><?=term('Functional Elements:',$settings,$session);?></label><br>
        <input type="text" id="setMenuItems" style="width:25%;" value="<?=$session['menu'];?>" placeholder="<?=term('Menu Items',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('menu',this.value);
        } else if (event.keyCode==27) {
            this.value='file_manager,preferences';
            setdata('menu',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setActiveHours" style="width:25%;" value="<?=$session['active_hours'];?>" placeholder="<?=term('Active Hours',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('active_hours',this.value);
        } else if (event.keyCode==27) {
            this.value=''; setdata('active_hours',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setCurrency" style="width:25%;" value="<?=$session['currency'];?>" placeholder="<?=term('Currency',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('currency',this.value);
        } else if (event.keyCode==27) {
            this.value='^x::^y:'; setdata('currency',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <label><?=term('Signature Elements:',$settings,$session);?></label><br>
        <select id="setProfileType" style="width:38%;" onchange="setdata('type',setProfileType.options[setProfileType.selectedIndex].id);">
        <?php foreach ($settings['locale']['profile']['types'] as $key=>$value) { ?>
            <option id="<?=$key;?>" <?php if ($session['type']==$key) { ?> selected <?php } ?>>
                <?=(isset($value[$session['units']]))?$value[$session['units']]:$value['default'];?>
            </option>
        <?php } ?></select>
        <select id="setProfileCalendar" style="width:38%;" onchange="setdata('calendar',setProfileCalendar.options[setProfileCalendar.selectedIndex].id);">
        <?php foreach ($settings['locale']['profile']['calendars'] as $key=>$value) { ?>
            <option id="<?=$key;?>" <?php if ($session['calendar']==$key) { ?> selected <?php } ?>>
                <?=(isset($value[$session['units']]))?$value[$session['units']]:$value['default'];?>
            </option>
        <?php } ?></select><br>
        <label><?=term('Your Reticles:',$settings,$session);?></label><br>
        <select id="setReticle1" style="width:15%;" onchange="setdata('reticle_choice_1',setReticle1.options[setReticle1.selectedIndex].id);">
        <?php foreach ($listReticles as $key=>$value) { ?>
            <option id="<?=explode('.',$value)[1];?>" <?php if ($session['reticle_choice_1']==explode('.',$value)[1]) { ?> selected <?php } ?>>
                <?=explode('.',$value)[1];?>
            </option>
        <?php } ?></select>
        <select id="setReticle2" style="width:15%;" onchange="setdata('reticle_choice_2',setReticle2.options[setReticle2.selectedIndex].id);">
        <?php foreach ($listReticles as $key=>$value) { ?>
            <option id="<?=explode('.',$value)[1];?>" <?php if ($session['reticle_choice_2']==explode('.',$value)[1]) { ?> selected <?php } ?>>
                <?=explode('.',$value)[1];?>
            </option>
        <?php } ?></select>
        <select id="setReticle3" style="width:15%;" onchange="setdata('reticle_choice_3',setReticle3.options[setReticle3.selectedIndex].id);">
        <?php foreach ($listReticles as $key=>$value) { ?>
            <option id="<?=explode('.',$value)[1];?>" <?php if ($session['reticle_choice_3']==explode('.',$value)[1]) { ?> selected <?php } ?>>
                <?=explode('.',$value)[1];?>
            </option>
        <?php } ?></select>
        <select id="setReticle4" style="width:15%;" onchange="setdata('reticle_choice_4',setReticle4.options[setReticle4.selectedIndex].id);">
        <?php foreach ($listReticles as $key=>$value) { ?>
            <option id="<?=explode('.',$value)[1];?>" <?php if ($session['reticle_choice_4']==explode('.',$value)[1]) { ?> selected <?php } ?>>
                <?=explode('.',$value)[1];?>
            </option>
        <?php } ?></select>
        <select id="setReticle5" style="width:15%;" onchange="setdata('reticle_choice_5',setReticle5.options[setReticle5.selectedIndex].id);">
        <?php foreach ($listReticles as $key=>$value) { ?>
            <option id="<?=explode('.',$value)[1];?>" <?php if ($session['reticle_choice_5']==explode('.',$value)[1]) { ?> selected <?php } ?>>
                <?=explode('.',$value)[1];?>
            </option>
        <?php } ?></select>
    </p>
</div>