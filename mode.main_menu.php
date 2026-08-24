<!-- home -->
<!-- AD: Menu principal; AE: القائمة الرئيسية; AG: Menu principal; AT: Hauptmenü; BE: Menu principal; BR: Menu principal; CH: Menu Principal; CL: Menu principal; CN: 主菜单仪表板; CO: Menu principal; CU: Menu principal; CY: Κυρίως μενού; DD: Hauptmenü; DE: Hauptmenü; DR: Hauptmenü; ES: Menu principal; FR: Menu principal; GR: Κυρίως μενού; IN: मुख्य मेन्यू; IQ: القائمة الرئيسية; IR: القائمة الرئيسية; IT: Menu principale; JP: 主要メニュー; KP: 메인 메뉴; KR: 메인 메뉴; KW: القائمة الرئيسية; LK: मुख्य मेनू; MC: Menu principal; MD: Meniu principal; MX: Menu principal; NP: དཀར་ཆག་གཙོ་བོ།; PT: Menu principal; QA: القائمة الرئيسية; RO: Meniu principal; RS: Главни мени; RU: Главное меню; SA: القائمة الرئيسية; SM: Menu principale; SP: Menu Principal; TR: Ana menü; UA: Головне меню; VA: Menu Principal -->
<!--  -->
<?php if ($request['lock']=='true') {
    $index=explode(',',$session['menu']);
    $appIndex=str_replace('./','',(glob('./*.package.json')));
} else { $index=str_replace('./','',(glob('./mode.*.php'))); }
if ($request['lock']=='true') {
    if (($session['menu_view']=='thumb')||($session['menu_view']=='thumbnail')||($session['menu_view']=='thumbs')||($session['menu_view']=='thumbnails')) { ?>
        <div class='grid-container'>
        <?php foreach ($index as $key=>$value) {
            if (file_exists('mode.'.$value.'.php')) {
                $menuItemFile=selectedLines('mode.'.$value.'.php',[0,1]);
                $menuItemIcon=annotationString($menuItemFile[0]);
                $elementIcon=(themed($themePrefix,$menuItemIcon))?$themePrefix.$menuItemIcon.'.webp':$ersatzPrefix.$menuItemIcon.'.webp';
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
                        <img onmouseover="soundButton();" loading="lazy" name="<?=$value;?>" style="height:20%;" onclick="soundClick(); omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>">
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
                $eurArrFavicon=(isset($eurArrPkg['favicon']))?((file_exists($eurArrPkg['favicon']))?$eurArrPkg['favicon']:$themePrefix.'package.webp'):$themePrefix.'package.webp';
            ?>
            <div class='grid-item'>
                <div class='grid-label'>
                    <a href="<?=$eurArrPkg['run'];?>">
                        <?=titlePkgEnt($value,'package',$settings,$session);?>
                    </a>
                </div>
                <div class='grid-icon'>
                    <img onmouseover="soundButton();" loading="lazy" name="<?=$eurArrPkg['run'];?>" style="height:20%;" onclick="soundClick(); window.location.href=this.name;" src="<?=$eurArrFavicon;?>" title="<?=titlePkgEnt($value,'package',$settings,$session);?>">
                </div>
            </div><?php }} ?>
        </div>
    <?php } elseif (($session['menu_view']=='icon')||($session['menu_view']=='icons')||($session['menu_view']=='menu')||($session['menu_view']=='grid')) { ?>
        <p align='center' class='block'>
        <?php foreach ($index as $key=>$value) {
            if (file_exists('mode.'.$value.'.php')) {
                $menuItemFile=selectedLines('mode.'.$value.'.php',[0,1]);
                $menuItemIcon=annotationString($menuItemFile[0]);
                $elementIcon=(themed($themePrefix, $menuItemIcon))?$themePrefix.$menuItemIcon.'.webp':$ersatzPrefix.$menuItemIcon.'.webp';
                $menuItemLangPack=annotationString($menuItemFile[1]);
                $menuItemLangArr=explode('; ',$menuItemLangPack);
                $menuItemLangNew=[]; foreach ($menuItemLangArr as $menuItemLangStr) {
                    $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
                } ?>
                <img onmouseover="soundButton();" loading="lazy" name="<?=$value;?>" style="height:20%;" onclick="soundClick(); omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>">
            <?php }
        } if ($session['apps']!=0) {
            foreach ($appIndex as $key=>$value) {
                $eurArrayPkg=fileopen($value);
                if (!isset($eurArrayPkg['run'])) {
                    unset($appIndex[array_search($value,$appIndex)]);
                }
            } foreach ($appIndex as $key=>$value) {
                $eurArrPkg=fileopen($value);
                $eurArrFavicon=(isset($eurArrPkg['favicon']))?((file_exists($eurArrPkg['favicon']))?$eurArrPkg['favicon']:$themePrefix.'package.webp'):$themePrefix.'package.webp';
                ?>
                <img onmouseover="soundButton();" loading="lazy" name="<?=$eurArrPkg['run'];?>" style="height:20%;" onclick="soundClick(); window.location.href=this.name;" src="<?=$eurArrFavicon;?>" title="<?=titlePkgEnt($value,'package',$settings,$session);?>">
        <?php }} ?></p>
    <?php } else {
        foreach ($index as $key=>$value) {
            if (file_exists('mode.'.$value.'.php')) {
                $menuItemFile=selectedLines('mode.'.$value.'.php',[1]);
                $menuItemLangPack=annotationString($menuItemFile[1]);
                $menuItemLangArr=explode('; ',$menuItemLangPack); $menuItemLangNew=[];
                foreach ($menuItemLangArr as $menuItemLangStr) {
                    $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
                } ?>
                <p align='center'>
                    <input type="button" class="button" name="<?=$value;?>" onmouseover="soundButton();" style="width:80%;" value="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>" onclick="soundClick(); omniGo(this.name);">
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
                    <input type="button" class="button" name="<?=$eurArrPkg['run'];?>" onmouseover="soundButton();" style="width:80%;" value="<?=titlePkgEnt($value,'package',$settings,$session);?>" onclick="soundClick(); window.location.href=this.name;">
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
            $menuItemFile=selectedLines('mode.'.$menuElementName.'.php',[0,1]);
            $menuItemIcon=annotationString($menuItemFile[0]);
            $elementIcon=(themed($themePrefix,$menuItemIcon))?$themePrefix.$menuItemIcon.'.webp':$ersatzPrefix.$menuItemIcon.'.webp';
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
                    <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.webp':sysDefPrefix.value+'min.webp';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.webp';?>">
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
            $menuItemFile=selectedLines('mode.'.$menuElementName.'.php',[0,1]);
            $menuItemIcon=annotationString($menuItemFile[0]);
            $elementIcon=(themed($themePrefix,$menuItemIcon))?$themePrefix.$menuItemIcon.'.webp':$ersatzPrefix.$menuItemIcon.'.webp';
            $menuItemLangPack=annotationString($menuItemFile[1]);
            $menuItemLangArr=explode('; ',$menuItemLangPack);
            $menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
            } ?>
            <img onmouseover="soundButton();" loading="lazy" name="<?=$menuElementName;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>">
            <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.webp':sysDefPrefix.value+'min.webp';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.webp';?>">
        <?php } ?></p>
    <?php } else {
        foreach ($index as $key=>$value) {
            $menuElementName=str_replace('mode.','',basename($value,'.php'));$currentMenuItems=explode(',',$session['menu']);$statusFound=(array_search($menuElementName,$currentMenuItems)!==false)?'min':'plus';$menuItemFile=selectedLines('mode.'.$menuElementName.'.php',[1]);$menuItemLangPack=annotationString($menuItemFile[1]);$menuItemLangArr=explode('; ',$menuItemLangPack);$menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
            <p align='center' class='block'>
                <input type="button" class="button" name="<?=$menuElementName;?>" onmouseover="soundButton();" style="width:70%;" value="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>" onclick="omniGo(this.name);"><input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.webp':sysDefPrefix.value+'min.webp';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.webp';?>">
            </p>
        <?php }
    }
} ?>