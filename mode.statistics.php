<!-- status -->
<!-- GR: Στατιστική; CY: Στατιστική; FR: Statistiques; BE: Statistiques; ES: Estadísticas; MX: Estadísticas; PT: Estatisticas; BR: Estatisticas; IT: Statistiche; DE: Statistiken; AT: Statistiken; CH: Statistica; LK: सांख्यिकी; RO: Statistici; MD: Statistici; NP: གྲངས་གཞི།; IN: आंकड़े; TR: İstatistik; UA: Статистика; RU: Статистика; RS: Статистика; CN: 用户统计; KR: 사용자 통계; JP: ユーザー統計; AE: إحصائيات المستخدم -->
<p align='center'>
<input type='image' onmouseover="soundButton();" class="power" onclick="setdata('stats', 'auto');" src="<?=$prefix.'steer.png'.$suffix;?>">
<input type='image' onmouseover="soundButton();" class="power" onclick="setdata('stats', 'friend');" src="<?=$prefix.'dial.png'.$suffix;?>">
<input type='image' onmouseover="soundButton();" class="power" onclick="setdata('stats', 'bind');" src="<?=$prefix.'chain.png'.$suffix;?>">
<input type='image' onmouseover="soundButton();" class="power" onclick="setdata('stats', 'tool');" src="<?=$prefix.'dice.png'.$suffix;?>">
<input type='image' onmouseover="soundButton();" class="power" onclick="setdata('stats', 'score');" src="<?=$prefix.'money.png'.$suffix;?>">
</p>
<p align='center' id='tabOper'><?=term('User Operation:', $settings['vocabulary'], $session['units']);?></p><p align='center' id='userStatsAuto'></p>
<p align='center' id='tabScore'><?=term('User Score Tab:', $settings['vocabulary'], $session['units']);?></p><p align='center' id='userStats'></p>
