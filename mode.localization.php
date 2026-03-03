<!-- locale -->
<!-- GR: Γλωσσολογία; CY: Γλωσσολογία; DE: Lokalisierung; AT: Lokalisierung; CH: Localizatio; FR: Localisation; BE: Localisation; IT: Localizzazione; ES: Localización; MX: Localización; RO: Localizare; MD: Localizare; RU: Локализация; UA: Локалізація; PT: Localização; BR: Localização; NP: སྐད་ཡིག།; TR: Diller; LK: भाषाः; CN: 语言; KR: 언어; JP: 言語 -->
<p align="center">
<?php $arr=str_replace('.png','',(str_replace('Flag.','',str_replace('./','',(glob('./Flag.*.png')))))); foreach ($arr as $val) { ?>
    <img name="<?=$val;?>" style="height:17%;opacity:<?=(in_array($val,explode(',',$session['units_list'])))?1:0.5;?>;" title="<?=$val;?>" src="<?='Flag.'.$val.'.png';?>" onclick="setdata('units_list',arrangeMenu(sysDefUnitsList.value,this.name,',',true)); if (this.style.opacity==0.5) { this.style.setProperty('opacity',1); } else { this.style.setProperty('opacity',0.5); }">
<?php } ?>
</p>