function seekImage(command) {
    var content=jsonarr(sysDefContentData.value);
    var result=''; var timecode=''; var arr=[];
    if ((command.includes('::'))&&(command.split('::').length==2)) {
        var commandParts=command.split('::'); for (idx in content) {
            if (content[idx].toLowerCase().includes(commandParts[0].toLowerCase())) { arr.push(idx); }
        } timecode=((!isInt(commandParts[1]))&&((commandParts[1]=='*')||(commandParts[1]=='')))?rand(0,arr.length):commandParts[1];
    } else {
        for (idx in content) {
            if (content[idx].toLowerCase().includes(command.toLowerCase())) { arr.push(idx); }
        } timecode=rand(0,arr.length);
    } result=((notEmpty(arr))?arr[timecode]:content[rand(0,content.length)]);
    setdata('background',result); return result;
}
function seekMusic(command) {
    var subscribedMusic=subscription('music');
    var arg=[]; var playlist=[];
    var searchIndex=0; var timecode=0;
    var arj=ari=arc=itm=res='',sec=0;
    if ((command.includes('?'))&&(command.includes(':'))) {
        searchIndex=command.split('?')[1].split(':')[0];
        timecode=command.split('?')[1].split(':')[1];
        for (i=0; i<subscribedMusic.length; i++) {
            if (subscribedMusic[i].toLowerCase().includes(command.split('?')[0].toLowerCase())) {
                playlist.push(subscribedMusic[i]);
            }
        } if ((!isInt(searchIndex))&&((searchIndex=='*')||(searchIndex==''))) {
            searchIndex=rand(0,playlist.length);
        }
    } else if (command.includes('?')) {
        for (i=0; i<subscribedMusic.length; i++) {
            if (subscribedMusic[i].toLowerCase().includes(command.split('?')[0].toLowerCase())) {
                playlist.push(subscribedMusic[i]);
            }
        } if ((!isInt(command.split('?')[1]))&&((command.split('?')[1]=='*')||(command.split('?')[1]==''))) {
            searchIndex=rand(0,playlist.length);
        } timecode=0;
    } else if (command.includes(':')) {
        timecode=command.split(':')[1];
        for (i=0; i<subscribedMusic.length; i++) {
            if (subscribedMusic[i].toLowerCase().includes(command.split('?')[0].toLowerCase())) {
                playlist.push(subscribedMusic[i]);
            }
        } searchIndex=rand(0,playlist.length);
    } else {
        for (i=0; i<subscribedMusic.length; i++) {
            if (subscribedMusic[i].toLowerCase().includes(command.toLowerCase())) {
                playlist.push(subscribedMusic[i]);
            }
        } searchIndex=rand(0,playlist.length); timecode=0;
    } if (notEmpty(pls)) {
        if ((timecode=='+')&&(searchIndex=='+')) {
            result=playlist[rand(0,playlist.length)];
            setdata('playlist',playlistNext(result));
        } else if (timecode=='+') {
            result=playlist[searchIndex];
            setdata('playlist',playlistNext(result));
        } else if (searchIndex=='+') {
            result=playlist[rand(0,playlist.length)];
            setdata('playlist',playlistNext(result)); 
        } else {
            result=playlist[searchIndex]; omniListen(result,true,parseInt(timecode));
        }
    } else {
        if ((timecode=='+')&&(searchIndex=='+')) {
            result=subscribedMusic[rand(0,subscribedMusic.length)];
            setdata('playlist',playlistNext(result));
        } else if (timecode=='+') {
            result=subscribedMusic[rand(0,subscribedMusic.length)];
            setdata('playlist',playlistNext(result));
        } else if (searchIndex=='+') {
            result=subscribedMusic[rand(0,subscribedMusic.length)];
            setdata('playlist',playlistNext(result));
        } else {
            result=subscribedMusic[rand(0,subscribedMusic.length)];
            omniListen(result,true,parseInt(timecode));
        }
    } return result;
}
function seekCode(req) {
    var macroses=(sysDefCodexBox.value).split(';');
    var speeches=(sysDefSpeechBox.value).split(';');
    var ark=(req.includes(':'))?req.split(':')[0]:req;
    var arv=(req.includes(':'))?req.split(':')[1]:'';
    var res=''; if (arv!='') {
        for (i=0; i<macroses.length; i++) {
            if (macroses[i].toLowerCase().includes(ark.toLowerCase())) {
                res=macroses[i]; executeFile(res,arv); break;
            }
        }
    } else {
        for (i=0; i<speeches.length; i++) {
            if (speeches[i].toLowerCase().includes(ark.toLowerCase())) {
                res=speeches[i]; executeFile(res,arv,false,true); break;
            }
        }
    } return res;
}
function omniEnter() {
    var arj=''; var arg=[]; var input=(omniBox.value).trim();
    var owner=''; var uid=sysDefSessionID.value;
    if ((input.toLowerCase()=='upload')||(input.toLowerCase()=='up')) {
        document.getElementById('filebrowser').click(); return false;
    } else if (input.toLowerCase()=='this') {
        if (!isLocalhost()) {
            window.location.href='https://yandex.ru/images/search?rpt=imageview&url='+($('body').css('background-image')).replace(/^url\(['"]?(.*?)['"]?\)$/i,'$1');
        }
    } else if (input.toLowerCase()=='save') { userBackupManager.backup(uid);
    } else if (input.toLowerCase()=='load') { userBackupManager.restore(uid);
    } else if (input.toLowerCase()=='backup') { websiteBackupManager.backup();
    } else if (input.toLowerCase()=='restore') { websiteBackupManager.restore();
    } else if (input.toLowerCase()=='purge') {
        recycleBin.clear();
    } else if (input.startsWith('download ')) {
        arj=input.replace('download ','');
        arg=arj.match(/\"([^\"]+)\"|(\S+)/g);
        downloadFile(quote(arg[0]),((arg.length>1)?quote(arg[1]):quote(arg[0])));
    } else if (input.startsWith('down ')) {
        arj=input.replace('down ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        downloadFile(quote(arg[0]),((arg.length>1)?quote(arg[1]):quote(arg[0])));
    } else if (input.startsWith('mkdir ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('mkdir ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                mkdir(quote(arg[i]),owner);
            } window.location.reload();
        }
    } else if (input.startsWith('set ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('set ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            set(quote(arg[0]),quote(arg[1]),owner,'re');
        } else if (arg.length==1) {
            set(quote(arg[0]),'',owner,'re');
        }
    } else if (input.startsWith('write ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('write ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            set(quote(arg[0]),quote(arg[1]),owner,'re');
        } else if (arg.length==1) {
            set(quote(arg[0]),'',owner,'re');
        }
    } else if (input.startsWith('env ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('env ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==3) {
            env(quote(arg[0]),quote(arg[1]),quote(arg[2]),owner,'re');
        } else if (arg.length==2) {
            env(quote(arg[0]),quote(arg[1]),'',owner,'re');
        }
    } else if (input.startsWith('touch ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('touch ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            set(quote(arg[0]),quote(arg[1]),owner,'re');
        } else if (arg.length==1) {
            set(quote(arg[0]),'',owner,'re');
        }
    } else if (input.startsWith('rm ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('rm ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                del(quote(arg[i]),owner);
            } window.location.reload();
        }
    } else if (input.startsWith('del ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('del ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                del(quote(arg[i]),owner);
            } window.location.reload();
        }
    } else if (input.startsWith('trash ')) {
        arj=input.replace('trash ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                recycleBin.move(quote(arg[i]));
            } window.location.reload();
        }
    } else if (input.startsWith('untrash ')) {
        arj=input.replace('untrash ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                recycleBin.restore(quote(arg[i]));
            } window.location.reload();
        }
    } else if (input.startsWith('destroy ')) {
        arj=input.replace('destroy ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                recycleBin.destroy(quote(arg[i]));
            } window.location.reload();
        }
    } else if (input.startsWith('mv ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('mv ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            move(quote(arg[0]),quote(arg[1]),owner,'re');
        }
    } else if (input.startsWith('move ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('move ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            move(quote(arg[0]),quote(arg[1]),owner,'re');
        }
    } else if (input.startsWith('cp ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('cp ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            for (i=1; i<arg.length; i++) {
                copy(quote(arg[0]),quote(arg[i]),owner,'re');
            } window.location.reload();
        }
    } else if (input.startsWith('copy ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('copy ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            for (i=1; i<arg.length; i++) {
                copy(quote(arg[0]),quote(arg[i]),owner,'re');
            } window.location.reload();
        }
    } else if (input.startsWith('dir ')) {
        arj=input.replace('dir ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniDir(quote(arg[0]));
    } else if (input.startsWith('cd ')) {
        arj=input.replace('cd ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniDir(quote(arg[0]));
    } else if (input.startsWith('info ')) {
        arj=input.replace('info ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniPath(quote(arg[0]),'','true');
    } else if (input.startsWith('edit ')) {
        arj=input.replace('edit ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniRead('text_editor',quote(arg[0]),'false');
    } else if (input.startsWith('play ')) {
        arj=input.replace('play ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniRead('media_player',quote(arg[0]),requestLock.value);
    } else if (input.startsWith('read ')) {
        arj=input.replace('read ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniBox.value=(arg.length==2)?loadFile(quote(arg[0]),quote(arg[1])):loadFile(quote(arg[0]));
    } else if (input.startsWith('data ')) {
        owner=(superuser())?'rw':uid; arj=input.replace('data ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==4) {
            data(quote(arg[0]),quote(arg[1]),quote(arg[2]),quote(arg[3]),owner,'r');
        } else if (arg.length==3) {
            data(quote(arg[0]),quote(arg[1]),quote(arg[2]),'',owner,'r');
        } else {
            data(quote(arg[0]),quote(arg[1]),'','',owner,'r');
        }
    } else if (input.startsWith('app ')) {
        getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('app ','')).toString()).value,'get ',0);
    } else if (input.startsWith('game ')) {
        getPkgSequence('get -i '+document.getElementById('downloadChannel'+CryptoJS.MD5(input.replace('game ','')).toString()).value,'get ',0);
    } else if (input.startsWith('clear ')) {
        clearJournal(input.replace('clear ',''),sysDefMyMessengerData,'messenger');
    } else if (input.startsWith('erase ')) {
        clearJournal(input.replace('erase ',''),sysDefMyVisitorsData,'visitors');
    } else if (input.startsWith('get ')) {
        getPkgSequence(input,'get ',0);
    } else if (input.startsWith('git ')) {
        getPkgSequence(input,'git ',1);
    } else { omniBox.value=basicCommand(input); } omniBox.focus();
}
function getPkgSequence(input,cmdword,isRepo=0,isDbg=0) {
    var preQuery=input.replace(cmdword,'');
    var query=''; if (preQuery.includes('-i ')) {
        query=preQuery.replace('-i ','');
        if (isRepo!=0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-s ')) {
        query=preQuery.replace('-s ','');
        if (isRepo!=0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-o ')) {
        query=preQuery.replace('-o ','');
        if (isRepo!=0) { obtainRepo(query); } else { systemUpdate(query); }
    } else if (preQuery.includes('-d ')) {
        query=preQuery.replace('-d ','');
        if (isRepo!=0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes('-u ')) {
        query=preQuery.replace('-u ','');
        if (isRepo!=0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes('-x ')) {
        query=preQuery.replace('-x ','');
        if (isRepo!=0) { terminate(query); } else { uninstall(query); }
    } else if (preQuery.includes(' -r ')) { query=preQuery.split(' -r ');
        if (isRepo!=0) { replaceRepo(query[0],query[1],0);
        } else { replacePackage(query[0],query[1],0); }
    } else if (preQuery.includes(' -p ')) { query=preQuery.split(' -p ');
        if (isRepo!=0) { replaceRepo(query[0],query[1],1);
        } else { replacePackage(query[0],query[1],1); }
    } else if (preQuery.includes(' -m ')) { query=preQuery.split(' -m ');
        if (isRepo!=0) { replaceRepo(query[0],query[1],-1);
        } else { replacePackage(query[0],query[1],-1); }
    } if (isDbg==0) { window.location.reload(); }
}
function executeMacros(input) {
    var output=input,keyVal,transVal,transData,res;
    if (input.startsWith('# ')) { /* SAY SOMETHING... */
    } else if (input.includes(': ')) {
        keyVal=input.split(': '); if (keyVal[0]=='memo') {
            if (keyVal[1].startsWith('+')) {
                transVal=parseInt(keyVal[1].slice(1));
                setdata('memo',(parseInt(Date.now()/1000)+parseInt(transVal)));
            } else if (isNum(keyVal[1])) {
                transVal=parseInt(keyVal[1]);
                setdata('memo',(parseInt(Date.now()/1000)+parseInt(transVal)));
            } else { setdata('memo',''); pauseAudio(alarmPlayer); }
        } else if (keyVal[0]=='slideshow') {
            setdata('slideshow',((isNum(keyVal[1]))?parseFloat(keyVal[1]):0));
        } else if (keyVal[0]=='locations') {
            setdata('locations',keyVal[1]); populateWeatherTable();
        } else if ((keyVal[0]=='melody')||(keyVal[0]=='playlist')||(keyVal[0]=='duration')||(keyVal[0]=='titles')||(keyVal[0]=='codenames')||(keyVal[0]=='projects')) {
        } else if (keyVal[0]=='timezone') {
            setdata(keyVal[0],btoa(keyVal[1]));
        } else if (keyVal[0]=='current') {
		    omniListen(EE2EE.decode(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value,sysDefSeparator.value),false,parseFloat(keyVal[1]));
        } else if (keyVal[0].startsWith('_')) {
            subscribe(keyVal[0].replace('_',''),keyVal[1]);
        } else if (keyVal[1].includes('?rev=')) {
            transVal=keyVal[1].split('?rev=')[1];
            setdata(keyVal[0],keyVal[1].replace(transVal,'').replace('?rev=',''));
        } else { setdata(keyVal[0],keyVal[1]); }
    } else {
        if (input=='reload') {
            window.location.reload();
        } else if (input=='melody') {
            output=input+': '+EE2EE.decode(userdata()[input],sysDefSessionID.value,sysDefNumeric.value,sysDefSeparator.value);
        } else if (input=='timezone') {
            output=input+': '+atob(userdata()[input]);
        } else if (input=='playlist') {
            output=input+': '+showPlaylist();
        } else if ((input=='titles')||(input=='codenames')||(input=='projects')) {
        } else if (input.startsWith('get_')) {
            output=input+': '+getRequestData()[input.replace('get_','')];
        } else if (input.startsWith('post_')) {
            output=input+': '+postRequestData()[input.replace('post_','')];
        } else if (input.endsWith('++')) {
            transVal=input.replace('++',''); if (isNum(userdata()[transVal])) {
		        if ((transVal=='audio_volume')||(transVal=='video_volume')||(transVal=='audio_speed')||(transVal=='video_speed')) {
                    setdata(transVal,superRound((parseFloat(userdata()[transVal])+0.05),2));
	            } else {
		            setdata(transVal,(parseInt(userdata()[transVal])+1));
		        }
            }
        } else if (input.endsWith('--')) {
            transVal=input.replace('--',''); if (isNum(userdata()[transVal])) {
		        if ((transVal=='audio_volume')||(transVal=='video_volume')||(transVal=='audio_speed')||(transVal=='video_speed')) {
                    setdata(transVal,superRound((parseFloat(userdata()[transVal])-0.05),2));
	            } else {
		            setdata(transVal,(parseInt(userdata()[transVal])-1));
		        }
            }
        } else if (input.startsWith('!')) {
            transVal=input.replace('!','');
            if (transVal.includes(',')) {
                transValArr=transVal.toString().split(',');
                for (i=0; i<transValArr.length; i++) {
                    if (isBit(userdata()[transValArr[i]])) {
                        setdata(transValArr[i],flip(userdata()[transValArr[i]]));
                    }
                }
            } else {
                if (isBit(userdata()[transVal])) {
                    setdata(transVal,flip(userdata()[transVal]));
                }
            }
        } else if (input.startsWith('_')) {
            output=input+': '+subscrData()[input.replace('_','')];
        } else { output=input+': '+userdata()[input]; }
    } return output;
}
function executeCode(input) {
    var output=''; if (notNull(input)) {
        var query=input.slice(0,-1),querySep; if (query.includes('; ')) {
            querySep=query.split('; '); for (i=0; i<querySep.length; i++) {
                output+=executeMacros(querySep[i])+"; ";
            } output=output.slice(0,-2);
        } else { output+=executeMacros(query); } output=output+';';
    } return output;
}
function executeFile(name,str='',withReload=false,multiline=false) {
    var dataString='name='+name+'&type=code&blank=&attr=plur';
    $.ajax({ type: "POST", url: "read.php", data: dataString, cache: false,
        success: function(result) {
            var codeExt=result.split(/\r?\n/),strd=strl=[],strs='';
            if (str.includes(',')) {
                strl=str.split(','); for (il in strl) {
                    if (codeExt[strl[il]]!==undefined) {
                        if (multiline!==false) {
                            strs+=codeExt[strl[il]]+'\r\n';
                        } else {
                            executeCode(codeExt[strl[il]]);
                        }
                    }
                } if (multiline!==false) {
                    compose(sysDefSessionID.value,strs.slice(0,-2));
                }
            } else if (str.includes('-')) {
                strd=str.split('-'); if (strd[1]>strd[0]) {
                    for (i=strd[0]; i<=strd[1]; i++) {
                        strl.push(i);
                    }
                } for (il in strl) {
                    if (codeExt[strl[il]]!==undefined) {
                        if (multiline!==false) {
                            strs+=codeExt[strl[il]]+'\r\n';
                        } else {
                            executeCode(codeExt[strl[il]]);
                        }
                    }
                } if (multiline!==false) {
                    compose(sysDefSessionID.value,strs.slice(0,-2));
                }
            } else if ((isInt(str))&&(codeExt[str]!==undefined)) {
                if (multiline!==false) {
                    compose(sysDefSessionID.value,codeExt[str]);
                } else { executeCode(codeExt[str]); }
            } else if (str=='') {
                if (multiline!==false) {
                    compose(sysDefSessionID.value,result);
                } else {
                    for (il in codeExt) {
                        executeCode(codeExt[il]);
                    }
                }
            } else {
                for (il in codeExt) {
                    if (codeExt[il].toLowerCase().includes(str.toLowerCase())) {
                        if (multiline!==false) {
                            compose(sysDefSessionID.value,codeExt[il]); break;
                        } else {
                            executeCode(codeExt[il]); break;
                        }
                    }
                }
            } if ((withReload!==false)&&(multiline!==true)) {
                window.location.reload();
            }
        }
    }); return false;

}
