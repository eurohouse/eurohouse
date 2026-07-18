<script>
window.onload=function() {
    if (window.history.replaceState) {
        window.history.replaceState(null,null,window.location.href);
    } if ((sysDefAutoplay.value==1)&&(sysDefPlaying.value==1)) {
        omniListen(EE2EE.decode(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value));
    } if (requestMode.value=='media_player') {
        replayVideo(video);
    } else if (requestMode.value=='volume_control') {
        audioVolInd.value=superRound(100*sysDefAudioVolume.value)+'%';
        audioRatInd.value=superRound(100*sysDefAudioSpeed.value)+'%';
        videoVolInd.value=superRound(100*sysDefVideoVolume.value)+'%';
        videoRatInd.value=superRound(100*sysDefVideoSpeed.value)+'%';
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
            sysDefAvaPrefix.value=(sysDefPrefData.value).split(',')[1];
            sysDefPrefix.value=(sysDefPrefData.value).split(',')[3];
            $('#sysDefSubscriptions').val(pager(data,1));
            $('#sysDefMyVisitorsData').val(pager(data,2));
        }
    });
}
function repository() {
    $.ajax({
        url: 'repository.php',
        success: function(data) {
            $('#sysDefContentData').val(pager(data,0));
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
            showUsCurrentMusic.innerText=(sysDefCipher.value!=0)?sysDefMelody.value:('"'+EE2EE.decode(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value)+'" <'+hhmmss(sysDefCurrent.value,true)+'/'+hhmmss(sysDefDuration.value,true)+'>');
            if ((pager(data,2)!='00:00')&&(pager(data,2)!='--:--')&&(sysDefMemo.value!='')) {
                playAudio(tickerPlayer,sysDefTickingSound.value);
            } else { pauseAudio(tickerPlayer); }
            if ((pager(data,2)=='--:--')&&(sysDefMemo.value!='')) {
                playAudio(alarmPlayer,sysDefAlarmSound.value);
                setdata('memo','');
            } $('#sysDefEffects').val(pager(data,4));
            $('#sysDefPangram').val(pager(data,5));
            $('#usernameBanner').val(sysDefSessionID.value); if (authstate()) {
                const filteredMessages=filterMessages(sysDefMyMessengerData.value);
		const messageKeys=Object.keys(filteredMessages);
		const messageValues=Object.values(filteredMessages);
		const maxIndex=messageKeys.length>0?messageKeys.length-1:-1;
		sysDefMsgMaxCount.value=maxIndex;
		let currentCounter=parseInt(sysDefMsgCounter.value,10);
		if (!isInt(currentCounter)) { currentCounter=0; }
		if (sysDefReadBackwards.value!=0) {
  		    if (currentCounter<=0) {
    		        sysDefMsgCounter.value=maxIndex;
                    } else {
                        sysDefMsgCounter.value=currentCounter-1;
                    }
                } else {
                    if (currentCounter>=maxIndex) {
                        sysDefMsgCounter.value=0;
                    } else {
                        sysDefMsgCounter.value=currentCounter+1;
                    }
                } if (maxIndex>=0&&sysDefMsgCounter.value>=0&&sysDefMsgCounter.value<=maxIndex) {
  		    sysDefMsgCurrent.value=messageValues[sysDefMsgCounter.value];
		} else {
  		    sysDefMsgCurrent.value="";
		} $('#showUsUrgent').text(sysDefMsgCurrent.value);
            } if (sysDefLoop.value!=sysDefPostBackEff.value) {
                if (sysDefLoop.value!=0) {
                    playAudio(backgroundPlayer,sysDefBackgroundSound.value);
                } else { pauseAudio(backgroundPlayer); }
            } sysDefPostBackEff.value=sysDefLoop.value;
            document.querySelector(':root').style.setProperty('--bicolor',alphaHex(sysDefBackColor.value,sysDefOpacity.value)); $('#powerButton').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonObserve').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonSpectate').attr('src',sysDefPrefix.value+'unpower.png');
	    $('#buttonAdd').attr('src',sysDefPrefix.value+'plus.png');
            $('#buttonRemove').attr('src',sysDefPrefix.value+'min.png');
	    $('#buttonTrash').attr('src',sysDefPrefix.value+'trash.png');
            $('#buttonDelete').attr('src',sysDefPrefix.value+'error.png');
            $('#buttonMenu').attr('src',sysDefPrefix.value+sysDefMenuView.value+'.png');
            $('#buttonUpdate').attr('src',sysDefPrefix.value+'world.png');
            $('#buttonRequestLock').attr('src',sysDefPrefix.value+((requestLock.value!='false')?'lock.png':'key.png'));
            $('#buttonMorseLock').attr('src',sysDefPrefix.value+((sysDefMorse.value!=0)?'key.png':'lock.png'));
            $('#buttonCipherLock').attr('src',sysDefPrefix.value+((sysDefCipher.value!=0)?'key.png':'lock.png'));
            $('#buttonAutoplay').attr('src',sysDefPrefix.value+((sysDefAutoplay.value!=0)?'autopause.png':'autoplay.png'));
            $('#buttonSlideshow').attr('src',sysDefPrefix.value+((sysDefBackground.value!='')?'image.png':((sysDefSlideshow.value!=0)?'speed.png':'time.png')));
            $('#buttonShuffle').attr('src',sysDefPrefix.value+((sysDefShuffle.value!=0)?'shuffle.png':'update.png'));
            $('#buttonPlay').attr('src',sysDefPrefix.value+((audioPlayer.paused!=true)?'pause.png':'play.png'));
            $('#buttonPrev').attr('src',sysDefPrefix.value+'rew.png');
            $('#buttonNext').attr('src',sysDefPrefix.value+'ff.png');
            $('#buttonSearch').attr('src',sysDefPrefix.value+'search.png');
            $('#buttonReplace').attr('src',sysDefPrefix.value+'text.png');
            $('#buttonReplaceAll').attr('src',sysDefPrefix.value+'copy.png');
            $('#buttonNew').attr('src',sysDefPrefix.value+'new.png');
            $('#buttonOpen').attr('src',sysDefPrefix.value+'open.png');
            $('#buttonSave').attr('src',sysDefPrefix.value+'save.png');
            $('#buttonEnter').attr('src',sysDefPrefix.value+'return.png');
            $('#buttonKeyboard').attr('src',sysDefPrefix.value+'keyboard.png');
            $('#buttonBackspace').attr('src',sysDefPrefix.value+'backspace.png');
            $('#buttonEscape').attr('src',sysDefPrefix.value+((sysDefIsModeNull.value!=0)?'forward.png':'escape.png'));
            $('#buttonAuthState').attr('src',sysDefPrefix.value+((authstate())?'user.png':'anonym.png'));
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
            } document.querySelector(':root').style.setProperty('--marquee-animation','scrollMarquee '+sysDefMarquee.value+'s linear infinite');
            document.querySelector(':root').style.setProperty('--mediainfo-animation','scrollMarquee '+sysDefMediainfo.value+'s linear infinite');
            document.querySelector(':root').style.setProperty('--backdrop-filter',jsonarr(sysDefEffects.value)[0]);
            document.querySelector(':root').style.setProperty('--backdrop-opacity',jsonarr(sysDefEffects.value)[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg',jsonarr(sysDefEffects.value)[2]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani',jsonarr(sysDefEffects.value)[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg',jsonarr(sysDefEffects.value)[4]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani',jsonarr(sysDefEffects.value)[5]);
            if (requestMode.value=='messenger') {
                if (authstate()) {
                    msgBox.innerHTML='<p>'+messengerHTML(sysDefMyMessengerData.value)+'</p>';
                }
            } else if (requestMode.value=='date_and_time') {
                hourInd.style.width=(100*((pager(data,3)).split(':')[0]/23))+'%';
                minuteInd.style.width=(100*((pager(data,3)).split(':')[1]/59))+'%';
                secondInd.style.width=(100*((pager(data,3)).split(':')[2]/59))+'%';
            } else if (requestMode.value=='font_book') {
                fontBook24Pt.innerText=fontBook22Pt.innerText=fontBook20Pt.innerText=fontBook18Pt.innerText=fontBook16Pt.innerText=fontBook14Pt.innerText=(testFont.value!='')?testFont.value:sysDefPangram.value;
	    } else if (requestMode.value=='artificial_intelligence') {
		AIInfo.name=(superuser())?'set "../.env" "API_KEY=..."':'endpoint: '+loadFile(sysDefSuperUserName.value+'_files/profile.json','endpoint')+'; model: '+loadFile(sysDefSuperUserName.value+'_files/profile.json','model')+';';
		AIInfo.innerText=(superuser())?'set "../.env" "API_KEY=..."':'endpoint: ...; model: ...;';
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
    document.querySelector(':root').style.setProperty('--gradient-fore','linear-gradient('+sysDefGradientFore.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
    document.querySelector(':root').style.setProperty('--gradient-input','linear-gradient('+sysDefGradientInput.value+'deg, '+sysDefInputColor.value+' 0%, '+sysDefArcInputColor.value+' 100%)');
    $('.power').css('background','linear-gradient('+sysDefGradientButton.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
    document.querySelector(':root').style.setProperty('--blur-filter','blur('+sysDefBlur.value+'px) brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)');
    document.querySelector(':root').style.setProperty('--filter','none');
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
            $('body').css('background-image','url('+pager(data,2)+')');
            document.querySelector(':root').style.setProperty('--position',sysDefPosition.value);
            document.title=pager(data,0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI';
            var faviconList=document.querySelectorAll('link[rel="icon"], link[rel="shortcut icon"]'); faviconList.forEach(function(element) {
	        element.setAttribute('href',pager(data,4));
            }); $('#showUserAvatarBadgeTop').attr('src',pager(data,4)); $('#showUserAvatarBadgeBottom').attr('src',pager(data,4)); $('#showUserTypeBadge').attr('src',sysDefPrefix.value+((sysDefType.value=='entity')?'home.png':'user.png')); var headPageNum=(sysDefFace.value!=0)?0:6;
            var bodyPageNum=(sysDefFace.value!=0)?1:7;
	    var avatarPageNum=(sysDefFace.value!=0)?3:5;
            if (sysDefIsModeNull.value!=0) {
                $('#showArticleHead').text(pager(data,headPageNum).toUpperCase());
                $('#showArticleBody').html(pager(data,bodyPageNum));
		$('#showArticleLink').text(pager(data,8));
		$('#showArticleLink').attr('href',pager(data,8));
                $('#showArticleAvatar').attr('src',pager(data,avatarPageNum));
            } else {
                $('#showUsText').html(pager(data,bodyPageNum));
            }
        }
    });
}
</script>
