<!-- status -->
<!-- AD: Estadística; AE: إحصائيات المستخدمين; AG: Estadística; AT: Statistiken; BE: Statistiques; BR: Estatísticos; CH: Statisticae; CL: Estadística; CN: 用户统计; CO: Estadística; CU: Estadística; CY: Στατιστική; DD: Statistiken; DE: Statistiken; DR: Statistiken; ES: Estadística; FR: Statistiques; GR: Στατιστική; IN: आंकड़े; IQ: إحصائيات المستخدمين; IR: إحصائيات المستخدمين; IT: Statistiche; JP: ユーザー統計; KP: 사용자 통계; KR: 사용자 통계; KW: إحصائيات المستخدمين; LK: सांख्यिकी; MC: Statistiques; MD: Statistici; MX: Estadística; NP: བསྡོམས་རྩིས་དཔྱད་གཞི།; PT: Estatísticos; QA: إحصائيات المستخدمين; RO: Statistici; RS: Статистика; RU: Статистика; SA: إحصائيات المستخدمين; SM: Statistiche; SP: Statisticae; TR: İstatistikler; UA: Статистика; VA: Statisticae -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptStats" style="width:62%;" placeholder="<?=term("Search certain models or objects by keywords",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        populateIpStats(this.value);
    } else if (event.keyCode==27) {
        this.value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonSearch" onmouseover="soundButton();" src="<?=$prefix[3].'search.png';?>" onclick="populateIpStats(promptStats.value);">
    <input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="promptStats.value='';">
    </p>
</div>
<div class='customPanel' id='ipDiv' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
<table id="ipTable" style="width:100%;" class="wrapper">
<thead>
    <tr>
        <th style="width:20%;">
            <a href="javascript:SortTable(0,'T','','ipTable');">
                <?=term('Remote Address',$settings,$session);?>
            </a>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(1,'T','','ipTable');">
                <?=term('System',$settings,$session);?>
            </a>
        </th>
        <th style="width:20%;">
            <a href="javascript:SortTable(2,'T','','ipTable');">
                <?=term('Browser',$settings,$session);?>
            </a>
        </th>
    </tr>
</thead>
<tbody id="ipData"></tbody>
<tfoot id="ipFoot">
    <tr><th style="width:25%;" colspan="3">
        <?=term('Total elements:',$settings,$session).' 0';?>
    </th></tr>
</tfoot>
</table>
</div>
