<!-- settings -->
<!-- GR: Ρυθμίσεις; CY: Ρυθμίσεις; FR: Paramètres; BE: Paramètres; IT: Impostazioni; PT: Configurações; BR: Configurações; IN: सेटिंग्स; LK: सेटिंग्स्; RS: Подешавања; ES: Ajustes; MX: Ajustes; DE: Einstellungen; AT: Einstellungen; CH: Optiones; RO: Setări; MD: Setări; UA: Налаштування; NP: སྒྲིག་སྟངས།; TR: Ayarlar; RU: Настройки; CN: 设置; KR: 설정; JP: 設定 -->
<div class='customPanel' style="width:100%;height:60px;left:0px;top:0px;">
    <p align='center'>
        <input type='button' onmouseover="soundButton();" value="<?=term('Apply Settings',$settings,$session)?>" onclick="setdata('date_format',setDateFormat.value); setdata('time_format',setTimeFormat.value); setdata('units_list',setLanguages.value); setdata('menu',setMenuItems.value); setdata('title',encodeURIComponent(setTitle.value)); setdata('codename',encodeURIComponent(setCodenameTitle.value)); setdata('project',encodeURIComponent(setProjectTitle.value)); setdata('titles', encodeURIComponent(setLocalizedTitles.value)); setdata('codenames', encodeURIComponent(setLocalizedCodenameTitles.value)); setdata('projects', encodeURIComponent(setLocalizedProjectTitles.value));">
        <input type='button' onmouseover="soundButton();" value="<?=term('Reload Page',$settings,$session)?>" onclick="window.location.reload();">
    </p>
</div>
<div class='customPanel' style="width:100%;height:60%;left:0px;top:0px;overflow-y:scroll;">
    <p align='center'>
        <label><?=term('Titles:',$settings,$session);?></label><br>
        <span class='block'>
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
        }" oninput="handleInput(this.value,true);">
        </span><br>
        <label>
            <?=term('Localized Titles:',$settings,$session);?>
        </label><br>
        <span class='block'>
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
        }" oninput="handleInput(this.value,true);">
        </span><br>
        <label>
        <a href="https://www.iso.org/obp/ui/#iso:pub:PUB500001:en">
        <?=l10nEnt('standards','iso3166',$settings,$session);?></a>
        </label><br>
        <input type="text" id="setLanguages" style="width:76%;" value="<?=$session['units_list'];?>" placeholder="<?=term('Localizations',$settings,$session);?>" onkeydown="
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
        <input type="text" id="setMenuItems" style="width:76%;" value="<?=$session['menu'];?>" placeholder="<?=term('Menu Items',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('menu',this.value);
        } else if (event.keyCode==27) {
            this.value='file_manager,preferences';
            setdata('menu',this.value);
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <label><?=term('Signature Elements:',$settings,$session);?></label><br>
        <select id="setProfileType" style="width:76%;" onchange="setdata('type',setProfileType.options[setProfileType.selectedIndex].id); window.location.reload();">
        <?php foreach ($settings['locale']['profile']['types'] as $key=>$value) { ?>
            <option id="<?=$key;?>" <?php if ($session['type']==$key) { ?> selected <?php } ?>>
                <?=(isset($value[$session['units']]))?$value[$session['units']]:$value['default'];?>
            </option>
        <?php } ?></select><br>
        <?php if (isAuthorized()) { ?>
        <label>
            <?=term('Update Password:',$settings,$session);?>
        </label><br>
        <span class='block'>
        <input type="text" placeholder="<?=term('Username',$settings,$session);?>" id="setUsername" style="width:32%;" value="<?=$sessionID;?>" onkeydown="if (event.keyCode==13) {
            setPassword.value=''; setPassword.focus();
        } else if (event.keyCode==27) { setUsername.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="password" placeholder="<?=term('Password',$settings,$session);?>" id="setPassword" style="width:32%;" value="" onkeydown="if (event.keyCode==13) {
            rename_user(sysDefSessionID.value,setUsername.value,setPassword.value); omniAuthRequest('signin',setUsername.value,CryptoJS.SHA256(setPassword.value).toString());
        } else if (event.keyCode==27) {
            setPassword.value=''; setUsername.focus();
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type='image' onmouseover="soundButton();" class="power" onclick="rename_user(sysDefSessionID.value,setUsername.value,setPassword.value); omniAuthRequest('signin',setUsername.value, CryptoJS.SHA256(setPassword.value).toString());" src="<?=$prefix[3].'return.png';?>" title="<?=term('Update Password',$settings,$session);?>">
        <input type='image' onmouseover="soundButton();" class="power" onclick="setPassword.value=''; setUsername.value=''; setUsername.focus();" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear Sign In Form',$settings,$session);?>"></span>
        <?php } ?>
    </p>
</div>