function executeMacros(input) {
    var output=input,rep,san;
    if (input.startsWith('# ')) { /* SAY SOMETHING... */
    } else if (input.includes(': ')) {
        rep=input.split(': '); if (rep[0]=='memo') {
            if ((rep[1]=='')||(rep[1]==0)) {
                setdata('memo',''); pauseAudio(alarmPlayer);
            } else { setdata('memo',rep[1]); }
        } else if (rep[0]=='melody') { omniListen(rep[1],true);
        } else if (rep[0]=='playlist') { } else if (rep[0]=='current') {
            audioPosition((rep[1].startsWith('+'))?rep[1].replaceAll('+',''):rep[1]);
        } else if (rep[0].startsWith('lock_')) { setlock(rep[0].replace('lock_',''), rep[1]);
        } else if (rep[1].includes('?rev=')) { san=rep[1].split('?rev=')[1];
            setdata(rep[0],rep[1].replace(san,'').replace('?rev=',''));
        } else { setdata(rep[0],rep[1]); }
    } else {
        if (input.startsWith('lock_')) {
            output=input+': '+lockdata()[input.replace('lock_','')];
        } else if ((input=='melody')) {
            output=input+': '+demorse(userdata()[input],sysDefSessionID.value,sysDefNumeric.value);
        } else if ((input=='playlist')) {
            output=input+': '+decipher(userdata()[input],sysDefSessionID.value,sysDefNumeric.value);
        } else { output=input+': '+userdata()[input]; }
    } return output;
}
function executeCode(input) {
    var output=''; if (input!==undefined) {
        var query=input.slice(0,-1),querySep; if (query.includes('; ')) {
            querySep=query.split('; '); for (i=0; i<querySep.length; i++) {
                output+=executeMacros(querySep[i])+"; ";
            } output=output.slice(0,-2);
        } else { output+=executeMacros(query); } output=output+';';
    } return output;
}
function readFile(name,opt='read',path='',store='user_content') {
    var dataString='name='+name+'&type=code&blank=&attr=plur';
    $.ajax({ type: "POST", url: "read.php", data: dataString, cache: false,
        success: function(result) {
            if (opt=='read') {
                var arr=jsonarr(result),ob; if (path!='') {
                    if (path.includes('/')) {
                        ob=arr; for (chk in path.split('/')) {
                            ob=ob[path.split('/')[chk]];
                        }
                    } else { ob=arr[path]; }
                } else { ob=arr; }
                if (typeof(ob)=='object') {
                    localStorage.setItem(store,JSON.stringify(ob));
                } else { localStorage.setItem(store,ob); }
            } else { localStorage.setItem(store,result); }
        }
    });
}
function executeFile(name,str='',re=false,sp=false) {
    var dataString='name='+name+'&type=code&blank=&attr=plur';
    $.ajax({ type: "POST", url: "read.php", data: dataString, cache: false,
        success: function(result) {
            var codeExt=result.split(/\r?\n/),strd=strl=[],strs='';
            if (str.includes(',')) {
                strl=str.split(','); for (il in strl) {
                    if (codeExt[strl[il]]!==undefined) {
                        if (sp!==false) { strs+=codeExt[strl[il]]+'\r\n';
                        } else { executeCode(codeExt[strl[il]]); }
                    }
                } if (sp!==false) { compose(strs.slice(0,-2)); }
            } else if (str.includes('-')) {
                strd=str.split('-'); if (strd[1]>strd[0]) {
                    for (i=strd[0]; i<=strd[1]; i++) { strl.push(i); }
                } for (il in strl) {
                    if (codeExt[strl[il]]!==undefined) {
                        if (sp!==false) { strs+=codeExt[strl[il]]+'\r\n';
                        } else { executeCode(codeExt[strl[il]]); }
                    }
                } if (sp!==false) { compose(strs.slice(0,-2)); }
            } else if (isInt(str)) {
                if (sp!==false) { compose(codeExt[str]);
                } else { executeCode(codeExt[str]); }
            } else if (str=='') { if (sp!==false) { compose(result);
                } else { for (il in codeExt) { executeCode(codeExt[il]); }}
            } else {
                for (il in codeExt) {
                    if (codeExt[il].toLowerCase().includes(str.toLowerCase())) {
                        if (sp!==false) { compose(codeExt[il]); break;
                        } else { executeCode(codeExt[il]); break; }
                    }
                }
            } if (re!==false) { if (sp===false) { window.location.reload(); }}
        }
    }); return false;
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
function pipeExec(input) {
    var exr,brd,ark,arv,lnt,mls=lockarr('music'),pls=[];
    var elm,fln,atr,fli,fle,ard='',inc=0;
    if (input.includes('/')) {
        exr=(input.endsWith('/')),pipes=input.split('/');
        brd=(exr)?(pipes.length-2):(pipes.length-1);
        lnt=(sysDefCodexBox.value).split('//');
        for (it in pipes) {
            if ((it>=1)&&(it<=brd)) {
                if (pipes[it].includes(':')) {
                    ark=pipes[it].split(':')[0];
                    arv=pipes[it].split(':')[1];
                } else { ark=pipes[it]; arv=''; }
                for (i=0; i<lnt.length; i++) {
                    if (lnt[i].toLowerCase().includes(ark.toLowerCase())) {
                        executeFile(lnt[i],arv,exr); break;
                    }
                }
            }
        }
    } else if (input.includes('!')) {
        exr=(input.endsWith('!')),pipes=input.split('!');
        brd=(exr)?(pipes.length-2):(pipes.length-1);
        lnt=(sysDefSpeechBox.value).split('//');
        for (it in pipes) {
            if ((it>=1)&&(it<=brd)) {
                if (pipes[it].includes(':')) {
                    ark=pipes[it].split(':')[0];
                    arv=pipes[it].split(':')[1];
                } else { ark=pipes[it]; arv=''; }
                for (i=0; i<lnt.length; i++) {
                    if (lnt[i].toLowerCase().includes(ark.toLowerCase())) {
                        executeFile(lnt[i],arv,exr,true); break;
                    }
                }
            }
        }
    } else if (input.includes('\\')) {
        exr=(input.endsWith('\\')),pipes=input.split('\\');
        brd=(exr)?(pipes.length-2):(pipes.length-1);
        for (it in pipes) {
            elm=pipes[it]; if ((it>=1)&&(it<=brd)) {
                if ((elm.includes('?'))&&(elm.includes(':'))) {
                    fln=elm.split('?')[0]; atr=elm.split('?')[1]; fli=atr.split(':')[0]; fle=atr.split(':')[1];
                } else if (elm.includes('?')) {
                    fln=elm.split('?')[0]; fli=elm.split('?')[1]; fle=0;
                } else if (elm.includes(':')) {
                    fln=elm.split(':')[0]; fle=elm.split(':')[1]; fli=0;
                } else { fln=elm; fli=0; fle=0; }
                for (i=0; i<mls.length; i++) {
                    if (mls[i].toLowerCase().includes(fln.toLowerCase())) { pls.push(mls[i]); }
                } inc=0; if (((it==1)&&(it==brd))||((it==1)&&(it<brd))) {
                    for (j=0; j<mls.length; j++) {
                        if ((mls[j].toLowerCase().includes(fln.toLowerCase()))&&(isInt(fle))) {
                            if (input.endsWith('\\')) {
                                if ((isInt(fli))&&(inc>=fli)) {
                                    omniListen(mls[j],true,parseInt(fle)); break;
                                } else if (fli=='*') {
                                    omniListen(pls[rand(0,pls.length)],true,parseInt(fle)); break;
                                }
                            } else {
                                if ((isInt(fli))&&(inc>=fli)) {
                                    setdata('playlist',playlistNext(mls[j])); break;
                                } else if (fli=='*') {
                                    setdata('playlist',playlistNext(pls[rand(0,pls.length)])); break;
                                }
                            } inc++;
                        } if (input.endsWith('\\')) {
                            omniPause();
                        }
                    }
                } else if (((it>1)&&(it<brd))||((it>1)&&(it==brd))) {
                    for (j=0; j<mls.length; j++) {
                        if ((mls[j].toLowerCase().includes(fln.toLowerCase()))&&(isInt(fle))) {
                            if ((isInt(fli))&&(inc>=fli)) {
                                ard=arrangeMenu(sysDefPlaylist.value,enmorse(mls[j],sysDefSessionID.value,sysDefNumeric.value),' | '); setdata('playlist',ard); break;
                            } else if (fli=='*') {
                                ard=arrangeMenu(sysDefPlaylist.value,enmorse(pls[rand(0,pls.length)],sysDefSessionID.value,sysDefNumeric.value),' | '); setdata('playlist',ard); break;
                            } inc++;
                        }
                    }
                }
            }
        }
    }
}
function omniEnter() {
    var input=omniBox.value,arb='',arc='',arj='';
    var itr=0,itd=0,arg=[],arh=[],ark={};
    var uid=sysDefSessionID.value;
    if (input.toLowerCase()=='reload') { window.location.reload();
    } else if (input.toLowerCase()=='refresh') {
        window.location.reload();
    } else if (input.toLowerCase()=='upload') {
        document.getElementById('filebrowser').click(); return false;
    } else if (input.toLowerCase()=='save') {
        userBackup(uid);
    } else if (input.toLowerCase()=='load') {
        userRestore(uid);
    } else if (input.toLowerCase()=='play') {
        omniListen(demorse(sysDefMelody.value,uid,sysDefNumeric.value));
    } else if (input.toLowerCase()=='pause') { omniPause();
    } else if (input.toLowerCase()=='nightcore') {
        arb=superRound((parseFloat(sysDefAudioSpeed.value)+0.05),2);
        arc=(arb>1.5)?1.5:arb; setdata('audio_speed',arc);
    } else if (input.toLowerCase()=='daycore') {
        arb=superRound((parseFloat(sysDefAudioSpeed.value)-0.05),2);
        arc=(arb<0.5)?0.5:arb; setdata('audio_speed',arc);
    } else if (input.toLowerCase()=='spedup') {
        arb=superRound((parseFloat(sysDefVideoSpeed.value)+0.05),2);
        arc=(arb>1.5)?1.5:arb; setdata('video_speed',arc);
    } else if (input.toLowerCase()=='slowmo') {
        arb=superRound((parseFloat(sysDefVideoSpeed.value)-0.05),2);
        arc=(arb<0.5)?0.5:arb; setdata('video_speed',arc);
    } else if (input=='::::') { setdata('banner','none');
    } else if (input==':::') { setdata('banner','');
    } else if (input=='::') {
        arg=Object.keys(jsonarr(sysDefContentData.value));
        setdata('banner',arg[rand(0,arg.length)]);
    } else if (input=='\\=') {
        omniBox.value='\\='+demorse(sysDefMelody.value,uid,sysDefNumeric.value);
    } else if ((input.startsWith('"'))&&(input.endsWith('"'))) {
        compose(input.replace('"','').slice(0,-1));
    } else if (input.startsWith('store ')) {
        arb=input.replace('store ','');
        ark=jsonarr(openJournal(sysDefSessionID.value,sysDefStoreJSONs)); arg=arb.match(/\"([^\"]+)\"|(\w+)/g);
        if (!cancelled(uid)) {
        if (quote(arg[0])=='produce') {
            if ((ark[quote(arg[1])]!==undefined)&&(typeof(ark[quote(arg[1])])=='object')) {
                itr=(arg.length>2)?((isInt(quote(arg[2])))?parseInt(quote(arg[2])):1):1;
                itd=(isInt(ark[quote(arg[1])]['amount'])&&(ark[quote(arg[1])]['amount']>=0))?(parseInt(ark[quote(arg[1])]['amount'])+itr):itr;
                ark[quote(arg[1])]['amount']=itd;
            }
        } else if (quote(arg[0])=='reduce') {
            if ((ark[quote(arg[1])]!==undefined)&&(typeof(ark[quote(arg[1])])=='object')) {
                itr=(arg.length>2)?((isInt(quote(arg[2])))?parseInt(quote(arg[2])):1):1;
                itd=(isInt(ark[quote(arg[1])]['amount'])&&(ark[quote(arg[1])]['amount']>=0))?(parseInt(ark[quote(arg[1])]['amount'])-itr):itr;
                ark[quote(arg[1])]['amount']=itd;
            }
        } else if (quote(arg[0])=='delete') {
            if (arg.length>1) {
                for (i=1; i<arg.length; i++) {
                    if (ark[quote(arg[i])]!==undefined) {
                        delete ark[quote(arg[i])];
                    }
                }
            }
        } else if (quote(arg[0])=='rename') {
            if (ark[quote(arg[1])]!==undefined) {
                ark[quote(arg[2])]=ark[quote(arg[1])];
                delete ark[quote(arg[1])];
            }
        } else if (quote(arg[0])=='finite') {
            if ((ark[quote(arg[1])]!==undefined)&&(typeof(ark[quote(arg[1])])=='object')) { ark[quote(arg[1])]['finite']=1; }
        } else if (quote(arg[0])=='infinite') {
            if ((ark[quote(arg[1])]!==undefined)&&(typeof(ark[quote(arg[1])])=='object')) { ark[quote(arg[1])]['finite']=0; }
        } else {
            if ((ark[quote(arg[1])]!==undefined)&&(typeof(ark[quote(arg[1])])=='object')&&(quote(arg[0])!='amount')) {
                itr=(arg.length>2)?((isNum(quote(arg[2])))?parseFloat(quote(arg[2])):quote(arg[2])):ark[quote(arg[1])][quote(arg[0])]; ark[quote(arg[1])][quote(arg[0])]=itr;
            }
        }} set('./'+uid+'_store.json',encodeURIComponent(JSON.stringify(ark)),'rw');
    } else if (input.startsWith('sell ')) {
        arj=input.replace('sell ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        sell_item(uid,quote(arg[0]),quote(arg[1]));
    } else if (input.startsWith('mkdir ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('mkdir ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                mkdir(quote(arg[i]),itd);
            } window.location.reload();
        }
    } else if (input.startsWith('set ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('set ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            set(quote(arg[0]),quote(arg[1]),itd); window.location.reload();
        } else if (arg.length==1) {
            set(quote(arg[0]),'',itd);
            window.location.reload();
        }
    } else if (input.startsWith('chmod ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('chmod ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            chmod(quote(arg[0]),quote(arg[1]),itd);
            window.location.reload();
        } else if (arg.length==1) {
            chmod(quote(arg[0]),'0777',itd);
            window.location.reload();
        }
    } else if (input.startsWith('rm ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('rm ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                del(quote(arg[i]),itd);
            } window.location.reload();
        }
    } else if (input.startsWith('mv ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('mv ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            move(quote(arg[0]),quote(arg[1]),itd);
            window.location.reload();
        }
    } else if (input.startsWith('cp ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('cp ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            for (i=1; i<arg.length; i++) {
                copy(quote(arg[0]),quote(arg[i]),itd);
            } window.location.reload();
        }
    } else if (input.startsWith('update ')) {
        getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('update ','')).toString()).value,'get ',0);
    } else if (input.startsWith('clear ')) {
        clearJournal(input.replace('clear ',''),sysDefMyMsgboxData,'msgbox');
    } else if (input.startsWith('erase ')) {
        clearJournal(input.replace('erase ',''),sysDefMyBookData,'book');
    } else if (input.startsWith('purge ')) {
        clearJournal(input.replace('purge ',''),sysDefIpData,'visitors',true);
    } else if (input.startsWith('get ')) {
        getPkgSequence(input,'get ',0);
    } else if (input.startsWith('git ')) {
        getPkgSequence(input,'git ',1);
    } else if (input.startsWith('lock ')) {
        omniBox.value=lockarr(input.replace('lock ','')).join(' | ');
    } else if (input.startsWith('count ')) {
        omniBox.value=lockarr(input.replace('count ','')).length;
    } else if (input.includes('#')&&(input.endsWith('/'))) {
        arg=input.slice(0,-1).split('#');
        omniBox.value=decbase(arg[0],arg[1])+'#'+arg[1]+'\\';
    } else if (input.includes('#')&&(input.endsWith('\\'))) {
        arg=input.slice(0,-1).split('#');
        omniBox.value=basedec(arg[0],arg[1])+'#'+arg[1]+'/';
    } else if (input.startsWith('::')) {
        arb=input.replace('::','');
        if ((arb.includes('.'))&&(arb.split('.').length==3)) {
            setdata('banner',arb+'.png');
        } else {
            ark=jsonarr(sysDefContentData.value);
            arh=[]; for (idx in ark) {
                if (ark[idx].toLowerCase().includes(arb.toLowerCase())) { arh.push(idx); }
            } setdata('banner',arh[rand(0,arh.length)]);
        }
    } else if (input.startsWith('->')) {
        omniSwitch(input.replace('->',''));
    } else if (input.startsWith('\\=')) {
        arb=input.replace('\\=','');
        if (arb.includes('://')) { omniListen(arb,true);
        } else {
            if ((arb.includes('/'))&&(arb.split('/').length==2)) {
                arg=arb.split('/'); if (isInt(arg[0])) {
                    arc='https://github.com/lovehotcoffee/'+parseInt(arg[0])+'/blob/main/'+arg[1]+'?raw=true';
                } else {
                    arc='https://github.com/infofintech/'+arg[0]+'/blob/main/'+arg[1]+'?raw=true';
                }
            } omniListen(arc,true);
        }
    } else if (input.startsWith('./')) {
        omniRead(requestMode.value,input.replace('./',''),requestLock.value);
    } else if (input.startsWith('_/')) {
        omniPathDir(input.replace('_/',''),requestMode.value);
    } else if (input.startsWith('>')) {
        arb=input.replace('>',''); if (arb.endsWith('-')) {
            arc=arb.replace('-',''); administer(arc,'-');
        } else if (arb.endsWith('+')) {
            arc=arb.replace('+',''); administer(arc,'+');
        }
    } else if (input.startsWith('~')) {
        arb=input.replace('~',''),itr=0; if (arb.includes(',')) {
            arj=arb.split(','); for (idx in arj) {
                if (superuser()) { delete_user(arj[idx]);
                } else {
                    if (arj[idx]==uid) {
                        itr++; delete_user(arj[idx]);
                    }
                }
            }
        } else {
            if (superuser()) { delete_user(arb);
            } else {
                if (arb==uid) { itr++; delete_user(arb); }
            }
        } if (itr>0) { omniAuthRequest('signout','',''); }
    } else if (input.startsWith('&')) {
        bind(uid,input.replace('&',''));
    } else if (input.startsWith('$')) {
        equip(uid,input.replace('$',''));
    } else if (input.startsWith('#')) {
        setdata('find',input);
    } else if (input.startsWith('_')) {
        omniGo(input.replace('_',''));
    } else if (input.startsWith('=')) {
        window.location.href=input.replace('=','');
    } else if (input.includes('@')) {
        if (input.startsWith('@')) {
            arb=input.replace('@','');
            if (arb.includes(':')) {
                arg=arb.split(':');
                arc=CryptoJS.SHA256(arg[1]).toString();
                omniAuthRequest('signin',arg[0],arc);
            } else {
                arc=CryptoJS.SHA256('').toString();
                omniAuthRequest('signin',arb,arc);
            }
        } else {
            arg=input.split('@');
            if (arg[0].includes(':')) {
                arh=arg[0].split(':');
                arc=CryptoJS.SHA256(arh[1]).toString();
                if (arg[1].includes('signin')) {
                    omniAuthRequest('signin',arh[0],arc);
                } else if (arg[1].includes('signup')) {
                    omniAuthRequest('signup',arh[0],arc);
                } else if (arg[1].includes('rename')) {
                    rename_user(uid,arh[0],arh[1]);
                    omniAuthRequest('signin',arh[0],arc);
                }
            } else {
                arc=CryptoJS.SHA256('').toString();
                if (arg[1].includes('signin')) {
                    omniAuthRequest('signin',arg[0],arc);
                } else if (arg[1].includes('signup')) {
                    omniAuthRequest('signup',arg[0],arc);
                } else if (arg[1].includes('rename')) {
                    rename_user(uid,arg[0],'');
                    omniAuthRequest('signin',arg[0],arc);
                }
            }
        }
    } else if ((input.startsWith('?'))||(input.endsWith('?'))||((input.startsWith('?'))&&(input.endsWith('?')))) {
        omniDisp(requestMode.value,input.replaceAll('?',''),requestLock.value);
    } else if (input.endsWith(';')) {
        omniBox.value=executeCode(input);
    } else if ((input.startsWith('/'))||(input.startsWith('\\'))||(input.startsWith('!'))) { pipeExec(input);
    } else if ((input.includes('|'))||(input.includes('&'))||(input.includes('~'))||(input.includes('^'))) {
        omniBox.value=finarr(arrmath(input)).join(';');
    } else if ((input.startsWith('+'))&&(input.endsWith('"'))) {
        arb=parseInt(input.replace('+','').replace('"',''))+1;
        setdata('memo',(Math.round(Date.now()/1000)+parseInt(arb)));
    } else if ((input.startsWith('+'))&&(input.endsWith("'"))) {
        arb=parseInt(input.replace('+','').replace("'",''))*60+1;
        setdata('memo',(Math.round(Date.now()/1000)+parseInt(arb)));
    } else { omniBox.value=calc(input); } omniBox.focus();
}
