<script>
window.onload=function() {
    if (authstate()) { document.getElementById('omniBox').focus();
    } else { document.getElementById('omniBoxAuthLogin').focus(); }
    if (window.history.replaceState) {
        window.history.replaceState(null,null,window.location.href);
    } if ((sysDefAutoplay.value==1)&&(sysDefPlaying.value==1)) {
        omniListen(demorse(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value));
    } if (requestMode.value=='media_player') { replayVideo(video);
    } else if (requestMode.value=='text_editor') { countText();
    } else if (requestMode.value=='sticky_notes') { countNote();
    } else if (requestMode.value=='markdown_viewer') { markdownToHTMLParse(); }
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
            $('#sysDefPrefData').val(pager(data,1));
            $('#sysDefBindData').val(pager(data,2));
            $('#sysDefPowersData').val(pager(data,3));
            $('#sysDefAutoData').val(pager(data,4));
            $('#sysDefToolData').val(pager(data,5));
            $('#sysDefLockData').val(pager(data,6));
            $('#sysDefCodexBox').val(pager(data,7));
            $('#sysDefSpeechBox').val(pager(data,8));
            $('#sysDefUsersList').val(pager(data,9));
            $('#sysDefPublicUserData').val(pager(data,10));
            $('#sysDefMetaData').val(pager(data,11));
            $('#sysDefHdiData').val(pager(data,12));
            $('#sysDefNSFWModelData').val(pager(data,13));
            $('#sysDefNSFWContentData').val(pager(data,14));
            $('#sysDefSafeModelData').val(pager(data,15));
            $('#sysDefSafeContentData').val(pager(data,16));
            $('#sysDefModelData').val(arrjson({...jsonarr(sysDefNSFWModelData.value), ...jsonarr(sysDefSafeModelData.value)}));
            $('#sysDefContentData').val(arrjson({...jsonarr(sysDefNSFWContentData.value), ...jsonarr(sysDefSafeContentData.value)}));
            $('#sysDefMetaList').val(Object.keys(jsonarr(sysDefMetaData.value)).join(' | ')); var powersData=strarr(sysDefPowersData.value,';',':');
            sysDefMyPowersState.value=powersData[sysDefSessionID.value];
            var bindData=strarr(sysDefBindData.value,';',':');
            sysDefMyBindState.value=bindData[sysDefSessionID.value];
            var autoData=strarr(sysDefAutoData.value,';',':');
            sysDefMyAutoState.value=autoData[sysDefSessionID.value];
            var toolData=strarr(sysDefToolData.value,';',':');
            sysDefMyToolState.value=toolData[sysDefSessionID.value];
            sysDefPrefix.value=(sysDefPrefData.value).split(',')[3]; sysDefAva0Prefix.value=(sysDefPrefData.value).split(',')[0]; sysDefAva1Prefix.value=(sysDefPrefData.value).split(',')[1]; sysDefPic0Prefix.value=(sysDefPrefData.value).split(',')[2]; sysDefPic1Prefix.value=(sysDefPrefData.value).split(',')[3]; sysDefRet0Prefix.value=(sysDefPrefData.value).split(',')[4]; sysDefRet1Prefix.value=(sysDefPrefData.value).split(',')[5];
            if (sysDefBindData.value!=sysDefPostBindData.value) { playAudio(bindPlayer,sysDefBindSound.value); } sysDefPostBindData.value=sysDefBindData.value;
            if (sysDefPowersData.value!=sysDefPostPowersData.value) { playAudio(sufferPlayer,sysDefSufferSound.value); } sysDefPostPowersData.value=sysDefPowersData.value;
            if (sysDefToolData.value!=sysDefPostToolData.value) { playAudio(bindPlayer,sysDefBindSound.value); } sysDefPostToolData.value=sysDefToolData.value;
            if (sysDefMyMsgboxData.value!=sysDefPostMyMsgboxData.value) {
                playAudio(notifyPlayer,sysDefNotifySound.value);
            } sysDefPostMyMsgboxData.value=sysDefMyMsgboxData.value;
        }
    });
}
function dataload() {
    $.ajax({
        url: 'dataload.php',
        success: function(data) {
            var bank=(sysDefDataLoad.value).split(',');
            for (const [i,val] of bank.entries()) {
                document.getElementById('sysDef'+ucfirst(val)+'JSONs').value=pager(data,i);
                document.getElementById('sysDefMy'+ucfirst(val)+'Data').value=openJournal(sysDefSessionID.value,(document.getElementById('sysDef'+ucfirst(val)+'JSONs')));
            }
        }
    });
}
function world_clock() {
    $.ajax({
        url: 'world_clock.php',
        success: function(data) {
            $('#currentTime').val(pager(data,sysDefTimedisp.value));
            $('#alarmTime').val((pager(data,2)!='00:00')?pager(data,2):hhmmss(audioPlayer.currentTime,true));
            document.getElementById('favicon').href=((isDarkMode())?'ava.':'abc.')+sysDefAvatar.value+'.png';
            $('#sysDefAccent').val(pager(data,3));
            $('#sysDefEffects').val(pager(data,4));
            $('#sysDefMixers').val(pager(data,5));
            $('#sysDefFinTerms').val(pager(data,6));
            $('#sysDefPangram').val(pager(data,7));
            var effects=jsonarr(sysDefEffects.value);
            var mixers=jsonarr(sysDefMixers.value);
            var uidm=sysDefSessionID.value;
            var bndm=strarr(sysDefBindData.value,';',':')[uidm];
            $('#sysDefLockIcons').val(pager(data,8));
            $('#sysDefDataLoad').val(pager(data,9));
            if (requestMode.value=='volume_control') {
                audioVolInd.value=mixers[0]; audioRatInd.value=mixers[1]; videoVolInd.value=mixers[2]; videoRatInd.value=mixers[3];
            } document.querySelector(':root').style.setProperty('--bicolor',sysDefAccent.value);
            if (authstate()) {
                sysDefMsgMaxCount.value=parseInt(Object.keys(filterMessages(sysDefMyMsgboxData.value,uidm,sysDefFind.value)).length-1); sysDefMsgCounter.value=(sysDefReverse.value!=0)?((parseInt(sysDefMsgCounter.value)<=0)?sysDefMsgMaxCount.value:(parseInt(sysDefMsgCounter.value)-1)):((parseInt(sysDefMsgCounter.value)>=sysDefMsgMaxCount.value)?0:(parseInt(sysDefMsgCounter.value)+1));
                sysDefMsgCurrent.value=(sysDefCypher.value!='')?enmorse(Object.values(filterMessages(sysDefMyMsgboxData.value,uidm,sysDefFind.value,'msg'))[sysDefMsgCounter.value],uidm,sysDefCypher.value):Object.values(filterMessages(sysDefMyMsgboxData.value,uidm,sysDefFind.value,'msg'))[sysDefMsgCounter.value];
                $('#showUsUrgent').text(sysDefMsgCurrent.value);
            } if (sysDefLoop.value!=sysDefPostBackEff.value) {
                if (sysDefLoop.value!=0) {
                    playAudio(backgroundPlayer,sysDefBackgroundSound.value);
                } else { pauseAudio(backgroundPlayer); }
            } sysDefPostBackEff.value=sysDefLoop.value;
            $('#powerButton').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonPrev').attr('src',sysDefPrefix.value+'rew.png');
            $('#buttonNext').attr('src',sysDefPrefix.value+'ff.png');
            $('#buttonLock').attr('src',sysDefPrefix.value+((sysDefLock.value!=0)?'key.png':'lock.png')); $('#buttonLockRequest').attr('src',sysDefPrefix.value+((requestLock.value!='false')?'restore.png':'maximize.png'));
            $('#buttonOnReload').attr('src',sysDefPrefix.value+((sysDefReload.value!=0)?'bluetooth.png':'radio.png')); $('#buttonSongIndex').attr('src',sysDefPrefix.value+((sysDefSongIndex.value=='random')?'shuffle.png':'update.png')); $('#buttonPitched').attr('src',sysDefPrefix.value+((sysDefPitchLock.value!=0)?'midi.png':'volume.png'));
            $('#buttonObserve').attr('src',sysDefPrefix.value+'power.png');
            $('#buttonSpectate').attr('src',sysDefPrefix.value+'unpower.png');
            $('#buttonEnter').attr('src',sysDefPrefix.value+'return.png');
            $('#buttonSuggest').attr('src',sysDefPrefix.value+'user.png');
            $('#buttonKeyboard').attr('src',sysDefPrefix.value+'keyboard.png');
            $('#buttonBackspace').attr('src',sysDefPrefix.value+'backspace.png');
            $('#buttonRegister').attr('src',sysDefPrefix.value+'book.png');
            $('#buttonTime').attr('src',sysDefPrefix.value+((sysDefTimedisp.value!=0)?((sysDefBenchmark.value!=0)?'note.png':'calendar.png'):((sysDefBenchmark.value!=0)?'speed.png':'time.png')));
            $('#buttonAutoplay').attr('src',sysDefPrefix.value+((sysDefAutoplay.value!=0)?'autopause.png':'autoplay.png'));
            $('#buttonRandomMusic').attr('src',sysDefPrefix.value+'music.png');
            $('#buttonRandomBanner').attr('src',sysDefPrefix.value+((sysDefBanner.value!='')?'paint.png':'image.png'));
            $('#buttonVintage').attr('src',sysDefPrefix.value+'diamante.png');
            $('#buttonCommand').attr('src',sysDefPrefix.value+'start.png');
            $('#buttonGloss').attr('src',sysDefPrefix.value+((sysDefGloss.value!=0)?'parfum.png':'deparfum.png'));
            $('#buttonPlay').attr('src',sysDefPrefix.value+((audioPlayer.paused!=true)?'pause.png':'play.png'));
            $('#buttonMuteBack').attr('src',sysDefPrefix.value+'disk.png');
            $('#buttonMenuStyle').attr('src',sysDefPrefix.value+((sysDefIcons.value!=0)?'menu.png':'list.png')); $('#buttonUpdate').attr('src',sysDefPrefix.value+'world.png');
            $('#buttonUserStatus').attr('src',sysDefPrefix.value+((authstate())?'escape.png':'forward.png'));
            $('#buttonEscape').attr('src',sysDefPrefix.value+'escape.png');
            if (((sysDefObserve.value!=0)&&(sysDefSpectate.value!=0))||((sysDefObserve.value!=0)&&(sysDefSpectate.value==0))) {
                $('#powerButton').show();$('.panel').hide();
                $('.customPanel').hide();$('.upperGap').hide();
                $('.lowerGap').hide();$('.topbar').hide();
            } else {
                if ((sysDefObserve.value==0)&&(sysDefSpectate.value!=0)) {
                    $('#powerButton').hide();$('.panel').hide();
                    $('.customPanel').hide();$('.upperGap').hide();
                    $('.lowerGap').hide();$('.topbar').show();
                } else {
                    $('#powerButton').hide();$('.panel').show();
                    $('.customPanel').show();$('.upperGap').show();
                    $('.lowerGap').show();$('.topbar').show();
                }
            } document.querySelector(':root').style.setProperty('--backdrop-filter',effects[0]);
            document.querySelector(':root').style.setProperty('--backdrop-opacity',effects[1]);
            document.querySelector(':root').style.setProperty('--overlay-before-bg',effects[2]);
            document.querySelector(':root').style.setProperty('--overlay-before-ani',effects[3]);
            document.querySelector(':root').style.setProperty('--overlay-after-bg',effects[4]);
            document.querySelector(':root').style.setProperty('--overlay-after-ani',effects[5]);
            if ((pager(data,2)!='00:00')&&(pager(data,2)!='--:--')&&(sysDefMemo.value!='')) {
                playAudio(tickerPlayer,sysDefTickingSound.value);
            } else { pauseAudio(tickerPlayer); }
            if ((pager(data,2)=='--:--')&&(sysDefMemo.value!='')) {
                playAudio(alarmPlayer,sysDefAlarmSound.value);
                setdata('memo','');
            } var uidm=sysDefSessionID.value,bndm=strarr(sysDefBindData.value,';',':')[uidm];
            if (authstate()) {
                omniBox.placeholder=finterm('Type command or expression and press ENTER');
            } else {
                omniBoxAuthLogin.placeholder=finterm('Username');
                omniBoxAuthPass.placeholder=finterm('Password');
            } if (requestMode.value=='messenger') {
                if (authstate()) {
                    msgBox.innerHTML='<p>'+messengerHTML(sysDefMyMsgboxData.value,uidm,sysDefFind.value)+'</p>'; composeMessage.placeholder=finterm("What's on your mind?");
                }
            } else if (requestMode.value=='bookkeeping') {
                bookkeep_disp.innerHTML='<table style="width:100%;position:relative;"><thead><th style="width:25%;">'+finterm('Agent')+'</th><th style="width:25%;">'+finterm('Debit')+'</th><th style="width:25%;">'+finterm('Credit')+'</th><th style="width:25%;">'+finterm('Balance')+'</th></thead><tbody>'+bookkeepingHTML(sysDefMyBookData.value)+'</tbody></table>';
            } else if (requestMode.value=='accessibility') {
                pressedKeyInfo.innerText=finterm('Press any key to continue...');
            } else if (requestMode.value=='album_collection') {
                album_mode_switch.innerHTML=lockIndicatorsHTML();
                var epr='',alr=indexAvatars(sysDefAlbum.value);
                var upn=decipher(sysDefPlaylist.value,uidm,sysDefNumeric.value,'arr');
                var arl="",plCol=sysDefPlaylistColumns.value;
                for (iu in upn) {
                    arl+="<a href='javascript:omniListen(%22"+rfc3986(upn[iu])+"%22,true);'>"+(parseInt(iu)+1)+'. '+upn[iu]+"</a><br>";
                } currentPlaylist.innerHTML=arl;
                currentPlaylist.setAttribute('style','-webkit-columns:'+plCol+';-moz-columns:'+plCol+';columns:'+plCol+';');
                var alb=lockarr(sysDefAlbum.value),arl="";
                var albCol=(((sysDefAlbum.value=='avatar')||(sysDefAlbum.value=='pictogram')||(sysDefAlbum.value=='reticle')||(sysDefAlbum.value=='background'))?1:sysDefAlbumColumns.value);
                if (sysDefAlbum.value=='music') {
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
                        epr=alb[iu].split('.')[0];
                        arl+="<img title='"+loadFile(epr+'.pkg','title')+"' src='"+loadFile(epr+'.pkg','favicon')+"' style='width:18%;'>";
                    }
                } else if (sysDefAlbum.value=='avatar') {
                    epr=sysDefAva1Prefix.value;
                    for (iu in alr) {
                        arl+="<input type='image' class='power' src='"+epr+alr[iu]+".png' title='"+alr[iu]+"' onclick='setdata(&#34;avatar&#34;,&#34;"+alr[iu]+"&#34;);'>";
                    }
                } else if (sysDefAlbum.value=='pictogram') {
                    epr=sysDefPrefix.value;
                    for (iu in alr) {
                        arl+="<input type='image' class='power' src='"+epr+alr[iu]+".png' title='"+(alr[iu].toUpperCase())+"' onclick='setdata(&#34;mode&#34;,&#34;"+alr[iu]+"&#34;);'>";
                    }
                } else if (sysDefAlbum.value=='reticle') {
                    epr=sysDefRet1Prefix.value;
                    for (iu in alr) {
                        arl+="<input type='image' class='power' src='"+epr+alr[iu]+".png' title='"+(alr[iu].toUpperCase())+"' onclick='setdata(&#34;reticle&#34;,&#34;"+alr[iu]+"&#34;);'>";
                    }
                } currentAlbumList.innerHTML=arl;
                currentAlbumList.setAttribute('style','-webkit-columns:'+albCol+';-moz-columns:'+albCol+';columns:'+albCol+';text-align:'+(((sysDefAlbum.value=='avatar')||(sysDefAlbum.value=='pictogram')||(sysDefAlbum.value=='reticle')||(sysDefAlbum.value=='background'))?'center':'left')+';');
            } else if (requestMode.value=='inventory') {
                var stoDop='<table style="width:100%;position:relative;"><thead><th style="width:5%;">'+finterm('Name')+'</th><th style="width:7%;">'+finterm('Amount')+'</th><th style="width:3%;">'+finterm('Price')+'</th></thead><tbody>'+storeInventoryHTML(uidm)+'</tbody></table>';
                store_disp.innerHTML=stoDop;
            } else if (requestMode.value=='point_of_sale') {
                var stoInf="<p align='center'>"+finterm('The market is closed.')+"</p><p align='center'>"+finterm('Active Hours:')+"</p>"+activeHoursHTML(bndm);
                var stoDop='<table style="width:100%;position:relative;"><thead><th style="width:5%;">'+finterm('Name')+'</th><th style="width:7%;">'+finterm('Amount')+'</th><th style="width:3%;">'+finterm('Price')+'</th></thead><tbody>'+storeInventoryHTML(bndm)+'</tbody></table>'; store_disp.innerHTML=(uidm!=bndm)?((is_store_open(bndm))?stoDop:stoInf):stoDop;
            } else if (requestMode.value=='font_book') {
                fontBook24Pt.innerText=fontBook22Pt.innerText=fontBook20Pt.innerText=fontBook18Pt.innerText=fontBook16Pt.innerText=fontBook14Pt.innerText=sysDefPangram.value;
            } else if (requestMode.value=='statistics') {
                $('#switchBtnAuto').attr('src',sysDefPrefix.value+'steer.png'); $('#switchBtnBind').attr('src',sysDefPrefix.value+'chain.png'); $('#switchBtnTool').attr('src',sysDefPrefix.value+'parfum.png'); $('#switchBtnScore').attr('src',sysDefPrefix.value+'money.png'); $('#switchBtnHDI').attr('src',sysDefPrefix.value+'heart.png'); $('#switchBtnModel').attr('src',sysDefPrefix.value+'user.png'); $('#switchBtnIP').attr('src',sysDefPrefix.value+'world.png');
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
                if (authstate()) {
                    $('#myNotesApplyBtn').attr('src',sysDefPrefix.value+'return.png');
                    $('#myNotesKbdBtn').attr('src',sysDefPrefix.value+'keyboard.png');
                    $('#myNotesResetBtn').attr('src',sysDefPrefix.value+'backspace.png');
                    $('#myNotesNewBtn').attr('src',sysDefPrefix.value+'new.png');
                    $('#myNotesOpenBtn').attr('src',sysDefPrefix.value+'open.png');
                    $('#myNotesSaveBtn').attr('src',sysDefPrefix.value+'save.png');
                    notesMenu.innerHTML='<p align="center" class="block">'+notebookHTML(sysDefMetaList.value)+'</p>';
                    myNotesRad.placeholder=finterm('Symbolic Digits');
                    myNotesEnt.placeholder=finterm('Title');
                    myNotesEnc.placeholder=finterm('Password');
                    $('#textEdRep').attr('src',sysDefPrefix.value+'new.png');
                    $('#textEdRepAll').attr('src',sysDefPrefix.value+'copy.png');
                }
            } else if (requestMode.value=='text_editor') {
                if (authstate()) {
                    $('#textEdRep').attr('src',sysDefPrefix.value+'new.png');
                    $('#textEdRepAll').attr('src',sysDefPrefix.value+'copy.png');
                }
            }
        },
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
    document.querySelector(':root').style.setProperty('--filter','brightness('+sysDefBrightness.value+'%) saturate('+sysDefSaturation.value+'%) contrast('+sysDefContrast.value+'%) sepia('+sysDefSepia.value+'%) grayscale('+sysDefGrayscale.value+'%) hue-rotate('+sysDefHue.value+'deg)');
    if (sysDefGloss.value==1) {
        $('.power').css('background','linear-gradient('+sysDefGradientButton.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-fore','linear-gradient('+sysDefGradientFore.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefArcForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-input','linear-gradient('+sysDefGradientInput.value+'deg, '+sysDefInputColor.value+' 0%, '+sysDefArcInputColor.value+' 100%)');
    } else {
        $('.power').css('background','linear-gradient('+sysDefGradientButton.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-fore','linear-gradient('+sysDefGradientFore.value+'deg, '+sysDefForeColor.value+' 0%, '+sysDefForeColor.value+' 100%)');
        document.querySelector(':root').style.setProperty('--gradient-input','linear-gradient('+sysDefGradientInput.value+'deg, '+sysDefInputColor.value+' 0%, '+sysDefInputColor.value+' 100%)');
    } if (requestMode.value=='visual_effects') {
        opacityInd.value=sysDefOpacity.value; blurInd.value=sysDefBlur.value+'px'; brightnessInd.value=sysDefBrightness.value+'%'; saturationInd.value=sysDefSaturation.value+'%'; contrastInd.value=sysDefContrast.value+'%'; sepiaInd.value=sysDefSepia.value+'%'; grayInd.value=sysDefGrayscale.value+'%'; hueInd.value=sysDefHue.value+'deg';
    }
}
function wallpaper_engine() {
    $.ajax({
        url: 'wallpaper_engine.php',
        success: function(data) {
            $('#sysDefVarsArr').val(pager(data,5));
            $('body').css('background-image','url('+((pager(data,12)!='')?pager(data,12):pager(data,1))+')');
            $('#buttonAugment').attr('src',sysDefPrefix.value+(((sysDefVarsArr.value.split(';').length)>1)?((sysDefEntry.value!='')?'diamond.png':'heart.png'):((sysDefEntry.value!='')?'club.png':'spade.png')));
            document.title=pager(data,0)+' (@'+sysDefSessionID.value+') · Eurohouse UX/UI';
            document.querySelector(':root').style.setProperty('--position',pager(data,4));
            $('#userAvatarBadge').attr('src',pager(data,8));
            $('#buttonReticle').attr('src',sysDefRet1Prefix.value+sysDefReticle.value+'.png');
            $('#buttonDice').attr('src',sysDefPrefix.value+'dice.png');
            $('#chooseReticle1').attr('name',sysDefReticleChoice1.value);
            $('#chooseReticle2').attr('name',sysDefReticleChoice2.value);
            $('#chooseReticle3').attr('name',sysDefReticleChoice3.value);
            $('#chooseReticle4').attr('name',sysDefReticleChoice4.value);
            $('#chooseReticle5').attr('name',sysDefReticleChoice5.value);
            $('#chooseReticle1').attr('src',sysDefRet0Prefix.value+sysDefReticleChoice1.value+'.png');
            $('#chooseReticle2').attr('src',sysDefRet0Prefix.value+sysDefReticleChoice2.value+'.png');
            $('#chooseReticle3').attr('src',sysDefRet0Prefix.value+sysDefReticleChoice3.value+'.png');
            $('#chooseReticle4').attr('src',sysDefRet0Prefix.value+sysDefReticleChoice4.value+'.png');
            $('#chooseReticle5').attr('src',sysDefRet0Prefix.value+sysDefReticleChoice5.value+'.png');
            $('#buttonAutomator').attr('src',sysDefPrefix.value+((sysDefMyAutoState.value=='auto')?'wheel.png':'steer.png')); var chainIcon='chain';
            if (sysDefMyPowersState.value<=-666) {
                delete_user(sysDefSessionID.value);omniAuthRequest('signout','','');
            } chainIcon=(arraySearch(sysDefSessionID.value,jsonarr(sysDefBindData.value))!=false)?((sysDefMyBindState.value!=sysDefSessionID.value)?'unbroke':'unchain'):((sysDefMyBindState.value!=sysDefSessionID.value)?'broke':'chain');
            $('#buttonBroke').attr('src',sysDefPrefix.value+chainIcon+'.png');
            $('#showUsInfoPower').val(format_currency(sysDefMyPowersState.value));
            $('#showUsInfoBond').val(format_currency(sysDefSessionID.value,''));
            <?php if (file_exists('mode.'.$request['mode'].'.php')) {
                if ($request['mode']=='main_menu') { ?>
                    $('#projectTitle').text(pager(data,0).toUpperCase());
                    $('#showingAvatarNow').attr('src',pager(data,9));
                <?php } ?>
            $('#showUsText').text(pager(data,7));
            <?php } else { ?>
                $('#articleHead').text(pager(data,6).toUpperCase());
                $('#articleBody').text(pager(data,7));
                $('#articleLink').text(pager(data,10));
                $('#articleLink').attr('href',pager(data,10));
                $('#showingAvatarNow').attr('src',pager(data,3));
            <?php } ?>
        },
    });
}
function automator() {
    var autoPower=strarr(sysDefAutoData.value,';',':');
    var bindPower=strarr(sysDefBindData.value,';',':');
    var tabPower=strarr(sysDefPowersData.value,';',':');
    var toolPower=strarr(sysDefToolData.value,';',':');
    var userList=(sysDefUsersList.value).split(',');
    var subName=userList[rand(0,userList.length)];
    var objName=userList[rand(0,userList.length)];
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
        if ((subName!=objName)&&(objMarketCount>0)&&(objMarket[objSelect]['type']!==undefined)&&(objMarket[objSelect]['password']===undefined)&&(is_store_open(objName))) {
            buy_item(subName,objSelect,objName);
            console.log('@'+subName+' '+objSelect+'$ @'+objName);
        } if ((subName!=objName)&&(subMarketCount>0)&&(subMarket[subSelect]['type']!==undefined)&&(subMarket[subSelect]['type']=='weapon')) {
            dominate(subName,objName,subSelect);
            console.log('@'+subName+' -'+subSelect+' @'+objName);
        } if ((subName==objName)&&(subMarketCount>0)&&(subMarket[subSelect]['type']!==undefined)&&(subMarket[subSelect]['type']!='weapon')&&(subMarket[subSelect]['force']!==undefined)&&(isInt(subMarket[subSelect]['force']))) {
            charge(subName,subSelect);
            console.log('@'+subName+' +'+subSelect);
        }
    }
}
</script>
