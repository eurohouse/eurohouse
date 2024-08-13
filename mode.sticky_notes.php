<!-- note -->
<!-- GR: Σημειώσεις; CY: Σημειώσεις; FR: Remarques; BE: Remarques; DE: Anmerkungen; AT: Anmerkungen; CH: Explorare Notae; IT: Note adesive; ES: Notas adhesivas; MX: Notas adhesivas; PT: Lembretes; BR: Lembretes; RO: Note lipicioase; MD: Note lipicioase; RU: Заметки; NP: སྦྱར་བའི་དྲན་ཐོ།; RS: Напомене; UA: Замітки; IN: स्टिकी नोट; TR: Yapışkan notlar; LK: चिपचिपा टिप्पणियाँ; CN: 便利贴; KR: 부착 노트; JP: ポストイット; AE: ورق ملاحظات -->
<p align='center'>
<input type="button" onmouseover="soundButton();" onclick="setdata('notes', bin2hex(myNotesDoc.value)); window.location.reload();" value="<?=term('Apply', $settings['vocabulary'], $session['units']);?>">
<input type="button" onmouseover="soundButton();" onclick="myNotesDoc.value = ''; setdata('notes', '');" value="<?=term('Clear', $settings['vocabulary'], $session['units']);?>"><br>
<textarea id="myNotesDoc" style="width:78%;height:25%;" placeholder="<?=term('What\'s on your mind...', $settings['vocabulary'], $session['units']);?>" onkeydown="if (event.keyCode == 27) {
    myNotesDoc.value = '';
    setdata('notes', '');
} else if (event.keyCode == 8) {
    handleInput(this.value);
} else if (event.keyCode == 46) {
    handleInput(this.value);
}" oninput="handleInput(this.value, true);">
<?=dat($session['notes']);?></textarea>
</p>

