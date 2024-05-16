<!-- head -->
<!--  -->
<p align="center" class="block">
<select id="setDegrees" style="width:14%;position:relative;" onchange="omniRotate(setDegrees.options[setDegrees.selectedIndex].id);">
<?php foreach ($settings['angles'] as $key=>$value) { ?>
    <option id="<?=$value;?>" <?php if ($request['angle'] == $value) { ?> selected <?php } ?>><?=$degPreSign.($value*$degKoeff).$degSign;?></option>
<?php } ?>
</select>
<input type="image" onmouseover="soundButton();" class="power" onclick="if (sysDefBardot.value != 0) {
    this.src = sysDefPrefix.value+'plus.png'+sysDefSuffix.value;
} else {
    this.src = sysDefPrefix.value+'min.png'+sysDefSuffix.value;
}
setdata('bardot', flip(sysDefBardot.value), true);" src="<?=$prefix.(($session['bardot'] == 1) ? 'min' : 'plus').'.png'.$suffix;?>">
</p>
<p align="center">
<?php if (horizontal($request['angle'], 360) == 'u') { ?>
<a href="<?=$portfolioPrefix.'left0.png';?>"><img style="width:6%;position:relative;" src="<?=$portfolioPrefix.'left0.png'.$suffix;?>"></a>
<a href="<?=$portfolioPrefix.'head.png';?>"><img style="width:11%;position:relative;" src="<?=$portfolioPrefix.'head.png'.$suffix;?>"></a>
<a href="<?=$portfolioPrefix.'right0.png';?>"><img style="width:6%;position:relative;" src="<?=$portfolioPrefix.'right0.png'.$suffix;?>"></a>
<?php } elseif (horizontal($request['angle'], 360) == 'l') { ?>
<a href="<?=$portfolioPrefix.'left270.png';?>"><img style="width:80%;position:relative;" src="<?=$portfolioPrefix.'left270.png'.$suffix;?>"></a>
<?php } elseif (horizontal($request['angle'], 360) == 'r') { ?>
<a href="<?=$portfolioPrefix.'right90.png';?>"><img style="width:80%;position:relative;" src="<?=$portfolioPrefix.'right90.png'.$suffix;?>"></a>
<?php } elseif (horizontal($request['angle'], 360) == 'd') { ?>
<a href="<?=$portfolioPrefix.'right180.png';?>"><img style="width:6%;position:relative;" src="<?=$portfolioPrefix.'right180.png'.$suffix;?>"></a>
<a href="<?=$portfolioPrefix.'left180.png';?>"><img style="width:6%;position:relative;" src="<?=$portfolioPrefix.'left180.png'.$suffix;?>"></a><?php } ?></p>