function seekImage(req) {
    if (sysDefBackground.value!='') {
        setdata('background','');
    } else {
        var mod=jsonarr(sysDefModelData.value);
        var all=jsonarr(sysDefContentData.value);
        var rqs=rqt=md='',rqd=arr=mt=[];
        if ((req.includes('?'))&&(req.split('?').length==2)) {
            rqd=req.split('?'); rqs=rqd[0]; for (idx in all) {
                if (all[idx].toLowerCase().includes(rqs.toLowerCase())) { arr.push(idx); }
            } rqt=((!isInt(rqd[1]))&&((rqd[1]=='*')||(rqd[1]=='')))?rand(0,arr.length):rqd[1];
        } else if ((req.includes(':'))&&(req.split(':').length==2)) {
            rqd=req.split(':'); rqs=rqd[0]; for (idx in all) {
                if (all[idx].toLowerCase().includes(rqs.toLowerCase())) { arr.push(idx); }
            } rqt=((!isInt(rqd[1]))&&((rqd[1]=='*')||(rqd[1]=='')))?rand(0,arr.length):rqd[1];
        } else {
            rqs=req; for (idx in all) {
                if (all[idx].toLowerCase().includes(rqs.toLowerCase())) { arr.push(idx); }
            } rqt=rand(0,arr.length);
        } setdata('background',((notEmpty(arr))?arr[rqt]:all[rand(0,all.length)]));
    }
}
function seekMusic(req) {
    var mls=subscription('music'),pls=arg=[],arj=ari=arc=itm='',sec=0;
    if (req.includes('://')) {
        var urlObj=new URL(req);
        var urlParam=urlObj.searchParams.get('sec');
        var urlSec=(urlParam!==null)?urlParam:0;
        omniListen(req,true,urlSec);
    } else {
        if ((req.includes('?'))&&(req.includes(':'))) {
            fln=req.split('?')[0],atr=req.split('?')[1];
            fli=atr.split(':')[0],fle=atr.split(':')[1];
            for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } if ((!isInt(fli))&&((fli=='*')||(fli==''))) {
                fli=rand(0,pls.length);
            }
        } else if (req.includes('?')) {
            fln=req.split('?')[0],fli=req.split('?')[1],fle=0;
            for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } if ((!isInt(fli))&&((fli=='*')||(fli==''))) {
                fli=rand(0,pls.length);
            }
        } else if (req.includes(':')) {
            fln=req.split(':')[0],fle=req.split(':')[1];
            for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } fli=rand(0,pls.length);
        } else {
            fln=req,fle=0; for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } fli=rand(0,pls.length);
        } if (notEmpty(pls)) {
            if (fle=='+') {
                setdata('playlist',playlistNext(pls[fli]));
            } else {
                omniListen(pls[fli],true,parseInt(fle));
            }
        } else {
            if (fle=='+') {
                setdata('playlist',playlistNext(mls[rand(0,mls.length)]));
            } else {
                omniListen(mls[rand(0,mls.length)],true,parseInt(fle));
            }
        }
    }
}
function seekCode(req) {
    var macroses=(sysDefCodexBox.value).split(';');
    var speeches=(sysDefSpeechBox.value).split(';');
    var ark=(req.includes(':'))?req.split(':')[0]:req;
    var arv=(req.includes(':'))?req.split(':')[1]:'';
    if (arv!='') {
        for (i=0; i<macroses.length; i++) {
            if (macroses[i].toLowerCase().includes(ark.toLowerCase())) {
                executeFile(macroses[i],arv); break;
            }
        }
    } else {
        for (i=0; i<speeches.length; i++) {
            if (speeches[i].toLowerCase().includes(ark.toLowerCase())) {
                executeFile(speeches[i],arv,false,true); break;
            }
        }
    }
}
function omniEnter() {
    var arb=arc=ari=arj=''; var input=omniBox.value,itr=0,itd=0,arg=[],arh=[],ark={}; var uid=sysDefSessionID.value;
    if ((input.toLowerCase()=='upload')||(input.toLowerCase()=='up')) {
        document.getElementById('filebrowser').click(); return false;
    } else if (input.toLowerCase()=='this') {
        window.location.href='https://yandex.ru/images/search?rpt=imageview&url='+($('body').css('background-image')).replace(/^url\(['"]?(.*?)['"]?\)$/i,'$1');
    } else if (input.toLowerCase()=='save') { userBackup(uid);
    } else if (input.toLowerCase()=='load') { userRestore(uid);
    } else if (input.toLowerCase()=='backup') { dataBackup();
    } else if (input.toLowerCase()=='restore') { dataRestore();
    } else if ((input.toLowerCase()=='louder')||(input.toLowerCase()=='la+')) {
        arb=superRound((parseFloat(sysDefAudioVolume.value)+0.05),2);
        arc=(arb>1)?1:arb; setdata('audio_volume',arc);
    } else if ((input.toLowerCase()=='decibel')||(input.toLowerCase()=='la++')) {
        arb=superRound((parseFloat(sysDefAudioVolume.value)+0.1),2);
        arc=(arb>1)?1:arb; setdata('audio_volume',arc);
    } else if (input.toLowerCase()=='la-') {
        arb=superRound((parseFloat(sysDefAudioVolume.value)-0.05),2);
        arc=(arb<0)?0:arb; setdata('audio_volume',arc);
    } else if (input.toLowerCase()=='la--') {
        arb=superRound((parseFloat(sysDefAudioVolume.value)-0.1),2);
        arc=(arb<0)?0:arb; setdata('audio_volume',arc);
    } else if (input.toLowerCase()=='lv+') {
        arb=superRound((parseFloat(sysDefVideoVolume.value)+0.05),2);
        arc=(arb>1)?1:arb; setdata('video_volume',arc);
    } else if (input.toLowerCase()=='lv++') {
        arb=superRound((parseFloat(sysDefVideoVolume.value)+0.1),2);
        arc=(arb>1)?1:arb; setdata('video_volume',arc);
    } else if (input.toLowerCase()=='lv-') {
        arb=superRound((parseFloat(sysDefVideoVolume.value)-0.05),2);
        arc=(arb<0)?0:arb; setdata('video_volume',arc);
    } else if (input.toLowerCase()=='lv--') {
        arb=superRound((parseFloat(sysDefVideoVolume.value)-0.1),2);
        arc=(arb<0)?0:arb; setdata('video_volume',arc);
    } else if ((input.toLowerCase()=='nightcore')||(input.toLowerCase()=='ra+')) {
        arb=superRound((parseFloat(sysDefAudioSpeed.value)+0.05),2);
        arc=(arb>1.5)?1.5:arb; setdata('audio_speed',arc);
    } else if ((input.toLowerCase()=='nightcore++')||(input.toLowerCase()=='ra++')) {
        arb=superRound((parseFloat(sysDefAudioSpeed.value)+0.1),2);
        arc=(arb>1.5)?1.5:arb; setdata('audio_speed',arc);
    } else if ((input.toLowerCase()=='daycore')||(input.toLowerCase()=='ra-')) {
        arb=superRound((parseFloat(sysDefAudioSpeed.value)-0.05),2);
        arc=(arb<0.5)?0.5:arb; setdata('audio_speed',arc);
    } else if ((input.toLowerCase()=='daycore++')||(input.toLowerCase()=='ra--')) {
        arb=superRound((parseFloat(sysDefAudioSpeed.value)-0.1),2);
        arc=(arb<0.5)?0.5:arb; setdata('audio_speed',arc);
    } else if ((input.toLowerCase()=='spedup')||(input.toLowerCase()=='rv+')) {
        arb=superRound((parseFloat(sysDefVideoSpeed.value)+0.05),2);
        arc=(arb>1.5)?1.5:arb; setdata('video_speed',arc);
    } else if ((input.toLowerCase()=='spedup++')||(input.toLowerCase()=='rv++')) {
        arb=superRound((parseFloat(sysDefVideoSpeed.value)+0.1),2);
        arc=(arb>1.5)?1.5:arb; setdata('video_speed',arc);
    } else if ((input.toLowerCase()=='slowmo')||(input.toLowerCase()=='rv-')) {
        arb=superRound((parseFloat(sysDefVideoSpeed.value)-0.05),2);
        arc=(arb<0.5)?0.5:arb; setdata('video_speed',arc);
    } else if ((input.toLowerCase()=='slowmo++')||(input.toLowerCase()=='rv--')) {
        arb=superRound((parseFloat(sysDefVideoSpeed.value)-0.1),2);
        arc=(arb<0.5)?0.5:arb; setdata('video_speed',arc);
    } else if (input.startsWith('download ')) {
        arb=input.replace('download ','');
        arg=arb.match(/\"([^\"]+)\"|(\S+)/g);
        if (arg.length>1) {
            downloadFile(quote(arg[0]),quote(arg[1]));
        } else {
            downloadFile(quote(arg[0]),quote(arg[0]));
        }
    } else if (input.startsWith('down ')) {
        arb=input.replace('down ','');
        arg=arb.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            downloadFile(quote(arg[0]),quote(arg[1]));
        } else {
            downloadFile(quote(arg[0]),quote(arg[0]));
        }
    } else if (input.startsWith('encode ')) {
        arj=input.replace('encode ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==3) {
            omniBox.value="decode \""+enmorse(quote(arg[0]),quote(arg[1]),quote(arg[2]))+"\" \""+quote(arg[1])+"\" \""+quote(arg[2])+"\"";
        }
    } else if (input.startsWith('decode ')) {
        arj=input.replace('decode ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==3) {
            omniBox.value="encode \""+demorse(quote(arg[0]),quote(arg[1]),quote(arg[2]))+"\" \""+quote(arg[1])+"\" \""+quote(arg[2])+"\"";
        }
    } else if (input.startsWith('decbase ')) {
        arj=input.replace('decbase ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            omniBox.value="basedec \""+decbase(quote(arg[0]),quote(arg[1]))+"\" \""+quote(arg[1])+"\"";
        }
    } else if (input.startsWith('basedec ')) {
        arj=input.replace('basedec ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            omniBox.value="decbase \""+basedec(quote(arg[0]),quote(arg[1]))+"\" \""+quote(arg[1])+"\"";
        }
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
        if (arg.length>2) {
            set(quote(arg[0]),quote(arg[1]),itd,quote(arg[2]),'re');
        } else if (arg.length==2) {
            set(quote(arg[0]),quote(arg[1]),itd,'0777','re');
        } else if (arg.length==1) {
            set(quote(arg[0]),'',itd,'0777','re');
        }
    } else if (input.startsWith('touch ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('touch ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>2) {
            set(quote(arg[0]),quote(arg[1]),itd,quote(arg[2]),'re');
        } else if (arg.length==2) {
            set(quote(arg[0]),quote(arg[1]),itd,'0777','re');
        } else if (arg.length==1) {
            set(quote(arg[0]),'',itd,'0777','re');
        }
    } else if (input.startsWith('chmod ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('chmod ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            chmod(quote(arg[0]),quote(arg[1]),itd,'re');
        } else if (arg.length==1) {
            chmod(quote(arg[0]),'0777',itd,'re');
        }
    } else if (input.startsWith('rm ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('rm ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>0) {
            for (i=0; i<arg.length; i++) {
                del(quote(arg[i]),itd);
            } window.location.reload();
        }
    } else if (input.startsWith('del ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('del ','');
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
            move(quote(arg[0]),quote(arg[1]),itd,'0777','re');
        }
    } else if (input.startsWith('move ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('move ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            move(quote(arg[0]),quote(arg[1]),itd,'0777','re');
        }
    } else if (input.startsWith('cp ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('cp ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            for (i=1; i<arg.length; i++) {
                copy(quote(arg[0]),quote(arg[i]),itd);
            } window.location.reload();
        }
    } else if (input.startsWith('copy ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('copy ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            for (i=1; i<arg.length; i++) {
                copy(quote(arg[0]),quote(arg[i]),itd);
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
    } else if (input.startsWith('read ')) {
        arj=input.replace('read ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        omniBox.value=(arg.length==2)?loadFile(quote(arg[0]),quote(arg[1])):loadFile(quote(arg[0]));
    } else if (input.startsWith('data ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('data ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==4) {
            data(quote(arg[0]),quote(arg[1]),quote(arg[2]),quote(arg[3]),itd,'r');
        } else if (arg.length==3) {
            data(quote(arg[0]),quote(arg[1]),quote(arg[2]),'',itd,'r');
        } else {
            data(quote(arg[0]),quote(arg[1]),'','',itd,'r');
        }
    } else if (input.startsWith('appstore ')) {
        getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('appstore ','')).toString()).value,'get ',0);
    } else if (input.startsWith('as ')) {
        getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('as ','')).toString()).value,'get ',0);
    } else if (input.startsWith('playstore ')) {
        getPkgSequence('get -i '+document.getElementById('downloadChannel'+CryptoJS.MD5(input.replace('playstore ','')).toString()).value,'get ',0);
    } else if (input.startsWith('ps ')) {
        getPkgSequence('get -i '+document.getElementById('downloadChannel'+CryptoJS.MD5(input.replace('ps ','')).toString()).value,'get ',0);
    } else if (input.startsWith('clear ')) {
        clearJournal(input.replace('clear ',''),sysDefMyMessengerData,'messenger');
    } else if (input.startsWith('get ')) {
        getPkgSequence(input,'get ',0);
    } else if (input.startsWith('git ')) {
        getPkgSequence(input,'git ',1);
    } else if (input.includes('@')) {
        if (input.startsWith('@')) {
            arb=input.replace('@',''); if (arb.includes(':')) {
                arg=arb.split(':');
                arc=CryptoJS.SHA256(arg[1]).toString();
                omniAuthRequest('signin',arg[0],arc);
            } else {
                arc=CryptoJS.SHA256('').toString();
                omniAuthRequest('signin',arb,arc);
            }
        } else {
            arg=input.split('@'); if (arg[0].includes(':')) {
                arh=arg[0].split(':');
                arc=CryptoJS.SHA256(arh[1]).toString();
                if (arg[1].includes('signin')) {
                    omniAuthRequest('signin',arh[0],arc);
                } else if (arg[1].includes('signup')) {
                    omniAuthRequest('signup',arh[0],arc);
                } else if (arg[1].includes('rename')) {
                    rename_user(uid,arh[0],arh[1]);
                    omniAuthRequest('signin',arh[0],arc);
                } else if (arg[1].includes('reset')) {
                    if (superuser()) {
                        rename_user(arh[0],arh[0],arh[1]);
                        omniAuthRequest('signin',arh[0],arc);
                    }
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
                } else if (arg[1].includes('reset')) {
                    if (superuser()) {
                        rename_user(arg[0],arg[0],'');
                        omniAuthRequest('signin',arg[0],arc);
                    }
                } else if (arg[1].includes('delete')) {
                    itr=0; if (arg[0].includes(',')) {
                        arj=arg[0].split(','); for (idx in arj) {
                            if (superuser()) { delete_user(arj[idx]);
                            } else {
                                if (arj[idx]==uid) {
                                    itr++; delete_user(arj[idx]);
                                }
                            }
                        }
                    } else {
                        if (superuser()) { delete_user(arg[0]);
                        } else {
                            if (arg[0]==uid) {
                                itr++; delete_user(arg[0]);
                            }
                        }
                    } if (itr>0) { omniAuthRequest(); }
                } else if (arg[1].includes('create')) {
                    if (arg[0].includes(',')) {
                        arj=arg[0].split(','); for (idx in arj) {
                            if (superuser()) { init_user(arj[idx]); }
                        }
                    } else {
                        if (superuser()) { init_user(arg[0]); }
                    }
                } else if (arg[1].includes('find')) {
                    if (arg[0].startsWith('#')) {
                        setdata('find',arg[0]);
                    }
                } else if (arg[1].includes('sort')) {
                    if (arg[0].startsWith('->')) {
                        omniSort(arg[0].replace('->',''));
                    }
                } else if (arg[1].includes('index')) {
                    if (arg[0].startsWith('?')) {
                        omniDisp(arg[0].replace('?',''));
                    }
                } else if (arg[1].includes('entry')) {
                    if (arg[0].startsWith('_')) {
                        omniGo(arg[0].replace('_',''));
                    }
                } else if (arg[1].includes('file')) {
                    if (arg[0].startsWith('./')) {
                        omniRead(requestMode.value,arg[0],requestLock.value);
                    }
                }
            }
        }
    } else if ((input.match(/([\w|\s]{2,})(?:\:)$/gi))||(input.match(/([\w|\s]{2,})(?:\:)([\w|\s|\*]{2,})$/gi))) { seekCode(input);
    } else if ((input.startsWith('+'))&&(input.toLowerCase().endsWith('t'))) {
        arb=parseInt(input.slice(1,-1));
        setdata('memo',(parseInt(Date.now()/1000)+parseInt(arb)));
    } else if ((input.startsWith('+'))&&(input.toLowerCase().endsWith('s'))) {
        arb=parseFloat(input.slice(1,-1)); setdata('slideshow',arb);
    } else if ((input.startsWith('+'))&&(input.toLowerCase().endsWith('r'))) {
        arb=parseFloat(input.slice(1,-1));
        omniListen(atob(sysDefMelody.value),false,arb);
    } else if ((input.startsWith('-'))&&(input.toLowerCase().endsWith('r'))) {
        arb=parseFloat(input.slice(0,-1));
        omniListen(atob(sysDefMelody.value),false,arb);
    } else if (input.endsWith(';')) {
        omniBox.value=executeCode(input);
    } else if (/\[.*?\]/gi.test(input)) {
        omniBox.value=setCalculator.evaluate(input);
    } else { omniBox.value=solveSystem(input); } omniBox.focus();
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
    var output=input,rep,san;
    if (input.startsWith('# ')) { /* SAY SOMETHING... */
    } else if (input.includes(': ')) {
        rep=input.split(': ');
        if (rep[0]=='memo') {
            if ((rep[1]=='')||(rep[1]==0)) {
                setdata('memo',''); pauseAudio(alarmPlayer);
            } else { setdata('memo',solveSystem(rep[1])); }
        } else if (rep[0]=='locations') {
            setdata('locations',rep[1]); populateWeatherTable();
        } else if ((rep[0]=='playlist')||(rep[0]=='duration')||(rep[0]=='titles')||(rep[0]=='codenames')||(rep[0]=='projects')) {
        } else if (rep[0]=='melody') {
            omniListen(rep[1],false,sysDefCurrent.value);
        } else if (rep[0]=='timezone') {
            setdata(rep[0],btoa(rep[1]));
        } else if (rep[0]=='current') {
            omniListen(atob(sysDefMelody.value),false,parseFloat(rep[1]));
        } else if (rep[0].startsWith('_')) {
            subscribe(rep[0].replace('_',''),rep[1]);
        } else if (rep[1].includes('?rev=')) {
            san=rep[1].split('?rev=')[1];
            setdata(rep[0],rep[1].replace(san,'').replace('?rev=',''));
        } else { setdata(rep[0],rep[1]); }
    } else {
        if ((input=='melody')||(input=='timezone')) {
            output=input+': '+atob(userdata()[input]);
        } else if (input=='playlist') {
            output=input+': '+showPlaylist();
        } else if ((input=='titles')||(input=='codenames')||(input=='projects')) {
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
