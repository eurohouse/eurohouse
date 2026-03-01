<!-- help -->
<!-- GR: Τεχνητή Νοημοσύνη; CY: Τεχνητή Νοημοσύνη; CH: Intellegentia Artificialis; FR: Intelligence artificielle; IT: Intelligenza artificiale; LK: कृत्रिम बुद्धि; IN: कृत्रिम होशियारी; RU: Искусственный интеллект; RS: Вештачка интелигенција; NP: མིས་བཟོས་རིག་སྟོབས།; UA: Штучний інтелект; CN: 人工智能; KR: 인공지능; JP: 人工知能 -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptGPT" style="width:62%;" placeholder="<?=term("Ask artificial intelligence anything",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        chatGPTAI(promptGPT.value).then(reply=>{
            commandOutput.innerHTML=marked.parse(reply);
        }).catch(error=>{ console.error(error); });
    } else if (event.keyCode==27) {
        document.getElementById('promptGPT').value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonEnter" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="chatGPTAI(promptGPT.value).then(reply=>{
            commandOutput.innerHTML=marked.parse(reply);
        }).catch(error=>{ console.error(error); });">
    <input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('promptGPT').value=''; document.getElementById('promptGPT').focus();"></p>
</div>
<div class='customPanel' id='playlist_disp' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
    <p align="center" id="commandOutput"></p>
</div>