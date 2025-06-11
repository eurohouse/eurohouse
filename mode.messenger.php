<!-- mail -->
<!-- GR: Αμεσα μηνύματα; CY: Αμεσα μηνύματα; IT: Messaggi istantanei; DE: Sofortnachrichten; AT: Sofortnachrichten; FR: Messaggi istantanei; BE: Messaggi istantanei; CH: Epistulae Momentum; ES: Mensajes instantáneos; MX: Mensajes instantáneos; IN: त्वरित संदेश; LK: तत्क्षणिकसन्देशाः; UA: Миттєві повідомлення; PT: Mensagens instantâneas; BR: Mensagens instantâneas; RO: Mesaje instant; MD: Mesaje instant; TR: Anlık mesajlar; RU: Мгновенные сообщения; NP: ལམ་སེང་འཕྲིན་འཕྲིན།; CN: 即时通讯聊天; KR: 커뮤니케이션 채팅; JP: 通信チャット; AE: رسالة فورية -->
<?php if (isAuthorized()) { ?>
<div class='customPanel'>
<p align='center' class='block'>
<input type="text" id="composeMessage" style="width:54%;" placeholder="<?=term('',$settings,$session);?>" value="" onkeydown="if (event.keyCode == 13) {
    compose(sysDefSessionID.value,composeMessage.value);
} else if (event.keyCode==27) {
    document.getElementById('composeMessage').value='';
} else if (event.keyCode==8) {
    handleInput(this.value);
} else if (event.keyCode==46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'return.png';?>" onclick="compose(sysDefSessionID.value,composeMessage.value);">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="document.getElementById('composeMessage').focus();">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('composeMessage').value = ''; document.getElementById('composeMessage').focus();"></p>
</div><?php } ?>
<div class='customPanel' id='msgBox' style="width:100%;height:85%;left:0px;top:0px;overflow-y:scroll;">
</div>