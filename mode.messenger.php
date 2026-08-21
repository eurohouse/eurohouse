<!-- mail -->
<!-- AD: Servicio de correo; AG: Servicio de correo; AT: Postdienst; BE: Service postal; BR: Serviço de Correio; CH: Epistulae; CL: Servicio de correo; CN: 邮件服务; CO: Servicio de correo; CU: Servicio de correo; CY: Επιστολές; DD: Postdienst; DE: Postdienst; DR: Postdienst; ES: Servicio de correo; FR: Service postal; GR: Επιστολές; IN: मेल सेवा; IT: Servizio di posta; JP: メールサービス; KP: 우편 서비스; KR: 우편 서비스; LK: मेल सेवा; MC: Service postal; MD: Serviciu poștal; MX: Servicio de correo; NP: སྦྲག་སྲིད་ཞབས་ཞུ།; PT: Serviço de Correio; RO: Serviciu poștal; RU: Сообщения; SM: Servizio di posta; SP: Epistulae; TR: Posta Servisi; UA: Поштова служба; VA: Epistulae -->
<?php if (isAuthorized()) { ?>
<div class='customPanel'>
<p align='center' class='block'>
    <input type="image" class="power" id="buttonMorseLock" onmouseover="soundButton();" src="<?=$prefix[3].(($session['morse']!=0)?'key.png':'lock.png');?>" onclick="soundClick(); setdata('morse',flip(sysDefMorse.value));">
    <input type="text" id="composeMessage" style="width:54%;" placeholder="<?=term("What's on your mind?",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        compose(sysDefSessionID.value,composeMessage.value);
    } else if (event.keyCode==27) { composeMessage.value='';
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonKeyboard" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="soundClick(); compose(sysDefSessionID.value,composeMessage.value);">
    <input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="soundClick(); composeMessage.value='';">
</p>
</div>
<div class='customPanel' id='msgBox' style="width:100%;height:85%;left:0px;top:0px;overflow-y:scroll;">
</div>
<?php } ?>
