<!-- disk -->
<!-- AD: Lista de canciones; AG: Lista de canciones; AT: Album-Trackliste; BE: Liste des titres; BR: Lista de faixas; CL: Lista de canciones; CN: 专辑曲目列表; CO: Lista de canciones; CU: Lista de canciones; CY: Λίστα κομματιών άλμπουμ; DD: Album-Trackliste; DE: Album-Trackliste; DR: Album-Trackliste; ES: Lista de canciones; FR: Liste des titres; GR: Λίστα κομματιών άλμπουμ; IN: एल्बम ट्रैकलिस्ट; IT: Elenco tracce dell'album; JP: トラックリスト; KP: 앨범 트랙리스트; KR: 앨범 트랙리스트; LK: एल्बम ट्रैकलिस्ट; MC: Liste des titres; MD: Listă de melodii; MX: Lista de canciones; NP: གླུ་གཞས་ཆེད་བསྒྲིགས།; PT: Lista de faixas; RO: Listă de melodii; RS: Листа песама албума; RU: Список композиций; SM: Elenco tracce dell'album; TR: Albüm Şarkı Listesi; UA: Список треків -->
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