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
    set(sysDefSessionID.value+'_lock.json',JSON.stringify(obj),true);
    <?php foreach ($locks as $key=>$value) {
        echo "lock".snakeToCamel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent,val) {
    var obj=userdata(); obj[ent]=val;
    set(sysDefSessionID.value+'_session.json',JSON.stringify(obj),true);
    <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".snakeToCamel($key).".value = obj['".$key."'];";
    } ?> if (ent=='audio_volume') { audioPlayer.volume = val; }
    if (ent=='audio_speed') { audioPlayer.playbackRate=val; }
    if (ent=='alarm_volume') { alarmPlayer.volume=val; }
    if (ent=='timer_volume') { tickerPlayer.volume=val; }
    if (ent=='loop_volume') { backgroundPlayer.volume=val; }
    if (ent=='rest_volume') {
        soundPlayer.volume=typePlayer.volume=errorPlayer.volume=notifyPlayer.volume=bindPlayer.volume=hitPlayer.volume=sufferPlayer.volume=val;
    } if (ent=='pitch_lock') {
        audioPlayer.preservesPitch=(val!=0)?true:false;
    } if (requestMode.value=='sticky_notes') {
        if (ent=='numeric') { myNotesRad.value=val; }
    } if (requestMode.value=='media_player') {
        if (ent=='video_volume') { video.volume=val; }
        if (ent=='video_speed') { video.playbackRate=val; }
        if (ent=='pitch_lock') { video.preservesPitch=(val!=0)?true:false; }
    } if (requestMode.value=='volume_control') {
        if (ent=='audio_volume') { audioVolInd.value=val; audioVolRange.value=val; }
        if (ent=='audio_speed') { audioRatInd.value=val; audioRatRange.value=val; }
        if (ent=='video_volume') { videoVolInd.value=val; videoVolRange.value=val; }
        if (ent=='video_speed') { videoRatInd.value=val; videoRatRange.value=val; }
        if (ent=='alarm_volume') { alarmVolInd.value=val; alarmVolRange.value=val; }
        if (ent=='timer_volume') { timerVolInd.value=val; timerVolRange.value=val; }
        if (ent=='loop_volume') { loopVolInd.value=val; loopVolRange.value=val; }
        if (ent=='rest_volume') { restVolInd.value=val; restVolRange.value=val; }
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
function encipher(txt,pass='',numsys='.-',restyp='str') {
    var srcarr=txt.split(' | ');
    var resarr=[]; for (idx in srcarr) {
        resarr.push(etw(srcarr[idx],pass,numsys));
    } return (restyp=='arr')?resarr:resarr.join(' | ');
}
function decipher(txt,pass='',numsys='.-',restyp='str') {
    var srcarr=txt.split(' | ');
    var resarr=[]; for (idx in srcarr) {
        resarr.push(dtw(srcarr[idx],pass,numsys));
    } return (restyp=='arr')?resarr:resarr.join(' | ');
}
function playlistNext(name) {
    return arrangeMenu(sysDefPlaylist.value,etw(name,sysDefSessionID.value,sysDefNumeric.value),' | ');
}
function setfor(id,obj,name,val) {
    var arr=arrjob(obj.value,';',':'); arr[id]=val;
    set(name+'.json',JSON.stringify(arr),true);
    obj.value=arrpack(arr,';',':');
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
    set(sysDefSessionID.value+'_metadata.json',JSON.stringify(obj),true);
}
function delmeta(ent) {
    var obj=metadata(); delete obj[ent];
    set(sysDefSessionID.value+'_metadata.json',JSON.stringify(obj),true);
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
        set('./'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),true);
    } else {
        set('./.'+name+'/'+sysDefSessionID.value+'_'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),true);
    }
}
function markJournal(id,obj,name,ind,val,anyFile=false) {
    var resarr=(typeof(obj)=='object')?jsonarr(obj.value):jsonarr(obj);
    if ((typeof(resarr[id])=='object')&&(resarr[id][ind]!==undefined)) {
        resarr[id][ind]=val;
    } if (anyFile) {
        set('./'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),true);
    } else {
        set('./.'+name+'/'+sysDefSessionID.value+'_'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),true);
    }
}
function openJournal(id,usersObj,dataObj) {
    var userArr=(usersObj.value).split(',');
    var userNum=arraySearch(id,userArr);
    return pager((dataObj.value),userNum);
}
function storeOpen(id) {
    var hours=storeHours(id).split(',');
    return (hours.includes(userTimeNow(id)));
}
function userTimeNow(id) {
    var arr=arrjob(sysDefHoursNow.value,';',':');
    return (arr[id]!==undefined)?arr[id]:'00';
}
function getUserAvatar(id) {
    var arr=arrjob(sysDefAvatarsNow.value,';',':');
    return (arr[id]!==undefined)?arr[id]:'NULL';
}
function storeHours(id) {
    var arr=arrjob(sysDefHoursActive.value,';',':');
    return (arr[id]!==undefined)?arr[id]:'';
}
function isInBackup(id) {
    var fsess=flock={};
    with(localStorage) {
        readFile(id+'_session_saved.json','read','',id+'_session_data');
        fsess=jsonarr(getItem(id+'_session_data'));
        readFile(id+'_lock_saved.json','read','',id+'_lock_data');
        flock=jsonarr(getItem(id+'_lock_data'));
    } return ((fsess!==null)&&(flock!==null)&&(Object.keys(fsess).length>0)&&(Object.keys(flock).length>0));
}
function userBackup(id) {
    var fsess=flock={};
    with(localStorage) {
        if (isInBackup(id)) {
            copy(id+'_session_saved.json',id+'_session.json',true,1);
            copy(id+'_lock_saved.json',id+'_lock.json',true,1);
            del(id+'_session_saved.json',true); del(id+'_lock_saved.json',true);
            readFile(id+'_session.json','read','',id+'_session_data');
            fsess=jsonarr(getItem(id+'_session_data')); for (idx in fsess) {
                setItem(id+'_session_'+idx,fsess[idx]); setdata(idx,getItem(id+'_session_'+idx));
            } readFile(id+'_lock.json','read','',id+'_lock_data');
            flock=jsonarr(getItem(id+'_lock_data')); for (idx in flock) {
                setItem(id+'_lock_'+idx,flock[idx]); setlock(idx,getItem(id+'_lock_'+idx));
            } omniListen(dtw(getItem(id+'_session_melody'),id,getItem(id+'_session_numeric')),false,parseInt(getItem(id+'_session_current')));
        } else {
            copy(id+'_session.json',id+'_session_saved.json',true,1);
            copy(id+'_lock.json',id+'_lock_saved.json',true,1);
            readFile(id+'_session_saved.json','read','',id+'_session_data');
            fsess=jsonarr(getItem(id+'_session_data')); for (idx in fsess) {
                setItem(id+'_session_'+idx,fsess[idx]);
            } readFile(id+'_lock_saved.json','read','',id+'_lock_data');
            flock=jsonarr(getItem(id+'_lock_data')); for (idx in flock) {
                setItem(id+'_lock_'+idx,flock[idx]);
            }
        }
    }
}
function remove_entry(id,obj,name,complex=false,helper=false,dy=';',dx=':') {
    var rawData=(typeof(obj)=='object')?obj.value:obj;
    var resarr=(complex)?jsonarr(rawData):arrjob((rawData),dy,dx);
    delete resarr[id]; set(name,JSON.stringify(resarr),true);
    if (helper) { del(id+'.json',true); del(id,true); }
    obj.value=(complex)?arrjson(resarr):arrpack(resarr,dy,dx);
}
function delete_user(id) {
    unbind(sysDefSessionID.value); unbind(id);
    remove_entry(id,sysDefBindData,'binding.json');
    remove_entry(id,sysDefPowersData,'dominion.json');
    remove_entry(id,sysDefAutoData,'automator.json');
    remove_entry(id,sysDefFriendData,'friendship.json');
    remove_entry(id,sysDefToolData,'toolbox.json');
    remove_entry(id,sysDefCallData,'calling.json');
    del(id+'_session.json',true); del(id+'_session.json.bak',true);
    del(id+'_password',true); del(id+'_lock.json',true);
    del(id+'_lock.json.bak',true); del(id+'_metadata.json',true);
    del(id+'_metadata.json.bak',true);
    del('./.msgbox/'+id+'_msgbox.json',true);
    del('./.msgbox/'+id+'_msgbox.json.bak',true);
    del('./.book/'+id+'_book.json',true);
    del('./.book/'+id+'_book.json.bak',true);
    del('./.store/'+id+'_store.json',true);
    del('./.store/'+id+'_store.json.bak',true);
    del('./.cabinet/'+id+'_cabinet.json',true);
    del('./.cabinet/'+id+'_cabinet.json.bak',true);
}
function transfer_entry(id,obj,name,onlyAssignID=false) {
    var objData=arrjob(obj.value,';',':');
    objData[id]=(onlyAssignID)?id:objData[sysDefSessionID.value];
    if (sysDefSessionID.value!=id) { delete objData[sysDefSessionID.value]; }
    set(name+'.json',JSON.stringify(objData),true);
    obj.value=arrpack(objData,';',':');
}
function rename_user(username,password) {
    unbind(sysDefSessionID.value); unbind(username);
    change(sysDefSessionID.value,username,CryptoJS.SHA256(password).toString(),true);
    if (sysDefSessionID.value!=username) {
        transfer_entry(username,sysDefBindData,'binding',true);
        transfer_entry(username,sysDefPowersData,'dominion');
        transfer_entry(username,sysDefAutoData,'automator');
        transfer_entry(username,sysDefFriendData,'friendship');
        transfer_entry(username,sysDefToolData,'toolbox');
        transfer_entry(username,sysDefCallData,'calling',true);
    }
}
function createEmptyRecord(id,obj,name,val) {
    var tab=arrjob(obj.value,';',':');
    if (!(id in tab)) {
        tab[id]=val; set(name+'.json',JSON.stringify(tab),true);
        obj.value=arrpack(tab,';',':');
    }
}
function init_user(id,pass='',args='',helper=false) {
    var usersList=(sysDefUsersList.value).split(',');
    if (usersList.indexOf(id)<=-1) {
        set('./.msgbox/'+id+'_msgbox.json','{}',true);
        set('./.book/'+id+'_book.json','{}',true);
        set('./.store/'+id+'_store.json','{}',true);
        set('./.cabinet/'+id+'_cabinet.json','{}',true);
    } createEmptyRecord(id,sysDefBindData,'binding',id);
    createEmptyRecord(id,sysDefPowersData,'dominion',0);
    createEmptyRecord(id,sysDefPowersData,'automator',((args.includes('auto'))?'auto':'manual'));
    createEmptyRecord(id,sysDefFriendData,'friendship','');
    createEmptyRecord(id,sysDefToolData,'toolbox','');
    createEmptyRecord(id,sysDefCallData,'calling',id);
    if (pass!='') { set(id+'_password',pass,true); }
    if (helper) { delete_user(''); }
}
function friendsOf(obj,id) {
    var res=(obj[id]!==undefined)?((obj[id].includes(','))?obj[id].split(','):[obj[id]]):[]; return res;
}
function isFriends(id) {
    var usr=sysDefSessionID.value;
    var fr=arrjob(sysDefFriendData.value,';',':');
    var frnd=friendsOf(fr,usr),res=false;
    if (id!=usr) { if (frnd.indexOf(id)>-1) { res=true; }} return res;
}
function administer(sta,md='+') {
    if (superuser()) {
        var sto={'bind':'binding','call':'calling','auto':'automator','friend':'friendship','tool':'toolbox','ip':'visitors','powers':'dominion','hdi':'i18n'};
        var sti={'bind':'μ','call':'μ','auto':'μ','friend':'μ','tool':'μ','powers':'μ'},rid=sysDefSessionID.value;
        var stu={'bind':'i','call':'i','auto':'manual|auto','friend':'e','tool':'e','powers':'n'},rid=sysDefSessionID.value;
        var ept=document.getElementById('sysDef'+ucfirst(sta)+'Data'),arr=ept.value,eps=sto[sta]+'.json',ob={}; if (sti[sta]!==undefined) {
            if (sti[sta]=='μ') { ob=arrjob(arr,';',':');
            } else { ob=jsonarr(arr); }
        } else { ob=jsonarr(arr); }
        var sum=arrsum(Object.values(ob)),qua=Object.keys(ob).length;
        if (stu[sta]!==undefined) {
            if (stu[sta]=='i') {
                for (ib in ob) { ob[ib]=ib; }
            } else if (stu[sta].includes('|')) {
                for (ib in ob) { ob[ib]=(md=='-')?stu[sta].split('|')[0]:stu[sta].split('|')[1]; }
            } else if (stu[sta]=='e') {
                for (ib in ob) { ob[ib]=''; }
            } else if (stu[sta]=='n') {
                if (md=='-') {
                    div=Math.round(sum/qua);
                    for (ib in ob) { ob[ib]=parseInt(div); }
                } else {
                    for (ib in ob) { ob[ib]=parseInt(sum); }
                }
            }
        } if (ob!==null) {
            set(eps,JSON.stringify(ob),true);
            if (sti[sta]!==undefined) {
                if (sti[sta]=='μ') { ept.value=arrpack(ob,';',':');
                } else { ept.value=arrjson(ob); }
            } else { ept.value=arrjson(ob); }
        }
    }
}
function jsonFilter(str,mask) {
    var arr=jsonarr(str),sym='#',uni='L';
    var arf={},cyp='.-',hbin=hkin='',hbio={};
    if (mask==sym) {
        for (el in arr) {
            hbin=dtw(arr[el],sysDefSessionID.value,cyp);
            hkin=dtw(el,sysDefSessionID.value,cyp),arf[hkin]=hbin;
        }
    } else {
        var arrRegex=XRegExp('(\\'+sym+'\\p{'+uni+'}+)','g');
        var repRegex=XRegExp('(\\'+sym+'+)','g');
        var wordArr=XRegExp.match(mask,arrRegex);
        for (el in arr) {
            if (wordArr!==null) {
                for (iy in wordArr) {
                    hbin=dtw(arr[el],sysDefSessionID.value,cyp);
                    hkin=dtw(el,sysDefSessionID.value,cyp);
                    hbio=XRegExp.replace(wordArr[iy],repRegex,'');
                    if (hbin.toLowerCase().includes(hbio.toLowerCase())) { arf[hkin]=hbin; }
                }
            }
        }
    } return arf;
}
function jsonHTML(str,mask) {
    var arr=jsonFilter(str,mask),ard='',fu0=fu1='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    for (el in arr) {
        fu0="clearJournal(&#39;"+etw(el,usr)+"&#39;,&#39;"+sysDefMsgData.value+"&#39;,&#39;msgbox&#39;);"; fu1="clip(&#39;"+arr[el]+"&#39;);";
        ard=el+" <input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='"+fu0+"'><br>"+arr[el]+" <input type='image' class='power' onmouseover='soundButton();' src='"+epr+"copy.png"+"' onclick='"+fu1+"'><br>"+ard;
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
function jsonMarket(id) {
    return jsonarr(openJournal(id,sysDefUsersList,sysDefStoreJSONs));
}
function activeHrsBtn(id) {
    var arr=storeHours(id).split(',');
    var arl=''; for (el in arr) {
        arl+="<input type='button' onmouseover='soundButton();' value='"+arr[el]+"'>";
    } return arl;
}
function showLockInd() {
    var ob=((jsonarr(sysDefLockData.value)!==undefined)&&(jsonarr(sysDefLockData.value)!==null))?jsonarr(sysDefLockData.value):{},ch=Object.keys(ob||{});
    var lic=jsonarr(sysDefLockIcons.value);
    var epr=sysDefPrefix.value,arl=""; for (iu in ch) {
        arl+="<input type='image' class='power' onmouseover='soundButton();' onmouseover='soundButton();' src='"+epr+lic[ch[iu]]+".png"+"' onclick='setdata(&#34;album&#34;,&#34;"+ch[iu]+"&#34;);'>";
    } return arl;
}
function listlock(id) {
    var ob=lockarr(id),ar=[];
    for (iu in ob) { ar.push(ob[iu].split('.')[1]); }
    return ar;
}
function jsonStore(id) {
    var arr=jsonarr(openJournal(id,sysDefUsersList,sysDefStoreJSONs));
    var ard=arl='',eld={},fu0=fu1='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    for (el in arr) {
        if ((arr[el]!==undefined)&&(typeof(arr[el])=='object')) {
            eld=arr[el],arl='<tr>';
            fu0="buy_item(&#34;"+usr+"&#34;,&#34;"+el+"&#34;,&#34;"+id+"&#34;);",fu1=(isInt(el))?"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":((eld['type']=='weapon')?"equip(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);");
            arl+="<td><input type='button' onmouseover='soundButton();' style='width:80%;' onclick='"+((id!=usr)?fu0:fu1)+"' value='"+el+"'>";
            arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"info.png"+"' onclick='omniPath(&#34;./.store/"+usr+"_store.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>";
            arl+="</td><td>"+eld['amount']+"</td><td>$"+eld['price']+"</td>"; ard=arl+"</tr>"+ard;
        }
    } return ard;
}
function formCur(val) {
    var cur=sysDefCurrency.value,res=curSign=userSign=delim=delimit='';
    var num=sign=start=end=''; if (cur.length==7) {
        curSign=(cur.charAt(1)!='x')?(cur.charAt(1)):'';
        userSign=(cur.charAt(5)!='y')?(cur.charAt(5)):'';
        delim=(cur.charAt(3)!=':')?(cur.charAt(3)):'';
        delimit=(delim=='_')?' ':delim;
        num=(isInt(val))?delimNum(parseInt(val),delimit):val;
        sign=(isInt(val))?curSign:userSign;
        start=(isInt(val))?0:4,end=(isInt(val))?2:6;
        if ((cur.charAt(start)=='^')&&(cur.charAt(end)=='_')) {
            res=sign+' '+num;
        } else if ((cur.charAt(start)=='_')&&(cur.charAt(end)=='^')) {
            res=num+' '+sign;
        } else if ((cur.charAt(start)=='^')&&(cur.charAt(end)==':')) {
            res=sign+num;
        } else if ((cur.charAt(start)==':')&&(cur.charAt(end)=='^')) {
            res=num+sign;
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
        arl+=(isInt(eld[2]))?'<td>'+formCur(eld[2])+'</td>':'<td>'+eld[2]+'</td>';
        arl+=(isInt(eld[3]))?'<td>'+formCur(eld[3])+'</td>':'<td>'+eld[3]+'</td>';
        arl+='<td>'+formCur(eld[4])+'</td>';
        ard=arl+'</tr>'+ard;
    } return ard;
}
function jsonDocs(str) {
    var arr=jsonarr(str),ard=arl='',arf={},eld=[];
    var epr=sysDefPrefix.value,fu0=fu1=''; for (el in arr) {
        arf[el]=arr[el];
    } for (el in arf) {
        fu0="markJournal(&#39;"+el+"&#39;,&#39;"+sysDefGovtData.value+"&#39;,&#39;cabinet&#39;,&#39;status&#39;,&#39;&#45;&#39;);";
        fu1="markJournal(&#39;"+el+"&#39;,&#39;"+sysDefGovtData.value+"&#39;,&#39;cabinet&#39;,&#39;status&#39;,&#39;&#43;&#39;);";
        arl='<tr>'; arl+='<td>'+arf[el]['plaintiff']+'</td>';
        arl+='<td>'+arf[el]['defendant']+'</td>';
        arl+='<td>'+arf[el]['claims']+'</td>';
        arl+='<td>'+arf[el]['status']+'</td><td>';
        arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"plus.png"+"' onclick='"+fu0+"'>";
        arl+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"min.png"+"' onclick='"+fu1+"'>";
        ard=arl+'</td></tr>'+ard;
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
function etw(msg,usr='',abc='.-') {
    return encode(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function dtw(msg,usr='',abc='.-') {
    return decode(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function systemUpdate(query) {
    var parts=query.toString('').split(' ');
    for (i=0; i<parts.length; i++) {
        var part=payload(parts[i]);
        get('i', part[0], 'from', part[1], part[2], part[3], true);
    }
}
function obtainRepo(query) {
    var parts=query.toString('').split(' ');
    for (i=0; i<parts.length; i++) {
        var part=payload(parts[i]);
        getdir('i',part[0],'from',part[1],part[2],part[3],true);
    }
}
function replacePackage(quid,quo,ord=0) {
    var toRem=quid.toString('').split(' ');
    var toSet=quo.toString('').split(' ');
    var part=[]; if (ord<0) {
        for (i=0; i<toSet.length; i++) {
            part=payload(toSet[i]);
            get('i',part[0],'from',part[1],part[2],part[3],true);
        } for (i=0; i<toRem.length; i++) {
            get('d','',toRem[i],'from','','here',true);
        }
    } else {
        for (i=0; i<toRem.length; i++) {
            get('d','',toRem[i],'from','','here',true);
        } for (i=0; i<toSet.length; i++) {
            part=payload(toSet[i]);
            get('i',part[0],'from',part[1],part[2],part[3],true);
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
        get('d','',query.split(' ')[i],'from','','here',true);
    }
}
function terminate(query) {
    for (i=0; i<query.split(' ').length; i++) {
        getdir('d','',query.split(' ')[i],'from','','here',true);
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
    var powersData=arrjob(sysDefPowersData.value,';',':');
    var bindData=arrjob(sysDefBindData.value,';',':');
    var autoData=arrjob(sysDefAutoData.value,';',':');
    sysDefAutoState.value=autoData[sysDefSessionID.value];
    $('#buttonAutomator').attr('src',sysDefPrefix.value+((sysDefAutoState.value=='auto')?'wheel.png':'steer.png'));
    var myPowers=powersData[sysDefSessionID.value];
    var chainIcon='chain'; if (myPowers<=-666) {
        delete_user(sysDefSessionID.value);omniAuthRequest('signout','','');
    } chainIcon=(arraySearch(sysDefSessionID.value,bindData)!=false)?((bindData[sysDefSessionID.value]!=sysDefSessionID.value)?'unbroke':'unchain'):((bindData[sysDefSessionID.value]!=sysDefSessionID.value)?'broke':'chain');
    var powerHandler=formCur(myPowers);
    var nameHandler=formCur(sysDefSessionID.value);
    $('#buttonBroke').attr('src',sysDefPrefix.value+chainIcon+'.png');
    $('#showUsInfoPower').val(powerHandler);
    $('#showUsInfoBond').val(nameHandler);
}
function call(usr,id) {
    var obj=arrjob(sysDefCallData.value,';',':');
    obj[id]=usr; set('calling.json',JSON.stringify(obj),true);
    sysDefCallData.value=arrpack(obj,';',':');
}
function bind(usr,id) {
    var obj=arrjob(sysDefBindData.value,';',':');
    obj[usr]=id; set('binding.json',JSON.stringify(obj),true);
    sysDefBindData.value=arrpack(obj,';',':');
}
function equip(usr,id) {
    var obj=arrjob(sysDefToolData.value,';',':');
    obj[usr]=id; set('toolbox.json',JSON.stringify(obj),true);
    sysDefToolData.value=arrpack(obj,';',':');
}
function automate() {
    var usr=sysDefSessionID.value;
    var obj=arrjob(sysDefAutoData.value,';',':');
    obj[usr]=(sysDefAutoState.value=='auto')?'manual':'auto';
    set('automator.json',JSON.stringify(obj),true);
    sysDefAutoData.value=arrpack(obj,';',':');
}
function compose(msg) {
    var addr=(msg!==undefined)?msg.match(/(@\S*)/g):'';
    var userID,cyp='.-',msgbox='',msgbr=[];
    var ratTab=arrjob(sysDefPowersData.value,';',':');
    if (ratTab[sysDefSessionID.value]>=0) {
        if (addr!==null) {
            for (it in addr) {
                userID=addr[it].replace('@','');
                msgbox=openJournal(userID,sysDefUsersList,sysDefMailingJSONs); msgarr=jsonarr(msgbox);
                if (msg.match(/\r?\n/)!==null) {
                    msgbr=msg.split(/\r?\n/);
                    for (j=0; j<msgbr.length; j++) {
                        msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC',userID,cyp)]=etw(msgbr[j],userID,cyp);
                    }
                } else {
                    msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC',userID,cyp)]=etw(msg,userID,cyp);
                } set('./.msgbox/'+userID+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
            }
        } else {
            msgbox=sysDefMsgData.value; msgarr=jsonarr(msgbox);
            if (msg.match(/\r?\n/)!==null) {
                msgbr=msg.split(/\r?\n/);
                for (j=0; j<msgbr.length; j++) {
                    msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now()+j*1000)+' UTC',sysDefSessionID.value,cyp)]=etw(msgbr[j],sysDefSessionID.value,cyp);
                }
            } else {
                msgarr[etw(sysDefTitle.value+' (@'+sysDefSessionID.value+') · '+isoformat(Date.now())+' UTC',sysDefSessionID.value,cyp)]=etw(msg,sysDefSessionID.value,cyp);
            } set('./.msgbox/'+sysDefSessionID.value+'_msgbox.json', encodeURIComponent(JSON.stringify(msgarr)), true);
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
        var tabS=jsonarr(openJournal(seller,sysDefUsersList,sysDefStoreJSONs));
        var tabB=jsonarr(openJournal(buyer,sysDefUsersList,sysDefStoreJSONs));
        var prix,pass,powersData=arrjob(sysDefPowersData.value,';',':');
        if ((powersData[buyer]>=0)&&(powersData[seller]>=0)) {
            if ((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')) {
                if ((isInt(tabS[art]['price']))&&(!isInt(art))) {
                    prix=parseInt(tabS[art]['price']);
                    if (powersData[buyer]>=prix) {
                        fixPrice(buyer,seller,art,prix);
                        amounts(tabS,tabB,art);
                        set('./.store/'+seller+'_store.json',encodeURIComponent(JSON.stringify(tabS)),true); set('./.store/'+buyer+'_store.json',encodeURIComponent(JSON.stringify(tabB)),true);
                        if ((tabS[art]['password']!==undefined)&&(tabS[art]['type']=='account')) {
                            copy(seller+'_session.json.bak',buyer+'_session.json.bak',true,1);
                            copy(seller+'_session.json',buyer+'_session.json',true,1);
                            copy(seller+'_lock.json.bak',buyer+'_lock.json.bak',true,1);
                            copy(seller+'_lock.json',buyer+'_lock.json',true,1);
                            change(buyer,buyer,tabS[art]['password'],true);
                            omniAuthRequest('signin',buyer,tabS[art]['password']);
                        } else if ((tabS[art]['password']!==undefined)&&(tabS[art]['type']=='password')) {
                            change(seller,seller,tabS[art]['password'],true);
                            omniAuthRequest('signin',seller,tabS[art]['password']);
                        }
                    }
                } else if ((!isInt(tabS[art]['price']))&&(!isInt(art))&&(tabB[tabS[art]['price']]!==undefined)&&(typeof(tabB[tabS[art]['price']])=='object')) {
                    prix=tabS[art]['price']; fixPrice(buyer,seller,art,prix);
                    amounts(tabB,tabS,prix); amounts(tabS,tabB,art);
                    set('./.store/'+seller+'_store.json',encodeURIComponent(JSON.stringify(tabS)),true);
                    set('./.store/'+buyer+'_store.json',encodeURIComponent(JSON.stringify(tabB)),true);
                } else if ((!isInt(tabS[art]['price']))&&(tabS[art]['price']=='')) {
                    prix=tabS[art]['price']; fixPrice(buyer,seller,art,prix); amounts(tabS,tabB,art);
                    set('./.store/'+seller+'_store.json',encodeURIComponent(JSON.stringify(tabS)),true);
                    set('./.store/'+buyer+'_store.json',encodeURIComponent(JSON.stringify(tabB)),true);
                }
            }
        }
    }
}
function sell_item(usr,art,rawTxtData='') {
    var tabS=jsonarr(openJournal(usr,sysDefUsersList,sysDefStoreJSONs));
    var powersData=arrjob(sysDefPowersData.value,';',':');
    var dataArr=arrjob(rawTxtData,'; ',': '); if (powersData[usr]>=0) {
        var amount=((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')&&(tabS[art]['amount']!==undefined)&&isInt(tabS[art]['amount'])&&(tabS[art]['amount']>=0))?parseInt(tabS[art]['amount'])+1:1; tabS[art]={"amount":amount}; for (idx in dataArr) {
            tabS[art][idx]=(idx=='password')?CryptoJS.SHA256(dataArr[idx]).toString():dataArr[idx];
        } set('./.store/'+usr+'_store.json',encodeURIComponent(JSON.stringify(tabS)),true);
    }
}
function fixPrice(sen,rec,deb,cre) {
    var tran1=openJournal(sen,sysDefUsersList,sysDefBookKeepJSONs);
    var tran2=openJournal(rec,sysDefUsersList,sysDefBookKeepJSONs);
    var trans1=jsonarr(tran1),trans2=jsonarr(tran2);
    var stat=arrjob(sysDefPowersData.value,';',':');
    var statD=(isInt(stat[sen]))?parseInt(stat[sen]):0;
    var statC=(isInt(stat[rec]))?parseInt(stat[rec]):0;
    var statDr=parseInt(statD),statCr=parseInt(statC);
    var bal1=((tran1=='{}')||(tran1==''))?statDr:(trans1[Object.keys(trans1)[Object.keys(trans1).length-1]]).split(' | ')[4];
    var bal2=((tran2=='{}')||(tran2==''))?statCr:(trans2[Object.keys(trans2)[Object.keys(trans2).length-1]]).split(' | ')[4];
    var statDt,statCt,statK,statV,statDi,statCi,statDn,statCn,statT;
    var statDv=statDr-parseInt(bal1),statCv=statCr-parseInt(bal2);
    if ((isInt(deb))&&!(isInt(cre))) {
        statV=parseInt(deb),statK=cre,statT=cre;
        statD+=statV; statC-=statV;
        statDi=parseInt(bal1)+parseInt(statDv)+statV;
        statCi=parseInt(bal2)+parseInt(statCv)-statV;
    } else if (!(isInt(deb))&&(isInt(cre))) {
        statV=parseInt(cre),statK=deb,statT=deb;
        statD-=statV; statC+=statV;
        statDi=parseInt(bal1)+parseInt(statDv)-statV;
        statCi=parseInt(bal2)+parseInt(statCv)+statV;
    } else { statK=cre,statT=deb;
        statDi=parseInt(bal1)+parseInt(statDv);
        statCi=parseInt(bal2)+parseInt(statCv);
    } statDn=Math.abs(statDi-parseInt(bal1));
    statCn=Math.abs(statCi-parseInt(bal2));
    statDt=(statDi==statD)?'OK':'ERR';
    statCt=(statCi==statC)?'OK':'ERR';
    stat[sen]=parseInt(statD),stat[rec]=parseInt(statC);
    trans1[isoformat(Date.now())+' UTC']=(statDi<parseInt(bal1))?sen+' | '+rec+' | '+statT+' | '+statDn+' | '+statDi+' | '+statDt : sen+' | '+rec+' | '+statDn+' | '+statT+' | '+statDi+' | '+statDt;
    trans2[isoformat(Date.now())+' UTC']=(statCi<parseInt(bal2))?rec+' | '+sen+' | '+statT+' | '+statCn+' | '+statCi+' | '+statCt : rec+' | '+sen+' | '+statCn+' | '+statT+' | '+statCi+' | '+statCt;
    if (!isInt(deb)&&!isInt(cre)) {
        trans1[isoformat(Date.now())+' UTC']=sen+' | '+rec+' | '+statT+' | '+statK+' | '+statDi+' | '+statDt;
        trans2[isoformat(Date.now())+' UTC']=rec+' | '+sen+' | '+statK+' | '+statT+' | '+statCi+' | '+statCt;
    } set('./.book/'+sen+'_book.json',encodeURIComponent(JSON.stringify(trans1)),true);
    set('./.book/'+rec+'_book.json',encodeURIComponent(JSON.stringify(trans2)),true);
    set('dominion.json',JSON.stringify(stat),true);
    sysDefPowersData.value=arrpack(stat,';',':');
}
function charge(usr,art='') {
    var powersData=arrjob(sysDefPowersData.value,';',':');
    var userMarket=jsonMarket(usr);
    var force=amount=series=finite=0;
    var usrPwr=(isInt(powersData[usr]))?parseInt(powersData[usr]):0;
    if (usrPwr>=0) {
        if ((userMarket[art]!==undefined)&&(typeof(userMarket[art])=='object')&&(userMarket[art]['type']!='account')&&(userMarket[art]['type']!='password')&&(userMarket[art]['type']!='weapon')) {
            amount=((userMarket[art]['amount']!==undefined)&&isInt(userMarket[art]['amount']))?parseInt(userMarket[art]['amount']):1;
            force=(isInt(art))?parseInt(art):(((userMarket[art]['force']!==undefined)&&isInt(userMarket[art]['force']))?parseInt(userMarket[art]['force']):1);
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
        set('./.store/'+usr+'_store.json',encodeURIComponent(JSON.stringify(userMarket)),true);
        set('dominion.json',JSON.stringify(powersData),true);
        sysDefPowersData.value=arrpack(powersData,';',':');
    }
}
function dominate(usr,id,art='') {
    var powersData=arrjob(sysDefPowersData.value,';',':');
    var userMarket=jsonMarket(usr);
    var force=amount=series=finite=0;
    var usrPwr=(isInt(powersData[usr]))?parseInt(powersData[usr]):0;
    var idPwr=(isInt(powersData[id]))?parseInt(powersData[id]):0;
    if ((usr!=id)&&(usrPwr>=0)) {
        if ((userMarket[art]!==undefined)&&(typeof(userMarket[art])=='object')&&(userMarket[art]['type']=='weapon')) {
            amount=((userMarket[art]['amount']!==undefined)&&isInt(userMarket[art]['amount']))?parseInt(userMarket[art]['amount']):1;
            force=((userMarket[art]['force']!==undefined)&&isInt(userMarket[art]['force']))?parseInt(userMarket[art]['force']):1;
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
            set('./.store/'+usr+'_store.json',encodeURIComponent(JSON.stringify(userMarket)),true);
            set('dominion.json',JSON.stringify(powersData),true);
            sysDefPowersData.value=arrpack(powersData,';',':');
        }
    }
}
function unbind(id) { bind(id,id); }
function unequip(id) { equip(id,''); }
function toggleFriend(id) {
    var usr=sysDefSessionID.value;
    var fr=arrjob(sysDefFriendData.value,';',':');
    var frnd=friendsOf(fr,usr);
    if (id!=usr) {
        if (frnd.indexOf(id)>-1) {
            frnd.splice(frnd.indexOf(id),1);
        } else { frnd.push(id); }
        fr[usr]=finarr(frnd).sort().join(',');
        set('friendship.json',JSON.stringify(fr),true);
        sysDefFriendData.value=arrpack(fr,';',':');
    }
}
function addFriend(id) {
    var usr=sysDefSessionID.value;
    var fr=arrjob(sysDefFriendData.value,';',':');
    var frnd=friendsOf(fr,usr); if (id!=usr) {
        frnd.push(id);
        fr[usr]=finarr(frnd).sort().join(',');
        set('friendship.json',JSON.stringify(fr),true);
        sysDefFriendData.value=arrpack(fr,';',':');
    }
}
function dropFriend(id) {
    var usr=sysDefSessionID.value;
    var fr=arrjob(sysDefFriendData.value,';',':');
    var frnd=friendsOf(fr,usr);
    if (id!=usr) {
        if (frnd.indexOf(id)>-1) {
            frnd.splice(frnd.indexOf(id),1);
        } fr[usr]=finarr(frnd).sort().join(',');
        set('friendship.json',JSON.stringify(fr),true);
        sysDefFriendData.value=arrpack(fr,';',':');
    }
}
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
    } setdata('melody',etw(input,sysDefSessionID.value,sysDefNumeric.value));
    setdata('pitch_lock',sysDefPitchLock.value);
    setdata('audio_volume',sysDefAudioVolume.value);
    setdata('audio_speed',sysDefAudioSpeed.value);
}
function songIndex(mode='') {
    var lxn=lockarr('music'),nxp=sysDefPlaylist.value;
    var nxt=(nxp.includes(' | '))?nxp.split(' | '):((nxp!='')?[nxp]:[]);
    var mel=dtw(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
    var ind=arraySearch(((mel.startsWith(requestPath.value+'/'))?mel.replace(requestPath.value+'/',''):mel),lxn);
    if (nxp!='') {
        if (nxt[0]!='') {
            omniListen(dtw(nxt[0],sysDefSessionID.value,sysDefNumeric.value),true);
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
        audioPlayer.currentTime=(sec.includes('-'))?(audioPlayer.duration-parseInt(sec.replace('-',''))):(((sec.includes('+')))?(parseInt(sec.replace('+',''))):(parseInt(sec)));
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
        pressedCode.innerText=(event.code).toUpperCase();
    }
}
</script>
