<!-- status -->
<!-- GR: Στατιστική; CY: Στατιστική; FR: Statistiques; BE: Statistiques; ES: Estadísticas; MX: Estadísticas; PT: Estatisticas; BR: Estatisticas; IT: Statistiche; DE: Statistiken; AT: Statistiken; CH: Statistica; LK: सांख्यिकी; RO: Statistici; MD: Statistici; NP: གྲངས་གཞི།; IN: आंकड़े; TR: İstatistik; UA: Статистика; RU: Статистика; RS: Статистика; CN: 用户统计; KR: 사용자 통계; JP: ユーザー統計; AE: إحصائيات المستخدم -->
<div class='customPanel' id='stat_disp' style="width:100%;height:75%;left:0px;top:0px;overflow-y:scroll;">
    <p align='center'>
        <input type='image' id='switchBtnAuto' onmouseover="soundButton();" class="power" onclick="setdata('stats','auto');" src="<?=$prefix.'steer.png';?>">
        <input type='image' id='switchBtnCall' onmouseover="soundButton();" class="power" onclick="setdata('stats','call');" src="<?=$prefix.'dial.png';?>">
        <input type='image' id='switchBtnFrnd' onmouseover="soundButton();" class="power" onclick="setdata('stats','friend');" src="<?=$prefix.'user.png';?>">
        <input type='image' id='switchBtnBind' onmouseover="soundButton();" class="power" onclick="setdata('stats','bind');" src="<?=$prefix.'chain.png';?>">
        <input type='image' id='switchBtnTool' onmouseover="soundButton();" class="power" onclick="setdata('stats','tool');" src="<?=$prefix.'parfum.png';?>">
        <input type='image' id='switchBtnScore' onmouseover="soundButton();" class="power" onclick="setdata('stats','powers');" src="<?=$prefix.'money.png';?>">
        <input type='image' id='switchBtnHDI' onmouseover="soundButton();" class="power" onclick="setdata('stats','hdi');" src="<?=$prefix.'heart.png';?>">
        <input type='image' id='switchBtnIP' onmouseover="soundButton();" class="power" onclick="setdata('stats','ip');" src="<?=$prefix.'world.png';?>">
    </p>
    <p align='center' id='tabScore'><?=term('Server-Wide User Statistics:', $settings['vocabulary'], $session['units']);?></p>
    <p align='center' id='userStats'></p>
</div>
