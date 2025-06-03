<script>
function lockdata() {
    var obj={
        <?php $iter=0; foreach ($locks as $key=>$value) {
            echo "'".$key."': lock".snakeToCamel($key).".value".((count($locks)==($iter-1))?'':','); $iter++;
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
function setlock(ent,val) {
    var obj=lockdata(); obj[ent]=val;
    set(sysDefSessionID.value+'_lock.json',JSON.stringify(obj),'rw'); <?php foreach ($locks as $key=>$value) {
        echo "lock".snakeToCamel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent,val) {
    var obj=userdata();obj[ent]=val;
    set(sysDefSessionID.value+'_session.json',JSON.stringify(obj),'rw'); <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".snakeToCamel($key).".value=obj['".$key."'];";
    } ?> if (ent=='audio_volume') { audioPlayer.volume=val; }
    if (ent=='audio_speed') { audioPlayer.playbackRate=val; }
    if (ent=='pitch_lock') {
        audioPlayer.preservesPitch=(val!=0)?true:false;
    } if (requestMode.value=='sticky_notes') {
        if (ent=='numeric') { myNotesRad.value=val; }
    } if (requestMode.value=='media_player') {
        if (ent=='video_volume') { video.volume=val; }
        if (ent=='video_speed') { video.playbackRate=val; }
        if (ent=='pitch_lock') {
            video.preservesPitch=(val!=0)?true:false;
        }
    } if (requestMode.value=='volume_control') {
        if (ent=='audio_volume') {
            audioVolInd.value=val;audioVolRange.value=val;
        } if (ent=='audio_speed') {
            audioRatInd.value=val;audioRatRange.value=val;
        } if (ent=='video_volume') {
            videoVolInd.value=val;videoVolRange.value=val;
        } if (ent=='video_speed') {
            videoRatInd.value=val;videoRatRange.value=val;
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
function superuser() {
    return ((sysDefIsSession.value!=false)&&(sysDefSessionID.value=='root'));
}
function authstate() {
    return (sysDefIsSession.value!=false);
}
function cancelled(id) {
    var pwr=strarr(sysDefPowersData.value,';',':');
    var res=false; if ((pwr[id]!==undefined)&&(isNum(pwr[id]))) {
        res=(pwr[id]<0);
    } return res;
}
function enoughfor(id,prix) {
    var pwr=strarr(sysDefPowersData.value,';',':');
    var res=true; if (isNum(prix)) {
        res=(pwr[id]>=parseFloat(prix));
    } return res;
}
function encipher(txt,pass='',numsys='.-',restyp='str') {
    var srcarr=txt.split(' | ');
    var resarr=[]; for (idx in srcarr) {
        resarr.push(enmorse(srcarr[idx],pass,numsys));
    } return (restyp=='arr')?resarr:resarr.join(' | ');
}
function decipher(txt,pass='',numsys='.-',restyp='str') {
    var srcarr=txt.split(' | ');
    var resarr=[]; for (idx in srcarr) {
        resarr.push(demorse(srcarr[idx],pass,numsys));
    } return (restyp=='arr')?resarr:resarr.join(' | ');
}
function enmorse(msg,usr='',abc='.-') {
    return encode(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function demorse(msg,usr='',abc='.-') {
    return decode(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function playlistNext(name) {
    return arrangeMenu(sysDefPlaylist.value,enmorse(name,sysDefSessionID.value,sysDefNumeric.value),' | ');
}
function setfor(id,obj,name,val) {
    var arr=(typeof(obj)=='object')?strarr(obj.value,';',':'):strarr(obj,';',':'); var arf=arr; arf[id]=val;
    set(name+'.json',JSON.stringify(arf),'rw');
    obj.value=arrstr(arf,';',':');
}
function lockarr(id) {
    var objData=((jsonarr(sysDefLockData.value)!==undefined)&&(jsonarr(sysDefLockData.value)!==null))?jsonarr(sysDefLockData.value):{};
    var dataSel=Object.values(objData[id]||{});
    return ((dataSel!==undefined)&&(dataSel!==null))?dataSel:[];
}
function lockcount(id) {
    var objData=((jsonarr(sysDefLockData.value)!==undefined)&&(jsonarr(sysDefLockData.value)!==null))?jsonarr(sysDefLockData.value):{};
    var dataSel=Object.keys(objData[id]||{});
    return (isInt(dataSel.length))?parseInt(dataSel.length):0;
}
function metadata() { return jsonarr(sysDefMetaData.value); }
function setmeta(ent,val) {
    var obj=metadata(); obj[ent]=val;
    set(sysDefSessionID.value+'_metadata.json',JSON.stringify(obj),'rw');
}
function delmeta(ent) {
    var obj=metadata(); delete obj[ent];
    set(sysDefSessionID.value+'_metadata.json',JSON.stringify(obj),'rw');
}
function clearJournal(id,obj,name,anyFile=false) {
    var resarr=(typeof(obj)=='object')?jsonarr(obj.value):jsonarr(obj);
    var lastElem=Object.keys(resarr).length-1; if (isInt(id)) {
        var absNum=Math.abs(id),numDiff=(lastElem-absNum);
        if (id<0) {
            for (i=0; i<absNum; i++) {
                if (resarr[Object.keys(resarr)[0]]!==undefined) {
                    delete resarr[Object.keys(resarr)[0]];
                }
            }
        } else {
            for (i=lastElem; i>numDiff; i--) {
                if (resarr[Object.keys(resarr)[i]]!==undefined) {
                    delete resarr[Object.keys(resarr)[i]];
                }
            }
        }
    } else {
        if (resarr[id]!==undefined) { delete resarr[id]; }
    } if (anyFile) {
        set('./'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),'rw');
    } else {
        set('./'+sysDefSessionID.value+'_'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),'rw');
    }
}
function openJournal(id,obj) {
    var resarr=(typeof(obj)=='object')?jsonarr(obj.value):jsonarr(obj);
    return (isObject(resarr[id]))?arrjson(resarr[id]):"{\"\":\"\"}";
}
function storeOpen(id) {
    return loadFile(id+'_session.json','active_hours').split(',').includes(userTimeNow(id));
}
function userTimeNow(id) {
    var arr=strarr(sysDefHoursNow.value,';',':');
    return (arr[id]!==undefined)?arr[id]:'00';
}
function isInBackup(id) {
    var fsess=jsonarr(loadFile(id+'_session_saved.json'));
    var flock=jsonarr(loadFile(id+'_lock_saved.json'));
    return (isObject(fsess)&&isObject(flock));
}
function userBackup(id) {
    copy(id+'_session.json',id+'_session_saved.json','rw');
    copy(id+'_lock.json',id+'_lock_saved.json','rw');
    var fsess=jsonarr(loadFile(id+'_session_saved.json'));
    var flock=jsonarr(loadFile(id+'_lock_saved.json'));
}
function userRestore(id) {
    var fsess=flock={}; if (isInBackup(id)) {
        copy(id+'_session_saved.json',id+'_session.json','rw');
        copy(id+'_lock_saved.json',id+'_lock.json','rw');
        fsess=jsonarr(loadFile(id+'_session_saved.json'));
        for (idx in fsess) { setdata(idx,fsess[idx]); }
        flock=jsonarr(loadFile(id+'_lock_saved.json'));
        for (idx in flock) { setlock(idx,flock[idx]); }
        omniListen(demorse(fsess['melody'],id,fsess['numeric']),false,parseInt(fsess['current']));
    }
}
function remove_entry(id,obj,name,complex=false,helper=false,dy=';',dx=':') {
    var rawData=(typeof(obj)=='object')?obj.value:obj;
    var resarr=(complex)?jsonarr(rawData):strarr((rawData),dy,dx);
    delete resarr[id]; set(name,JSON.stringify(resarr),'rw');
    if (helper) { del(id+'.json','rw'); del(id,'rw'); }
    obj.value=(complex)?arrjson(resarr):arrstr(resarr,dy,dx);
}
function user_exists(id) {
    return ((sysDefUsersList.value).split(',').includes(id));
}
function delete_user(id) {
    unbind(sysDefSessionID.value); unbind(id);
    remove_entry(id,sysDefBindData,'binding.json');
    remove_entry(id,sysDefPowersData,'dominion.json');
    remove_entry(id,sysDefAutoData,'automator.json');
    remove_entry(id,sysDefToolData,'toolbox.json');
    del(id+'_lock_saved.json','rw');
    del(id+'_session_saved.json','rw');
    del(id+'_msgbox.json.bak','rw');
    del(id+'_book.json.bak','rw');
    del(id+'_store.json.bak','rw');
    del(id+'_msgbox.json','rw');
    del(id+'_book.json','rw');
    del(id+'_store.json','rw');
    del(id+'_lock.json.bak','rw');
    del(id+'_metadata.json.bak','rw');
    del(id+'_session.json.bak','rw');
    del(id+'_lock.json','rw');
    del(id+'_metadata.json','rw');
    del(id+'_session.json','rw');
    del(id+'_lock.json.bak','rw');
    del(id+'_metadata.json.bak','rw');
    del(id+'_session.json.bak','rw');
}
function transfer_entry(id,to,obj,name,onlyAssignID=false) {
    var objData=strarr(obj.value,';',':');
    objData[to]=(onlyAssignID)?to:objData[id];
    if (id!=to) { delete objData[id]; }
    set(name+'.json',JSON.stringify(objData),'rw');
    obj.value=arrstr(objData,';',':');
}
function rename_user(id,to,pass,perm) {
    unbind(id); unbind(to); del(id+'_password','rw');
    set(to+'_password',CryptoJS.SHA256(pass).toString(),'rw');
    if (id!=to) {
        copy(id+'_lock.json',to+'_lock.json',perm);
        copy(id+'_metadata.json',to+'_metadata.json',perm);
        copy(id+'_session.json',to+'_session.json',perm);
        copy(id+'_msgbox.json',to+'_msgbox.json',perm);
        copy(id+'_book.json',to+'_book.json',perm);
        copy(id+'_store.json',to+'_store.json',perm);
        transfer_entry(id,to,sysDefBindData,'binding',true);
        transfer_entry(id,to,sysDefPowersData,'dominion');
        transfer_entry(id,to,sysDefAutoData,'automator');
        transfer_entry(id,to,sysDefToolData,'toolbox');
    }
}
function init_user(id,pass=null) {
    var scoreTab=strarr(sysDefPowersData.value,';',':');
    if (!notNull(scoreTab[id])) { scoreTab[id]=0; }
    sysDefPowersData.value=arrstr(scoreTab,';',':');
    var bindTab=strarr(sysDefBindData.value,';',':');
    if (!notNull(bindTab[id])) { bindTab[id]=id; }
    sysDefBindData.value=arrstr(bindTab,';',':');
    var autoTab=strarr(sysDefAutoData.value,';',':');
    if (!notNull(autoTab[id])) { autoTab[id]='manual'; }
    sysDefAutoData.value=arrstr(autoTab,';',':');
    var toolTab=strarr(sysDefToolData.value,';',':');
    if (!notNull(toolTab[id])) { toolTab[id]=''; }
    sysDefToolData.value=arrstr(toolTab,';',':');
    var msgData=jsonarr(openJournal(id,sysDefMsgboxJSONs));
    if (!notNull(msgData)) {
        set('./'+id+'_msgbox.json',JSON.stringify({}),'rw');
    } var bookData=jsonarr(openJournal(id,sysDefBookJSONs));
    if (!notNull(bookData)) {
        set('./'+id+'_book.json',JSON.stringify({}),'rw');
    } var storeData=jsonarr(openJournal(id,sysDefStoreJSONs));
    if (!notNull(storeData)) {
        set('./'+id+'_store.json',JSON.stringify({}),'rw');
    } if (isLine(pass)) { set(id+'_password',pass,'rw'); }
    batch_remove_users(',0,auto');
}
function batch_remove_users(str='') {
    var arr=str.split(',');
    for (i=0; i<arr.length; i++) {
        if (user_exists(arr[i])) { delete_user(arr[i]); }
    }
}
function administer(entry,mode='+') {
    if (superuser()) {
        var files={'bind':'binding','auto':'automator','tool':'toolbox','ip':'visitors','powers':'dominion','hdi':'i18n'};
        var micro=['bind','auto','tool','powers'];
        var sub={'bind':'i','auto':'manual|auto','tool':'e','powers':'n'},sum=qua=div=1;
        var tempObj=obj={},tempData=temp='';
        var counts=strarr(sysDefPowersData.value,';',':');
        if (notNull(sub[entry])) {
            tempObj=document.getElementById('sysDef'+ucfirst(entry)+'Data'),tempData=tempObj.value;
            obj=(micro.includes(entry))?strarr(tempData,';',':'):jsonarr(tempData);
            sum=arrsum(Object.values(obj));
            qua=Object.keys(obj).length;
            div=Math.round(sum/qua);
            for (idx in counts) {
                if (sub[entry]=='i') { obj[idx]=idx;
                } else if (sub[entry].includes('|')) {
                    obj[idx]=(mode=='-')?sub[entry].split('|')[0]:sub[entry].split('|')[1];
                } else if (sub[entry]=='e') {
                    obj[idx]='';
                } else if (sub[entry]=='n') {
                    if (mode=='-') {
                        obj[idx]=parseFloat(div);
                    } else {
                        obj[idx]=parseFloat(sum);
                    }
                }
            } if (notNull(obj)) {
                set(files[entry]+'.json',JSON.stringify(obj),'rw'); tempObj.value=(micro.includes(entry))?arrstr(obj,';',':'):arrjson(obj);
            }
        } else {
            for (temp in sub) {
                tempObj=document.getElementById('sysDef'+ucfirst(temp)+'Data'),tempData=tempObj.value;
                obj=(micro.includes(temp))?strarr(tempData,';',':'):jsonarr(tempData);
                sum=arrsum(Object.values(obj));
                qua=Object.keys(obj).length;
                div=Math.round(sum/qua);
                for (idx in counts) {
                    if (sub[temp]=='i') {
                        obj[idx]=idx;
                    } else if (sub[temp].includes('|')) {
                        obj[idx]=(mode=='-')?sub[temp].split('|')[0]:sub[temp].split('|')[1];
                    } else if (sub[temp]=='e') {
                        obj[idx]='';
                    } else if (sub[temp]=='n') {
                        if (mode=='-') {
                            div=Math.round(sum/qua);
                            obj[idx]=parseFloat(div);
                        } else {
                            obj[idx]=parseFloat(sum);
                        }
                    }
                } if (notNull(obj)) {
                    set(files[temp]+'.json',JSON.stringify(obj),'rw'); tempObj.value=(micro.includes(temp))?arrstr(obj,';',':'):arrjson(obj);
                }
            }
        }
    }
}
function jsonFilter(str,usr,mask='#') {
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
function jsonHTML(str,usr,mask='#') {
    var arr=jsonFilter(str,usr,mask),ard='',fu0=fu1=ark=arv='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    var cyp=sysDefCypher.value; for (el in arr) {
        ark=(cyp!='')?enmorse(el,usr,cyp):el;
        arv=(cyp!='')?enmorse(arr[el],usr,cyp):arr[el];
        fu0="clearJournal(&#39;"+enmorse(el,usr)+"&#39;,&#39;"+sysDefMyMsgboxData.value+"&#39;,&#39;msgbox&#39;);";
        fu1="clip(&#39;"+arv+"&#39;);";
        ard="<p><input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='"+fu0+"'> "+ark+" <input type='image' class='power' onmouseover='soundButton();' src='"+epr+"copy.png"+"' onclick='"+fu1+"'><br>"+arv+"</p>"+ard;
    } return ard;
}
function jsonNews() {
    var arr=jsonarr(sysDefNewsData.value),ard=abk=abl='';
    for (el in arr) {
        abk=((arr[el]!==undefined)&&(arr[el][sysDefUnits.value]!==undefined)&&(arr[el][sysDefUnits.value]['title']!==undefined))?arr[el][sysDefUnits.value]['title']:((arr[el]['default']['title']!==undefined)?arr[el]['default']['title']:'');
        abl=((arr[el]!==undefined)&&(arr[el][sysDefUnits.value]!==undefined)&&(arr[el][sysDefUnits.value]['body']!==undefined))?arr[el][sysDefUnits.value]['body']:((arr[el]['default']['body']!==undefined)?arr[el]['default']['body']:'');
        ard=ard+abk+' · '+el+"<br>"+abl+"<br>";
    } return ard;
}
function activeHrsBtn(id) {
    var arr=loadFile(id+'_session.json','active_hours').split(','),arl=''; for (el in arr) {
        arl+="<input type='button' onmouseover='soundButton();' value='"+arr[el]+"'>";
    } return arl;
}
function showLockInd() {
    var ob=((jsonarr(sysDefLockData.value)!==undefined)&&(jsonarr(sysDefLockData.value)!==null))?jsonarr(sysDefLockData.value):{};
    var ch=Object.keys(ob||{});
    var lic=jsonarr(sysDefLockIcons.value);
    var epr=sysDefPrefix.value,arl=""; for (iu in ch) {
        arl+="<input type='image' class='power' onmouseover='soundButton();' style='width:36px;height:36px;' onmouseover='soundButton();' src='"+epr+lic[ch[iu]]+".png"+"' onclick='setdata(&#34;album&#34;,&#34;"+ch[iu]+"&#34;);'>";
    } return arl;
}
function indexAvatars(id) {
    var obj=lockarr(id),arr=[];
    for (idx in obj) {
        if ((id=='avatar')||(id=='pictogram')||(id=='reticle')) { arr.push(obj[idx].split('.')[1]); }
    } return arr;
}
function jsonStore(id) {
    var arr=jsonarr(openJournal(id,sysDefStoreJSONs));
    var ard=arl='',eld={},fu0=fu1='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    for (el in arr) {
        if ((arr[el]!==undefined)&&(typeof(arr[el])=='object')) {
            eld=arr[el],arl='<tr>';
            fu0="buy_item(&#34;"+usr+"&#34;,&#34;"+el+"&#34;,&#34;"+id+"&#34;);",fu1=(isNum(el))?"charge(&#34;"+id+"&#34;,&#34;"+parseFloat(el)+"&#34;);":(((eld['type']=='book')||(eld['type']=='text'))?"omniPath(&#34;./"+usr+"_store.json&#34;,&#34;"+el+"/contents&#34;,&#34;false&#34;);":((eld['type']=='weapon')?"equip(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);"));
            arl+="<td><input type='button' onmouseover='soundButton();' style='width:80%;' onclick='"+((id!=usr)?fu0:fu1)+"' value='"+el+"'>";
            arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"info.png"+"' onclick='omniPath(&#34;./"+usr+"_store.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>";
            arl+="</td><td>"+eld['amount']+"</td><td>$"+eld['price']+"</td>"; ard=arl+"</tr>"+ard;
        }
    } return ard;
}
function formCur(val,mtd='num') {
    var cur=sysDefCurrency.value,res=curSign=userSign=delim=delimit='';
    var expr=sign=start=end=''; if (cur.length==7) {
        curSign=(cur.charAt(1)!='x')?(cur.charAt(1)):'';
        userSign=(cur.charAt(5)!='y')?(cur.charAt(5)):'';
        delim=(cur.charAt(3)!=':')?(cur.charAt(3)):'';
        delimit=(delim=='_')?' ':delim;
        expr=(mtd=='num')?delimNum(parseFloat(val),delimit):val;
        sign=(mtd=='num')?curSign:userSign;
        start=(mtd=='num')?0:4,end=(mtd=='num')?2:6;
        if ((cur.charAt(start)=='^')&&(cur.charAt(end)=='_')) {
            res=sign+' '+expr;
        } else if ((cur.charAt(start)=='_')&&(cur.charAt(end)=='^')) {
            res=expr+' '+sign;
        } else if ((cur.charAt(start)=='^')&&(cur.charAt(end)==':')) {
            res=sign+expr;
        } else if ((cur.charAt(start)==':')&&(cur.charAt(end)=='^')) {
            res=expr+sign;
        }
    } return res;
}
function jsonBookKeep(str) {
    var arr=jsonarr(str),ard=arl='',arf={},eld=[];
    for (el in arr) {
        eld=arr[el].split(' | ');arf[el]=arr[el];
    } for (el in arf) {
        eld=arr[el].split(' | ');
        arl=(eld[5]=='ERR')?'<tr style="text-decoration:line-through;">':'<tr>';
        arl+='<td>@'+eld[1]+'</td>';
        arl+=(isNum(eld[2]))?'<td>'+formCur(eld[2])+'</td>':'<td>'+eld[2]+'</td>';
        arl+=(isNum(eld[3]))?'<td>'+formCur(eld[3])+'</td>':'<td>'+eld[3]+'</td>';
        arl+='<td>'+formCur(eld[4])+'</td>';
        ard=arl+'</tr>'+ard;
    } return ard;
}
function noteBook(str) {
    var arr=str.split(' | '),ard=arl=eld=elt=eln='';
    var epr=sysDefPrefix.value; for (el in arr) {
        eld=arr[el],eln=sysDefNumeric.value,elt=decode(eld,'',eln);
        arl="<input type='button' onmouseover='soundButton();' style='width:80%;' onclick='openNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);' value='"+elt+"'>";
        arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='deleteNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);'>";
        ard=ard+arl+'<br>';
    } return ard;
}
function helpBook() {
    var obj=jsonarr(sysDefTutorData.value),ard=arl=elt='';
    var epr=sysDefPrefix.value; for (el in obj) {
        elt=((obj[el]!==undefined)&&(obj[el][sysDefUnits.value]!==undefined)&&(obj[el][sysDefUnits.value]['title']!==undefined))?obj[el][sysDefUnits.value]['title']:((obj[el]['default']['title']!==undefined)?obj[el]['default']['title']:''); arl="<input type='button' onmouseover='soundButton();' style='width:80%;' onclick='openHelpPage(&#34;"+el+"&#34;);' value='"+elt+"'>";
        arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"info.png"+"' onclick='omniPath(&#34;tutorial.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>"; ard=ard+arl+'<br>';
    } return ard;
}
function isoformat(num) {
    var ob=new Date(num);
    return (ob.getUTCFullYear())+'-'+pad((ob.getUTCMonth()+1),-2)+'-'+pad((ob.getUTCDate()),-2)+' '+pad((ob.getUTCHours()),-2)+':'+pad((ob.getUTCMinutes()),-2)+':'+pad((ob.getUTCSeconds()),-2)+'.'+pad((ob.getUTCMilliseconds()),-3);
}
function systemUpdate(query) {
    var parts=query.toString('').split(' ');
    for (i=0; i<parts.length; i++) {
        var part=payload(parts[i]);
        get('i',part[0],'from',part[1],part[2],part[3]);
    }
}
function obtainRepo(query) {
    var parts=query.toString('').split(' ');
    for (i=0; i<parts.length; i++) {
        var part=payload(parts[i]);
        getdir('i',part[0],'from',part[1],part[2],part[3]);
    }
}
function replacePackage(quid,quo,ord=0) {
    var toRem=quid.toString('').split(' ');
    var toSet=quo.toString('').split(' ');
    var part=[]; if (ord<0) {
        for (i=0; i<toSet.length; i++) {
            part=payload(toSet[i]);
            get('i',part[0],'from',part[1],part[2],part[3]);
        } for (i=0; i<toRem.length; i++) {
            get('d','',toRem[i],'from','','here');
        }
    } else {
        for (i=0; i<toRem.length; i++) {
            get('d','',toRem[i],'from','','here');
        } for (i=0; i<toSet.length; i++) {
            part=payload(toSet[i]);
            get('i',part[0],'from',part[1],part[2],part[3]);
        }
    }
}
function replaceRepo(quid,quo,ord=0) {
    var toRem=quid.toString('').split(' ');
    var toSet=quo.toString('').split(' ');
    var part=[]; if (ord<0) {
        for (i=0; i<toSet.length; i++) {
            part=payload(toSet[i]);
            getdir('i',part[0],'from',part[1],part[2],part[3],true);
        } for (i=0; i<toRem.length; i++) {
            getdir('d','',toRem[i],'from','','here',true);
        }
    } else {
        for (i=0; i<toRem.length; i++) {
            getdir('d','',toRem[i],'from','','here',true);
        } for (i=0; i<toSet.length; i++) {
            part=payload(toSet[i]);
            getdir('i',part[0],'from',part[1],part[2],part[3],true);
        }
    }
}
function payload(query) {
    var host=repo=user='';
    var uri=(query.includes('>'))?query.split('>')[0]:query;
    var branch=(query.includes('>'))?query.split('>')[1]:'';
    var prot=uri.split('://')[0],rest=uri.split('://')[1];
    var parts=rest.split('/'),prim=parts[0],prest=parts;
    if (parts.length>2) {
        repo=parts[parts.length-1];
        prest.splice(0,1); prest.splice((prest.length-1),1);
        user=prest.join('/');
    } else if (parts.length==2) {
        repo=parts[1],user='';
    } host=prot+'://'+prim;
    return res=[host,repo,branch,user];
}
function uninstall(query) {
    for (i=0; i<query.split(' ').length; i++) {
        get('d','',query.split(' ')[i],'from','','here');
    }
}
function terminate(query) {
    for (i=0; i<query.split(' ').length; i++) {
        getdir('d','',query.split(' ')[i],'from','','here');
    }
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
function arrangePlay() {
    var powersData=strarr(sysDefPowersData.value,';',':');
    var bindData=strarr(sysDefBindData.value,';',':');
    var autoData=strarr(sysDefAutoData.value,';',':');
    sysDefAutoState.value=autoData[sysDefSessionID.value];
    $('#buttonAutomator').attr('src',sysDefPrefix.value+((sysDefAutoState.value=='auto')?'wheel.png':'steer.png'));
    var myPowers=powersData[sysDefSessionID.value];
    var chainIcon='chain'; if (myPowers<=-666) {
        delete_user(sysDefSessionID.value);omniAuthRequest('signout','','');
    } chainIcon=(arraySearch(sysDefSessionID.value,bindData)!=false)?((bindData[sysDefSessionID.value]!=sysDefSessionID.value)?'unbroke':'unchain'):((bindData[sysDefSessionID.value]!=sysDefSessionID.value)?'broke':'chain');
    var powerHandler=formCur(myPowers);
    var nameHandler=formCur(sysDefSessionID.value,'str');
    $('#buttonBroke').attr('src',sysDefPrefix.value+chainIcon+'.png');
    $('#showUsInfoPower').val(powerHandler);
    $('#showUsInfoBond').val(nameHandler);
}
function init_rec(id) {
    var obj=strarr(sysDefPowersData.value,';',':');
    if (!notNull(obj[id])) { obj[id]=0; }
    set('powers.json',JSON.stringify(obj),'rw');
    sysDefPowersData.value=arrstr(obj,';',':');
}
function bind(usr,id) {
    init_rec(usr); init_rec(id);
    var binds=strarr(sysDefBindData.value,';',':');
    binds[usr]=id; set('binding.json',JSON.stringify(binds),'rw');
    sysDefBindData.value=arrstr(binds,';',':');
}
function equip(usr,id) {
    init_rec(usr);
    var obj=strarr(sysDefToolData.value,';',':');
    obj[usr]=id; set('toolbox.json',JSON.stringify(obj),'rw');
    sysDefToolData.value=arrstr(obj,';',':');
}
function automate() {
    var usr=sysDefSessionID.value;
    var obj=strarr(sysDefAutoData.value,';',':');
    obj[usr]=(sysDefAutoState.value=='auto')?'manual':'auto';
    set('automator.json',JSON.stringify(obj),'rw');
    sysDefAutoData.value=arrstr(obj,';',':');
}
function localizedTitle(id,ent='title') {
    var mono=loadFile(id+'_session.json',ent);
    var lang=loadFile(id+'_session.json','units');
    var trans=loadFile(id+'_session.json',ent+'s');
    var tran=strarr(trans,' | ',' - ');
    return (notNull(tran[lang]))?tran[lang]:mono;
}
function compose(usr,msg) {
    var addr=(msg!==undefined)?msg.match(/(@\w*)/g):'';
    var argv=(msg!==undefined)?msg.match(/\{[^\}]*\}/g):'';
    var id=sen=rec=req=msglt='',msgbox={},msgbr=msglr=[];
    var senT=recT=usrT=''; if (!cancelled(usr)) {
        if (addr!==null) {
            for (it in addr) {
                id=addr[it].replace('@','');
                init_user(id); if (!cancelled(id)) {
                    sen=((argv!==null)?id:usr);
                    rec=((argv!==null)?usr:id);
                    senT=localizedTitle(sen);
                    recT=localizedTitle(rec);
                    msgbox=openJournal(rec,sysDefMsgboxJSONs); msgarr=jsonarr(msgbox);
                    if (msg.match(/\r?\n/)!==null) {
                        msgbr=msg.split(/\r?\n/);
                        for (j=0; j<msgbr.length; j++) {
                            if (argv!==null) {
                                msglr.push('@'+usr);
                                for (idx in argv) {
                                    req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+calc(req).toString()+']');
                                } msglt=msglr.join(' ');
                            } else { msglt=msgbr[j]; }
                            msgarr[enmorse(senT+' (@'+sen+') · '+isoformat(Date.now()+j*1000)+' UTC',rec)]=enmorse(msglt,rec);
                        }
                    } else {
                        if (argv!==null) {
                            msglr.push('@'+usr);
                            for (idx in argv) {
                                req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+calc(req).toString()+']');
                            } msglt=msglr.join(' ');
                        } else { msglt=msg; }
                        msgarr[enmorse(senT+' (@'+sen+') · '+isoformat(Date.now())+' UTC',rec)]=enmorse(msglt,rec);
                    } set('./'+rec+'_msgbox.json',(JSON.stringify(msgarr)),'rw');
                }
            }
        } else {
            msgbox=openJournal(usr,sysDefMsgboxJSONs); msgarr=jsonarr(msgbox);
            usrT=localizedTitle(usr);
            if (msg.match(/\r?\n/)!==null) {
                msgbr=msg.split(/\r?\n/);
                for (j=0; j<msgbr.length; j++) {
                    if (argv!==null) {
                        msglr.push('@'+usr);
                        for (idx in argv) {
                            req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+calc(req).toString()+']');
                        } msglt=msglr.join(' ');
                    } else { msglt=msgbr[j]; }
                    msgarr[enmorse(usrT+' (@'+usr+') · '+isoformat(Date.now()+j*1000)+' UTC',usr)]=enmorse(msglt,usr);
                }
            } else {
                if (argv!==null) {
                    msglr.push('@'+usr);
                    for (idx in argv) {
                        req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+calc(req).toString()+']');
                    } msglt=msglr.join(' ');
                } else { msglt=msg; }
                msgarr[enmorse(usrT+' (@'+usr+') · '+isoformat(Date.now())+' UTC',usr)]=enmorse(msglt,usr);
            } set('./'+usr+'_msgbox.json',(JSON.stringify(msgarr)),'rw');
        }
    }
}
function pamd(pamLen=4,pamChar='0123456789') {
    var dt=new Date(),hh=dt.getUTCHours();
    var mm=dt.getUTCMinutes(),ss=dt.getUTCSeconds();
    var period=sysDefCron.value;
    var pass=(sysDefPamSerial.value!=0)?genSerial(pamLen,pamChar):genFixedNum(pamLen,pamChar);
    if ((authstate())&&(sysDefPam.value!=0)) {
        if (period=="60min") {
            if ((parseInt(mm)==0)&&(parseInt(ss)==0)) {
                rename_user(sysDefSessionID.value,sysDefSessionID.value,pass,sysDefSessionID.value);
                compose('pam','@'+sysDefSessionID.value+':'+pass);
            }
        } else if (period=="30min") {
            if (((parseInt(mm)==0)||(parseInt(mm)==30))&&(parseInt(ss)==0)) {
                rename_user(sysDefSessionID.value,sysDefSessionID.value,pass,sysDefSessionID.value);
                compose('pam','@'+sysDefSessionID.value+':'+pass);
            }
        } else if (period=="15min") {
            if (((parseInt(mm)==0)||(parseInt(mm)==15))||(parseInt(mm)==30)||(parseInt(mm)==45)&&(parseInt(ss)==0)) {
                rename_user(sysDefSessionID.value,sysDefSessionID.value,pass,sysDefSessionID.value);
                compose('pam','@'+sysDefSessionID.value+':'+pass);
            }
        } else if (period=="60sec") {
            if (parseInt(ss)==0) {
                rename_user(sysDefSessionID.value,sysDefSessionID.value,pass,sysDefSessionID.value);
                compose('pam','@'+sysDefSessionID.value+':'+pass);
            }
        } else if (period=="30sec") {
            if ((parseInt(ss)==0)||(parseInt(ss)==30)) {
                rename_user(sysDefSessionID.value,sysDefSessionID.value,pass,sysDefSessionID.value);
                compose('pam','@'+sysDefSessionID.value+':'+pass);
            }
        } else if (period=="15sec") {
            if ((parseInt(ss)==0)||(parseInt(ss)==15)||(parseInt(ss)==30)||(parseInt(ss)==45)) {
                rename_user(sysDefSessionID.value,sysDefSessionID.value,pass,sysDefSessionID.value);
                compose('pam','@'+sysDefSessionID.value+':'+pass);
            }
        }
    }
}
function amounts(tabS,tabB,art) {
    var qS=qB=0; if ((tabS[art]['amount']!==undefined)&&isInt(tabS[art]['amount'])) {
        qS=parseInt(tabS[art]['amount']); if (qS>1) {
            if ((tabB[art]!==undefined)&&(typeof(tabB[art])=='object')&&(tabB[art]['amount']!==undefined)&&isInt(tabB[art]['amount'])) {
                qB=parseInt(tabB[art]['amount']);
                qB=(qB>0)?(qB+1):1; tabB[art]['amount']=parseInt(qB);
            } else {
                qB=1; tabB[art]=tabS[art]; tabB[art]['amount']=parseInt(qB);
            } qS--; tabS[art]['amount']=parseInt(qS);
        } else {
            if ((tabB[art]!==undefined)&&(typeof(tabB[art])=='object')&&(tabB[art]['amount']!==undefined)&&isInt(tabB[art]['amount'])) {
                qB=parseInt(tabB[art]['amount']);
                qB=(qB>0)?(qB++):1; tabB[art]['amount']=parseInt(qB);
            } else { tabB[art]=tabS[art]; } delete tabS[art];
        }
    }
}
function buy_item(buyer,art,seller) {
    if (seller!=buyer) {
        var tabS=jsonarr(openJournal(seller,sysDefStoreJSONs));
        var tabB=jsonarr(openJournal(buyer,sysDefStoreJSONs));
        var prix,pass; if ((!cancelled(buyer))&&(!cancelled(seller))) {
            if ((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')) {
                if ((isNum(tabS[art]['price']))&&(!isNum(art))) {
                    prix=parseFloat(tabS[art]['price']);
                    if (enoughfor(buyer,prix)) {
                        fixPrice(buyer,seller,art,prix);
                        amounts(tabS,tabB,art);
                        set('./'+seller+'_store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
                        set('./'+buyer+'_store.json',encodeURIComponent(JSON.stringify(tabB)),'rw');
                        if ((tabS[art]['password']!==undefined)&&(tabS[art]['type']=='account')) {
                            rename_user(seller,buyer,tabS[art]['password'],seller); omniAuthRequest('signin',buyer,tabS[art]['password']);
                        } else if ((tabS[art]['password']!==undefined)&&(tabS[art]['type']=='password')) {
                            rename_user(seller,seller,tabS[art]['password'],seller);
                            omniAuthRequest('signin',seller,tabS[art]['password']);
                        }
                    }
                } else if ((!isNum(tabS[art]['price']))&&(!isNum(art))&&(tabB[tabS[art]['price']]!==undefined)&&(typeof(tabB[tabS[art]['price']])=='object')) {
                    prix=tabS[art]['price']; fixPrice(buyer,seller,art,prix);
                    amounts(tabB,tabS,prix); amounts(tabS,tabB,art);
                    set('./'+seller+'_store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
                    set('./'+buyer+'_store.json',encodeURIComponent(JSON.stringify(tabB)),'rw');
                } else if ((!isNum(tabS[art]['price']))&&(tabS[art]['price']=='')) {
                    prix=tabS[art]['price']; fixPrice(buyer,seller,art,prix); amounts(tabS,tabB,art);
                    set('./'+seller+'_store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
                    set('./'+buyer+'_store.json',encodeURIComponent(JSON.stringify(tabB)),'rw');
                }
            }
        }
    }
}
function sell_item(usr,art,rawTxtData='') {
    var tabS=jsonarr(openJournal(usr,sysDefStoreJSONs));
    var dataArr=strarr(rawTxtData,'; ',': '); if (!cancelled(usr)) {
        var amount=((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')&&(tabS[art]['amount']!==undefined)&&isInt(tabS[art]['amount'])&&(tabS[art]['amount']>=0))?parseInt(tabS[art]['amount'])+1:1; tabS[art]={"amount":amount}; for (idx in dataArr) {
            tabS[art][idx]=(idx=='password')?CryptoJS.SHA256(dataArr[idx]).toString():dataArr[idx];
        } set('./'+usr+'_store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
    }
}
function fixPrice(sen,rec,deb,cre) {
    var tran1=openJournal(sen,sysDefBookJSONs);
    var tran2=openJournal(rec,sysDefBookJSONs);
    var trans1=jsonarr(tran1),trans2=jsonarr(tran2);
    var stat=strarr(sysDefPowersData.value,';',':');
    var statD=(isNum(stat[sen]))?parseFloat(stat[sen]):0;
    var statC=(isNum(stat[rec]))?parseFloat(stat[rec]):0;
    var statDr=parseFloat(statD),statCr=parseFloat(statC);
    var bal1=((tran1=='{}')||(tran1==''))?statDr:(trans1[Object.keys(trans1)[Object.keys(trans1).length-1]]).split(' | ')[4];
    var bal2=((tran2=='{}')||(tran2==''))?statCr:(trans2[Object.keys(trans2)[Object.keys(trans2).length-1]]).split(' | ')[4];
    var statDt,statCt,statK,statV,statDi,statCi,statDn,statCn,statT;
    var statDv=statDr-parseFloat(bal1),statCv=statCr-parseFloat(bal2);
    if ((isNum(deb))&&!(isNum(cre))) {
        statV=parseFloat(deb),statK=cre,statT=cre;
        statD+=statV; statC-=statV;
        statDi=parseFloat(bal1)+parseFloat(statDv)+statV;
        statCi=parseFloat(bal2)+parseFloat(statCv)-statV;
    } else if (!(isNum(deb))&&(isNum(cre))) {
        statV=parseFloat(cre),statK=deb,statT=deb;
        statD-=statV; statC+=statV;
        statDi=parseFloat(bal1)+parseFloat(statDv)-statV;
        statCi=parseFloat(bal2)+parseFloat(statCv)+statV;
    } else { statK=cre,statT=deb;
        statDi=parseFloat(bal1)+parseFloat(statDv);
        statCi=parseFloat(bal2)+parseFloat(statCv);
    } statDn=Math.abs(statDi-parseFloat(bal1));
    statCn=Math.abs(statCi-parseFloat(bal2));
    statDt=(statDi==statD)?'OK':'ERR';
    statCt=(statCi==statC)?'OK':'ERR';
    stat[sen]=parseFloat(statD),stat[rec]=parseFloat(statC);
    trans1[isoformat(Date.now())+' UTC']=(statDi<parseFloat(bal1))?sen+' | '+rec+' | '+statT+' | '+statDn+' | '+statDi+' | '+statDt : sen+' | '+rec+' | '+statDn+' | '+statT+' | '+statDi+' | '+statDt;
    trans2[isoformat(Date.now())+' UTC']=(statCi<parseFloat(bal2))?rec+' | '+sen+' | '+statT+' | '+statCn+' | '+statCi+' | '+statCt : rec+' | '+sen+' | '+statCn+' | '+statT+' | '+statCi+' | '+statCt;
    if (!isNum(deb)&&!isNum(cre)) {
        trans1[isoformat(Date.now())+' UTC']=sen+' | '+rec+' | '+statT+' | '+statK+' | '+statDi+' | '+statDt;
        trans2[isoformat(Date.now())+' UTC']=rec+' | '+sen+' | '+statK+' | '+statT+' | '+statCi+' | '+statCt;
    } set('./'+sen+'_book.json',encodeURIComponent(JSON.stringify(trans1)),'rw');
    set('./'+rec+'_book.json',encodeURIComponent(JSON.stringify(trans2)),'rw');
    set('dominion.json',JSON.stringify(stat),'rw');
    sysDefPowersData.value=arrstr(stat,';',':');
}
function charge(usr,art='') {
    var powersData=strarr(sysDefPowersData.value,';',':');
    var userMarket=jsonarr(openJournal(usr,sysDefStoreJSONs));
    var force=amount=series=finite=0;
    var usrPwr=(isNum(powersData[usr]))?parseFloat(powersData[usr]):0;
    if (usrPwr>=0) {
        if ((userMarket[art]!==undefined)&&(typeof(userMarket[art])=='object')&&(userMarket[art]['type']!='account')&&(userMarket[art]['type']!='password')&&(userMarket[art]['type']!='weapon')) {
            amount=((userMarket[art]['amount']!==undefined)&&isInt(userMarket[art]['amount']))?parseInt(userMarket[art]['amount']):1;
            force=(isNum(art))?parseFloat(art):(((userMarket[art]['force']!==undefined)&&isNum(userMarket[art]['force']))?parseFloat(userMarket[art]['force']):1);
            finite=((userMarket[art]['finite']!==undefined)&&isInt(userMarket[art]['finite']))?parseInt(userMarket[art]['finite']):0;
            series=((userMarket[art]['series']!==undefined)&&isInt(userMarket[art]['series']))?parseInt(userMarket[art]['series']):0;
        } else { amount=force=1,finite=series=0; }
        if (finite!=0) {
            if (amount>0) { if (series!=0) {
                    do {
                        usrPwr+=force; series-=1;
                    } while (series>0);
                } else {
                    usrPwr+=force;
                } amount-=1; userMarket[art]['amount']=amount;
            } else { delete userMarket[art]; }
        } else {
            if (series!=0) {
                do {
                    usrPwr+=force; series-=1;
                } while (series>0);
            } else { usrPwr+=force; }
        } powersData[usr]=usrPwr;
        set('./'+usr+'_store.json',encodeURIComponent(JSON.stringify(userMarket)),'rw');
        set('dominion.json',JSON.stringify(powersData),'rw');
        sysDefPowersData.value=arrstr(powersData,';',':');
    }
}
function dominate(usr,id,art='') {
    var powersData=strarr(sysDefPowersData.value,';',':');
    var userMarket=jsonarr(openJournal(usr,sysDefStoreJSONs));
    var force=amount=series=finite=0;
    var usrPwr=(isNum(powersData[usr]))?parseFloat(powersData[usr]):0;
    var idPwr=(isNum(powersData[id]))?parseFloat(powersData[id]):0;
    if ((usr!=id)&&(usrPwr>=0)) {
        if ((userMarket[art]!==undefined)&&(typeof(userMarket[art])=='object')&&(userMarket[art]['type']=='weapon')) {
            amount=((userMarket[art]['amount']!==undefined)&&isInt(userMarket[art]['amount']))?parseInt(userMarket[art]['amount']):1;
            force=((userMarket[art]['force']!==undefined)&&isNum(userMarket[art]['force']))?parseFloat(userMarket[art]['force']):1;
            finite=((userMarket[art]['finite']!==undefined)&&isInt(userMarket[art]['finite']))?parseInt(userMarket[art]['finite']):0;
            series=((userMarket[art]['series']!==undefined)&&isInt(userMarket[art]['series']))?parseInt(userMarket[art]['series']):0;
        } else { amount=force=1,finite=series=0; }
        if (idPwr<=-666) { delete_user(id); } else {
            if (finite!=0) {
                if (amount>0) {
                    if (series!=0) {
                        do {
                            usrPwr+=force; idPwr-=force; series-=1;
                        } while (series>0);
                    } else {
                        usrPwr+=force; idPwr-=force;
                    } amount-=1; userMarket[art]['amount']=amount;
                } else { delete userMarket[art]; }
            } else {
                if (series!=0) {
                    do {
                        usrPwr+=force; idPwr-=force; series-=1;
                    } while (series>0);
                } else { usrPwr+=force; idPwr-=force; }
            } powersData[usr]=usrPwr; powersData[id]=idPwr;
            set('./'+usr+'_store.json',encodeURIComponent(JSON.stringify(userMarket)),'rw');
            set('dominion.json',JSON.stringify(powersData),'rw');
            sysDefPowersData.value=arrstr(powersData,';',':');
        }
    }
}
function unbind(id) { bind(id,id); }
function unequip(id) { equip(id,''); }
function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('pitch_lock',sysDefPitchLock.value);
    setdata('video_volume',sysDefVideoVolume.value);
    setdata('video_speed',sysDefVideoSpeed.value);
}
function omniListen(input,scratch=false,pos=false) {
    playAudio(audioPlayer,input);
    if ((isInt(pos))&&(pos!==false)) {
        audioPlayer.currentTime=parseInt(pos);
    } else {
        if (scratch) { audioPlayer.currentTime=0;
        } else { audioPlayer.currentTime=parseInt(sysDefCurrent.value); }
    } setdata('melody',enmorse(input,sysDefSessionID.value,sysDefNumeric.value));
    setdata('pitch_lock',sysDefPitchLock.value);
    setdata('audio_volume',sysDefAudioVolume.value);
    setdata('audio_speed',sysDefAudioSpeed.value);
}
function songIndex(mode='') {
    var lxn=lockarr('music'),nxp=sysDefPlaylist.value;
    var nxt=(nxp.includes(' | '))?nxp.split(' | '):((nxp!='')?[nxp]:[]);
    var mel=demorse(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
    var ind=arraySearch(((mel.startsWith(requestPath.value+'/'))?mel.replace(requestPath.value+'/',''):mel),lxn);
    if (nxp!='') {
        if (nxt[0]!='') {
            omniListen(demorse(nxt[0],sysDefSessionID.value,sysDefNumeric.value),true);
        } setdata('playlist',arrangeMenu(sysDefPlaylist.value,nxt[0],' | '));
    } else {
        if (mode=='next') {
            omniListen((((ind>=(lxn.length-1))||(ind===false))?lxn[0]:lxn[parseInt(ind)+1]),true);
        } else if (mode=='prev') {
            omniListen((((ind<=0)||(ind===false))?lxn[lxn.length-1]:lxn[parseInt(ind)-1]),true);
        } else if (mode=='random') { omniListen(lxn[rand(0,lxn.length)],true);
        } else { omniListen(mel,true); }
    }
}
function omniPause() { pauseAudio(audioPlayer); }
function audioPosition(sec) {
    if (audioPlayer.duration>sec) {
        audioPlayer.currentTime=(sec.includes('-'))?(audioPlayer.duration-parseFloat(sec.replace('-',''))):(((sec.includes('+')))?(parseFloat(sec.replace('+',''))):(parseFloat(sec)));
    }
}
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
function handleInput(val,bulk=false) {
    if (bulk!=false) {
        playAudio(typePlayer,sysDefTypeSound.value);
    } else {
        if (val.length==0) {
            playAudio(errorPlayer,sysDefErrorSound.value);
        }
    }
}
function keyPressed() {
    if (requestMode.value=='accessibility') {
        pressedKeyCode.innerText=event.keyCode;
        pressedCode.innerText=event.code;
    }
}
</script>
