<script>
window.onload=function() {
    if (window.history.replaceState) {
        window.history.replaceState(null,null,window.location.href);
    } if ((sysDefAutoplay.value==1)&&(sysDefPlaying.value==1)) {
        omniListen(atob(sysDefMelody.value));
    } if (requestMode.value=='media_player') {
        replayVideo(video);
    } else if (requestMode.value=='volume_control') {
        audioVolInd.value=sysDefAudioVolume.value;
        audioRatInd.value=sysDefAudioSpeed.value;
        videoVolInd.value=sysDefVideoVolume.value;
        videoRatInd.value=sysDefVideoSpeed.value;
    } else if (requestMode.value=='text_editor') { countText();
    } else if (requestMode.value=='sticky_notes') { countNote();
    } else if (requestMode.value=='album_tracklist') {
        playlistCollectionHTML();
    } else if (requestMode.value=='weather') {
        promptWeather.focus(); populateWeatherTable();
    } else if (requestMode.value=='statistics') {
        promptStats.focus(); populateIpStats();
    } else if ((requestMode.value=='file_manager')||(requestMode.value=='picture_gallery')) {
        searchBox.focus();
    } else if (requestMode.value=='terminal') {
        promptExec.focus();
    } else if (requestMode.value=='artificial_intelligence') {
        promptGPT.focus();
    } else if (requestMode.value=='calculator') {
        calcExpr.focus();
    } else if (requestMode.value=='messenger') {
        composeMessage.focus();
    } else {
        if (authstate()) { omniBox.focus();
        } else { omniBoxAuthLogin.focus(); }
    }
};
$(document).ready(function() {
    <?php foreach ($settings['intervals'] as $key=>$val) { ?>
        setInterval(<?=$key;?>,<?=$val;?>);
    <?php } ?>
});
function subscriptions() {
    $.ajax({
        url: 'subscriptions.php',
        success: function(data) {
            $('#sysDefPrefData').val(pager(data,0));
            sysDefPrefix.value=(sysDefPrefData.value).split(',')[3];
            sysDefAva0Prefix.value=(sysDefPrefData.value).split(',')[0];
            sysDefAva1Prefix.value=(sysDefPrefData.value).split(',')[1];
            sysDefPic0Prefix.value=(sysDefPrefData.value).split(',')[2];
            sysDefPic1Prefix.value=(sysDefPrefData.value).split(',')[3];
            $('#sysDefSubscriptions').val(pager(data,1));
        }
    });
}
function repository() {
    $.ajax({
        url: 'repository.php',
        success: function(data) {
            $('#sysDefContentData').val(pager(data,0));
            $('#sysDefModelData').val(pager(data,0));
        }
    });
}
function messenger() {
    $.ajax({
        url: 'messenger.php',
        success: function(data) {
            $('#sysDefMessengerJSONs').val(pager(data,0));
            sysDefMyMessengerData.value=openJournal(sysDefSessionID.value,sysDefMessengerJSONs);
            if (sysDefMyMessengerData.value!=sysDefPostMyMessengerData.value) {
                playAudio(notifyPlayer,sysDefNotifySound.value);
            } sysDefPostMyMessengerData.value=sysDefMyMessengerData.value;
        }
    });
}
function sticky_notes() {
    $.ajax({
        url: 'sticky_notes.php',
        success: function(data) {
            $('#sysDefMetaData').val(pager(data,0));
            $('#sysDefMetaList').val(Object.keys(jsonarr(sysDefMetaData.value)).join(' | '));
        }
    });
}
function world_clock() {
    $.ajax({
        url: 'world_clock.php',
        success: function(data) {
            $('#currentTime').val(pager(data,sysDefTimedisp.value));
            $('#alarmTime').val((pager(data,2)!='00:00')?pager(data,2):((sysDefPlayBackwards.value!=0)?hhmmss((sysDefDuration.value-audioPlayer.currentTime),true):hhmmss(audioPlayer.currentTime,true)));
            if ((pager(data,2)!='00:00')&&(pager(data,2)!='--:--')&&(sysDefMemo.value!='')) {
                playAudio(tickerPlayer,sysDefTickingSound.value);
            } else { pauseAudio(tickerPlayer); }
            if ((pager(data,2)=='--:--')&&(sysDefMemo.value!='')) {
                playAudio(alarmPlayer,sysDefAlarmSound.value);
                setdata('memo','');
            } $('#sysDefEffects').val(pager(data,4));
            var effects=jsonarr(sysDefEffects.value);
            $('#sysDefPangram').val(pager(data,5));
            $('#sysDefIpData').val(pager(data,6));
            var uidm=sysDefSessionID.value; if (authstate()) {
                sysDefMsgMaxCount.value=parseInt(Object.keys(filterMessages(sysDefMyMessengerData.value,uidm,sysDefFind.value)).length-1);
                sysDefMsgCounter.value=(sysDefReadBackwards.value!=0)?((parseInt(sysDefMsgCounter.value)<=0)?sysDefMsgMaxCount.value:(parseInt(sysDefMsgCounter.value)-1)):((parseInt(sysDefMsgCounter.value)>=sysDefMsgMaxCount.value)?0:(parseInt(sysDefMsgCounter.value)+1));
                sysDefMsgCurrent.value=Object.values(filterMessages(sysDefMyMessengerData.value,uidm,sysDefFind.value,'msg'))[sysDefMsgCounter.value];
                $('#showUsUrgent').text(sysDefMsgCurrent.value);
            } if (sysDefLoop.value!=sysDefPostBackEff.value) {
                if (sysDefLoop.value!=0) {
                    playAudio(backgroundPlayer,sysDefBackgroundSound.value);
                } else { pauseAudio(backgroundPlayer); }
            } sysDefPostBackEff.value=sysDefLoop.value;
            document.querySelector(':root').style.setProperty('--bicolor',alphaHex(sysDefBackColor.value,sysDefOpacity.value));
            $('#powerButton').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonObserve').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonSpectate').attr('src',sysDefPrefix.value+'unpower.png');
            $('#buttonMenu').attr('src',sysDefPrefix.value+sysDefMenuView.value+'.png');
            $('#buttonUpdate').attr('src',sysDefPrefix.value+'world.png');
            $('#buttonCommand').attr('src',sysDefPrefix.value+'start.png');
            $('#buttonSuggest').attr('src',sysDefPrefix.value+'dice.png');
            $('#buttonMusic').attr('src',sysDefPrefix.value+'music.png');
            $('#buttonImage').attr('src',sysDefPrefix.value+((sysDefBackground.value!='')?'paint.png':'image.png'));
            $('#buttonLock').attr('src',sysDefPrefix.value+((requestLock.value!='false')?'lock.png':'key.png'));
            $('#buttonAutoplay').attr('src',sysDefPrefix.value+((sysDefAutoplay.value!=0)?'autopause.png':'autoplay.png'));
            $('#buttonShuffle').attr('src',sysDefPrefix.value+((sysDefShuffle.value!=0)?'shuffle.png':'update.png'));
            $('#buttonPlay').attr('src',sysDefPrefix.value+((audioPlayer.paused!=true)?'pause.png':'play.png'));
            $('#buttonPrev').attr('src',sysDefPrefix.value+'rew.png');
            $('#buttonNext').attr('src',sysDefPrefix.value+'ff.png');
            $('#buttonVintage').attr('src',sysDefPrefix.value+'diamante.png');
            $('#buttonBackSound').attr('src',sysDefPrefix.value+'disk.png');
            $('#buttonMute').attr('src',sysDefPrefix.value+((sysDefMute.value!=0)?'audio.png':'error.png'));
            $('#buttonEnter').attr('src',sysDefPrefix.value+'return.png');
            $('#buttonKeyboard').attr('src',sysDefPrefix.value+'keyboard.png');
            $('#buttonBackspace').attr('src',sysDefPrefix.value+'backspace.png');
            $('#buttonEscape').attr('src',sysDefPrefix.value+((sysDefIsModeNull.value!=0)?'forward.png':'escape.png'));
            $('#buttonAuth').attr('src',sysDefPrefix.value+'user.png');
            if (((sysDefObserve.value!=0)&&(sysDefSpectate.value!=0))||((sysDefObserve.value!=0)&&(sysDefSpectate.value==0))) {
                $('#powerButton').show(); $('.panel').hide();
                $('.customPanel').hide(); $('.upperGap').hide();
                $('.lowerGap').hide(); $('.topbar').hide();
            } else {
                if ((sysDefObserve.value==0)&&(sysDefSpectate.value!=0)) {
                    $('#powerButton').hide(); $('.panel').hide();
                    $('.customPanel').hide(); $('.upperGap').hide();
                    $('.lowerGap').hide(); $('.topbar').show();
                } else {
                    $('#powerButton').hide(); $('.panel').show();
                    $('.customPanel').show(); $('.upperGap').show();
                    $('.lowerGap').show(); $('.topbar').show();
                }
            } document.querySelector(':root').style.setProperty('--marquee-animation','scrollMarquee '+sysDefMarqueeSpeed.value+'s linear infinite');
            document.querySelector(':root').style.setProperty('--backdrop-filter',effects[0]);
            document.querySelector(':root').style.setProperty('--backdrop-opacity',effects[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg',effects[2]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani',effects[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg',effects[4]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani',effects[5]);
            if (requestMode.value=='messenger') {
                if (authstate()) {
                    msgBox.innerHTML='<p>'+messengerHTML(sysDefMyMessengerData.value,uidm,sysDefFind.value)+'</p>';
                }
            } else if (requestMode.value=='date_and_time') {
                hourInd.style.width=(100*((pager(data,3)).split(':')[0]/23))+'%';
                minuteInd.style.width=(100*((pager(data,3)).split(':')[1]/59))+'%';
                secondInd.style.width=(100*((pager(data,3)).split(':')[2]/59))+'%';
            } else if (requestMode.value=='font_book') {
                fontBook24Pt.innerText=fontBook22Pt.innerText=fontBook20Pt.innerText=fontBook18Pt.innerText=fontBook16Pt.innerText=fontBook14Pt.innerText=sysDefPangram.value;
            } else if (requestMode.value=='sticky_notes') {
                if (authstate()) {
                    notesMenu.innerHTML='<p align="center" class="block">'+notebookHTML(sysDefMetaList.value)+'</p>';
                }
            }
        }
    });
}
function visual_effects() {
    document.querySelector(':root').style.setProperty('--grad-fore',sysDefGradientFore.value+'deg');
    document.querySelector(':root').style.setProperty('--grad-input',sysDefGradientInput.value+'deg');
    document.querySelector(':root').style.setProperty('--grad-button',sysDefGradientButton.value+'deg');
    document.querySelector(':root').style.setProperty('--backsize',sysDefBackSize.value+'pt');
    document.querySelector(':root').style.setProperty('--foresize',sysDefForeSize.value+'pt');
    document.querySelector(':root').style.setProperty('--inputsize',sysDefInputSize.value+'pt');
    document.querySelector(':root').style.setProperty('--head1size',sysDefHead1Size.value+'pt');
    document.querySelector(':root').style.setProperty('--head2size',sysDefHead2Size.value+'pt');
    document.querySelector(':root').style.setProperty('--head3size',sysDefHead3Size.value+'pt');
    document.querySelector(':root').style.setProperty('--dispsize',sysDefDispSize.value+'pt');
    document.querySelector(':root').style.setProperty('--priv1size',sysDefPriv1Size.value+'pt');
    document.querySelector(':root').style.setProperty('--priv2size',sysDefPriv2Size.value+'pt');
    document.querySelector(':root').style.setProperty('--priv3size',sysDefPriv3Size.value+'pt');
    document.querySelector(':root').style.setProperty('--backcolor',sysDefBackColor.value);
    document.querySelector(':root').style.setProperty('--forecolor',sysDefForeColor.value);
    document.querySelector(':root').style.setProperty('--inputcolor',sysDefInputColor.value);
    document.querySelector(':root').style.setProperty('--backtextcolor',sysDefBackTextColor.value);
    document.querySelector(':root').style.setProperty('--foretextcolor',sysDefForeTextColor.value);
    document.querySelector(':root').style.setProperty('--inputtextcolor',sysDefInputTextColor.value);
    document.querySelector(':root').style.setProperty('--blankcolor',sysDefBlankColor.value);
    document.querySelector(':root').style.setProperty('--blanktextcolor',sysDefBlankTextColor.value);
    document.querySelector(':root').style.setProperty('--arcforecolor',sysDefArcForeColor.value);
    document.querySelector(':root').style.setProperty('--arcinputcolor',sysDefArcInputColor.value);
    document.querySelector(':root').style.setProperty('--qucolor',(sysDefBackColor.value).slice(0,7)+'00');
    document.querySelector(':root').style.setProperty('--border-radius',sysDefBorderRadius.value);
    document.querySelector(':root').style.setProperty('--text-border-radius',sysDefTextBorderRadius.value);
    document.querySelector(':root').style.setProperty('--box-shadow',sysDefBoxShadow.value);
    document.querySelector(':root').style.setProperty('--text-box-shadow',sysDefTextBoxShadow.value);
    document.querySelector(':root').style.setProperty('--text-shadow',sysDefTextShadow.value);
    document.querySelector(':root').style.setProperty('--blur-filter','blur('+sysDefBlur.value+'px) brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)');
    document.querySelector(':root').style.setProperty('--filter','none');
    $('.power').css('background','linear-gradient('+sysDefGradientButton.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
    document.querySelector(':root').style.setProperty('--gradient-fore','linear-gradient('+sysDefGradientFore.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
    document.querySelector(':root').style.setProperty('--gradient-input','linear-gradient('+sysDefGradientInput.value+'deg, '+sysDefInputColor.value+' 0%, '+sysDefArcInputColor.value+' 100%)');
    if (requestMode.value=='visual_effects') {
        opacityInd.value=sysDefOpacity.value;
        blurInd.value=sysDefBlur.value+'px';
        brightnessInd.value=sysDefBrightness.value+'%';
        saturationInd.value=sysDefSaturation.value+'%';
        contrastInd.value=sysDefContrast.value+'%';
        sepiaInd.value=sysDefSepia.value+'%';
        grayInd.value=sysDefGrayscale.value+'%';
        hueInd.value=sysDefHue.value+'deg';
    }
}
function wallpaper_engine() {
    $.ajax({
        url: 'wallpaper_engine.php',
        success: function(data) {
            $('body').css('background-image','url('+pager(data,1)+')');
            var uidm=sysDefSessionID.value;
            document.querySelector(':root').style.setProperty('--position',sysDefPosition.value);
            var faviconList=document.querySelectorAll('link[rel="icon"], link[rel="shortcut icon"]');
            faviconList.forEach(function(element) {
	            element.setAttribute('href',((isDarkMode())?'ava.':'abc.')+sysDefAvatar.value+'.png');
            }); $('#userAvatarBadge').attr('src',sysDefAva1Prefix.value+sysDefAvatar.value+'.png');
            <?php if (file_exists('mode.'.$request['mode'].'.php')) { ?>
                $('#showUsText').html(pager(data,4));
            <?php } else { ?>
                $('#articleHead').text(pager(data,3).toUpperCase());
                $('#articleBody').html(pager(data,4));
                $('#articleLink').text(pager(data,5));
                $('#articleLink').attr('href',pager(data,5));
                $('#showingAvatarNow').attr('src',pager(data,2));
            <?php } ?> document.title=pager(data,0)+' (@'+uidm+') · Eurohouse UX/UI';
        }
    });
}
</script>
