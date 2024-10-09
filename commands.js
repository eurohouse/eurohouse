function executeMacros(input, index = 0, length = 1) {
    var output = input, rep, san;
    if ((index == (length - 1)) && (input == '_')) {
        omniBack(sysDefParent.value);
    } else if ((index == (length - 1)) && (input == '\\=')) {
        output = '\\='+hex2bin(userdata()['melody']);
    } else if ((index == (length - 1)) && (input == '&')) {
        unbind(sysDefSessionID.value);
    } else if ((index == (length - 1)) && (input == '$')) {
        unequip(sysDefSessionID.value);
    } else if ((input.includes('# ')) && (input.indexOf('# ') == 0)) {
        // YOUR COMMENTS HERE...
    } else if ((index == (length - 1)) && (input.includes('\\=')) && (input.startsWith('\\='))) {
        var req = input.replace('\\=', '');
        var res = (req.includes('://')) ? req : 'https://bitbucket.org/baronnaise/'+req.split('/')[0]+'/raw/master/'+req.split('/')[1]; omniListen(res, true);
    } else if ((index == (length - 1)) && (input.includes("\\")) && (input.startsWith('\\'))) {
        var namePart = input.replace("\\", ''), nameInc = 0;
        var namePart1 = (namePart.includes(':')) ? namePart.split(':')[0] : namePart;
        var namePart2 = (namePart.includes(':')) ? namePart.split(':')[1] : 0;
        var museLint = (sysDefMusicBox.value).split('//');
        for (i = 0; i < museLint.length; i++) {
            if (museLint[i].toLowerCase().includes(namePart1.toLowerCase())) {
                if (nameInc >= namePart2) { omniListen(museLint[i], true); break; } nameInc++;
            } omniPause();
        }
    } else if ((index == (length - 1)) && (input.includes("\\/")) && (input.startsWith('\\/'))) {
        var nameNum = input.replace("\\/", ''), museMelo = hex2bin(sysDefMelody.value);
        var museLint = (sysDefMusicBox.value).split('//');
        var museInd = arraySearch(((museMelo.startsWith(requestPath.value+'/')) ? museMelo.replace(requestPath.value+'/','') : museMelo), museLint);
        var museNum = museLint.length, museDiv = Math.floor(museNum / parseInt(nameNum));
        var museNxt = (museInd+museDiv)%museNum;
        console.log(museNxt);
        omniListen(museLint[museNxt], true);
    } else if ((index == (length - 1)) && (input.includes('./')) && (input.startsWith('./'))) {
        omniRead(requestMode.value, input.replace('./', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('*'))) {
        omniDisp(requestMode.value, input.replace('*', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('@'))) {
        var atr = input.split('@'), atd, atx; if (atr[0].includes(':')) {
            atd = atr[0].split(':'); atx = CryptoJS.SHA256(atd[1]).toString();
            if (atr[1].includes('signin')) {
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
                delete_user(input.replace('~', '')); omniAuthRequest('signout','','');
            }
        }
    } else if (input.includes(': ')) {
        rep = input.split(': '); if (rep[0] == 'memo') {
            if ((rep[1].includes('h')) && (rep[1].startsWith('+'))) {
                san = parseInt(rep[1].replace('+', '').replace('h', '')) * 3600;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(san)));
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
            } else {
                setdata('memo', rep[1]);
            }
        } else if (rep[0] == 'melody') {
            omniListen(rep[1], true);
        } else if (rep[0] == 'current_entry') {
            setdata('current_entry', bin2hex(rep[1]));
        } else if (rep[0] == 'current') {
            if ((rep[1].includes('+')) && (rep[1].startsWith('+'))) {
                audioPosition(rep[1].replaceAll('+', ''));
            } else {
                audioPosition(rep[1]);
            }
        } else if (rep[0].startsWith('lock_')) {
            setlock(rep[0].replace('lock_', ''), rep[1]);
        } else if (rep[0].startsWith('meta_')) {
            setmeta(bin2hex(rep[0].replace('meta_', '')), bin2hex(rep[1]));
        } else if (rep[1].includes('?rev=')) {
            var atr = rep[1].split('?rev=')[1];
            setdata(rep[0], rep[1].replace(atr, '').replace('?rev=', ''));
        } else {
            setdata(rep[0], rep[1]);
        }
    } else if ((index == (length - 1)) && (input.includes('_')) && (input.startsWith('_'))) {
        omniGo(input.replace('_', ''));
    } else if ((index == (length - 1)) && (input.includes('=')) && (input.startsWith('='))) {
        window.location.href = input.replace('=', '');
    } else if ((index == (length - 1)) && (input.includes('+')) && (input.startsWith('+'))) {
        if (input.replace('+', '').includes('h')) {
            sansPlus = parseInt(input.replace('+', '').replace('h', '')) * 3600;
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
        } else if (input.replace('+', '').includes('min')) {
            sansPlus = parseInt(input.replace('+', '').replace('min', '')) * 60;
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
        } else if (input.replace('+', '').includes('m')) {
            sansPlus = parseInt(input.replace('+', '').replace('m', '')) * 60;
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
        } else if (input.replace('+', '').includes('sec')) {
            sansPlus = parseInt(input.replace('+', '').replace('sec', ''));
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
        } else if (input.replace('+', '').includes('s')) {
            sansPlus = parseInt(input.replace('+', '').replace('s', ''));
            setdata('memo', (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
        } else {
            audioPosition(input.replace('+', ''));
        }
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
        } else if (input.startsWith('meta_')) {
            output = input + ': ' + hex2bin(metadata()[bin2hex(input.replace('meta_', ''))]);
        } else if ((input == 'melody') || (input == 'current_entry')) {
            output = input + ': ' + hex2bin(userdata()[input]);
        } else {
            output = input + ': ' + userdata()[input];
        }
    } return output;
}
function executeCode(input) {
    var output = '';
    if (input !== undefined) {
        var query = input.slice(0, -1);
        var querySep;
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
function getPkgSequence(input, cmdword, isRepo = 0) {
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
    } window.location.reload();  
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
        var brd = (input.endsWith('\\')) ? (pipes.length - 2) : (pipes.length - 1);
        for (it in pipes) {
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
    var input = omniBox.value, arj = '', arg = [];
    if (sysDefChat.value != 0) {
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
            document.getElementById('filebrowser').click(); return false;
        } else if (input == 'song') {
            songIndex();
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
        } else if (input.startsWith('store rm ')) {
            var st = jsonstr(openJournal(sysDefSessionID.value, sysDefStoreList, sysDefStoreJSONs));
            var ob = arrjob(sysDefPowersData.value,';',':');
            if (ob[sysDefSessionID.value] >= 0) {
                arj = input.replace('store rm ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        if (st[arg[i]] !== undefined) { delete st[arg[i]]; }
                    } set('./.store/'+sysDefSessionID.value+'_store.json', encodeURIComponent(JSON.stringify(st)), true);
                }
            }
        } else if (input.startsWith('store mv ')) {
            var st = jsonstr(openJournal(sysDefSessionID.value, sysDefStoreList, sysDefStoreJSONs));
            var ob = arrjob(sysDefPowersData.value,';',':');
            if (ob[sysDefSessionID.value] >= 0) {
                arj = input.replace('store mv ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (st[arg[0]] !== undefined) { st[arg[1]] = st[arg[0]]; delete st[arg[0]]; }
                set('./.store/'+sysDefSessionID.value+'_store.json', encodeURIComponent(JSON.stringify(st)), true);
            }
        } else if (input.startsWith('sell ')) {
            arj = input.replace('sell ', '');
            arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
            if (arg.length > 4) {
                sell_item(arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''), arg[2].replaceAll('"', ''), arg[3].replaceAll('"', ''), arg[4].replaceAll('"', ''));
            } else if (arg.length == 4) {
                sell_item(arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''), arg[2].replaceAll('"', ''), arg[3].replaceAll('"', ''));
            } else {
                sell_item(arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''), arg[2].replaceAll('"', ''));
            }
        } else if (input.startsWith('ytmp3 ')) {
            $('.lowerGap').html('<iframe style="width:100%;height:60px;border:0;overflow:hidden;" scrolling="no" src="https://loader.to/api/button/?url='+input.replace('ytmp3 ', '')+'&f=mp3"></iframe>');
        } else if (input.startsWith('ytmp4 ')) {
            $('.lowerGap').html('<iframe style="width:100%;height:60px;border:0;overflow:hidden;" scrolling="no" src="https://loader.to/api/button/?url='+input.replace('ytmp4 ', '')+'&f=360"></iframe>');
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
        } else if (input.startsWith('trash ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('trash ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        recycle(requestPath.value+'/'+arg[i].replaceAll('"', ''), true);
                    } window.location.reload();
                }
            }
        } else if (input.startsWith('arr ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('arr ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length >= 4) {
                    ordarr(arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''), arg[2].replaceAll('"', ''), arg[3].replaceAll('"', ''));
                } else if (arg.length == 3) {
                    ordarr(arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''), arg[2].replaceAll('"', ''));
                } else {
                    ordarr(arg[0].replaceAll('"', ''), arg[1].replaceAll('"', ''), '', '');
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
        } else if ((input.includes('update ')) && (input.startsWith('update '))) {
            getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('update ', '')).toString()).value, 'get ', 0);
        } else if ((input.includes('clear ')) && (input.startsWith('clear '))) {
            clearJournal(input.replace('clear ', ''), sysDefMsgData, 'msgbox');
        } else if ((input.includes('erase ')) && (input.startsWith('erase '))) {
            clearJournal(input.replace('erase ', ''), sysDefBookKeep, 'book');
        } else if ((input.includes('get ')) && (input.startsWith('get '))) {
            getPkgSequence(input, 'get ', 0);
        } else if ((input.includes('git ')) && (input.startsWith('git '))) {
            getPkgSequence(input, 'git ', 1);
        } else if ((input.includes('rand ')) && (input.startsWith('rand '))) {
            var numPart = input.replace('rand ', '').split(' ');
            omniBox.value = rand(numPart[0], numPart[1]);
        } else if ((input.includes(';')) && (input.endsWith(';'))) {
            omniBox.value = executeCode(input);
        } else if (((input.startsWith('/')) && (input.includes('/'))) || ((input.startsWith('\\')) && (input.includes('\\'))) || (input.startsWith('/')) || (input.startsWith('\\'))) {
            pipeExec(input);
        } else if ((input.includes('&')) || (input.includes('|')) || (input.includes('^')) || (input.includes('~'))) {
            omniBox.value = finarr(arrmath(input)).sort().join(',');
        } else if ((input.includes('.')) && ((input.split('.').length == 3) || (input.split('.').length == 4))) {
            var reh = input.split('.')[2].substring(0, 2);
            var rey = input.split('.')[2].substring(2);
            setdata('background', input.split('.')[0]+'.'+input.split('.')[1]+'.'+input.split('.')[2]+'.png'); setdata('lock', 1); setdata('hour', reh); setdata('entry', rey);
        } else {
            omniBox.value = calc(input);
        }
    } omniBox.focus();
}
