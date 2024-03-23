<!-- paint -->
<!-- RU: Эффекты изображения; CN: 视觉效果和滤镜; TW: 视觉效果和滤镜; JP: 视觉效果和滤镜; AE: تأثيرات بصرية -->
<p align='center' class='block'>
<input type="button" value="Reset" onclick="
setdata('opacity', 64); setdata('blur', 0);
setdata('brightness', 100); setdata('saturation', 100);
setdata('contrast', 100); setdata('sepia', 0);
setdata('grayscale', 0); setdata('hue', 0);">
<input type="button" value="Vintage" onclick="
setdata('opacity', 64); setdata('blur', 0);
setdata('brightness', 100); setdata('saturation', 100);
setdata('contrast', 100); setdata('sepia', 50);
setdata('grayscale', 50); setdata('hue', 0);">
<input type="button" value="Back" onclick="omniBack('<?=$parent;?>');"></p>
<div class="slidecontainer"><p align='center'>Opacity: 
    <input type='button' id="opacityInd" value="<?=$session['opacity'];?>"> Blur: 
    <input type='button' id="blurInd" value="<?=$session['blur'];?>px"></p><p align='center'>
    <input type="range" min="0" max="255" value="<?=$session['opacity'];?>" class="slider" id="opacityRange" onchange="setdata('opacity', this.value);"> 
    <input type="range" min="0" max="100" value="<?=$session['blur'];?>" class="slider" id="blurRange" onchange="setdata('blur', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'>Bright: 
    <input type='button' id="brightnessInd" value="<?=$session['brightness'].'%';?>"> Saturate: 
    <input type='button' id="saturationInd" value="<?=$session['saturation'].'%';?>"></p><p align='center'>
    <input type="range" min="50" max="150" value="<?=$session['brightness'];?>" class="slider" id="brightnessRange" onchange="setdata('brightness', this.value);"> 
    <input type="range" min="0" max="200" value="<?=$session['saturation'];?>" class="slider" id="saturationRange" onchange="setdata('saturation', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'>Contrast: 
    <input type='button' id="contrastInd" value="<?=$session['contrast'].'%';?>"> Sepia: 
    <input type='button' id="sepiaInd" value="<?=$session['sepia'].'%';?>"></p><p align='center'>
    <input type="range" min="50" max="150" value="<?=$session['contrast'];?>" class="slider" id="contrastRange" onchange="setdata('contrast', this.value);"> 
    <input type="range" min="0" max="100" value="<?=$session['sepia'];?>" class="slider" id="sepiaRange" onchange="setdata('sepia', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'>Grayscale: 
    <input type='button' id="grayInd" value="<?=$session['grayscale'].'%';?>"> Hue: 
    <input type='button' id="hueInd" value="<?=$session['hue'].'deg';?>"></p><p align='center'>
    <input type="range" min="0" max="100" value="<?=$session['grayscale'];?>" class="slider" id="grayRange" onchange="setdata('grayscale', this.value);">
    <input type="range" min="0" max="360" value="<?=$session['hue'];?>" class="slider" id="hueRange" onchange="setdata('hue', this.value);">
</p></div>