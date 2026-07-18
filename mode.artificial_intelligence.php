<!-- help -->
<!-- GR: Τεχνητή Νοημοσύνη; CY: Τεχνητή Νοημοσύνη; CH: Intellegentia Artificialis; FR: Intelligence artificielle; IT: Intelligenza artificiale; LK: कृत्रिम बुद्धि; IN: कृत्रिम होशियारी; RU: Искусственный интеллект; RS: Вештачка интелигенција; NP: མིས་བཟོས་རིག་སྟོབས།; UA: Штучний інтелект; CN: 人工智能; KR: 인공지능; JP: 人工知能 -->
<?php if (!file_exists($sessionID.'_files/artificial_intelligence.json')) {
    file_put_contents($sessionID.'_files/artificial_intelligence.json','[]');
} ?>
<div class='customPanel' style="width:100%;height:1.3em;left:0px;top:0px;">
    <p align='center' class='block'>
	<span id='AIInfo' class='urgent' name="<?=(isUserRoot($superuser))?'set "../.env" "API_KEY=..."':'endpoint: '.fileopen($superuser.'_files/profile.json',json_encode($settings['defaults']))['endpoint'].'; model: '.fileopen($superuser.'_files/profile.json',json_encode($settings['defaults']))['model'].';';?>" onclick="soundClick(true); clip(this.name);">
	<?=(isUserRoot($superuser))?'set "../.env" "API_KEY=..."':'endpoint: ...; model: ...;';?>
	</span>
    </p>
</div>
<div class='customPanel' style="width:100%;height:1.7em;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptGPT" style="width:68%;" placeholder="<?=term("Ask artificial intelligence anything",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        AI(this.value).then(reply=>{
            if (notNull(reply)) {
                markdown_disp.innerHTML=marked.parse(reply);
            }
        }).catch(error=>{ console.error(error); });
    } else if (event.keyCode==27) { this.value=''; markdown_disp.innerHTML=''; this.focus(); set(sysDefSessionID.value+'_files/artificial_intelligence.json','[]','rw');
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonKeyboard" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="soundClick(); AI(promptGPT.value).then(reply=>{
        if (notNull(reply)) {
            markdown_disp.innerHTML=marked.parse(reply);
        }
    }).catch(error=>{ console.error(error); });">
    <input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="soundClick(); promptGPT.value=''; markdown_disp.innerHTML=''; promptGPT.focus(); set(sysDefSessionID.value+'_files/artificial_intelligence.json','[]','rw');">
    </p>
</div>
<div class='customPanel' id='markdown_disp' style="width:100%;height:70%;left:0px;top:0px;overflow-y:scroll;">
</div>