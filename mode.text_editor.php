<!-- text -->
<!-- AD: Editor de texto; AE: محرر النص; AG: Editor de texto; AT: Texteditor; BE: Éditeur de texte; BR: Editor de texto; CH: Compositor Textum; CL: Editor de texto; CN: 文本编辑器; CO: Editor de texto; CU: Editor de texto; CY: Συντακτικό; DD: Texteditor; DE: Texteditor; DR: Texteditor; ES: Editor de texto; FR: Éditeur de texte; GR: Συντακτικό; IN: पाठ संपादक; IQ: محرر النص; IR: محرر النص; IT: Editor de text; JP: テキスト編集者; KP: 텍스트 에디터; KR: 텍스트 에디터; KW: محرر النص; LK: पाठ सम्पादक; MC: Éditeur de texte; MD: Editor de text; MX: Editor de texto; NP: ཡི་གེ་རྩོམ་སྒྲིག་པ།; PT: Editor de texto; QA: محرر النص; RO: Editor de text; RS: Текст едитор; RU: Текстовый редактор; SA: محرر النص; SM: Editor de text; SP: Compositor Textum; TR: Metin düzeltici; UA: Текстовий редактор; VA: Compositor Textum -->
<!-- <ref> -->
<!-- true -->
<?php if (isAuthorized()) { ?>
<script>
function replaceText() {
    var str=document.getElementById('content').value;
    var stri=document.getElementById('findbox').value;
    var stro=document.getElementById('replacebox').value;
    var strp=str.toString().replace(stri,stro);
    document.getElementById('content').value=strp;
    countText();
}
function replaceTextAll() {
    var str=document.getElementById('content').value;
    var stri=document.getElementById('findbox').value;
    var stro=document.getElementById('replacebox').value;
    var strp=str.toString().replaceAll(stri,stro);
    document.getElementById('content').value=strp;
    countText();
}
function countText() {
    var sourceText=document.getElementById('content').value;
    var charsCount=sourceText.length;
    var linesCount=sourceText.split(/\r?\n/).length;
    var wordsCount=sourceText.split(/ /).length;
    document.getElementById('statusBar').innerHTML='CHARS = '+charsCount+'; LINES = '+linesCount+'; WORDS = '+wordsCount;
}
</script>
<?php if ($request['lock']!='true') {
    if (file_exists($request['input'])) {
	if (!str_starts_with(basename($request['input']),'.')) {
	    $content=file_get_contents($request['input']);
	}
    }
} $newDocumentIcon=$themePrefix.'new.webp';
$openDocumentIcon=$themePrefix.'open.webp';
$saveDocumentIcon=$themePrefix.'save.webp';
$filmDocumentIcon=$themePrefix.'video.webp';
$mkdirDocumentIcon=$themePrefix.'mkdir.webp';
$moveDocumentIcon=$themePrefix.'move.webp';
$dbDocumentIcon=$themePrefix.'database.webp';
$copyDocumentIcon=$themePrefix.'copy.webp';
$deleteDocumentIcon=$themePrefix.'trash.webp';
$infoDocumentIcon=$themePrefix.'info.webp';
$homeDocumentIcon=$themePrefix.'home.webp'; ?>
<p align='center' class='block'>
<img style="width:10%;position:relative;" loading="lazy" src="<?=$newDocumentIcon;?>" onmouseover="soundButton();" id="newButton" onclick="soundClick(); content.value=''; countText();">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$openDocumentIcon;?>" onmouseover="soundButton();" id="openButton" onclick="soundClick(); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$saveDocumentIcon;?>" onmouseover="soundButton();" id="saveButton" onclick="soundClick(); set(filename.value,encodeURIComponent(content.value),sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$mkdirDocumentIcon;?>" onmouseover="soundButton();" id="mkdirButton" onclick="soundClick(); mkdir(filename.value,sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$moveDocumentIcon;?>" onmouseover="soundButton();" id="moveButton" onclick="soundClick(); move(filename.value,doto.value,sysDefSessionID.value); omniRead(requestMode.value,doto.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$copyDocumentIcon;?>" onmouseover="soundButton();" id="copyButton" onclick="soundClick(); copy(filename.value,doto.value,sysDefSessionID.value); omniRead(requestMode.value,doto.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$deleteDocumentIcon;?>" onmouseover="soundButton();" id="deleteButton" onclick="soundClick(); del(filename.value,sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$homeDocumentIcon;?>" onmouseover="soundButton();" id="homeButton" onclick="soundClick(); omniBack(sysDefParent.value);">
</p>
<p align='center' class='block'>
<input class="text" id="filename" name="<?=$request['mode'];?>" style="width:45%;" type="text" placeholder="<?=term('Name',$settings,$session);?>" value="<?=$request['input'];?>" onkeydown="if (event.keyCode==13) {
    omniRead(requestMode.value,this.value,'false');
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==113) {
    set(this.value,encodeURIComponent(content.value),sysDefSessionID.value); omniRead(requestMode.value,this.value,'false');
}">
<input class="text" id="doto" name="<?=$request['mode'];?>" style="width:45%;" type="text" placeholder="<?=term('Name',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
    copy(filename.value,this.value,sysDefSessionID.value);
    omniRead(requestMode.value,this.value,'false');
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==113) {
    move(filename.value,this.value,sysDefSessionID.value);
    omniRead(requestMode.value,this.value,'false');
}">
</p>
<p align='center' class='block'>
<textarea class="text" id="content" style="width:100%;height:50%;" onkeydown="if (event.keyCode==27) {
	this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true); countText();">
<?=$content;?>
</textarea>
<br>
<input class="text" id="findbox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) {
    replaceText(); countText();
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true);">
<input class="text" id="replacebox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) {
    replaceText(); countText();
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true);">
<input type="image" id="textEditRepOne" onmouseover="soundButton();" id="buttonReplace" class="power" onclick="soundClick(); replaceText(); countText();" src="<?=$prefix[3].'text.webp';?>">
<input type="image" id="textEditRepAll" onmouseover="soundButton();" id="buttonReplaceAll" class="power" onclick="soundClick(); replaceTextAll(); countText();" src="<?=$prefix[3].'copy.webp';?>"><br>
<label id="statusBar" style="width:98%;"></label>
</p><?php } ?>
