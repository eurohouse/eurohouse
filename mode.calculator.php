<!-- calc -->
<!-- GR: Αριθμομηχανή; CY: Αριθμομηχανή; FR: Calculatrice; BE: Calculatrice; DE: Taschenrechner; AT: Taschenrechner; CH: Computus; IT: Calcolatore; ES: Calculadora; MX: Calculadora; PT: Calculadora; BR: Calculadora; RO: Calculatorul; MD: Calculatorul; RU: Калькулятор; NP: རྩིས་འཕྲུལ་ཆས།; RS: Калкулатор; UA: Калькулятор; IN: कैलकुलेटर; TR: Hesap makinesi; LK: गणकम्; CN: 计算器; KR: 계산자; JP: 電卓; AE: آلة حاسبة -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="calcExpr" style="width:62%;" placeholder="<?=term("Type any mathematical expression",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        if (/\[.*?\]/gi.test(calcExpr.value)) {
            calcExpr.value=setCalculator.evaluate(calcExpr.value);
        } else {
            calcExpr.value=solveSystem(calcExpr.value);
        }
    } else if (event.keyCode==27) {
        document.getElementById('calcExpr').value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonEnter" onmouseover="soundButton();" src="<?=$prefix[3].'return.png';?>" onclick="if (/\[.*?\]/gi.test(calcExpr.value)) {
        calcExpr.value=setCalculator.evaluate(calcExpr.value);
    } else {
        calcExpr.value=solveSystem(calcExpr.value);
    }">
    <input type="image" class="power" id="buttonClear" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="document.getElementById('calcExpr').value=''; document.getElementById('calcExpr').focus();"></p>
</div>
<div class='customPanel' id='playlist_disp' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
<p align='center'>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='&';" value="&">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='|';" value="|">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='~';" value="~">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='^';" value="^">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='<';" value="<">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='<=';" value="<=">
</p>
<p align='center'>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='%';" value="%">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='**';" value="**">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='(';" value="(">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+=')';" value=")">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='=';" value="=">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='==';" value="==">
</p>
<p align='center'>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='7';" value="7">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='8';" value="8">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='9';" value="9">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='/';" value="/">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='>';" value=">">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='>=';" value=">=">
<br>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='4';" value="4">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='5';" value="5">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='6';" value="6">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='*';" value="*">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='!=';" value="!=">
<input type="image" class="power" onmouseover="soundButton();" style="width:40px;height:40px;top:14px;" onclick="document.getElementById('calcExpr').value=''; document.getElementById('calcExpr').focus();" src="<?=$prefix[3].'backspace.png';?>">
<br>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='1';" value="1">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='2';" value="2">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='3';" value="3">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='-';" value="-">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='x';" value="x">
<input type="image" class="power" onmouseover="soundButton();" style="width:40px;height:40px;top:14px;" onclick="document.getElementById('calcExpr').focus();" src="<?=$prefix[3].'keyboard.png';?>">
<br>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='0';" value="0">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='.';" value=".">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+=',';" value=",">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='+';" value="+">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;" onclick="calcExpr.value+='y';" value="y">
<input type="image" class="power" onmouseover="soundButton();" style="width:40px;height:40px;top:14px;" onclick="calcExpr.value=solveSystem(calcExpr.value);" src="<?=$prefix[3].'return.png';?>">
</p></div>
