<!-- font -->
<!-- AD: Visor de fuentes; AE: كتاب الخطوط; AG: Visor de fuentes; AT: Schriftartenbetrachter; BE: Visionneuse de polices; BR: Visualizador de fontes; CH: Typographia Liber; CL: Visor de fuentes; CN: 字体查看器; CO: Visor de fuentes; CU: Visor de fuentes; CY: Τυπογραφία; DD: Schriftartenbetrachter; DE: Schriftartenbetrachter; DR: Schriftartenbetrachter; ES: Visor de fuentes; FR: Visionneuse de polices; GR: Τυπογραφία; IN: फ़ॉन्ट दर्शक; IQ: كتاب الخطوط; IR: كتاب الخطوط; IT: Visualizzatore di caratteri; JP: フォントビューア; KP: 글꼴 뷰어; KR: 글꼴 뷰어; KW: كتاب الخطوط; LK: फॉन्ट दर्शक; MC: Visionneuse de polices; MD: Cartea cu fonturi; MX: Visor de fuentes; NP: ཡིག་གཟུགས་ལྟ་མཁན།; PT: Visualizador de fontes; QA: كتاب الخطوط; RO: Cartea cu fonturi; RS: Прегледач фонтова; RU: Просмотр шрифта; SA: كتاب الخطوط; SM: Visualizzatore di caratteri; SP: Typographia Liber; TR: Yazı tipi görüntüleyici; UA: Засіб перегляду шрифту; VA: Typographia Liber -->
<!-- <ref> -->
<!-- true -->
<?php $isFont=(in_array(pathinfo($request['input'],PATHINFO_EXTENSION),fileExt($settings['collections']['font'])))?'userDefine':'euro'; ?>
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="testFont" style="width:62%;" placeholder="<?=term("What's on your mind?",$settings,$session);?>" value="" onkeydown="if (event.keyCode==27) {
        testFont.value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    </p>
</div>
<div class='customPanel' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
    <p id="fontBook24Pt" style="font-size:24pt;" align='left' class="<?=$isFont;?>">
        <?=$session['pangram_'.(($settings['pangram'][$session['units']])?$settings['pangram'][$session['units']]:$settings['pangram']['default'])];?>
    </p>
    <p id="fontBook22Pt" style="font-size:22pt;" align='left' class="<?=$isFont;?>">
        <?=$session['pangram_'.(($settings['pangram'][$session['units']])?$settings['pangram'][$session['units']]:$settings['pangram']['default'])];?>
    </p>
    <p id="fontBook20Pt" style="font-size:20pt;" align='left' class="<?=$isFont;?>">
        <?=$session['pangram_'.(($settings['pangram'][$session['units']])?$settings['pangram'][$session['units']]:$settings['pangram']['default'])];?>
    </p>
    <p id="fontBook18Pt" style="font-size:18pt;" align='left' class="<?=$isFont;?>">
        <?=$session['pangram_'.(($settings['pangram'][$session['units']])?$settings['pangram'][$session['units']]:$settings['pangram']['default'])];?>
    </p>
    <p id="fontBook16Pt" style="font-size:16pt;" align='left' class="<?=$isFont;?>">
        <?=$session['pangram_'.(($settings['pangram'][$session['units']])?$settings['pangram'][$session['units']]:$settings['pangram']['default'])];?>
    </p>
    <p id="fontBook14Pt" style="font-size:14pt;" align='left' class="<?=$isFont;?>">
        <?=$session['pangram_'.(($settings['pangram'][$session['units']])?$settings['pangram'][$session['units']]:$settings['pangram']['default'])];?>
    </p>
</div>