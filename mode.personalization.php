<!-- speed -->
<!-- GR: Προσωπικότητα; CY: Προσωπικότητα; IT: Personalizzazione; FR: Personnalisation; BE: Personnalisation; LK: व्यक्तिगतकरणम्; IN: वैयक्तिकरण; CH: Occasus Personalis; TR: Kişiselleştirme; RO: Personalizare; MD: Personalizare; RS: Персонализација; NP: མི་སྒེར་ཅན་བཟོ་བ།; BR: Personalização; PT: Personalização; UA: Персоналізація; ES: Personalización; MX: Personalización; DE: Personalisierung; AT: Personalisierung; RU: Персонализация; CN: 个性化和元数据; KR: 개인화하다; JP: カスタマイズする -->
<div class='customPanel' id='prefs_btns' style="width:100%;height:60px;left:0px;top:0px;">
    <p align='center'>
        <input type='button' onmouseover="soundButton();" value="<?=term('Apply Settings',$settings,$session)?>" onclick="setdata('box_shadow',setBoxShadow.value); setdata('text_box_shadow',setTextBoxShadow.value); setdata('marquee_speed',setMarqueeSpeed.value); setdata('border_radius',setBorderRadius.value); setdata('text_border_radius',setTextBorderRadius.value); setdata('gradient_fore',setGradFore.value); setdata('gradient_input',setGradInput.value); setdata('gradient_button',setGradButton.value); setdata('magnitude',setMagnitude.value); setdata('specimen',encodeURIComponent(setSpecimen.value)); setdata('background',setBackImage.value); setdata('back_size',setBackSize.value); setdata('fore_size',setForeSize.value); setdata('input_size',setInputSize.value); setdata('head1_size',setHead1Size.value); setdata('head2_size',setHead2Size.value); setdata('head3_size',setHead3Size.value); setdata('disp_size',setDispSize.value); setdata('back_color',setBackColor.value); setdata('fore_color',setForeColor.value); setdata('input_color',setInputColor.value); setdata('back_text_color',setBackTextColor.value); setdata('fore_text_color',setForeTextColor.value); setdata('input_text_color',setInputTextColor.value); setdata('blank_color',setBlankColor.value); setdata('blank_text_color',setBlankTextColor.value); setdata('arc_fore_color',setArcForeColor.value); setdata('arc_input_color',setArcInputColor.value);">
        <input type='button' onmouseover="soundButton();" value="<?=term('Reload Page',$settings,$session)?>" onclick="window.location.reload();">
    </p>
