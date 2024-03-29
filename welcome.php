<?php if ($session['bardot'] == 1) { ?>
<p align="center">
    <img onmouseover="soundButton();" id="showingBardotLNow" name="brigitte_bardot" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'left0.png'.$suffix;?>">
    <img onmouseover="soundButton();" id="showingBardotNow" name="main_menu" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'head.png'.$suffix;?>">
    <img onmouseover="soundButton();" id="showingBardotRNow" name="preferences" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'right0.png'.$suffix;?>">
</p><?php } else { ?>
<p align="center">
    <img onmouseover="soundButton();" id="showingAvatarNow" name="main_menu" style="height:24%;position:relative;" onclick="omniGo(this.name);" src="<?=$avaPrefix.$session['avatar'].'.png'.$suffix;?>">
</p>
<h1 id="articleHead" align='center' style="cursor:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></h1>
<p align="articleBody" align="center" style="cursot:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></p>
<?php } ?>
