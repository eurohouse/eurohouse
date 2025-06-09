<style>
:root {
    --backsize: <?=$session['back_size'];?>pt;
    --foresize: <?=$session['fore_size'];?>pt;
    --inputsize: <?=$session['input_size'];?>pt;
    --head1size: <?=$session['head1_size'];?>pt;
    --head2size: <?=$session['head2_size'];?>pt;
    --head3size: <?=$session['head3_size'];?>pt;
    --dispsize: <?=$session['disp_size'];?>pt;
    --priv1size: <?=$session['priv1_size'];?>pt;
    --priv2size: <?=$session['priv2_size'];?>pt;
    --priv3size: <?=$session['priv3_size'];?>pt;
    --backcolor: <?=$session['back_color'];?>;
    --forecolor: <?=$session['fore_color'];?>;
    --inputcolor: <?=$session['input_color'];?>;
    --backtextcolor: <?=$session['back_text_color'];?>;
    --foretextcolor: <?=$session['fore_text_color'];?>;
    --inputtextcolor: <?=$session['input_text_color'];?>;
    --blankcolor: <?=$session['blank_color'];?>;
    --blanktextcolor: <?=$session['blank_text_color'];?>;
    --arcforecolor: <?=$session['arc_fore_color'];?>;
    --arcinputcolor: <?=$session['arc_input_color'];?>;
    --background: url("<?=$background;?>");
    --bicolor: <?=alphaChannel($session['back_color'], $session['opacity']);?>;
    --qucolor: <?=alphaChannel($session['back_color'], 'IF');?>;
    --grad-line: <?=$session['gradient_fore'].'deg';?>;
    --grad-button: <?=$session['gradient_button'].'deg';?>;
    --border-radius: <?=$session['border_radius'];?>;
    --text-border-radius: <?=$session['text_border_radius'];?>;
    --box-shadow: <?=$session['box_shadow'];?>;
    --text-box-shadow: <?=$session['text_box_shadow'];?>;
    --text-shadow: <?=$session['text_shadow'];?>;
    --position: <?=$session['position'];?>;
    --filter: brightness(<?=$session['brightness'];?>%) saturate(<?=$session['saturation'];?>%) contrast(<?=$session['contrast'];?>%) sepia(<?=$session['sepia'];?>%) grayscale(<?=$session['grayscale'];?>%) hue-rotate(<?=$session['hue'];?>deg);
    --blur-filter: blur(<?=$session['blur'];?>px) brightness(<?=$session['brightness'];?>%) saturate(<?=$session['saturation'];?>%) contrast(<?=$session['contrast'];?>%) sepia(<?=$session['sepia'];?>%) grayscale(<?=$session['grayscale'];?>%) hue-rotate(<?=$session['hue'];?>deg);
    --gradient-fore: linear-gradient(var(--grad-line), var(--forecolor) 0%, var(--arcforecolor) 100%);
    --gradient-input: linear-gradient(var(--grad-line), var(--inputcolor) 0%, var(--arcinputcolor) 100%);
    --gradient-power: linear-gradient(var(--grad-button), var(--forecolor) 0%, var(--arcforecolor) 100%);
    --backdrop-filter: none; --backdrop-opacity: none;
    --overlay-before-bg: none; --overlay-before-ani: none;
    --overlay-after-bg: none; --overlay-after-ani: none;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_ascii'];?>");
    unicode-range: U+0000-007F;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_latin'];?>");
    unicode-range: U+0080-00FF;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_phone'];?>");
    unicode-range: U+0100-036F;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_greek'];?>");
    unicode-range: U+0386-03CE;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_cyril'];?>");
    unicode-range: U+0400-045F;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_arabi'];?>");
    unicode-range: U+0600-077F;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_korea'];?>");
    unicode-range: U+1100-11FF, U+3130-318F, U+A000-D7A3;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_china'];?>");
    unicode-range: U+2E80-312F, U+3190-9FFF, U+D7A4-FB1C;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_other'];?>");
    unicode-range: U+0370-0385, U+03CF-03FF, U+0460-05FF, U+0590-05FF, U+0780-10FF, U+1200-25FF, U+2700-2E7F, U+FB1D-1F2FF, U+1F650-1F67F, U+1F700-10FFFF;
}
@font-face {
    font-family: "euro";
    src: url("<?=$session['font_emoji'];?>");
    unicode-range: U+2600-26FF, U+1F300-1F64F, U+1F680-1F6FF;
}
@font-face {
    font-family: "userDefine"; src: url("<?=$request['input'];?>");
}
body {
    -moz-filter: var(--filter); filter: var(--filter);
    -moz-backdrop-filter: var(--blur-filter);
    backdrop-filter: var(--blur-filter);
    background-image: var(--background); background-size: cover;
    background-repeat: no-repeat; background-position: var(--position);
    background-color: var(--backcolor); color: var(--backtextcolor);
    font-family: "euro"; font-size: var(--backsize); overflow: hidden;
}
.topBarItem {
    border: none; border-radius: 0px; position: relative;
    background-color: var(--qucolor); color: var(--backtextcolor);
    width: 100%; height: 40px; left: 0%; top: 0px;
}
.topbar {
    border: none; border-radius: 0px; position: relative;
    background-color: var(--qucolor); color: var(--backtextcolor);
    width: 100%; height: 250px; left: 0%; top: -2px;
    display: flex; flex-direction: column; flex-wrap: nowrap;
}
.upperGap {
    border: none; border-radius: 0px; position: relative;
    background-color: var(--qucolor); color: var(--backtextcolor);
    width: 100%; height: 2.8em; left: 0%; top: -2px;
    text-align: center; overflow: hidden;
}
.lowerGap {
    border: none; border-radius: 0px; position: relative;
    background-color: var(--qucolor); color: var(--backtextcolor);
    width: 100%; height: 1.5em; left: 0%; top: -5px;
    text-align: center; overflow: hidden;
}
@keyframes scrollMarquee {
    to { transform: translateX(-100%); }
}
.urgent {
    overflow: hidden; cursor: pointer; display: inline-block;
}
.marquee {
    overflow: hidden; white-space: nowrap; cursor: pointer;
    display: inline-block; animation: scrollMarquee 60s linear infinite;
}
.panel {
    border: none; border-radius: 0px; position: relative;
    background-color: var(--qucolor); color: var(--backtextcolor);
    overflow-y: scroll; width: 100%; height: 50%; left: 0%; top: -2px;
}
.customPanel {
    border: none; border-radius: 0px; position: relative;
    background-color: var(--qucolor); color: var(--backtextcolor);
}
.notesMenu {
    float: left; overflow-y: scroll; width: 20%; flex: 0%;
}
.notesContent {
    float: right; width: 80%; flex: 0%;
}
.notesRow {
    display: flex; height: 70%;
}
.notesRow:after {
    content: ""; display: table; clear: both;
}
.overlay {
    width: 100%; height: 100%; filter: var(--backdrop-filter);
    border: none; border-radius: 0px;
    background-color: var(--bicolor); color: var(--backtextcolor);
}
.overlay:before {
    content: ''; position: absolute; opacity: var(--backdrop-opacity);
    width: 100%; height: 100%; z-index: -1000; top: 0; left: 0;
    background: var(--overlay-before-bg);
    animation: var(--overlay-before-ani);
}
.overlay:after {
    content: ''; position: absolute; opacity: var(--backdrop-opacity);
    width: 100%; height: 100%; z-index: -1000; top: 0; left: 0;
    background: var(--overlay-after-bg);
    animation: var(--overlay-after-ani);
}
@keyframes vlines {
    0%, 100% { transform: translateX(0%); opacity: 0.5; }
    10% { transform: translateX(-1%); }
    20% { transform: translateX(1%); }
    30% { transform: translateX(-2%); opacity: 0.75; }
    40% { transform: translateX(3%); }
    50% { transform: translateX(-3%); opacity: 0.5; }
    60% { transform: translateX(8%); }
    70% { transform: translateX(-3%); opacity: 0.5; }
    80% { transform: translateX(10%); opacity: 0.25; }
    90% { transform: translateX(-2%); }
}
@keyframes grains {
    0%, 100% { transform: translate(0%, 0%); }
    10% { transform: translate(-1%, -1%); }
    20% { transform: translate(1%, 1%); }
    30% { transform: translate(-2%, -2%); }
    40% { transform: translate(3%, 3%); }
    50% { transform: translate(-3%, -3%); }
    60% { transform: translate(4%, 4%); }
    70% { transform: translate(-4%, -4%); }
    80% { transform: translate(2%, 2%); }
    90% { transform: translate(-3%, -3%); }
}
a, p, b, i, span, label {
    color: var(--backtextcolor);
    font-family: "euro"; font-size: var(--backsize);
    text-shadow: var(--text-shadow);
}
table, tr, td, th {
    color: var(--backtextcolor);
    font-family: "euro"; font-weight: normal;
    font-size: var(--backsize); text-align: center;
    border-collapse: separate; border-spacing: 0;
    text-shadow: var(--text-shadow);
}
table thead {
    color: var(--backtextcolor);
    font-family: "euro"; font-weight: normal;
    font-size: var(--backsize); text-align: center;
    position: sticky; z-index: 1;
    inset-block-start: 0;
    text-shadow: var(--text-shadow);
}
table tfoot {
    color: var(--backtextcolor);
    font-family: "euro"; font-weight: normal;
    font-size: var(--backsize); text-align: center;
    position: sticky; z-index: 1;
    inset-block-end: 0;
    text-shadow: var(--text-shadow);
}
img { position: relative; }
input[type=button], input[type=image], button {
    background: var(--gradient-fore); background-size: 100%;
    color: var(--foretextcolor); border: none;
    border-radius: var(--border-radius); font-family: "euro";
    font-size: var(--foresize); position: relative;
    height: 1.4em; display: inline-block;
    vertical-align: baseline; box-shadow: var(--box-shadow);
}
.power {
    background: var(--gradient-power); background-size: 100%;
    color: var(--foretextcolor); border: none;
    border-radius: var(--border-radius); font-family: "euro";
    font-size: var(--foresize); position: relative;
    width: 1.4em; top: 7px; display: inline-block;
    vertical-align: baseline; box-shadow: var(--box-shadow);
}
input[type=text], input[type=password], input[type=number], select, option, textarea {
    background: var(--gradient-input); background-size: 100%;
    color: var(--inputtextcolor); border: none;
    border-radius: var(--text-border-radius); font-family: "euro";
    font-size: var(--inputsize); position: relative;
    height: 1.4em; display: inline-block;
    vertical-align: baseline;
    box-shadow: var(--text-box-shadow);
}
@supports (-moz-appearance: none) {
    select {
        -moz-appearance: none !important;
        background: var(--gradient-input); background-size: 100%;
        color: var(--inputtextcolor); border: none;
        border-radius: var(--text-border-radius); font-family: "euro";
        font-size: var(--inputsize); position: relative;
        height: 1.4em; display: inline-block;
        vertical-align: baseline;
        box-shadow: var(--text-box-shadow);
    }
}
option {
    -webkit-appearance: none; -moz-appearance: none;
    background-color: var(--inputcolor);
    color: var(--inputtextcolor); border: none;
    font-size: var(--inputsize); position: relative;
    font-family: "euro"; height: 1.4em;
}
input[type=checkbox] {
    background: var(--gradient-input); background-size: 100%;
    border: none; border-radius: var(--border-radius); position: relative;
    width: 1.4em; height: 1.4em; display: inline-block;
    vertical-align: baseline; box-shadow: var(--text-box-shadow);
}
input[type=range] {
    appearance: none; position: relative;
    width: 90%; height: 26px; border: none; outline: none;
    border-radius: var(--border-radius); background: var(--gradient-input);
    background-size: 100%; box-shadow: var(--box-shadow);
}
input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none; appearance: none;
    position: relative; border: none;
    width: 26px; height: 26px;
    border-radius: var(--border-radius); 
    background: var(--gradient-fore); cursor: pointer;
    background-size: 100%; box-shadow: var(--box-shadow);
}
input[type=range]::-moz-range-thumb {
    -moz-appearance: none; appearance: none;
    position: relative; border: none;
    width: 26px; height: 26px;
    border-radius: var(--border-radius); 
    background: var(--gradient-fore); cursor: pointer;
    background-size: 100%; box-shadow: var(--box-shadow);
}
h1 {
    color: var(--backtextcolor); font-family: "euro";
    font-size: var(--head1size); font-weight: normal;
    text-shadow: var(--text-shadow);
}
h2 {
    color: var(--backtextcolor); font-family: "euro";
    font-size: var(--head2size); font-weight: normal;
    text-shadow: var(--text-shadow);
}
h3 {
    color: var(--backtextcolor); font-family: "euro";
    font-size: var(--head3size); font-weight: normal;
    text-shadow: var(--text-shadow);
}
.block {
    color: var(--backtextcolor); font-family: "euro";
    font-size: 0.2em; top: 3px;
}
.userDefine {
    color: var(--backtextcolor); font-family: "userDefine"; font-size: var(--dispsize);
}
</style>
