<!-- note -->
<!-- GR: Σημειώσεις; CY: Σημειώσεις; FR: Remarques; BE: Remarques; DE: Anmerkungen; AT: Anmerkungen; CH: Explorare Notae; IT: Note adesive; ES: Notas adhesivas; MX: Notas adhesivas; PT: Lembretes; BR: Lembretes; RO: Note lipicioase; MD: Note lipicioase; RU: Заметки; NP: སྦྱར་བའི་དྲན་ཐོ།; RS: Напомене; UA: Замітки; IN: स्टिकी नोट; TR: Yapışkan notlar; LK: चिपचिपा टिप्पणियाँ; CN: 便利贴; KR: 부착 노트; JP: ポストイット; AE: ورق ملاحظات -->
<?php if (isAuthorized()) { ?>
<script>
function newNote() { myNotesDoc.value='';countNote(); }
function openNote(id) {
    myNotesEnt.value=id; var ci=obfstr(CryptoJS.SHA256(myNotesEnc.value));
    var cd=sysDefNumeric.value; myNotesDoc.value=decode(metadata()[encode(id,'',cd)],ci,cd);
    countNote();
}
function saveNote(id) {
    var ci=obfstr(CryptoJS.SHA256(myNotesEnc.value));
    var cd=myNotesRad.value; setmeta(encode(id,'',cd),encode(myNotesDoc.value,ci,cd));
}
function deleteNote(id) {
    var cd=sysDefNumeric.value;delmeta(encode(id,'',cd));
}
function countNote() {
    var sourceChars=document.getElementById('myNotesRad').value;
    var sourceText=document.getElementById('myNotesDoc').value;
    var bitsCount=sourceChars.length;
    var charsCount=sourceText.length;
    var linesCount=sourceText.split(/\r?\n/).length;
    var wordsCount=sourceText.split(/ /).length;
    var statusBar='BITS = '+bitsCount+'; CHARS = '+charsCount+'; LINES = '+linesCount+'; WORDS = '+wordsCount;
    document.getElementById('numBits').innerHTML=statusBar;
}
</script>
<p align='center' class='block'>
<input class="text" id="myNotesRad" style="width:65%;" type="text" placeholder="<?=term('Symbolic Digits',$settings,$session);?>" value="<?=$session['numeric'];?>" onkeydown="if (event.keyCode==13) {
    setdata('numeric',myNotesRad.value);
} else if (event.keyCode==27) { myNotesRad.value=''; countNote();
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value,true); countNote();">
<input type="image" id="myNotesApplyBtn" onmouseover="soundButton();" class="power" onclick="setdata('numeric', myNotesRad.value);" src="<?=$prefix[3].'return.png';?>">
<input type="image" id="myNotesKbdBtn" onmouseover="soundButton();" class="power" onclick="myNotesRad.focus();" src="<?=$prefix[3].'keyboard.png';?>">
<input type="image" id="myNotesResetBtn" onmouseover="soundButton();" class="power" onclick="myNotesRad.value=''; countNote();" src="<?=$prefix[3].'backspace.png';?>">
</p>
<p align='center' class='block'>
<input class="text" id="myNotesEnt" style="width:34%;" type="text" placeholder="<?=term('Title',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { myNotesEnc.focus();
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input class="text" id="myNotesEnc" style="width:32%;" type="password" placeholder="<?=term('Password',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { openNote(myNotesEnt.value);
} else if (event.keyCode==27) { this.value=''; myNotesEnt.focus();
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="image" id="myNotesNewBtn" onmouseover="soundButton();" class="power" onclick="newNote();" src="<?=$prefix[3].'new.png';?>">
<input type="image" id="myNotesOpenBtn" onmouseover="soundButton();" class="power" onclick="openNote(myNotesEnt.value);" src="<?=$prefix[3].'open.png';?>">
<input type="image" id="myNotesSaveBtn" onmouseover="soundButton();" class="power" onclick="saveNote(myNotesEnt.value);" src="<?=$prefix[3].'save.png';?>">
</p>
<div class="notesRow">
<div class="notesMenu" id="notesMenu"></div>
<div class="notesContent">
<p align='center'>
<textarea id="myNotesDoc" style="width:100%;height:100%;" placeholder="<?=term('',$settings,$session);?>" onkeydown="if (event.keyCode==27) {
    newNote();
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value,true); countNote();" onchange="countNote();"></textarea>
</p>
</div>
</div><br>
<label id='numBits' style="width:98%;"></label>
<?php } ?>
