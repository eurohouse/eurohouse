<!-- disk -->
<!-- GR: Λίστα κομματιών άλμπουμ; DE: Album-Trackliste; AT: Album-Trackliste; CY: Λίστα κομματιών άλμπουμ; ES: Lista de canciones; MX: Lista de canciones; FR: Liste des titres; BE: Liste des titres; TR: Albüm Şarkı Listesi; IT: Elenco tracce dell'album; RO: Listă de melodii; MD: Listă de melodii; LK: एल्बम ट्रैकलिस्ट; IN: एल्बम ट्रैकलिस्ट; RU: Список композиций; RS: Листа песама албума; NP: གླུ་གཞས་ཆེད་བསྒྲིགས།; BR: Lista de faixas; PT: Lista de faixas; UA: Список треків; CN: 专辑曲目列表; KR: 앨범 트랙리스트; JP: トラックリスト -->
<div class='customPanel' style="width:100%;height:15%;left:0px;top:0px;">
    <p align='center' class='block'>
    <input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'image.png';?>" onclick="setdata('album','background'); playlistCollectionHTML();">
    <input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'user.png';?>" onclick="setdata('album','avatar'); playlistCollectionHTML();">
    <input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'start.png';?>" onclick="setdata('album','pictogram'); playlistCollectionHTML();">
    <input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'music.png';?>" onclick="setdata('album','music'); playlistCollectionHTML();">
    <input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'audio.png';?>" onclick="setdata('album','sound'); playlistCollectionHTML();">
    <input type="image" class="power" onmouseover="soundButton();" src="<?=$prefix[3].'font.png';?>" onclick="setdata('album','font'); playlistCollectionHTML();">
</div>
<div class='customPanel' id='playlist_disp' style="width:100%;height:25%;left:0px;top:0px;overflow-y:scroll;">
    <p align='left' id="currentPlaylist"></p>
</div>
<div class='customPanel' id='album_disp' style="width:100%;height:55%;left:0px;top:0px;overflow-y:scroll;">
    <p align='left' id="currentAlbumList"></p>
</div>