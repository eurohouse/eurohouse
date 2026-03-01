<script>
function superuser() {
    return ((sysDefIsSession.value!=false)&&(sysDefSessionID.value==sysDefSuperUserName.value));
}
function authstate() {
    return (sysDefIsSession.value!=false);
}
async function registerFont(fontFamily,url,unicodeRange) {
    const font=new FontFace(fontFamily,`url(${url})`,{ unicodeRange });
    await font.load(); document.fonts.add(font);
}
function systemUpdate(query) {
    var parts=query.toString('').split(' ');
    for (i=0; i<parts.length; i++) {
        get(parts[i],'i','');
    }
}
function obtainRepo(query) {
    var parts=query.toString('').split(' ');
    for (i=0; i<parts.length; i++) {
        get(parts[i],'i','','raw');
    }
}
function moveToRecycleBin(name) {
    var itd=(superuser())?'rw':sysDefSessionID.value;
    data(sysDefSessionID.value+'_files/recycle_bin.json','pack',name,'',itd,'re');
}
function restoreFromRecycleBin(name) {
    var itd=(superuser())?'rw':sysDefSessionID.value;
    data(sysDefSessionID.value+'_files/recycle_bin.json','unpack',name,'',itd,'re');
}
function destroyFromRecycleBin(name) {
    var itd=(superuser())?'rw':sysDefSessionID.value;
    data(sysDefSessionID.value+'_files/recycle_bin.json','drop',name,'',itd,'re');
}
function clearRecycleBin() {
    var itd=(superuser())?'rw':sysDefSessionID.value;
    data(sysDefSessionID.value+'_files/recycle_bin.json','clear','','',itd,'re');
}
function isDarkMode() {
    return ((window.matchMedia)&&(window.matchMedia('(prefers-color-scheme: dark)').matches));
}
function alphaHex(hex='#000000',opa='IF') {
    return ('#'+((hex.substring(1,7)).toString())+(((hex.length>7)?(hex.substring(7,9)):((opa=='IF')?'00':((opa=='FI')?'FF':decbase(opa,'0123456789ABCDEF')))).toString())).toUpperCase();
}
function subscrData() {
    var obj={
        <?php $iter=0; foreach ($subscr as $key=>$value) {
            echo "'".$key."': sysDefSubscription".snakeToCamel($key).".value".((count($subscr)==($iter-1))?'':','); $iter++;
        } $iter=0; ?>
    }; return obj;
}
function userdata() {
    var obj = {
        <?php $iter=0; foreach ($settings['defaults'] as $key=>$value) {
            echo "'".$key."': sysDef".snakeToCamel($key).".value".((count($settings['defaults'])==($iter-1))?'':','); $iter++;
        } $iter=0; ?>
    }; return obj;
}
function subscribe(ent,val) {
    var obj=subscrData(); obj[ent]=val;
    set(sysDefSessionID.value+'_files/subscription.json',JSON.stringify(obj),'rw'); <?php foreach ($subscr as $key=>$value) {
        echo "sysDefSubscription".snakeToCamel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent,val) {
    var obj=userdata();obj[ent]=val;
    set(sysDefSessionID.value+'_files/profile.json',JSON.stringify(obj),'rw'); <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".snakeToCamel($key).".value=obj['".$key."'];";
    } ?> if (ent=='font_ascii') { registerFont('euro',val,'U+0000-007F'); }
    if (ent=='font_latin') { registerFont('euro',val,'U+0080-00FF'); }
    if (ent=='font_phone') { registerFont('euro',val,'U+0100-036F'); }
    if (ent=='font_greek') { registerFont('euro',val,'U+0386-03CE'); }
    if (ent=='font_cyril') { registerFont('euro',val,'U+0400-045F'); }
    if (ent=='font_arabi') { registerFont('euro',val,'U+0600-077F'); }
    if (ent=='font_korea') { registerFont('euro',val,'U+1100-11FF, U+3100-318F, U+A000-D7A3'); }
    if (ent=='font_japan') { registerFont('euro',val,'U+2E80-30FF, U+3190-4DFF, U+D7A4-FB1C'); }
    if (ent=='font_other') { registerFont('euro',val,'U+0370-0385, U+03CF-03FF, U+0460-05FF, U+0590-05FF, U+0780-10FF, U+1200-25FF, U+2700-2E7F, U+4E00-9FFF, U+FB1D-1F2FF, U+1F650-1F67F, U+1F700-10FFFF'); }
    if (ent=='font_emoji') { registerFont('euro',val,'U+2600-26FF, U+1F300-1F64F, U+1F680-1F6FF'); }
    if (ent=='audio_volume') { audioPlayer.volume=val; }
    if (ent=='audio_speed') { audioPlayer.playbackRate=val; }
    if (ent=='preserves_pitch') {
        audioPlayer.preservesPitch=(val!=0)?true:false;
    } if (requestMode.value=='sticky_notes') {
        if (ent=='numeric') { myNotesRad.value=val; }
    } if (requestMode.value=='album_tracklist') {
        if ((ent=='album')||(ent=='album_columns')||(ent=='playlist')||(ent=='playlist_columns')) {
            playlistCollectionHTML(); albumCollectionHTML();
        }
    } if (requestMode.value=='media_player') {
        if (ent=='video_volume') { video.volume=val; }
        if (ent=='video_speed') { video.playbackRate=val; }
        if (ent=='preserves_pitch') {
            video.preservesPitch=(val!=0)?true:false;
        }
    } if (requestMode.value=='volume_control') {
        if (ent=='audio_volume') {
            audioVolInd.value=val; audioVolRange.value=val;
        } if (ent=='audio_speed') {
            audioRatInd.value=val; audioRatRange.value=val;
        } if (ent=='video_volume') {
            videoVolInd.value=val; videoVolRange.value=val;
        } if (ent=='video_speed') {
            videoRatInd.value=val; videoRatRange.value=val;
        }
    } if (requestMode.value=='visual_effects') {
        if (ent=='opacity') { opacityRange.value=val; }
        if (ent=='blur') { blurRange.value=val; }
        if (ent=='brightness') { brightnessRange.value=val; }
        if (ent=='saturation') { saturationRange.value=val; }
        if (ent=='contrast') { contrastRange.value=val; }
        if (ent=='sepia') { sepiaRange.value=val; }
        if (ent=='grayscale') { grayscaleRange.value=val; }
        if (ent=='hue') { hueRange.value=val; }
    }
}
function subscription(id) {
    var objData=((jsonarr(sysDefSubscriptions.value)!==undefined)&&(jsonarr(sysDefSubscriptions.value)!==null))?jsonarr(sysDefSubscriptions.value):{}; var dataSel=Object.values(objData[id]||{});
    return ((dataSel!==undefined)&&(dataSel!==null))?dataSel:[];
}
function metadata() { return jsonarr(sysDefMetaData.value); }
function setmeta(ent,val) {
    var obj=metadata(); obj[ent]=val;
    set(sysDefSessionID.value+'_files/metadata.json',JSON.stringify(obj),'rw');
}
function delmeta(ent) {
    var obj=metadata(); delete obj[ent];
    set(sysDefSessionID.value+'_files/metadata.json',JSON.stringify(obj),'rw');
}
function clearJournal(id,obj,name) {
    var resarr=(isObject(obj))?jsonarr(obj.value):jsonarr(obj);
    var lastElem=Object.keys(resarr).length-1; if (isInt(id)) {
        var absNum=Math.abs(id),numDiff=(lastElem-absNum);
        if (id<0) {
            for (i=0; i<absNum; i++) {
                if (notNull(resarr[Object.keys(resarr)[0]])) {
                    delete resarr[Object.keys(resarr)[0]];
                }
            }
        } else {
            for (i=lastElem; i>numDiff; i--) {
                if (notNull(resarr[Object.keys(resarr)[i]])) {
                    delete resarr[Object.keys(resarr)[i]];
                }
            }
        }
    } else {
        if (notNull(resarr[id])) { delete resarr[id]; }
    } set('./'+sysDefSessionID.value+'_files/'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),'rw');
}
function openJournal(id,obj) {
    var resarr=(isObject(obj))?jsonarr(obj.value):jsonarr(obj);
    return (isObject(resarr[id]))?arrjson(resarr[id]):"{\"\":\"\"}";
}
function profileAutoload(id) {
    if (id==sysDefSessionID.value) {
        var arr1=jsonarr(loadFile(id+'_files/profile.json'));
        for (idx in arr1) { setdata(idx,arr1[idx]); }
        omniListen(atob(arr1['melody']),false,parseFloat(arr1['current']));
    }
}
function subscrAutoload(id) {
    if (id==sysDefSessionID.value) {
        var arr1=jsonarr(loadFile(id+'_files/subscription.json'));
        for (idx in arr1) { subscribe(idx,arr1[idx]); }
    }
}
function dataBackup() {
    if (superuser()) {
        var users=(sysDefUsersList.value).split(',');
        for (i=0; i<users.length; i++) {
            data('backup.json','pack',users[i]+'_files/profile.json','','rw');
            data('backup.json','pack',users[i]+'_files/subscription.json','','rw');
            data('backup.json','pack',users[i]+'_files/metadata.json','','rw');
            data('backup.json','pack',users[i]+'_files/password','','rw');
            data('backup.json','pack',users[i]+'_files/messenger.json','','rw');
        }
    }
}
function dataRestore() {
    if (superuser()) {
        var users=Object.keys(jsonarr(loadFile('backup.json'))).map(key=>key.replace(/_files$/,''));
        for (i=0; i<users.length; i++) {
            init_user(users[i]);
            data('backup.json','unpack',users[i]+'_files/profile.json','','rw');
            data('backup.json','unpack',users[i]+'_files/subscription.json','','rw');
            data('backup.json','unpack',users[i]+'_files/metadata.json','','rw');
            data('backup.json','unpack',users[i]+'_files/password','','rw');
            data('backup.json','unpack',users[i]+'_files/messenger.json','','rw');
        } window.location.reload();
    }
}
function userBackup(usr) {
    data(usr+'_backup.json','pack',usr+'_files/profile.json','','rw');
    data(usr+'_backup.json','pack',usr+'_files/subscription.json','','rw');
    data(usr+'_backup.json','pack',usr+'_files/metadata.json','','rw');
    data(usr+'_backup.json','pack',usr+'_files/password','','rw');
    data(usr+'_backup.json','pack',usr+'_files/messenger.json','','rw');
}
function userRestore(usr) {
    data(usr+'_backup.json','unpack',usr+'_files/profile.json','','rw');
    data(usr+'_backup.json','unpack',usr+'_files/subscription.json','','rw');
    data(usr+'_backup.json','unpack',usr+'_files/metadata.json','','rw');
    data(usr+'_backup.json','unpack',usr+'_files/password','','rw');
    data(usr+'_backup.json','unpack',usr+'_files/messenger.json','','rw');
    profileAutoload(usr); subscrAutoload(usr);
}
function delete_user(id) {
    del(id+'_files/password','rw');
    del(id+'_files/messenger.json.bak','rw');
    del(id+'_files/messenger.json','rw');
    del(id+'_files/subscription.json.bak','rw');
    del(id+'_files/metadata.json.bak','rw');
    del(id+'_files/profile.json.bak','rw');
    del(id+'_files/subscription.json','rw');
    del(id+'_files/metadata.json','rw');
    del(id+'_files/profile.json','rw');
    del(id+'_files/subscription.json.bak','rw');
    del(id+'_files/metadata.json.bak','rw');
    del(id+'_files/profile.json.bak','rw');
    del(id+'_files','rw');
}
function rename_user(id,to,pass=null) {
    if (id!=to) {
        init_user(to,pass);
        move(id+'_files/subscription.json',to+'_files/subscription.json',to);
        move(id+'_files/profile.json',to+'_files/profile.json',to);
        move(id+'_files/metadata.json',to+'_files/metadata.json',to);
        move(id+'_files/messenger.json',to+'_files/messenger.json',to);
        delete_user(id);
    } else { init_user(id,pass); }
}
function init_user(id,pass=null) {
    if (isLine(pass)) {
        mkdir('./'+id+'_files','rw');
        set(id+'_files/password',CryptoJS.SHA256(pass).toString(),'rw');
    } var msgData=jsonarr(openJournal(id,sysDefMessengerJSONs));
    if (!notNull(msgData)) {
        mkdir('./'+id+'_files','rw');
        set('./'+id+'_files/messenger.json',JSON.stringify({}),'rw');
    }
}
function indexAvatars(id) {
    var obj=subscription(id),arr=[]; for (idx in obj) {
        if ((id=='avatar')||(id=='pictogram')) {
            arr.push(obj[idx].split('.')[1]);
        }
    } return arr;
}
function enmorse(msg,usr='',abc='.-') {
    return encode(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function demorse(msg,usr='',abc='.-') {
    return decode(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function readPlaylist() {
    var text=atob(sysDefPlaylist.value);
    var arr=art=[]; var trim='';
    if (text.includes('"')) {
        if (text.includes(',')) {
            arr=text.split(','); for (idx in arr) {
                trim=arr[idx].replace(/^[\"\"]|[\"\"]$/g,''); art.push(trim);
            }
        } else {
            trim=text.replace(/^[\"\"]|[\"\"]$/g,'');
            if (trim!='') { art.push(trim); }
        }
    } return art;
}
function showPlaylist() {
    var arr=readPlaylist();
    return arr.map(item=>`"${item}"`).join(',');
}
function playlistNext(name) {
    var arr=readPlaylist();
    if (arr.indexOf('')>-1) {
        arr.splice(arr.indexOf(''),1);
    } if (arr.indexOf(' ')>-1) {
        arr.splice(arr.indexOf(' '),1);
    } if (arr.indexOf(name)>-1) {
        arr.splice(arr.indexOf(name),1);
    } else { arr.push(name); }
    return btoa(arr.map(item=>`"${item}"`).join(','));
}
function populateIpStats(req='') {
    if (requestMode.value=='statistics') {
        let vocEntry=localizedVocWord();
        const tableElem=document.getElementById('ipTable');
        const tableBody=document.getElementById('ipData');
        tableBody.innerHTML='';
        const existingTfoot=document.getElementById('ipFoot');
        if (existingTfoot) { existingTfoot.remove(); }
        const ipTab=jsonarr(sysDefIpData.value);
        let count=Object.keys(ipTab).length;
        if (req!='') {
            if ((req.length==2)&&(req==req.toString().toUpperCase())) {
                for (const ipElem in ipTab) {
                    if (req.toString().toUpperCase()!=ipTab[ipElem]['country']) {
                        delete ipTab[ipElem];
                    }
                }
            } else {
                for (const ipElem in ipTab) {
                    if (req.toString()!=ipTab[ipElem]['user']) {
                        delete ipTab[ipElem];
                    }
                }
            }
        } count=Object.keys(ipTab).length; for (const ipElem in ipTab) {
            const row=tableBody.insertRow();
            const countryCell=row.insertCell();
            const countryIso=ipTab[ipElem]['country'];
            if (countryIso) {
                const img=document.createElement('img');
                img.src=`Flag.${countryIso.toUpperCase()}.png`;
                img.style.height='80px'; countryCell.appendChild(img);
            } row.insertCell().textContent=ipElem;
            row.insertCell().textContent=ipTab[ipElem]['os'];
            row.insertCell().textContent=ipTab[ipElem]['browser'];
            row.insertCell().textContent=ipTab[ipElem]['user'];
        } const tfoot=document.createElement('tfoot');
        tfoot.id='ipFoot'; const footerRow=tfoot.insertRow();
        const footerCell=footerRow.insertCell(); footerCell.colSpan=5;
        footerCell.style.textAlign='center';
        footerCell.style.fontWeight='bold';
        footerCell.style.padding='10px';
        footerCell.textContent=`${vocEntry} ${count}`;
        tableElem.appendChild(tfoot);
    }
}
function playlistCollectionHTML() {
    if (requestMode.value=='album_tracklist') {
        var upn=readPlaylist(); var arl="",plCol=sysDefPlaylistColumns.value; for (iu in upn) {
            arl+="<a href='javascript:omniListen(%22"+rfc3986(upn[iu])+"%22,true);'>"+(parseInt(iu)+1)+'. '+upn[iu]+"</a><br>";
        } currentPlaylist.innerHTML=arl;
        currentPlaylist.setAttribute('style','-webkit-columns:'+plCol+';-moz-columns:'+plCol+';columns:'+plCol+';');
    }
}
function albumCollectionHTML() {
    if (requestMode.value=='album_tracklist') {
        var epr=ept='',alr=indexAvatars(sysDefAlbum.value);
        var alb=subscription(sysDefAlbum.value),arl="";
        var albCol=(((sysDefAlbum.value=='avatar')||(sysDefAlbum.value=='pictogram'))?1:sysDefAlbumColumns.value);
        if (sysDefAlbum.value=='music') {
            for (iu in alb) {
                elid=CryptoJS.SHA256(alb[iu]).toString();
                arl+="<a id='albumEl"+elid+"' href='javascript:setdata(%22playlist%22,playlistNext(%22"+rfc3986(alb[iu])+"%22));'>"+(parseInt(iu)+1)+'. '+alb[iu]+"</a><br>";
            }
        } else if (sysDefAlbum.value=='sound') {
            for (iu in alb) {
                arl+="<a href='javascript:omniListen(%22"+rfc3986(alb[iu])+"%22,true);'>"+alb[iu]+"</a><br>";
            }
        } else if (sysDefAlbum.value=='font') {
            for (iu in alb) {
                arl+="<a href='javascript:omniRead(%22font_book%22,%22"+rfc3986(alb[iu])+"%22,%22"+requestLock.value+"%22);'>"+alb[iu]+"</a><br>";
            }
        } else if (sysDefAlbum.value=='background') {
            for (iu in alb) {
                epr=alb[iu].split('.')[0];
                ept=localizedPkg(epr,'title');
                arl+="<a href='javascript:omniPath("+epr+".collection.json%22,%22%22,%22false%22);'>"+ept+"</a><br>";
            }
        } else if (sysDefAlbum.value=='avatar') {
            epr=sysDefAva1Prefix.value; for (iu in alr) {
                arl+="<input type='image' class='power' src='"+epr+alr[iu]+".png' title='"+alr[iu]+"' style='width:64px;height:64px;' onclick='setdata(&#34;avatar&#34;,&#34;"+alr[iu]+"&#34;);'>";
            }
        } else if (sysDefAlbum.value=='pictogram') {
            epr=sysDefPrefix.value; for (iu in alr) {
                arl+="<input type='image' class='power' src='"+epr+alr[iu]+".png' title='"+(alr[iu].toUpperCase())+"' style='width:48px;height:48px;' onclick='setdata(&#34;mode&#34;,&#34;"+alr[iu]+"&#34;);'>";
            }
        } currentAlbumList.innerHTML=arl;
        currentAlbumList.setAttribute('style','-webkit-columns:'+albCol+';-moz-columns:'+albCol+';columns:'+albCol+';text-align:'+(((sysDefAlbum.value=='avatar')||(sysDefAlbum.value=='pictogram')||(sysDefAlbum.value=='background'))?'center':'left')+';');
    }
}
function filterMessages(str,usr,mask='#') {
    var arr=jsonarr(str);
    var arf={},hbin=hkin='',hbio={};
    if (mask=='#') {
        for (el in arr) {
            hbin=demorse(arr[el],usr);
            hkin=demorse(el,usr),arf[hkin]=hbin;
        }
    } else {
        var arrRegex=XRegExp('(\\#(\\@|\\p{L}|\\p{N}|\\:)+)','g'); var repRegex=XRegExp('(\\#+)','g');
        var wordArr=XRegExp.match(mask,arrRegex);
        for (el in arr) {
            if (wordArr!==null) {
                for (iy in wordArr) {
                    hbin=demorse(arr[el],usr);
                    hkin=demorse(el,usr);
                    hbio=XRegExp.replace(wordArr[iy],repRegex,'');
                    if (hbin.toLowerCase().includes(hbio.toLowerCase())) { arf[hkin]=hbin; }
                }
            }
        }
    } return arf;
}
function messengerHTML(str,usr,mask='#') {
    var arr=filterMessages(str,usr,mask),ard=fu0=fu1='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    for (el in arr) {
        fu0="clearJournal(&#39;"+enmorse(el,usr)+"&#39;,&#39;"+sysDefMyMessengerData.value+"&#39;,&#39;messenger&#39;);";
        fu1="clip(&#39;"+arr[el]+"&#39;);";
        ard="<p><input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='"+fu0+"'> "+el+" <input type='image' class='power' onmouseover='soundButton();' src='"+epr+"copy.png"+"' onclick='"+fu1+"'><br>"+arr[el]+"</p>"+ard;
    } return ard;
}
function notebookHTML(str) {
    var arr=str.split(' | '),ard=arl=eld=elt=eln='';
    var epr=sysDefPrefix.value; for (el in arr) {
        eld=arr[el],eln=sysDefNumeric.value,elt=decode(eld,'',eln);
        arl="<input type='button' onmouseover='soundButton();' style='width:80%;' onclick='openNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);' value='"+elt+"'>";
        arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='deleteNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);'>";
        ard=ard+arl+'<br>';
    } return ard;
}
function toIso8601(num) {
    var ob=new Date(num);
    return (ob.getUTCFullYear())+'-'+pad((ob.getUTCMonth()+1),-2)+'-'+pad((ob.getUTCDate()),-2)+' '+pad((ob.getUTCHours()),-2)+':'+pad((ob.getUTCMinutes()),-2)+':'+pad((ob.getUTCSeconds()),-2)+'.'+pad((ob.getUTCMilliseconds()),-3);
}
function arrangeMenu(list,item,delim=',',sort=false) {
    var arr=list.toString('').split(delim);
    if (arr.indexOf('')>-1) {
        arr.splice(arr.indexOf(''),1);
    } if (arr.indexOf(' ')>-1) {
        arr.splice(arr.indexOf(' '),1);
    } if (arr.indexOf(item)>-1) {
        arr.splice(arr.indexOf(item),1);
    } else { arr.push(item); }
    return (sort)?finarr(arr).join(delim):arr.join(delim);
}
function isInMenu(list,item) {
    var arr=list.toString('').split(',');
    return (arr.indexOf(item)>-1);
}
function localizedPkg(id,ent='title') {
    var mono=loadFile(id+'.package.json',ent);
    var lang=sysDefUnits.value;
    var trans=loadFile(id+'.package.json','language/'+lang+'/'+ent);
    return (notBlank(trans))?trans:((notBlank(mono))?mono:id);
}
function localizedVocWord(ent='Total elements:') {
    var lang=sysDefUnits.value;
    var trans=loadFile('settings.json','vocabulary/'+lang+'/'+ent);
    return (notBlank(trans))?trans:ent;
}
function localizedTitle(id,ent='title') {
    var mono=loadFile(id+'_files/profile.json',ent);
    var lang=loadFile(id+'_files/profile.json','units');
    var trans=loadFile(id+'_files/profile.json',ent+'s');
    var tranArr=strarr(trans,'; ',': ');
    var tranStep=(notNull(tranArr[lang]))?tranArr[lang]:mono;
    return (tranStep.includes(' | '))?tranStep.split(' | ')[0]:tranStep;
}
function processMessage(arr,sen,rec,msg='',index=0) {
    arr[enmorse(localizedTitle(sen)+' (@'+sen+') · '+toIso8601(Date.now()+index*1000)+' UTC',rec)]=enmorse(replaceLineBreaks(msg),rec);
    return arr;
}
function compose(usr,msg) {
    var addr=(msg!=null)?msg.match(/(@\w*)/g):'';
    var argv=(msg!=null)?msg.match(/\{[^\}]*\}/g):'';
    var id=sen=rec=req=msglt='',msgbox={},msgbr=msglr=[];
    var senT=recT=usrT=''; if (addr!=null) {
        for (it in addr) {
            id=addr[it].replace('@','');
            init_user(id);
            sen=(argv!=null)?id:usr;
            rec=(argv!=null)?usr:id;
            senT=localizedTitle(sen);
            recT=localizedTitle(rec);
            msgbox=openJournal(rec,sysDefMessengerJSONs);
            msgarr=jsonarr(msgbox);
            if (msg.match(/\r?\n/)!=null) {
                msgbr=msg.split(/\r?\n/);
                for (j=0; j<msgbr.length; j++) {
                    if (argv!=null) {
                        msglr.push('@'+usr);
                        for (idx in argv) {
                            req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+solveSystem(req).toString()+']');
                        } msglt=msglr.join(' ');
                    } else { msglt=msgbr[j]; }
                    msgarr=processMessage(msgarr,sen,rec,msglt,j);
                }
            } else {
                if (argv!=null) {
                    msglr.push('@'+usr);
                    for (idx in argv) {
                        req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+solveSystem(req).toString()+']');
                    } msglt=msglr.join(' ');
                } else { msglt=msg; }
                msgarr=processMessage(msgarr,sen,rec,msglt);
            } set('./'+rec+'_files/messenger.json',(JSON.stringify(msgarr)),'rw');
        }
    } else {
        msgbox=openJournal(usr,sysDefMessengerJSONs);
        msgarr=jsonarr(msgbox),usrT=localizedTitle(usr);
        if (msg.match(/\r?\n/)!=null) {
            msgbr=msg.split(/\r?\n/);
            for (j=0; j<msgbr.length; j++) {
                if (argv!=null) {
                    msglr.push('@'+usr);
                    for (idx in argv) {
                        req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+solveSystem(req).toString()+']');
                    } msglt=msglr.join(' ');
                } else { msglt=msgbr[j]; }
                msgarr=processMessage(msgarr,usr,usr,msglt,j);
            }
        } else {
            if (argv!=null) {
                msglr.push('@'+usr);
                for (idx in argv) {
                    req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+solveSystem(req).toString()+']');
                } msglt=msglr.join(' ');
            } else { msglt=msg; }
            msgarr=processMessage(msgarr,usr,usr,msglt);
        } set('./'+usr+'_files/messenger.json',(JSON.stringify(msgarr)),'rw');
    }
}
function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('preserves_pitch',sysDefPreservesPitch.value);
    setdata('video_volume',sysDefVideoVolume.value);
    setdata('video_speed',sysDefVideoSpeed.value);
}
function omniListen(input,scratch=false,pos=false) {
    playAudio(audioPlayer,input); var dur=sysDefDuration.value;
    if ((isNum(pos))&&(!isNaN(dur))&&(isFinite(dur))) {
        audioPlayer.currentTime=(pos<0)?(parseFloat(dur)-Math.abs(parseFloat(pos))):parseFloat(pos);
    } else {
        if (scratch) { audioPlayer.currentTime=0;
        } else { audioPlayer.currentTime=parseFloat(sysDefCurrent.value); }
    } setdata('melody',btoa(input));
    setdata('preserves_pitch',sysDefPreservesPitch.value);
    setdata('audio_volume',sysDefAudioVolume.value);
    setdata('audio_speed',sysDefAudioSpeed.value);
}
function omniPlaylist(mode=0) {
    var music=subscription('music');
    var playlist=atob(sysDefPlaylist.value);
    var next=readPlaylist();
    var melody=atob(sysDefMelody.value);
    var index=arraySearch(((melody.startsWith(requestPath.value+'/'))?melody.replace(requestPath.value+'/',''):melody),music);
    if (playlist!='') {
        if (next[0]!='') {
            omniListen(next[0],true);
        } setdata('playlist',playlistNext(next[0]));
    } else {
        if (mode==-1) {
            omniListen((((index>=(music.length-1))||(index===false))?music[0]:music[parseInt(index)+1]),true);
        } else if (mode==-2) {
            omniListen((((index<=0)||(index===false))?music[music.length-1]:music[parseInt(index)-1]),true);
        } else if (mode==1) {
            omniListen(music[rand(0,music.length)],true);
        } else { omniListen(melody,true); }
    }
}
function omniPause() { pauseAudio(audioPlayer); }
function savePlayState() { setdata('current',audioPlayer.currentTime); }
function soundButton(bulk=false) {
    if (bulk!=false) {
        playAudio(soundPlayer,sysDefFocusSound.value);
    } else {
        if (sysDefMute.value==0) {
            playAudio(soundPlayer,sysDefFocusSound.value);
        }
    }
}
function soundClick(bulk=false) {
    if (bulk!=false) {
        playAudio(soundPlayer,sysDefClickSound.value);
    } else {
        if (sysDefMute.value==0) {
            playAudio(soundPlayer,sysDefClickSound.value);
        }
    }
}
function handleInput(val,bulk=false) {
    if (bulk!=false) {
        playAudio(typePlayer,sysDefTypeSound.value);
    } else {
        if (val.length==0) {
            playAudio(errorPlayer,sysDefErrorSound.value);
        }
    }
}
</script>
