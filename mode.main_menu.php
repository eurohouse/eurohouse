<!-- home -->
<!-- GR: Κυρίως μενού; DE: Hauptmenü; AT: Hauptmenü; CY: Κυρίως μενού; CH: Menu Principal; FR: Menu principal; BE: Menu principal; ES: Menu principal; MX: Menu principal; IT: Menu principale; RU: Главное меню; BR: Menu principal; PT: Menu principal; RO: Meniu principal; MD: Meniu principal; RS: Главни мени; UA: Головне меню; IN: मुख्य मेन्यू; LK: मुख्य मेनू; TR: Ana menü; NP: དཀར་ཆག་གཙོ་བོ།; CN: 主菜单仪表板; KR: 메인 메뉴; JP: 主要メニュー; AE: القائمة الرئيسية -->
<!--  -->
<?php if ($request['lock']=='true') {
    $index=explode(',',$session['menu']);
    $appIndex=str_replace('./','',(glob('./*.package.json')));
} else { $index=str_replace('./','',(glob('./mode.*.php'))); }
if ($request['lock']=='true') {
    if ($session['menu_view']=='thumb') { ?>
        <div class='grid-container'>
        <?php foreach ($index as $key=>$value) {
            if (file_exists('mode.'.$value.'.php')) {
                $menuItemFile=paging('mode.'.$value.'.php',[0,1]);
                $menuItemIcon=annotationString($menuItemFile[0]);
                $elementIcon=(themed($themePrefix, $menuItemIcon))?$themePrefix.$menuItemIcon.'.png':$ersatzPrefix.$menuItemIcon.'.png';
                $menuItemLangPack=annotationString($menuItemFile[1]);
                $menuItemLangArr=explode('; ',$menuItemLangPack);
                $menuItemLangNew=[]; foreach ($menuItemLangArr as $menuItemLangStr) {
                    $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
                } ?>
                <div class='grid-item'>
                    <div class='grid-label'>
                        <a href="javascript:omniGo(%22<?=$value;?>%22);">
                            <?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>
                        </a>
                    </div>
                    <div class='grid-icon'>
                        <img onmouseover="soundButton();" loading="lazy" name="<?=$value;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>">
                    </div>
                </div>
            <?php }
        } if ($session['apps']!=0) {
            foreach ($appIndex as $key=>$value) {
                $eurArrayPkg=fileopen($value);
                if (!isset($eurArrayPkg['run'])) {
                    unset($appIndex[array_search($value,$appIndex)]);
                }
            } foreach ($appIndex as $key=>$value) {
                $eurArrPkg=fileopen($value);
                $eurArrFavicon=(isset($eurArrPkg['favicon']))?((file_exists($eurArrPkg['favicon']))?$eurArrPkg['favicon']:$themePrefix.'package.png'):$themePrefix.'package.png';
            ?>
            <div class='grid-item'>
                <div class='grid-label'>
                    <a href="<?=$eurArrPkg['run'];?>">
                        <?=wallpaperTitle($value,'package',$settings,$session);?>
                    </a>
                </div>
                <div class='grid-icon'>
                    <img onmouseover="soundButton();" loading="lazy" name="<?=$eurArrPkg['run'];?>" style="height:20%;" onclick="window.location.href=this.name;" src="<?=$eurArrFavicon;?>" title="<?=wallpaperTitle($value,'package',$settings,$session);?>">
                </div>
            </div><?php }} ?>
        </div>
    <?php } elseif ($session['menu_view']=='menu') { ?>
        <p align='center' class='block'>
        <?php foreach ($index as $key=>$value) {
            if (file_exists('mode.'.$value.'.php')) {
                $menuItemFile=paging('mode.'.$value.'.php',[0,1]);
                $menuItemIcon=annotationString($menuItemFile[0]);
                $elementIcon=(themed($themePrefix, $menuItemIcon))?$themePrefix.$menuItemIcon.'.png':$ersatzPrefix.$menuItemIcon.'.png';
                $menuItemLangPack=annotationString($menuItemFile[1]);
                $menuItemLangArr=explode('; ',$menuItemLangPack);
                $menuItemLangNew=[]; foreach ($menuItemLangArr as $menuItemLangStr) {
                    $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
                } ?>
                <img onmouseover="soundButton();" loading="lazy" name="<?=$value;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>">
            <?php }
        } if ($session['apps']!=0) {
            foreach ($appIndex as $key=>$value) {
                $eurArrayPkg=fileopen($value);
                if (!isset($eurArrayPkg['run'])) {
                    unset($appIndex[array_search($value,$appIndex)]);
                }
            } foreach ($appIndex as $key=>$value) {
                $eurArrPkg=fileopen($value);
                $eurArrFavicon=(isset($eurArrPkg['favicon']))?((file_exists($eurArrPkg['favicon']))?$eurArrPkg['favicon']:$themePrefix.'package.png'):$themePrefix.'package.png';
                ?>
                <img onmouseover="soundButton();" loading="lazy" name="<?=$eurArrPkg['run'];?>" style="height:20%;" onclick="window.location.href=this.name;" src="<?=$eurArrFavicon;?>" title="<?=wallpaperTitle($value,'package',$settings,$session);?>">
        <?php }} ?></p>
    <?php } else {
        foreach ($index as $key=>$value) {
            if (file_exists('mode.'.$value.'.php')) {
                $menuItemFile=paging('mode.'.$value.'.php',[1]);
                $menuItemLangPack=annotationString($menuItemFile[1]);
                $menuItemLangArr=explode('; ',$menuItemLangPack); $menuItemLangNew=[];
                foreach ($menuItemLangArr as $menuItemLangStr) {
                    $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
                } ?>
                <p align='center'>
                    <input type="button" class="button" name="<?=$value;?>" onmouseover="soundButton();" style="width:80%;" value="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>" onclick="omniGo(this.name);">
                </p>
            <?php }
        } if ($session['apps']!=0) {
            foreach ($appIndex as $key=>$value) {
                $eurArrayPkg=fileopen($value);
                if (!isset($eurArrayPkg['run'])) {
                    unset($appIndex[array_search($value,$appIndex)]);
                }
            } foreach ($appIndex as $key=>$value) {
                $eurArrPkg=fileopen($value); ?>
                <p align='center'>
                    <input type="button" class="button" name="<?=$eurArrPkg['run'];?>" onmouseover="soundButton();" style="width:80%;" value="<?=wallpaperTitle($value,'package',$settings,$session);?>" onclick="window.location.href=this.name;">
                </p>
            <?php }
        }
    }
} else {
    if ($session['menu_view']=='thumb') { ?>
        <div class='grid-container'>
        <?php foreach ($index as $key=>$value) {
            $menuElementName=str_replace('mode.','',basename($value,'.php'));$currentMenuItems=explode(',',$session['menu']);
            $statusFound=(array_search($menuElementName,$currentMenuItems)!==false)?'min':'plus';
            $menuItemFile=paging('mode.'.$menuElementName.'.php',[0,1]);
            $menuItemIcon=annotationString($menuItemFile[0]);
            $elementIcon=(themed($themePrefix,$menuItemIcon))?$themePrefix.$menuItemIcon.'.png':$ersatzPrefix.$menuItemIcon.'.png';
            $menuItemLangPack=annotationString($menuItemFile[1]);
            $menuItemLangArr=explode('; ',$menuItemLangPack);
            $menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
            } ?>
            <div class='grid-item'>
                <div class='grid-label'>
                    <a href="javascript:omniGo(%22<?=$menuElementName;?>%22);">
                        <?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>
                    </a><br>
                    <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.png';?>">
                </div>
                <div class='grid-icon'>
                    <img onmouseover="soundButton();" loading="lazy" name="<?=$menuElementName;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>">
                </div>
            </div>
        <?php } ?></div>
    <?php } elseif ($session['menu_view']=='menu') { ?>
        <p align='center' class='block'>
        <?php foreach ($index as $key=>$value) {
            $menuElementName=str_replace('mode.','',basename($value,'.php'));$currentMenuItems=explode(',',$session['menu']);
            $statusFound=(array_search($menuElementName,$currentMenuItems)!==false)?'min':'plus';
            $menuItemFile=paging('mode.'.$menuElementName.'.php',[0,1]);
            $menuItemIcon=annotationString($menuItemFile[0]);
            $elementIcon=(themed($themePrefix,$menuItemIcon))?$themePrefix.$menuItemIcon.'.png':$ersatzPrefix.$menuItemIcon.'.png';
            $menuItemLangPack=annotationString($menuItemFile[1]);
            $menuItemLangArr=explode('; ',$menuItemLangPack);
            $menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
            } ?>
            <img onmouseover="soundButton();" loading="lazy" name="<?=$menuElementName;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>">
            <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.png';?>">
        <?php } ?></p>
    <?php } else {
        foreach ($index as $key=>$value) {
            $menuElementName=str_replace('mode.','',basename($value,'.php'));$currentMenuItems=explode(',',$session['menu']);$statusFound=(array_search($menuElementName,$currentMenuItems)!==false)?'min':'plus';$menuItemFile=paging('mode.'.$menuElementName.'.php',[1]);$menuItemLangPack=annotationString($menuItemFile[1]);$menuItemLangArr=explode('; ',$menuItemLangPack);$menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
            <p align='center' class='block'>
                <input type="button" class="button" name="<?=$menuElementName;?>" onmouseover="soundButton();" style="width:70%;" value="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>" onclick="omniGo(this.name);"><input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.png';?>">
            </p>
        <?php }
    }
} ?>