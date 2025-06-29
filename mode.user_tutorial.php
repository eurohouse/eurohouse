<!-- help -->
<!-- GR: Εγχειρίδιο Χρήσης; CY: Εγχειρίδιο Χρήσης; FR: Manuel d'utilisation; BE: Manuel d'utilisation; DE: Benutzerhandbuch; AT: Benutzerhandbuch; CH: Manualis Usuario; IT: Manuale d'uso; ES: Manual de usuario; MX: Manual de usuario; PT: Manual do utilizador; BR: Manual do usuário; RO: Manual de utilizare; MD: Manual de utilizare; RU: Руководство пользователя; NP: བཀོལ་སྤྱོད་ལག་དེབ།; RS: Упутство за употребу; UA: Посібник користувача; IN: उपयोगकर्ता गाइड; TR: Kullanıcı Kılavuzu; LK: उपयोक्तृपुस्तिका; CN: 用户指南; KR: 지도 시간; JP: チュートリアル; AE: دليل المستخدم. SA: دليل المستخدم. IQ: دليل المستخدم. IR: دليل المستخدم. KW: دليل المستخدم. QA: دليل المستخدم. -->
<!-- <ref> -->
<!-- true -->
<script>
function markdownToHTMLParse() {
    var converter=new showdown.Converter();
    text=markdownTest.value; html=converter.makeHtml(text);
    markdownPage.innerHTML=html;
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
<textarea class="text" id="markdownTest" style="width:100%;height:90%;" onkeydown="if (event.keyCode==27) { this.value=''; }" onchange="markdownToHTMLParse();" oninput="countText();">
    <?=$content;?>
</textarea><br>
<input class="text" id="findbox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) { replacebox.focus();
} else if (event.keyCode==27) { this.value=''; }">
<input class="text" id="replacebox" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode==13) { replaceText(); countText();
} else if (event.keyCode==27) { findbox.focus(); this.value=''; }">
<input type="image" id="textEdRep" onmouseover="soundButton();" class="power" onclick="replaceText(); countText();" src="<?=$prefix[3].'text.png';?>">
<input type="image" id="textEdRepAll" onmouseover="soundButton();" class="power" onclick="replaceTextAll(); countText();" src="<?=$prefix[3].'copy.png';?>">
</p></div>
</div><br>
<label id="statusBar" style="width:98%;"></label>