</div>
<div class='customPanel' id='prefs_tab' style="width:100%;height:70%;left:0px;top:0px;overflow-y:scroll;">
    <p align='center'>
        <label><?=term('Specimen Text:',$settings,$session);?></label><br>
        <span class='block'>
        <input type="text" id="setSpecimen" style="width:68%;" placeholder="<?=term('Specimen Text',$settings,$session);?>" value="<?=$session['specimen'];?>" onkeydown="if (event.keyCode==13) {
            setdata('specimen',encodeURIComponent(this.value));
        } else if (event.keyCode==27) {
            this.value='Q F S H Æ Ø Ð Ñ ʒ ʊ ʎ ɸ Σ Φ Ω Θ Г З Х Б خالد 인 방 학 적 の あ ぱ オ 中 英 阿 网 რ Ֆ ט भो 🍷 ☕️ 🍾 🍫';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type='image' onmouseover="soundButton();" class="power" onclick="setdata('specimen',encodeURIComponent(setSpecimen.value));" src="<?=$prefix[3].'return.png';?>" title="<?=term('Update',$settings,$session);?>">
        <input type='image' onmouseover="soundButton();" class="power" onclick="setSpecimen.value='Q F S H Æ Ø Ð Ñ ʒ ʊ ʎ ɸ Σ Φ Ω Θ Г З Х Б خالد 인 방 학 적 の あ ぱ オ 中 英 阿 网 რ Ֆ ט भो 🍷 ☕️ 🍾 🍫';" src="<?=$prefix[3].'backspace.png';?>" title="<?=term('Clear',$settings,$session);?>"></span><br>
        <label><?=term('Font Configuration:',$settings,$session);?></label><br>
        <select id="setUTF0" style="width:15%;" onchange="setdata('font_ascii',setUTF0.options[setUTF0.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_ascii']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF1" style="width:15%;" onchange="setdata('font_latin',setUTF1.options[setUTF1.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_latin']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF2" style="width:15%;" onchange="setdata('font_phone',setUTF2.options[setUTF2.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_phone']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF3" style="width:15%;" onchange="setdata('font_greek',setUTF3.options[setUTF3.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_greek']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF4" style="width:15%;" onchange="setdata('font_cyril',setUTF4.options[setUTF4.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_cyril']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select><br>
        <select id="setUTF5" style="width:15%;" onchange="setdata('font_arabi',setUTF5.options[setUTF5.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_arabi']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF6" style="width:15%;" onchange="setdata('font_korea',setUTF6.options[setUTF6.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_korea']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF7" style="width:15%;" onchange="setdata('font_japan',setUTF7.options[setUTF7.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_japan']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF8" style="width:15%;" onchange="setdata('font_other',setUTF8.options[setUTF8.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_other']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setUTF9" style="width:15%;" onchange="setdata('font_emoji',setUTF9.options[setUTF9.selectedIndex].id);">
        <?php foreach ($userSubscr['font'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['font_emoji']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select><br>
        <label><?=term('Sound Effects:',$settings,$session);?></label><br>
        <select id="setAlarmSound" style="width:20%;" onchange="setdata('alarm_sound',setAlarmSound.options[setAlarmSound.selectedIndex].id); omniListen(setAlarmSound.options[setAlarmSound.selectedIndex].id, true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['alarm_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setTickingSound" style="width:20%;" onchange="setdata('ticking_sound',setTickingSound.options[setTickingSound.selectedIndex].id); omniListen(setTickingSound.options[setTickingSound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['ticking_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setBackgroundSound" style="width:20%;" onchange="setdata('background_sound',setBackgroundSound.options[setBackgroundSound.selectedIndex].id); omniListen(setBackgroundSound.options[setBackgroundSound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['background_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setFocusSound" style="width:20%;" onchange="setdata('focus_sound',setFocusSound.options[setFocusSound.selectedIndex].id); omniListen(setFocusSound.options[setFocusSound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['focus_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select><br>
        <select id="setTypeSound" style="width:20%;" onchange="setdata('type_sound',setTypeSound.options[setTypeSound.selectedIndex].id); omniListen(setTypeSound.options[setTypeSound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['type_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setErrorSound" style="width:20%;" onchange="setdata('error_sound',setErrorSound.options[setErrorSound.selectedIndex].id); omniListen(setErrorSound.options[setErrorSound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['error_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setNotifySound" style="width:20%;" onchange="setdata('notify_sound',setNotifySound.options[setNotifySound.selectedIndex].id); omniListen(setNotifySound.options[setNotifySound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['notify_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select>
        <select id="setClickSound" style="width:20%;" onchange="setdata('click_sound',setClickSound.options[setClickSound.selectedIndex].id); omniListen(setClickSound.options[setClickSound.selectedIndex].id,true);">
        <?php foreach ($userSubscr['sound'] as $key=>$value) { ?>
            <option id="<?=$value;?>" <?php if ($session['click_sound']==$value) { ?> selected <?php } ?>><?=$value;?></option>
        <?php } ?></select><br>
        <label><?=term('User Interface:', $settings,$session);?></label><br>
        <input type="text" id="setBoxShadow" style="width:68%;" placeholder="<?=term('Box Shadow',$settings,$session);?>" value="<?=$session['box_shadow'];?>" onkeydown="if (event.keyCode==13) {
            setdata('box_shadow',this.value);
        } else if (event.keyCode==27) {
            this.value='inset 0px 0px #FFFFFF, inset 0px 0px #FFFFFF';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setTextBoxShadow" style="width:68%;" placeholder="<?=term('Text Box Shadow',$settings,$session);?>" value="<?=$session['text_box_shadow'];?>" onkeydown="if (event.keyCode==13) {
            setdata('text_box_shadow',this.value);
        } else if (event.keyCode==27) {
            this.value='inset 0px 0px #FFFFFF, inset 0px 0px #FFFFFF';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setTextShadow" style="width:68%;" placeholder="<?=term('Text Shadow',$settings,$session);?>" value="<?=$session['text_shadow'];?>" onkeydown="if (event.keyCode==13) {
            setdata('text_shadow',this.value);
        } else if (event.keyCode==27) {
            this.value='#000000 3px 3px 3px, #000000 -3px -3px 3px, #000000 3px -3px 3px, #000000 -3px 3px 3px';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setBackImage" style="width:38%;" placeholder="<?=term('Background',$settings,$session);?>" value="<?=$session['background'];?>" onkeydown="if (event.keyCode==13) {
            setdata('background',this.value);
        } else if (event.keyCode==27) { this.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setBackBuffer" style="width:38%;" placeholder="<?=term('Background Buffer',$settings,$session);?>" value="<?=$session['background_buffer'];?>" onkeydown="if (event.keyCode==13) {
            setdata('background_buffer',this.value);
        } else if (event.keyCode==27) { this.value='';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setBorderRadius" style="width:38%;" placeholder="<?=term('Border Radius',$settings,$session);?>" value="<?=$session['border_radius'];?>" onkeydown="if (event.keyCode==13) {
            setdata('border_radius',this.value);
        } else if (event.keyCode==27) { this.value='7';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setTextBorderRadius" style="width:38%;" placeholder="<?=term('Text Border Radius',$settings,$session);?>" value="<?=$session['text_border_radius'];?>" onkeydown="if (event.keyCode==13) {
            setdata('text_border_radius',this.value);
        } else if (event.keyCode==27) { this.value='7';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setMarqueeSpeed" style="width:12%;" placeholder="<?=term('Marquee Speed',$settings,$session);?>" value="<?=$session['marquee_speed'];?>" onkeydown="if (event.keyCode==13) {
            setdata('marquee_speed',this.value);
        } else if (event.keyCode==27) { this.value='400';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setGradButton" style="width:12%;" placeholder="<?=term('Button Gradient',$settings,$session);?>" value="<?=$session['gradient_button'];?>" onkeydown="if (event.keyCode==13) {
            setdata('gradient_button',this.value);
        } else if (event.keyCode==27) { this.value='180';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setBackSize" style="width:12%;" placeholder="<?=term('Back Size',$settings,$session);?>" value="<?=$session['back_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('back_size',this.value);
        } else if (event.keyCode==27) { this.value='14';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setForeSize" style="width:12%;" placeholder="<?=term('Fore Size',$settings,$session);?>" value="<?=$session['fore_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('fore_size',this.value);
        } else if (event.keyCode==27) { this.value='14';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setInputSize" style="width:12%;" placeholder="<?=term('Input Size',$settings,$session);?>" value="<?=$session['input_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('input_size',this.value);
        } else if (event.keyCode==27) { this.value = '14';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="number" min='0' max='9' step='1' id="setMagnitude" style="width:12%;" placeholder="<?=term('Magnitude',$settings,$session);?>" value="<?=$session['magnitude'];?>" oninput="setdata('magnitude',setMagnitude.value); handleInput(this.value,true);" onkeydown="if (event.keyCode==27) {
            this.value=5;
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }"><br>
        <input type="text" id="setGradFore" style="width:12%;" placeholder="<?=term('Fore Gradient',$settings,$session);?>" value="<?=$session['gradient_fore'];?>" onkeydown="if (event.keyCode==13) {
            setdata('gradient_fore',this.value);
        } else if (event.keyCode==27) { this.value='180';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setGradInput" style="width:12%;" placeholder="<?=term('Input Gradient',$settings,$session);?>" value="<?=$session['gradient_input'];?>" onkeydown="if (event.keyCode==13) {
            setdata('gradient_input',this.value);
        } else if (event.keyCode==27) { this.value='180';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setHead1Size" style="width:12%;" placeholder="<?=term('Heading Level 1 Size',$settings,$session);?>" value="<?=$session['head1_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('head1_size',this.value);
        } else if (event.keyCode==27) { this.value='17';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setHead2Size" style="width:12%;" placeholder="<?=term('Heading Level 2 Size',$settings,$session);?>" value="<?=$session['head2_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('head2_size',this.value);
        } else if (event.keyCode==27) { this.value='16';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setHead3Size" style="width:12%;" placeholder="<?=term('Heading Level 3 Size',$settings,$session);?>" value="<?=$session['head3_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('head3_size',this.value);
        } else if (event.keyCode==27) { this.value='15';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setDispSize" style="width:12%;" placeholder="<?=term('Display Text Size',$settings,$session);?>" value="<?=$session['disp_size'];?>" onkeydown="if (event.keyCode==13) {
            setdata('disp_size',this.value);
        } else if (event.keyCode==27) { this.value = '18';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setBackColor" style="width:15%;" placeholder="<?=term('Back Color',$settings,$session);?>" value="<?=$session['back_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('back_color',this.value);
        } else if (event.keyCode==27) { this.value='C0BFC0';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setForeColor" style="width:15%;" placeholder="<?=term('Fore Color',$settings,$session);?>" value="<?=$session['fore_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('fore_color',this.value);
        } else if (event.keyCode==27) { this.value='605F60';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setInputColor" style="width:15%;" placeholder="<?=term('Input Color',$settings,$session);?>" value="<?=$session['input_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('input_color',this.value);
        } else if (event.keyCode==27) { this.value='E5E5E5';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setArcForeColor" style="width:15%;" placeholder="<?=term('Adverse Fore Color',$settings,$session);?>" value="<?=$session['arc_fore_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('arc_fore_color',this.value);
        } else if (event.keyCode==27) { this.value='403F40';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setArcInputColor" style="width:15%;" placeholder="<?=term('Adverse Input Color',$settings,$session);?>" value="<?=$session['arc_input_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('arc_input_color',this.value);
        } else if (event.keyCode==27) { this.value='D5D5D5';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);"><br>
        <input type="text" id="setBackTextColor" style="width:15%;" placeholder="<?=term('Back Text Color',$settings,$session);?>" value="<?=$session['back_text_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('back_text_color',this.value);
        } else if (event.keyCode==27) { this.value='FFFFFF';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setForeTextColor" style="width:15%;" placeholder="<?=term('Fore Text Color',$settings,$session);?>" value="<?=$session['fore_text_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('fore_text_color',this.value);
        } else if (event.keyCode==27) { this.value='FFFFFF';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setInputTextColor" style="width:15%;" placeholder="<?=term('Input Text Color',$settings,$session);?>" value="<?=$session['input_text_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('input_text_color',this.value);
        } else if (event.keyCode==27) { this.value='000000';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setBlankColor" style="width:15%;" placeholder="<?=term('Blank Color',$settings,$session);?>" value="<?=$session['blank_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('blank_color',this.value);
        } else if (event.keyCode==27) { this.value='FFFFFF';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setBlankTextColor" style="width:15%;" placeholder="<?=term('Blank Text Color',$settings,$session);?>" value="<?=$session['blank_text_color'];?>" onkeydown="if (event.keyCode==13) {
            setdata('blank_text_color',this.value);
        } else if (event.keyCode==27) { this.value='000000';
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
    </p>
</div>