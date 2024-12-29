<script>
window.onload = function() {
    <?php if (isAuth()) { ?>
        document.getElementById('omniBox').focus();
    <?php } else { ?>
        document.getElementById('omniBoxAuthLogin').focus();
    <?php } ?>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    } if ((sysDefAutoplay.value == 1) && (sysDefPlaying.value == 1)) {
        omniListen(dtw(sysDefMelody.value, sysDefSessionID.value, 'あいうえおかがきぎぐけげこごさざしじすずせぜそぞただちぢづてでとどなにぬねのはばぱひびぴふぶぷべぺほぼぽまみむめもやゆよらりるれろわゐゑをんゔゟ'));
    } if (requestMode.value == 'media_player') {
        replayVideo(video);
    }
}
$(document).ready(function() {
<?php foreach ($settings['intervals'] as $key=>$val) { ?>
    setInterval(<?=$key;?>, <?=$val;?>);
<?php } ?>
});
function databox() {
    $.ajax({
        url: 'databox.php',
        success: function(data) {
            $('#sysDefSessionID').val(pager(data, 0));
            $('#sysDefBindData').val(pager(data, 1));
            $('#sysDefPowersData').val(pager(data, 2));
            $('#sysDefAutoData').val(pager(data, 3));
            $('#sysDefFriendData').val(pager(data, 4));
            $('#sysDefToolData').val(pager(data, 5));
            $('#sysDefCallData').val(pager(data, 6));
            $('#sysDefMsgData').val(pager(data, 7));
            $('#sysDefBookKeep').val(pager(data, 8));
            $('#sysDefUserStore').val(pager(data, 9));
            $('#sysDefLockData').val(pager(data, 10));            
            $('#sysDefCodexBox').val(pager(data, 11).split("\\\\")[0]);
            $('#sysDefSpeechBox').val(pager(data, 11).split("\\\\")[1]);
            $('#sysDefUsersList').val(pager(data, 12).split(";")[0]);
            $('#sysDefBooksList').val(pager(data, 12).split(";")[1]);
            $('#sysDefStoreList').val(pager(data, 12).split(";")[2]);
            $('#sysDefHoursNow').val(pager(data, 13));
            $('#sysDefMetaList').val(pager(data, 14));
            $('#sysDefMetaData').val(pager(data, 15));
            $('#sysDefTutorList').val(pager(data, 16));
            $('#sysDefTutorData').val(pager(data, 17));
            if (sysDefBindData.value != sysDefPostBindData.value) {
                playAudio(bindPlayer, sysDefBindSound.value);
            } sysDefPostBindData.value = sysDefBindData.value;
            if (sysDefToolData.value != sysDefPostToolData.value) {
                playAudio(bindPlayer, sysDefBindSound.value);
            } sysDefPostToolData.value = sysDefToolData.value;
            if (sysDefMsgData.value != sysDefPostMsgData.value) {
                playAudio(notifyPlayer, sysDefNotifySound.value);
            } sysDefPostMsgData.value = sysDefMsgData.value;
            if (sysDefBookKeep.value != sysDefPostBookKeep.value) {
                playAudio(sufferPlayer, sysDefSufferSound.value);
            } sysDefPostBookKeep.value = sysDefBookKeep.value;
        }
    });
}
function world_clock() {
    $.ajax({
        url: 'world_clock.php',
        success: function(data) {
            $('#currentTime').val(pager(data, 0));
            var enzi = pager(data, 1).split(' ');
            $('#alarmTime').val(pager(data, 2));
            var effi = pager(data, 3).split(';');
            init_user(sysDefSessionID.value, 'manual');
            var mixers = pager(data, 4).split(' ');
            var bndm = arrjob(sysDefBindData.value,';',':')[sysDefSessionID.value];
            if (requestMode.value == 'volume_control') {
                audioVolInd.value = mixers[0]; audioRatInd.value = mixers[1];
                videoVolInd.value = mixers[2]; videoRatInd.value = mixers[3];
                alarmVolInd.value = mixers[4]; timerVolInd.value = mixers[5];
                loopVolInd.value = mixers[6]; restVolInd.value = mixers[7];
            } document.querySelector(':root').style.setProperty('--bicolor', '#'+enzi[2]);
            var obs = enzi[1].split('')[0], spe = enzi[1].split('')[1];
            sysDefMsgCounter.value = (sysDefMsgCounter.value <= 0) ? (Object.keys(jsonFilter(sysDefMsgData.value, sysDefFind.value)).length - 1) : (sysDefMsgCounter.value - 1);
            $('#showUsUrgent').text(Object.values(jsonFilter(sysDefMsgData.value, sysDefFind.value, 'msg'))[sysDefMsgCounter.value]);
            if (sysDefLoop.value != sysDefPostBackEff.value) {
                if (sysDefLoop.value != 0) { playAudio(backgroundPlayer, sysDefBackgroundSound.value); } else { pauseAudio(backgroundPlayer); }
            } sysDefPostBackEff.value = sysDefLoop.value;
            if (requestMode.value == 'news_feed') { msgBox.innerHTML = '<p>'+jsonHTML(sysDefMsgData.value, sysDefFind.value)+'</p>'; }
            $('#powerButton').attr('src', sysDefPrefix.value+'power.png');
            $('#buttonPrev').attr('src', sysDefPrefix.value+'rew.png');
            $('#buttonNext').attr('src', sysDefPrefix.value+'ff.png');
            $('#buttonLock').attr('src', sysDefPrefix.value+((sysDefLock.value != 0)?'key.png':'lock.png'));
            $('#buttonOnReload').attr('src', sysDefPrefix.value+((sysDefReload.value != 0)?'bluetooth.png':'radio.png'));
            $('#buttonSongIndex').attr('src', sysDefPrefix.value+((sysDefSongIndex.value == 'random')?'shuffle.png':'update.png'));
            $('#buttonPitched').attr('src', sysDefPrefix.value+((sysDefPitchLock.value != 0)?'midi.png':'volume.png'));
            $('#buttonObserve').attr('src', sysDefPrefix.value+'power.png');
            $('#buttonSpectate').attr('src', sysDefPrefix.value+'unpower.png');
            $('#buttonEnter').attr('src', sysDefPrefix.value+'return.png');
            $('#buttonChat').attr('src', sysDefPrefix.value+((sysDefChat.value != 0)?'book.png':'bash.png'));
            $('#buttonKeyboard').attr('src', sysDefPrefix.value+'keyboard.png');
            $('#buttonBackspace').attr('src', sysDefPrefix.value+'backspace.png');
            $('#buttonLogin').attr('src', sysDefPrefix.value+'user.png');
            $('#buttonRegister').attr('src', sysDefPrefix.value+'book.png');
            $('#buttonCancelSignin').attr('src', sysDefPrefix.value+'backspace.png');
            $('#buttonTime').attr('src', sysDefPrefix.value+((sysDefTimedisp.value != 0)?((sysDefBenchmark.value != 0)?'note.png':'calendar.png'):((sysDefBenchmark.value != 0)?'speed.png':'time.png')));
            $('#buttonAutoplay').attr('src', sysDefPrefix.value+((sysDefAutoplay.value != 0)?'autopause.png':'autoplay.png'));
            $('#buttonRandom').attr('src', sysDefPrefix.value+'dice.png');
            $('#buttonVintage').attr('src', sysDefPrefix.value+'diamante.png');
            $('#buttonGloss').attr('src', sysDefPrefix.value+((sysDefGloss.value != 0)?'parfum.png':'deparfum.png'));
            $('#buttonPlay').attr('src', sysDefPrefix.value+((audioPlayer.paused != true)?'pause.png':'play.png'));
            $('#buttonAlarm').attr('src', sysDefPrefix.value+((alarmPlayer.paused != true)?'dial.png':'call.png'));
            $('#buttonMute').attr('src', sysDefPrefix.value+((sysDefMute.value != 0)?'audio.png':'music.png'));
            $('#buttonMuteBack').attr('src', sysDefPrefix.value+'disk.png');
            $('#buttonReqLock').attr('src', sysDefPrefix.value+((requestLock.value != 'true')?'expand.png':'collapse.png'));
            $('#buttonMaximize').attr('src', sysDefPrefix.value+((sysDefApps.value != 0)?'restore.png':'maximize.png'));
            $('#buttonMenuStyle').attr('src', sysDefPrefix.value+((sysDefIcons.value != 0)?'menu.png':'list.png'));
            $('#buttonUpdate').attr('src', sysDefPrefix.value+'world.png');
            $('#buttonUserStatus').attr('src', sysDefPrefix.value+"<?=(isAuth())?'user.png':'anonym.png';?>"); $('#buttonEscape').attr('src', sysDefPrefix.value+'escape.png'); var fint = pager(data, 5).split(' | ');
            if (requestMode.value == 'bookkeeping') {
                bookkeep_disp.innerHTML = '<table style="width:100%;position:relative;"><thead><th style="width:25%;">'+fint[9]+'</th><th style="width:25%;">'+fint[0]+'</th><th style="width:25%;">'+fint[1]+'</th><th style="width:25%;">'+fint[2]+'</th></thead><tbody>'+jsonBookKeep(sysDefBookKeep.value)+'</tbody></table>';
            } if (requestMode.value == 'play_store') {
                var stoInf = "<p align='center'>"+fint[7]+"</p><p align='center'>"+fint[8]+"</p><p align='center'>"+activeHrsBtn(bndm)+"</p>";
                var stoDop = '<table style="width:100%;position:relative;"><thead><th style="width:5%;">'+fint[3]+'</th><th style="width:7%;">'+fint[4]+'</th><th style="width:3%;">'+fint[5]+'</th></thead><tbody>'+jsonStore(bndm)+'</tbody></table>';
                store_disp.innerHTML = (sysDefSessionID.value != bndm) ? ((storeOpen(bndm)) ? stoDop : stoInf) : stoDop;
            } if (requestMode.value == 'font_book') {
                fontBook24Pt.innerText = fontBook22Pt.innerText = fontBook20Pt.innerText = fontBook18Pt.innerText = fontBook16Pt.innerText = fontBook14Pt.innerText = pager(data, 6);
            } if (requestMode.value == 'statistics') {
                tabScore.innerText = fint[6];
                $('#switchBtnAuto').attr('src', sysDefPrefix.value+'steer.png');
                $('#switchBtnCall').attr('src', sysDefPrefix.value+'dial.png');
                $('#switchBtnFrnd').attr('src', sysDefPrefix.value+'user.png');
                $('#switchBtnBind').attr('src', sysDefPrefix.value+'chain.png');
                $('#switchBtnTool').attr('src', sysDefPrefix.value+'parfum.png');
                $('#switchBtnScore').attr('src', sysDefPrefix.value+'money.png');
            } if (requestMode.value == 'preferences') {
                $('#prefsBtnApply').attr('src', sysDefPrefix.value+'return.png');
                $('#prefsBtnUpdate').attr('src', sysDefPrefix.value+'lock.png');
                $('#prefsBtnReset').attr('src', sysDefPrefix.value+'backspace.png');
                $('#prefsBtnClear').attr('src', sysDefPrefix.value+'error.png');
                $('#prefsBtnApplySizes').attr('src', sysDefPrefix.value+'ruler.png');
                $('#prefsBtnApplyColors').attr('src', sysDefPrefix.value+'paint.png');
            } if (requestMode.value == 'personalization') {
                $('#prefsBtnApply').attr('src', sysDefPrefix.value+'return.png');
                $('#prefsBtnUpdate').attr('src', sysDefPrefix.value+'lock.png');
                $('#prefsBtnReset').attr('src', sysDefPrefix.value+'backspace.png');
                $('#prefsBtnClear').attr('src', sysDefPrefix.value+'error.png');
                $('#prefsBtnUpdateTitle').attr('src', sysDefPrefix.value+'keyboard.png');
                $('#prefsBtnUpdateTitles').attr('src', sysDefPrefix.value+'movie.png');
            } if (requestMode.value == 'sticky_notes') {
                $('#myNotesNewBtn').attr('src', sysDefPrefix.value+'new.png'); $('#myNotesOpenBtn').attr('src', sysDefPrefix.value+'open.png'); $('#myNotesSaveBtn').attr('src', sysDefPrefix.value+'save.png');
                notesMenu.innerHTML = '<p align="center" class="block">'+noteBook(sysDefMetaList.value)+'</p>';
            } if (requestMode.value == 'user_tutorial') {
                helpMenu.innerHTML = '<p align="center" class="block">'+helpBook()+'</p>';
            } if (requestMode.value == 'text_editor') {
                $('#textEdRep').attr('src', sysDefPrefix.value+'new.png'); $('#textEdRepAll').attr('src', sysDefPrefix.value+'copy.png');
            } if (((obs == 1) && (spe == 1)) || ((obs == 1) && (spe == 0))) {
                $('#powerButton').show(); $('.panel').hide();
                $('.customPanel').hide(); $('.upperGap').hide();
                $('.lowerGap').hide(); $('.topbar').hide();
            } else {
                if ((obs == 0) && (spe == 1)) {
                    $('#powerButton').hide(); $('.panel').hide();
                    $('.customPanel').hide(); $('.upperGap').hide();
                    $('.lowerGap').hide(); $('.topbar').show();
                } else {
                    $('#powerButton').hide(); $('.panel').show();
                    $('.customPanel').show(); $('.upperGap').show();
                    $('.lowerGap').show(); $('.topbar').show();
                }
            } document.querySelector(':root').style.setProperty('--backdrop-filter', effi[0]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg', effi[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani', effi[2]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg', effi[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani', effi[4]);
            var calls = arrjob(sysDefCallData.value,';',':');
            if (enzi[0].split('')[1] != 0) {
                playAudio(tickerPlayer, sysDefTickingSound.value);
            } else {
                pauseAudio(tickerPlayer);
            } if (enzi[0].split('')[0] != 0) {
                playAudio(alarmPlayer, sysDefAlarmSound.value); setdata('memo', '');
            } if (calls[sysDefSessionID.value] != sysDefSessionID.value) {
                playAudio(alarmPlayer, sysDefAlarmSound.value);
                calls[sysDefSessionID.value] = sysDefSessionID.value;
                set('calling.json', JSON.stringify(calls), true);
                sysDefCallData.value = arrpack(calls,';',':');
            }
        },
    });
}
function visual_effects() {
    document.querySelector(':root').style.setProperty('--graddeg', sysDefGradient.value+'deg');
    document.querySelector(':root').style.setProperty('--backsize', sysDefBackSize.value+'pt');
    document.querySelector(':root').style.setProperty('--foresize', sysDefForeSize.value+'pt');
    document.querySelector(':root').style.setProperty('--inputsize', sysDefInputSize.value+'pt');
    document.querySelector(':root').style.setProperty('--head1size', sysDefHead1Size.value+'pt');
    document.querySelector(':root').style.setProperty('--head2size', sysDefHead2Size.value+'pt');
    document.querySelector(':root').style.setProperty('--head3size', sysDefHead3Size.value+'pt');
    document.querySelector(':root').style.setProperty('--dispsize', sysDefDispSize.value+'pt');
    document.querySelector(':root').style.setProperty('--priv1size', sysDefPriv1Size.value+'pt');
    document.querySelector(':root').style.setProperty('--priv2size', sysDefPriv2Size.value+'pt');
    document.querySelector(':root').style.setProperty('--priv3size', sysDefPriv3Size.value+'pt');
    document.querySelector(':root').style.setProperty('--backcolor', '#'+sysDefBackColor.value);
    document.querySelector(':root').style.setProperty('--forecolor', '#'+sysDefForeColor.value);
    document.querySelector(':root').style.setProperty('--inputcolor', '#'+sysDefInputColor.value);
    document.querySelector(':root').style.setProperty('--backtextcolor', '#'+sysDefBackTextColor.value);
    document.querySelector(':root').style.setProperty('--foretextcolor', '#'+sysDefForeTextColor.value);
    document.querySelector(':root').style.setProperty('--inputtextcolor', '#'+sysDefInputTextColor.value);
    document.querySelector(':root').style.setProperty('--blankcolor', '#'+sysDefBlankColor.value);
    document.querySelector(':root').style.setProperty('--blanktextcolor', '#'+sysDefBlankTextColor.value);
    document.querySelector(':root').style.setProperty('--arcforecolor', '#'+sysDefArcForeColor.value);
    document.querySelector(':root').style.setProperty('--arcinputcolor', '#'+sysDefArcInputColor.value);
    document.querySelector(':root').style.setProperty('--qucolor', '#'+(sysDefBackColor.value).slice(0, 6)+'00');
    document.querySelector(':root').style.setProperty('--radius', sysDefRadius.value+'px');
    document.querySelector(':root').style.setProperty('--box-shadow', sysDefBoxShadow.value);
    document.querySelector(':root').style.setProperty('--text-box-shadow', sysDefTextBoxShadow.value);
    document.querySelector(':root').style.setProperty('--blur-filter', 'blur('+sysDefBlur.value+'px) brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)');
    document.querySelector(':root').style.setProperty('--filter', 'brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)'); if (sysDefGloss.value == 1) {
        $('.power').css('background', 'linear-gradient('+sysDefGradient.value+'deg, #'+sysDefForeColor.value+' 0%, #'+sysDefArcForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-fore', 'linear-gradient(180deg, #'+sysDefForeColor.value+' 0%, #'+sysDefArcForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-input', 'linear-gradient(180deg, #'+sysDefInputColor.value+' 0%, #'+sysDefArcInputColor.value+' 100%)');
    } else {
        $('.power').css('background', 'linear-gradient('+sysDefGradient.value+'deg, #'+sysDefForeColor.value+' 0%, #'+sysDefForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-fore', 'linear-gradient(180deg, #'+sysDefForeColor.value+' 0%, #'+sysDefForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-input', 'linear-gradient(180deg, #'+sysDefInputColor.value+' 0%, #'+sysDefInputColor.value+' 100%)');
    } if (requestMode.value == 'visual_effects') {
        opacityInd.value = sysDefOpacity.value;
        blurInd.value = sysDefBlur.value+'px';
        brightnessInd.value = sysDefBrightness.value+'%';
        saturationInd.value = sysDefSaturation.value+'%';
        contrastInd.value = sysDefContrast.value+'%';
        sepiaInd.value = sysDefSepia.value+'%';
        grayInd.value = sysDefGrayscale.value+'%';
        hueInd.value = sysDefHue.value+'deg';
    }
}
function wallpaper_engine() {
    $.ajax({
        url: 'wallpaper_engine.php',
        success: function(data) {
            sysDefPrefix.value = pager(data, 6).split(';')[0];
            sysDefReticlePrefix.value = pager(data, 6).split(';')[1];
            $('#buttonChild').attr('src', sysDefPrefix.value+((pager(data, 5).split(':')[0] != 0)?'briefcase.png':'cabinet.png'));
            $('#sysDefVarsArr').val(pager(data, 5).split(':')[1]);
            $('body').css('background-image', 'url('+pager(data, 1)+')');
            $('#buttonAugment').attr('src', sysDefPrefix.value+(((sysDefVarsArr.value.split(';').length) > 1)?((sysDefEntry.value != '')?'diamond.png':'heart.png'):((sysDefEntry.value != '')?'club.png':'spade.png')));
            document.title = pager(data, 0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI'; document.querySelector(':root').style.setProperty('--position', pager(data, 4));
            $('#userAvatarBadge').attr('src', pager(data, 9));
            $('#buttonReticle').attr('src', sysDefReticlePrefix.value+sysDefReticle.value+'.png');
            $('#buttonDice').attr('src', sysDefPrefix.value+'dice.png');
            $('#chooseReticle1').attr('name', sysDefReticleChoice1.value);
            $('#chooseReticle2').attr('name', sysDefReticleChoice2.value);
            $('#chooseReticle3').attr('name', sysDefReticleChoice3.value);
            $('#chooseReticle4').attr('name', sysDefReticleChoice4.value);
            $('#chooseReticle5').attr('name', sysDefReticleChoice5.value);
            $('#chooseReticle1').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice1.value+'.png'); $('#chooseReticle2').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice2.value+'.png'); $('#chooseReticle3').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice3.value+'.png'); $('#chooseReticle4').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice4.value+'.png'); $('#chooseReticle5').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice5.value+'.png');
            arrangePlay(); <?php if (file_exists('mode.'.$request['mode'].'.php')) {
                if ($request['mode'] == 'main_menu') { ?>
                    $('#projectTitle').text(pager(data, 0).toUpperCase());
                    $('#showingAvatarNow').attr('src', pager(data, 10));
                <?php } ?>
            $('#showUsText').text(pager(data, 8));
            <?php } else { ?>
                $('#articleHead').text(pager(data, 7).toUpperCase());
                $('#articleBody').text(pager(data, 8));
                $('#articleLink').text(pager(data, 11));
                $('#articleLink').attr('href', pager(data, 11));
                $('#showingAvatarNow').attr('src', pager(data, 3));
            <?php } ?>
        },
    });
}
function active_hours() {
    $.ajax({
        url: 'active_hours.php',
        success: function(data) {
            $('#sysDefHoursActive').val(data);
        }
    });
}
function mailing_list() {
    $.ajax({
        url: 'mailing_list.php',
        success: function(data) { sysDefMailingJSONs.value = data; }
    });
}
function bookkeep_list() {
    $.ajax({
        url: 'bookkeep_list.php',
        success: function(data) { sysDefBookKeepJSONs.value = data; }
    });
}
function store_list() {
    $.ajax({
        url: 'store_list.php',
        success: function(data) { sysDefStoreJSONs.value = data; }
    });
}
function automator() {
    var autoPower = arrjob(sysDefAutoData.value,';',':');
    var bindPower = arrjob(sysDefBindData.value,';',':');
    var tabPower = arrjob(sysDefPowersData.value,';',':');
    var frndPower = arrjob(sysDefFriendData.value,';',':');
    var toolPower = arrjob(sysDefToolData.value,';',':');
    var userList = (sysDefUsersList.value).split(',');
    var subName = userList[rand(0, userList.length)];
    var objName = userList[rand(0, userList.length)];
    var subFrnd = friendsOf(frndPower, subName);
    var sut = obt = {}, sch = och = '', rnd = suc = obc = 0;
    if (requestMode.value == 'statistics') {
        userStats.innerText = scores(sysDefStats.value);
    } if ((subName != '') && (objName != '') && (isInt(tabPower[subName])) && (tabPower[subName] >= 0) && (autoPower[subName] == 'auto')) {
        sut = jsonMarket(subName);
        suc = Object.keys(sut).length;
        if (suc <= 0) {
            sch = '';
        } else if (suc == 1) {
            sch = Object.keys(sut)[0];
        } else {
            sch = Object.keys(sut)[rand(0, suc-1)];
        } console.log('SUBJECT @'+subName+': '+sch);
        bind(subName, objName); equip(subName, sch);
        obt = jsonMarket(objName);
        obc = Object.keys(obt).length;
        if (obc <= 0) {
            och = '';
        } else if (obc == 1) {
            och = Object.keys(obt)[0];
        } else {
            och = Object.keys(obt)[rand(0, obc-1)];
        } console.log('OBJECT @'+objName+': '+och);
        if ((subName != objName) && (obc <= 0) && (storeOpen(objName))) {
            buy_item(subName, och, objName);
        } if ((subName != objName) && (sut[sch]['type'] !== undefined) && (sut[sch]['type'] == 'weapon') && (!(subFrnd.includes(objName)))) {
            dominate(subName, objName, sch);
        } if ((subName == objName) && (sut[sch]['type'] !== undefined) && (sut[sch]['type'] != 'weapon') && (sut[sch]['force'] !== undefined) && (isInt(sut[sch]['force']))) {
            charge(subName, sch);
        }
    }
}
</script>
