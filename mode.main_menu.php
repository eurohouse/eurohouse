<!-- home -->
<!-- RU: Главное меню; CN: 主菜单仪表板; TW: 主菜单仪表板; JP: 主菜单仪表板; AE: القائمة الرئيسية -->
<!--  -->
<?php if ($request['lock'] == 'true') {
    $index = explode(',', $session['menu']);
    $appIndex = str_replace('./','',(glob('./*.pkg')));
} else {
    $index = str_replace('./','',(glob('./mode.*.php')));
} ?><?php if ($session['bardot'] == 1) { ?>
<p align="center">
    <img onmouseover="soundButton();" id="showingBardotLNow" name="brigitte_bardot" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'left0.png'.$suffix;?>">
    <img onmouseover="soundButton();" id="showingBardotNow" name="" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'head.png'.$suffix;?>">
    <img onmouseover="soundButton();" id="showingBardotRNow" name="preferences" style="height:54%;position:relative;" onclick="omniGo(this.name);" src="<?=$portfolioPrefix.'right0.png'.$suffix;?>">
</p>
<?php } else { 
    if ($session['faceoff'] == 0) {
?><div class='customPanel'><p align="center">
    <img onmouseover="soundButton();" id="showingAvatarNow" name="<?php if ($request['mode'] != '') { echo ''; } else { echo 'main_menu'; } ?>" style="height:24%;position:relative;" onclick="omniGo(this.name);" src="<?=$avaPrefix.$session['avatar'].'.png'.$suffix;?>">
    <h1 id="projectTitle" align='center' style="cursor:pointer;" onclick="navigator.clipboard.writeText(this.innerText);"></h1>
</p></div>
<div class='customPanel' style="width:100%;height:60%;left:0px;top:0px;overflow-y:scroll;">
<?php include 'menu_items.php'; ?>
</div>
<?php } else {
    include 'menu_items.php';
}} ?>