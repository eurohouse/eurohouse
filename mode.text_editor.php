<!-- text -->
<!-- GR: Συντακτικό; CY: Συντακτικό; FR: Éditeur de texte; BE: Éditeur de texte; DE: Texteditor; AT: Texteditor; CH: Compositor Textum; IT: Editor de text; ES: Editor de texto; MX: Editor de texto; PT: Editor de texto; BR: Editor de texto; RO: Editor de text; MD: Editor de text; RU: Текстовый редактор; NP: ཡི་གེ་རྩོམ་སྒྲིག་པ།; RS: Текст едитор; UA: Текстовий редактор; IN: पाठ संपादक; TR: Metin düzeltici; LK: पाठ सम्पादक; CN: 文本编辑器; KR: 텍스트 에디터; JP: テキスト編集者; AE: محرر النص -->
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
        $content=file_get_contents($request['input']);
    }
} $newDocumentIcon=$themePrefix.'new.png';
$openDocumentIcon=$themePrefix.'open.png';
$saveDocumentIcon=$themePrefix.'save.png';
$filmDocumentIcon=$themePrefix.'video.png';
$mkdirDocumentIcon=$themePrefix.'mkdir.png';
$moveDocumentIcon=$themePrefix.'move.png';
$dbDocumentIcon=$themePrefix.'database.png';
$copyDocumentIcon=$themePrefix.'copy.png';
$deleteDocumentIcon=$themePrefix.'trash.png';
$infoDocumentIcon=$themePrefix.'info.png';
$homeDocumentIcon=$themePrefix.'home.png'; ?>
<p align='center' class='block'>
<img style="width:10%;position:relative;" loading="lazy" src="<?=$newDocumentIcon;?>" onmouseover="soundButton();" id="newButton" onclick="content.value=''; countText();">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$openDocumentIcon;?>" onmouseover="soundButton();" id="openButton" onclick="omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$saveDocumentIcon;?>" onmouseover="soundButton();" id="saveButton" onclick="set(filename.value,encodeURIComponent(content.value),sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$mkdirDocumentIcon;?>" onmouseover="soundButton();" id="mkdirButton" onclick="mkdir(filename.value,sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$moveDocumentIcon;?>" onmouseover="soundButton();" id="moveButton" onclick="move(filename.value,doto.value,sysDefSessionID.value); omniRead(requestMode.value,doto.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$copyDocumentIcon;?>" onmouseover="soundButton();" id="copyButton" onclick="copy(filename.value,doto.value,sysDefSessionID.value); omniRead(requestMode.value,doto.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$deleteDocumentIcon;?>" onmouseover="soundButton();" id="deleteButton" onclick="del(filename.value,sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');">
<img style="width:10%;position:relative;" loading="lazy" src="<?=$homeDocumentIcon;?>" onmouseover="soundButton();" id="homeButton" onclick="omniBack(sysDefParent.value);">
</p>
<p align='center' class='block'>
<input class="text" id="filename" name="<?=$request['mode'];?>" style="width:45%;" type="text" placeholder="<?=term('Name',$settings,$session);?>" value="<?=$request['input'];?>" onkeydown="if (event.keyCode==13) {
    omniRead(requestMode.value,filename.value,'false');
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==113) {
    set(filename.value,encodeURIComponent(content.value),sysDefSessionID.value); omniRead(requestMode.value,filename.value,'false');
}">
<input class="text" id="doto" name="<?=$request['mode'];?>" style="width:45%;" type="text" placeholder="<?=term('Name',$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
    copy(filename.value,doto.value,sysDefSessionID.value);
    omniRead(requestMode.value,doto.value,'false');
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==113) {
    move(filename.value,doto.value,sysDefSessionID.value);
    omniRead(requestMode.value,doto.value,'false');
}">
</p>
<p align='center' class='block'>
<textarea class="text" id="content" style="width:100%;height:50%;" onkeydown="if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true); countText();"><?=$content;?></textarea>
<br>
<input class="text" id="findbox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) {
    replacebox.focus();
} else if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true);">
<input class="text" id="replacebox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) {
    replaceText(); countText();
} else if (event.keyCode==27) { findbox.focus(); this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true);">
<input type="image" id="textEditRepOne" onmouseover="soundButton();" class="power" onclick="replaceText(); countText();" src="<?=$prefix[3].'text.png';?>">
<input type="image" id="textEditRepAll" onmouseover="soundButton();" class="power" onclick="replaceTextAll(); countText();" src="<?=$prefix[3].'copy.png';?>"><br>
<label id="statusBar" style="width:98%;"></label>
</p><?php } ?>
