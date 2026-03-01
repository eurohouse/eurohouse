<!-- status -->
<!-- GR: Στατιστική; CY: Στατιστική; FR: Statistiques; DE: Statistiken; BE: Statistiques; AT: Statistiken; CH: Statisticae; ES: Estadística; MX: Estadística; PT: Estatísticos; BR: Estatísticos; RO: Statistici; MD: Statistici; IT: Statistiche; RU: Статистика; TR: İstatistikler; NP: བསྡོམས་རྩིས་དཔྱད་གཞི།; IN: आंकड़े; LK: सांख्यिकी; UA: Статистика; RS: Статистика; CN: 用户统计; KR: 사용자 통계; JP: ユーザー統計; AE: إحصائيات المستخدمين -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptStats" style="width:62%;" placeholder="<?=term("Search certain models or objects by keywords",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { populateIpStats(promptStats.value);
    } else if (event.keyCode==27) { promptStats.value='';
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonSearch" onmouseover="soundButton();" src="<?=$prefix[3].'search.png';?>" onclick="populateIpStats(promptStats.value);"><input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="promptStats.value=''; promptStats.focus();"></p>
</div>
<div class='customPanel' id='ipDiv' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
<table id="ipTable" style="width:100%;">
<thead>
    <tr>
        <th style="width:4%;">
            <?=term('Country',$settings,$session);?>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(1,'T','','ipTable');">
                <?=term('IP Address',$settings,$session);?>
            </a>
        </th>
        <th style="width:4%;">
            <a href="javascript:SortTable(2,'T','','ipTable');">
                <?=term('OS',$settings,$session);?>
            </a>
        </th>
        <th style="width:4%;">
            <a href="javascript:SortTable(3,'T','','ipTable');">
                <?=term('Browser',$settings,$session);?>
            </a>
        </th>
        <th style="width:8%;">
            <a href="javascript:SortTable(4,'T','','ipTable');">
                <?=term('Username',$settings,$session);?>
            </a>
        </th>
    </tr>
</thead>
<tbody id="ipData"></tbody>
<tfoot id="ipFoot">
    <tr><th style="width:25%;" colspan="5">
        <?=term('Total elements:',$settings,$session).' 0';?>
    </th></tr>
</tfoot>
</table>
</div>