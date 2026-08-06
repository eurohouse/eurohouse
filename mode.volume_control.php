<!-- volume -->
<!-- GR: Ακουστική; CY: Ακουστική; FR: Niveaux de volume; DE: Lautstärkeregelung; BE: Niveaux de volume; AT: Lautstärkeregelung; CH: Occasus Acusticus; ES: Niveles de volumen; MX: Niveles de volumen; PT: Niveles de volumen; BR: Níveis de volume; RO: Niveluri de volum; MD: Niveluri de volum; IT: Livelli di volume; RU: Уровни громкости; TR: Ses seviyeleri; IN: वॉल्यूम स्तर; LK: आयतनस्तराः; UA: Рівні гучності; RS: Нивои јачине звука; CN: 声音混合器; KR: 사운드 믹서; JP: サウンドミキサー -->
<div class="customPanel" style="width:100%;">
<p align='center'>
<label class="custom-checkbox-wrapper">
    <input type="checkbox" id="preservesPitchTumblr" class="custom-checkbox-input" value="<?=$session['preserves_pitch'];?>" <?=($session['preserves_pitch']!=0)?'checked':'';?> onchange="setdata('preserves_pitch',flip(sysDefPreservesPitch.value));">
    <span class="custom-checkbox-box"></span>
    <span class="custom-checkbox-label"><?=term('Preserves Pitch',$settings,$session);?></span>
</label>
</p>
</div>
<div class="customPanel" style="width:100%;display:grid;grid-template-columns:repeat(2,1fr);grid-template-rows:repeat(2,1fr);">
    <div class='customPanel'>
    <p align='center'>
        <input type='button' id="audioVolInd" value="<?=round(100*$session['audio_volume']).'%';?>"><br><?=term('Audio Volume',$settings,$session);?><br>
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['audio_volume'];?>" id="audioVolRange" onchange="setdata('audio_volume',this.value);">
    </p>
    <p align='center'>
        <input type='button' id="videoVolInd" value="<?=round(100*$session['video_volume']).'%';?>"><br><?=term('Video Volume',$settings,$session);?><br>
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['video_volume'];?>" id="videoVolRange" onchange="setdata('video_volume',this.value);">
    </p>
    </div>
    <div class='customPanel'>
    <p align='center'>
        <input type='button' id="audioRatInd" value="<?=round(100*$session['audio_speed']).'%';?>"><br><?=term('Audio Speed',$settings,$session);?><br>
        <input type="range" min="0.5" max="1.5" step="0.05" value="<?=$session['audio_speed'];?>" id="audioRatRange" onchange="setdata('audio_speed',this.value);">
    </p>
    <p align='center'>
        <input type='button' id="videoRatInd" value="<?=round(100*$session['video_speed']).'%';?>"><br><?=term('Video Speed',$settings,$session);?><br>
        <input type="range" min="0.5" max="1.5" step="0.05" value="<?=$session['video_speed'];?>" id="videoRatRange" onchange="setdata('video_speed', this.value);">
    </p>
    </div>
</div>