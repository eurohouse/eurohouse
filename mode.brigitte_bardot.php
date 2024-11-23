<!-- head -->
<!-- CH: Brigitta Bardot; RU: Брижит Бардо; UA: Бріжит Бардо -->
<p align="center" class="block">
<select id="setDegrees" style="width:40%;" onchange="omniRotate(setDegrees.options[setDegrees.selectedIndex].id);">
<?php foreach ($settings['angles'] as $key=>$value) { ?>
    <option id="<?=$value;?>" <?php if ($request['angle'] == $value) { ?> selected <?php } ?>><?=$degPreSign.($value*$degKoeff).$degSign;?></option>
<?php } ?></select>
<input type="image" onmouseover="soundButton();" class="power" onclick="this.src = sysDefPrefix.value+((sysDefBardot.value != 0)?'plus':'min')+'.png'; setdata('bardot', flip(sysDefBardot.value), true);" src="<?=$prefix.(($session['bardot'] != 0)?'min':'plus').'.png';?>">
</p><p align="center">
<?php if ($session['censor'] == 0) {
if (horizontal($request['angle'], 360) == 0) { ?>
<a href="<?=$portfolioPrefix.'left0.png';?>"><img style="width:6%;" src="<?=$portfolioPrefix.'left0.png';?>"></a>
<a href="<?=$portfolioPrefix.'head.png';?>"><img style="width:11%;" src="<?=$portfolioPrefix.'head.png';?>"></a>
<a href="<?=$portfolioPrefix.'right0.png';?>"><img style="width:6%;" src="<?=$portfolioPrefix.'right0.png';?>"></a>
<?php } elseif (horizontal($request['angle'], 360) == 3) { ?>
<a href="<?=$portfolioPrefix.'left270.png';?>"><img style="width:80%;" src="<?=$portfolioPrefix.'left270.png';?>"></a>
<?php } elseif (horizontal($request['angle'], 360) == 1) { ?>
<a href="<?=$portfolioPrefix.'right90.png';?>"><img style="width:80%;" src="<?=$portfolioPrefix.'right90.png';?>"></a>
<?php } elseif (horizontal($request['angle'], 360) == 2) { ?>
<a href="<?=$portfolioPrefix.'right180.png';?>"><img style="width:6%;" src="<?=$portfolioPrefix.'right180.png';?>"></a>
<a href="<?=$portfolioPrefix.'left180.png';?>"><img style="width:6%;" src="<?=$portfolioPrefix.'left180.png';?>"></a><?php }} ?></p>