<!-- help -->
<!-- GR: Εγχειρίδιο Χρήσης; CY: Εγχειρίδιο Χρήσης; FR: Manuel d'utilisation; BE: Manuel d'utilisation; DE: Benutzerhandbuch; AT: Benutzerhandbuch; CH: Manualis Usuario; IT: Manuale d'uso; ES: Manual de usuario; MX: Manual de usuario; PT: Manual do utilizador; BR: Manual do usuário; RO: Manual de utilizare; MD: Manual de utilizare; RU: Руководство пользователя; NP: བཀོལ་སྤྱོད་ལག་དེབ།; RS: Упутство за употребу; UA: Посібник користувача; IN: उपयोगकर्ता गाइड; TR: Kullanıcı Kılavuzu; LK: उपयोक्तृपुस्तिका; CN: 用户指南; KR: 지도 시간; JP: チュートリアル; AE: دليل المستخدم. SA: دليل المستخدم. IQ: دليل المستخدم. IR: دليل المستخدم. KW: دليل المستخدم. QA: دليل المستخدم. -->
<script>
function openHelpPage(id) {
    var tutd = jsonstr(sysDefTutorData.value);
    var tutm = (tutd[id]['language'][sysDefUnits.value]['memoir'] !== undefined) ? tutd[id]['language'][sysDefUnits.value]['memoir'] : tutd[id]['memoir'];
    helpContent.innerText = tutm;
}
</script>
<div class="notesRow">
<div class="notesMenu" id="helpMenu"></div>
<div class="notesContent">
<p align='center' id='helpContent'></p>
</div>
</div>