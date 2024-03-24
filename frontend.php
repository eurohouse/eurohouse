<script>
window.onload = function() {
    <?php if (isset($_SESSION['user'])) { ?>
        document.getElementById('omniBox').focus();
    <?php } else { ?>
        document.getElementById('omniBoxAuthLogin').focus();
    <?php } ?>
    if ((sysDefAutoplay.value == 1) && (sysDefPlaying.value == 1)) {
        omniListen(hex2bin(sysDefMelody.value));
    }
}
$(document).ready(function() {
    setInterval(world_clock, 1000);
    setInterval(visual_effects, 1000);
    setInterval(wallpaper_engine, 1000);
});
function omniListen(input, scratch = false) {
    var currentPos = 0;
    playAudio(audioPlayer, input); currentPos = parseInt(sysDefCurrent.value);
    audioPlayer.currentTime = (scratch) ? 0 : currentPos;
    setdata('melody', bin2hex(input));
    var searchValue = (input.split('?')[0]).replace(requestPath.value+'/', '');
}
function omniPause() {
    pauseAudio(audioPlayer);
}
function audioPosition(sec) {
    if (audioPlayer.duration > sec) {
        if (sec.includes('-')) {
            audioPlayer.currentTime = audioPlayer.duration - parseInt(sec.replace('-',''));
        } else if (sec.includes('+')) {
            audioPlayer.currentTime = parseInt(sec.replace('+',''));
        } else {
            audioPlayer.currentTime = parseInt(sec);
        }
    }
}
function savePlayState() {
    setdata('current', audioPlayer.currentTime);
}
function userdata() {
    var obj = {
        'timezone': sysDefTimezone.value,
        'units': sysDefUnits.value,
        'units_list': sysDefUnitsList.value,
        'melody': sysDefMelody.value,
        'current': sysDefCurrent.value,
        'playing': sysDefPlaying.value,
        'autoplay': sysDefAutoplay.value,
        'force': sysDefForce.value,
        'hour': sysDefHour.value,
        'entry': sysDefEntry.value,
        'bardot': sysDefBardot.value,
        'faceoff': sysDefFaceoff.value,
        'timedisp': sysDefTimedisp.value,
        'benchmark': sysDefBenchmark.value,
        'lock': sysDefLock.value,
        'icons': sysDefIcons.value,
        'mute': sysDefMute.value,
        'gloss': sysDefGloss.value,
        'personal': sysDefPersonal.value,
        'observe': sysDefObserve.value,
        'spectate': sysDefSpectate.value,
        'vintage': sysDefVintage.value,
        'magnitude': sysDefMagnitude.value,
        'title': sysDefTitle.value,
        'description': sysDefDescription.value,
        'avatar': sysDefAvatar.value,
        'reticle': sysDefReticle.value,
        'reticle_choice_1': sysDefReticleChoice1.value,
        'reticle_choice_2': sysDefReticleChoice2.value,
        'reticle_choice_3': sysDefReticleChoice3.value,
        'reticle_choice_4': sysDefReticleChoice4.value,
        'reticle_choice_5': sysDefReticleChoice5.value,
        'radius': sysDefRadius.value,
        'box_shadow': sysDefBoxShadow.value,
        'gradient_deg': sysDefGradientDeg.value,
        'back_size': sysDefBackSize.value,
        'fore_size': sysDefForeSize.value,
        'input_size': sysDefInputSize.value,
        'head1_size': sysDefHead1Size.value,
        'head2_size': sysDefHead2Size.value,
        'head3_size': sysDefHead3Size.value,
        'disp_size': sysDefDispSize.value,
        'priv1_size': sysDefPriv1Size.value,
        'priv2_size': sysDefPriv2Size.value,
        'priv3_size': sysDefPriv3Size.value,
        'opacity': sysDefOpacity.value,
        'blur': sysDefBlur.value,
        'brightness': sysDefBrightness.value,
        'saturation': sysDefSaturation.value,
        'contrast': sysDefContrast.value,
        'sepia': sysDefSepia.value,
        'grayscale': sysDefGrayscale.value,
        'hue': sysDefHue.value,
        'gender': sysDefGender.value,
        'specimen': sysDefSpecimen.value,
        'font_ascii': sysDefFontAscii.value,
        'font_latin': sysDefFontLatin.value,
        'font_phone': sysDefFontPhone.value,
        'font_greek': sysDefFontGreek.value,
        'font_cyril': sysDefFontCyril.value,
        'font_arabi': sysDefFontArabi.value,
        'font_korea': sysDefFontKorea.value,
        'font_china': sysDefFontChina.value,
        'font_other': sysDefFontOther.value,
        'font_emoji': sysDefFontEmoji.value,
        'back_color': sysDefBackColor.value,
        'fore_color': sysDefForeColor.value,
        'input_color': sysDefInputColor.value,
        'back_text_color': sysDefBackTextColor.value,
        'fore_text_color': sysDefForeTextColor.value,
        'input_text_color': sysDefInputTextColor.value,
        'blank_color': sysDefBlankColor.value,
        'blank_text_color': sysDefBlankTextColor.value,
        'arc_fore_color': sysDefArcForeColor.value,
        'arc_input_color': sysDefArcInputColor.value,
        'background': sysDefBackground.value,
        'menu': sysDefMenu.value,
        'theme': sysDefTheme.value,
        'memo': sysDefMemo.value,
        'position': sysDefPosition.value,
        'date_format': sysDefDateFormat.value,
        'time_format': sysDefTimeFormat.value,
        'alarm_sound': sysDefAlarmSound.value,
        'ticking_sound': sysDefTickingSound.value,
        'background_sound': sysDefBackgroundSound.value,
        'focus_sound': sysDefFocusSound.value,
        'type_sound': sysDefTypeSound.value,
        'error_sound': sysDefErrorSound.value,
        'notify_sound': sysDefNotifySound.value,
        'bind_sound': sysDefBindSound.value,
        'hit_sound': sysDefHitSound.value,
        'suffer_sound': sysDefSufferSound.value
    };
    return obj;
}
function setdata(ent, val) {
    var obj = userdata(); obj[ent] = val;
    set(sysDefSessionID.value+'_session.json', JSON.stringify(obj), true);
    sysDefDateFormat.value = obj['date_format'];
    sysDefTimeFormat.value = obj['time_format'];
    sysDefTimezone.value = obj['timezone'];
    sysDefPosition.value = obj['position'];
    sysDefUnits.value = obj['units'];
    sysDefMelody.value = obj['melody'];
    sysDefCurrent.value = obj['current'];
    sysDefPlaying.value = obj['playing'];
    sysDefAutoplay.value = obj['autoplay'];
    sysDefForce.value = obj['force'];
    sysDefBackground.value = obj['background'];
    sysDefAvatar.value = obj['avatar'];
    sysDefReticle.value = obj['reticle'];
    sysDefReticleChoice1.value = obj['reticle_choice_1'];
    sysDefReticleChoice2.value = obj['reticle_choice_2'];
    sysDefReticleChoice3.value = obj['reticle_choice_3'];
    sysDefReticleChoice4.value = obj['reticle_choice_4'];
    sysDefReticleChoice5.value = obj['reticle_choice_5'];
    sysDefTitle.value = obj['title'];
    sysDefDescription.value = obj['description'];
    sysDefMemo.value = obj['memo'];
    sysDefHour.value = obj['hour'];
    sysDefEntry.value = obj['entry'];
    sysDefSpecimen.value = obj['specimen'];
    sysDefFontAscii.value = obj['font_ascii'];
    sysDefFontLatin.value = obj['font_latin'];
    sysDefFontPhone.value = obj['font_phone'];
    sysDefFontGreek.value = obj['font_greek'];
    sysDefFontCyril.value = obj['font_cyril'];
    sysDefFontArabi.value = obj['font_arabi'];
    sysDefFontKorea.value = obj['font_korea'];
    sysDefFontChina.value = obj['font_china'];
    sysDefFontOther.value = obj['font_other'];
    sysDefFontEmoji.value = obj['font_emoji'];
    sysDefAlarmSound.value = obj['alarm_sound'];
    sysDefTickingSound.value = obj['ticking_sound'];
    sysDefBackgroundSound.value = obj['background_sound'];
    sysDefFocusSound.value = obj['focus_sound'];
    sysDefTypeSound.value = obj['type_sound'];
    sysDefErrorSound.value = obj['error_sound'];
    sysDefNotifySound.value = obj['notify_sound'];
    sysDefBindSound.value = obj['bind_sound'];
    sysDefHitSound.value = obj['hit_sound'];
    sysDefSufferSound.value = obj['suffer_sound'];
    sysDefBardot.value = obj['bardot'];
    sysDefTimedisp.value = obj['timedisp'];
    sysDefBenchmark.value = obj['benchmark'];
    sysDefLock.value = obj['lock'];
    sysDefMute.value = obj['mute'];
    sysDefGloss.value = obj['gloss'];
    sysDefPersonal.value = obj['personal'];
    sysDefObserve.value = obj['observe'];
    sysDefSpectate.value = obj['spectate'];
    sysDefVintage.value = obj['vintage'];
    sysDefMagnitude.value = obj['magnitude'];
    sysDefMenu.value = obj['menu'];
    sysDefTheme.value = obj['theme'];
    sysDefRadius.value = obj['radius'];
    sysDefBoxShadow.value = obj['box_shadow'];
    sysDefGradientDeg.value = obj['gradient_deg'];
    sysDefBackSize.value = obj['back_size'];
    sysDefForeSize.value = obj['fore_size'];
    sysDefInputSize.value = obj['input_size'];
    sysDefHead1Size.value = obj['head1_size'];
    sysDefHead2Size.value = obj['head2_size'];
    sysDefHead3Size.value = obj['head3_size'];
    sysDefDispSize.value = obj['disp_size'];
    sysDefPriv1Size.value = obj['priv1_size'];
    sysDefPriv2Size.value = obj['priv2_size'];
    sysDefPriv3Size.value = obj['priv3_size'];
    sysDefBackColor.value = obj['back_color'];
    sysDefForeColor.value = obj['fore_color'];
    sysDefInputColor.value = obj['input_color'];
    sysDefBackTextColor.value = obj['back_text_color'];
    sysDefForeTextColor.value = obj['fore_text_color'];
    sysDefInputTextColor.value = obj['input_text_color'];
    sysDefBlankColor.value = obj['blank_color'];
    sysDefBlankTextColor.value = obj['blank_text_color'];
    sysDefArcForeColor.value = obj['arc_fore_color'];
    sysDefArcInputColor.value = obj['arc_input_color'];
    sysDefOpacity.value = obj['opacity'];
    sysDefBlur.value = obj['blur'];
    sysDefBrightness.value = obj['brightness'];
    sysDefSaturation.value = obj['saturation'];
    sysDefContrast.value = obj['contrast'];
    sysDefSepia.value = obj['sepia'];
    sysDefGrayscale.value = obj['grayscale'];
    sysDefHue.value = obj['hue'];
    sysDefGender.value = obj['gender'];
}
function bind(id) {
    var usr = sysDefSessionID.value;
    var obj = arrjob(sysDefBindData.value,';',':'); obj[usr] = id;
    set('binding.json', JSON.stringify(obj), true); sysDefHandledID.value = id;
    sysDefBindData.value = arrpack(obj,';',':');
}
function compose(msg, clear = false, fx = 0) {
    nt = Date.now(); it = nt + fx * 1000;
    var t = new Date(it); var tY = t.getUTCFullYear();
    var tM = t.getUTCMonth()+1; var tD = t.getUTCDate();
    var tH = t.getUTCHours(); var tMin = t.getUTCMinutes();
    var tS = t.getUTCSeconds(); if (clear !== false) {
        sysDefMsgData.value = sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+tY+'-'+pad(tM, 2)+'-'+pad(tD, 2)+' '+pad(tH, 2)+':'+pad(tMin, 2)+':'+pad(tS, 2)+' UTC :::: '+msg;
        set('./.log/msgbox.log', sysDefMsgData.value, true);
    } else {
        if (sysDefMsgData.value.includes(' ;;;; ') !== false) {
            sysDefMsgData.value = sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+tY+'-'+pad(tM, 2)+'-'+pad(tD, 2)+' '+pad(tH, 2)+':'+pad(tMin, 2)+':'+pad(tS, 2)+' UTC :::: '+msg+' ;;;; '+sysDefMsgData.value;
            set('./.log/msgbox.log', sysDefMsgData.value, true);
        } else {
            if (sysDefMsgData.value != '') {
                sysDefMsgData.value = sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+tY+'-'+pad(tM, 2)+'-'+pad(tD, 2)+' '+pad(tH, 2)+':'+pad(tMin, 2)+':'+pad(tS, 2)+' UTC :::: '+msg+' ;;;; '+sysDefMsgData.value;
                set('./.log/msgbox.log', sysDefMsgData.value, true);
            } else {
                sysDefMsgData.value = sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+tY+'-'+pad(tM, 2)+'-'+pad(tD, 2)+' '+pad(tH, 2)+':'+pad(tMin, 2)+':'+pad(tS, 2)+' UTC :::: '+msg;
                set('./.log/msgbox.log', sysDefMsgData.value, true);
            }
        }
    }
}
function isAllZero(arr) {
    for (i = 0; i < arr.length; i++) {
        if ((arr[i] != 0) && (isInt(arr[i]))) {
            return false; break;
        }
    } return true;
}
function dominate(q = 1, s = 2, n = 0) {
    var max = parseInt(Math.abs(q)); var min = parseInt(Math.abs(q)*-1);
    var usr = sysDefSessionID.value; var id = sysDefHandledID.value;
    var obj = arrjob(sysDefPowersData.value,';',':');
    var suf = 0; var obf = 0; var f = 0; f = (isInt(q)) ? parseInt(Math.abs(q)) : 1;
    suf = (isInt(obj[usr])) ? parseInt(obj[usr]) : 0; obf = (isInt(obj[id])) ? parseInt(obj[id]) : 0; var sides = [];
    playAudio(hitPlayer, sysDefHitSound.value);
    if ((usr != id) && (suf >= 0)) {
        for (i = 0; i < s; i++) {
            sides.push(rand(((n != 0) ? min : 0), max));
        } if (isAllZero(sides)) {
            suf += f; obf -= f;
        }
    } if (obf <= -666) {
        delete_user(id);
    } else {
        obj[usr] = suf; obj[id] = obf;
        set('dominion.json', JSON.stringify(obj), true);
        sysDefPowersData.value = arrpack(obj,';',':');
        setdata('force', f);
    } return '$'+q+','+s+','+n+'='+sides.join(':');
}
function remove_bind(id) {
    var objData = arrjob(sysDefBindData.value,';',':');
    delete objData[id];
    set('binding.json', JSON.stringify(objData), true);
    sysDefBindData.value = arrpack(objData,';',':');
}
function remove_power(id) {
    var objData = arrjob(sysDefPowersData.value,';',':');
    delete objData[id];
    set('dominion.json', JSON.stringify(objData), true);
    sysDefPowersData.value = arrpack(objData,';',':');
}
function delete_user(id) {
    del(id+'_session.json', true); del(id+'_session.json.bak', true);
    del(id+'_password', true); del(id+'_password.bak', true);
    bind(sysDefSessionID.value); sysDefHandledID.value = sysDefSessionID.value;
    remove_bind(id); remove_power(id);
}
function rename_user(username, password) {
    bind(sysDefSessionID.value); sysDefHandledID.value = sysDefSessionID.value;
    move(sysDefSessionID.value+'_session.json', username+'_session.json', true);
    move(sysDefSessionID.value+'_session.json.bak', username+'_session.json.bak', true);
    change(sysDefSessionID.value+'_password', username+'_password', CryptoJS.MD5(password).toString(), true);
}
function world_clock() {
    $.ajax({
        url: 'world_clock.php',
        success: function(data) {
            $('#alarmTime').val(pager(data, 2));
            $('#currentTime').val(pager(data, 0));
            $('#sysDefSessionID').val(pager(data, 3));
            $('#sysDefBindData').val(pager(data, 4));
            $('#sysDefPowersData').val(pager(data, 5));
            $('#sysDefMsgData').val(pager(data, 7));
            $('#sysDefMusicBox').val(pager(data, 8));
            var tickCode = pager(data, 1).split(':')[0];
            var tickPanel = pager(data, 1).split(':')[1];
            if (sysDefBindData.value != sysDefPostBindData.value) {
                playAudio(bindPlayer, sysDefBindSound.value);
            } sysDefPostBindData.value = sysDefBindData.value;
            if (sysDefMsgCounter.value == 0) {
                sysDefMsgCounter.value = parseInt(arrlens(sysDefMsgData.value, ' ;;;; ', ' :::: ') - 1);
            } else {
                sysDefMsgCounter.value = parseInt(sysDefMsgCounter.value - 1);
            } $('#showUsUrgent').text(arrvals(sysDefMsgData.value, ' ;;;; ', ' :::: ')[sysDefMsgCounter.value]);
            if (sysDefMsgData.value != sysDefPostMsgData.value) {
                playAudio(notifyPlayer, sysDefNotifySound.value);
            } sysDefPostMsgData.value = sysDefMsgData.value;
            $('#powerButton').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value); if (sysDefLock.value != 0) {
                $('#buttonLock').attr('src', sysDefPrefix.value+'key.png'+sysDefSuffix.value);
            } else {
                $('#buttonLock').attr('src', sysDefPrefix.value+'lock.png'+sysDefSuffix.value);
            } $('#buttonObserve').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value); $('#buttonSpectate').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value); $('#buttonEnter').attr('src', sysDefPrefix.value+'return.png'+sysDefSuffix.value); $('#buttonKeyboard').attr('src', sysDefPrefix.value+'keyboard.png'+sysDefSuffix.value); $('#buttonBackspace').attr('src', sysDefPrefix.value+'backspace.png'+sysDefSuffix.value); $('#buttonLogin').attr('src', sysDefPrefix.value+'user.png'+sysDefSuffix.value); $('#buttonRegister').attr('src', sysDefPrefix.value+'book.png'+sysDefSuffix.value); $('#buttonCancelSignin').attr('src', sysDefPrefix.value+'backspace.png'+sysDefSuffix.value); $('#buttonOnend').attr('src', sysDefPrefix.value+'ff.png'+sysDefSuffix.value);
            if (sysDefBenchmark.value == 2) {
                $('#buttonTime').attr('src', sysDefPrefix.value+'double.png'+sysDefSuffix.value);
            } else if (sysDefBenchmark.value == 4) {
                $('#buttonTime').attr('src', sysDefPrefix.value+'quadro.png'+sysDefSuffix.value);
            } else {
                $('#buttonTime').attr('src', sysDefPrefix.value+'time.png'+sysDefSuffix.value);
            } if (sysDefAutoplay.value != 0) {
                $('#buttonAutoplay').attr('src', sysDefPrefix.value+'autopause.png'+sysDefSuffix.value);
            } else {
                $('#buttonAutoplay').attr('src', sysDefPrefix.value+'autoplay.png'+sysDefSuffix.value);
            } $('#buttonVintage').attr('src', sysDefPrefix.value+'diamante.png'+sysDefSuffix.value); $('#buttonGloss').attr('src', sysDefPrefix.value+'parfum.png'+sysDefSuffix.value); $('#buttonPlus').attr('src', sysDefPrefix.value+'plus.png'+sysDefSuffix.value);
            if (audioPlayer.paused != true) {
                $('#buttonPlay').attr('src', sysDefPrefix.value+'pause.png'+sysDefSuffix.value);
            } else {
                $('#buttonPlay').attr('src', sysDefPrefix.value+'play.png'+sysDefSuffix.value);
            } if (alarmPlayer.paused != true) {
                $('#buttonAlarm').attr('src', sysDefPrefix.value+'dial.png'+sysDefSuffix.value);
            } else {
                $('#buttonAlarm').attr('src', sysDefPrefix.value+'call.png'+sysDefSuffix.value);
            } if (sysDefMute.value != 0) {
                $('#buttonMute').attr('src', sysDefPrefix.value+'audio.png'+sysDefSuffix.value);
            } else {
                $('#buttonMute').attr('src', sysDefPrefix.value+'music.png'+sysDefSuffix.value);
            } if (requestLock.value != 'true') {
                $('#buttonReqLock').attr('src', sysDefPrefix.value+'expand.png'+sysDefSuffix.value);
            } else {
                $('#buttonReqLock').attr('src', sysDefPrefix.value+'collapse.png'+sysDefSuffix.value);
            } if (sysDefFaceoff.value != 0) {
                $('#buttonFaceoff').attr('src', sysDefPrefix.value+'maximize.png'+sysDefSuffix.value);
            } else {
                $('#buttonFaceoff').attr('src', sysDefPrefix.value+'restore.png'+sysDefSuffix.value);
            } if (tickPanel.split('')[3] == 1) {
                $('#buttonIconsList').attr('src', sysDefPrefix.value+'menu.png'+sysDefSuffix.value);
            } else {
                $('#buttonIconsList').attr('src', sysDefPrefix.value+'list.png'+sysDefSuffix.value);
            } $('#buttonUpdate').attr('src', sysDefPrefix.value+'world.png'+sysDefSuffix.value); if (sysDefIsSession.value !== false) {
                $('#buttonUserStatus').attr('src', sysDefPrefix.value+'user.png'+sysDefSuffix.value);
            } else {
                $('#buttonUserStatus').attr('src', sysDefPrefix.value+'anonym.png'+sysDefSuffix.value);
            } $('#buttonEscape').attr('src', sysDefPrefix.value+'escape.png'+sysDefSuffix.value);
            if (tickPanel.split('')[2] != sysDefPostBackEff.value) {
                if (tickPanel.split('')[2] != 0) {
                    playAudio(backgroundPlayer, sysDefBackgroundSound.value);
                } else {
                    pauseAudio(backgroundPlayer);
                }
            } sysDefPostBackEff.value = tickPanel.split('')[2];
            if (requestMode.value == 'news_feed') {
                msgBox.innerHTML = '<p>'+htmlarr(sysDefMsgData.value, ' ;;;; ', ' :::: ')+'</p>';
            } if (((tickPanel.split('')[0] == 1) && (tickPanel.split('')[1] == 1)) || ((tickPanel.split('')[0] == 1) && (tickPanel.split('')[1] == 0))) {
                $('#powerButton').show(); $('.panel').hide();
                $('.customPanel').hide(); $('.upperGap').hide(); $('.lowerGap').hide(); $('.topbar').hide();
            } else {
                if ((tickPanel.split('')[0] == 0) && (tickPanel.split('')[1] == 1)) {
                    $('#powerButton').hide(); $('.panel').hide();
                    $('.customPanel').hide(); $('.upperGap').hide(); $('.lowerGap').hide(); $('.topbar').show();
                } else {
                    $('#powerButton').hide(); $('.panel').show();
                    $('.customPanel').show(); $('.upperGap').show(); $('.lowerGap').show(); $('.topbar').show();
                }
            } document.querySelector(':root').style.setProperty('--backdrop-filter', pager(data, 6).split(';')[0]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg', pager(data, 6).split(';')[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani', pager(data, 6).split(';')[2]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg', pager(data, 6).split(';')[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani', pager(data, 6).split(';')[4]);
            if (tickCode.split('')[1] != 0) {
                playAudio(tickerPlayer, sysDefTickingSound.value);
            } else {
                pauseAudio(tickerPlayer);
            } if (tickCode.split('')[0] != 0) {
                playAudio(alarmPlayer, sysDefAlarmSound.value); setdata('memo', '');
            }
        },
    });
}
function visual_effects() {
    $.ajax({
        url: 'visual_effects.php',
        success: function(data) {
            document.querySelector(':root').style.setProperty('--graddeg', miniPager(data, 2)+'deg');
            document.querySelector(':root').style.setProperty('--backsize', miniPager(data, 3)+'pt');
            document.querySelector(':root').style.setProperty('--foresize', miniPager(data, 4)+'pt');
            document.querySelector(':root').style.setProperty('--inputsize', miniPager(data, 5)+'pt');
            document.querySelector(':root').style.setProperty('--head1size', miniPager(data, 6)+'pt');
            document.querySelector(':root').style.setProperty('--head2size', miniPager(data, 7)+'pt');
            document.querySelector(':root').style.setProperty('--head3size', miniPager(data, 8)+'pt');
            document.querySelector(':root').style.setProperty('--dispsize', miniPager(data, 9)+'pt');
            document.querySelector(':root').style.setProperty('--priv1size', miniPager(data, 10)+'pt');
            document.querySelector(':root').style.setProperty('--priv2size', miniPager(data, 11)+'pt');
            document.querySelector(':root').style.setProperty('--priv3size', miniPager(data, 12)+'pt');
            document.querySelector(':root').style.setProperty('--backcolor', '#'+miniPager(data, 13));
            document.querySelector(':root').style.setProperty('--forecolor', '#'+miniPager(data, 14));
            document.querySelector(':root').style.setProperty('--inputcolor', '#'+miniPager(data, 15));
            document.querySelector(':root').style.setProperty('--backtextcolor', '#'+miniPager(data, 16));
            document.querySelector(':root').style.setProperty('--foretextcolor', '#'+miniPager(data, 17));
            document.querySelector(':root').style.setProperty('--inputtextcolor', '#'+miniPager(data, 18));
            document.querySelector(':root').style.setProperty('--blankcolor', '#'+miniPager(data, 19));
            document.querySelector(':root').style.setProperty('--blanktextcolor', '#'+miniPager(data, 20));
            document.querySelector(':root').style.setProperty('--arcforecolor', '#'+miniPager(data, 21));
            document.querySelector(':root').style.setProperty('--arcinputcolor', '#'+miniPager(data, 22));
            document.querySelector(':root').style.setProperty('--bicolor', '#'+miniPager(data, 31));
            document.querySelector(':root').style.setProperty('--qucolor', '#'+miniPager(data, 13)+'00');
            document.querySelector(':root').style.setProperty('--radius', miniPager(data, 0)+'px');
            document.querySelector(':root').style.setProperty('--box-shadow', miniPager(data, 1)+'px '+miniPager(data, 1)+'px '+miniPager(data, 1)+'px '+miniPager(data, 20));
            document.querySelector(':root').style.setProperty('--blur', 'blur('+miniPager(data, 24)+'px)');
            document.querySelector(':root').style.setProperty('--filter', 'brightness('+miniPager(data, 25)+'%) saturate('+miniPager(data, 26)+'%) contrast('+miniPager(data, 27)+'%) sepia('+miniPager(data, 28)+'%) grayscale('+miniPager(data, 29)+'%) hue-rotate('+miniPager(data, 30)+'deg)');
            if (sysDefGloss.value == 1) {
                $('.power').css('background', 'linear-gradient('+miniPager(data, 2)+'deg, #'+miniPager(data, 14)+' 0%, #'+miniPager(data, 21)+' 100%)');
                document.querySelector(':root').style.setProperty('--gradient-fore', 'linear-gradient(180deg, #'+miniPager(data, 14)+' 0%, #'+miniPager(data, 21)+' 100%)');
                document.querySelector(':root').style.setProperty('--gradient-input', 'linear-gradient(180deg, #'+miniPager(data, 15)+' 0%, #'+miniPager(data, 22)+' 100%)');
            } else {
                $('.power').css('background', 'linear-gradient('+miniPager(data, 2)+'deg, #'+miniPager(data, 14)+' 0%, #'+miniPager(data, 14)+' 100%)');
                document.querySelector(':root').style.setProperty('--gradient-fore', 'linear-gradient(180deg, #'+miniPager(data, 14)+' 0%, #'+miniPager(data, 14)+' 100%)');
                document.querySelector(':root').style.setProperty('--gradient-input', 'linear-gradient(180deg, #'+miniPager(data, 15)+' 0%, #'+miniPager(data, 15)+' 100%)');
            } if (requestMode.value == 'visual_effects') {
                opacityInd.value = miniPager(data, 23);
                blurInd.value = miniPager(data, 24)+'px';
                brightnessInd.value = miniPager(data, 25)+'%';
                saturationInd.value = miniPager(data, 26)+'%';
                contrastInd.value = miniPager(data, 27)+'%';
                sepiaInd.value = miniPager(data, 28)+'%';
                grayInd.value = miniPager(data, 29)+'%';
                hueInd.value = miniPager(data, 30)+'deg';
                opacityRange.value = miniPager(data, 23);
                blurRange.value = miniPager(data, 24);
                brightnessRange.value = miniPager(data, 25);
                saturationRange.value = miniPager(data, 26);
                contrastRange.value = miniPager(data, 27);
                sepiaRange.value = miniPager(data, 28);
                grayRange.value = miniPager(data, 29);
                hueRange.value = miniPager(data, 30);
            }
        },
    });
}
function wallpaper_engine() {
    $.ajax({
        url: 'wallpaper_engine.php',
        success: function(data) {
            sysDefPrefix.value = pager(data, 6).split(';')[0];
            sysDefReticlePrefix.value = pager(data, 6).split(';')[1]; $('#sysDefVarsArr').val(pager(data, 5)); var decodePowers = arrjob(sysDefPowersData.value,';',':'); var decodeBind = arrjob(sysDefBindData.value,';',':'); sysDefSubP.value = decodePowers[sysDefSessionID.value];
            if (sysDefSubP.value != sysDefPostSubP.value) {
                playAudio(sufferPlayer, sysDefSufferSound.value);
            } sysDefPostSubP.value = sysDefSubP.value;
            var valBind = ''; var valBond = ''; var valPwrTh = 0; var valPwrBal = '';
            $('body').css('background-image', 'url('+pager(data, 1)+')');
            var varsNum = sysDefVarsArr.value.split(';').length;
            var varsID = sysDefVarsArr.value.split(';').indexOf(sysDefEntry.value);
            if (varsNum > 1) {
                if (sysDefEntry.value != '') {
                    $('#buttonAugment').attr('src', sysDefPrefix.value+'diamond.png'+sysDefSuffix.value);
                } else {
                    $('#buttonAugment').attr('src', sysDefPrefix.value+'heart.png'+sysDefSuffix.value);
                }
            } else {
                if (sysDefEntry.value != '') {
                    $('#buttonAugment').attr('src', sysDefPrefix.value+'club.png'+sysDefSuffix.value);
                } else {
                    $('#buttonAugment').attr('src', sysDefPrefix.value+'spade.png'+sysDefSuffix.value);
                }
            } document.title = pager(data, 0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI'; document.querySelector(':root').style.setProperty('--position', pager(data, 4)); $('#userAvatarBadge').attr('src', pager(data, 2)+sysDefSuffix.value); var valPwrMy = (isInt(decodePowers[sysDefSessionID.value])) ? parseInt(decodePowers[sysDefSessionID.value]) : 0; $('#buttonReticle').attr('src', sysDefReticlePrefix.value+sysDefReticle.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle1').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice1.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle2').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice2.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle3').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice3.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle4').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice4.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle5').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice5.value+'.png'+sysDefSuffix.value);
            var bindFunc = arraySearch(sysDefSessionID.value, decodeBind);
            if (bindFunc != false) {
                if (decodeBind[sysDefSessionID.value] != sysDefSessionID.value) {
                    valBind = bindFunc; valBond = '+@'+sysDefSessionID.value+'+';
                    valPwrTh = (isInt(decodePowers[valBind])) ? parseInt(decodePowers[valBind]) : 0; valPwrBal = valPwrMy+':'+valPwrTh;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
                } else {
                    valBind = bindFunc; valBond = '+@'+sysDefSessionID.value;
                    valPwrTh = (isInt(decodePowers[valBind])) ? parseInt(decodePowers[valBind]) : 0; valPwrBal = valPwrMy+':'+valPwrTh;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
                }
            } else {
                if (decodeBind[sysDefSessionID.value] != sysDefSessionID.value) {
                    valBind = decodeBind[sysDefSessionID.value];
                    valBond = '@'+sysDefSessionID.value+'+';
                    valPwrTh = ((isInt(decodePowers[valBind])) ? parseInt(decodePowers[valBind]) : 0);
                    valPwrBal = valPwrMy+':'+valPwrTh;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
                } else {
                    valBond = '@'+sysDefSessionID.value; valPwrBal = valPwrMy;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'chain.png'+sysDefSuffix.value);
                }
            } $('#showUsInfoPower').val(valPwrBal); $('#showUsInfoBond').val(valBond);
            $('#showUsText').text(pager(data, 8));
            <?php if (file_exists('mode.'.$request['mode'].'.php')) {
                if ($request['mode'] == 'main_menu') { ?>
                    $('#projectTitle').text(pager(data, 7).toUpperCase());
                    $('#showingAvatarNow').attr('src', pager(data, 3));
                <?php }
            } else { ?>
                $('#articleHead').text(pager(data, 7).toUpperCase());
                $('#showingAvatarNow').attr('src', pager(data, 3));
            <?php } ?>
        },
    });
}
function executeMacros(input, index = 0, length = 1) {
    var output = input; var rep, r1, r2, r3, r4;
    if ((input.includes('## ')) && (input.indexOf('## ') == 0)) {
    } else if ((input.includes('>>')) && (input.indexOf('>>') == 0)) {
        if (sysDefSessionID.value == 'root') {
            compose(input.replace('>>', ''), true, index);
        }
    } else if ((input.includes('>')) && (input.indexOf('>') == 0)) {
        compose(input.replace('>', ''), false, index);
    } else if ((index == (length - 1)) && (input == '&&')) {
        bind(sysDefSessionID.value);
    } else if ((index == (length - 1)) && ((input == '/') || (input == '='))) {
        window.location.reload();
    } else if ((index == (length - 1)) && (input == ':@')) {
        omniAuthRequest('signout','','');
    } else if ((index == (length - 1)) && (input == '..')) {
        omniBack(sysDefParent.value);
    } else if ((index == (length - 1)) && (input == '~~')) {
        delete_user(sysDefSessionID.value); omniAuthRequest('signout','','');
    } else if ((index == (length - 1)) && (input.includes("\\"))) {
        var namePart = input.replace("\\", '');
        var museArr = sysDefMusicBox.value;
        var museLint = museArr.split('//');
        for (i = 0; i < museLint.length; i++) {
            if (museLint[i].toLowerCase().includes(namePart.toLowerCase())) {
                omniListen(museLint[i], true); break;
            } omniPause();
        }
    } else if ((index == (length - 1)) && (input.includes('$'))) {
        if (input.indexOf('$') == 0) {
            if (input.includes('=')) {
                rep = input.split('='); r1 = rep[0].replace('$','');
                if (r1.includes(',')) {
                    r2 = r1.split(','); output = (r2.length > 2) ? dominate(r2[0],r2[1],r2[2]) : ((r2.length > 1) ? dominate(r2[0],r2[1]) : dominate(r2[0]));
                } else {
                    output = dominate(r1);
                }
            } else {
                rep = input.replace('$',''); if (rep.includes(',')) {
                    r1 = rep.split(','); output = (r1.length > 2) ? dominate(r1[0],r1[1],r1[2]) : ((r1.length > 1) ? dominate(r1[0],r1[1]) : dominate(r1[0]));
                } else {
                    output = dominate(rep);
                }
            }
        } else {
            omniPathDir(input.replace('$', ''), requestMode.value);
        }
    } else if ((index == (length - 1)) && (input.includes('./')) && (input.indexOf('./') == 0)) {
        omniRead(requestMode.value, input.replace('./', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('*'))) {
        omniDisp(requestMode.value, input.replace('*', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('@'))) {
        var atr = input.split('@'); var tyx; if (atr[0].includes(':')) {
            tyx = atr[0].split(':'); if (atr[1].includes('signin')) {
                omniAuthRequest('signin', tyx[0], tyx[1]);
            } else if (atr[1].includes('signup')) {
                omniAuthRequest('signup', tyx[0], tyx[1]);
            } else if (atr[1].includes('rename')) {
                rename_user(tyx[0], tyx[1]);
                omniAuthRequest('signout','','');
            }
        }
    } else if ((index == (length - 1)) && (input.includes('&')) && (input.indexOf('&') == 0)) {
        bind(input.replace('&', ''));
    } else if ((index == (length - 1)) && (input.includes('~')) && (input.indexOf('~') == 0)) {
        if (sysDefSessionID.value == 'root') {
            delete_user(input.replace('~', ''));
        } else {
            if (input.replace('~', '') == sysDefSessionID.value) {
                delete_user(input.replace('~', ''));
            }
        }
    } else if (input.includes(': ')) {
        rep = input.split(': '); if (rep[0] == 'memo') {
            if (rep[1].includes('+')) {
                if (parseInt(rep[1].replace('+', '')) == 0) {
                    setdata('memo', ''); pauseAudio(alarmPlayer);
                } else {
                    setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(rep[1].replace('+', ''))));
                }
            } else if ((rep[1] == '') || (rep[1] == 0)) {
                setdata('memo', ''); pauseAudio(alarmPlayer);
            } else {
                setdata('memo', rep[1]);
            }
        } else {
            setdata(rep[0], rep[1]);
        }
    } else if ((index == (length - 1)) && (input.includes('_')) && (input.indexOf('_') == 0)) {
        omniGo(input.replace('_', ''));
    } else if ((index == (length - 1)) && (input.includes('+')) && (input.indexOf('+') == 0)) {
        audioPosition(input.replace('+', ''));
    } else if ((index == (length - 1)) && (isInt(input))) {
        audioPosition(input);
    } else {
        output = input + ': ' + userdata()[input];
    } return output;
}
function macrosSequence(input, cmdword) {
    var query = input.replace(cmdword, ''); var querySep;
    var output = cmdword; if (query.includes('; ')) {
        querySep = query.split('; '); for (i = 0; i < querySep.length; i++) {
            output += executeMacros(querySep[i], i, querySep.length) + "; ";
        } output = output.slice(0, -2);
    } else {
        output += executeMacros(query);
    } return output;
}
function getPkgSequence(input, cmdword, isRepo = 0) {
    var preQuery = input.replace(cmdword, ''); var query = '';
    if (preQuery.includes('-i ')) { query = preQuery.replace('-i ', '');
        if (isRepo != 0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-s ')) { query = preQuery.replace('-s ', '');
        if (isRepo != 0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-o ')) { query = preQuery.replace('-o ', '');
        if (isRepo != 0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-d ')) { query = preQuery.replace('-d ', '');
        if (isRepo != 0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes('-u ')) { query = preQuery.replace('-u ', '');
        if (isRepo != 0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes('-x ')) { query = preQuery.replace('-x ', '');
        if (isRepo != 0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes(' -r' )) { query = preQuery.split(' -r ');
        if (isRepo != 0) { replaceRepo(query[0], query[1], 0); } else { replacePackage(query[0], query[1], 0); }
    } else if (preQuery.includes(' -p' )) { query = preQuery.split(' -p ');
        if (isRepo != 0) { replaceRepo(query[0], query[1], 1); } else { replacePackage(query[0], query[1], 1); }
    } else if (preQuery.includes(' -m' )) { query = preQuery.split(' -m ');
        if (isRepo != 0) { replaceRepo(query[0], query[1], -1); } else { replacePackage(query[0], query[1], -1); }
    } window.location.reload();  
}
function systemUpdate(query) {
    var parts = query.toString('').split(' ');
    for (i = 0; i < parts.length; i++) {
        var part = payload(parts[i]);
        get('i', part[0], 'from', part[1], part[2], part[3], true);
    }
}
function obtainRepo(query) {
    var parts = query.toString('').split(' ');
    for (i = 0; i < parts.length; i++) {
        var part = payload(parts[i]);
        getdir('i', part[0], 'from', part[1], part[2], part[3], true);
    }
}
function replacePackage(quid, quo, ord = 0) {
    var toRem = quid.toString('').split(' ');
    var toSet = quo.toString('').split(' ');
    var part = []; if (ord < 0) {
        for (i = 0; i < toSet.length; i++) {
            part = payload(toSet[i]);
            get('i', part[0], 'from', part[1], part[2], part[3], true);
        } for (i = 0; i < toRem.length; i++) {
            get('d', '', toRem[i], 'from', '', 'here', true);
        }
    } else {
        for (i = 0; i < toRem.length; i++) {
            get('d', '', toRem[i], 'from', '', 'here', true);
        } for (i = 0; i < toSet.length; i++) {
            part = payload(toSet[i]);
            get('i', part[0], 'from', part[1], part[2], part[3], true);
        }
    }
}
function replaceRepo(quid, quo, ord = 0) {
    var toRem = quid.toString('').split(' ');
    var toSet = quo.toString('').split(' ');
    var part = []; if (ord < 0) {
        for (i = 0; i < toSet.length; i++) {
            part = payload(toSet[i]);
            getdir('i', part[0], 'from', part[1], part[2], part[3], true);
        } for (i = 0; i < toRem.length; i++) {
            getdir('d', '', toRem[i], 'from', '', 'here', true);
        }
    } else {
        for (i = 0; i < toRem.length; i++) {
            getdir('d', '', toRem[i], 'from', '', 'here', true);
        } for (i = 0; i < toSet.length; i++) {
            part = payload(toSet[i]);
            getdir('i', part[0], 'from', part[1], part[2], part[3], true);
        }
    }
}
function payload(query) {
    if (query.includes('>')) {
        var uri = query.split('>')[0];
        var branch = query.split('>')[1];
        var host = '', repo = '', user = '';
        if (uri.split('/').length > 2) {
            repo = uri.split('/')[uri.split('/').length - 1];
            user = uri.split('/')[uri.split('/').length - 2];
            host = uri.replace('/'+user+'/'+repo, '');
        } else {
            host = 'https://github.com';
            user = uri.split('/')[0];
            repo = uri.split('/')[1];
        }
    } else {
        var branch = '', host = '', repo = '', user = '';
        if (query.split('/').length > 2) {
            repo = query.split('/')[query.split('/').length - 1];
            user = query.split('/')[query.split('/').length - 2];
            host = query.replace('/'+user+'/'+repo, '');
        } else {
            host = 'https://github.com';
            user = query.split('/')[0];
            repo = query.split('/')[1];
        }
    } return res = [host, repo, branch, user];
}
function uninstall(query) {
    for (i = 0; i < query.split(' ').length; i++) {
        get('d', '', query.split(' ')[i], 'from', '', 'here', true);
    }
}
function terminate(query) {
    for (i = 0; i < query.split(' ').length; i++) {
        getdir('d', '', query.split(' ')[i], 'from', '', 'here', true);
    }
}
function arrangeMenu(list, item) {
    var arr = list.toString('').split(',');
    if (arr.indexOf(item) > -1) {
        arr.splice(arr.indexOf(item), 1);
    } else {
        arr.push(item);
    }
    return arr.join(',');
}
function isInMenu(list, item) {
    var arr = list.toString('').split(',');
    return (arr.indexOf(item) > -1);
}
function applyTheme(sizes = '7 0 180 14 14 14 17 16 15 18 14 14 14', colors = 'C0BFC0|605F60|E5E5E5|FFFFFF|FFFFFF|000000|FFFFFF|000000|403F40|D5D5D5') {
    var t4size = sizes.toString('').split(' ');
    var t4color = colors.toString('').split('|');
    if (t4size[0].includes('i')) {
        setdata('radius', t4size[t4size[0].replace('i','')]);
    } else if (t4size[0].includes('x')) {
        setdata('radius', sysDefRadius.value);
    } else {
        setdata('radius', t4size[0]);
    }
    if (t4size[1].includes('i')) {
        setdata('box_shadow', t4size[t4size[1].replace('i','')]);
    } else if (t4size[1].includes('x')) {
        setdata('box_shadow', sysDefBoxShadow.value);
    } else {
        setdata('box_shadow', t4size[1]);
    }
    if (t4size[2].includes('i')) {
        setdata('gradient_deg', t4size[t4size[2].replace('i','')]);
    } else if (t4size[2].includes('x')) {
        setdata('gradient_deg', sysDefGradientDeg.value);
    } else {
        setdata('gradient_deg', t4size[2]);
    }
    if (t4size[3].includes('i')) {
        setdata('back_size', t4size[t4size[3].replace('i','')]);
    } else if (t4size[3].includes('x')) {
        setdata('back_size', sysDefBackSize.value);
    } else {
        setdata('back_size', t4size[3]);
    }
    if (t4size[4].includes('i')) {
        setdata('fore_size', t4size[t4size[4].replace('i','')]);
    } else if (t4size[4].includes('x')) {
        setdata('fore_size', sysDefForeSize.value);
    } else {
        setdata('fore_size', t4size[4]);
    }
    if (t4size[5].includes('i')) {
        setdata('input_size', t4size[t4size[5].replace('i','')]);
    } else if (t4size[5].includes('x')) {
        setdata('input_size', sysDefInputSize.value);
    } else {
        setdata('input_size', t4size[5]);
    }
    if (t4size[6].includes('i')) {
        setdata('head1_size', t4size[t4size[6].replace('i','')]);
    } else if (t4size[6].includes('x')) {
        setdata('head1_size', sysDefHead1Size.value);
    } else {
        setdata('head1_size', t4size[6]);
    }
    if (t4size[7].includes('i')) {
        setdata('head2_size', t4size[t4size[7].replace('i','')]);
    } else if (t4size[7].includes('x')) {
        setdata('head2_size', sysDefHead2Size.value);
    } else {
        setdata('head2_size', t4size[7]);
    }
    if (t4size[8].includes('i')) {
        setdata('head3_size', t4size[t4size[8].replace('i','')]);
    } else if (t4size[8].includes('x')) {
        setdata('head3_size', sysDefHead3Size.value);
    } else {
        setdata('head3_size', t4size[8]);
    }
    if (t4size[9].includes('i')) {
        setdata('disp_size', t4size[t4size[9].replace('i','')]);
    } else if (t4size[9].includes('x')) {
        setdata('disp_size', sysDefDispSize.value);
    } else {
        setdata('disp_size', t4size[9]);
    }
    if (t4size[10].includes('i')) {
        setdata('priv1_size', t4size[t4size[10].replace('i','')]);
    } else if (t4size[10].includes('x')) {
        setdata('priv1_size', sysDefPriv1Size.value);
    } else {
        setdata('priv1_size', t4size[10]);
    }
    if (t4size[11].includes('i')) {
        setdata('priv2_size', t4size[t4size[11].replace('i','')]);
    } else if (t4size[11].includes('x')) {
        setdata('priv2_size', sysDefPriv2Size.value);
    } else {
        setdata('priv2_size', t4size[11]);
    }
    if (t4size[12].includes('i')) {
        setdata('priv3_size', t4size[t4size[12].replace('i','')]);
    } else if (t4size[12].includes('x')) {
        setdata('priv3_size', sysDefPriv3Size.value);
    } else {
        setdata('priv3_size', t4size[12]);
    }
    if (t4color[0].includes('i')) {
        setdata('back_color', t4color[t4color[0].replace('i','')]);
    } else if (t4color[0].includes('x')) {
        setdata('back_color', sysDefBackColor.value);
    } else {
        setdata('back_color', t4color[0]);
    }
    if (t4color[1].includes('i')) {
        setdata('fore_color', t4color[t4color[1].replace('i','')]);
    } else if (t4color[1].includes('x')) {
        setdata('fore_color', sysDefForeColor.value);
    } else {
        setdata('fore_color', t4color[1]);
    }
    if (t4color[2].includes('i')) {
        setdata('input_color', t4color[t4color[2].replace('i','')]);
    } else if (t4color[2].includes('x')) {
        setdata('input_color', sysDefInputColor.value);
    } else {
        setdata('input_color', t4color[2]);
    }
    if (t4color[3].includes('i')) {
        setdata('back_text_color', t4color[t4color[3].replace('i','')]);
    } else if (t4color[3].includes('x')) {
        setdata('back_text_color', sysDefBackTextColor.value);
    } else {
        setdata('back_text_color', t4color[3]);
    }
    if (t4color[4].includes('i')) {
        setdata('fore_text_color', t4color[t4color[4].replace('i','')]);
    } else if (t4color[4].includes('x')) {
        setdata('fore_text_color', sysDefForeTextColor.value);
    } else {
        setdata('fore_text_color', t4color[4]);
    }
    if (t4color[5].includes('i')) {
        setdata('input_text_color', t4color[t4color[5].replace('i','')]);
    } else if (t4color[5].includes('x')) {
        setdata('input_text_color', sysDefInputTextColor.value);
    } else {
        setdata('input_text_color', t4color[5]);
    }
    if (t4color[6].includes('i')) {
        setdata('blank_color', t4color[t4color[6].replace('i','')]);
    } else if (t4color[6].includes('x')) {
        setdata('blank_color', sysDefBlankColor.value);
    } else {
        setdata('blank_color', t4color[6]);
    }
    if (t4color[7].includes('i')) {
        setdata('blank_text_color', t4color[t4color[7].replace('i','')]);
    } else if (t4color[7].includes('x')) {
        setdata('blank_text_color', sysDefBlankTextColor.value);
    } else {
        setdata('blank_text_color', t4color[7]);
    }
    if (t4color[8].includes('i')) {
        setdata('arc_fore_color', t4color[t4color[8].replace('i','')]);
    } else if (t4color[8].includes('x')) {
        setdata('arc_fore_color', sysDefArcForeColor.value);
    } else {
        setdata('arc_fore_color', t4color[8]);
    }
    if (t4color[9].includes('i')) {
        setdata('arc_input_color', t4color[t4color[9].replace('i','')]);
    } else if (t4color[9].includes('x')) {
        setdata('arc_input_color', sysDefArcInputColor.value);
    } else {
        setdata('arc_input_color', t4color[9]);
    }
}
function soundButton(bulk = false) {
    if (bulk != false) {
        playAudio(soundPlayer, sysDefFocusSound.value);
    } else {
        if (sysDefMute.value == 0) {
            playAudio(soundPlayer, sysDefFocusSound.value);
        }
    }
}
function handleInput(val, bulk = false) {
    if (bulk != false) {
        playAudio(typePlayer, sysDefTypeSound.value);
    } else {
        if (val.length == 0) {
            playAudio(errorPlayer, sysDefErrorSound.value);
        }
    }
}
function omniRequest(mode, sort, group, angle, input, output, args, lock, ref, path) {
    window.location.href = 'index.php?mode='+mode+'&sort='+sort+'&group='+group+'&angle='+angle+'&input='+input+'&output='+output+'&args='+args+'&lock='+lock+'&ref='+ref+'&path='+path;
}
function omniAuthRequest(auth, login, password) {
    var cryptedPassword = CryptoJS.MD5(password).toString();
    window.location.href = 'index.php?mode='+requestMode.value+'&sort='+requestSort.value+'&group='+requestGroup.value+'&angle='+requestAngle.value+'&input='+requestInput.value+'&output='+requestOutput.value+'&args='+requestArgs.value+'&lock='+requestLock.value+'&ref='+requestRef.value+'&path='+requestPath.value+'&auth='+auth+'&login='+login+'&password='+cryptedPassword;
}
function omniGo(mode) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
function omniRef() {
    var currentMode = requestMode.value;
    var currentParent = sysDefParent.value;
    var currentRef = requestRef.value;
    return ref = (sysDefIsRef.value == 'true') ? currentRef : currentMode;
}
function omniBack(mode) {
    var currentMode = requestMode.value;
    var currentArgs = requestArgs.value;
    var currentPath = requestPath.value;
    var currentGroup = requestGroup.value;
    var changeMode = '', args = '', path = ''; group = '';
    if (currentMode == 'file_explorer' || currentMode == 'file_finder') {
        args = currentArgs, path = '', group = currentGroup;
        changeMode = ((currentPath == '') || (currentPath == '.')) ? mode : currentMode;
    } else if (currentMode == 'object_info') {
        args = '', path = currentPath, group = currentGroup;
        changeMode = (currentArgs != '') ? currentMode : mode;
    } else if (currentMode == 'browse_europedia') {
        args = currentArgs, path = currentPath, group = '';
        changeMode = (currentGroup != '') ? currentMode : mode;
    } else {
        args = '', path = '', group = '', changeMode = mode;
    }
    omniRequest(changeMode, requestSort.value, group, requestAngle.value, requestInput.value, requestOutput.value, args, requestLock.value, omniRef(), path);
}
function omniPath(input, args, lock) {
    omniRequest('object_info', requestSort.value, requestGroup.value, requestAngle.value, input, requestOutput.value, args, lock, omniRef(), requestPath.value);
}
function omniPathDir(path, mode) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), path);
}
function omniRead(mode, input, lock) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, input, requestOutput.value, requestArgs.value, lock, omniRef(), requestPath.value);
}
function omniLock(lock) {
    omniRequest(requestMode.value, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, lock, omniRef(), requestPath.value);
}
function omniDisp(mode, output, lock) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, output, requestArgs.value, lock, omniRef(), requestPath.value);
}
function omniRotate(angle) {
    omniRequest(requestMode.value, requestSort.value, requestGroup.value, angle, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
function omniSwitch(group) {
    omniRequest(requestMode.value, requestSort.value, group, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
function omniSort(sort) {
    omniRequest(requestMode.value, sort, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
</script>
