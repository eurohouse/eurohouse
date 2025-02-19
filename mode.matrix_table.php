<!-- access -->
<!-- GR: Πίνακας Μήτρας; DE: Matrixtabelle; AT: Matrixtabelle; CY: Πίνακας Μήτρας; CH: Matrix Mensa; ES: Mesa Matricial; MX: Mesa Matricial; FR: Tableau Matriciel; BE: Tableau Matriciel; TR: Matris Tablosu; IT: Tabella Matrice; RO: Tabelul Matricei; MD: Tabelul Matricei; LK: मैट्रिक्स सारणी; IN: मैट्रिक्स तालिका; RU: Матричная таблица; RS: Табела матрица; NP: མེ་ཊིག་སི་རེའུ་མིག; BR: Tabela de Matriz; PT: Tabela de Matriz; UA: Матрична таблиця; CN: 用户特定矩阵表; KR: 매트릭스 테이블; JP: マトリックステーブル; AE: جدول المصفوفات -->
<?php if (isAuth()) { ?>
<script>
function mapleExec(input) {
    var mc=input.split(': ');
    var ma=mc[0],md=mc[1].split(' = ');
    ordarr(sysDefSessionID.value+'_maple.json','add',ma+'/'+md[0],md[1]); window.location.reload();
}
function mapleDel(id) {
    ordarr(sysDefSessionID.value+'_maple.json','drop',id,''); window.location.reload();
}
</script>
<?php $maple=arropen($sessionID.'_maple.json'); ?>
<p align='center' class='block'>
<input class="text" id="mapleCmd" style="width:65%;" type="text" value="" onkeydown="if (event.keyCode == 13) { mapleExec(mapleCmd.value); } else if (event.keyCode == 27) { mapleCmd.value='';
} else if (event.keyCode == 8) { handleInput(this.value);
} else if (event.keyCode == 46) { handleInput(this.value);
}" oninput="handleInput(this.value,true);">
<input type="image" id="mapleExec" onmouseover="soundButton();" class="power" onclick="mapleExec(mapleCmd.value);" src="<?=$prefix.'return.png';?>">
<input type="image" id="mapleExec" onmouseover="soundButton();" class="power" onclick="mapleCmd.focus();" src="<?=$prefix.'keyboard.png';?>">
<input type="image" id="mapleExec" onmouseover="soundButton();" class="power" onclick="mapleCmd.value=''; mapleCmd.focus();" src="<?=$prefix.'backspace.png';?>">
</p>
<table id="maple" style="width:100%;">
<thead>
    <th>
        <?php foreach ($maple[array_key_first($maple)] as $eno=>$prp) { ?><td><?=$eno;?></td><?php } ?>
    </th>
</thead>
<tbody>
    <?php foreach ($maple as $key=>$ent) { ?>
    <tr>
        <td><a href="javascript:clp(&#34;<?=$key;?>&#34;);"><?=$key;?></a> <input type="image" name="<?=$key;?>" onmouseover="soundButton();" class="power" onclick="mapleDel(this.name);" src="<?=$prefix.'delete.png';?>"></td>
        <?php foreach ($ent as $eno=>$val) { ?>
            <td><?=$val;?></td>
        <?php } ?>
    </tr>
    <?php } ?>
</tbody>
</table>
<?php } ?>