<!-- news -->
<!-- RU: Мгновенные сообщения; CN: 即时通讯聊天; KR: 커뮤니케이션 채팅; JP: 通信チャット; AE: رسالة فورية -->
<?php if (isset($_SESSION['user'])) { ?>
<div class='customPanel'>
<p align='center' class='block'>
<input type="text" id="composeMessage" style="width:54%;position:relative;" placeholder="<?=term('What\'s on your mind...', $settings['vocabulary'], $session['units']);?>" value="" onkeydown="if (event.keyCode == 13) {
    compose(composeMessage.value);
} else if (event.keyCode == 27) {
    document.getElementById('composeMessage').value = '';
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix.'return.png'.$suffix;?>" onclick="compose(composeMessage.value);">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix.'keyboard.png'.$suffix;?>" onclick="document.getElementById('composeMessage').focus();">
<input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix.'backspace.png'.$suffix;?>" onclick="document.getElementById('composeMessage').value = ''; document.getElementById('composeMessage').focus();">
</p>
</div>
<?php } ?>
<div class='customPanel' id='msgBox' style="width:100%;height:85%;left:0px;top:0px;overflow-y:scroll;">
</div>