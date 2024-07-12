<!-- volume -->
<!-- GR: Ελεγχος έντασης; CY: Ελεγχος έντασης; FR: Niveaux de volume; DE: Lautstärkeregelung; ES: Niveles de volumen; MX: Niveles de volumen; PT: Niveles de volumen; BR: Níveis de volume; RO: Niveluri de volum; MD: Niveluri de volum; IT: Livelli di volume; RU: Уровни громкости; TR: Ses seviyeleri; IN: वॉल्यूम स्तर; LK: आयतनस्तराः; UA: Рівні гучності; RS: Нивои јачине звука; CN: 声音混合器; KR: 사운드 믹서; JP: サウンドミキサー; AE: خلاط الصوت -->
<div class="slidecontainer"><p align='center'><?=term('Audio Volume', $settings['vocabulary'], $session['units']);?> 
<input type='button' id="audioVolInd" value="<?=$session['audio_volume'];?>"> <?=term('Video Volume', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="videoVolInd" value="<?=$session['video_volume'];?>"></p><p align='center'>
    <input type="range" min="0" max="1" step="0.05" value="<?=$session['audio_volume'];?>" class="slider" id="audioVolRange" onchange="setdata('audio_volume', this.value);"> 
    <input type="range" min="0" max="1" step="0.05" value="<?=$session['video_volume'];?>" class="slider" id="videoVolRange" onchange="setdata('video_volume', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'><?=term('Audio Speed', $settings['vocabulary'], $session['units']);?> 
<input type='button' id="audioRatInd" value="<?=$session['audio_speed'];?>"> <?=term('Video Speed', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="videoRatInd" value="<?=$session['audio_speed'];?>"></p><p align='center'>
    <input type="range" min="0.5" max="1.5" step="0.05" value="<?=$session['audio_speed'];?>" class="slider" id="audioRatRange" onchange="setdata('audio_speed', this.value);"> 
    <input type="range" min="0.5" max="1.5" step="0.05" value="<?=$session['video_speed'];?>" class="slider" id="videoRatRange" onchange="setdata('video_speed', this.value);">
</p></div>
<div class="slidecontainer"><p align='center'><?=term('Audio Balance', $settings['vocabulary'], $session['units']);?> 
<input type='button' id="audioBalInd" value="<?=$session['audio_balance'];?>"> <?=term('Video Balance', $settings['vocabulary'], $session['units']);?> 
    <input type='button' id="videoBalInd" value="<?=$session['video_balance'];?>"></p><p align='center'>
    <input type="range" min="-10000" max="10000" step="1000" value="<?=$session['audio_balance'];?>" class="slider" id="audioBalRange" onchange="setdata('audio_balance', this.value);"> 
    <input type="range" min="-10000" max="10000" step="1000" value="<?=$session['video_balance'];?>" class="slider" id="videoBalRange" onchange="setdata('video_balance', this.value);">
</p></div>