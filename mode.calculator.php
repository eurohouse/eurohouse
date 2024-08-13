<!-- calc -->
<!-- GR: Αριθμομηχανή; CY: Αριθμομηχανή; FR: Calculatrice; BE: Calculatrice; DE: Taschenrechner; AT: Taschenrechner; CH: Computus; IT: Calcolatore; ES: Calculadora; MX: Calculadora; PT: Calculadora; BR: Calculadora; RO: Calculatorul; MD: Calculatorul; RU: Калькулятор; NP: རྩིས་འཕྲུལ་ཆས།; RS: Калкулатор; UA: Калькулятор; IN: कैलकुलेटर; TR: Hesap makinesi; LK: गणकम्; CN: 计算器; KR: 계산자; JP: 電卓; AE: آلة حاسبة -->
<p align='center'>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='&';" value="&">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='|';" value="|">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='~';" value="~">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='^';" value="^">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='<';" value="<">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='<=';" value="<=">
</p>
<p align='center'>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='%';" value="%">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='**';" value="**">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='(';" value="(">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+=')';" value=")">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='=';" value="=">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='==';" value="==">
</p>
<p align='center'>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='7';" value="7">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='8';" value="8">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='9';" value="9">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='/';" value="/">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='>';" value=">">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='>=';" value=">=">
<br>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='4';" value="4">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='5';" value="5">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='6';" value="6">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='*';" value="*">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='!=';" value="!=">
<input type="image" class="power" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;top:14px;" onclick="document.getElementById('omniBox').value = ''; document.getElementById('omniBox').focus();" src="<?=$prefix.'backspace.png'.$suffix;?>">
<br>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='1';" value="1">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='2';" value="2">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='3';" value="3">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='-';" value="-">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='x';" value="x">
<input type="image" class="power" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;top:14px;" onclick="document.getElementById('omniBox').focus();" src="<?=$prefix.'keyboard.png'.$suffix;?>">
<br>
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='0';" value="0">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='.';" value=".">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+=',';" value=",">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='+';" value="+">
<input type="button" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;" onclick="omniBox.value+='y';" value="y">
<input type="image" class="power" onmouseover="soundButton();" style="width:40px;height:40px;position:relative;top:14px;" onclick="omniEnter();" src="<?=$prefix.'return.png'.$suffix;?>">
</p>

