<!-- info -->
<!-- GR: Ιδιότητες αντικειμένου; DE: Objekteigenschaften; AT: Objekteigenschaften; CY: Ιδιότητες αντικειμένου; FR: Propriétés de l'objet; BE: Propriétés de l'objet; CH: Notitias Objectum; IT: Proprietà dell'oggetto; RU: Свойства объекта; LK: वस्तुगुणाः; IN: वस्तु गुण; ES: Propiedades del objeto; MX: Propiedades del objeto; PT: Propriedades do objeto; BR: Propriedades do objeto; RO: Proprietățile obiectului; MD: Proprietățile obiectului; NP: དངོས་པོའི་ཁྱད་ཆོས།; RS: Својства објекта; UA: Властивості об'єкту; TR: Nesne özellikleri; CN: 文件信息和属性; KR: 파일정보; JP: ファイル情報; AE: خصائص الملف -->
<!-- <ref> -->
<!-- true -->
<?php $objFile = ($request['lock'] != 'false') ? ['name' => $request['input'], 'type' => filetype($request['input']), 'size' => filesize($request['input']), 'mode' => substr(sprintf('%o', fileperms($request['input'])), -4)] : fileopen($request['input']); if ($request['args'] != '') {
    if (strpos($request['args'], '/') !== false) {
        $objReadyArgs = explode('/', $request['args']); $objReadyTab = $objFile; $objReadyScope = $objFile; foreach ($objReadyArgs as $objReadyArg) {
            $objReadyScope = $objReadyTab[$objReadyArg]; $objReadyTab = $objReadyScope;
        } $objReadyData = $objReadyScope;
    } else {
        $objReadyScope = $objFile[$request['args']]; $objReadyData = $objReadyScope;
    }
} else {
    $objReadyData = $objFile;
} if (is_array($objReadyData)) {
    foreach ($objReadyData as $key=>$value) {
        $goArg = ($request['args'] != '') ? $request['args'].'/'.$key : $key;
?><p align='center'><input type="button" name="<?=$goArg;?>" value="<?=$key;?>" style="width:30%;" onmouseover="soundButton();" onclick="omniPath(requestInput.value, this.name, requestLock.value);">
<input type="button" name="<?=$goArg;?>" value="<?=$value;?>" style="width:60%;" onmouseover="soundButton();" onclick="omniPath(requestInput.value, this.name, requestLock.value);">
</p><?php }} else { ?><p align='center'><?=$objReadyData;?></p><?php } ?>