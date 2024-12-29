<script>
function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('pitch_lock', sysDefPitchLock.value);
    setdata('video_volume', sysDefVideoVolume.value);
    setdata('video_speed', sysDefVideoSpeed.value);
}
function omniListen(input, scratch = false) {
    playAudio(audioPlayer, input);
    currentPos = parseInt(sysDefCurrent.value);
    audioPlayer.currentTime = (scratch) ? 0 : currentPos;
    setdata('melody', etw(input, sysDefSessionID.value, 'あいうえおかがきぎぐけげこごさざしじすずせぜそぞただちぢづてでとどなにぬねのはばぱひびぴふぶぷべぺほぼぽまみむめもやゆよらりるれろわゐゑをんゔゟ'));
    setdata('pitch_lock', sysDefPitchLock.value);
    setdata('audio_volume', sysDefAudioVolume.value);
    setdata('audio_speed', sysDefAudioSpeed.value);
}
function songIndex(mode = '') {
    var museLint = lockarr('music');
    var museMelo = dtw(sysDefMelody.value, sysDefSessionID.value, 'あいうえおかがきぎぐけげこごさざしじすずせぜそぞただちぢづてでとどなにぬねのはばぱひびぴふぶぷべぺほぼぽまみむめもやゆよらりるれろわゐゑをんゔゟ'), museInd = arraySearch(((museMelo.startsWith(requestPath.value+'/')) ? museMelo.replace(requestPath.value+'/','') : museMelo), museLint); omniListen(((mode == 'next') ? (((museInd >= (museLint.length-1)) || (museInd === false)) ? museLint[0] : museLint[parseInt(museInd)+1]) : ((mode == 'prev') ? (((museInd <= 0) || (museInd === false)) ? museLint[museLint.length-1] : museLint[parseInt(museInd)-1]) : ((mode == 'random') ? museLint[rand(0, museLint.length)] : museMelo))), true);
}
function omniPause() { pauseAudio(audioPlayer); }
function audioPosition(sec) {
    if (audioPlayer.duration > sec) {
        audioPlayer.currentTime = (sec.includes('-')) ? (audioPlayer.duration - parseInt(sec.replace('-',''))) : (((sec.includes('+'))) ? (parseInt(sec.replace('+',''))) : (parseInt(sec)));
    }
}
function savePlayState() {
    setdata('current', audioPlayer.currentTime);
}
function arrangePlay() {
    var dp = arrjob(sysDefPowersData.value,';',':');
    var db = arrjob(sysDefBindData.value,';',':');
    var da = arrjob(sysDefAutoData.value,';',':');
    sysDefAutoState.value = da[sysDefSessionID.value];
    $('#buttonAutomator').attr('src', sysDefPrefix.value+((sysDefAutoState.value == 'auto')?'wheel.png':'steer.png'));
    var my = dp[sysDefSessionID.value], bl = pl = lp = rp = '', ch = 'chain';
    if (my <= -666) {
        delete_user(sysDefSessionID.value);
        omniAuthRequest('signout', '', '');
    } if (arraySearch(sysDefSessionID.value, db) != false) {
        if (db[sysDefSessionID.value] != sysDefSessionID.value) {
            /* ELSE BINDED TO USER BINDED TO OTHER */ lp = '+', rp = '+', ch = 'broke';
        } else {
            /* OTHER BINDED TO USER */ lp = '+', rp = '', ch = 'broke';
        }
    } else {
        if (db[sysDefSessionID.value] != sysDefSessionID.value) {
            /* USER BINDED TO OTHER */ lp = '', rp = '+', ch = 'broke';
        } else {
            /* USER BINDED TO SELF */ lp = '', rp = '', ch = 'chain';
        }
    } pl = lp+'$'+my+rp, bl = lp+'@'+sysDefSessionID.value+rp;
    $('#buttonBroke').attr('src', sysDefPrefix.value+ch+'.png');
    $('#showUsInfoPower').val(pl); $('#showUsInfoBond').val(bl);
}
function lockdata() {
    var obj = {
        <?php $iter = 0; foreach ($locks as $key=>$value) {
            echo "'".$key."': lock".camel($key).".value".((count($locks) == ($iter-1))?'':','); $iter++;
        } $iter = 0; ?>
    }; return obj;
}
function lockarr(ind) {
    return Object.values(jsonstr(sysDefLockData.value)[ind]);
}
function lockcount(ind) {
    return Object.keys(jsonstr(sysDefLockData.value)[ind]).length;
}
function metadata() { return jsonstr(sysDefMetaData.value); }
function userdata() {
    var obj = {
        <?php $iter = 0; foreach ($settings['defaults'] as $key=>$value) {
            echo "'".$key."': sysDef".camel($key).".value".((count($settings['defaults']) == ($iter-1))?'':','); $iter++;
        } $iter = 0; ?>
    }; return obj;
}
function setlock(ent, val) {
    var obj = lockdata(); obj[ent] = val;
    set(sysDefSessionID.value+'_lock.json', JSON.stringify(obj), true);
    <?php foreach ($locks as $key=>$value) {
        echo "lock".camel($key).".value = obj['".$key."'];";
    } ?>
}
function setmeta(ent, val) {
    var obj = metadata(); obj[ent] = val;
    set(sysDefSessionID.value+'_metadata.json', JSON.stringify(obj), true);
}
function delmeta(ent) {
    var obj = metadata(); delete obj[ent];
    set(sysDefSessionID.value+'_metadata.json', JSON.stringify(obj), true);
}
function setdata(ent, val) {
    var obj = userdata(); obj[ent] = val;
    set(sysDefSessionID.value+'_session.json', JSON.stringify(obj), true);
    <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".camel($key).".value = obj['".$key."'];";
    } ?> if (ent == 'audio_volume') { audioPlayer.volume = val; }
    if (ent == 'audio_speed') { audioPlayer.playbackRate = val; }
    if (ent == 'alarm_volume') { alarmPlayer.volume = val; }
    if (ent == 'timer_volume') { tickerPlayer.volume = val; }
    if (ent == 'loop_volume') { backgroundPlayer.volume = val; }
    if (ent == 'rest_volume') {
        soundPlayer.volume = val; typePlayer.volume = val; errorPlayer.volume = val;
        notifyPlayer.volume = val; bindPlayer.volume = val;
        hitPlayer.volume = val; sufferPlayer.volume = val;
    } if (ent == 'pitch_lock') { audioPlayer.preservesPitch = (val != 0) ? true : false; }
    if (requestMode.value == 'sticky_notes') {
        if (ent == 'numeric') { myNotesRad.value = val; }
    } if (requestMode.value == 'media_player') {
        if (ent == 'video_volume') { video.volume = val; }
        if (ent == 'video_speed') { video.playbackRate = val; }
        if (ent == 'pitch_lock') { video.preservesPitch = (val != 0) ? true : false; }
    } if (requestMode.value == 'volume_control') {
        if (ent == 'audio_volume') { audioVolInd.value = val; audioVolRange.value = val; }
        if (ent == 'audio_speed') { audioRatInd.value = val; audioRatRange.value = val; }
        if (ent == 'video_volume') { videoVolInd.value = val; videoVolRange.value = val; }
        if (ent == 'video_speed') { videoRatInd.value = val; videoRatRange.value = val; }
        if (ent == 'alarm_volume') { alarmVolInd.value = val; alarmVolRange.value = val; }
        if (ent == 'timer_volume') { timerVolInd.value = val; timerVolRange.value = val; }
        if (ent == 'loop_volume') { loopVolInd.value = val; loopVolRange.value = val; }
        if (ent == 'rest_volume') { restVolInd.value = val; restVolRange.value = val; }
    } if (requestMode.value == 'visual_effects') {
        if (ent == 'opacity') { opacityRange.value = val; }
        if (ent == 'blur') { blurRange.value = val; }
        if (ent == 'brightness') { brightnessRange.value = val; }
        if (ent == 'saturation') { saturationRange.value = val; }
        if (ent == 'contrast') { contrastRange.value = val; }
        if (ent == 'sepia') { sepiaRange.value = val; }
        if (ent == 'grayscale') { grayscaleRange.value = val; }
        if (ent == 'hue') { hueRange.value = val; }
    }
}
function bind(usr, id) {
    var obj = arrjob(sysDefBindData.value,';',':');
    obj[usr] = id; set('binding.json', JSON.stringify(obj), true);
    sysDefBindData.value = arrpack(obj,';',':');
}
function equip(usr, id) {
    var obj = arrjob(sysDefToolData.value,';',':');
    obj[usr] = id; set('toolbox.json', JSON.stringify(obj), true);
    sysDefToolData.value = arrpack(obj,';',':');
}
function automate() {
    var usr = sysDefSessionID.value;
    var obj = arrjob(sysDefAutoData.value,';',':');
    obj[usr] = (sysDefAutoState.value == 'auto') ? 'manual' : 'auto';
    set('automator.json', JSON.stringify(obj), true);
    sysDefAutoData.value = arrpack(obj,';',':');
}
function jsonstr(str) {
    var res = {}; try {
        res = JSON.parse(str);
    } catch (e) {
        res = {};
    } return res;
}
function jsonFilter(str, mask) {
    var arr = jsonstr(str), sym = '#'; uni = 'L';
    var arf = {}, cyp = '.-', hbin = '', hkin = '', hbio = {};
    if (mask == sym) {
        for (el in arr) {
            hbin = dtw(arr[el], sysDefSessionID.value, cyp);
            hkin = dtw(el, sysDefSessionID.value, cyp); arf[hkin] = hbin;
        }
    } else {
        var arrRegex = XRegExp('(\\'+sym+'\\p{'+uni+'}+)', 'g');
        var repRegex = XRegExp('(\\'+sym+'+)', 'g');
        var wordArr = XRegExp.match(mask, arrRegex);
        for (el in arr) {
            if (wordArr !== null) {
                for (iy in wordArr) {
                    hbin = dtw(arr[el], sysDefSessionID.value, cyp);
                    hkin = dtw(el, sysDefSessionID.value, cyp);
                    hbio = XRegExp.replace(wordArr[iy], repRegex, '');
                    if (hbin.toLowerCase().includes(hbio.toLowerCase())) { arf[hkin] = hbin; }
                }
            }
        }
    } return arf;
}
function jsonHTML(str, mask) {
    var arr = jsonFilter(str, mask);
    var ard = ''; for (el in arr) {
        ard = el+'<br>'+arr[el]+'<br>'+ard;
    } return ard;
}
function jsonMarket(id) {
    var arr = jsonstr(openJournal(id, sysDefStoreList, sysDefStoreJSONs));
    var res = {}; for (el in arr) {
        if (arr[el]['password'] === undefined) {
            res[el] = arr[el];
        }
    } return res;
}
function activeHrsBtn(id) {
    var arr = storeHours(id).split(',');
    var arl = ''; for (el in arr) {
        arl += "<input type='button' value='"+arr[el]+"'>";
    } return arl;
}
function jsonStore(id) {
    var arr = jsonstr(openJournal(id, sysDefStoreList, sysDefStoreJSONs));
    var ard = arl = '', eld = {}, fu0 = fu1 = '';
    var usr = sysDefSessionID.value, epr = sysDefPrefix.value; for (el in arr) {
        if ((arr[el] !== undefined) && (typeof(arr[el]) == 'object')) {
            eld = arr[el], arl = '<tr>';
            fu0 = "buy_item(&#34;"+usr+"&#34;,&#34;"+el+"&#34;,&#34;"+id+"&#34;);";
            fu1 = (isInt(el)) ? "charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);" : ((eld['type'] == 'weapon') ? "equip(&#34;"+id+"&#34;,&#34;"+el+"&#34;);" : "charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);");
            arl += "<td><input type='button' style='width:80%;' onclick='"+((id != usr) ? fu0 : fu1)+"' value='"+el+"'></td><td>"+eld['amount']+"</td><td>"+eld['price']+"</td>"; ard = arl+"</tr>"+ard;
            arl += "<input type='image' class='power' src='"+epr+"info.png"+"' onclick='omniPath(&#34;./.store/"+usr+"_store.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>";
        }
    } return ard;
}
function jsonBookKeep(str) {
    var arr = jsonstr(str);
    var ard = '', arl = '', arf = {}, eld = [];
    for (el in arr) {
        eld = arr[el].split(' | '); arf[el] = arr[el];
    } for (el in arf) {
        eld = arr[el].split(' | ');
        arl = (eld[4] == 'ERR') ? '<tr style="text-decoration:line-through;">' : '<tr>';
        arl += '<td>@'+eld[0]+'</td>'; arl += (isInt(eld[1])) ? '<td>$'+eld[1]+'</td>' : '<td>'+eld[1]+'</td>';
        arl += (isInt(eld[2])) ? '<td>$'+eld[2]+'</td>' : '<td>'+eld[2]+'</td>'; arl += '<td>$'+eld[3]+'</td>';
        ard = arl+'</tr>'+ard;
    } return ard;
}
function noteBook(str) {
    var arr = str.split(' | ');
    var ard = '', arl = '', eld = '', elt = '', eln = '';
    var epr = sysDefPrefix.value; for (el in arr) {
        eld = arr[el]; eln = sysDefNumeric.value, elt = hex2bin(eld,'',eln);
        arl = "<input type='button' style='width:80%;' onclick='openNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);' value='"+elt+"'>";
        arl += "<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='deleteNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);'>";
        ard = ard+arl+'<br>';
    } return ard;
}
function helpBook() {
    var obj = jsonstr(sysDefTutorData.value);
    var ard = '', arl = '', elt = '';
    for (el in obj) {
        if ((obj[el] !== undefined) && (obj[el][sysDefUnits.value] !== undefined) && (obj[el][sysDefUnits.value]['title'] !== undefined)) {
            elt = obj[el][sysDefUnits.value]['title'];
        } else {
            if (obj[el]['default']['title'] !== undefined) {
                elt = obj[el]['default']['title'];
            } else {
                elt = '';
            }
        } arl = "<input type='button' style='width:80%;' onclick='openHelpPage(&#34;"+el+"&#34;);' value='"+elt+"'>";
        ard = ard+arl+'<br>';
    } return ard;
}
function openJournal(id, ob, oj) {
    var users = ob.value, jours = oj.value;
    var userArr = users.split(',');
    var userNum = arraySearch(id, userArr);
    return pager(jours, userNum);
}
function storeOpen(id) {
    var userArr = (sysDefUsersList.value).split(',');
    var userNum = arraySearch(id, userArr);
    var hours = storeHours(id).split(',');
    return (hours.includes(userTimeNow(id)));
}
function userTimeNow(id) {
    var userArr = (sysDefUsersList.value).split(',');
    var userNum = arraySearch(id, userArr);
    return (sysDefHoursNow.value).split(' ')[userNum];
}
function storeHours(id) {
    var userArr = (sysDefUsersList.value).split(',');
    var userNum = arraySearch(id, userArr);
    return pager(sysDefHoursActive.value, userNum);
}
function clearJournal(num, obj, kw) {
    var msgarr = jsonstr(obj.value), nur, ras;
    var las = Object.keys(msgarr).length - 1;
    if (isInt(num)) {
        nur = Math.abs(num);
        ras = (las - nur); if (num < 0) {
            for (i = 0; i < nur; i++) {
                if (msgarr[Object.keys(msgarr)[0]] !== undefined) {
                    delete msgarr[Object.keys(msgarr)[0]];
                }
            }
        } else {
            for (i = las; i > ras; i--) {
                if (msgarr[Object.keys(msgarr)[i]] !== undefined) {
                    delete msgarr[Object.keys(msgarr)[i]];
                }
            }
        }
    } else {
        nur = Math.abs(las);
        for (i = 0; i < nur; i++) {
            if (msgarr[Object.keys(msgarr)[0]] !== undefined) {
                delete msgarr[Object.keys(msgarr)[0]];
            }
        }
    } set('./.'+kw+'/'+sysDefSessionID.value+'_'+kw+'.json', encodeURIComponent(JSON.stringify(msgarr)), true);
}
function isoformat(num) {
    var ob = new Date(num);
    return (ob.getUTCFullYear())+'-'+pad((ob.getUTCMonth()+1), 2)+'-'+pad((ob.getUTCDate()), 2)+' '+pad((ob.getUTCHours()), 2)+':'+pad((ob.getUTCMinutes()), 2)+':'+pad((ob.getUTCSeconds()), 2)+'.'+pad((ob.getUTCMilliseconds()), 3);
}
function etw(msg, usr = '', abc = '.-') {
    return bin2hex(msg, obfstr(CryptoJS.SHA256(usr).toString()), abc);
}
function dtw(msg, usr = '', abc = '.-') {
    return hex2bin(msg, obfstr(CryptoJS.SHA256(usr).toString()), abc);
}
function compose(msg) {
    var addr = (msg !== undefined) ? msg.match(/(@\w*)/g) : '';
    var userID, cyp = '.-', msgbox = '', msgbr = [];
    var ratTab = arrjob(sysDefPowersData.value, ';', ':');
    if (ratTab[sysDefSessionID.value] >= 0) {
        if (addr !== null) {
            for (it in addr) {
                userID = addr[it].replace('@', '');
                msgbox = openJournal(userID, sysDefUsersList, sysDefMailingJSONs);
                msgarr = jsonstr(msgbox);
                if (msg.match(/\r?\n/) !== null) {
                    msgbr = msg.split(/\r?\n/);
                    for (j = 0; j < msgbr.length; j++) {
                        msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC', userID, cyp)] = etw(msgbr[j], userID, cyp);
                    }
                } else {
                    msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC', userID, cyp)] = etw(msg, userID, cyp);
                } set('./.msgbox/'+userID+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            }
        } else {
            msgbox = sysDefMsgData.value; msgarr = jsonstr(msgbox);
            if (msg.match(/\r?\n/) !== null) {
                msgbr = msg.split(/\r?\n/);
                for (j = 0; j < msgbr.length; j++) {
                    msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC', sysDefSessionID.value, cyp)] = etw(msgbr[j], sysDefSessionID.value, cyp);
                }
            } else {
                msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC', sysDefSessionID.value, cyp)] = etw(msg, sysDefSessionID.value, cyp);
            } set('./.msgbox/'+sysDefSessionID.value+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
        }
    }
}
function storeq(tabS, tabB, art) {
    var qS = 0, qB = 0;
    if ((tabS[art]['amount'] !== undefined) && isInt(tabS[art]['amount'])) {
        qS = parseInt(tabS[art]['amount']); if (qS > 1) {
            if ((tabB[art] !== undefined) && (typeof(tabB[art]) == 'object') && (tabB[art]['amount'] !== undefined) && isInt(tabB[art]['amount'])) {
                qB = parseInt(tabB[art]['amount']);
                qB = (qB > 0) ? (qB + 1) : 1;
                tabB[art]['amount'] = parseInt(qB);
            } else {
                qB = 1; tabB[art] = tabS[art];
                tabB[art]['amount'] = parseInt(qB);
            } qS = qS - 1; tabS[art]['amount'] = parseInt(qS);
        } else {
            if ((tabB[art] !== undefined) && (typeof(tabB[art]) == 'object') && (tabB[art]['amount'] !== undefined) && isInt(tabB[art]['amount'])) {
                qB = parseInt(tabB[art]['amount']);
                qB = (qB > 0) ? (qB + 1) : 1;
                tabB[art]['amount'] = parseInt(qB);
            } else {
                tabB[art] = tabS[art];
            } delete tabS[art];
        }
    }
}
function buy_item(bye, art, sel) {
    if (sel != bye) {
        var tabS = jsonstr(openJournal(sel, sysDefStoreList, sysDefStoreJSONs));
        var tabB = jsonstr(openJournal(bye, sysDefStoreList, sysDefStoreJSONs));
        var prix, pass, obj = arrjob(sysDefPowersData.value,';',':');
        if ((obj[bye] >= 0) && (obj[sel] >= 0)) {
            if ((tabS[art] !== undefined) && (typeof(tabS[art]) == 'object')) {
                if ((isInt(tabS[art]['price'])) && (!isInt(art))) {
                    // Buy any product for certain price
                    prix = parseInt(tabS[art]['price']);
                    if (obj[bye] >= prix) {
                        fixPrice(bye, sel, art, prix); storeq(tabS, tabB, art);
                        set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                        set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                        if ((tabS[art]['password'] !== undefined) && (tabS[art]['type'] == 'account')) {
                            pass = tabS[art]['password'];
                            copy(sel+'_session.json.bak', bye+'_session.json.bak', true, 1);
                            copy(sel+'_session.json', bye+'_session.json', true, 1);
                            change(bye, bye, pass, true); omniAuthRequest('signin', bye, pass);
                        } else if ((tabS[art]['password'] !== undefined) && (tabS[art]['type'] == 'password')) {
                            pass = tabS[art]['password'];
                            change(sel, sel, pass, true); omniAuthRequest('signin', sel, pass);
                        }
                    }
                } else if ((!isInt(tabS[art]['price'])) && (!isInt(art)) && (tabB[tabS[art]['price']] !== undefined) && (typeof(tabB[tabS[art]['price']]) == 'object')) {
                    // Exchange goods with other users
                    prix = tabS[art]['price']; fixPrice(bye, sel, art, prix);
                    storeq(tabB, tabS, prix); storeq(tabS, tabB, art);
                    set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                    set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                } else if ((!isInt(tabS[art]['price'])) && (tabS[art]['price'] == '')) {
                    // Get certain amount of money or good from user as a gift
                    prix = tabS[art]['price']; fixPrice(bye, sel, art, prix); storeq(tabS, tabB, art);
                    set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                    set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                }
            }
        }
    }
}
function sell_item(usr, art, dat = '') {
    var tabS = jsonstr(openJournal(usr, sysDefStoreList, sysDefStoreJSONs));
    var obj = arrjob(sysDefPowersData.value,';',':'), dap = arrjob(dat,'; ',': ');
    if (obj[usr] >= 0) {
        var qu = ((tabS[art] !== undefined) && (typeof(tabS[art]) == 'object') && (tabS[art]['amount'] !== undefined) && isInt(tabS[art]['amount']) && (tabS[art]['amount'] >= 0)) ? parseInt(tabS[art]['amount'])+1 : 1; tabS[art] = { "amount": qu };
        for (iu in dap) {
            tabS[art][iu] = (iu == 'password') ? CryptoJS.SHA256(dap[iu]).toString() : dap[iu];
        } set('./.store/'+usr+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
    }
}
function fixPrice(sen, rec, deb, cre) {
    var tran1 = openJournal(sen, sysDefBooksList, sysDefBookKeepJSONs);
    var tran2 = openJournal(rec, sysDefBooksList, sysDefBookKeepJSONs);
    var trans1 = jsonstr(tran1); var trans2 = jsonstr(tran2);
    var stat = arrjob(sysDefPowersData.value,';',':');
    var statD = (isInt(stat[sen])) ? parseInt(stat[sen]) : 0;
    var statC = (isInt(stat[rec])) ? parseInt(stat[rec]) : 0;
    var statDr = parseInt(statD); var statCr = parseInt(statC);
    var bal1 = (tran1 == '{}') ? statDr : (trans1[Object.keys(trans1)[Object.keys(trans1).length - 1]]).split(' | ')[4]; var bal2 = (tran2 == '{}') ? statCr : (trans2[Object.keys(trans2)[Object.keys(trans2).length - 1]]).split(' | ')[4];
    var statDt, statCt, statK, statV, statDi, statCi, statDn, statCn, statT;
    var statDv = statDr - parseInt(bal1), statCv = statCr - parseInt(bal2);
    if ((isInt(deb)) && !(isInt(cre))) {
        statV = parseInt(deb); statK = cre; statT = cre;
        statD += statV; statC -= statV;
        statDi = parseInt(bal1) + parseInt(statDv) + statV;
        statCi = parseInt(bal2) + parseInt(statCv) - statV;
    } else if (!(isInt(deb)) && (isInt(cre))) {
        statV = parseInt(cre); statK = deb; statT = deb;
        statD -= statV; statC += statV;
        statDi = parseInt(bal1) + parseInt(statDv) - statV;
        statCi = parseInt(bal2) + parseInt(statCv) + statV;
    } else {
        statK = cre; statT = deb;
        statDi = parseInt(bal1) + parseInt(statDv);
        statCi = parseInt(bal2) + parseInt(statCv);
    } statDn = Math.abs(statDi - parseInt(bal1));
    statCn = Math.abs(statCi - parseInt(bal2));
    statDt = (statDi == statD) ? 'OK' : 'ERR';
    statCt = (statCi == statC) ? 'OK' : 'ERR';
    stat[sen] = parseInt(statD); stat[rec] = parseInt(statC);
    trans1[isoformat(Date.now())+' UTC'] = (statDi < parseInt(bal1)) ? rec+' | '+statT+' | '+statDn+' | '+statDi+' | '+statDt : rec+' | '+statDn+' | '+statT+' | '+statDi+' | '+statDt;
    trans2[isoformat(Date.now())+' UTC'] = (statCi < parseInt(bal2)) ? sen+' | '+statT+' | '+statCn+' | '+statCi+' | '+statCt : sen+' | '+statCn+' | '+statT+' | '+statCi+' | '+statCt;
    if (!isInt(deb) && !isInt(cre)) {
        trans1[isoformat(Date.now())+' UTC'] = rec+' | '+statT+' | '+statK+' | '+statDi+' | '+statDt;
        trans2[isoformat(Date.now())+' UTC'] = sen+' | '+statK+' | '+statT+' | '+statCi+' | '+statCt;
    } set('./.book/'+sen+'_book.json', encodeURIComponent(JSON.stringify(trans1)), true);
    set('./.book/'+rec+'_book.json', encodeURIComponent(JSON.stringify(trans2)), true);
    set('dominion.json', JSON.stringify(stat), true);
    sysDefPowersData.value = arrpack(stat,';',':');
}
function charge(usr, itp = '') {
    var obj = arrjob(sysDefPowersData.value,';',':');
    var stu = jsonMarket(usr), f = m = s = n = 0;
    var suf = (isInt(obj[usr])) ? parseInt(obj[usr]) : 0; if (suf >= 0) {
        if ((stu[itp] !== undefined) && (typeof(stu[itp]) == 'object') && (stu[itp]['type'] != 'account') && (stu[itp]['type'] != 'password') && (stu[itp]['type'] != 'weapon')) {
            m = ((stu[itp]['amount'] !== undefined) && isInt(stu[itp]['amount'])) ? parseInt(stu[itp]['amount']) : 1;
            f = (isInt(itp)) ? parseInt(itp) : (((stu[itp]['force'] !== undefined) && isInt(stu[itp]['force'])) ? parseInt(stu[itp]['force']) : 1);
            n = ((stu[itp]['finite'] !== undefined) && isInt(stu[itp]['finite'])) ? parseInt(stu[itp]['finite']) : 0;
            s = ((stu[itp]['series'] !== undefined) && isInt(stu[itp]['series'])) ? parseInt(stu[itp]['series']) : 0;
        } else { m = f = 1, n = s = 0; }
        if (n != 0) {
            if (m > 0) { if (s != 0) {
                    do { suf += f; s -= 1; } while (s > 0);
                } else { suf += f; } m -= 1; stu[itp]['amount'] = m;
            } else { delete stu[itp]; }
        } else {
            if (s != 0) {
                do { suf += f; s -= 1; } while (s > 0);
            } else { suf += f; }
        } obj[usr] = suf;
        set('./.store/'+usr+'_store.json', encodeURIComponent(JSON.stringify(stu)), true);
        set('dominion.json', JSON.stringify(obj), true);
        sysDefPowersData.value = arrpack(obj,';',':');
    }
}
function dominate(usr, id, wep = '') {
    var obj = arrjob(sysDefPowersData.value,';',':');
    var stu = jsonMarket(usr), f = m = s = n = 0;
    var suf = (isInt(obj[usr])) ? parseInt(obj[usr]) : 0;
    var obf = (isInt(obj[id])) ? parseInt(obj[id]) : 0; if ((usr != id) && (suf >= 0)) {
        if ((stu[wep] !== undefined) && (typeof(stu[wep]) == 'object') && (stu[wep]['type'] == 'weapon')) {
            m = ((stu[wep]['amount'] !== undefined) && isInt(stu[wep]['amount'])) ? parseInt(stu[wep]['amount']) : 1;
            f = ((stu[wep]['force'] !== undefined) && isInt(stu[wep]['force'])) ? parseInt(stu[wep]['force']) : 1;
            n = ((stu[wep]['finite'] !== undefined) && isInt(stu[wep]['finite'])) ? parseInt(stu[wep]['finite']) : 0;
            s = ((stu[wep]['series'] !== undefined) && isInt(stu[wep]['series'])) ? parseInt(stu[wep]['series']) : 0;
        } else { m = f = 1, n = s = 0; }
        if (obf <= -666) {
            delete_user(id);
        } else {
            if (n != 0) {
                if (m > 0) {
                    if (s != 0) {
                        do { suf += f; obf -= f; s -= 1; } while (s > 0);
                    } else { suf += f; obf -= f; } m -= 1; stu[wep]['amount'] = m;
                } else { delete stu[wep]; }
            } else {
                if (s != 0) {
                    do { suf += f; obf -= f; s -= 1; } while (s > 0);
                } else { suf += f; obf -= f; }
            } obj[usr] = suf; obj[id] = obf;
            set('./.store/'+usr+'_store.json', encodeURIComponent(JSON.stringify(stu)), true);
            set('dominion.json', JSON.stringify(obj), true);
            sysDefPowersData.value = arrpack(obj,';',':');
        }
    }
}
function unbind(id) { bind(id, id); }
function unequip(id) { equip(id, ''); }
function remove_entry(id, obj, name) {
    var objData = arrjob(obj.value,';',':');
    delete objData[id];
    set(name, JSON.stringify(objData), true);
    obj.value = arrpack(objData,';',':');
}
function delete_user(id) {
    unbind(sysDefSessionID.value);
    remove_entry(id, sysDefBindData, 'binding.json');
    remove_entry(id, sysDefPowersData, 'dominion.json');
    remove_entry(id, sysDefAutoData, 'automator.json');
    remove_entry(id, sysDefFriendData, 'friendship.json');
    remove_entry(id, sysDefToolData, 'toolbox.json');
    remove_entry(id, sysDefCallData, 'calling.json');
    del(id+'_session.json', true);
    del(id+'_session.json.bak', true);
    del(id+'_password', true);
    del(id+'_lock.json', true);
    del(id+'_lock.json.bak', true);
    del(id+'_metadata.json', true);
    del(id+'_metadata.json.bak', true);
    del('./.msgbox/'+id+'_msgbox.json', true);
    del('./.msgbox/'+id+'_msgbox.json.bak', true);
    del('./.book/'+id+'_book.json', true);
    del('./.book/'+id+'_book.json.bak', true);
    del('./.store/'+id+'_store.json', true);
    del('./.store/'+id+'_store.json.bak', true);
}
function transfer_entry(id, obj, name, seb = false) {
    var objData = arrjob(obj.value,';',':');
    objData[id] = (seb !== false) ? id : objData[sysDefSessionID.value];
    if (sysDefSessionID.value != id) {
        delete objData[sysDefSessionID.value];
    } set(name+'.json', JSON.stringify(objData), true);
    obj.value = arrpack(objData,';',':');
}
function rename_user(username, password) {
    unbind(sysDefSessionID.value);
    change(sysDefSessionID.value, username, CryptoJS.SHA256(password).toString(), true);
    if (sysDefSessionID.value != username) {
        transfer_entry(username, sysDefBindData, 'binding', true);
        transfer_entry(username, sysDefPowersData, 'dominion');
        transfer_entry(username, sysDefAutoData, 'automator');
        transfer_entry(username, sysDefFriendData, 'friendship');
        transfer_entry(username, sysDefToolData, 'toolbox');
        transfer_entry(username, sysDefCallData, 'calling');
    }
}
function init_user(id, au = 'manual', ob) {
    var bd = arrjob(sysDefBindData.value,';',':');
    var pd = arrjob(sysDefPowersData.value,';',':');
    var ad = arrjob(sysDefAutoData.value,';',':');
    var fd = arrjob(sysDefFriendData.value,';',':');
    var td = arrjob(sysDefToolData.value,';',':');
    var cd = arrjob(sysDefCallData.value,';',':');
    var usl = (sysDefUsersList.value).split(',');
    var bkl = (sysDefBooksList.value).split(',');
    var stl = (sysDefStoreList.value).split(',');
    if (usl.indexOf(id) <= -1) {
        set('./.msgbox/'+id+'_msgbox.json', '{}', true);
    } if (bkl.indexOf(id) <= -1) {
        set('./.book/'+id+'_book.json', '{}', true);
    } if (stl.indexOf(id) <= -1) {
        set('./.store/'+id+'_store.json', JSON.stringify(ob), true);
    } if (!(id in bd)) {
        bd[id] = id;
        set('binding.json', JSON.stringify(bd), true);
        sysDefBindData.value = arrpack(bd,';',':');
    } if (!(id in pd)) {
        pd[id] = 0;
        set('dominion.json', JSON.stringify(pd), true);
        sysDefPowersData.value = arrpack(pd,';',':');
    } if (!(id in ad)) {
        ad[id] = au;
        set('automator.json', JSON.stringify(ad), true);
        sysDefAutoData.value = arrpack(ad,';',':');
    } if (!(id in fd)) {
        fd[id] = '';
        set('friendship.json', JSON.stringify(fd), true);
        sysDefFriendData.value = arrpack(fd,';',':');
    } if (!(id in td)) {
        td[id] = '';
        set('toolbox.json', JSON.stringify(td), true);
        sysDefToolData.value = arrpack(td,';',':');
    } if (!(id in cd)) {
        cd[id] = id;
        set('calling.json', JSON.stringify(cd), true);
        sysDefCallData.value = arrpack(cd,';',':');
    }
}
function friendsOf(obj, id) {
    var res = (obj[id] !== undefined) ? ((obj[id].includes(',')) ? obj[id].split(',') : [obj[id]]) : []; return res;
}
function isFriends(id) {
    var usr = sysDefSessionID.value;
    var fr = arrjob(sysDefFriendData.value,';',':');
    var frnd = friendsOf(fr, usr); var res = false;
    if (id != usr) { if (frnd.indexOf(id) > -1) { res = true; }} return res;
}
function toggleFriend(id) {
    var usr = sysDefSessionID.value;
    var fr = arrjob(sysDefFriendData.value,';',':');
    var frnd = friendsOf(fr, usr);
    if (id != usr) {
        if (frnd.indexOf(id) > -1) {
            frnd.splice(frnd.indexOf(id), 1);
        } else {
            frnd.push(id);
        } fr[usr] = finarr(frnd).sort().join(',');
        set('friendship.json', JSON.stringify(fr), true);
        sysDefFriendData.value = arrpack(fr,';',':');
    }
}
function addFriend(id) {
    var usr = sysDefSessionID.value;
    var fr = arrjob(sysDefFriendData.value,';',':');
    var frnd = friendsOf(fr, usr);
    if (id != usr) {
        frnd.push(id);
        fr[usr] = finarr(frnd).sort().join(',');
        set('friendship.json', JSON.stringify(fr), true);
        sysDefFriendData.value = arrpack(fr,';',':');
    }
}
function dropFriend(id) {
    var usr = sysDefSessionID.value;
    var fr = arrjob(sysDefFriendData.value,';',':');
    var frnd = friendsOf(fr, usr);
    if (id != usr) {
        if (frnd.indexOf(id) > -1) {
            frnd.splice(frnd.indexOf(id), 1);
        } fr[usr] = finarr(frnd).sort().join(',');
        set('friendship.json', JSON.stringify(fr), true);
        sysDefFriendData.value = arrpack(fr,';',':');
    }
}
function administer(sta, act, fn) {
    if (sysDefSessionID.value == 'root') {
        var obj = document.getElementById('sysDef'+ucfirst(sta)+'Data'), arr = (obj !== null) ? obj.value : ';', sb = arr.slice(0, -1), ob = arrjob(sb,';',':');
        var sum = arrsum(Object.values(ob)), qua = Object.keys(ob).length;
        if ((sta == 'bind') || (sta == 'call')) {
            for (ib in ob) { ob[ib] = ib; }
        } else if (sta == 'auto') {
            for (ib in ob) { ob[ib] = act; }
        } else if ((sta == 'friend') || (sta == 'tool')) {
            for (ib in ob) { ob[ib] = ''; }
        } else {
            if ((act == 'equal') || (act == 'share')) {
                div = Math.round(sum / qua);
                for (ib in ob) { ob[ib] = parseInt(div); }
            } else if ((act == 'total') || (act == 'sum')) {
                for (ib in ob) { ob[ib] = parseInt(sum); }
            }
        } if (obj !== null) {
            set(fn+'.json', JSON.stringify(ob), true);
            obj.value = arrpack(ob,';',':');
        }
    }
}
function scores(sta) {
    var sto = ['bind', 'call', 'auto', 'friend', 'tool'];
    var arr = (arraySearch(sta, sto) !== false) ? document.getElementById('sysDef'+ucfirst(sta)+'Data').value : document.getElementById('sysDefPowersData').value;
    var obj = arrjob(arr, ';', ':'), em = '';
    var keys = Object.keys(obj), vals = Object.values(obj);
    var res = '', sortable = {}, ordered = {};
    var dat = {}, am = se = fo = ex = 0;
    if (sta == 'bind') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { obd[key] = obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] != indi) {
                    res += '@'+indi+' :: @'+ordered[indi]+'\n';
                } else { res += '@'+indi+' :: SELF\n'; }
            }
        }
    } else if (sta == 'call') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { obd[key] = obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] != indi) {
                    res += '@'+indi+' INCOMING\n';
                } else { res += '@'+indi+' OUTGOING\n'; }
            }
        }
    } else if (sta == 'auto') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { obd[key] = obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] == 'auto') {
                    res += '@'+indi+' AUTO\n';
                } else { res += '@'+indi+' MANUAL\n'; }
            }
        }
    } else if (sta == 'friend') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { obd[key] = obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] != '') {
                    res += '@'+indi+' ['+ordered[indi]+']\n';
                } else { res += '@'+indi+' [NULL]\n'; }
            }
        }
    } else if (sta == 'tool') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { obd[key] = obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                dat = jsonstr(openJournal(indi, sysDefStoreList, sysDefStoreJSONs));
                if ((dat[ordered[indi]] !== undefined) && (typeof(dat[ordered[indi]]) == 'object') && (ordered[indi] != '')) {
                    ex = ((dat[ordered[indi]]['finite'] !== undefined) && (isInt(dat[ordered[indi]]['finite'])) && (dat[ordered[indi]]['finite'] == 1)) ? 1 : 0;
                    am = ((dat[ordered[indi]]['amount'] !== undefined) && (isInt(dat[ordered[indi]]['amount'])) && (dat[ordered[indi]]['amount'] > 0)) ? parseInt(dat[ordered[indi]]['amount']) : 0;
                    se = ((dat[ordered[indi]]['series'] !== undefined) && (isInt(dat[ordered[indi]]['series'])) && (dat[ordered[indi]]['series'] > 1)) ? parseInt(dat[ordered[indi]]['series'])+'x' : 'x';
                    fo = ((dat[ordered[indi]]['force'] !== undefined) && (isInt(dat[ordered[indi]]['force'])) && (dat[ordered[indi]]['force'] > 0)) ? parseInt(dat[ordered[indi]]['force']) : 0;
                    em = (ex != 0) ? am+'/'+se+fo : se+fo;
                    res += '@'+indi+' <'+ordered[indi]+'> ['+em+']\n';
                }
            }
        }
    } else {
        sortable = Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b]) => b - a)
        ); for (indi in sortable) {
            if ((sortable[indi] !== undefined) || (indi != '')) {
                res += '@'+indi+' ('+sortable[indi]+')\n';
            }
        }
    } return res;
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
    var host = repo = user = '';
    var uri = (query.includes('>')) ? query.split('>')[0] : query;
    var branch = (query.includes('>')) ? query.split('>')[1] : '';
    var prot = uri.split('://')[0], rest = uri.split('://')[1];
    var parts = rest.split('/'), prim = parts[0], prest = parts;
    if (parts.length > 2) {
        repo = parts[parts.length-1];
        prest.splice(0, 1);
        prest.splice((prest.length-1), 1);
        user = prest.join('/');
    } else if (parts.length == 2) {
        repo = parts[1]; user = '';
    } host = prot+'://'+prim;
    return res = [host, repo, branch, user];
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
    if (arr.indexOf('') > -1) {
        arr.splice(arr.indexOf(''), 1);
    } if (arr.indexOf(' ') > -1) {
        arr.splice(arr.indexOf(' '), 1);
    } if (arr.indexOf(item) > -1) {
        arr.splice(arr.indexOf(item), 1);
    } else {
        arr.push(item);
    } return finarr(arr).join(',');
}
function isInMenu(list, item) {
    var arr = list.toString('').split(',');
    return (arr.indexOf(item) > -1);
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
</script>
