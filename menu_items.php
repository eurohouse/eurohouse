<?php if ($request['lock'] == 'true') {
    if ($session['icons'] == 1) { ?>
    <p align='center' class='block'>
    <?php foreach ($index as $key=>$value) {
        if (file_exists('mode.'.$value.'.php')) {
            $menuItemFile = paging('mode.'.$value.'.php', [0,1]);
            $menuItemIcon = escHTML($menuItemFile[0]);
            $elementIcon = (themed($themePrefix, $menuItemIcon)) ? $themePrefix.$menuItemIcon.'.png' : $portfolioPrefix.$menuItemIcon.'.png';
            $menuItemLangPack = escHTML($menuItemFile[1]);
            $menuItemLangArr = explode('; ', $menuItemLangPack);
            $menuItemLangNew = []; foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
                $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
                $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
<img onmouseover="soundButton();" loading="lazy" name="<?=$value;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($value);?>">
<?php }} if ($session['apps'] != 0) { foreach ($appIndex as $key=>$value) {
    $eurArrayPkg = (@json_decode(file_get_contents($value), true) != null) ? json_decode(file_get_contents($value), true) : [];
        if (!isset($eurArrayPkg['run'])) {
            unset($appIndex[array_search($value, $appIndex)]);
        }
    } foreach ($appIndex as $key=>$value) {
        $eurArrPkg = (@json_decode(file_get_contents($value), true) != null) ? json_decode(file_get_contents($value), true) : [];
        if (isset($eurArrPkg['favicon'])) {
            if (file_exists($eurArrPkg['favicon'])) {
                $eurArrFavicon = $eurArrPkg['favicon'];
            } else {
                $eurArrFavicon = $themePrefix.'package.png';
            }
        } else {
            $eurArrFavicon = $themePrefix.'package.png';
        } ?>
<img onmouseover="soundButton();" loading="lazy" name="<?=$eurArrPkg['run'];?>" style="height:25%;" onclick="window.location.href=this.name;" src="<?=$eurArrFavicon;?>" title="<?=$eurArrPkg['title'];?>">
<?php }} ?>
</p>
<?php } else {
    foreach ($index as $key=>$value) {
        if (file_exists('mode.'.$value.'.php')) {
            $menuItemFile = paging('mode.'.$value.'.php', [1]);
            $menuItemLangPack = escHTML($menuItemFile[1]);
            $menuItemLangArr = explode('; ', $menuItemLangPack); $menuItemLangNew = [];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
                $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
                $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
    <p align='center'>
    <input type="button" class="button" name="<?=$value;?>" onmouseover="soundButton();" style="width:80%;" value="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($value);?>" onclick="omniGo(this.name);">
    </p>
    <?php }} if ($session['apps'] != 0) {
    foreach ($appIndex as $key=>$value) {
        $eurArrayPkg = (@json_decode(file_get_contents($value), true) != null) ? json_decode(file_get_contents($value), true) : [];
        if (!isset($eurArrayPkg['run'])) {
            unset($appIndex[array_search($value, $appIndex)]);
        }
    } foreach ($appIndex as $key=>$value) {
        $eurArrPkg = (@json_decode(file_get_contents($value), true) != null) ? json_decode(file_get_contents($value), true) : []; ?>
        <p align='center'>
        <input type="button" class="button" name="<?=$eurArrPkg['run'];?>" onmouseover="soundButton();" style="width:80%;" value="<?=$eurArrPkg['title'];?>" onclick="window.location.href=this.name;">
        </p>
    <?php }}}} else {
        if ($session['icons'] == 1) { ?>
        <p align='center' class='block'>
        <?php foreach ($index as $key=>$value) {
            $menuElementName = str_replace('mode.', '', basename($value, '.php'));
            $currentMenuItems = explode(',', $session['menu']);
            $statusFound = (array_search($menuElementName, $currentMenuItems) !== false) ? 'min' : 'plus';
            $menuItemFile = paging('mode.'.$menuElementName.'.php', [0,1]);
            $menuItemIcon = escHTML($menuItemFile[0]);
            $elementIcon = (themed($themePrefix, $menuItemIcon)) ? $themePrefix.$menuItemIcon.'.png' : $portfolioPrefix.$menuItemIcon.'.png';
            $menuItemLangPack = escHTML($menuItemFile[1]);
            $menuItemLangArr = explode('; ', $menuItemLangPack);
            $menuItemLangNew = []; foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
                $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
                $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
        <img onmouseover="soundButton();" loading="lazy" name="<?=$menuElementName;?>" style="height:20%;" onclick="omniGo(this.name);" src="<?=$elementIcon;?>" title="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($menuElementName);?>">
        <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isInMenu(sysDefMenu.value, this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png'; setdata('menu', arrangeMenu(sysDefMenu.value, this.name));" src="<?=$prefix.$statusFound.'.png';?>">
        <?php } ?>
        </p>
        <?php } else {
            foreach ($index as $key=>$value) {
            $menuElementName = str_replace('mode.', '', basename($value, '.php'));
            $currentMenuItems = explode(',', $session['menu']);
            $statusFound = (array_search($menuElementName, $currentMenuItems) !== false) ? 'min' : 'plus';
            $menuItemFile = paging('mode.'.$menuElementName.'.php', [1]);
            $menuItemLangPack = escHTML($menuItemFile[1]);
            $menuItemLangArr = explode('; ', $menuItemLangPack);
            $menuItemLangNew = []; foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
                $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
                $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
        <p align='center' class='block'>
        <input type="button" class="button" name="<?=$menuElementName;?>" onmouseover="soundButton();" style="width:70%;" value="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($menuElementName);?>" onclick="omniGo(this.name);">
        <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isInMenu(sysDefMenu.value, this.name))?sysDefPrefix.value+'plus.png':sysDefPrefix.value+'min.png'; setdata('menu', arrangeMenu(sysDefMenu.value, this.name));" src="<?=$prefix.$statusFound.'.png';?>">
        </p>
        <?php } ?>
<?php }} ?>