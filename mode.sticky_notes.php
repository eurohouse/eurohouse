<!-- note -->
<!-- GR: Σημειώσεις; CY: Σημειώσεις; FR: Remarques; BE: Remarques; DE: Anmerkungen; AT: Anmerkungen; CH: Explorare Notae; IT: Note adesive; ES: Notas adhesivas; MX: Notas adhesivas; PT: Lembretes; BR: Lembretes; RO: Note lipicioase; MD: Note lipicioase; RU: Заметки; NP: སྦྱར་བའི་དྲན་ཐོ།; RS: Напомене; UA: Замітки; IN: स्टिकी नोट; TR: Yapışkan notlar; LK: चिपचिपा टिप्पणियाँ; CN: 便利贴; KR: 부착 노트; JP: ポストイット; AE: ورق ملاحظات -->
<?php if (isAuth()) { ?>
<p align='center' class='block'>
<input class="text" id="myNotesEnt" style="width:40%;" type="text" value="<?=$session['current_entry'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('current_entry', myNotesEnt.value);
    window.location.reload();
} else if (event.keyCode == 27) {
    this.value = '';
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="image" onmouseover="soundButton();" class="power" onclick="setdata('current_entry', myNotesEnt.value); setmeta(myNotesEnt.value, bin2hex('')); window.location.reload();" src="<?=$prefix.'new.png'.$suffix;?>">
<input type="image" onmouseover="soundButton();" class="power" onclick="setdata('current_entry', myNotesEnt.value); window.location.reload();" src="<?=$prefix.'open.png'.$suffix;?>">
<input type="image" onmouseover="soundButton();" class="power" onclick="setdata('current_entry', myNotesEnt.value); setmeta(myNotesEnt.value, bin2hex(myNotesDoc.value)); window.location.reload();" src="<?=$prefix.'save.png'.$suffix;?>">
<input type="image" onmouseover="soundButton();" class="power" onclick="setdata('current_entry', myNotesEnt.value); delmeta(myNotesEnt.value); window.location.reload();" src="<?=$prefix.'delete.png'.$suffix;?>">
</p>
<div class="notesRow">
<div class="notesMenu">
<p align='center'>
<?php foreach ($metadata as $key=>$val) { ?>
    <input type="button" style="width:100%;" name="<?=$key;?>" onmouseover="soundButton();" onclick="setdata('current_entry', this.name); window.location.reload();" value="<?=$key;?>"><br>
<?php } ?>
</p>
</div>
<div class="notesContent">
<p align='center'>
<textarea id="myNotesDoc" style="width:78%;height:60%;" placeholder="<?=term('What\'s on your mind...', $settings['vocabulary'], $session['units']);?>" onkeydown="if (event.keyCode == 27) {
    myNotesDoc.value = '';
    setmeta(myNotesEnt.value, bin2hex(''));
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<?=dat($metadata[$session['current_entry']]);?></textarea>
</p>
</div>
</div>
<?php } ?>
