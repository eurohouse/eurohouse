<!-- text -->
<!-- GR: Επεξεργαστής κειμένου; CY: Επεξεργαστής κειμένου; FR: Éditeur de texte; BE: Éditeur de texte; DE: Texteditor; AT: Texteditor; CH: Compositor Textum; IT: Editor de text; ES: Editor de texto; MX: Editor de texto; PT: Editor de texto; BR: Editor de texto; RO: Editor de text; MD: Editor de text; RU: Текстовый редактор; NP: ཡི་གེ་རྩོམ་སྒྲིག་པ།; RS: Текст едитор; UA: Текстовий редактор; IN: पाठ संपादक; TR: Metin düzeltici; LK: पाठ सम्पादक; CN: 文本编辑器; KR: 텍스트 에디터; JP: テキスト編集者; AE: محرر النص -->
<!-- <ref> -->
<!-- true -->
<script>
function saveGUI() {
    var name = filename.value;
    var content = encodeURIComponent(document.getElementById('content').value);
    var dataString = 'name=' + name + '&content=' + content;
    $.ajax({
        type: "POST",
        url: "write.php",
        data: dataString,
        cache: false,
        success: function(html) {
            document.location.reload();
        }
    });
    return false;
}
function replaceText(stri) {
    var str = document.getElementById('content').value;
    var stro = document.getElementById('replacebox').value;
    var strp = str.toString().replace(stri, stro);
    document.getElementById('content').value = strp;
}
function replaceTextAll(stri) {
    var str = document.getElementById('content').value;
    var stro = document.getElementById('replacebox').value;
    var strp = str.toString().replaceAll(stri, stro);
    document.getElementById('content').value = strp;
}
function countText() {
    var sourceText = document.getElementById('content').value;
    var charsCount = sourceText.length;
    document.getElementById('statusBar').innerHTML = 'CHARS = ' + charsCount;
} countText();
</script>
<?php
if ($request['lock'] != 'true') {
    if (file_exists($request['input'])) {
        $content = file_get_contents($request['input']);
    }
}
$newDocumentIcon = $themePrefix.'new.png';
$openDocumentIcon = $themePrefix.'open.png';
$saveDocumentIcon = $themePrefix.'save.png';
$filmDocumentIcon = $themePrefix.'video.png';
$mkdirDocumentIcon = $themePrefix.'mkdir.png';
$moveDocumentIcon = $themePrefix.'move.png';
$dbDocumentIcon = $themePrefix.'database.png';
$copyDocumentIcon = $themePrefix.'copy.png';
$deleteDocumentIcon = $themePrefix.'delete.png';
$infoDocumentIcon = $themePrefix.'info.png';
$homeDocumentIcon = $themePrefix.'home.png';
?>
<img class="actionIcon" src="<?=$newDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="newButton" onclick="omniRead(requestMode.value, 'file', 'true');">
<img class="actionIcon" src="<?=$openDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="openButton" onclick="omniRead(requestMode.value, filename.value, 'false');">
<?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
    <img class="actionIcon" src="<?=$saveDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="saveButton" onclick="saveGUI();">
<?php } else { ?>
    <img class="actionIcon" src="<?=$filmDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="filmButton" onclick="omniRead('media_player', filename.value, 'true');">
<?php } ?>
<img class="actionIcon" src="<?=$mkdirDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="mkdirButton" onclick="mkdir(filename.value, false);">
<?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
    <img class="actionIcon" src="<?=$moveDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="moveButton" onclick="move(filename.value, doto.value, false);">
<?php } else { ?>
    <img class="actionIcon" src="<?=$dbDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="dbButton" onclick="omniPath(filename.value, '', 'false');">
<?php } ?>
<img class="actionIcon" src="<?=$copyDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="copyButton" onclick="copy(filename.value, doto.value, false);">
<?php if ((isset($_SESSION['user'])) && ($sessionID == 'root')) { ?>
    <img class="actionIcon" src="<?=$deleteDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="deleteButton" onclick="recycle(filename.value, false);">
<?php } else { ?>
    <img class="actionIcon" src="<?=$infoDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="infoButton" onclick="omniPath(filename.value, '', 'true');">
<?php } ?>
<img class="actionIcon" src="<?=$homeDocumentIcon.$suffix;?>" onmouseover="soundButton();" id="homeButton" onclick="omniBack('<?=$parent?>');"><br>
<input class="text" id="filename" name="<?=$request['mode'];?>" style="width:36%;" type="text" value="<?=$request['input'];?>" onkeydown="if (event.keyCode == 13) {
    omniRead(this.name, this.value, 'false');
}">
<input class="text" id="doto" style="width:36%;" type="text" value="" onkeydown="if (event.keyCode == 13) {
    saveGUI();
}">
<textarea class="text" id="content" style="width:100%;height:50%;" oninput="countText();"><?=$content;?></textarea><br>
<input class="text" id="findbox" style="width:36%;" type="text" value="">
<input class="text" id="replacebox" style="width:36%;" type="text" value="">
<input type="image" onmouseover="soundButton();" class="power" onclick="replaceText(findbox.value); countText();" src="<?=$prefix.'text.png'.$suffix;?>">
<input type="image" onmouseover="soundButton();" class="power" onclick="replaceTextAll(findbox.value); countText();" src="<?=$prefix.'copy.png'.$suffix;?>">
<br><label id="statusBar" style="width:98%;"></label>
