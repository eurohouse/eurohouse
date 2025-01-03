<!-- note -->
<!-- GR: Σημειώσεις; CY: Σημειώσεις; FR: Remarques; BE: Remarques; DE: Anmerkungen; AT: Anmerkungen; CH: Explorare Notae; IT: Note adesive; ES: Notas adhesivas; MX: Notas adhesivas; PT: Lembretes; BR: Lembretes; RO: Note lipicioase; MD: Note lipicioase; RU: Заметки; NP: སྦྱར་བའི་དྲན་ཐོ།; RS: Напомене; UA: Замітки; IN: स्टिकी नोट; TR: Yapışkan notlar; LK: चिपचिपा टिप्पणियाँ; CN: 便利贴; KR: 부착 노트; JP: ポストイット; AE: ورق ملاحظات -->
<?php if (isAuth()) { ?>
<script>
function newNote() {
    myNotesDoc.value = '';
}
function openNote(id) {
    myNotesEnt.value = id;
    var ci = obfstr(CryptoJS.SHA256(myNotesEnc.value));
    var cd = sysDefNumeric.value;
    myNotesDoc.value = hex2bin(metadata()[bin2hex(id,'',cd)], ci, cd);
}
function saveNote(id) {
    var ci = obfstr(CryptoJS.SHA256(myNotesEnc.value));
    var cd = myNotesRad.value;
    setmeta(bin2hex(id,'',cd), bin2hex(myNotesDoc.value, ci, cd));
}
function deleteNote(id) {
    var cd = sysDefNumeric.value;
    delmeta(bin2hex(id,'',cd));
}
function countNote() {
    var bitsCount = (document.getElementById('myNotesRad').value).length;
    var charsCount = (document.getElementById('myNotesDoc').value).length;
    var statusBar = 'BITS = '+bitsCount+'; CHARS = '+charsCount;
    document.getElementById('numBits').innerHTML = statusBar;
}
</script>
<p align='center' class='block'>
<input class="text" id="myNotesRad" style="width:88%;" type="text" value="<?=$session['numeric'];?>" onkeydown="if (event.keyCode == 13) {
    setdata('numeric', myNotesRad.value);
} else if (event.keyCode == 27) {
    myNotesRad.value = '';
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true); countNote();">
</p>
<p align='center' class='block'>
<input class="text" id="myNotesEnt" style="width:34%;" type="text" value="" onkeydown="if (event.keyCode == 13) {
    myNotesEnc.focus();
} else if (event.keyCode == 27) {
    this.value = '';
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input class="text" id="myNotesEnc" style="width:32%;" type="password" value="" onkeydown="if (event.keyCode == 13) {
    openNote(myNotesEnt.value);
} else if (event.keyCode == 27) {
    this.value = ''; myNotesEnt.focus();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="image" id="myNotesNewBtn" onmouseover="soundButton();" class="power" onclick="newNote();" src="<?=$prefix.'new.png';?>">
<input type="image" id="myNotesOpenBtn" onmouseover="soundButton();" class="power" onclick="openNote(myNotesEnt.value);" src="<?=$prefix.'open.png';?>">
<input type="image" id="myNotesSaveBtn" onmouseover="soundButton();" class="power" onclick="saveNote(myNotesEnt.value);" src="<?=$prefix.'save.png';?>">
</p>
<div class="notesRow">
<div class="notesMenu" id="notesMenu"></div>
<div class="notesContent">
<p align='center'>
<textarea id="myNotesDoc" style="width:100%;height:100%;" placeholder="<?=term('What\'s on your mind...', $settings['vocabulary'], $session['units']);?>" onkeydown="if (event.keyCode == 27) {
    newNote();
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true); countNote();">
</textarea>
</p>
</div>
</div><br>
<label id='numBits' style="width:98%;"></label>
<?php } ?>
