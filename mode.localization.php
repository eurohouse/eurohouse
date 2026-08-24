<!-- locale -->
<!-- AD: Localización; AG: Localización; AT: Lokalisierung; BE: Localisation; BR: Localização; CH: Localizatio; CL: Localización; CN: 语言; CO: Localización; CU: Localización; CY: Γλωσσολογία; DD: Lokalisierung; DE: Lokalisierung; DR: Lokalisierung; ES: Localización; FR: Localisation; GR: Γλωσσολογία; IT: Localizzazione; JP: 言語; KP: 언어; KR: 언어; LK: भाषाः; MC: Localisation; MD: Localizare; MX: Localización; NP: སྐད་ཡིག།; PT: Localização; RO: Localizare; RU: Локализация; SM: Localizzazione; SP: Localizatio; TR: Diller; UA: Локалізація; VA: Localizatio -->
<p align="center">
<?php $arr=str_replace('.webp','',(str_replace('Flag.','',str_replace('./','',(glob('./Flag.*.webp')))))); foreach ($arr as $val) { ?>
    <img name="<?=$val;?>" style="height:17%;opacity:<?=(in_array($val,explode(',',$session['units_list'])))?1:0.5;?>;" title="<?=$val;?>" src="<?='Flag.'.$val.'.webp';?>" onclick="soundClick(); setdata('units_list',arrangeMenu(sysDefUnitsList.value,this.name,',',true)); if (this.style.opacity==0.5) { this.style.setProperty('opacity',1); } else { this.style.setProperty('opacity',0.5); }">
<?php } ?>
</p>