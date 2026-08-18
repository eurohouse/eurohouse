<!-- help -->
<!-- BE: Intelligence artificielle; CH: Intellegentia Artificialis; CN: 人工智能; CY: Τεχνητή Νοημοσύνη; FR: Intelligence artificielle; GR: Τεχνητή Νοημοσύνη; IN: कृत्रिम होशियारी; IT: Intelligenza artificiale; JP: 人工知能; KP: 인공지능; KR: 인공지능; LK: कृत्रिम बुद्धि; MC: Intelligence artificielle; NP: མིས་བཟོས་རིག་སྟོབས།; RS: Вештачка интелигенција; RU: Искусственный интеллект; SM: Intelligenza artificiale; SP: Intellegentia Artificialis; UA: Штучний інтелект; VA: Intellegentia Artificialis -->
<?php if (!file_exists($sessionID.'_files/artificial_intelligence.json')) {
    file_put_contents($sessionID.'_files/artificial_intelligence.json','[]');
} ?>
<div class='customPanel' style="width:100%;height:1.7em;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptGPT" style="width:50%;" placeholder="<?=term("Ask artificial intelligence anything",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        AI(this.value).then(reply=>{
            if (notNull(reply)) {
                markdown_disp.innerHTML=marked.parse(reply);
		sysDefUserAIMaxNum.value=Math.max(...Object.keys(jsonarr(sysDefUserAIData.value)).map(Number));
		sysDefUserAICurNum.value=parseInt(sysDefUserAIMaxNum.value);
            }
        }).catch(error=>{ console.error(error); });
    } else if (event.keyCode==27) { this.value=''; markdown_disp.innerHTML=''; this.focus(); set(sysDefSessionID.value+'_files/artificial_intelligence.json','[]','rw'); sysDefUserAICurNum.value=0;
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonPrev" onmouseover="soundButton();" src="<?=$prefix[3].'prev.png';?>" onclick="soundClick(); var cur=parseInt(sysDefUserAICurNum.value); var max=parseInt(sysDefUserAIMaxNum.value); cur=(cur<=0)?max:(cur-1); sysDefUserAICurNum.value=cur; markdown_disp.innerHTML=marked.parse(getAIRecordContent(sysDefUserAICurNum.value)); promptGPT.focus();">
    <input type="image" class="power" id="buttonNext" onmouseover="soundButton();" src="<?=$prefix[3].'next.png';?>" onclick="soundClick(); var cur=parseInt(sysDefUserAICurNum.value); var max=parseInt(sysDefUserAIMaxNum.value); cur=(cur>=max)?0:(cur+1); sysDefUserAICurNum.value=cur; markdown_disp.innerHTML=marked.parse(getAIRecordContent(sysDefUserAICurNum.value)); promptGPT.focus();">
    <input type="image" class="power" id="buttonKeyboard" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="soundClick(); AI(this.value).then(reply=>{
    if (notNull(reply)) {
            markdown_disp.innerHTML=marked.parse(reply);
	    sysDefUserAIMaxNum.value=Math.max(...Object.keys(jsonarr(sysDefUserAIData.value)).map(Number));
	    sysDefUserAICurNum.value=parseInt(sysDefUserAIMaxNum.value);
        }
    }).catch(error=>{ console.error(error); }); promptGPT.focus();">
    <input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="soundClick(); promptGPT.value=''; markdown_disp.innerHTML=''; promptGPT.focus(); set(sysDefSessionID.value+'_files/artificial_intelligence.json','[]','rw'); sysDefUserAICurNum.value=0;">
    </p>
</div>
<div class='customPanel' id='markdown_disp' style="width:100%;height:70%;left:0px;top:0px;overflow-y:scroll;">
</div>