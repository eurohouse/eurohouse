<!-- volume -->
<!-- GR: Ελεγχος έντασης; CY: Ελεγχος έντασης; FR: Niveaux de volume; DE: Lautstärkeregelung; BE: Niveaux de volume; AT: Lautstärkeregelung; CH: Occasus Acusticus; ES: Niveles de volumen; MX: Niveles de volumen; PT: Niveles de volumen; BR: Níveis de volume; RO: Niveluri de volum; MD: Niveluri de volum; IT: Livelli di volume; RU: Уровни громкости; TR: Ses seviyeleri; IN: वॉल्यूम स्तर; LK: आयतनस्तराः; UA: Рівні гучності; RS: Нивои јачине звука; CN: 声音混合器; KR: 사운드 믹서; JP: サウンドミキサー; AE: خلاط الصوت -->
<div style="width:100%;position:relative;columns:2;">
    <p align='center'><?=term('Audio Volume', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="audioVolInd" value="<?=$session['audio_volume'];?>"> <?=term('Video Volume', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="videoVolInd" value="<?=$session['video_volume'];?>">
    </p>
    <p align='center'>
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['audio_volume'];?>" id="audioVolRange" onchange="setdata('audio_volume', this.value);"> 
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['video_volume'];?>" id="videoVolRange" onchange="setdata('video_volume', this.value);">
    </p>
    <p align='center'><?=term('Audio Speed', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="audioRatInd" value="<?=$session['audio_speed'];?>"> <?=term('Video Speed', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="videoRatInd" value="<?=$session['audio_speed'];?>">
    </p>
    <p align='center'>
        <input type="range" min="0.5" max="1.5" step="0.05" value="<?=$session['audio_speed'];?>" id="audioRatRange" onchange="setdata('audio_speed', this.value);"> 
        <input type="range" min="0.5" max="1.5" step="0.05" value="<?=$session['video_speed'];?>" id="videoRatRange" onchange="setdata('video_speed', this.value);">
    </p>
    <p align='center'><?=term('Alarm Volume', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="alarmVolInd" value="<?=$session['alarm_volume'];?>"> <?=term('Timer Volume', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="timerVolInd" value="<?=$session['timer_volume'];?>">
    </p>
    <p align='center'>
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['alarm_volume'];?>" id="alarmVolRange" onchange="setdata('alarm_volume', this.value);"> 
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['timer_volume'];?>" id="timerVolRange" onchange="setdata('timer_volume', this.value);">
    </p>
    <p align='center'><?=term('Loop Volume', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="loopVolInd" value="<?=$session['loop_volume'];?>"> <?=term('Rest Volume', $settings['vocabulary'], $session['units']);?> 
        <input type='button' id="restVolInd" value="<?=$session['rest_volume'];?>">
    </p>
    <p align='center'>
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['loop_volume'];?>" id="loopVolRange" onchange="setdata('loop_volume', this.value);"> 
        <input type="range" min="0" max="1" step="0.05" value="<?=$session['rest_volume'];?>" id="restVolRange" onchange="setdata('rest_volume', this.value);">
    </p>
</div>