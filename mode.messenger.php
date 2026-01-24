<!-- mail -->
<!-- GR: Επιστολές; CY: Επιστολές; IT: Servizio di posta; DE: Postdienst; AT: Postdienst; FR: Service postal; BE: Service postal; CH: Epistulae; ES: Servicio de correo; MX: Servicio de correo; IN: मेल सेवा; LK: मेल सेवा; UA: Поштова служба; PT: Serviço de Correio; BR: Serviço de Correio; RO: Serviciu poștal; MD: Serviciu poștal; TR: Posta Servisi; RU: Сообщения; NP: སྦྲག་སྲིད་ཞབས་ཞུ།; CN: 邮件服务; KR: 우편 서비스; JP: メールサービス -->
<?php if (isAuthorized()) { ?>
<div class='customPanel'>
<p align='center' class='block'>
<input type="text" id="composeMessage" style="width:54%;" placeholder="<?=term("What's on your mind?",$settings,$session);?>" value="" onkeydown="if (event.keyCode == 13) {
    compose(sysDefSessionID.value,composeMessage.value);
} else if (event.keyCode==27) {
    document.getElementById('composeMessage').value='';
} else if (event.keyCode==8) {
    handleInput(this.value);
} else if (event.keyCode==46) {
    handleInput(this.value);
}" oninput="handleInput(this.value,true);">
<input type="image" class="power" id="buttonMsgrKeyboard" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="compose(sysDefSessionID.value,composeMessage.value);">
<input type="image" class="power" id="buttonMsgrBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('composeMessage').value = ''; document.getElementById('composeMessage').focus();"></p>
</div>
<div class='customPanel' id='msgBox' style="width:100%;height:85%;left:0px;top:0px;overflow-y:scroll;">
</div>
<?php } ?>
