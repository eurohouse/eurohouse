function executeMacros(input, index = 0, length = 1) {
    var output = input, rep, san, atr, atd, atx, plu, np, inc, np1, np2, ml, mr;
    if ((index == (length - 1)) && (input == '_')) {
        omniBack(sysDefParent.value);
    } else if ((index == (length - 1)) && (input == '\\=')) {
        output = '\\='+dtw(userdata()['melody'], sysDefSessionID.value, 'あいうえおかがきぎぐけげこごさざしじすずせぜそぞただちぢづてでとどなにぬねのはばぱひびぴふぶぷべぺほぼぽまみむめもやゆよらりるれろわゐゑをんゔゟ');
    } else if ((index == (length - 1)) && (input == '&')) {
        unbind(sysDefSessionID.value);
    } else if ((index == (length - 1)) && (input == '$')) {
        unequip(sysDefSessionID.value);
    } else if ((input.includes('# ')) && (input.indexOf('# ') == 0)) {
        // YOUR COMMENTS HERE...
    } else if ((input.includes('>')) && (input.indexOf('>') == 0)) {
        var rep = input.replace('>', '');
        if ((rep == 'auto') || (rep == 'manual')) {
            administer('auto', rep, 'automator');
        } else if ((rep == 'bind') || (rep == 'call')) {
            administer(rep, rep, rep+'ing');
        } else if ((rep == 'null') || (rep == 'empty')) {
            administer('friend', rep, 'friendship');
        } else {
            administer('powers', rep, 'dominion');
        }
    } else if ((index == (length - 1)) && (input.includes('\\=')) && (input.startsWith('\\='))) {
        omniListen(input.replace('\\=', ''), true);
    } else if ((index == (length - 1)) && (input.includes("\\")) && (input.startsWith('\\'))) {
        np = input.replace("\\", ''), inc = 0, ml = lockarr('music'), mr = [];
        np1 = (np.includes(':')) ? np.split(':')[0] : np;
        np2 = (np.includes(':')) ? np.split(':')[1] : 0;
        for (i = 0; i < ml.length; i++) {
            if (ml[i].toLowerCase().includes(np1.toLowerCase())) {
                mr.push(ml[i]);
            }
        }
        for (i = 0; i < ml.length; i++) {
            if (ml[i].toLowerCase().includes(np1.toLowerCase())) {
                if (isInt(np2)) {
                    if (inc >= np2) {
                        omniListen(ml[i], true); break;
                    }
                } else if (np2 == '*') {
                    omniListen(mr[rand(0, mr.length)]); break;
                } inc++;
            } omniPause();
        }
    } else if ((index == (length - 1)) && (input.includes('./')) && (input.startsWith('./'))) {
        omniRead(requestMode.value, input.replace('./', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('/')) && (input.startsWith('/'))) {
        omniPathDir(input.replace('/', ''), requestMode.value);
    } else if ((index == (length - 1)) && (input.includes('*'))) {
        omniDisp(requestMode.value, input.replace('*', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('@'))) {
        atr = input.split('@'), atd, atx;
        if (atr[0].includes(':')) {
            atd = atr[0].split(':'); atx = CryptoJS.SHA256(atd[1]).toString(); if (atr[1].includes('signin')) {
                omniAuthRequest('signin', atd[0], atx);
            } else if (atr[1].includes('signup')) {
                omniAuthRequest('signup', atd[0], atx);
            } else if (atr[1].includes('rename')) {
                rename_user(atd[0], atd[1]); omniAuthRequest('signin', atd[0], atx);
            }
        } else {
            atx = CryptoJS.SHA256('').toString(); if (atr[1].includes('signin')) {
                omniAuthRequest('signin', atr[0], atx);
            } else if (atr[1].includes('signup')) {
                omniAuthRequest('signup', atr[0], atx);
            } else if (atr[1].includes('rename')) {
                rename_user(atr[0], ''); omniAuthRequest('signin', atr[0], atx);
            }
        }
    } else if ((index == (length - 1)) && (input.includes('--')) && (input.startsWith('--'))) {
        omniSort(input.replace('--',''));
    } else if ((index == (length - 1)) && (input.includes('->')) && (input.startsWith('->'))) {
        omniSwitch(input.replace('->',''));
    } else if ((index == (length - 1)) && (input.includes('#')) && (input.startsWith('#'))) {
        setdata('find', input);
    } else if ((index == (length - 1)) && (input.includes('&')) && (input.startsWith('&'))) {
        bind(sysDefSessionID.value, input.replace('&', ''));
    } else if ((index == (length - 1)) && (input.includes('$')) && (input.startsWith('$'))) {
        equip(sysDefSessionID.value, input.replace('$', ''));
    } else if ((index == (length - 1)) && (input.includes('~')) && (input.startsWith('~'))) {
        if (sysDefSessionID.value == 'root') {
            delete_user(input.replace('~', ''));
        } else {
            if (input.replace('~', '') == sysDefSessionID.value) {
                delete_user(input.replace('~', ''));
                omniAuthRequest('signout','','');
            }
        }
    } else if (input.includes(': ')) {
        rep = input.split(': '); if (rep[0] == 'memo') {
            if ((rep[1].includes('h')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', '').replace('h', '')) * 3600; setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
            } else if ((rep[1].includes('min')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', '').replace('min', '')) * 60;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
            } else if ((rep[1].includes('m')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', '').replace('m', '')) * 60;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
            } else if ((rep[1].includes('sec')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', '').replace('sec', ''));
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
            } else if ((rep[1].includes('s')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', '').replace('s', ''));
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
            } else if (isInt(rep[1].replace('+', '')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', ''));
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
            } else if ((rep[1] == '') || (rep[1] == 0)) {
                setdata('memo', ''); pauseAudio(alarmPlayer);
            } else { setdata('memo', rep[1]); }
        } else if (rep[0] == 'melody') { omniListen(rep[1], true);
        } else if (rep[0] == 'current') {
            audioPosition(((rep[1].includes('+')) && (rep[1].startsWith('+'))) ? rep[1].replaceAll('+', '') : rep[1]);
        } else if (rep[0].startsWith('lock_')) {
            setlock(rep[0].replace('lock_', ''), rep[1]);
        } else if (rep[1].includes('?rev=')) {
            var atr = rep[1].split('?rev=')[1];
            setdata(rep[0], rep[1].replace(atr, '').replace('?rev=', ''));
        } else { setdata(rep[0], rep[1]); }
    } else if ((index == (length - 1)) && (input.includes(':')) && (input.startsWith(':'))) {
        var cald = arrjob(sysDefCallData.value,';',':');
        cald[input.replace(':', '')] = sysDefSessionID.value;
        set('calling.json', JSON.stringify(cald), true);
        sysDefCallData.value = arrpack(cald,';',':');
    } else if ((index == (length - 1)) && (input.includes('_')) && (input.startsWith('_'))) {
        omniGo(input.replace('_', ''));
    } else if ((index == (length - 1)) && (input.includes('=')) && (input.startsWith('='))) {
        window.location.href = input.replace('=', '');
    } else if ((index == (length - 1)) && (input.includes('+')) && (input.startsWith('+'))) {
        if (input.replace('+', '').includes('h')) {
            plu = parseInt(input.replace('+', '').replace('h', '')) * 3600; setdata('memo', (Math.round(Date.now() / 1000) + parseInt(plu)));
        } else if (input.replace('+', '').includes('min')) {
            plu = parseInt(input.replace('+', '').replace('min', '')) * 60; setdata('memo', (Math.round(Date.now() / 1000) + parseInt(plu)));
        } else if (input.replace('+', '').includes('m')) {
            plu = parseInt(input.replace('+', '').replace('m', '')) * 60; setdata('memo', (Math.round(Date.now() / 1000) + parseInt(plu)));
        } else if (input.replace('+', '').includes('sec')) {
            plu = parseInt(input.replace('+', '').replace('sec', ''));
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(plu)));
        } else if (input.replace('+', '').includes('s')) {
            plu = parseInt(input.replace('+', '').replace('s', ''));
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(plu)));
        } else { audioPosition(input.replace('+', '')); }
    } else if ((index == (length - 1)) && (input.includes('.'))) {
        if (input.startsWith('.')) {
            addFriend(input.replace('.', ''));
        } else if (input.endsWith('.')) {
            dropFriend(input.slice(0, -1));
        }
    } else if ((index == (length - 1)) && (isInt(input))) {
        audioPosition(input);
    } else {
        if (input.startsWith('lock_')) {
            output = input + ': ' + lockdata()[input.replace('lock_', '')];
        } else if ((input == 'melody')) {
            output = input + ': ' + dtw(userdata()[input], sysDefSessionID.value, 'あいうえおかがきぎぐけげこごさざしじすずせぜそぞただちぢづてでとどなにぬねのはばぱひびぴふぶぷべぺほぼぽまみむめもやゆよらりるれろわゐゑをんゔゟ');
        } else {
            output = input + ': ' + userdata()[input];
        }
    } return output;
}
function executeCode(input) {
    var output = ''; if (input !== undefined) {
        var query = input.slice(0, -1), querySep;
        if (query.includes('; ')) {
            querySep = query.split('; ');
            for (i = 0; i < querySep.length; i++) {
                output += executeMacros(querySep[i], i, querySep.length) + "; ";
            } output = output.slice(0, -2);
        } else {
            output += executeMacros(query);
        } output = output + ';';
    } return output;
}
function readFile(name, opt = 'read', path = '') {
    var dataString = 'name='+name+'&type=code&sign=&mode=multiline';
    $.ajax({
        type: "POST", url: "read.php",
        data: dataString, cache: false,
        success: function(result) {
            if (opt == 'read') {
                var arr = jsonstr(result), ob;
                if (path != '') {
                    if (path.includes('/')) {
                        ob = arr; for (chk in path.split('/')) {
                            ob = ob[path.split('/')[chk]];
                        }
                    } else {
                        ob = arr[path];
                    }
                } else {
                    ob = arr;
                } if (typeof(ob) == 'object') {
                    omniBox.value = JSON.stringify(ob);
                } else {
                    omniBox.value = ob;
                }
            } else {
                omniBox.value = result;
            }
        }
    });
}
function executeFile(name, str = '', re = false, sp = false) {
    var dataString = 'name='+name+'&type=code&sign=&mode=multiline';
    $.ajax({
        type: "POST", url: "read.php",
        data: dataString, cache: false,
        success: function(result) {
            var codeExt = result.split(/\r?\n/);
            var strd = []; var strl = []; var strs = '';
            if (str.includes(',')) {
                strl = str.split(',');
                for (il in strl) {
                    if (codeExt[strl[il]] !== undefined) {
                        if (sp !== false) {
                            strs += codeExt[strl[il]]+'\r\n';
                        } else {
                            executeCode(codeExt[strl[il]]);
                        }
                    }
                } if (sp !== false) { compose(strs.slice(0, -2)); }
            } else if (str.includes('-')) {
                strd = str.split('-'); if (strd[1] > strd[0]) {
                    for (i = strd[0]; i <= strd[1]; i++) { strl.push(i); }
                } for (il in strl) {
                    if (codeExt[strl[il]] !== undefined) {
                        if (sp !== false) {
                            strs += codeExt[strl[il]]+'\r\n';
                        } else {
                            executeCode(codeExt[strl[il]]);
                        }
                    }
                } if (sp !== false) { compose(strs.slice(0, -2)); }
            } else if (isInt(str)) {
                if (sp !== false) { compose(codeExt[str]); } else { executeCode(codeExt[str]); }
            } else if (str == '') {
                if (sp !== false) {
                    compose(result);
                } else {
                    for (il in codeExt) { executeCode(codeExt[il]); }
                }
            } else {
                for (il in codeExt) {
                    if (codeExt[il].toLowerCase().includes(str.toLowerCase())) {
                        if (sp !== false) {
                            compose(codeExt[il]); break;
                        } else {
                            executeCode(codeExt[il]); break;
                        }
                    }
                }
            } if (re !== false) { if (sp === false) { window.location.reload(); }}
        }
    }); return false;
}
function getPkgSequence(input, cmdword, isRepo = 0, isDbg = 0) {
    var preQuery = input.replace(cmdword, '');
    var query = ''; if (preQuery.includes('-i ')) {
        query = preQuery.replace('-i ', '');
        if (isRepo != 0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-s ')) {
        query = preQuery.replace('-s ', '');
        if (isRepo != 0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-o ')) {
        query = preQuery.replace('-o ', '');
        if (isRepo != 0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-d ')) {
        query = preQuery.replace('-d ', '');
        if (isRepo != 0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes('-u ')) {
        query = preQuery.replace('-u ', '');
        if (isRepo != 0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes('-x ')) {
        query = preQuery.replace('-x ', '');
        if (isRepo != 0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes(' -r ')) {
        query = preQuery.split(' -r ');
        if (isRepo != 0) { replaceRepo(query[0], query[1], 0); } else { replacePackage(query[0], query[1], 0); }
    } else if (preQuery.includes(' -p ')) {
        query = preQuery.split(' -p ');
        if (isRepo != 0) { replaceRepo(query[0], query[1], 1); } else { replacePackage(query[0], query[1], 1); }
    } else if (preQuery.includes(' -m ')) {
        query = preQuery.split(' -m ');
        if (isRepo != 0) { replaceRepo(query[0], query[1], -1); } else { replacePackage(query[0], query[1], -1); }
    } if (isDbg == 0) { window.location.reload(); }
}
function pipeExec(input) {
    if (input.includes('/')) {
        var exr = (input.endsWith('/'));
        var pipes = input.split('/');
        var brd = (input.endsWith('/')) ? (pipes.length - 2) : (pipes.length - 1);
        for (it in pipes) {
            if ((it >= 1) && (it <= brd)) {
                var ark = (pipes[it].includes(':')) ? pipes[it].split(':')[0] : pipes[it];
                var arv = (pipes[it].includes(':')) ? pipes[it].split(':')[1] : '';
                var lnt = (sysDefCodexBox.value).split('//');
                for (i = 0; i < lnt.length; i++) {
                    if (lnt[i].toLowerCase().includes(ark.toLowerCase())) {
                        executeFile(lnt[i], arv, exr); break;
                    }
                }
            }
        }
    } else if (input.includes('\\')) {
        var exr = (input.endsWith('\\'));
        var pipes = input.split('\\');
        var brd = (input.endsWith('\\')) ? (pipes.length - 2) : (pipes.length - 1); for (it in pipes) {
            if ((it >= 1) && (it <= brd)) {
                var ark = (pipes[it].includes(':')) ? pipes[it].split(':')[0] : pipes[it];
                var arv = (pipes[it].includes(':')) ? pipes[it].split(':')[1] : '';
                var lnt = (sysDefSpeechBox.value).split('//');
                for (i = 0; i < lnt.length; i++) {
                    if (lnt[i].toLowerCase().includes(ark.toLowerCase())) {
                        executeFile(lnt[i], arv, exr, true); break;
                    }
                }
            }
        }
    }
}
function omniEnter() {
    var input = omniBox.value, arb = arc = arj = '', arg = [];
    var itm, prx, qy; if (sysDefChat.value != 0) {
        compose(input);
    } else {
        if ((input == 'reload') || (input == 'refresh')) {
            window.location.reload();
        } else if ((input == 'signout') || (input == 'logout') || (input == 'logoff')) {
            omniAuthRequest('signout','','');
        } else if (input == 'spawn') {
            var ob = jsonMarket(sysDefSessionID.value, 'weapon');
            init_user('1337', 'auto', ob);
        } else if (input == 'upload') {
            document.getElementById('filebrowser').click();
            return false;
        } else if (input == 'song') { songIndex();
        } else if (input == 'clear') {
            clearJournal('', sysDefMsgData, 'msgbox');
        } else if (input == 'erase') {
            clearJournal(-1, sysDefBookKeep, 'book');
        } else if ((input == 'unbind') || (input == 'detach')) {
            unbind(sysDefSessionID.value);
        } else if ((input == 'suicide') || (input == 'goodbye')) {
            delete_user(sysDefSessionID.value); omniAuthRequest('signout','','');
        } else if ((input == 'fast') || (input == 'spedup')) {
            var vlr = superRound((parseFloat(sysDefAudioSpeed.value) + 0.05), 2);
            setdata('audio_speed', vlr); sysDefAudioSpeed.value = vlr;
        } else if ((input == 'slow') || (input == 'slowed')) {
            var vlr = superRound((parseFloat(sysDefAudioSpeed.value) - 0.05), 2);
            setdata('audio_speed', vlr); sysDefAudioSpeed.value = vlr;
        } else if (input == 'ff') {
            var vlr = superRound((parseFloat(sysDefVideoSpeed.value) + 0.05), 2);
            setdata('video_speed', vlr); sysDefVideoSpeed.value = vlr;
        } else if (input == 'rew') {
            var vlr = superRound((parseFloat(sysDefVideoSpeed.value) - 0.05), 2);
            setdata('video_speed', vlr); sysDefVideoSpeed.value = vlr;
        } else if (input.startsWith('store ')) {
            var st = jsonstr(openJournal(sysDefSessionID.value, sysDefStoreList, sysDefStoreJSONs))
            var ob = arrjob(sysDefPowersData.value,';',':'), arb = input.replace('store ', '');
            if (ob[sysDefSessionID.value] >= 0) {
                if (arb.startsWith('delete ')) {
                    arj = arb.replace('delete ', '');
                    arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                    if (arg.length > 0) {
                        for (i = 0; i < arg.length; i++) {
                            if (st[arg[i].replaceAll('"', '')] !== undefined) {
                                delete st[arg[i].replaceAll('"', '')];
                            }
                        }
                    }
                } else if (arb.startsWith('rename ')) {
                    arj = arb.replace('rename ', '');
                    arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                    if (st[arg[0].replaceAll('"', '')] !== undefined) {
                        st[arg[1].replaceAll('"', '')] = st[arg[0].replaceAll('"', '')];
                        delete st[arg[0].replaceAll('"', '')];
                    }
                } else if (arb.startsWith('produce ')) {
                    arj = arb.replace('produce ', '');
                    arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                    if ((st[arg[0].replaceAll('"', '')] !== undefined) && (typeof(st[arg[0].replaceAll('"', '')]) == 'object') && (st[arg[0].replaceAll('"', '')]['amount'] !== 'undefined')) {
                        qy = (arg.length > 1) ? ((isInt(arg[1].replaceAll('"', ''))) ? parseInt(arg[1].replaceAll('"', '')) : 1) : 1;
                        itm = (isInt(st[arg[0].replaceAll('"', '')]['amount']) && (st[arg[0].replaceAll('"', '')]['amount'] >= 0)) ? parseInt(st[arg[0].replaceAll('"', '')]['amount']) + qy : qy;
                        st[arg[0].replaceAll('"', '')]['amount'] = itm;
                    }
                } else if (arb.includes('price ')) {
                    arj = arb.replace('price ', '');
                    arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                    if ((st[arg[0].replaceAll('"', '')] !== undefined) && (typeof(st[arg[0].replaceAll('"', '')]) == 'object') && (st[arg[0].replaceAll('"', '')]['price'] !== 'undefined')) {
                        prx = (arg.length > 1) ? ((isInt(arg[1].replaceAll('"', ''))) ? parseInt(arg[1].replaceAll('"', '')) : arg[1].replaceAll('"', '')) : '';
                        st[arg[0].replaceAll('"', '')]['price'] = prx;
                    }
                } else if (arb.includes('finite ')) {
                    arj = arb.replace('finite ', '');
                    arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                    if ((st[arg[0].replaceAll('"', '')] !== undefined) && (typeof(st[arg[0].replaceAll('"', '')]) == 'object') && (st[arg[0].replaceAll('"', '')]['finite'] !== 'undefined')) {
                        st[arg[0].replaceAll('"', '')]['finite'] = flip(st[arg[0].replaceAll('"', '')]['finite']);
                    }
                } set('./.store/'+sysDefSessionID.value+'_store.json', encodeURIComponent(JSON.stringify(st)), true);
            }
        } else if (input.startsWith('sell ')) {
            arj = input.replace('sell ', '');
            arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
            sell_item(sysDefSessionID.value, arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''));
        } else if (input.startsWith('mkdir ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('mkdir ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        mkdir(requestPath.value+'/'+arg[i].replaceAll('"', ''), true);
                    } window.location.reload();
                }
            }
        } else if (input.startsWith('touch ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('touch ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        set(requestPath.value+'/'+arg[i].replaceAll('"', ''), '', true);
                    } window.location.reload();
                }
            }
        } else if (input.startsWith('rm ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('rm ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        del(requestPath.value+'/'+arg[i].replaceAll('"', ''), true);
                    } window.location.reload();
                }
            }
        } else if (input.startsWith('mv ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('mv ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length == 2) {
                    move(requestPath.value+'/'+arg[0].replaceAll('"', ''), requestPath.value+'/'+arg[1].replaceAll('"', ''), true);
                    window.location.reload();
                }
            }
        } else if (input.startsWith('cp ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('cp ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 1) {
                    for (i = 1; i < arg.length; i++) {
                        copy(requestPath.value+'/'+arg[0].replaceAll('"', ''), requestPath.value+'/'+arg[i].replaceAll('"', ''), true);
                    } window.location.reload();
                }
            }
        } else if (input.startsWith('update ')) {
            getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('update ', '')).toString()).value, 'get ', 0);
        } else if (input.startsWith('clear ')) {
            clearJournal(input.replace('clear ', ''), sysDefMsgData, 'msgbox');
        } else if (input.startsWith('erase ')) {
            clearJournal(input.replace('erase ', ''), sysDefBookKeep, 'book');
        } else if (input.startsWith('get ')) {
            getPkgSequence(input, 'get ', 0);
        } else if (input.startsWith('git ')) {
            getPkgSequence(input, 'git ', 1);
        } else if (input.endsWith(';')) {
            omniBox.value = executeCode(input);
        } else if ((input.startsWith('/')) || (input.startsWith('\\'))) {
            pipeExec(input);
        } else if ((input.includes('&')) || (input.includes('|')) || (input.includes('^')) || (input.includes('~'))) {
            omniBox.value = finarr(arrmath(input)).join('|');
        } else {
            omniBox.value = calc(input);
        }
    } omniBox.focus();
}
