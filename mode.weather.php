<!-- weather -->
<!-- AD: Pronóstico del tiempo; AE: توقعات الطقس; AG: Pronóstico del tiempo; AT: Wettervorhersage; BE: Prévisions météorologiques; BR: Previsão do tempo; CH: Praedictio tempestatis; CL: Pronóstico del tiempo; CN: 天气预报; CO: Pronóstico del tiempo; CU: Pronóstico del tiempo; CY: Μετεωρολογία; DD: Wettervorhersage; DE: Wettervorhersage; DR: Wettervorhersage; ES: Pronóstico del tiempo; FR: Prévisions météorologiques; GR: Μετεωρολογία; IN: मौसम पूर्वानुमान; IQ: توقعات الطقس; IR: توقعات الطقس; IT: Previsioni del tempo; JP: 天気予報; KP: 날씨 예보; KR: 날씨 예보; KW: توقعات الطقس; LK: मौसमस्य पूर्वानुमानम्; MC: Prévisions météorologiques; MD: Prognoza meteo; MX: Pronóstico del tiempo; NP: གནམ་གཤིས་སྔོན་བརྡ།; PT: Previsão do tempo; QA: توقعات الطقس; RO: Prognoza meteo; RS: Временска прогноза; RU: Прогноз погоды; SA: توقعات الطقس; SM: Previsioni del tempo; SP: Praedictio tempestatis; TR: Hava tahmini; UA: Прогноз погоди; VA: Praedictio tempestatis -->
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
    <input type="image" class="power" id="buttonSearch" onmouseover="soundButton();" src="<?=$prefix[3].'search.png';?>" onclick="soundClick(); setdata('locations',promptWeather.value); populateWeatherTable();"><input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="soundClick(); promptWeather.value=''; promptWeather.focus();"></p>
</div>
<div class='customPanel' id='weatherWidget' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
    <table id="weatherTable" style="width:100%;" class="wrapper">
        <thead>
            <tr>
                <th style="width:30%;">
                    <?=term('Location',$settings,$session);?>
                </th>
                <th style="width:30%;">
                    <a href="javascript:SortTable(1,'T','','weatherTable');">
                        <?=term('Weather',$settings,$session);?>
                    </a>
                </th>
                <th style="width:30%;">
                    <a href="javascript:SortTable(2,'T','','weatherTable');">
                        <?=term('Climate',$settings,$session);?>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody id="weatherData"></tbody>
        <tfoot id="weatherFoot">
            <tr><th style="width:25%;" colspan="3">
                <?=term('Total elements:',$settings,$session).' 0';?>
            </th></tr>
        </tfoot>
    </table>
</div>