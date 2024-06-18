function executeMacros(input, index = 0, length = 1) {
    var output = input; var rep, sansPlus;
    if ((index == (length - 1)) && (input == '_')) {
        omniBack(sysDefParent.value);
    } else if ((index == (length - 1)) && (input == '\\=')) {
        output = '\\='+hex2bin(userdata()['melody']);
    } else if ((index == (length - 1)) && (input == '\\')) {
        omniPause();
    } else if ((index == (length - 1)) && (input == ':/')) {
        pauseMIDI();
    } else if ((input.includes('# ')) && (input.indexOf('# ') == 0)) {
        // YOUR COMMENTS HERE...
    } else if ((index == (length - 1)) && (input.includes(':\\')) && (input.indexOf(':\\') == 0)) {
        playMIDI(input.replace(':\\', ''));
    } else if ((index == (length - 1)) && (input.includes('\\=')) && (input.indexOf('\\=') == 0)) {
        omniListen(input.replace('\\=', ''), true);
    } else if ((index == (length - 1)) && (input.includes("\\")) && (input.indexOf('\\') == 0)) {
        var namePart = input.replace("\\", '');
        var museArr = sysDefMusicBox.value;
        var museLint = museArr.split('//');
        for (i = 0; i < museLint.length; i++) {
            if (museLint[i].toLowerCase().includes(namePart.toLowerCase())) {
                omniListen(museLint[i], true);
                break;
            }
            omniPause();
        }
    } else if ((index == (length - 1)) && (input.includes('./')) && (input.indexOf('./') == 0)) {
        omniRead(requestMode.value, input.replace('./', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('*'))) {
        omniDisp(requestMode.value, input.replace('*', ''), requestLock.value);
    } else if ((index == (length - 1)) && (input.includes('@'))) {
        var atr = input.split('@'); var tyx, txy;
        if (atr[0].includes(':')) {
            tyx = atr[0].split(':');
            if (atr[1].includes('signin')) {
                omniAuthRequest('signin', tyx[0], tyx[1]);
            } else if (atr[1].includes('signup')) {
                omniAuthRequest('signup', tyx[0], tyx[1]);
            } else if (atr[1].includes('rename')) {
                rename_user(tyx[0], tyx[1]);
                omniAuthRequest('signin', tyx[0], tyx[1]);
            } else if (atr[1].includes(':')) {
                txy = atr[1].split(':');
                if (txy[0] == 'buy') {
                    buy_item(tyx[0], tyx[1], txy[1]);
                } else if (txy[0] == 'sell') {
                    sell_item(tyx[0], tyx[1], txy[1]);
                }
            }
        } else {
            if (atr[1].includes('signin')) {
                omniAuthRequest('signin', atr[0], '');
            } else if (atr[1].includes('signup')) {
                omniAuthRequest('signup', atr[0], '');
            } else if (atr[1].includes('rename')) {
                rename_user(atr[0], '');
                omniAuthRequest('signin', atr[0], '');
            } else if (atr[1].includes('accept')) {
                accept_gift(atr[0]);
            } else if (atr[1].includes(':')) {
                txy = atr[1].split(':');
                if (txy[0] == 'buy') {
                    buy_item(atr[0], '', txy[1]);
                } else if (txy[0] == 'sell') {
                    sell_item(atr[0], '', txy[1]);
                }
            } else if (atr[1].includes('+')) {
                txy = atr[1].split('+');
                make_gift(atr[0], txy[1]);
            }
        }
    } else if ((index == (length - 1)) && (input.includes('#')) && (input.indexOf('#') == 0)) {
        setdata('find', input);
    } else if ((index == (length - 1)) && (input.includes('&')) && (input.indexOf('&') == 0)) {
        bind(sysDefSessionID.value, input.replace('&', ''));
    } else if ((index == (length - 1)) && (input.includes('~')) && (input.indexOf('~') == 0)) {
        if (sysDefSessionID.value == 'root') {
            delete_user(input.replace('~', ''));
        } else {
            if (input.replace('~', '') == sysDefSessionID.value) {
                delete_user(input.replace('~', ''));
                omniAuthRequest('signout','','');
            }
        }
    } else if (input.includes(': ')) {
        rep = input.split(': ');
        if (rep[0] == 'memo') {
            if ((rep[1].includes('h')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('h', '')) * 3600;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if ((rep[1].includes('min')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('min', '')) * 60;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if ((rep[1].includes('m')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('m', '')) * 60;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if ((rep[1].includes('sec')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('sec', ''));
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if ((rep[1].includes('s')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('s', ''));
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if (isInt(rep[1].replace('+', '')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', ''));
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if ((rep[1] == '') || (rep[1] == 0)) {
                setdata('memo', '');
                pauseAudio(alarmPlayer);
            } else {
                setdata('memo', rep[1]);
            }
        } else if (rep[0] == 'melody') {
            omniListen(rep[1], true);
        } else if (rep[0] == 'current') {
            if ((rep[1].includes('+')) && (rep[1].startsWith('+'))) {
                audioPosition(rep[1].replaceAll('+', ''));
            } else {
                audioPosition(rep[1]);
            }
        } else if (rep[0].startsWith('lock_')) {
            setlock(rep[0].replace('lock_', ''), rep[1]);
        } else {
            setdata(rep[0], rep[1]);
        }
    } else if ((index == (length - 1)) && (input.includes('_')) && (input.indexOf('_') == 0)) {
        omniGo(input.replace('_', ''));
    } else if ((index == (length - 1)) && (input.includes('=')) && (input.indexOf('=') == 0)) {
        window.location.href = input.replace('=', '');
    } else if ((index == (length - 1)) && (input.includes('+')) && (input.indexOf('+') == 0)) {
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
        } else if (input == 'melody') {
            output = input + ': ' + hex2bin(userdata()[input]);
        } else {
            output = input + ': ' + userdata()[input];
        }
    }
    return output;
}
function executeCode(input) {
    var query = input.slice(0, -1);
    var querySep; var output = '';
    if (query.includes('; ')) {
        querySep = query.split('; ');
        for (i = 0; i < querySep.length; i++) {
            output += executeMacros(querySep[i], i, querySep.length) + "; ";
        }
        output = output.slice(0, -2);
    } else {
        output += executeMacros(query);
    }
    return output + ';';
}
function executeFile(name, str = '', re = false) {
    var dataString = 'name='+name+'&type=code&sign=&mode=multiline';
    $.ajax({
        type: "POST",
        url: "read.php",
        data: dataString,
        cache: false,
        success: function(result) {
            var codeExt = result.split(/\r?\n/);
            if (isInt(str)) {
                executeCode(codeExt[str]);
            } else if (str == '') {
                for (il in codeExt) {
                    executeCode(codeExt[il]);
                }
            } else {
                for (il in codeExt) {
                    if (codeExt[il].toLowerCase().includes(str.toLowerCase())) {
                        executeCode(codeExt[il]);
                        break;
                    }
                }
            }
            if (re !== false) {
                window.location.reload();
            }
        }
    });
    return false;
}
function pronounceFile(name, str = '', re = false) {
    var dataString = 'name='+name+'&type=code&sign=&mode=multiline';
    $.ajax({
        type: "POST",
        url: "read.php",
        data: dataString,
        cache: false,
        success: function(result) {
            var codeExt = result.split(/\r?\n/);
            if (isInt(str)) {
                compose(codeExt[str]);
            } else if (str == '') {
                compose(result);
            } else {
                for (il in codeExt) {
                    if (codeExt[il].toLowerCase().includes(str.toLowerCase())) {
                        compose(codeExt[il]);
                        break;
                    }
                }
            }
            if (re !== false) {
                window.location.reload();
            }
        }
    });
    return false;
}
function getPkgSequence(input, cmdword, isRepo = 0) {
    var preQuery = input.replace(cmdword, '');
    var query = '';
    if (preQuery.includes('-i ')) {
        query = preQuery.replace('-i ', '');
        if (isRepo != 0) {
            obtainRepo(query);
        } else {
            systemUpdate(query);
        }
    } else if (preQuery.includes('-s ')) {
        query = preQuery.replace('-s ', '');
        if (isRepo != 0) {
            obtainRepo(query);
        } else {
            systemUpdate(query);
        }
    } else if (preQuery.includes('-o ')) {
        query = preQuery.replace('-o ', '');
        if (isRepo != 0) {
            obtainRepo(query);
        } else {
            systemUpdate(query);
        }
    } else if (preQuery.includes('-d ')) {
        query = preQuery.replace('-d ', '');
        if (isRepo != 0) {
            terminate(query);
        } else {
            uninstall(query);
        }
    } else if (preQuery.includes('-u ')) { query = preQuery.replace('-u ', '');
        if (isRepo != 0) {
            terminate(query);
        } else {
            uninstall(query);
        }
    } else if (preQuery.includes('-x ')) {
        query = preQuery.replace('-x ', '');
        if (isRepo != 0) {
            terminate(query);
        } else {
            uninstall(query);
        }
    } else if (preQuery.includes(' -r' )) { query = preQuery.split(' -r ');
        if (isRepo != 0) {
            replaceRepo(query[0], query[1], 0);
        } else {
            replacePackage(query[0], query[1], 0);
        }
    } else if (preQuery.includes(' -p' )) {
        query = preQuery.split(' -p ');
        if (isRepo != 0) {
            replaceRepo(query[0], query[1], 1);
        } else {
            replacePackage(query[0], query[1], 1);
        }
    } else if (preQuery.includes(' -m' )) {
        query = preQuery.split(' -m ');
        if (isRepo != 0) {
            replaceRepo(query[0], query[1], -1);
        } else {
            replacePackage(query[0], query[1], -1);
        }
    }
    window.location.reload();  
}
function omniEnter() {
    var mode = requestMode.value;
    var sort = requestSort.value;
    var group = requestGroup.value;
    var angle = requestAngle.value;
    var input = omniBox.value;
    var output = "";
    var arj = ''; var arg = [];
    if (sysDefChat.value != 0) {
        compose(input);
    } else {
        if ((input == 'reload') || (input == 'refresh')) {
            window.location.reload();
        } else if ((input == 'signout') || (input == 'logout') || (input == 'logoff')) {
            omniAuthRequest('signout', '', '');
        } else if (input == 'clear') {
            clearMessage('');
        } else if (input == 'erase') {
            clearBookKeep('');
        } else if (input == 'spawn') {
            init_user('1337', 'auto');
        } else if (input == 'upload') {
            document.getElementById('filebrowser').click();
            return false;
        } else if (input == 'song') {
            songIndex();
        } else if ((input == 'unbind') || (input == 'detach')) {
            unbind(sysDefSessionID.value);
        } else if ((input == 'suicide') || (input == 'goodbye')) {
            delete_user(sysDefSessionID.value);
            omniAuthRequest('signout','','');
        } else if (input.startsWith('mkdir ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('mkdir ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        mkdir(requestPath.value+'/'+arg[i].replaceAll('"', ''), true);
                    }
                    window.location.reload();
                }
            }
        } else if (input.startsWith('touch ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('touch ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        set(requestPath.value+'/'+arg[i].replaceAll('"', ''), '', true);
                    }
                    window.location.reload();
                }
            }
        } else if (input.startsWith('rm ')) {
            if (sysDefSessionID.value == 'root') {
                arj = input.replace('rm ', '');
                arg = arj.match(/\"([^\"]+)\"|(\w+)/g);
                if (arg.length > 0) {
                    for (i = 0; i < arg.length; i++) {
                        del(requestPath.value+'/'+arg[i].replaceAll('"', ''), true);
                    }
                    window.location.reload();
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
                    }
                    window.location.reload();
                }
            }
        } else if ((input.includes('update ')) && (input.startsWith('update '))) {
            if (sysDefSessionID.value == 'root') {
                var req = input.replace('update ', '');
                getPkgSequence('get -i '+document.getElementById('updateChannel'+ucfirst(req)).value, 'get ', 0);
            }
        } else if ((input.includes('clear ')) && (input.startsWith('clear '))) {
            clearMessage(input.replace('clear', ''));
        } else if ((input.includes('erase ')) && (input.startsWith('erase '))) {
            clearBookKeep(input.replace('erase', ''));
        } else if ((input.includes('get ')) && (input.startsWith('get '))) {
            if (sysDefSessionID.value == 'root') {
                getPkgSequence(input, 'get ', 0);
            }
        } else if ((input.includes('git ')) && (input.startsWith('git '))) {
            if (sysDefSessionID.value == 'root') {
                getPkgSequence(input, 'git ', 1);
            }
        } else if ((input.includes('rand ')) && (input.startsWith('rand '))) {
            var numPart = input.replace('rand ', '');
            var numArr = numPart.split(' ');
            omniBox.value = rand(numArr[0], numArr[1]);
        } else if (input.includes(' & ')) {
            var arr = input.split(' & ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : res.concat(mas);
            }
            omniBox.value = finarr(res).sort().join(',');
        } else if (input.includes(' | ')) {
            var arr = input.split(' | ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : res.filter(function(n) {
                    return mas.indexOf(n) !== -1;
                });
            }
            omniBox.value = finarr(res).sort().join(',');
        } else if (input.includes(' / ')) {
            var arr = input.split(' / ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : res.filter(function(n) {
                    return mas.indexOf(n) == -1;
                });
            }
            omniBox.value = finarr(res).sort().join(',');
        } else if (input.includes(' \\ ')) {
            var arr = input.split(' \\ ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : mas.filter(function(n) {
                    return res.indexOf(n) == -1;
                });
            }
            omniBox.value = finarr(res).sort().join(',');
        } else if ((input.includes(';')) && (input.endsWith(';'))) {
            omniBox.value = executeCode(input);
        } else if (input.startsWith('/')) {
            var re1 = (input.endsWith('/')) ? input.replaceAll('/', '') : input.replace('/', '');
            var re2 = (input.endsWith('/'));
            var ark = (re1.includes(':')) ? re1.split(':')[0] : re1;
            var arv = (re1.includes(':')) ? re1.split(':')[1] : '';
            var lnt = (sysDefCodexBox.value).split('//');
            for (i = 0; i < lnt.length; i++) {
                if (lnt[i].toLowerCase().includes(ark.toLowerCase())) {
                    executeFile(lnt[i], arv, re2);
                    break;
                }
            }
        } else if (input.includes('\\')) {
            var re1 = (input.endsWith('\\')) ? input.replaceAll('\\', '') : input.replace('\\', '');
            var re2 = (input.endsWith('\\'));
            var ark = (re1.includes(':')) ? re1.split(':')[0] : re1;
            var arv = (re1.includes(':')) ? re1.split(':')[1] : '';
            var lnt = (sysDefSpeechBox.value).split('//');
            for (i = 0; i < lnt.length; i++) {
                if (lnt[i].toLowerCase().includes(ark.toLowerCase())) {
                    pronounceFile(lnt[i], arv, re2);
                    break;
                }
            }
        } else {
            omniBox.value = math(input);
        }
    }
    omniBox.focus();
}
