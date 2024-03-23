<!-- map -->
<!-- RU: Создать новый опрос; CN: 创建新的竞争性民意调查; TW: 创建新的竞争性民意调查; JP: 创建新的竞争性民意调查; AE: إنشاء استطلاع جديد -->
<p align='center' class='block'>
<input type="button" onmouseover="soundButton();" value="Apply" onclick="
var opt = prepareOptions.value; var arr = opt.toString('').split(', ');
var newArr = {}; var elem = ''; var key = ''; var val = '';
var currentlySet = preparePollType.options[preparePollType.selectedIndex].id;
if (currentlySet == 'start_duel') {
    var elem1 = arr[0]; var elem2 = arr[1];
    newArr[elem1] = 0; newArr[elem2] = 0;
} else if (currentlySet == 'init_duel') {
    var elem1 = arr[0]; var elem2 = arr[1];
    var elem1k = elem1.split(': ')[0]; var elem1v = elem1.split(': ')[1];
    var elem2k = elem2.split(': ')[0]; var elem2v = elem2.split(': ')[1];
    newArr[elem1k] = elem1v; newArr[elem2k] = elem2v;
} else if (currentlySet == 'start_multi') {
    for (i = 0; i < arr.length; i++) {
        var elem = arr[i]; newArr[elem] = 0;
    }
} else if (currentlySet == 'init_multi') {
    for (i = 0; i < arr.length; i++) {
        var elem = arr[i]; var key = elem.split(': ')[0];
        var val = elem.split(': ')[1]; newArr[key] = val;
    }
} var obj = {
    'title': encodeURIComponent(prepareTitle.value), 'type': currentlySet,
    'description': encodeURIComponent(prepareDescription.value),
    'range': prepareRange.value, 'options': newArr
};
set(prepareID.value+'.poll', JSON.stringify(obj), true);
omniRead('online_poll', prepareID.value+'.poll', requestLock.value);">
<input type="button" onmouseover="soundButton();" value="Back" onclick="omniBack('<?=$parent;?>');">
</p><p align='center'><label>Name:</label><br>
<input type="text" id="prepareID" style="width:82%;" value="">
<br><label>Title:</label><br>
<input type="text" id="prepareTitle" style="width:62%;" value="">
<select id="preparePollType" style="width:10%;">
<option id="start_multi">Start Multi</option>
<option id="start_duel">Start Duel</option>
<option id="init_multi">Init Multi</option>
<option id="init_duel">Init Duel</option>
</select><input type="number" id="prepareRange" style="width:10%;" value="0"><br>
<label>Description:</label><br>
<textarea id="prepareDescription" style="width:82%;height:25%;" placeholder="What's on your mind?"></textarea><br><label>Options:</label><br>
<textarea id="prepareOptions" style="width:82%;height:25%;" placeholder="Add something here..."></textarea></p>