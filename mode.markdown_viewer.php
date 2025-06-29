<!-- help -->
<!-- GR: Προβολή επισημασμένων εγγράφων; CY: Προβολή επισημασμένων εγγράφων; FR: Affichage des documents marqués; BE: Affichage des documents marqués; DE: Markierte Dokumente anzeigen; AT: Markierte Dokumente anzeigen; CH: Documenta signata inspicienda; IT: Visualizzazione dei documenti contrassegnati; ES: Visualización de documentos marcados; MX: Visualización de documentos marcados; PT: Visualização de documentos marcados; BR: Visualizando documentos marcados; RO: Vizualizarea documentelor marcate; MD: Vizualizarea documentelor marcate; RU: Просмотр размеченных документов; NP: རྟགས་བཀོད་པའི་ཡིག་ཆ་ལ་བལྟ་བ།; RS: Преглед означених докумената; UA: Перегляд розмічених документів; IN: चिह्नित दस्तावेज़ देखना; TR: İşaretli belgeleri görüntüleme; LK: चिह्नितदस्तावेजान् दृष्ट्वा; CN: 查看标记的文档; KR: 표시된 문서 보기; JP: マークされた文書の表示; AE: عرض المستندات المميزة; SA: عرض المستندات المميزة; IQ: عرض المستندات المميزة; IR: عرض المستندات المميزة; KW: عرض المستندات المميزة; QA: عرض المستندات المميزة; -->
<!-- <ref> -->
<!-- true -->
<script>
function markdownToHTMLParse() {
    var converter=new showdown.Converter();
    text=markdownTest.value; html=converter.makeHtml(text);
    markdownPage.innerHTML=html;
    countText();
}
function replaceText() {
    var str=markdownTest.value;
    var stri=findbox.value;
    var stro=replacebox.value;
    var strp=str.toString().replace(stri,stro);
    markdownTest.value=strp; countText();
}
function replaceTextAll() {
    var str=markdownTest.value;
    var stri=findbox.value;
    var stro=replacebox.value;
    var strp=str.toString().replaceAll(stri,stro);
    markdownTest.value=strp; countText();
}
function countText() {
    var sourceText=markdownTest.value;
    var charsCount=sourceText.length;
    var linesCount=sourceText.split(/\r?\n/).length;
    var wordsCount=sourceText.split(/ /).length;
    statusBar.innerHTML='CHARS = '+charsCount+'; LINES = '+linesCount+'; WORDS = '+wordsCount;
}
</script>
<?php if ($request['lock']!='true') {
    if (file_exists($request['input'])) {
        $content=file_get_contents($request['input']);
    }
} ?>
<div class="bivalviaRow">
<div class="bivalviaLeft" id="markdownPage"></div>
<div class="bivalviaRight">
<p align='center'>
<textarea class="text" id="markdownTest" style="width:100%;height:90%;" onkeydown="if (event.keyCode==27) { this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true); markdownToHTMLParse();"><?=$content;?></textarea><br>
<input class="text" id="findbox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) { replacebox.focus();
} else if (event.keyCode==27) { this.value=''; markdownToHTMLParse();
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true);">
<input class="text" id="replacebox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) { replaceText(); markdownToHTMLParse();
} else if (event.keyCode==27) { findbox.focus(); this.value='';
} else if (event.keyCode==8) { handleInput(this.value);
} else if (event.keyCode==46) { handleInput(this.value); }" oninput="handleInput(this.value,true);">
<input type="image" id="textEdRep" onmouseover="soundButton();" class="power" onclick="replaceText(); markdownToHTMLParse();" src="<?=$prefix[3].'text.png';?>">
<input type="image" id="textEdRepAll" onmouseover="soundButton();" class="power" onclick="replaceTextAll(); markdownToHTMLParse();" src="<?=$prefix[3].'copy.png';?>">
</p></div>
</div><br>
<label id="statusBar" style="width:98%;"></label>