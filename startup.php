<script>
window.onload = function() {
    <?php if (isAuth()) { ?>
        document.getElementById('omniBox').focus();
    <?php } else { ?>
        document.getElementById('omniBoxAuthLogin').focus();
    <?php } ?>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    if ((sysDefAutoplay.value == 1) && (sysDefPlaying.value == 1)) {
        omniListen(hex2bin(sysDefMelody.value));
    }
    if (requestMode.value == 'media_player') {
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
            $('#sysDefFind').val(pager(data, 1));
            $('#sysDefBindData').val(pager(data, 2));
            $('#sysDefPowersData').val(pager(data, 3));
            $('#sysDefAutoData').val(pager(data, 4));
            $('#sysDefFriendData').val(pager(data, 5));
            $('#sysDefMsgData').val(pager(data, 6));
            $('#sysDefBookKeep').val(pager(data, 7));
            $('#sysDefMusicBox').val(pager(data, 8));
            $('#sysDefCodexBox').val(pager(data, 9).split("\\\\")[0]);
            $('#sysDefSpeechBox').val(pager(data, 9).split("\\\\")[1]);
            $('#sysDefUsersList').val(pager(data, 10));
            $('#sysDefBooksList').val(pager(data, 11));
            if (sysDefBindData.value != sysDefPostBindData.value) {
                if (sysDefMute.value == 0) {
                    playAudio(bindPlayer, sysDefBindSound.value);
                }
            }
            sysDefPostBindData.value = sysDefBindData.value;
            if (sysDefMsgData.value != sysDefPostMsgData.value) {
                playAudio(notifyPlayer, sysDefNotifySound.value);
            }
            sysDefPostMsgData.value = sysDefMsgData.value;
        }
    });
}
function world_clock() {
    $.ajax({
        url: 'world_clock.php',
        success: function(data) {
            $('#currentTime').val(pager(data, 0));
            $('#alarmTime').val(pager(data, 2));
            init_user(sysDefSessionID.value, 'manual');
            var effi = pager(data, 3).split(' ');
            var mixers = pager(data, 4).split(' ');
            if (requestMode.value == 'volume_control') {
                audioVolInd.value = mixers[0];
                audioRatInd.value = mixers[1];
                audioBalInd.value = mixers[2];
                videoVolInd.value = mixers[3];
                videoRatInd.value = mixers[4];
                videoBalInd.value = mixers[5];
            }
            var tickCode = pager(data, 1).split(' ')[0];
            var tickPane1 = pager(data, 1).split(' ')[1];
            var tickPane2 = pager(data, 1).split(' ')[2];
            var obs = tickPane1.split('')[0];
            var spe = tickPane1.split('')[1];
            var vint = tickPane1.split('')[2];
            var icn = tickPane2.split('')[0];
            var prv = tickPane2.split('')[1];
            var cht = tickPane2.split('')[2];
            $('#powerButton').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value);
            $('#buttonNext').attr('src', sysDefPrefix.value+'go.png'+sysDefSuffix.value);
            if (sysDefLock.value != 0) {
                $('#buttonLock').attr('src', sysDefPrefix.value+'key.png'+sysDefSuffix.value);
            } else {
                $('#buttonLock').attr('src', sysDefPrefix.value+'lock.png'+sysDefSuffix.value);
            }
            var msgcnt = Object.keys(JSONFilter(sysDefMsgData.value, sysDefFind.value)).length - 1;
            if (sysDefMsgCounter.value <= 0) {
                sysDefMsgCounter.value = msgcnt;
            } else {
                sysDefMsgCounter.value = sysDefMsgCounter.value - 1;
            }
            $('#showUsUrgent').text(Object.values(JSONFilter(sysDefMsgData.value, sysDefFind.value))[sysDefMsgCounter.value]);
            if (prv != 0) {
                $('#buttonPrivate').attr('src', sysDefPrefix.value+'home.png'+sysDefSuffix.value);
            } else {
                $('#buttonPrivate').attr('src', sysDefPrefix.value+'world.png'+sysDefSuffix.value);
            }
            if (sysDefPitchLock.value != 0) {
                $('#buttonPitched').attr('src', sysDefPrefix.value+'microphone.png'+sysDefSuffix.value);
            } else {
                $('#buttonPitched').attr('src', sysDefPrefix.value+'volume.png'+sysDefSuffix.value);
            }
            $('#buttonObserve').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value);
            $('#buttonSpectate').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value);
            $('#buttonEnter').attr('src', sysDefPrefix.value+'return.png'+sysDefSuffix.value);
            if (cht != 0) {
                $('#buttonChat').attr('src', sysDefPrefix.value+'book.png'+sysDefSuffix.value);
            } else {
                $('#buttonChat').attr('src', sysDefPrefix.value+'bash.png'+sysDefSuffix.value);
            }
            $('#buttonKeyboard').attr('src', sysDefPrefix.value+'keyboard.png'+sysDefSuffix.value);
            $('#buttonBackspace').attr('src', sysDefPrefix.value+'backspace.png'+sysDefSuffix.value);
            $('#buttonLogin').attr('src', sysDefPrefix.value+'user.png'+sysDefSuffix.value);
            $('#buttonRegister').attr('src', sysDefPrefix.value+'book.png'+sysDefSuffix.value);
            $('#buttonCancelSignin').attr('src', sysDefPrefix.value+'backspace.png'+sysDefSuffix.value);
            $('#buttonOnend').attr('src', sysDefPrefix.value+'ff.png'+sysDefSuffix.value);
            if (sysDefBenchmark.value != 0) {
                $('#buttonTime').attr('src', sysDefPrefix.value+'speed.png'+sysDefSuffix.value);
            } else {
                $('#buttonTime').attr('src', sysDefPrefix.value+'time.png'+sysDefSuffix.value);
            }
            if (sysDefAutoplay.value != 0) {
                $('#buttonAutoplay').attr('src', sysDefPrefix.value+'autopause.png'+sysDefSuffix.value);
            } else {
                $('#buttonAutoplay').attr('src', sysDefPrefix.value+'autoplay.png'+sysDefSuffix.value);
            }
            if (sysDefShuffle.value != 0) {
                $('#buttonShuffle').attr('src', sysDefPrefix.value+'dice.png'+sysDefSuffix.value);
            } else {
                $('#buttonShuffle').attr('src', sysDefPrefix.value+'code.png'+sysDefSuffix.value);
            }
            $('#buttonVintage').attr('src', sysDefPrefix.value+'diamante.png'+sysDefSuffix.value);
            $('#buttonVintageFilm').attr('src', sysDefPrefix.value+'movie.png'+sysDefSuffix.value);
            if (sysDefGloss.value != 0) {
                $('#buttonGloss').attr('src', sysDefPrefix.value+'parfum.png'+sysDefSuffix.value);
            } else {
                $('#buttonGloss').attr('src', sysDefPrefix.value+'idea.png'+sysDefSuffix.value);
            }
            if (audioPlayer.paused != true) {
                $('#buttonPlay').attr('src', sysDefPrefix.value+'pause.png'+sysDefSuffix.value);
            } else {
                $('#buttonPlay').attr('src', sysDefPrefix.value+'play.png'+sysDefSuffix.value);
            }
            if (alarmPlayer.paused != true) {
                $('#buttonAlarm').attr('src', sysDefPrefix.value+'dial.png'+sysDefSuffix.value);
            } else {
                $('#buttonAlarm').attr('src', sysDefPrefix.value+'call.png'+sysDefSuffix.value);
            }
            if (sysDefMute.value != 0) {
                $('#buttonMute').attr('src', sysDefPrefix.value+'audio.png'+sysDefSuffix.value);
            } else {
                $('#buttonMute').attr('src', sysDefPrefix.value+'music.png'+sysDefSuffix.value);
            }
            if (requestLock.value != 'true') {
                $('#buttonReqLock').attr('src', sysDefPrefix.value+'expand.png'+sysDefSuffix.value);
            } else {
                $('#buttonReqLock').attr('src', sysDefPrefix.value+'collapse.png'+sysDefSuffix.value);
            }
            if (sysDefFaceoff.value != 0) {
                $('#buttonFaceoff').attr('src', sysDefPrefix.value+'maximize.png'+sysDefSuffix.value);
            } else {
                $('#buttonFaceoff').attr('src', sysDefPrefix.value+'restore.png'+sysDefSuffix.value);
            }
            if (icn == 1) {
                $('#buttonIconsList').attr('src', sysDefPrefix.value+'menu.png'+sysDefSuffix.value);
            } else {
                $('#buttonIconsList').attr('src', sysDefPrefix.value+'list.png'+sysDefSuffix.value);
            }
            $('#buttonUpdate').attr('src', sysDefPrefix.value+'update.png'+sysDefSuffix.value);
            if (sysDefIsSession.value !== false) {
                $('#buttonUserStatus').attr('src', sysDefPrefix.value+'user.png'+sysDefSuffix.value);
            } else {
                $('#buttonUserStatus').attr('src', sysDefPrefix.value+'anonym.png'+sysDefSuffix.value);
            }
            $('#buttonEscape').attr('src', sysDefPrefix.value+'escape.png'+sysDefSuffix.value);
            if (vint != sysDefPostBackEff.value) {
                if (vint != 0) {
                    playAudio(backgroundPlayer, sysDefBackgroundSound.value);
                } else {
                    pauseAudio(backgroundPlayer);
                }
            }
            sysDefPostBackEff.value = vint;
            if (requestMode.value == 'news_feed') {
                msgBox.innerHTML = '<p>'+JSONtoHTML(sysDefMsgData.value, sysDefFind.value)+'</p>';
            }
            if (requestMode.value == 'bookkeeping') {
                bookkeep_disp.innerHTML = '<p>'+JSONtoHTML(sysDefBookKeep.value, sysDefFind.value)+'</p>';
            }
            if (((obs == 1) && (spe == 1)) || ((obs == 1) && (spe == 0))) {
                $('#powerButton').show();
                $('.panel').hide();
                $('.customPanel').hide();
                $('.upperGap').hide();
                $('.lowerGap').hide();
                $('.topbar').hide();
            } else {
                if ((obs == 0) && (spe == 1)) {
                    $('#powerButton').hide();
                    $('.panel').hide();
                    $('.customPanel').hide();
                    $('.upperGap').hide();
                    $('.lowerGap').hide();
                    $('.topbar').show();
                } else {
                    $('#powerButton').hide();
                    $('.panel').show();
                    $('.customPanel').show();
                    $('.upperGap').show();
                    $('.lowerGap').show();
                    $('.topbar').show();
                }
            }
            document.querySelector(':root').style.setProperty('--backdrop-filter', effi[0]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg', effi[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani', effi[2]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg', effi[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani', effi[4]);
            var ongo = tickCode.split('')[0];
            var inco = tickCode.split('')[1];
            if (inco != 0) {
                playAudio(tickerPlayer, sysDefTickingSound.value);
            } else {
                pauseAudio(tickerPlayer);
            }
            if (ongo != 0) {
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
            document.querySelector(':root').style.setProperty('--box-shadow', '0px 0px '+miniPager(data, 1)+'px '+miniPager(data, 1)+'px #'+miniPager(data, 19));
            document.querySelector(':root').style.setProperty('--text-box-shadow', '0px 0px '+miniPager(data, 1)+'px '+miniPager(data, 1)+'px #'+miniPager(data, 20));
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
            }
        },
    });
}
function wallpaper_engine() {
    $.ajax({
        url: 'wallpaper_engine.php',
        success: function(data) {
            sysDefPrefix.value = pager(data, 6).split(';')[0];
            sysDefReticlePrefix.value = pager(data, 6).split(';')[1];
            var varsPlus = pager(data, 5);
            if (varsPlus.split(':')[0] != 0) {
                $('#buttonChild').attr('src', sysDefPrefix.value+'weather.png'+sysDefSuffix.value);
            } else {
                $('#buttonChild').attr('src', sysDefPrefix.value+'tree.png'+sysDefSuffix.value);
            }
            $('#sysDefVarsArr').val(varsPlus.split(':')[1]);
            var decodePowers = arrjob(sysDefPowersData.value,';',':');
            var decodeBind = arrjob(sysDefBindData.value,';',':');
            var decodeAuto = arrjob(sysDefAutoData.value,';',':');
            sysDefAutoState.value = decodeAuto[sysDefSessionID.value];
            if (sysDefAutoState.value == 'auto') {
                $('#buttonAutomator').attr('src', sysDefPrefix.value+'wheel.png'+sysDefSuffix.value);
            } else {
                $('#buttonAutomator').attr('src', sysDefPrefix.value+'steer.png'+sysDefSuffix.value);
            }
            sysDefPower.value = decodePowers[sysDefSessionID.value];
            if (sysDefPower.value != sysDefPostPower.value) {
                playAudio(sufferPlayer, sysDefSufferSound.value);
            }
            sysDefPostPower.value = sysDefPower.value;
            var valBind = ''; var valBond = '';
            var valPwrTh = 0; var valPwrBal = '';
            if (sysDefPower.value <= -666) {
                delete_user(sysDefSessionID.value);
                omniAuthRequest('signout', '', '');
            }
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
            }
            document.title = pager(data, 0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI';
            document.querySelector(':root').style.setProperty('--position', pager(data, 4));
            $('#userAvatarBadge').attr('src', pager(data, 9)+sysDefSuffix.value);
            var valPwrMy = (isInt(decodePowers[sysDefSessionID.value])) ? parseInt(decodePowers[sysDefSessionID.value]) : 0;
            $('#buttonReticle').attr('src', sysDefReticlePrefix.value+sysDefReticle.value+'.png'+sysDefSuffix.value);
            $('#buttonDice').attr('src', sysDefPrefix.value+'dice.png'+sysDefSuffix.value);
            $('#chooseReticle1').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice1.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle2').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice2.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle3').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice3.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle4').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice4.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle5').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice5.value+'.png'+sysDefSuffix.value);
            var bindFunc = arraySearch(sysDefSessionID.value, decodeBind);
            if (bindFunc != false) {
                if (decodeBind[sysDefSessionID.value] != sysDefSessionID.value) {
                    valBind = bindFunc;
                    valBond = '+@'+sysDefSessionID.value+'+';
                    valPwrTh = (isInt(decodePowers[valBind])) ? parseInt(decodePowers[valBind]) : 0; valPwrBal = valPwrMy+':'+valPwrTh;
                    sysDefObjPower.value = valPwrTh;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
                } else {
                    valBind = bindFunc;
                    valBond = '+@'+sysDefSessionID.value;
                    valPwrTh = (isInt(decodePowers[valBind])) ? parseInt(decodePowers[valBind]) : 0; valPwrBal = valPwrMy+':'+valPwrTh;
                    sysDefObjPower.value = valPwrMy;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
                }
            } else {
                if (decodeBind[sysDefSessionID.value] != sysDefSessionID.value) {
                    valBind = decodeBind[sysDefSessionID.value];
                    valBond = '@'+sysDefSessionID.value+'+';
                    valPwrTh = ((isInt(decodePowers[valBind])) ? parseInt(decodePowers[valBind]) : 0); valPwrBal = valPwrMy+':'+valPwrTh;
                    sysDefObjPower.value = valPwrTh;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
                } else {
                    valBond = '@'+sysDefSessionID.value; valPwrBal = valPwrMy;
                    sysDefObjPower.value = valPwrMy;
                    $('#buttonBroke').attr('src', sysDefPrefix.value+'chain.png'+sysDefSuffix.value);
                }
            }
            $('#showUsInfoPower').val(valPwrBal);
            $('#showUsInfoBond').val(valBond);
            <?php if (file_exists('mode.'.$request['mode'].'.php')) {
                if ($request['mode'] == 'main_menu') { ?>
                    $('#projectTitle').text(pager(data, 0).toUpperCase());
                    $('#showingAvatarNow').attr('src', pager(data, 10));
                <?php } ?>
            $('#showUsText').text(pager(data, 8));
            <?php } else { ?>
                $('#articleHead').text(pager(data, 7).toUpperCase());
                $('#articleBody').text(pager(data, 8));
                $('#showingAvatarNow').attr('src', pager(data, 3));
            <?php } ?>
        },
    });
}
function mailing_list() {
    $.ajax({
        url: 'mailing_list.php',
        success: function(data) {
            sysDefMailingJSONs.value = data;
        }
    });
}
function bookkeep_list() {
    $.ajax({
        url: 'bookkeep_list.php',
        success: function(data) {
            sysDefBookKeepJSONs.value = data;
        }
    });
}
function automator() {
    var autoPower = arrjob(sysDefAutoData.value,';',':');
    var bindPower = arrjob(sysDefBindData.value,';',':');
    var tabPower = arrjob(sysDefPowersData.value,';',':');
    var frndPower = arrjob(sysDefFriendData.value,';',':');
    $.ajax({
        url: 'automator.php',
        success: function(data) {
            var subName = miniPager(data, 0);
            var objName = miniPager(data, 1);
            var handle = miniPager(data, 2);
            var status = miniPager(data, 3);
            var subFrnd = friendsOf(frndPower, subName);
            if (requestMode.value == 'statistics') {
                userStats.innerText = scores(sysDefStats.value);
                userStatsAuto.innerText = (subName == 'root') ? CryptoJS.MD5(status+'@'+subName+'#'+objName+'&'+handle).toString() : CryptoJS.MD5(status+'@'+subName+'$'+objName+'&'+handle).toString();
            }
            if ((subName != '') && (objName != '') && (subName != objName) && (isInt(tabPower[subName])) && (tabPower[subName] >= 0) && (autoPower[subName] == 'auto') && (status == 200)) {
                bind(subName, handle);
                if ((objName == handle) && (!(subFrnd.includes(objName)))) {
                    dominate(subName, objName, 1, 1, 0);
                }
            }
        }
    });
}
</script>
