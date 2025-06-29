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
<div class="markdownRow">
<div class="markdownPage" id="markdownPage"></div>
<div class="markdownContent">
<p align='center'>
    <textarea class="text" id="markdownTest" style="width:100%;height:100%;" onkeydown="if (event.keyCode==27) { this.value=''; }" onchange="markdownToHTMLParse();" oninput="countText();">
        <?=$content;?>
    </textarea>
</p>
</div>
</div>
<label id="statusBar" style="width:98%;"></label>