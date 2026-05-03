<!-- calc -->
<!-- GR: Αριθμομηχανή; CY: Αριθμομηχανή; FR: Calculatrice; BE: Calculatrice; DE: Taschenrechner; AT: Taschenrechner; CH: Computus; IT: Calcolatore; ES: Calculadora; MX: Calculadora; PT: Calculadora; BR: Calculadora; RO: Calculatorul; MD: Calculatorul; RU: Калькулятор; NP: རྩིས་འཕྲུལ་ཆས།; RS: Калкулатор; UA: Калькулятор; IN: कैलकुलेटर; TR: Hesap makinesi; LK: गणकम्; CN: 计算器; KR: 계산자; JP: 電卓; AE: آلة حاسبة -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="text" id="calcExpr" style="width:62%;" placeholder="<?=term("Type any mathematical expression",$settings,$session);?>" value="" onkeydown="if (event.keyCode==13) {
        calcExpr.value=calculate(calcExpr.value);
    } else if (event.keyCode==27) {
        document.getElementById('calcExpr').value='';
    } else if (event.keyCode==8) {
        handleInput(this.value);
    } else if (event.keyCode==46) {
        handleInput(this.value);
    }" oninput="handleInput(this.value,true);">
    <input type="image" class="power" id="buttonEnter" onmouseover="soundButton();" src="<?=$prefix[3].'return.png';?>" onclick="soundClick(); calcExpr.value=calculate(calcExpr.value);">
    <input type="image" class="power" id="buttonBackspace" onmouseover="soundButton();" src="<?=$prefix[3].'backspace.png';?>" onclick="soundClick(); calcExpr.value=''; calcExpr.focus();"></p>
</div>
<div class='customPanel' style="width:100%;height:80%;left:0px;top:0px;overflow-y:scroll;">
<p align='center'>
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='&';" value="&">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='|';" value="|">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='~';" value="~">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='^';" value="^">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='<';" value="<">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='>';" value=">">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+=':';" value=":">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+=';';" value=";">
</p>
<p align='center'>
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='%';" value="%">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='**';" value="**">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='(';" value="(">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+=')';" value=")">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='{';" value="{">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='}';" value="}">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='[';" value="[">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+=']';" value="]">
</p>
<p align='center'>
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='7';" value="7">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='8';" value="8">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='9';" value="9">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='/';" value="/">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='=';" value="=">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='!';" value="!">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='true';" value="t">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='false';" value="f">
<br>
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='4';" value="4">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='5';" value="5">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='6';" value="6">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='*';" value="*">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='!=';" value="!=">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='2.718281828459045';" value="e">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='3.141592653589793';" value="π">
<input type="image" class="power" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value=''; calcExpr.focus();" src="<?=$prefix[3].'backspace.png';?>">
<br>
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='1';" value="1">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='2';" value="2">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='3';" value="3">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='-';" value="-">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='x';" value="x">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='A';" value="A">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='B';" value="B">
<input type="image" class="power" onmouseover="soundButton();" onclick="soundClick(); calcExpr.focus();" src="<?=$prefix[3].'keyboard.png';?>">
<br>
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='0';" value="0">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='.';" value=".">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+=',';" value=",">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='+';" value="+">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='y';" value="y">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='C';" value="C">
<input type="button" class="calcButton" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value+='D';" value="D">
<input type="image" class="power" onmouseover="soundButton();" onclick="soundClick(); calcExpr.value=calculate(calcExpr.value);" src="<?=$prefix[3].'return.png';?>">
</p></div>
