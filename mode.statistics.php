<!-- status -->
<!-- GR: Στατιστική; CY: Στατιστική; FR: Statistiques; BE: Statistiques; ES: Estadísticas; MX: Estadísticas; PT: Estatisticas; BR: Estatisticas; IT: Statistiche; DE: Statistiken; AT: Statistiken; CH: Statistica; LK: सांख्यिकी; RO: Statistici; MD: Statistici; NP: གྲངས་གཞི།; IN: आंकड़े; TR: İstatistik; UA: Статистика; RU: Статистика; RS: Статистика; CN: 用户统计; KR: 사용자 통계; JP: ユーザー統計; AE: إحصائيات المستخدم -->
<div class='customPanel' id='stat_modes' style="width:100%;height:40px;left:0px;top:0px;">
    <p align='center'>
        <input type='image' id='switchBtnAuto' onmouseover="soundButton();" class="power" onclick="setdata('stats','auto');" src="<?=$prefix[3].'steer.png';?>">
        <input type='image' id='switchBtnBind' onmouseover="soundButton();" class="power" onclick="setdata('stats','bind');" src="<?=$prefix[3].'chain.png';?>">
        <input type='image' id='switchBtnTool' onmouseover="soundButton();" class="power" onclick="setdata('stats','tool');" src="<?=$prefix[3].'parfum.png';?>">
        <input type='image' id='switchBtnScore' onmouseover="soundButton();" class="power" onclick="setdata('stats','powers');" src="<?=$prefix[3].'money.png';?>">
        <input type='image' id='switchBtnHDI' onmouseover="soundButton();" class="power" onclick="setdata('stats','hdi');" src="<?=$prefix[3].'heart.png';?>">
    </p>
</div>
<div class='customPanel' id='stat_disp' style="width:100%;height:75%;left:0px;top:0px;overflow-y:scroll;">
    <p align='center' id='userStats'></p>
</div>
