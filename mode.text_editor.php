<!-- text -->
<!-- GR: Επεξεργαστής κειμένου; CY: Επεξεργαστής κειμένου; FR: Éditeur de texte; BE: Éditeur de texte; DE: Texteditor; AT: Texteditor; CH: Compositor Textum; IT: Editor de text; ES: Editor de texto; MX: Editor de texto; PT: Editor de texto; BR: Editor de texto; RO: Editor de text; MD: Editor de text; RU: Текстовый редактор; NP: ཡི་གེ་རྩོམ་སྒྲིག་པ།; RS: Текст едитор; UA: Текстовий редактор; IN: पाठ संपादक; TR: Metin düzeltici; LK: पाठ सम्पादक; CN: 文本编辑器; KR: 텍스트 에디터; JP: テキスト編集者; AE: محرر النص -->
<!-- <ref> -->
<!-- true -->
<script>
function replaceText(stri) {
    var str = document.getElementById('content').value;
    var stro = document.getElementById('replacebox').value;
    var strp = str.toString().replace(stri, stro);
    document.getElementById('content').value = strp;
    countText();
}
function replaceTextAll(stri) {
    var str = document.getElementById('content').value;
    var stro = document.getElementById('replacebox').value;
    var strp = str.toString().replaceAll(stri, stro);
    document.getElementById('content').value = strp;
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
<img style="width:9%;position:relative;" loading="lazy" src="<?=$newDocumentIcon;?>" onmouseover="soundButton();" id="newButton" onclick="text.value=''; countText();">
<img style="width:9%;position:relative;" loading="lazy" src="<?=$openDocumentIcon;?>" onmouseover="soundButton();" id="openButton" onclick="omniRead(requestMode.value,filename.value,'false');">
<?php if (isUserRoot()) { ?>
    <img style="width:9%;position:relative;" loading="lazy" src="<?=$saveDocumentIcon;?>" onmouseover="soundButton();" id="saveButton" onclick="set(filename.value,encodeURIComponent(content.value),sysDefSessionID.value,'r');">
<?php } else { ?>
    <img style="width:9%;position:relative;" loading="lazy" src="<?=$filmDocumentIcon;?>" onmouseover="soundButton();" id="filmButton" onclick="omniRead('media_player',filename.value,'true');">
<?php } ?>
<img style="width:9%;position:relative;" loading="lazy" src="<?=$mkdirDocumentIcon;?>" onmouseover="soundButton();" id="mkdirButton" onclick="mkdir(filename.value,sysDefSessionID.value,'r');">
<?php if (isUserRoot()) { ?>
    <img style="width:9%;position:relative;" loading="lazy" src="<?=$moveDocumentIcon;?>" onmouseover="soundButton();" id="moveButton" onclick="move(filename.value,doto.value,sysDefSessionID.value,'r');">
<?php } else { ?>
    <img style="width:9%;position:relative;" loading="lazy" src="<?=$dbDocumentIcon;?>" onmouseover="soundButton();" id="dbButton" onclick="omniPath(filename.value,'','false');">
<?php } ?>
<img style="width:9%;position:relative;" loading="lazy" src="<?=$copyDocumentIcon;?>" onmouseover="soundButton();" id="copyButton" onclick="copy(filename.value,doto.value,sysDefSessionID.value,'r');">
<?php if (isUserRoot()) { ?>
    <img style="width:9%;position:relative;" loading="lazy" src="<?=$deleteDocumentIcon;?>" onmouseover="soundButton();" id="deleteButton" onclick="del(filename.value,sysDefSessionID.value,'r');">
<?php } else { ?>
    <img style="width:9%;position:relative;" loading="lazy" src="<?=$infoDocumentIcon;?>" onmouseover="soundButton();" id="infoButton" onclick="omniPath(filename.value,'','true');">
<?php } ?>
<img style="width:9%;position:relative;" loading="lazy" src="<?=$homeDocumentIcon;?>" onmouseover="soundButton();" id="homeButton" onclick="omniBack('<?=$parent?>');"><br>
<input class="text" id="filename" name="<?=$request['mode'];?>" style="width:50%;" type="text" value="<?=$request['input'];?>" onkeydown="if (event.keyCode==13) { doto.focus();
} else if (event.keyCode==27) { this.value=''; }">
<input class="text" id="doto" name="<?=$request['mode'];?>" style="width:50%;" type="text" value="" onkeydown="if (event.keyCode==13) {
    if ((superuser())&&(this.value!='')) { saveGUI(); } else {
    omniRead(this.name,filename.value,'false');countText(); }
} else if (event.keyCode==27) { filename.focus(); this.value='';
} else if (event.keyCode==113) { this.value=filename.value;
}"><textarea class="text" id="content" style="width:100%;height:50%;" oninput="countText();"><?=$content;?></textarea><br>
<input class="text" id="findbox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) { replacebox.focus();
} else if (event.keyCode==27) { this.value=''; }">
<input class="text" id="replacebox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) {
    replaceText(findbox.value); countText();
} else if (event.keyCode==27) { findbox.focus();this.value=''; }">
<input type="image" id="textEdRep" onmouseover="soundButton();" class="power" onclick="replaceText(findbox.value); countText();" src="<?=$prefix[3].'text.png';?>">
<input type="image" id="textEdRepAll" onmouseover="soundButton();" class="power" onclick="replaceTextAll(findbox.value); countText();" src="<?=$prefix[3].'copy.png';?>">
<br><label id="statusBar" style="width:98%;"></label>
