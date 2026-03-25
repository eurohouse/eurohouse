<!-- bash -->
<!-- GR: Τερματικό; CY: Τερματικό; CH: Terminalis; IT: Terminale; LK: टर्मिनल्; IN: टर्मिनल; RU: Командная строка; RS: Терминал; NP: མཐའ་འཁོར།; UA: Термінал; CN: 终端; KR: 단말기; JP: ターミナル -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="promptExec" style="width:62%;" placeholder="<?=term("Type anything and press ENTER",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) { populateCommandIO();
    } else if (event.keyCode==27) { promptExec.value='';
    } else if (event.keyCode==8) { handleInput(this.value);
    } else if (event.keyCode==46) { handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonEnter" onmouseover="soundButton();" src="<?=$prefix[3].'keyboard.png';?>" onclick="populateCommandIO();">
    <input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="promptExec.value=''; promptExec.focus();"></p>
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