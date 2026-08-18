<!-- bash -->
<!-- CH: Terminalis; CN: 终端; CY: Τερματικό; GR: Τερματικό; IN: टर्मिनल; IT: Terminale; JP: ターミナル; KP: 단말기; KR: 단말기; LK: टर्मिनल्; NP: མཐའ་འཁོར།; RS: Терминал; RU: Командная строка; SM: Terminale; SP: Terminalis; UA: Термінал; VA: Terminalis -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptExec" style="width:62%;" placeholder="<?=term("Type anything and press ENTER",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
	populateCommandIO();
    } else if (event.keyCode==27) {
	promptExec.value=''; clearCommandIO(); promptExec.focus();
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonEnter" onmouseover="soundButton();" src="<?=$prefix[3].'return.png';?>" onclick="soundClick(); populateCommandIO();">
    <input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="soundClick(); promptExec.value=''; clearCommandIO(); promptExec.focus();">
    </p>
</div>
<div class='customPanel' id='commandPrompt' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
    <table id="commandTable" style="width:100%;">
        <thead>
            <tr>
                <th><?=term('Input',$settings,$session);?></th>
                <th><?=term('Output',$settings,$session);?></th>
            </tr>
        </thead>
        <tbody id="commandData"></tbody>
    </table>
</div>