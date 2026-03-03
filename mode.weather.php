<!-- weather -->
<!-- GR: Μετεωρολογία; CY: Μετεωρολογία; FR: Prévisions météorologiques; DE: Wettervorhersage; BE: Prévisions météorologiques; AT: Wettervorhersage; CH: Praedictio tempestatis; ES: Pronóstico del tiempo; MX: Pronóstico del tiempo; PT: Previsão do tempo; BR: Previsão do tempo; RO: Prognoza meteo; MD: Prognoza meteo; IT: Previsioni del tempo; RU: Прогноз погоды; TR: Hava tahmini; NP: གནམ་གཤིས་སྔོན་བརྡ།; IN: मौसम पूर्वानुमान; LK: मौसमस्य पूर्वानुमानम्; UA: Прогноз погоди; RS: Временска прогноза; CN: 天气预报; KR: 날씨 예보; JP: 天気予報; AE: توقعات الطقس -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptWeather" style="width:62%;" placeholder="<?=term("Set certain weather locations",$settings,$session);?>" value="<?=$session['locations'];?>" onkeydown="if (event.keyCode==13) {
        setdata('locations',promptWeather.value);
        populateWeatherTable();
    } else if (event.keyCode==27) {
        document.getElementById('promptWeather').value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonSearch" onmouseover="soundButton();" src="<?=$prefix[3].'search.png';?>" onclick="setdata('locations',promptWeather.value); populateWeatherTable();"><input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('promptWeather').value=''; document.getElementById('promptWeather').focus();"></p>
</div>
<div class='customPanel' id='weatherWidget' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
    <table id="weatherTable" style="width:100%;">
        <thead>
            <tr>
                <th><?=term('Location',$settings,$session);?></th>
                <th><?=term('Coordinates',$settings,$session);?></th>
                <th><?=term('Date/Time',$settings,$session);?></th>
                <th><?=term('Temperature',$settings,$session);?></th>
                <th><?=term('Precipitation',$settings,$session);?></th>
                <th><?=term('Wind Speed',$settings,$session);?></th>
                <th><?=term('Pressure',$settings,$session);?></th>
                <th><?=term('Cloud Cover',$settings,$session);?></th>
                <th><?=term('Sunrise/Sunset',$settings,$session);?></th>
                <th><?=term('Conditions',$settings,$session);?></th>
            </tr>
        </thead>
        <tbody id="weatherData"></tbody>
    </table>
</div>