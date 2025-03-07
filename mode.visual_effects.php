<!-- paint -->
<!-- FR: Effets visuels; DE: Visuelle Effekte; BE: Effets visuels; AT: Visuelle Effekte; GR: Οπτικά εφέ; CY: Οπτικά εφέ; CH: Filtra Photographica; RO: Efecte vizuale; MD: Efecte vizuale; LK: दृश्यप्रभावाः; IN: दृश्यात्मक प्रभाव; TR: Görsel efektler; IT: Effetti visivi; RU: Визуальные эффекты; UA: Візуальні ефекти; RS: Визуелни ефекти; ES: Efectos visuales; NP: མཐོང་ཐུབ་པའི་ཕན་ནུས།; MX: Efectos visuales; BR: Efeitos visuais; PT: Efeitos visuais; CN: 视觉效果和滤镜; KR: 시각 효과 및 필터; JP: 視覚効果とフィルター; AE: تأثيرات بصرية -->
<div class="slidecontainer"><p align='center'><?=term('Opacity', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="opacityInd" value="<?=$session['opacity'];?>"> <?=term('Blur', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="blurInd" value="<?=$session['blur'];?>px"></p><p align='center'> 
    <input type="range" min="0" max="255" step="1" value="<?=$session['opacity'];?>" class="slider" id="opacityRange" onchange="setdata('opacity', this.value);"> 
    <input type="range" min="0" max="100" step="1" value="<?=$session['blur'];?>" class="slider" id="blurRange" onchange="setdata('blur', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'><?=term('Bright', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="brightnessInd" value="<?=$session['brightness'].'%';?>"> <?=term('Saturate', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="saturationInd" value="<?=$session['saturation'].'%';?>"></p><p align='center'>
    <input type="range" min="50" max="150" step="5" value="<?=$session['brightness'];?>" class="slider" id="brightnessRange" onchange="setdata('brightness', this.value);"> 
    <input type="range" min="0" max="200" step="10" value="<?=$session['saturation'];?>" class="slider" id="saturationRange" onchange="setdata('saturation', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'><?=term('Contrast', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="contrastInd" value="<?=$session['contrast'].'%';?>"> <?=term('Sepia', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="sepiaInd" value="<?=$session['sepia'].'%';?>"></p><p align='center'>
    <input type="range" min="50" max="150" step="5" value="<?=$session['contrast'];?>" class="slider" id="contrastRange" onchange="setdata('contrast', this.value);"> 
    <input type="range" min="0" max="100" step="5" value="<?=$session['sepia'];?>" class="slider" id="sepiaRange" onchange="setdata('sepia', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'><?=term('Grayscale', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="grayInd" value="<?=$session['grayscale'].'%';?>"> <?=term('Hue', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="hueInd" value="<?=$session['hue'].'deg';?>"></p><p align='center'>
    <input type="range" min="0" max="100" step="5" value="<?=$session['grayscale'];?>" class="slider" id="grayRange" onchange="setdata('grayscale', this.value);">
    <input type="range" min="0" max="360" step="18" value="<?=$session['hue'];?>" class="slider" id="hueRange" onchange="setdata('hue', this.value);">
</p></div>