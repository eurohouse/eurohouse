<!-- note -->
<!-- AD: Notas adhesivas; AE: ورق ملاحظات; AG: Notas adhesivas; AT: Anmerkungen; BE: Remarques; BR: Lembretes; CH: Explorare Notae; CL: Notas adhesivas; CN: 便利贴; CO: Notas adhesivas; CU: Notas adhesivas; CY: Σημειώσεις; DD: Anmerkungen; DE: Anmerkungen; DR: Anmerkungen; ES: Notas adhesivas; FR: Remarques; GR: Σημειώσεις; IN: स्टिकी नोट; IQ: ورق ملاحظات; IR: ورق ملاحظات; IT: Note adesive; JP: ポストイット; KP: 부착 노트; KR: 부착 노트; KW: ورق ملاحظات; LK: चिपचिपा टिप्पणियाँ; MC: Remarques; MD: Note lipicioase; MX: Notas adhesivas; NP: སྦྱར་བའི་དྲན་ཐོ།; PT: Lembretes; QA: ورق ملاحظات; RO: Note lipicioase; RS: Напомене; RU: Заметки; SA: ورق ملاحظات; SM: Note adesive; SP: Explorare Notae; TR: Yapışkan notlar; UA: Замітки; VA: Explorare Notae -->
<?php if (isAuthorized()) { ?>
<script>
function newNote() { myNotesDoc.value=''; countNote(); }
function openNote(id) {
    myNotesEnt.value=id; var obf=obfstr(CryptoJS.SHA256(myNotesEnc.value));
    var num=sysDefNumeric.value; var sep=sysDefSeparator.value;
    myNotesDoc.value=caesar.decode(metadata()[caesar.encode(id,'',num,sep)],obf,num,sep); countNote();
}
function saveNote(id) {
    var obf=obfstr(CryptoJS.SHA256(myNotesEnc.value));
    var num=myNotesRad.value; var sep=myNotesSep.value;
    setmeta(caesar.encode(id,'',num,sep),caesar.encode(myNotesDoc.value,obf,num,sep));
}
function deleteNote(id) {
    var num=sysDefNumeric.value; var sep=sysDefSeparator.value;
    delmeta(caesar.encode(id,'',num,sep));
}
function replaceNote() {
    var str=myNotesDoc.value; var stri=findbox.value;
    var stro=replacebox.value; var strp=str.toString().replace(stri,stro);
    myNotesDoc.value=strp; countText();
}
function replaceNoteAll() {
    var str=myNotesDoc.value; var stri=findbox.value;
    var stro=replacebox.value; var strp=str.toString().replaceAll(stri,stro);
    myNotesDoc.value=strp; countText();
}
function countNote() {
    var sourceChars=myNotesRad.value; var sourceText=myNotesDoc.value;
    var bitsCount=sourceChars.length; var charsCount=sourceText.length;
    var linesCount=sourceText.split(/\r?\n/).length; var wordsCount=sourceText.split(/ /).length;
    var statusBar='BITS = '+bitsCount+'; CHARS = '+charsCount+'; LINES = '+linesCount+'; WORDS = '+wordsCount; numBits.innerHTML=statusBar;
}
</script>
<p align='center' class='block'>
    <input class="text" id="myNotesRad" style="width:58%;" type="text" placeholder="<?=term('Symbolic Digits',$settings,$session);?>" value="<?=$session['numeric'];?>" onkeydown="if (event.keyCode==13) {
        setdata('numeric',this.value);
    } else if (event.keyCode==27) { this.value=''; countNote();
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true); countNote();">
    <input class="text" id="myNotesSep" style="width:12%;" type="text" placeholder="<?=term('Separator',$settings,$session);?>" value="<?=$session['separator'];?>" onkeydown="if (event.keyCode==13) {
        setdata('separator',this.value);
    } else if (event.keyCode==27) { this.value=''; countNote();
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true); countNote();">
    <input type="image" id="buttonEnter" onmouseover="soundButton();" class="power" onclick="soundClick(); setdata('numeric',myNotesRad.value); setdata('separator',myNotesSep.value);" src="<?=$prefix[3].'return.png';?>">
    <input type="image" id="buttonBackspace" onmouseover="soundButton();" class="power" onclick="soundClick(); myNotesRad.value=''; myNotesSep.value=''; countNote();" src="<?=$prefix[3].'backspace.png';?>">
</p>
<p align='center' class='block'>
<input class="text" id="myNotesEnt" style="width:34%;" type="text" placeholder="<?=term('Title',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { myNotesEnc.focus();
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value,true);">
<input class="text" id="myNotesEnc" style="width:32%;" type="password" placeholder="<?=term('Password',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { openNote(myNotesEnt.value);
} else if (event.keyCode==27) { this.value=''; myNotesEnt.focus();
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value,true);">
<input type="image" id="buttonNew" onmouseover="soundButton();" class="power" onclick="soundClick(); newNote();" src="<?=$prefix[3].'new.png';?>">
<input type="image" id="buttonOpen" onmouseover="soundButton();" class="power" onclick="soundClick(); openNote(myNotesEnt.value);" src="<?=$prefix[3].'open.png';?>">
<input type="image" id="buttonSave" onmouseover="soundButton();" class="power" onclick="soundClick(); saveNote(myNotesEnt.value);" src="<?=$prefix[3].'save.png';?>">
</p>
<div class="bivalviaRow">
<div class="bivalviaLeft" id="notesMenu"></div>
<div class="bivalviaRight">
<p align='center' class='block'>
<textarea id="myNotesDoc" style="width:100%;height:80%;" placeholder="<?=term('',$settings,$session);?>" onkeydown="if (event.keyCode==27) {
    newNote();
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value);
}" oninput="handleInput(this.value,true); countNote();" onchange="countNote();"></textarea><br>
<input class="text" id="findbox" style="width:26%;" type="text" value="" onkeydown="if (event.keyCode==13) { replacebox.focus();
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }">
<input class="text" id="replacebox" style="width:26%;" type="text" value="" onkeydown="if (event.keyCode==13) { replaceNote(); countText();
} else if (event.keyCode==27) { findbox.focus(); this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }">
<input type="image" id="buttonReplace" onmouseover="soundButton();" class="power" onclick="soundClick(); replaceNote(); countText();" oninput="handleInput(this.value,true);" src="<?=$prefix[3].'text.png';?>">
<input type="image" id="buttonReplaceAll" onmouseover="soundButton();" class="power" onclick="soundClick(); replaceNoteAll(); countText();" oninput="handleInput(this.value,true);" src="<?=$prefix[3].'copy.png';?>">
</p></div>
</div><br>
<label id='numBits' style="width:98%;"></label>
<?php } ?>
