<?php if ($request['lock']=='true') {
    if ($session['icons']==1) { ?>
    <p align='center' class='block'>
    <?php foreach ($index as $key=>$value) {
        if (file_exists('mode.'.$value.'.php')) {
            $menuItemFile=paging('mode.'.$value.'.php', [0,1]);
            $menuItemIcon=annotationString($menuItemFile[0]);
            $elementIcon=(themed($themePrefix, $menuItemIcon))?$themePrefix.$menuItemIcon.'.png':$portfolioPrefix.$menuItemIcon.'.png';
            $menuItemLangPack=annotationString($menuItemFile[1]);
            $menuItemLangArr=explode('; ',$menuItemLangPack);
            $menuItemLangNew=[]; foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
            } ?>
<img onmouseover="soundButton();" loading="lazy" name="<?=$value;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>"><?php }} if ($session['apps']!=0) { foreach ($appIndex as $key=>$value) {
    $eurArrayPkg=(@json_decode(file_get_contents($value),true)!=null)?json_decode(file_get_contents($value),true):[];
        if (!isset($eurArrayPkg['run'])) {
            unset($appIndex[array_search($value,$appIndex)]);
        }
    } foreach ($appIndex as $key=>$value) {
        $eurArrPkg=(@json_decode(file_get_contents($value),true)!=null)?json_decode(file_get_contents($value),true):[];
        if (isset($eurArrPkg['favicon'])) {
            $eurArrFavicon=(file_exists($eurArrPkg['favicon']))?$eurArrPkg['favicon']:$themePrefix.'package.png';
        } else {
            $eurArrFavicon=$themePrefix.'package.png';
        } ?>
<img onmouseover="soundButton();" loading="lazy" name="<?=$eurArrPkg['run'];?>" style="height:20%;" onclick="window.location.href=this.name;" src="<?=$eurArrFavicon;?>" title="<?=$eurArrPkg['title'];?>">
<?php }} ?>
</p>
<?php } else {
    foreach ($index as $key=>$value) {
        if (file_exists('mode.'.$value.'.php')) {
            $menuItemFile=paging('mode.'.$value.'.php',[1]);
            $menuItemLangPack=annotationString($menuItemFile[1]);
            $menuItemLangArr=explode('; ',$menuItemLangPack); $menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
            } ?>
    <p align='center'><input type="button" class="button" name="<?=$value;?>" onmouseover="soundButton();" style="width:80%;" value="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($value);?>" onclick="omniGo(this.name);"></p>
    <?php }} if ($session['apps']!=0) {
    foreach ($appIndex as $key=>$value) {
        $eurArrayPkg=(@json_decode(file_get_contents($value),true)!=null)?json_decode(file_get_contents($value),true):[];
        if (!isset($eurArrayPkg['run'])) {
            unset($appIndex[array_search($value,$appIndex)]);
        }
    } foreach ($appIndex as $key=>$value) {
        $eurArrPkg=(@json_decode(file_get_contents($value),true)!=null)?json_decode(file_get_contents($value),true):[]; ?>
        <p align='center'><input type="button" class="button" name="<?=$eurArrPkg['run'];?>" onmouseover="soundButton();" style="width:80%;" value="<?=$eurArrPkg['title'];?>" onclick="window.location.href=this.name;"></p>
    <?php }}}} else { if ($session['icons']==1) { ?>
        <p align='center' class='block'>
        <?php foreach ($index as $key=>$value) {
            $menuElementName=str_replace('mode.','',basename($value,'.php'));$currentMenuItems=explode(',',$session['menu']);$statusFound=(array_search($menuElementName,$currentMenuItems)!==false)?'min':'plus';$menuItemFile=paging('mode.'.$menuElementName.'.php',[0,1]);$menuItemIcon=annotationString($menuItemFile[0]);$elementIcon=(themed($themePrefix,$menuItemIcon))?$themePrefix.$menuItemIcon.'.png':$portfolioPrefix.$menuItemIcon.'.png';$menuItemLangPack=annotationString($menuItemFile[1]);$menuItemLangArr=explode('; ',$menuItemLangPack);$menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey]=$menuItemLangVal;
            } ?>
        <img onmouseover="soundButton();" loading="lazy" name="<?=$menuElementName;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>">
        <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.png';?>">
        <?php } ?>
        </p>
        <?php } else {
            foreach ($index as $key=>$value) {
            $menuElementName=str_replace('mode.','',basename($value,'.php'));$currentMenuItems=explode(',',$session['menu']);$statusFound=(array_search($menuElementName,$currentMenuItems)!==false)?'min':'plus';$menuItemFile=paging('mode.'.$menuElementName.'.php',[1]);$menuItemLangPack=annotationString($menuItemFile[1]);$menuItemLangArr=explode('; ',$menuItemLangPack);$menuItemLangNew=[];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey=explode(': ',$menuItemLangStr)[0];$menuItemLangVal=explode(': ',$menuItemLangStr)[1];$menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
        <p align='center' class='block'>
        <input type="button" class="button" name="<?=$menuElementName;?>" onmouseover="soundButton();" style="width:70%;" value="<?=(isset($menuItemLangNew[$session['units']]))?$menuItemLangNew[$session['units']]:snakeToSpaces($menuElementName);?>" onclick="omniGo(this.name);"><input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src=(isInMenu(sysDefMenu.value,this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png';setdata('menu',arrangeMenu(sysDefMenu.value,this.name));" src="<?=$prefix[3].$statusFound.'.png';?>">
        </p>
        <?php } ?>
<?php }} ?>