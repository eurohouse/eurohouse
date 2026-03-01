<!-- paint -->
<!-- FR: Effets visuels; DE: Visuelle Effekte; BE: Effets visuels; AT: Visuelle Effekte; GR: Οπτικά; CY: Οπτικά; CH: Filtra Photographica; RO: Efecte vizuale; MD: Efecte vizuale; LK: दृश्यप्रभावाः; IN: दृश्यात्मक प्रभाव; TR: Görsel efektler; IT: Effetti visivi; RU: Визуальные эффекты; UA: Візуальні ефекти; RS: Визуелни ефекти; ES: Efectos visuales; NP: མཐོང་ཐུབ་པའི་ཕན་ནུས།; MX: Efectos visuales; BR: Efeitos visuais; PT: Efeitos visuais; CN: 视觉效果和滤镜; KR: 시각 효과 및 필터; JP: 視覚効果とフィルター -->
<div class="customPanel" style="width:100%;display:grid;grid-template-columns:repeat(2,1fr);grid-template-rows:repeat(2,1fr);">
    <div class='cusromPanel'>
    <p align='center'>
        <?=term('Opacity',$settings,$session);?> 
        <input type='button' id="opacityInd" value="<?=$session['opacity'];?>"><br>
        <input type="range" min="0" max="255" step="1" value="<?=$session['opacity'];?>" id="opacityRange" onchange="setdata('opacity',this.value);">
    </p>
    <p align='center'> 
        <?=term('Blur',$settings,$session);?> 
        <input type='button' id="blurInd" value="<?=$session['blur'];?>px"><br>
        <input type="range" min="0" max="100" step="1" value="<?=$session['blur'];?>" id="blurRange" onchange="setdata('blur',this.value);">
    </p>
    </div>
    <div class='cusromPanel'>
    <p align='center'>
        <?=term('Sepia',$settings,$session);?> 
        <input type='button' id="sepiaInd" value="<?=$session['sepia'].'%';?>"><br>
        <input type="range" min="0" max="100" step="5" value="<?=$session['sepia'];?>" id="sepiaRange" onchange="setdata('sepia',this.value);">
    </p>
    <p align='center'>
        <?=term('Grayscale',$settings,$session);?> 
        <input type='button' id="grayInd" value="<?=$session['grayscale'].'%';?>"><br>
        <input type="range" min="0" max="100" step="5" value="<?=$session['grayscale'];?>" id="grayRange" onchange="setdata('grayscale',this.value);">
    </p>
    </div>
    <div class='cusromPanel'>
    <p align='center'>
        <?=term('Bright',$settings,$session);?> 
        <input type='button' id="brightnessInd" value="<?=$session['brightness'].'%';?>"><br>
        <input type="range" min="50" max="150" step="5" value="<?=$session['brightness'];?>" id="brightnessRange" onchange="setdata('brightness',this.value);">
    </p>
    <p align='center'>
        <?=term('Hue',$settings,$session);?> 
        <input type='button' id="hueInd" value="<?=$session['hue'].'deg';?>">
        <input type="range" min="0" max="360" step="18" value="<?=$session['hue'];?>" id="hueRange" onchange="setdata('hue',this.value);">
    </p>
    </div>
    <div class='cusromPanel'>
    <p align='center'>
        <?=term('Contrast',$settings,$session);?> 
        <input type='button' id="contrastInd" value="<?=$session['contrast'].'%';?>"><br>
        <input type="range" min="50" max="150" step="5" value="<?=$session['contrast'];?>" id="contrastRange" onchange="setdata('contrast',this.value);">
    </p>
    <p align='center'>
        <?=term('Saturate',$settings,$session);?> 
        <input type='button' id="saturationInd" value="<?=$session['saturation'].'%';?>"><br>
        <input type="range" min="0" max="200" step="10" value="<?=$session['saturation'];?>" id="saturationRange" onchange="setdata('saturation',this.value);">
    </p>
    </div>
</div>