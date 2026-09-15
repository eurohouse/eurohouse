<!-- time -->
<!-- AD: Calendario y cronógrafo; AG: Calendario y cronógrafo; AT: Kalender und Chronograph; BE: Calendrier et chronographe; BR: Calendário e cronógrafo; CH: Chronographia; CL: Calendario y cronógrafo; CN: 日期和时间; CO: Calendario y cronógrafo; CU: Calendario y cronógrafo; CY: Χρονογραφία; DD: Kalender und Chronograph; DE: Kalender und Chronograph; DR: Kalender und Chronograph; ES: Calendario y cronógrafo; FR: Calendrier et chronographe; GR: Χρονογραφία; IN: कालक्रम; IT: Calendario e cronografo; JP: 日時; KP: 날짜 및 시간; KR: 날짜 및 시간; LK: कालक्रम; MC: Calendrier et chronographe; MD: Calendar și cronograf; MX: Calendario y cronógrafo; NP: ལོ་ཐོ་དང་དུས་ཚོད།; PT: Calendário e cronógrafo; RO: Calendar și cronograf; RS: Календар и хронограф; RU: Дата и время; SM: Calendario e cronografo; SP: Chronographia; TR: Takvim ve Kronograf; UA: Календар і хронограф; VA: Chronographia -->
<div class='customPanel' style="width:100%;height:60px;left:0px;top:0px;">
    <p align='center'>
        <input type='button' onmouseover="soundButton();" value="<?=term('Apply Settings',$settings,$session)?>" onclick="setdata('date_format',setDateFormat.value); setdata('time_format',setTimeFormat.value);">
        <input type='button' onmouseover="soundButton();" value="<?=term('Reload Page',$settings,$session)?>" onclick="window.location.reload();">
    </p>
</div>
<div class='customPanel' style="width:100%;height:100px;left:0px;top:0px;">
    <p align='center' class='block'>
    <div class="progress" id="hourProgress" style="max-width:100%;">
        <div class="progressBar" id="hourInd" style="width:<?=100*(date('H')/23);?>%;"></div>
    </div>
    <div class="progress" id="minuteProgress" style="max-width:100%;">
        <div class="progressBar" id="minuteInd" style="width:<?=100*(date('i')/59);?>%;"></div>
    </div>
    <div class="progress" id="secondProgress" style="max-width:100%;">
        <div class="progressBar" id="secondInd" style="width:<?=100*(date('s')/59);?>%;"></div>
    </div>
    </p>
</div>
<div class='customPanel' style="width:100%;height:47%;left:0px;top:0px;overflow-y:scroll;">
    <p align='center'>
        <label>
        <a href="https://www.php.net/manual/en/datetime.format.php">
        <?=l10nEnt('standards','iso8601',$settings,$session);?></a>
        </label><br>
        <span class='block'>
        <input type="text" id="setDateFormat" style="width:38%;" value="<?=$session['date_format'];?>" placeholder="<?=term('Date Format',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('date_format',this.value);
        } else if (event.keyCode==27) {
            this.value='Y-m-d'; setdata('date_format','Y-m-d');
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        <input type="text" id="setTimeFormat" style="width:38%;" value="<?=$session['time_format'];?>" placeholder="<?=term('Time Format',$settings,$session);?>" onkeydown="
        if (event.keyCode==13) {
            setdata('time_format',this.value);
        } else if (event.keyCode==27) {
            this.value='H:i:s'; setdata('time_format','H:i:s');
        } else if (event.keyCode==8) {
            handleInput(this.value);
        } else if (event.keyCode==46) {
            handleInput(this.value);
        }" oninput="handleInput(this.value,true);">
        </span><br>
        <label>
            <?=term('Choose Calendar:',$settings,$session);?>
        </label><br>
        <select id="setProfileCalendar" style="width:76%;" onchange="setdata('calendar',setProfileCalendar.options[setProfileCalendar.selectedIndex].id);">
        <?php foreach ($settings['locale']['profile']['calendars'] as $key=>$value) { ?>
            <option id="<?=$key;?>" <?php if ($session['calendar']==$key) { ?> selected <?php } ?>>
                <?=(isset($value[$session['units']]))?$value[$session['units']]:$value['default'];?>
            </option>
        <?php } ?></select><br>
        <label>
            <?=term('Choose Time Zone:',$settings,$session);?>
        </label><br>
        
        <select id="setTimeZone" style="width:76%;" onchange="setdata('timezone',btoa(this.options[this.selectedIndex].id));">
        <?php foreach ($settings['locale']['timezones'] as $key=>$value) { ?>
            <option id="<?=$key;?>" <?php if (base64_decode($session['timezone'])==$key) { ?> selected <?php } ?>>
                <?=(isset($value[$session['units']]))?$value[$session['units']]:$value['default'];?>
            </option>
        <?php } ?></select>
    </p>
</div>