<?php if (($session['bardot']==1)&&($session['nsfw']!=0)) { ?>
<p align="center">
    <img onmouseover="soundButton();" id="showingBardotLNow" name="brigitte_bardot" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'left0.png';?>">
    <img onmouseover="soundButton();" id="showingBardotNow" name="main_menu" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'head.png';?>">
    <img onmouseover="soundButton();" id="showingBardotRNow" name="preferences" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'right0.png';?>">
</p><?php } else { ?>
<p align="center">
    <img onmouseover="soundButton();" id="showingAvatarNow" name="main_menu" style="height:24%;position:relative;" onclick="omniGo(this.name);" src="<?=$prefix[0].$session['avatar'].'.png';?>">
</p>
<h1 id="articleHead" align='center' style="cursor:pointer;" onclick="clip(this.innerText);"></h1>
<p id="articleBody" align="center" style="cursot:pointer;" onclick="clip(this.innerText);"></p>
<p align="center"><a id="articleLink"></a></p>
<?php } ?>
