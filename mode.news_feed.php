<!-- news -->
<!-- RU: Мгновенные сообщения; CN: 即时通讯聊天; TW: 即时通讯聊天; JP: 即时通讯聊天; AE: رسالة فورية -->
<?php if (isset($_SESSION['user'])) { ?>
<div class='customPanel'>
<p align='center' class='block'>
<input type="text" id="composeMessage" style="width:54%;position:relative;" placeholder="<?=term('What\'s on your mind...', $settings['vocabulary'], $session['units']);?>" value="" onkeydown="if (event.keyCode == 13) {
    compose(encodeURIComponent(composeMessage.value));
}">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix.'return.png'.$suffix;?>" onclick="compose(encodeURIComponent(composeMessage.value), false);">
<?php if ($sessionID == 'root') { ?>
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix.'delete.png'.$suffix;?>" onclick="compose(encodeURIComponent(composeMessage.value), true);">
<?php } ?>
</p>
</div>
<?php } ?>
<div class='customPanel' id='msgBox' style="width:100%;height:85%;left:0px;top:0px;overflow-y:scroll;">
</div>