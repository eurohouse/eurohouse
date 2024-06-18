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
            $('#sysDefBindData').val(pager(data, 1));
            $('#sysDefPowersData').val(pager(data, 2));
            $('#sysDefAutoData').val(pager(data, 3));
            $('#sysDefFriendData').val(pager(data, 4));
            $('#sysDefMsgData').val(pager(data, 5));
            $('#sysDefBookKeep').val(pager(data, 6));
            $('#sysDefMusicBox').val(pager(data, 7));
            $('#sysDefCodexBox').val(pager(data, 8).split("\\\\")[0]);
            $('#sysDefSpeechBox').val(pager(data, 8).split("\\\\")[1]);
            $('#sysDefUsersList').val(pager(data, 9));
            $('#sysDefBooksList').val(pager(data, 10));
            if (sysDefBindData.value != sysDefPostBindData.value) {
                if (sysDefMute.value == 0) {
                    playAudio(bindPlayer, sysDefBindSound.value);
                }
            }
            sysDefPostBindData.value = sysDefBindData.value;
            if (sysDefMsgData.value != sysDefPostMsgData.value) {
                if (sysDefMute.value == 0) {
                    playAudio(notifyPlayer, sysDefNotifySound.value);
                }
            }
            sysDefPostMsgData.value = sysDefMsgData.value;
            if (sysDefBookKeep.value != sysDefPostBookKeep.value) {
                if (sysDefMute.value == 0) {
                    playAudio(sufferPlayer, sysDefSufferSound.value);
                }
            }
            sysDefPostBookKeep.value = sysDefBookKeep.value;
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
            var enzi = pager(data, 1).split(' ');
            var effi = pager(data, 3).split(';');
            var mixers = pager(data, 4).split(' ');
            if (requestMode.value == 'volume_control') {
                audioVolInd.value = mixers[0];
                audioRatInd.value = mixers[1];
                audioBalInd.value = mixers[2];
                videoVolInd.value = mixers[3];
                videoRatInd.value = mixers[4];
                videoBalInd.value = mixers[5];
            } var tickCode = enzi[0]; var tickPanel = enzi[1];
            var obs = tickPanel.split('')[0];
            var spe = tickPanel.split('')[1];
            $('#powerButton').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value);
            $('#buttonNext').attr('src', sysDefPrefix.value+'go.png'+sysDefSuffix.value);
            $('#buttonLock').attr('src', sysDefPrefix.value+((sysDefLock.value != 0)?'key.png':'lock.png')+sysDefSuffix.value);
            sysDefMsgCounter.value = (sysDefMsgCounter.value <= 0) ? (Object.keys(JSONFilter(sysDefMsgData.value, sysDefFind.value)).length - 1) : (sysDefMsgCounter.value - 1);
            $('#showUsUrgent').text(Object.values(JSONFilter(sysDefMsgData.value, sysDefFind.value))[sysDefMsgCounter.value]);
            $('#buttonPrivate').attr('src', sysDefPrefix.value+((sysDefPrivate.value != 0)?'home.png':'world.png')+sysDefSuffix.value);
            $('#buttonPitched').attr('src', sysDefPrefix.value+((sysDefPitchLock.value != 0)?'microphone.png':'volume.png')+sysDefSuffix.value);
            $('#buttonObserve').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value);
            $('#buttonSpectate').attr('src', sysDefPrefix.value+'power.png'+sysDefSuffix.value);
            $('#buttonEnter').attr('src', sysDefPrefix.value+'return.png'+sysDefSuffix.value);
            $('#buttonChat').attr('src', sysDefPrefix.value+((sysDefChat.value != 0)?'book.png':'bash.png')+sysDefSuffix.value);
            $('#buttonKeyboard').attr('src', sysDefPrefix.value+'keyboard.png'+sysDefSuffix.value);
            $('#buttonBackspace').attr('src', sysDefPrefix.value+'backspace.png'+sysDefSuffix.value);
            $('#buttonLogin').attr('src', sysDefPrefix.value+'user.png'+sysDefSuffix.value);
            $('#buttonRegister').attr('src', sysDefPrefix.value+'book.png'+sysDefSuffix.value);
            $('#buttonCancelSignin').attr('src', sysDefPrefix.value+'backspace.png'+sysDefSuffix.value);
            $('#buttonOnend').attr('src', sysDefPrefix.value+'ff.png'+sysDefSuffix.value);
            $('#buttonTime').attr('src', sysDefPrefix.value+((sysDefBenchmark.value != 0)?'speed.png':'time.png')+sysDefSuffix.value);
            $('#buttonAutoplay').attr('src', sysDefPrefix.value+((sysDefAutoplay.value != 0)?'autopause.png':'autoplay.png')+sysDefSuffix.value);
            $('#buttonShuffle').attr('src', sysDefPrefix.value+((sysDefShuffle.value != 0)?'dice.png':'code.png')+sysDefSuffix.value);
            $('#buttonVintage').attr('src', sysDefPrefix.value+'diamante.png'+sysDefSuffix.value);
            $('#buttonVintageFilm').attr('src', sysDefPrefix.value+'movie.png'+sysDefSuffix.value);
            $('#buttonGloss').attr('src', sysDefPrefix.value+((sysDefGloss.value != 0)?'parfum.png':'idea.png')+sysDefSuffix.value);
            $('#buttonPlay').attr('src', sysDefPrefix.value+((audioPlayer.paused != true)?'pause.png':'play.png')+sysDefSuffix.value);
            $('#buttonAlarm').attr('src', sysDefPrefix.value+((alarmPlayer.paused != true)?'dial.png':'call.png')+sysDefSuffix.value);
            $('#buttonMute').attr('src', sysDefPrefix.value+((sysDefMute.value != 0)?'audio.png':'music.png')+sysDefSuffix.value);
            $('#buttonReqLock').attr('src', sysDefPrefix.value+((requestLock.value != 'true')?'expand.png':'collapse.png')+sysDefSuffix.value);
            $('#buttonFaceoff').attr('src', sysDefPrefix.value+((sysDefFaceoff.value != 0)?'maximize.png':'restore.png')+sysDefSuffix.value);
            $('#buttonIconsList').attr('src', sysDefPrefix.value+((sysDefIcons.value == 1)?'menu.png':'list.png')+sysDefSuffix.value);
            $('#buttonUpdate').attr('src', sysDefPrefix.value+'update.png'+sysDefSuffix.value);
            $('#buttonUserStatus').attr('src', sysDefPrefix.value+((sysDefIsSession.value !== false)?'user.png':'anonym.png')+sysDefSuffix.value);
            $('#buttonEscape').attr('src', sysDefPrefix.value+'escape.png'+sysDefSuffix.value);
            if (sysDefVintage.value != sysDefPostBackEff.value) {
                if (sysDefVintage.value != 0) {
                    playAudio(backgroundPlayer, sysDefBackgroundSound.value);
                } else {
                    pauseAudio(backgroundPlayer);
                }
            }
            sysDefPostBackEff.value = sysDefVintage.value;
            if (requestMode.value == 'news_feed') {
                msgBox.innerHTML = '<p>'+JSONtoHTML(sysDefMsgData.value, sysDefFind.value)+'</p>';
            }
            if (requestMode.value == 'bookkeeping') {
                bookkeep_disp.innerHTML = '<p>'+JSONtoHTML(sysDefBookKeep.value, sysDefFind.value)+'</p>';
            }
            if (((obs == 1) && (spe == 1)) || ((obs == 1) && (spe == 0))) {
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
            }
            document.querySelector(':root').style.setProperty('--backdrop-filter', effi[0]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg', effi[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani', effi[2]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg', effi[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani', effi[4]);
            if (tickCode.split('')[1] != 0) {
                playAudio(tickerPlayer, sysDefTickingSound.value);
            } else {
                pauseAudio(tickerPlayer);
            }
            if (tickCode.split('')[0] != 0) {
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
            }
            if (requestMode.value == 'visual_effects') {
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
            $('#buttonChild').attr('src', sysDefPrefix.value+((varsPlus.split(':')[0] != 0)?'weather.png':'tree.png')+sysDefSuffix.value);
            $('#sysDefVarsArr').val(varsPlus.split(':')[1]);
            $('body').css('background-image', 'url('+pager(data, 1)+')');
            $('#buttonAugment').attr('src', sysDefPrefix.value+(((sysDefVarsArr.value.split(';').length) > 1)?((sysDefEntry.value != '')?'diamond.png':'heart.png'):((sysDefEntry.value != '')?'club.png':'spade.png'))+sysDefSuffix.value);
            document.title = pager(data, 0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI'; document.querySelector(':root').style.setProperty('--position', pager(data, 4));
            $('#userAvatarBadge').attr('src', pager(data, 9)+sysDefSuffix.value);
            $('#buttonReticle').attr('src', sysDefReticlePrefix.value+sysDefReticle.value+'.png'+sysDefSuffix.value);
            $('#buttonDice').attr('src', sysDefPrefix.value+'dice.png'+sysDefSuffix.value);
            $('#chooseReticle1').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice1.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle2').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice2.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle3').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice3.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle4').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice4.value+'.png'+sysDefSuffix.value);
            $('#chooseReticle5').attr('src', sysDefReticlePrefix.value+sysDefReticleChoice5.value+'.png'+sysDefSuffix.value);
            arrangePlay();
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
