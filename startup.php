<script>
window.onload=function() {
    init_user(sysDefSessionID.value,'','',true);
    if (authstate()) { document.getElementById('omniBox').focus();
    } else { document.getElementById('omniBoxAuthLogin').focus(); }
    if (window.history.replaceState) {
        window.history.replaceState(null,null,window.location.href);
    } if ((sysDefAutoplay.value==1)&&(sysDefPlaying.value==1)) {
        omniListen(dtw(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value));
    } if (requestMode.value=='media_player') { replayVideo(video); }
    if (requestMode.value=='text_editor') { countText(); }
}
$(document).ready(function() {
    <?php foreach ($settings['intervals'] as $key=>$val) { ?>
        setInterval(<?=$key;?>,<?=$val;?>);
    <?php } ?>
});
function databox() {
    $.ajax({
        url: 'databox.php',
        success: function(data) {
            $('#sysDefSessionID').val(pager(data,0));
            $('#sysDefBindData').val(pager(data,1));
            $('#sysDefPowersData').val(pager(data,2));
            $('#sysDefAutoData').val(pager(data,3));
            $('#sysDefFriendData').val(pager(data,4));
            $('#sysDefToolData').val(pager(data,5));
            $('#sysDefCallData').val(pager(data,6));
            $('#sysDefLockData').val(pager(data,7));
            $('#sysDefCodexBox').val(pager(data,8).split("\\\\")[0]);
            $('#sysDefSpeechBox').val(pager(data,8).split("\\\\")[1]);
            $('#sysDefUsersList').val(pager(data,9));
            $('#sysDefHoursNow').val(pager(data,10));
            $('#sysDefHoursActive').val(pager(data,11));
            $('#sysDefAvatarsNow').val(pager(data,12));
            $('#sysDefMetaData').val(pager(data,13));
            $('#sysDefTutorData').val(pager(data,14));
            $('#sysDefNewsData').val(pager(data,15));
            $('#sysDefIpData').val(pager(data,16));
            $('#sysDefHdiData').val(pager(data,17));
            $('#sysDefModelData').val(pager(data,18));
            $('#sysDefMetaList').val(Object.keys(jsonarr(sysDefMetaData.value)).join(' | ')); $('#sysDefTutorList').val(Object.keys(jsonarr(sysDefTutorData.value)).join(' | '));
            if (sysDefBindData.value!=sysDefPostBindData.value) { playAudio(bindPlayer,sysDefBindSound.value); } sysDefPostBindData.value=sysDefBindData.value;
            if (sysDefPowersData.value!=sysDefPostPowersData.value) { playAudio(sufferPlayer,sysDefSufferSound.value); } sysDefPostPowersData.value=sysDefPowersData.value;
            if (sysDefToolData.value!=sysDefPostToolData.value) { playAudio(bindPlayer,sysDefBindSound.value); } sysDefPostToolData.value=sysDefToolData.value;
            if (sysDefMyMsgboxData.value!=sysDefPostMyMsgboxData.value) {
                playAudio(notifyPlayer,sysDefNotifySound.value);
            } sysDefPostMyMsgboxData.value=sysDefMyMsgboxData.value;
        }
    });
}
function world_clock() {
    $.ajax({
        url: 'world_clock.php',
        success: function(data) {
            $('#currentTime').val(pager(data,0)); var enzi=pager(data,1).split(' ');
            $('#alarmTime').val((enzi[0]!='00:00')?enzi[0]:hhMmSs(audioPlayer.currentTime,true));
            var effi=pager(data,2).split(';'); var mixers=pager(data,3).split(' ');
            var bndm=arrjob(sysDefBindData.value,';',':')[sysDefSessionID.value];
            var fint=pager(data,4).split(' | '); $('#sysDefLockIcons').val(pager(data,6));
            $('#sysDefDotDirs').val(pager(data,7));
            if (authstate()) { omniBox.placeholder=fint[10]; }
            if (requestMode.value=='volume_control') {
                audioVolInd.value=mixers[0]; audioRatInd.value=mixers[1];
                videoVolInd.value=mixers[2]; videoRatInd.value=mixers[3];
                alarmVolInd.value=mixers[4]; timerVolInd.value=mixers[5];
                loopVolInd.value=mixers[6]; restVolInd.value=mixers[7];
            } document.querySelector(':root').style.setProperty('--bicolor',enzi[2]);
            sysDefMsgMaxCount.value=parseInt(Object.keys(jsonFilter(sysDefMyMsgboxData.value,sysDefFind.value)).length-1); sysDefMsgCounter.value=(sysDefReverse.value!=0)?((parseInt(sysDefMsgCounter.value)<=0)?sysDefMsgMaxCount.value:(parseInt(sysDefMsgCounter.value)-1)):((parseInt(sysDefMsgCounter.value)>=sysDefMsgMaxCount.value)?0:(parseInt(sysDefMsgCounter.value)+1));
            $('#showUsUrgent').text(Object.values(jsonFilter(sysDefMyMsgboxData.value,sysDefFind.value,'msg'))[sysDefMsgCounter.value]); if (sysDefLoop.value!=sysDefPostBackEff.value) {
                if (sysDefLoop.value!=0) { playAudio(backgroundPlayer,sysDefBackgroundSound.value); } else { pauseAudio(backgroundPlayer); }
            } sysDefPostBackEff.value=sysDefLoop.value;
            if (requestMode.value=='messenger') { msgBox.innerHTML='<p>'+jsonHTML(sysDefMyMsgboxData.value,sysDefFind.value)+'</p>'; } if (requestMode.value=='news_feed') { newsBox.innerHTML='<p>'+jsonNews()+'</p>'; } $('#powerButton').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonPrev').attr('src',sysDefPrefix.value+'rew.png');
            $('#buttonNext').attr('src',sysDefPrefix.value+'ff.png');
            $('#buttonLock').attr('src',sysDefPrefix.value+((sysDefLock.value != 0)?'key.png':'lock.png'));
            $('#buttonOnReload').attr('src',sysDefPrefix.value+((sysDefReload.value!=0)?'bluetooth.png':'radio.png')); $('#buttonSongIndex').attr('src',sysDefPrefix.value+((sysDefSongIndex.value=='random')?'shuffle.png':'update.png')); $('#buttonPitched').attr('src',sysDefPrefix.value+((sysDefPitchLock.value != 0)?'midi.png':'volume.png'));
            $('#buttonObserve').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonSpectate').attr('src',sysDefPrefix.value+'camera.png');
            $('#buttonEnter').attr('src',sysDefPrefix.value+'return.png');
            $('#buttonSuggest').attr('src',sysDefPrefix.value+'user.png');
            $('#buttonCommand').attr('src',sysDefPrefix.value+sysDefMode.value+'.png');
            $('#buttonChat').attr('src',sysDefPrefix.value+'mail.png');
            $('#buttonSearch').attr('src',sysDefPrefix.value+'directory.png');
            $('#buttonKeyboard').attr('src',sysDefPrefix.value+'keyboard.png');
            $('#buttonBackspace').attr('src',sysDefPrefix.value+'backspace.png');
            $('#buttonLogin').attr('src',sysDefPrefix.value+'return.png');
            $('#buttonRegister').attr('src',sysDefPrefix.value+'keyboard.png');
            $('#buttonCancelSignin').attr('src',sysDefPrefix.value+'backspace.png');
            $('#buttonTime').attr('src',sysDefPrefix.value+((sysDefTimedisp.value!=0)?((sysDefBenchmark.value!=0)?'note.png':'calendar.png'):((sysDefBenchmark.value!=0)?'speed.png':'time.png')));
            $('#buttonAutoplay').attr('src',sysDefPrefix.value+((sysDefAutoplay.value!=0)?'autopause.png':'autoplay.png'));
            $('#buttonRandom').attr('src',sysDefPrefix.value+'dice.png');
            $('#buttonVintage').attr('src',sysDefPrefix.value+'diamante.png');
            $('#buttonGloss').attr('src',sysDefPrefix.value+((sysDefGloss.value!=0)?'parfum.png':'deparfum.png'));
            $('#buttonPlay').attr('src',sysDefPrefix.value+((audioPlayer.paused!=true)?'pause.png':'play.png'));
            $('#buttonAlarm').attr('src',sysDefPrefix.value+((alarmPlayer.paused!=true)?'dial.png':'call.png'));
            $('#buttonMute').attr('src',sysDefPrefix.value+((sysDefMute.value!=0)?'audio.png':'music.png'));
            $('#buttonMuteBack').attr('src',sysDefPrefix.value+'disk.png');
            $('#buttonReqLock').attr('src',sysDefPrefix.value+((requestLock.value!='true')?'expand.png':'collapse.png'));
            $('#buttonMaximize').attr('src',sysDefPrefix.value+((sysDefApps.value!=0)?'restore.png':'maximize.png'));
            $('#buttonMenuStyle').attr('src',sysDefPrefix.value+((sysDefIcons.value!=0)?'menu.png':'list.png')); $('#buttonUpdate').attr('src',sysDefPrefix.value+'world.png');
            $('#buttonUserStatus').attr('src',sysDefPrefix.value+"<?=(isAuthorized())?'logout.png':'login.png';?>"); $('#buttonEscape').attr('src',sysDefPrefix.value+'escape.png');
            if (requestMode.value=='bookkeeping') {
                bookkeep_disp.innerHTML='<table style="width:100%;position:relative;"><thead><th style="width:25%;">'+fint[8]+'</th><th style="width:25%;">'+fint[0]+'</th><th style="width:25%;">'+fint[1]+'</th><th style="width:25%;">'+fint[2]+'</th></thead><tbody>'+jsonBookKeep(sysDefMyBookData.value)+'</tbody></table>';
            } else if (requestMode.value=='accessibility') {
                pressedKeyInfo.innerText=fint[9];
            } else if (requestMode.value=='album_collection') {
                album_mode_switch.innerHTML=showLockInd(),epr='',alr=[];
                var upn=decipher(sysDefPlaylist.value,sysDefSessionID.value,sysDefNumeric.value,'arr'),arl="",plCol=sysDefPlaylistColumns.value; for (iu in upn) {
                    arl+="<a href='javascript:omniListen(%22"+rfc3986(upn[iu])+"%22,true);'>"+(parseInt(iu)+1)+'. '+upn[iu]+"</a><br>";
                } currentPlaylist.innerHTML=arl;
                currentPlaylist.setAttribute('style','-webkit-columns:'+plCol+';-moz-columns:'+plCol+';columns:'+plCol+';');
                var alb=lockarr(sysDefAlbum.value),arl="";
                var albCol=((sysDefAlbum.value=='avatar')||(sysDefAlbum.value=='pictogram'))?1:sysDefAlbumColumns.value; if (sysDefAlbum.value=='music') {
                    for (iu in alb) {
                        elid=CryptoJS.SHA256(alb[iu]).toString();
                        arl+="<a id='albumEl"+elid+"' href='javascript:setdata(%22playlist%22,playlistNext(%22"+rfc3986(alb[iu])+"%22));'>"+(parseInt(iu)+1)+'. '+alb[iu]+"</a><br>";
                    }
                } else if (sysDefAlbum.value=='sound') {
                    for (iu in alb) {
                        arl+="<a href='javascript:omniListen(%22"+rfc3986(alb[iu])+"%22,true);'>"+alb[iu]+"</a><br>";
                    }
                } else if (sysDefAlbum.value=='font') {
                    for (iu in alb) {
                        arl+="<a href='javascript:omniRead(%22font_book%22,%22"+rfc3986(alb[iu])+"%22,%22"+requestLock.value+"%22);'>"+alb[iu]+"</a><br>";
                    }
                } else if (sysDefAlbum.value=='background') {
                    for (iu in alb) {
                        arl+=ucfirst(alb[iu].split('.')[0])+"<br>";
                    }
                } else if (sysDefAlbum.value=='avatar') {
                    epr=sysDefAvaPrefix.value,alr=listlock(sysDefAlbum.value);
                    for (iu in alr) {
                        arl+="<input type='image' class='power' style='width:40px;height:40px;' src='"+epr+alr[iu]+".png' title='"+alr[iu]+"' onclick='setdata(&#34;avatar&#34;,&#34;"+alr[iu]+"&#34;);'>";
                    }
                } else if (sysDefAlbum.value=='pictogram') {
                    epr=sysDefPrefix.value,alr=listlock(sysDefAlbum.value);
                    for (iu in alr) {
                        arl+="<input type='image' class='power' style='width:40px;height:40px;' src='"+epr+alr[iu]+".png' title='"+(alr[iu].toUpperCase())+"'>";
                    }
                } currentAlbumList.innerHTML=arl;
                currentAlbumList.setAttribute('style','-webkit-columns:'+albCol+';-moz-columns:'+albCol+';columns:'+albCol+';');
            } else if (requestMode.value=='point_of_sale') {
                var stoInf="<p align='center'>"+fint[6]+"</p><p align='center'>"+fint[7]+"</p><p align='center'>"+activeHrsBtn(bndm)+"</p>";
                var stoDop='<table style="width:100%;position:relative;"><thead><th style="width:5%;">'+fint[3]+'</th><th style="width:7%;">'+fint[4]+'</th><th style="width:3%;">'+fint[5]+'</th></thead><tbody>'+jsonStore(bndm)+'</tbody></table>';
                store_disp.innerHTML=(sysDefSessionID.value!=bndm)?((storeOpen(bndm))?stoDop:stoInf):stoDop;
            } else if (requestMode.value=='font_book') {
                fontBook24Pt.innerText=fontBook22Pt.innerText=fontBook20Pt.innerText=fontBook18Pt.innerText=fontBook16Pt.innerText=fontBook14Pt.innerText=pager(data,5);
            } else if (requestMode.value=='statistics') {
                $('#switchBtnAuto').attr('src',sysDefPrefix.value+'steer.png');
                $('#switchBtnCall').attr('src',sysDefPrefix.value+'dial.png');
                $('#switchBtnFrnd').attr('src',sysDefPrefix.value+'user.png');
                $('#switchBtnBind').attr('src',sysDefPrefix.value+'chain.png');
                $('#switchBtnTool').attr('src',sysDefPrefix.value+'pick.png');
                $('#switchBtnScore').attr('src',sysDefPrefix.value+'money.png');
                $('#switchBtnHDI').attr('src',sysDefPrefix.value+'heart.png');
                $('#switchBtnModel').attr('src',sysDefPrefix.value+'parfum.png');
                $('#switchBtnIP').attr('src',sysDefPrefix.value+'world.png');
            } else if (requestMode.value=='preferences') {
                $('#prefsBtnApply').attr('src',sysDefPrefix.value+'return.png');
                $('#prefsBtnUpdate').attr('src',sysDefPrefix.value+'lock.png');
                $('#prefsBtnReset').attr('src',sysDefPrefix.value+'backspace.png');
                $('#prefsBtnReload').attr('src',sysDefPrefix.value+'update.png');
                $('#prefsBtnClear').attr('src',sysDefPrefix.value+'error.png');
                $('#prefsBtnApplySizes').attr('src',sysDefPrefix.value+'ruler.png');
                $('#prefsBtnApplyColors').attr('src',sysDefPrefix.value+'paint.png');
            } else if (requestMode.value=='personalization') {
                $('#prefsBtnApply').attr('src',sysDefPrefix.value+'return.png');
                $('#prefsBtnUpdate').attr('src',sysDefPrefix.value+'lock.png');
                $('#prefsBtnReset').attr('src',sysDefPrefix.value+'backspace.png');
                $('#prefsBtnReload').attr('src',sysDefPrefix.value+'update.png');
                $('#prefsBtnClear').attr('src',sysDefPrefix.value+'error.png');
                $('#prefsBtnUpdateTitle').attr('src',sysDefPrefix.value+'keyboard.png');
                $('#prefsBtnUpdateTitles').attr('src',sysDefPrefix.value+'movie.png');
            } else if (requestMode.value=='sticky_notes') {
                $('#myNotesApplyBtn').attr('src',sysDefPrefix.value+'return.png');
                $('#myNotesKbdBtn').attr('src',sysDefPrefix.value+'keyboard.png');
                $('#myNotesResetBtn').attr('src',sysDefPrefix.value+'backspace.png');
                $('#myNotesNewBtn').attr('src',sysDefPrefix.value+'new.png');
                $('#myNotesOpenBtn').attr('src',sysDefPrefix.value+'open.png');
                $('#myNotesSaveBtn').attr('src',sysDefPrefix.value+'save.png');
                notesMenu.innerHTML='<p align="center" class="block">'+noteBook(sysDefMetaList.value)+'</p>';
            } else if (requestMode.value=='user_tutorial') {
                helpMenu.innerHTML='<p align="center" class="block">'+helpBook()+'</p>';
            } else if (requestMode.value=='text_editor') {
                $('#textEdRep').attr('src',sysDefPrefix.value+'new.png');
                $('#textEdRepAll').attr('src',sysDefPrefix.value+'copy.png');
            } if (((enzi[1].split('')[2]==1)&&(enzi[1].split('')[3]==1))||((enzi[1].split('')[2]==1)&&(enzi[1].split('')[3]==0))) {
                $('#powerButton').show();$('.panel').hide();
                $('.customPanel').hide();$('.upperGap').hide();
                $('.lowerGap').hide();$('.topbar').hide();
            } else {
                if ((enzi[1].split('')[2]==0)&&(enzi[1].split('')[3]==1)) {
                    $('#powerButton').hide();$('.panel').hide();
                    $('.customPanel').hide();$('.upperGap').hide();
                    $('.lowerGap').hide();$('.topbar').show();
                } else {
                    $('#powerButton').hide();$('.panel').show();
                    $('.customPanel').show();$('.upperGap').show();
                    $('.lowerGap').show();$('.topbar').show();
                }
            } document.querySelector(':root').style.setProperty('--backdrop-filter',effi[0]);
            document.querySelector(':root').style.setProperty('--backdrop-opacity',effi[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg',effi[2]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani',effi[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg',effi[4]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani',effi[5]);
            var calls=arrjob(sysDefCallData.value,';',':');
            if (enzi[1].split('')[1]!=0) {
                playAudio(tickerPlayer,sysDefTickingSound.value);
            } else { pauseAudio(tickerPlayer); }
            if (enzi[1].split('')[0]!=0) {
                playAudio(alarmPlayer,sysDefAlarmSound.value);
                setdata('memo','');
            } if (calls[sysDefSessionID.value]!=sysDefSessionID.value) {
                playAudio(alarmPlayer,sysDefAlarmSound.value);
                calls[sysDefSessionID.value]=sysDefSessionID.value;
                set('calling.json',JSON.stringify(calls),true);
                sysDefCallData.value=arrpack(calls,';',':');
            }
        },
    });
}
function visual_effects() {
    document.querySelector(':root').style.setProperty('--graddeg',sysDefGradient.value+'deg');
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
    document.querySelector(':root').style.setProperty('--radius',sysDefRadius.value+'px');
    document.querySelector(':root').style.setProperty('--box-shadow',sysDefBoxShadow.value);
    document.querySelector(':root').style.setProperty('--text-box-shadow',sysDefTextBoxShadow.value);
    document.querySelector(':root').style.setProperty('--text-shadow',sysDefTextShadow.value);
    document.querySelector(':root').style.setProperty('--blur-filter','blur('+sysDefBlur.value+'px) brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)');
    document.querySelector(':root').style.setProperty('--filter','brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)');
    if (sysDefGloss.value==1) {
        $('.power').css('background','linear-gradient('+sysDefGradient.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-fore','linear-gradient(180deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-input','linear-gradient(180deg, '+sysDefInputColor.value+' 0%, '+sysDefArcInputColor.value+' 100%)');
    } else {
        $('.power').css('background','linear-gradient('+sysDefGradient.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-fore','linear-gradient(180deg, '+sysDefForeColor.value+' 0%, '+sysDefForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-input','linear-gradient(180deg, '+sysDefInputColor.value+' 0%, '+sysDefInputColor.value+' 100%)');
    } if (requestMode.value=='visual_effects') {
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
            sysDefPrefix.value=pager(data,6).split(';')[0];
            sysDefReticlePrefix.value=pager(data,6).split(';')[1];
            sysDefAvaPrefix.value=pager(data,6).split(';')[2];
            $('#buttonChild').attr('src',sysDefPrefix.value+((pager(data,5).split(':')[0]!=0)?'briefcase.png':'cabinet.png'));
            $('#sysDefVarsArr').val(pager(data,5).split(':')[1]);
            $('body').css('background-image','url('+((pager(data, 12)!='')?pager(data,12):pager(data,1))+')');
            $('#buttonAugment').attr('src',sysDefPrefix.value+(((sysDefVarsArr.value.split(';').length)>1)?((sysDefEntry.value!='')?'diamond.png':'heart.png'):((sysDefEntry.value!='')?'club.png':'spade.png')));
            document.title=pager(data,0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI';
            document.querySelector(':root').style.setProperty('--position',pager(data,4));
            $('#userAvatarBadge').attr('src',pager(data, 9));
            $('#buttonReticle').attr('src',sysDefReticlePrefix.value+sysDefReticle.value+'.png');
            $('#buttonDice').attr('src',sysDefPrefix.value+'dice.png');
            $('#chooseReticle1').attr('name',sysDefReticleChoice1.value);
            $('#chooseReticle2').attr('name',sysDefReticleChoice2.value);
            $('#chooseReticle3').attr('name',sysDefReticleChoice3.value);
            $('#chooseReticle4').attr('name',sysDefReticleChoice4.value);
            $('#chooseReticle5').attr('name',sysDefReticleChoice5.value);
            $('#chooseReticle1').attr('src',sysDefReticlePrefix.value+sysDefReticleChoice1.value+'.png');
            $('#chooseReticle2').attr('src',sysDefReticlePrefix.value+sysDefReticleChoice2.value+'.png');
            $('#chooseReticle3').attr('src',sysDefReticlePrefix.value+sysDefReticleChoice3.value+'.png');
            $('#chooseReticle4').attr('src',sysDefReticlePrefix.value+sysDefReticleChoice4.value+'.png');
            $('#chooseReticle5').attr('src',sysDefReticlePrefix.value+sysDefReticleChoice5.value+'.png');
            arrangePlay(); <?php if (file_exists('mode.'.$request['mode'].'.php')) {
                if ($request['mode']=='main_menu') { ?>
                    $('#projectTitle').text(pager(data,0).toUpperCase());
                    $('#showingAvatarNow').attr('src',pager(data,10));
                <?php } ?>
            $('#showUsText').text(pager(data,8));
            <?php } else { ?>
                $('#articleHead').text(pager(data,7).toUpperCase());
                $('#articleBody').text(pager(data,8));
                $('#articleLink').text(pager(data,11));
                $('#articleLink').attr('href',pager(data,11));
                $('#showingAvatarNow').attr('src',pager(data,3));
            <?php } ?>
        },
    });
}
function dot_dirs_data() {
    $.ajax({
        url: 'dot_dirs_data.php',
        success: function(data) {
            var dotdirs=(sysDefDotDirs.value).split(',')
            for (const [i,val] of dotdirs.entries()) {
                document.getElementById('sysDef'+ucfirst(val)+'JSONs').value=pager(data,i);
                document.getElementById('sysDefMy'+ucfirst(val)+'Data').value=openJournal(sysDefSessionID.value,(document.getElementById('sysDef'+ucfirst(val)+'JSONs')));
            }
        }
    });
}
function automator() {
    var autoPower=arrjob(sysDefAutoData.value,';',':');
    var bindPower=arrjob(sysDefBindData.value,';',':');
    var callPower=arrjob(sysDefBindData.value,';',':');
    var tabPower=arrjob(sysDefPowersData.value,';',':');
    var frndPower=arrjob(sysDefFriendData.value,';',':');
    var toolPower=arrjob(sysDefToolData.value,';',':');
    var userList=(sysDefUsersList.value).split(',');
    var subName=userList[rand(0,userList.length)];
    var objName=userList[rand(0,userList.length)];
    var subFrnd=friendsOf(frndPower,subName);
    var subMarket=objMarket={},subSelect=objSelect='';
    var subMarketCount=objMarketCount=0;
    if (requestMode.value=='statistics') {
        userStats.innerHTML=scores(sysDefStats.value);
    } if ((subName!='')&&(objName!='')&&(isInt(tabPower[subName]))&&(tabPower[subName]>=0)&&(autoPower[subName]=='auto')) {
        subMarket=jsonarr(openJournal(subName,sysDefStoreJSONs));
        subMarketCount=Object.keys(subMarket).length;
        subSelect=(subMarketCount<=0)?'':((subMarketCount==1)?Object.keys(subMarket)[0]:Object.keys(subMarket)[rand(0,subMarketCount)]);
        bind(subName,objName);equip(subName,subSelect);
        objMarket=jsonarr(openJournal(objName,sysDefStoreJSONs));
        objMarketCount=Object.keys(objMarket).length;
        objSelect=(objMarketCount<=0)?'':((objMarketCount==1)?Object.keys(objMarket)[0]:Object.keys(objMarket)[rand(0,objMarketCount)]);
        if ((subName!=objName)&&(objMarketCount>0)&&(objMarket[objSelect]['type']!==undefined)&&(objMarket[objSelect]['password']===undefined)&&(storeOpen(objName))) {
            buy_item(subName,objSelect,objName);
            console.log('@'+subName+' '+objSelect+'$ @'+objName);
        } if ((subName!=objName)&&(subMarketCount>0)&&(subMarket[subSelect]['type']!==undefined)&&(subMarket[subSelect]['type']=='weapon')&&(!(subFrnd.includes(objName)))) {
            dominate(subName,objName,subSelect);
            console.log('@'+subName+' -'+subSelect+' @'+objName);
        } if ((subName==objName)&&(subMarketCount>0)&&(subMarket[subSelect]['type']!==undefined)&&(subMarket[subSelect]['type']!='weapon')&&(subMarket[subSelect]['force']!==undefined)&&(isInt(subMarket[subSelect]['force']))) {
            charge(subName,subSelect);
            console.log('@'+subName+' +'+subSelect);
        }
    }
}
</script>
