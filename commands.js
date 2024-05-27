function executeMacros(input, index = 0, length = 1) {
    var output = input; var rep, r1, r2, r3, r4;
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
        rep = input.split(': '); var sansPlus = '';
        if (rep[0] == 'memo') {
            if ((rep[1].includes('h')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('h', '')) * 3600;
                setdata(rep[0], (Math.round(Date.now() / 1000) + parseInt(sansPlus)));
            } else if ((rep[1].includes('min')) && (rep[1].startsWith('+'))) {
                sansPlus = parseInt(rep[1].replace('+', '').replace('min', '')) * 60;
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
        } else if (rep[0] == 'vintage') {
            if (rep[1] != 0) {
                setdata('brightness', 90);
                setdata('contrast', 120);
                setdata('grayscale', 100);
            } else {
                setdata('brightness', 100);
                setdata('contrast', 100);
                setdata('grayscale', 0);
            }
            setdata(rep[0], rep[1]);
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
        audioPosition(input.replace('+', ''));
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
function executeFile(name) {
    var dataString = 'name='+name+'&type=code&sign=&mode=multiline';
    var prep; $.ajax({
        type: "POST",
        url: "read.php",
        data: dataString,
        cache: false,
        success: function(result) {
            executeCode(miniPager(result, 0));
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
    if (sysDefChat.value != 0) {
        compose(input, false, 0);
    } else {
        if ((input == 'reload') || (input == 'refresh')) {
            window.location.reload();
        } else if ((input == 'signout') || (input == 'logout') || (input == 'logoff')) {
            omniAuthRequest('signout', '', '');
        } else if (input == 'clear') {
            clearMessage('');
        } else if (input == 'spawn') {
            spawnBot('auto');
        } else if (input == 'song') {
            songIndex();
        } else if ((input == 'unbind') || (input == 'suck it') || (input == 'отсоси')) {
            unbind(sysDefSessionID.value);
        } else if ((input == 'suicide') || (input == 'goodbye') || (input == 'good riddance')) {
            delete_user(sysDefSessionID.value);
            omniAuthRequest('signout','','');
        } else if ((input.includes('update ')) && (input.startsWith('update '))) {
            if (sysDefSessionID.value == 'root') {
                var req = input.replace('update ', '');
                getPkgSequence('get -i '+document.getElementById('updateChannel'+ucfirst(req)).value, 'get ', 0);
            }
        } else if ((input.includes('play ')) && (input.startsWith('play '))) {
            var req = input.replace('play ', '');
            omniListen('https://github.com/infofintech/'+req.split('\\')[0]+'/blob/main/'+req.split('\\')[1]+'?raw=true', true);
        } else if ((input.includes('clear ')) && (input.startsWith('clear '))) {
            clearMessage(input.replace('clear', ''));
        } else if ((input.includes('get ')) && (input.startsWith('get '))) {
            if (sysDefSessionID.value == 'root') {
                getPkgSequence(input, 'get ', 0);
            }
        } else if ((input.includes('git ')) && (input.startsWith('git '))) {
            if (sysDefSessionID.value == 'root') {
                getPkgSequence(input, 'git ', 1);
            }
        } else if ((input.includes('exec ')) && (input.startsWith('exec '))) {
            var namePart = input.replace('exec ', '');
            var codeArr = sysDefCodexBox.value;
            var codeLint = codeArr.split('//');
            for (i = 0; i < codeLint.length; i++) {
                if (codeLint[i].toLowerCase().includes(namePart.toLowerCase())) {
                    executeFile(codeLint[i]);
                    break;
                }
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
            omniBox.value = finarr(res).join(',');
        } else if (input.includes(' ^ ')) {
            var arr = input.split(' ^ ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : res.filter(function(n) {
                    return mas.indexOf(n) !== -1;
                });
            }
            omniBox.value = finarr(res).join(',');
        } else if (input.includes(' / ')) {
            var arr = input.split(' / ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : res.filter(function(n) {
                    return mas.indexOf(n) == -1;
                });
            }
            omniBox.value = finarr(res).join(',');
        } else if (input.includes(' \\ ')) {
            var arr = input.split(' \\ ');
            var mas = []; var res = [];
            for (i = 0; i < arr.length; i++) {
                mas = arr[i].split(',');
                res = (i == 0) ? mas : mas.filter(function(n) {
                    return res.indexOf(n) == -1;
                });
            }
            omniBox.value = finarr(res).join(',');
        } else if ((input.includes(';')) && (input.endsWith(';'))) {
            omniBox.value = executeCode(input);
        } else {
            omniBox.value = math(input);
        }
    }
    omniBox.focus();
}
