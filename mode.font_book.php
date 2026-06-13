<!-- font -->
<!-- GR: Τυπογραφία; CY: Τυπογραφία; DE: Schriftartenbetrachter; AT: Schriftartenbetrachter; CH: Typographia Liber; FR: Visionneuse de polices; BE: Visionneuse de polices; IT: Visualizzatore di caratteri; IN: फ़ॉन्ट दर्शक; LK: फॉन्ट दर्शक; RU: Просмотр шрифта; NP: ཡིག་གཟུགས་ལྟ་མཁན།; RS: Прегледач фонтова; ES: Visor de fuentes; PT: Visualizador de fontes; RO: Cartea cu fonturi; MD: Cartea cu fonturi; MX: Visor de fuentes; BR: Visualizador de fontes; TR: Yazı tipi görüntüleyici; UA: Засіб перегляду шрифту; CN: 字体查看器; KR: 글꼴 뷰어; JP: フォントビューア; AE: كتاب الخطوط -->
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