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
    setdata('melody', bin2hex(input));
    setdata('pitch_lock', sysDefPitchLock.value);
    setdata('audio_volume', sysDefAudioVolume.value);
    setdata('audio_speed', sysDefAudioSpeed.value);
}
function songIndex(mode = '') {
    var museArr = sysDefMusicBox.value;
    var museLint = museArr.split('//');
    var museMelo = hex2bin(sysDefMelody.value);
    var museInd = arraySearch(((museMelo.startsWith(requestPath.value+'/')) ? museMelo.replace(requestPath.value+'/','') : museMelo), museLint);
    if (mode == 'next') {
        omniListen((((museInd >= (museLint.length-1)) || (museInd === false)) ? museLint[0] : museLint[parseInt(museInd)+1]), true);
    } else if (mode == 'prev') {
        omniListen((((museInd <= 0) || (museInd === false)) ? museLint[museLint.length-1] : museLint[parseInt(museInd)-1]), true);
    } else if (mode == 'random') {
        omniListen(museLint[rand(0, museLint.length)], true);
    } else {
        omniListen(museMelo, true);
    }
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
function arrangePlay() {
    var dp = arrjob(sysDefPowersData.value,';',':');
    var db = arrjob(sysDefBindData.value,';',':');
    var da = arrjob(sysDefAutoData.value,';',':');
    sysDefAutoState.value = da[sysDefSessionID.value];
    $('#buttonAutomator').attr('src', sysDefPrefix.value+((sysDefAutoState.value == 'auto')?'wheel.png':'steer.png')+sysDefSuffix.value);
    var my = dp[sysDefSessionID.value]; var th, jh, bl, pl;
    if (my <= -666) {
        delete_user(sysDefSessionID.value);
        omniAuthRequest('signout', '', '');
    } if (arraySearch(sysDefSessionID.value, db) != false) {
        jh = dp[arraySearch(sysDefSessionID.value, db)];
        if (db[sysDefSessionID.value] != sysDefSessionID.value) {
            th = dp[db[sysDefSessionID.value]];
            bl = (jh != th) ? jh+'?'+my+':'+th : jh+'?'+my;
            pl = '+@'+sysDefSessionID.value+'+';
            $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
        } else {
            th = dp[sysDefSessionID.value];
            bl = jh+'?'+my;
            pl = '+@'+sysDefSessionID.value;
            $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
        }
    } else {
        if (db[sysDefSessionID.value] != sysDefSessionID.value) {
            th = dp[db[sysDefSessionID.value]]; bl = my+':'+th;
            pl = '@'+sysDefSessionID.value+'+';
            $('#buttonBroke').attr('src', sysDefPrefix.value+'broke.png'+sysDefSuffix.value);
        } else {
            th = dp[sysDefSessionID.value]; bl = my;
            pl = '@'+sysDefSessionID.value;
            $('#buttonBroke').attr('src', sysDefPrefix.value+'chain.png'+sysDefSuffix.value);
        }
    } $('#showUsInfoPower').val(bl); $('#showUsInfoBond').val(pl);
}
function lockdata() {
    var obj = {
        <?php $iter = 0; foreach ($locks as $key=>$value) {
            if (count($locks) == ($iter - 1)) {
                echo "'".$key."': lock".camel($key).".value";
            } else {
                echo "'".$key."': lock".camel($key).".value,";
            } $iter++;
        } $iter = 0; ?>
    }; return obj;
}
function metadata() {
    var obj = jsonstr(sysDefMetaData.value);
    return obj;
}
function userdata() {
    var obj = {
        <?php $iter = 0; foreach ($settings['defaults'] as $key=>$value) {
            if (count($settings['defaults']) == ($iter - 1)) {
                echo "'".$key."': sysDef".camel($key).".value";
            } else {
                echo "'".$key."': sysDef".camel($key).".value,";
            } $iter++;
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
    } ?>
    if (ent == 'audio_volume') { audioPlayer.volume = val; }
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
function automate() {
    var usr = sysDefSessionID.value;
    var obj = arrjob(sysDefAutoData.value,';',':');
    obj[usr] = (sysDefAutoState.value == 'auto') ? 'manual' : 'auto';
    set('automator.json', JSON.stringify(obj), true);
    sysDefAutoData.value = arrpack(obj,';',':');
}
function jsonstr(str) {
    var res = {};
    try { res = JSON.parse(str);
    } catch (e) { res = {}; }
    return res;
}
function jsonFilter(str, mask) {
    var arr = jsonstr(str), arf = {}, sym = '#'; uni = 'L';
    if (mask == sym) {
        for (el in arr) {
            arf[el] = hex2bin(arr[el], obfstr(CryptoJS.SHA256(sysDefSessionID.value).toString()), openJournal(sysDefSessionID.value, sysDefUsersList, sysDefUserHexes, true));
        }
    } else {
        var arrRegex = XRegExp('(\\'+sym+'\\p{'+uni+'}+)', 'g');
        var repRegex = XRegExp('(\\'+sym+'+)', 'g');
        var wordArr = XRegExp.match(mask, arrRegex);
        var hbin = ''; var hbio = {}; for (el in arr) {
            if (wordArr !== null) {
                for (iy in wordArr) {
                    hbin = hex2bin(arr[el], obfstr(CryptoJS.SHA256(sysDefSessionID.value).toString()), openJournal(sysDefSessionID.value, sysDefUsersList, sysDefUserHexes, true));
                    hbio = XRegExp.replace(wordArr[iy], repRegex, '');
                    if (hbin.toLowerCase().includes(hbio.toLowerCase())) { arf[el] = hbin; }
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
function jsonStore(id) {
    var arr = jsonstr(openJournal(id, sysDefStoreList, sysDefStoreJSONs)), ard = '', arl = '', eld = {}, fuc = '';
    for (el in arr) {
        if ((arr[el] !== undefined) && (typeof(arr[el]) == 'object')) {
            eld = arr[el];
            fuc = "<a href='javascript:buy_item(&#34;"+el+"&#34;,&#34;"+id+"&#34;);'>"; arl = '<tr>';
            arl += '<td>'+((id != sysDefSessionID.value) ? fuc+el+'</a>' : el)+'</td><td>'+hex2bin(eld['name'])+'</td><td>'+eld['type']+'</td><td>'+eld['price']+'</td>'; ard = arl+'</tr>'+ard;
        }
    } return ard;
}
function jsonBookKeep(str, wed) {
    var arr = jsonstr(str), ard = '', arl = '';
    var eld = [], dem, der; for (el in arr) {
        eld = arr[el].split(' | ');
        dem = Date.parse(el); der = (new Date(dem)).getDay();
        arl = (eld[5] == 'ERR') ? '<tr style="text-decoration:line-through;"><td>'+wed[der]+'</td>' : '<tr><td>'+wed[der]+'</td>';
        arl += '<td>'+eld[0]+'</td>'; arl += '<td>'+eld[1]+'</td>';
        arl += '<td>'+eld[2]+'</td>'; arl += '<td>'+eld[3]+'</td>';
        arl += '<td>'+eld[4]+'</td>'; ard = arl+'</tr>'+ard;
    } return ard;
}
function notesListDisp(str) {
    var arr = str.split(' | ');
    var ard = '', arl = '', eld = '', elt = '', eln = '';
    var epr = sysDefPrefix.value, esu = sysDefSuffix.value;
    for (el in arr) {
        eld = arr[el]; eln = sysDefNumeric.value;
        elt = hex2bin(eld,'',eln);
        arl = "<input type='button' style='width:80%;' onclick='openNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);' value='"+elt+"'>";
        arl += "<input type='image' class='power' src='"+epr+"delete.png"+esu+"' onclick='deleteNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);'>";
        ard = ard+arl+'<br>';
    } return ard;
}
function openJournal(id, ob, oj, cr = false) {
    var users = ob.value, jours = (cr) ? CryptoJS.enc.Utf8.stringify(CryptoJS.enc.Base64.parse(oj.value)) : oj.value, userArr = users.split(',');
    var userNum = arraySearch(id, userArr);
    return (cr) ? jours.split(' ')[userNum] : pager(jours, userNum);
}
function clearJournal(num, obj, kw) {
    var msgarr = jsonstr(obj.value);
    var ary = [], nur = Math.abs(num);
    var las = Object.keys(msgarr).length - 1;
    var ras = (las - nur); if (isInt(num)) {
        if (num < 0) {
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
        for (ek in msgarr) {
            if (msgarr[ek] !== undefined) { delete msgarr[ek]; }
        }
    } set('./.'+kw+'/'+sysDefSessionID.value+'_'+kw+'.json', encodeURIComponent(JSON.stringify(msgarr)), true);
}
function isoformat(num) {
    var ob = new Date(num);
    return (ob.getUTCFullYear())+'-'+pad((ob.getUTCMonth()+1), 2)+'-'+pad((ob.getUTCDate()), 2)+' '+pad((ob.getUTCHours()), 2)+':'+pad((ob.getUTCMinutes()), 2)+':'+pad((ob.getUTCSeconds()), 2)+'.'+pad((ob.getUTCMilliseconds()), 3);
}
function compose(msg) {
    var addr = (msg !== undefined) ? msg.match(/(@\w*)/g) : '';
    var userID; var msgbox = ''; var msgbr = [];
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
                        msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC'] = bin2hex(msgbr[j], obfstr(CryptoJS.SHA256(userID).toString()), openJournal(userID, sysDefUsersList, sysDefUserHexes, true));
                    }
                } else {
                    msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC'] = bin2hex(msg, obfstr(CryptoJS.SHA256(userID).toString()), openJournal(userID, sysDefUsersList, sysDefUserHexes, true));
                } set('./.msgbox/'+userID+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            }
        } else {
            msgbox = sysDefMsgData.value; msgarr = jsonstr(msgbox);
            if (msg.match(/\r?\n/) !== null) {
                msgbr = msg.split(/\r?\n/);
                for (j = 0; j < msgbr.length; j++) {
                    msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC'] = bin2hex(msgbr[j], obfstr(CryptoJS.SHA256(sysDefSessionID.value).toString()), openJournal(sysDefSessionID.value, sysDefUsersList, sysDefUserHexes, true));
                }
            } else {
                msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC'] = bin2hex(msg, obfstr(CryptoJS.SHA256(sysDefSessionID.value).toString()), openJournal(sysDefSessionID.value, sysDefUsersList, sysDefUserHexes, true));
            } if (sysDefPrivate.value != 0) {
                set('./.msgbox/'+sysDefSessionID.value+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            } else {
                set('./.msgbox/msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            }
        }
    }
}
function buy_item(art, sel) {
    var bye = sysDefSessionID.value;
    if (sel != bye) {
        var tabS = jsonstr(openJournal(sel, sysDefStoreList, sysDefStoreJSONs));
        var tabB = jsonstr(openJournal(bye, sysDefStoreList, sysDefStoreJSONs));
        var itemS = {}, prix, pass, itemB = {};
        var obj = arrjob(sysDefPowersData.value,';',':');
        if ((obj[bye] >= 0) && (obj[sel] >= 0)) {
            if ((tabS[art] !== undefined) && (typeof(tabS[art]) == 'object')) {
                itemS = tabS[art];
                if ((isInt(itemS['price'])) && (!isInt(art))) {
                    prix = parseInt(itemS['price']);
                    pass = ((itemS['type'] == 'account') || (itemS['type'] == 'password')) ? itemS['password'] : '';
                    if (obj[bye] >= prix) {
                        fixPrice(bye, sel, art, prix);
                        delete tabS[art]; tabB[art] = itemS;
                        set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                        set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                        if (itemS['type'] == 'account') {
                            copy(sel+'_session.json.bak', bye+'_session.json.bak', true, 1);
                            copy(sel+'_session.json', bye+'_session.json', true, 1);
                            change(bye, bye, pass, true);
                            omniAuthRequest('signin', bye, pass);
                        } else if (itemS['type'] == 'password') {
                            change(sel, sel, pass, true);
                            omniAuthRequest('signin', sel, pass);
                        }
                    }
                } else if ((!isInt(itemS['price'])) && (!isInt(art))) {
                    if ((tabB[itemS['price']] !== undefined) && (typeof(tabB[itemS['price']]) == 'object')) {
                        itemB = tabB[itemS['price']];
                        prix = itemS['price'];
                        fixPrice(bye, sel, art, prix);
                        delete tabS[art]; tabB[art] = itemS;
                        delete tabB[prix]; tabS[prix] = itemB;
                        set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                        set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                    }
                } else if ((!isInt(itemS['price'])) && (isInt(art))) {
                    if ((itemS['price'] == '')) {
                        prix = itemS['price'];
                        fixPrice(bye, sel, art, prix);
                        delete tabS[art];
                        set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                        set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                    }
                }
            }
        }
    }
}
function sell_item(typ, art, ttl, prix = '', pass = '') {
    var tabS = jsonstr(openJournal(sysDefSessionID.value, sysDefStoreList, sysDefStoreJSONs)); var tab = {};
    var obj = arrjob(sysDefPowersData.value,';',':');
    if (obj[sysDefSessionID.value] >= 0) {
        tabS[art] = { "name": bin2hex(ttl), "type": typ, "price": prix };
        if ((typ == 'account') || (typ == 'password')) {
            tabS[art]['password'] = CryptoJS.SHA256(pass).toString();
        } set('./.store/'+sysDefSessionID.value+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
    }
}
function del_item(art) {
    var tabS = jsonstr(openJournal(sysDefSessionID.value, sysDefStoreList, sysDefStoreJSONs)); var tab = {};
    var obj = arrjob(sysDefPowersData.value,';',':');
    if (obj[sysDefSessionID.value] >= 0) {
        if (tabS[art] !== undefined) {
            delete tabS[art];
        } set('./.store/'+sysDefSessionID.value+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
    }
}
function isAllZero(arr) {
    for (i = 0; i < arr.length; i++) {
        if ((arr[i] != 0) && (isInt(arr[i]))) { return false; break; }
    } return true;
}
function fixPrice(sen, rec, deb, cre) {
    var tran1 = openJournal(sen, sysDefBooksList, sysDefBookKeepJSONs);
    var tran2 = openJournal(rec, sysDefBooksList, sysDefBookKeepJSONs);
    var trans1 = jsonstr(tran1); var trans2 = jsonstr(tran2);
    var stat = arrjob(sysDefPowersData.value,';',':');
    var statD = (isInt(stat[sen])) ? parseInt(stat[sen]) : 0;
    var statC = (isInt(stat[rec])) ? parseInt(stat[rec]) : 0;
    var statDr = parseInt(statD); var statCr = parseInt(statC);
    var lsTr1, lsTr2, bal1, bal2;
    if (tran1 == '{}') {
        bal1 = statDr;
    } else {
        lsTr1 = trans1[Object.keys(trans1)[Object.keys(trans1).length - 1]];
        bal1 = lsTr1.split(' | ')[4];
    } if (tran2 == '{}') {
        bal2 = statCr;
    } else {
        lsTr2 = trans2[Object.keys(trans2)[Object.keys(trans2).length - 1]];
        bal2 = lsTr2.split(' | ')[4];
    } var statDt, statCt, statK, statV, statDi, statCi, statDn, statCn, statT;
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
    trans1[isoformat(Date.now())+' UTC'] = (statDi < parseInt(bal1)) ? '@'+sen+' | @'+rec+' | '+statT+' | '+statDn+' | '+statDi+' | '+statDt : '@'+sen+' | @'+rec+' | '+statDn+' | '+statT+' | '+statDi+' | '+statDt;
    trans2[isoformat(Date.now())+' UTC'] = (statCi < parseInt(bal2)) ? '@'+rec+' | @'+sen+' | '+statT+' | '+statCn+' | '+statCi+' | '+statCt : '@'+rec+' | @'+sen+' | '+statCn+' | '+statT+' | '+statCi+' | '+statCt;
    if (!isInt(deb) && !isInt(cre)) {
        trans1[isoformat(Date.now())+' UTC'] = '@'+sen+' | @'+rec+' | '+statT+' | '+statK+' | '+statDi+' | '+statDt;
        trans2[isoformat(Date.now())+' UTC'] = '@'+rec+' | @'+sen+' | '+statK+' | '+statT+' | '+statCi+' | '+statCt;
    } set('./.book/'+sen+'_book.json', encodeURIComponent(JSON.stringify(trans1)), true);
    set('./.book/'+rec+'_book.json', encodeURIComponent(JSON.stringify(trans2)), true);
    set('dominion.json', JSON.stringify(stat), true);
    sysDefPowersData.value = arrpack(stat,';',':');
}
function dominate(usr, id, q = 1, s = 1, n = 0, snd = false) {
    var max = parseInt(Math.abs(q));
    var min = parseInt(Math.abs(q)*-1);
    var obj = arrjob(sysDefPowersData.value,';',':');
    var f = (isInt(q)) ? parseInt(Math.abs(q)) : 1;
    var suf = (isInt(obj[usr])) ? parseInt(obj[usr]) : 0;
    var obf = (isInt(obj[id])) ? parseInt(obj[id]) : 0;
    var sides = []; if ((usr != id) && (suf >= 0)) {
        for (i = 0; i < s; i++) {
            sides.push(rand(((n != 0) ? min : 0), max));
        } if (isAllZero(sides)) {
            if (obf <= -666) {
                delete_user(id);
            } else {
                suf = suf + f; obf = obf - f;
                obj[usr] = suf; obj[id] = obf;
                set('dominion.json', JSON.stringify(obj), true);
                sysDefPowersData.value = arrpack(obj,';',':');
            }
        }
    }
}
function unbind(id) { bind(id, id); }
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
    } set(name, JSON.stringify(objData), true);
    obj.value = arrpack(objData,';',':');
}
function rename_user(username, password) {
    unbind(sysDefSessionID.value);
    change(sysDefSessionID.value, username, CryptoJS.SHA256(password).toString(), true);
    if (sysDefSessionID.value != username) {
        transfer_entry(username, sysDefBindData, 'binding.json', true);
        transfer_entry(username, sysDefPowersData, 'dominion.json');
        transfer_entry(username, sysDefAutoData, 'automator.json');
        transfer_entry(username, sysDefFriendData, 'friendship.json');
        delete_user(sysDefSessionID.value);
    }
}
function init_user(id, au = 'manual') {
    var bd = arrjob(sysDefBindData.value,';',':');
    var pd = arrjob(sysDefPowersData.value,';',':');
    var ad = arrjob(sysDefAutoData.value,';',':');
    var fd = arrjob(sysDefFriendData.value,';',':');
    var usl = (sysDefUsersList.value).split(',');
    var bkl = (sysDefBooksList.value).split(',');
    var stl = (sysDefStoreList.value).split(',');
    if (usl.indexOf(id) <= -1) {
        set('./.msgbox/'+id+'_msgbox.json', '{}', true);
    } if (bkl.indexOf(id) <= -1) {
        set('./.book/'+id+'_book.json', '{}', true);
    } if (stl.indexOf(id) <= -1) {
        set('./.store/'+id+'_store.json', '{}', true);
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
function scores(sta) {
    var sto = ['bind', 'auto', 'friend'];
    var arr = (arraySearch(sta, sto) !== false) ? document.getElementById('sysDef'+ucfirst(sta)+'Data').value : document.getElementById('sysDefPowersData').value; var obj = arrjob(arr, ';', ':');
    var keys = Object.keys(obj); var vals = Object.values(obj);
    var res = ''; var sortable = {}; var ordered = {};
    if (sta == 'bind') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { 
                obd[key] = obj[key]; 
                return obd;
            }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] != indi) {
                    res += '@'+indi+' :: @'+ordered[indi]+'\n';
                } else {
                    res += '@'+indi+' :: SELF\n';
                }
            }
        }
    } else if (sta == 'auto') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { 
                obd[key] = obj[key]; 
                return obd;
            }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] == 'auto') {
                    res += '@'+indi+' AUTO\n';
                } else {
                    res += '@'+indi+' MANUAL\n';
                }
            }
        }
    } else if (sta == 'friend') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { 
                obd[key] = obj[key]; 
                return obd;
            }, {}
        ); for (indi in ordered) {
            if ((ordered[indi] !== undefined) || (indi != '')) {
                if (ordered[indi] != '') {
                    res += '@'+indi+' ['+ordered[indi]+']\n';
                } else {
                    res += '@'+indi+' [NULL]\n';
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
function applyTheme(sizes = '7 0 180 14 14 14 17 16 15 18 14 14 14', colors = 'C0BFC0|605F60|E5E5E5|FFFFFF|FFFFFF|000000|FFFFFF|000000|403F40|D5D5D5') {
    var t4size = sizes.toString('').split(' ');
    var t4color = colors.toString('').split('|');
    if (t4size[0].includes('i')) {
        setdata('radius', t4size[t4size[0].replace('i','')]);
    } else if (t4size[0].includes('x')) {
        setdata('radius', sysDefRadius.value);
    } else {
        setdata('radius', t4size[0]);
    } if (t4size[1].includes('i')) {
        setdata('box_shadow', t4size[t4size[1].replace('i','')]);
    } else if (t4size[1].includes('x')) {
        setdata('box_shadow', sysDefBoxShadow.value);
    } else {
        setdata('box_shadow', t4size[1]);
    } if (t4size[2].includes('i')) {
        setdata('gradient_deg', t4size[t4size[2].replace('i','')]);
    } else if (t4size[2].includes('x')) {
        setdata('gradient_deg', sysDefGradientDeg.value);
    } else {
        setdata('gradient_deg', t4size[2]);
    } if (t4size[3].includes('i')) {
        setdata('back_size', t4size[t4size[3].replace('i','')]);
    } else if (t4size[3].includes('x')) {
        setdata('back_size', sysDefBackSize.value);
    } else {
        setdata('back_size', t4size[3]);
    } if (t4size[4].includes('i')) {
        setdata('fore_size', t4size[t4size[4].replace('i','')]);
    } else if (t4size[4].includes('x')) {
        setdata('fore_size', sysDefForeSize.value);
    } else {
        setdata('fore_size', t4size[4]);
    } if (t4size[5].includes('i')) {
        setdata('input_size', t4size[t4size[5].replace('i','')]);
    } else if (t4size[5].includes('x')) {
        setdata('input_size', sysDefInputSize.value);
    } else {
        setdata('input_size', t4size[5]);
    } if (t4size[6].includes('i')) {
        setdata('head1_size', t4size[t4size[6].replace('i','')]);
    } else if (t4size[6].includes('x')) {
        setdata('head1_size', sysDefHead1Size.value);
    } else {
        setdata('head1_size', t4size[6]);
    } if (t4size[7].includes('i')) {
        setdata('head2_size', t4size[t4size[7].replace('i','')]);
    } else if (t4size[7].includes('x')) {
        setdata('head2_size', sysDefHead2Size.value);
    } else {
        setdata('head2_size', t4size[7]);
    } if (t4size[8].includes('i')) {
        setdata('head3_size', t4size[t4size[8].replace('i','')]);
    } else if (t4size[8].includes('x')) {
        setdata('head3_size', sysDefHead3Size.value);
    } else {
        setdata('head3_size', t4size[8]);
    } if (t4size[9].includes('i')) {
        setdata('disp_size', t4size[t4size[9].replace('i','')]);
    } else if (t4size[9].includes('x')) {
        setdata('disp_size', sysDefDispSize.value);
    } else {
        setdata('disp_size', t4size[9]);
    } if (t4size[10].includes('i')) {
        setdata('priv1_size', t4size[t4size[10].replace('i','')]);
    } else if (t4size[10].includes('x')) {
        setdata('priv1_size', sysDefPriv1Size.value);
    } else {
        setdata('priv1_size', t4size[10]);
    } if (t4size[11].includes('i')) {
        setdata('priv2_size', t4size[t4size[11].replace('i','')]);
    } else if (t4size[11].includes('x')) {
        setdata('priv2_size', sysDefPriv2Size.value);
    } else {
        setdata('priv2_size', t4size[11]);
    } if (t4size[12].includes('i')) {
        setdata('priv3_size', t4size[t4size[12].replace('i','')]);
    } else if (t4size[12].includes('x')) {
        setdata('priv3_size', sysDefPriv3Size.value);
    } else {
        setdata('priv3_size', t4size[12]);
    } if (t4color[0].includes('i')) {
        setdata('back_color', t4color[t4color[0].replace('i','')]);
    } else if (t4color[0].includes('x')) {
        setdata('back_color', sysDefBackColor.value);
    } else {
        setdata('back_color', t4color[0]);
    } if (t4color[1].includes('i')) {
        setdata('fore_color', t4color[t4color[1].replace('i','')]);
    } else if (t4color[1].includes('x')) {
        setdata('fore_color', sysDefForeColor.value);
    } else {
        setdata('fore_color', t4color[1]);
    } if (t4color[2].includes('i')) {
        setdata('input_color', t4color[t4color[2].replace('i','')]);
    } else if (t4color[2].includes('x')) {
        setdata('input_color', sysDefInputColor.value);
    } else {
        setdata('input_color', t4color[2]);
    } if (t4color[3].includes('i')) {
        setdata('back_text_color', t4color[t4color[3].replace('i','')]);
    } else if (t4color[3].includes('x')) {
        setdata('back_text_color', sysDefBackTextColor.value);
    } else {
        setdata('back_text_color', t4color[3]);
    } if (t4color[4].includes('i')) {
        setdata('fore_text_color', t4color[t4color[4].replace('i','')]);
    } else if (t4color[4].includes('x')) {
        setdata('fore_text_color', sysDefForeTextColor.value);
    } else {
        setdata('fore_text_color', t4color[4]);
    } if (t4color[5].includes('i')) {
        setdata('input_text_color', t4color[t4color[5].replace('i','')]);
    } else if (t4color[5].includes('x')) {
        setdata('input_text_color', sysDefInputTextColor.value);
    } else {
        setdata('input_text_color', t4color[5]);
    } if (t4color[6].includes('i')) {
        setdata('blank_color', t4color[t4color[6].replace('i','')]);
    } else if (t4color[6].includes('x')) {
        setdata('blank_color', sysDefBlankColor.value);
    } else {
        setdata('blank_color', t4color[6]);
    } if (t4color[7].includes('i')) {
        setdata('blank_text_color', t4color[t4color[7].replace('i','')]);
    } else if (t4color[7].includes('x')) {
        setdata('blank_text_color', sysDefBlankTextColor.value);
    } else {
        setdata('blank_text_color', t4color[7]);
    } if (t4color[8].includes('i')) {
        setdata('arc_fore_color', t4color[t4color[8].replace('i','')]);
    } else if (t4color[8].includes('x')) {
        setdata('arc_fore_color', sysDefArcForeColor.value);
    } else {
        setdata('arc_fore_color', t4color[8]);
    } if (t4color[9].includes('i')) {
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
</script>
