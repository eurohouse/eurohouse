<?php if ($request['lock'] == 'true') {
    if ($session['icons'] == 1) { ?>
    <p align="center"><?php foreach ($index as $key=>$value) {
        if (file_exists('mode.'.$value.'.php')) {
            $menuItemFile = paging('mode.'.$value.'.php', [0,1]);
            $menuItemIcon = str_replace(' -->', '', str_replace('<!-- ', '', $menuItemFile[0])); $elementIcon = (themed($themePrefix, $menuItemIcon)) ? $themePrefix.$menuItemIcon.'.png' : $portfolioPrefix.$menuItemIcon.'.png';
            $menuItemLangPack = str_replace(' -->', '', str_replace('<!-- ', '', $menuItemFile[1])); $menuItemLangArr = explode('; ', $menuItemLangPack);
            $menuItemLangNew = []; foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
                $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
                $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?>
<img onmouseover="soundButton();" name="<?=$value;?>" style="height:25%;position:relative;" onclick="omniGo(this.name);" src="<?=$elementIcon.$suffix;?>" title="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($value);?>"><?php }} foreach ($appIndex as $key=>$value) {
    $eurArrayPkg = eurarr($value);
        if (!isset($eurArrayPkg['run'])) {
            unset($appIndex[array_search($value, $appIndex)]);
        }
    } foreach ($appIndex as $key=>$value) {
        $eurArrPkg = eurarr($value); if (isset($eurArrPkg['favicon'])) {
            if (file_exists($eurArrPkg['favicon'])) {
                $eurArrFavicon = $eurArrPkg['favicon'];
            } else {
                $eurArrFavicon = $themePrefix.'package.png';
            }
        } else {
            $eurArrFavicon = $themePrefix.'package.png';
        } ?>
<img onmouseover="soundButton();" name="<?=$eurArrPkg['run'];?>" style="height:25%;position:relative;" onclick="window.location.href=this.name;" src="<?=$eurArrFavicon.$suffix;?>" title="<?=$eurArrPkg['title'];?>">
<?php } ?></p><?php } else {
    foreach ($index as $key=>$value) {
        if (file_exists('mode.'.$value.'.php')) {
            $menuItemFile = paging('mode.'.$value.'.php', [1]);
            $menuItemLangPack = str_replace(' -->', '', str_replace('<!-- ', '', $menuItemFile[1])); $menuItemLangArr = explode('; ', $menuItemLangPack); $menuItemLangNew = [];
            foreach ($menuItemLangArr as $menuItemLangStr) {
                $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
                $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
                $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
            } ?><p align='center'>
    <input type="button" class="button" name="<?=$value;?>" onmouseover="soundButton();" style="width:80%;position:relative;" value="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($value);?>" onclick="omniGo(this.name);">
    </p><?php }} foreach ($appIndex as $key=>$value) {
        $eurArrayPkg = eurarr($value); if (!isset($eurArrayPkg['run'])) {
            unset($appIndex[array_search($value, $appIndex)]);
        }
    } foreach ($appIndex as $key=>$value) {
        $eurArrPkg = eurarr($value); ?><p align='center'>
        <input type="button" class="button" name="<?=$eurArrPkg['run'];?>" onmouseover="soundButton();" style="width:80%;position:relative;" value="<?=$eurArrPkg['title'];?>" onclick="window.location.href=this.name;"></p>
    <?php }}} else {
    foreach ($index as $key=>$value) {
        $menuElement = basename($value, '.php');
        $menuElementName = str_replace('mode.', '', $menuElement);
        $currentMenuItems = explode(',', $session['menu']);
        $statusFound = (array_search($menuElementName, $currentMenuItems) !== false) ? 'min' : 'plus'; $menuItemFile = paging('mode.'.$menuElementName.'.php', [1]);
        $menuItemLangPack = str_replace(' -->', '', str_replace('<!-- ', '', $menuItemFile[1])); $menuItemLangArr = explode('; ', $menuItemLangPack);
        $menuItemLangNew = []; foreach ($menuItemLangArr as $menuItemLangStr) {
            $menuItemLangKey = explode(': ', $menuItemLangStr)[0];
            $menuItemLangVal = explode(': ', $menuItemLangStr)[1];
            $menuItemLangNew[$menuItemLangKey] = $menuItemLangVal;
        } ?><p align='center' class='block'>
        <input type="button" class="button" name="<?=$menuElementName;?>" onmouseover="soundButton();" style="width:70%;position:relative;" value="<?=(isset($menuItemLangNew[$session['units']])) ? $menuItemLangNew[$session['units']] : spaces($menuElementName);?>" onclick="omniGo(this.name);">
        <input type="image" name="<?=$menuElementName;?>" onmouseover="soundButton();" class="power" onclick="this.src = (isInMenu(sysDefMenu.value, this.name)) ? sysDefPrefix.value+'plus.png'+sysDefSuffix.value : sysDefPrefix.value+'min.png'+sysDefSuffix.value; setdata('menu', arrangeMenu(sysDefMenu.value, this.name));" src="<?=$prefix.$statusFound.'.png'.$suffix;?>"></p>
        <?php } ?>
    </p>
<?php } ?>