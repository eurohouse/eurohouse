<!-- home -->
<!-- GR: Κυρίως μενού; DE: Hauptmenü; AT: Hauptmenü; CY: Κυρίως μενού; CH: Menu Principal; FR: Menu principal; BE: Menu principal; ES: Menu principal; MX: Menu principal; IT: Menu principale; RU: Главное меню; BR: Menu principal; PT: Menu principal; RO: Meniu principal; MD: Meniu principal; RS: Главни мени; UA: Головне меню; IN: मुख्य मेन्यू; LK: मुख्य मेनू; TR: Ana menü; NP: དཀར་ཆག་གཙོ་བོ།; CN: 主菜单仪表板; KR: 메인 메뉴; JP: 主要メニュー; AE: القائمة الرئيسية -->
<!--  -->
<?php if ($request['lock']=='true') {
    $index=explode(',',$session['menu']);
    $appIndex=str_replace('./','',(glob('./*.pkg')));
} else { $index=str_replace('./','',(glob('./mode.*.php'))); }
if ($session['face']==1) { ?>
    <div class='customPanel'>
        <p align="center">
            <img onmouseover="soundButton();" id="showingAvatarNow" name="" style="height:24%;" onclick="omniGo(this.name);" src="<?=$prefix[0].$session['avatar'].'.png';?>">
            <h1 id="projectTitle" align='center' style="cursor:pointer;" onclick="clip(this.innerText);"></h1>
        </p>
    </div>
    <div class='customPanel' style="width:100%;height:54%;left:0px;top:0px;overflow-y:scroll;">
        <?php include 'menu_items.php'; ?>
    </div>
<?php } else { include 'menu_items.php'; } ?>