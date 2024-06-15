<script>
function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('pitch_lock', sysDefPitchLock.value);
    setdata('video_volume', sysDefVideoVolume.value);
    setdata('video_speed', sysDefVideoSpeed.value);
    setdata('video_balance', sysDefVideoBalance.value);
}
function omniListen(input, scratch = false) {
    playAudio(audioPlayer, input);
    currentPos = parseInt(sysDefCurrent.value);
    audioPlayer.currentTime = (scratch) ? 0 : currentPos;
    setdata('melody', bin2hex(input));
    setdata('pitch_lock', sysDefPitchLock.value);
    setdata('audio_volume', sysDefAudioVolume.value);
    setdata('audio_speed', sysDefAudioSpeed.value);
    setdata('audio_balance', sysDefAudioBalance.value);
}
function songIndex() {
    var museArr = sysDefMusicBox.value;
    var museLint = museArr.split('//');
    omniListen(museLint[rand(0, museLint.length-1)], true);
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
function lockdata() {
    var obj = {
        <?php $iter = 0; foreach ($locks as $key=>$value) {
            if (count($locks) == ($iter - 1)) {
                echo "'".$key."': lock".camel($key).".value";
            } else {
                echo "'".$key."': lock".camel($key).".value,";
            } $iter++;
        } $iter = 0; ?>
    };
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
    };
    return obj;
}
function setlock(ent, val) {
    var obj = lockdata(); obj[ent] = val;
    set(sysDefSessionID.value+'_lock.json', JSON.stringify(obj), true);
    <?php foreach ($locks as $key=>$value) {
        echo "lock".camel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent, val) {
    var obj = userdata(); obj[ent] = val;
    set(sysDefSessionID.value+'_session.json', JSON.stringify(obj), true);
    <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".camel($key).".value = obj['".$key."'];";
    } ?>
    if (ent == 'audio_volume') {
        audioPlayer.volume = val;
    }
    if (ent == 'audio_balance') {
        audioPlayer.balance = val;
    }
    if (ent == 'audio_speed') {
        audioPlayer.playbackRate = val;
    }
    if (ent == 'pitch_lock') {
        audioPlayer.preservesPitch = (val != 0) ? true : false;
    }
    if (requestMode.value == 'media_player') {
        if (ent == 'video_volume') {
            video.volume = val;
        }
        if (ent == 'video_balance') {
            video.balance = val;
        }
        if (ent == 'video_speed') {
            video.playbackRate = val;
        }
        if (ent == 'pitch_lock') {
            video.preservesPitch = (val != 0) ? true : false;
        }
    }
}
function bind(usr, id) {
    var obj = arrjob(sysDefBindData.value,';',':');
    obj[usr] = id;
    set('binding.json', JSON.stringify(obj), true);
    sysDefBindData.value = arrpack(obj,';',':');
}
function automate() {
    var usr = sysDefSessionID.value;
    var obj = arrjob(sysDefAutoData.value,';',':');
    obj[usr] = (sysDefAutoState.value == 'auto') ? 'manual' : 'auto';
    set('automator.json', JSON.stringify(obj), true);
    sysDefAutoData.value = arrpack(obj,';',':');
}
function openBookKeep(id) {
    var users = sysDefBooksList.value;
    var books = sysDefBookKeepJSONs.value;
    var userArr = users.split(',');
    var userNum = arraySearch(id, userArr);
    return pager(books, userNum);
}
function openMsgBox(id) {
    var users = sysDefUsersList.value;
    var mail = sysDefMailingJSONs.value;
    var userArr = users.split(',');
    var userNum = arraySearch(id, userArr);
    return pager(mail, userNum);
}
function jsonstr(str) {
    var res = {};
    try {
        res = JSON.parse(str);
    } catch (e) {
        res = {};
    }
    return res;
}
function JSONFilter(str, mask) {
    var arr = jsonstr(str);
    var wordArr = mask.match(/(#\w*)/g);
    var arf = {};
    for (el in arr) {
        if (wordArr !== null) {
            for (i = 0; i < wordArr.length; i++) {
                if (arr[el].toLowerCase().includes(wordArr[i].replace('#', '').toLowerCase())) {
                    arf[el] = arr[el];
                }
            }
        }
    }
    return arf;
}
function JSONtoHTML(str, mask) {
    var arr = JSONFilter(str, mask);
    var ard = '';
    for (el in arr) {
        ard = el+'<br>'+arr[el]+'<br>'+ard;
    }
    return ard;
}
function clearBookKeep(date) {
    var msgarr = jsonstr(sysDefBookKeep.value);
    for (el in msgarr) {
        if (el.toLowerCase().includes(date.toLowerCase())) {
            delete msgarr[el];
        }
    }
    set('./.book/'+sysDefSessionID.value+'_book.json', encodeURIComponent(JSON.stringify(msgarr)), true);
}
function clearMessage(date) {
    var msgarr = jsonstr(sysDefMsgData.value);
    for (el in msgarr) {
        if (el.toLowerCase().includes(date.toLowerCase())) {
            if (sysDefSessionID.value == 'root') {
                if (sysDefPrivate.value != 0) {
                    delete msgarr[el];
                    set('./.log/'+sysDefSessionID.value+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
                } else {
                    delete msgarr[el];
                    set('./.log/msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
                }
            } else {
                if (sysDefPrivate.value != 0) {
                    delete msgarr[el];
                    set('./.log/'+sysDefSessionID.value+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
                }
            }
        }
    }
}
function isoformat(num) {
    var ob = new Date(num);
    return (ob.getUTCFullYear())+'-'+pad((ob.getUTCMonth()+1), 2)+'-'+pad((ob.getUTCDate()), 2)+' '+pad((ob.getUTCHours()), 2)+':'+pad((ob.getUTCMinutes()), 2)+':'+pad((ob.getUTCSeconds()), 2)+'.'+pad((ob.getUTCMilliseconds()), 3);
}
function compose(msg) {
    var addr = msg.match(/(@\w*)/g);
    var userID; var msgbox = ''; var msgbr = [];
    var ratTab = arrjob(sysDefPowersData.value, ';', ':');
    if (ratTab[sysDefSessionID.value] >= 0) {
        if (addr !== null) {
            for (i = 0; i < addr.length; i++) {
                userID = addr[i].replace('@', '');
                msgbox = openMsgBox(userID);
                msgarr = jsonstr(msgbox);
                if (msg.match(/\r?\n/) !== null) {
                    msgbr = msg.split(/\r?\n/);
                    for (j = 0; j < msgbr.length; j++) {
                        msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC'] = msgbr[j];
                    }
                } else {
                    msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC'] = msg;
                }
                set('./.log/'+userID+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            }
        } else {
            msgbox = sysDefMsgData.value;
            msgarr = jsonstr(msgbox);
            if (msg.match(/\r?\n/) !== null) {
                msgbr = msg.split(/\r?\n/);
                for (j = 0; j < msgbr.length; j++) {
                    msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC'] = msgbr[j];
                }
            } else {
                msgarr[sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC'] = msg;
            }
            if (sysDefPrivate.value != 0) {
                set('./.log/'+sysDefSessionID.value+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            } else {
                set('./.log/msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            }
        }
    }
}
function make_gift(user, sum = 0) {
    if (user != sysDefSessionID.value) {
        var obj = arrjob(sysDefPowersData.value,';',':');
        var est = (sum != 0) ? Math.abs(parseInt(sum)) : 1;
        if (obj[sysDefSessionID.value] >= est) {
            set(sysDefSessionID.value+'_gift_'+user, est, true);
            compose('FROM @'+sysDefSessionID.value+' TO @'+user+' GIFT +'+est);
        }
    }
}
function accept_gift(user) {
    if (user != sysDefSessionID.value) {
        var obj = arrjob(sysDefPowersData.value,';',':');
        var sum, prep, sp, op;
        var sp = obj[sysDefSessionID.value];
        var op = obj[user];
        var suf = (isInt(sp)) ? parseInt(sp) : 0;
        var obf = (isInt(op)) ? parseInt(op) : 0;
        if (obj[sysDefSessionID.value] >= 0) {
            var dataString = 'name='+user+'_gift_'+sysDefSessionID.value+'&type=number&sign=0&mode=';
            $.ajax({
                type: "POST",
                url: "read.php",
                data: dataString,
                cache: false,
                success: function(result) {
                    prep = miniPager(result, 0);
                    sum = (isInt(prep)) ? parseInt(prep) : 0;
                    fixPrice(sysDefSessionID.value, user, sum, 'ACCEPT');
                    del(user+'_gift_'+sysDefSessionID.value, true);
                }
            });
            return false;
        }
    }
}
function buy_item(user, pass, type = 'account') {
    if (user != sysDefSessionID.value) {
        var obj = arrjob(sysDefPowersData.value,';',':');
        if ((obj[sysDefSessionID.value] > 0) && (obj[user] > 0)) {
            var dataString = 'id='+user+'&to='+sysDefSessionID.value+'&pass='+encodeURIComponent(pass)+'&type='+type; var prep, sum;
            $.ajax({
                type: "POST",
                url: "point_of_sale.php",
                data: dataString,
                cache: false,
                success: function(result) {
                    prep = miniPager(result, 0);
                    if (isInt(prep)) {
                        fixPrice(sysDefSessionID.value, user, 'BUY '+type+' @'+user, parseInt(prep));
                    }
                }
            });
            return false;
        }
    }
}
function sell_item(user, pass, type = 'account') {
    if (user != sysDefSessionID.value) {
        var obj = arrjob(sysDefPowersData.value,';',':');
        if ((obj[sysDefSessionID.value] > 0) && (obj[user] > 0)) {
            set(sysDefSessionID.value+'_'+type+'_'+user, encodeURIComponent(pass), true);
            compose('FROM @'+sysDefSessionID.value+' TO @'+user+' KEY '+encodeURIComponent(pass));
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
function fixPrice(sen, rec, deb, cre) {
    var tran1 = openBookKeep(sen); var tran2 = openBookKeep(rec);
    var stat = arrjob(sysDefPowersData.value,';',':');
    var statD = (isInt(stat[sen])) ? parseInt(stat[sen]) : 0;
    var statC = (isInt(stat[rec])) ? parseInt(stat[rec]) : 0;
    var statDr = parseInt(statD); var statCr = parseInt(statC);
    if ((isInt(deb)) && !(isInt(cre))) {
        statD += parseInt(deb); statC -= parseInt(deb);
    } else if (!(isInt(deb)) && (isInt(cre))) {
        statD -= parseInt(cre); statC += parseInt(cre);
    }
    var statDt = (statDr + parseInt(deb) == statD) ? 'OK' : 'ERR';
    var statCt = (statCr + parseInt(deb) == statC) ? 'OK' : 'ERR';
    stat[sen] = parseInt(statD); stat[rec] = parseInt(statC);
    trans1 = jsonstr(tran1); trans2 = jsonstr(tran2);
    trans1[isoformat(Date.now())+' UTC'] = '@'+sen+' | @'+rec+' | '+deb+' | '+cre+' | '+statD+' | '+statDt;
    trans2[isoformat(Date.now())+' UTC'] = '@'+rec+' | @'+sen+' | '+cre+' | '+deb+' | '+statC+' | '+statCt;
    set('./.book/'+sen+'_book.json', encodeURIComponent(JSON.stringify(trans1)), true);
    set('./.book/'+rec+'_book.json', encodeURIComponent(JSON.stringify(trans2)), true);
    set('dominion.json', JSON.stringify(stat), true);
    sysDefPowersData.value = arrpack(stat,';',':');
}
function dominate(usr, id, q = 1, s = 2, n = 0, snd = false) {
    var max = parseInt(Math.abs(q));
    var min = parseInt(Math.abs(q)*-1);
    var obj = arrjob(sysDefPowersData.value,';',':');
    var res = ''; var suf = 0; var obf = 0; var f = 0;
    f = (isInt(q)) ? parseInt(Math.abs(q)) : 1;
    suf = (isInt(obj[usr])) ? parseInt(obj[usr]) : 0;
    obf = (isInt(obj[id])) ? parseInt(obj[id]) : 0;
    var sides = [];
    if ((usr != id) && (suf >= 0)) {
        for (i = 0; i < s; i++) {
            sides.push(rand(((n != 0) ? min : 0), max));
        }
        if (isAllZero(sides)) {
            if (obf <= -666) {
                delete_user(id);
            } else {
                fixPrice(usr, id, f, 'ATTACK');
            }
        }
    }
}
function unbind(id) {
    bind(id, id);
}
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
    del('./.log/'+id+'_msgbox.json', true);
    del('./.book/'+id+'_book.json', true);
}
function transfer_self(id, obj, name) {
    var objData = arrjob(obj.value,';',':');
    objData[id] = id;
    if (sysDefSessionID.value != id) {
        delete objData[sysDefSessionID.value];
    } set(name, JSON.stringify(objData), true);
    obj.value = arrpack(objData,';',':');
}
function transfer_entry(id, obj, name) {
    var objData = arrjob(obj.value,';',':');
    objData[id] = objData[sysDefSessionID.value];
    if (sysDefSessionID.value != id) {
        delete objData[sysDefSessionID.value];
    } set(name, JSON.stringify(objData), true);
    obj.value = arrpack(objData,';',':');
}
function rename_user(username, password) {
    unbind(sysDefSessionID.value);
    transfer_self(username, sysDefBindData, 'binding.json');
    transfer_entry(username, sysDefPowersData, 'dominion.json');
    transfer_entry(username, sysDefAutoData, 'automator.json');
    transfer_entry(username, sysDefFriendData, 'friendship.json');
    change(sysDefSessionID.value, username, CryptoJS.MD5(password).toString(), true);
    move('./'+sysDefSessionID.value+'_lock.json', './'+username+'_lock.json', true, 1);
    move('./'+sysDefSessionID.value+'_lock.json.bak', './'+username+'_lock.json.bak', true, 1);
    move('./.log/'+sysDefSessionID.value+'_msgbox.json', './.log/'+username+'_msgbox.json', true, 1);
    move('./.book/'+sysDefSessionID.value+'_book.json', './.book/'+username+'_book.json', true, 1);
}
function init_user(id, au = 'manual') {
    var bd = arrjob(sysDefBindData.value,';',':');
    var pd = arrjob(sysDefPowersData.value,';',':');
    var ad = arrjob(sysDefAutoData.value,';',':');
    var fd = arrjob(sysDefFriendData.value,';',':');
    var usl = (sysDefUsersList.value).split(',');
    var bkl = (sysDefBooksList.value).split(',');
    if (usl.indexOf(id) <= -1) {
        set('./.log/'+id+'_msgbox.json', '{}', true);
    }
    if (bkl.indexOf(id) <= -1) {
        set('./.book/'+id+'_book.json', '{}', true);
    }
    if (!(id in bd)) {
        bd[id] = id;
        set('binding.json', JSON.stringify(bd), true);
        sysDefBindData.value = arrpack(bd,';',':');
    }
    if (!(id in pd)) {
        pd[id] = 0;
        set('dominion.json', JSON.stringify(pd), true);
        sysDefPowersData.value = arrpack(pd,';',':');
    }
    if (!(id in ad)) {
        ad[id] = au;
        set('automator.json', JSON.stringify(ad), true);
        sysDefAutoData.value = arrpack(ad,';',':');
    }
    if (!(id in fd)) {
        fd[id] = '';
        set('friendship.json', JSON.stringify(fd), true);
        sysDefFriendData.value = arrpack(fd,';',':');
    }
}
function friendsOf(obj, id) {
    var res = [];
    if (obj[id] !== undefined) {
        if (obj[id].includes(',')) {
            res = obj[id].split(',');
        } else {
            res = [obj[id]];
        }
    } else {
        res = [];
    }
    return res;
}
function isFriends(id) {
    var usr = sysDefSessionID.value;
    var fr = arrjob(sysDefFriendData.value,';',':');
    var frnd = friendsOf(fr, usr);
    var res = false;
    if (id != usr) {
        if (frnd.indexOf(id) > -1) {
            res = true;
        }
    }
    return res;
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
        }
        fr[usr] = finarr(frnd).sort().join(',');
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
        }
        fr[usr] = finarr(frnd).sort().join(',');
        set('friendship.json', JSON.stringify(fr), true);
        sysDefFriendData.value = arrpack(fr,';',':');
    }
}
function scores(sta) {
    var sto = ['bind', 'auto', 'friend'];
    var arr = (arraySearch(sta, sto) !== false) ? document.getElementById('sysDef'+ucfirst(sta)+'Data').value : document.getElementById('sysDefPowersData').value;
    var obj = arrjob(arr, ';', ':');
    var keys = Object.keys(obj);
    var vals = Object.values(obj);
    var res = ''; var sortable = {}; var ordered = {};
    if (sta == 'bind') {
        ordered = Object.keys(obj).sort().reduce(
            (obd, key) => { 
                obd[key] = obj[key]; 
                return obd;
            }, {}
        );
        for (indi in ordered) {
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
        );
        for (indi in ordered) {
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
        );
        for (indi in ordered) {
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
        );
        for (indi in sortable) {
            if ((sortable[indi] !== undefined) || (indi != '')) {
                res += '@'+indi+' ('+sortable[indi]+')\n';
            }
        }
    }
    return res;
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
    }
    if (arr.indexOf(' ') > -1) {
        arr.splice(arr.indexOf(' '), 1);
    }
    if (arr.indexOf(item) > -1) {
        arr.splice(arr.indexOf(item), 1);
    } else {
        arr.push(item);
    }
    return finarr(arr).join(',');
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
</script>
