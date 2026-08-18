<!-- paint -->
<!-- AD: Efectos visuales; AG: Efectos visuales; AT: Visuelle Effekte; BE: Effets visuels; BR: Efeitos visuais; CH: Filtra Photographica; CL: Efectos visuales; CN: 视觉效果和滤镜; CO: Efectos visuales; CU: Efectos visuales; CY: Οπτικά; DD: Visuelle Effekte; DE: Visuelle Effekte; DR: Visuelle Effekte; ES: Efectos visuales; FR: Effets visuels; GR: Οπτικά; IN: दृश्यात्मक प्रभाव; IT: Effetti visivi; JP: 視覚効果とフィルター; KP: 시각 효과 및 필터; KR: 시각 효과 및 필터; LK: दृश्यप्रभावाः; MC: Effets visuels; MD: Efecte vizuale; MX: Efectos visuales; NP: མཐོང་ཐུབ་པའི་ཕན་ནུས།; PT: Efeitos visuais; RO: Efecte vizuale; RS: Визуелни ефекти; RU: Визуальные эффекты; SM: Effetti visivi; SP: Filtra Photographica; TR: Görsel efektler; UA: Візуальні ефекти; VA: Filtra Photographica -->
<div class="customPanel" style="width:100%;">
<p align='center'>
<label class="custom-checkbox-wrapper">
    <input type="checkbox" id="enableVintageTumblr" class="custom-checkbox-input" value="<?=$session['vintage'];?>" <?=($session['vintage']!=0)?'checked':'';?> onchange="setdata('vintage',flip(sysDefVintage.value));">
    <span class="custom-checkbox-box"></span>
    <span class="custom-checkbox-label"><?=term('Vintage Effects',$settings,$session);?></span> 
</label><br>
<label class="custom-checkbox-wrapper">
    <span class="custom-checkbox-label"><?=term('Magnitude:',$settings,$session);?></span>
    <input type="number" min='0' max='9' step='1' id="setMagnitude" style="width:16%;" placeholder="<?=term('Magnitude',$settings,$session);?>" value="<?=$session['magnitude'];?>" onkeydown="if (event.keyCode==27) {
            this.value=5;
        } else if (event.keyCode==8) { handleInput(this.value);
        } else if (event.keyCode==46) { handleInput(this.value);
        }" oninput="setdata('magnitude',setMagnitude.value); handleInput(this.value,true);">
</label>
</p>
</div>
<div class="customPanel" style="width:100%;display:grid;grid-template-columns:repeat(2,1fr);grid-template-rows:repeat(2,1fr);">
    <div class='cusromPanel'>
    <p align='center'>
        <input type='button' id="opacityInd" value="<?=$session['opacity'];?>"><br>
	<?=term('Opacity',$settings,$session);?><br>
        <input type="range" min="0" max="255" step="1" value="<?=$session['opacity'];?>" id="opacityRange" onchange="setdata('opacity',this.value);">
    </p>
    <p align='center'> 
        <input type='button' id="blurInd" value="<?=$session['blur'];?>px"><br>
	<?=term('Blur',$settings,$session);?><br> 
        <input type="range" min="0" max="100" step="1" value="<?=$session['blur'];?>" id="blurRange" onchange="setdata('blur',this.value);">
    </p>
    </div>
    <div class='cusromPanel'>
    <p align='center'>
        <input type='button' id="sepiaInd" value="<?=$session['sepia'].'%';?>"><br>
	<?=term('Sepia',$settings,$session);?><br>
        <input type="range" min="0" max="100" step="5" value="<?=$session['sepia'];?>" id="sepiaRange" onchange="setdata('sepia',this.value);">
    </p>
    <p align='center'>
        <input type='button' id="grayInd" value="<?=$session['grayscale'].'%';?>"><br>
	<?=term('Grayscale',$settings,$session);?><br>
        <input type="range" min="0" max="100" step="5" value="<?=$session['grayscale'];?>" id="grayRange" onchange="setdata('grayscale',this.value);">
    </p>
    </div>
    <div class='cusromPanel'>
    <p align='center'> 
        <input type='button' id="brightnessInd" value="<?=$session['brightness'].'%';?>"><br>
        <?=term('Bright',$settings,$session);?><br>
        <input type="range" min="50" max="150" step="5" value="<?=$session['brightness'];?>" id="brightnessRange" onchange="setdata('brightness',this.value);">
    </p>
    <p align='center'>
        <input type='button' id="hueInd" value="<?=$session['hue'].'deg';?>"><br>
        <?=term('Hue',$settings,$session);?><br>
        <input type="range" min="0" max="360" step="18" value="<?=$session['hue'];?>" id="hueRange" onchange="setdata('hue',this.value);">
    </p>
    </div>
    <div class='cusromPanel'>
    <p align='center'>
        <input type='button' id="contrastInd" value="<?=$session['contrast'].'%';?>"><br>
        <?=term('Contrast',$settings,$session);?><br>
        <input type="range" min="50" max="150" step="5" value="<?=$session['contrast'];?>" id="contrastRange" onchange="setdata('contrast',this.value);">
    </p>
    <p align='center'>
        <input type='button' id="saturationInd" value="<?=$session['saturation'].'%';?>"><br>
        <?=term('Saturate',$settings,$session);?><br>
        <input type="range" min="0" max="200" step="10" value="<?=$session['saturation'];?>" id="saturationRange" onchange="setdata('saturation',this.value);">
    </p>
    </div>
</div>