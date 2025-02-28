<script>
// SYSTEM JS LOAD DATA (USES PHP)
function lockdata() {
    var obj={
        <?php $iter=0; foreach ($locks as $key=>$value) {
            echo "'".$key."': lock".camel($key).".value".((count($locks)==($iter-1))?'':','); $iter++;
        } $iter=0; ?>
    }; return obj;
}
function userdata() {
    var obj = {
        <?php $iter=0; foreach ($settings['defaults'] as $key=>$value) {
            echo "'".$key."': sysDef".camel($key).".value".((count($settings['defaults'])==($iter-1))?'':','); $iter++;
        } $iter=0; ?>
    }; return obj;
}
function setlock(ent,val) {
    var obj=lockdata(); obj[ent]=val;
    set(sysDefSessionID.value+'_lock.json',JSON.stringify(obj),true);
    <?php foreach ($locks as $key=>$value) {
        echo "lock".camel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent,val) {
    var obj=userdata(); obj[ent]=val;
    set(sysDefSessionID.value+'_session.json',JSON.stringify(obj),true);
    <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".camel($key).".value = obj['".$key."'];";
    } ?> if (ent=='audio_volume') { audioPlayer.volume = val; }
    if (ent=='audio_speed') { audioPlayer.playbackRate=val; }
    if (ent=='alarm_volume') { alarmPlayer.volume=val; }
    if (ent=='timer_volume') { tickerPlayer.volume=val; }
    if (ent=='loop_volume') { backgroundPlayer.volume=val; }
    if (ent=='rest_volume') {
        soundPlayer.volume=typePlayer.volume=errorPlayer.volume=notifyPlayer.volume=bindPlayer.volume=hitPlayer.volume=sufferPlayer.volume=val;
    } if (ent=='pitch_lock') { audioPlayer.preservesPitch=(val!=0)?true:false; } if (requestMode.value=='sticky_notes') {
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
// OTHER FRONTEND FUNCTIONS
function superuser() {
    /* CHECKS IF CURRENT USER IS A SUPERUSER AND IS AUTHORIZED AS SUCH */
    return ((sysDefIsSession.value!=false)&&(sysDefSessionID.value=='root'));
}
function authstate() {
    /* JUST CHECK IF THE APP SESSION IS AUTHORIZED WITH USER ACCOUNT */
    return (sysDefIsSession.value!=false);
}
function trigUserDel() {
    /* SETS CURRENT USER SCORE VALUE TO -666 TO TRIGGER ITS DELETION */
    var dp=arrjob(sysDefPowersData.value,';',':');
    dp[sysDefSessionID.value]=-666;
    set('dominion.json',JSON.stringify(dp),true);
    sysDefPowersData.value=arrpack(dp,';',':');
}
function lockarr(ind) {
    /* GET ELEMENTS LOCKED AND ENCAPSULATED FOR ACCOUNT */
    return Object.values(jsonstr(sysDefLockData.value)[ind]);
}
function lockcount(ind) {
    /* COUNT ELEMENTS LOCKED AND ENCAPSULATED FOR ACCOUNT */
    return Object.keys(jsonstr(sysDefLockData.value)[ind]).length;
}
function metadata() { return jsonstr(sysDefMetaData.value); }
function setmeta(ent,val) {
    var obj=metadata(); obj[ent]=val;
    set(sysDefSessionID.value+'_metadata.json',JSON.stringify(obj),true);
}
function delmeta(ent) {
    var obj=metadata(); delete obj[ent];
    set(sysDefSessionID.value+'_metadata.json',JSON.stringify(obj),true);
}
function clearJournal(num,obj,name,anyFile=false) {
    /* CLEAR ANY VALUE INSIDE JSON DATA FILE */
    var msgarr={}; if (typeof(obj)=='object') {
        msgarr=jsonstr(obj.value);
    } else { msgarr=jsonstr(obj); }
    var nur,ras,las=Object.keys(msgarr).length-1;
    if (isInt(num)) {
        nur=Math.abs(num),ras=(las-nur); if (num<0) {
            /* DELETE ENTRIES FROM START */ for (i=0; i<nur; i++) {
                if (msgarr[Object.keys(msgarr)[0]]!==undefined) { delete msgarr[Object.keys(msgarr)[0]]; }
            }
        } else {
            /* DELETE ENTRIES FROM END */ for (i=las; i>ras; i--) {
                if (msgarr[Object.keys(msgarr)[i]]!==undefined) { delete msgarr[Object.keys(msgarr)[i]]; }
            }
        }
    } else { /* DELETE MESSAGE BY ITS KEY IN MESSAGE ARRAY */
        if (msgarr[num]!==undefined) { delete msgarr[num]; }
    } if (anyFile) {
        set('./'+name+'.json',encodeURIComponent(JSON.stringify(msgarr)),true);
    } else { set('./.'+name+'/'+sysDefSessionID.value+'_'+name+'.json',encodeURIComponent(JSON.stringify(msgarr)),true); }
}
function openJournal(id,usersObj,dataObj) {
    /* OPEN ANY USER DATA JOURNAL */
    var userArr=(usersObj.value).split(',');
    var userNum=arraySearch(id,userArr);
    return pager((dataObj.value),userNum);
}
function storeOpen(id) {
    /* IS ANOTHER USER STORE/INVENTORY OPEN */
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    var hours=storeHours(id).split(',');
    return (hours.includes(userTimeNow(id)));
}
function userTimeNow(id) {
    /* WHAT TIME IS IT IN ANOTHER USER ACCOUNT */
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    return (sysDefHoursNow.value).split(' ')[userNum];
}
function getUserAvatar(id) {
    /* WHAT AVATAR OTHER USER GOT */
    var avaArr=arrjob(sysDefAvatarsNow.value,';',':');
    return (avaArr[id]!==undefined)?avaArr[id]:'NULL';
}
function storeHours(id) {
    /* GET ACTIVE HOURS OF ANOTHER USER */
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    return pager(sysDefHoursActive.value,userNum);
}
function remove_entry(id,obj,name,complex=false,helper=false,dy=';',dx=':') {
    /* REMOVE CERTAIN ENTRY FROM CERTAIN DATA BANK */
    var dat={}; if (typeof(obj)=='object') {
        dat=(complex)?jsonstr(obj.value):arrjob((obj.value),dy,dx);
    } else { dat=(complex)?jsonstr(obj):arrjob((obj),dy,dx); }
    delete dat[id]; set(name,JSON.stringify(dat),true);
    if (helper) { del(id+'.json',true); del(id,true); }
    obj.value=(complex)?jsonarr(dat):arrpack(dat,dy,dx);
}
function delete_user(id) {
    /* COMPLETELY REMOVES USER WITH ALL ITS DATA */
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
}
function transfer_entry(id,obj,name,onlyAssignID=false) {
    /* TRANSFER ENTRY OF USER TO ANOTHER USER */
    var objData=arrjob(obj.value,';',':');
    /* CREATES ENTRY FOR ANOTHER USER AND TRANSFER CURRENT USER DATA */
    objData[id]=(onlyAssignID!==false)?id:objData[sysDefSessionID.value];
    /* REMOVES CURRENT USER TO FREE SERVER SPACE */
    if (sysDefSessionID.value!=id) { delete objData[sysDefSessionID.value]; }
    set(name+'.json',JSON.stringify(objData),true);
    obj.value=arrpack(objData,';',':');
}
function rename_user(username,password) {
    /* CHANGES CURRENT USER ID AND TRANSFERS ITS DATA */
    unbind(sysDefSessionID.value); unbind(id);
    change(sysDefSessionID.value,username,CryptoJS.SHA256(password).toString(),true); if (sysDefSessionID.value!=username) {
        transfer_entry(username,sysDefBindData,'binding',true);
        transfer_entry(username,sysDefPowersData,'dominion');
        transfer_entry(username,sysDefAutoData,'automator');
        transfer_entry(username,sysDefFriendData,'friendship');
        transfer_entry(username,sysDefToolData,'toolbox');
        transfer_entry(username,sysDefCallData,'calling',true);
    }
}
function init_user(id,au='manual',helper=false) {
    /* INITIALIZE NEW USER */
    var bd=arrjob(sysDefBindData.value,';',':');
    var pd=arrjob(sysDefPowersData.value,';',':');
    var ad=arrjob(sysDefAutoData.value,';',':');
    var fd=arrjob(sysDefFriendData.value,';',':');
    var td=arrjob(sysDefToolData.value,';',':');
    var cd=arrjob(sysDefCallData.value,';',':');
    var usl=(sysDefUsersList.value).split(',');
    var bkl=(sysDefBooksList.value).split(',');
    var stl=(sysDefStoreList.value).split(',');
    if (usl.indexOf(id)<=-1) {
        set('./.msgbox/'+id+'_msgbox.json','{}',true);
    } if (bkl.indexOf(id)<=-1) {
        set('./.book/'+id+'_book.json','{}',true);
    } if (stl.indexOf(id)<=-1) {
        set('./.store/'+id+'_store.json','{}',true);
    } if (!(id in bd)) {
        bd[id]=id; set('binding.json',JSON.stringify(bd),true);
        sysDefBindData.value=arrpack(bd,';',':');
    } if (!(id in pd)) {
        pd[id]=0; set('dominion.json',JSON.stringify(pd),true);
        sysDefPowersData.value=arrpack(pd,';',':');
    } if (!(id in ad)) {
        ad[id]=au; set('automator.json',JSON.stringify(ad),true);
        sysDefAutoData.value=arrpack(ad,';',':');
    } if (!(id in fd)) {
        fd[id]=''; set('friendship.json',JSON.stringify(fd),true);
        sysDefFriendData.value=arrpack(fd,';',':');
    } if (!(id in td)) {
        td[id]=''; set('toolbox.json',JSON.stringify(td),true);
        sysDefToolData.value=arrpack(td,';',':');
    } if (!(id in cd)) {
        cd[id]=id; set('calling.json',JSON.stringify(cd),true);
        sysDefCallData.value=arrpack(cd,';',':');
    } /* THIS HELPER REMOVES USER WITH EMPTY ID */
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
            } else { ob=jsonstr(arr); }
        } else { ob=jsonstr(arr); }
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
                } else { ept.value=jsonarr(ob); }
            } else { ept.value=jsonarr(ob); }
        }
    }
}
// BASIC DATA FUNCTIONS
function jsonFilter(str,mask) {
    var arr=jsonstr(str),sym='#',uni='L';
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
        fu0="clearJournal(&#39;"+etw(el,usr)+"&#39;,&#39;"+sysDefMsgData.value+"&#39;,&#39;msgbox&#39;,);";
        fu1="clp(&#39;"+arr[el]+"&#39;);";
        ard=el+" <input type='image' class='power' src='"+epr+"delete.png"+"' onclick='"+fu0+"'><br>"+arr[el]+" <input type='image' class='power' src='"+epr+"copy.png"+"' onclick='"+fu1+"'><br>"+ard;
    } return ard;
}
function jsonMarket(id) {
    return jsonstr(openJournal(id,sysDefStoreList,sysDefStoreJSONs));
}
function activeHrsBtn(id) {
    var arr=storeHours(id).split(',');
    var arl=''; for (el in arr) {
        arl+="<input type='button' value='"+arr[el]+"'>";
    } return arl;
}
function jsonStore(id) {
    var arr=jsonstr(openJournal(id,sysDefStoreList,sysDefStoreJSONs));
    var ard=arl='',eld={},fu0=fu1='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    for (el in arr) {
        if ((arr[el]!==undefined)&&(typeof(arr[el])=='object')) {
            eld=arr[el],arl='<tr>';
            fu0="buy_item(&#34;"+usr+"&#34;,&#34;"+el+"&#34;,&#34;"+id+"&#34;);",fu1=(isInt(el))?"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":((eld['type']=='weapon')?"equip(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);");
            arl+="<td><input type='button' style='width:80%;' onclick='"+((id!=usr)?fu0:fu1)+"' value='"+el+"'>";
            arl+="<input type='image' class='power' src='"+epr+"info.png"+"' onclick='omniPath(&#34;./.store/"+usr+"_store.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>";
            arl+="</td><td>"+eld['amount']+"</td><td>$"+eld['price']+"</td>"; ard=arl+"</tr>"+ard;
        }
    } return ard;
}
function formCur(val) {
    var cur=sysDefCurrency.value;
    var res=alm=clm=dlm=x=c='';
    if (cur.length==7) {
        alm=(cur.charAt(1)!='x')?(cur.charAt(1)):'';
        clm=(cur.charAt(5)!='y')?(cur.charAt(5)):'';
        dlm=(cur.charAt(3)!=':')?(cur.charAt(3)):'';
        x=(isInt(val))?delimNum(parseInt(val),dlm):val;
        c=(isInt(val))?alm:clm;
        a=(isInt(val))?0:4,e=(isInt(val))?2:6;
        if ((cur.charAt(a)=='^')&&(cur.charAt(e)=='_')) {
            res=c+' '+x;
        } else if ((cur.charAt(a)=='_')&&(cur.charAt(e)=='^')) {
            res=x+' '+c;
        } else if ((cur.charAt(a)=='^')&&(cur.charAt(e)==':')) {
            res=c+x;
        } else if ((cur.charAt(a)==':')&&(cur.charAt(e)=='^')) {
            res=x+c;
        }
    } return res;
}
function jsonBookKeep(str) {
    var arr=jsonstr(str),ard=arl='',arf={},eld=[];
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
function noteBook(str) {
    var arr=str.split(' | '),ard=arl=eld=elt=eln='';
    var epr=sysDefPrefix.value; for (el in arr) {
        eld=arr[el],eln=sysDefNumeric.value,elt=hex2bin(eld,'',eln);
        arl="<input type='button' style='width:80%;' onclick='openNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);' value='"+elt+"'>";
        arl+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='deleteNote(&#34;"+elt+"&#34;,&#34;&#34;,&#34;"+eln+"&#34;);'>";
        ard=ard+arl+'<br>';
    } return ard;
}
function helpBook() {
    var obj=jsonstr(sysDefTutorData.value),ard=arl=elt='';
    var epr=sysDefPrefix.value; for (el in obj) {
        elt=((obj[el]!==undefined)&&(obj[el][sysDefUnits.value]!==undefined)&&(obj[el][sysDefUnits.value]['title']!==undefined))?obj[el][sysDefUnits.value]['title']:((obj[el]['default']['title']!==undefined)?obj[el]['default']['title']:''); arl="<input type='button' style='width:80%;' onclick='openHelpPage(&#34;"+el+"&#34;);' value='"+elt+"'>";
        arl+="<input type='image' class='power' src='"+epr+"info.png"+"' onclick='omniPath(&#34;tutorial.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>"; ard=ard+arl+'<br>';
    } return ard;
}
function isoformat(num) {
    var ob=new Date(num);
    return (ob.getUTCFullYear())+'-'+pad((ob.getUTCMonth()+1),-2)+'-'+pad((ob.getUTCDate()),-2)+' '+pad((ob.getUTCHours()),-2)+':'+pad((ob.getUTCMinutes()),-2)+':'+pad((ob.getUTCSeconds()),-2)+'.'+pad((ob.getUTCMilliseconds()),-3);
}
function etw(msg,usr='',abc='.-') {
    return bin2hex(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
}
function dtw(msg,usr='',abc='.-') {
    return hex2bin(msg,obfstr(CryptoJS.SHA256(usr).toString()),abc);
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
// EXECUTE VARIOUS TRANSACTIONS
function arrangePlay() {
    var dp=arrjob(sysDefPowersData.value,';',':');
    var db=arrjob(sysDefBindData.value,';',':');
    var da=arrjob(sysDefAutoData.value,';',':');
    sysDefAutoState.value=da[sysDefSessionID.value];
    $('#buttonAutomator').attr('src',sysDefPrefix.value+((sysDefAutoState.value=='auto')?'wheel.png':'steer.png')); var my=dp[sysDefSessionID.value],bl=pl='',ch='chain'; if (my<=-666) {
        delete_user(sysDefSessionID.value);omniAuthRequest('signout','','');
    } ch=(arraySearch(sysDefSessionID.value,db)!=false)?((db[sysDefSessionID.value]!=sysDefSessionID.value)?'unbroke':'unchain'):((db[sysDefSessionID.value]!=sysDefSessionID.value)?'broke':'chain');
    var pl=formCur(my),bl=formCur(sysDefSessionID.value);
    $('#buttonBroke').attr('src',sysDefPrefix.value+ch+'.png');
    $('#showUsInfoPower').val(pl); $('#showUsInfoBond').val(bl);
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
    var addr=(msg!==undefined)?msg.match(/(@\w*)/g):'';
    var userID,cyp='.-',msgbox='',msgbr=[];
    var ratTab=arrjob(sysDefPowersData.value,';',':');
    if (ratTab[sysDefSessionID.value]>=0) {
        if (addr!==null) {
            for (it in addr) {
                userID=addr[it].replace('@','');
                msgbox=openJournal(userID,sysDefUsersList,sysDefMailingJSONs); msgarr=jsonstr(msgbox);
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
            msgbox=sysDefMsgData.value; msgarr=jsonstr(msgbox);
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
function buy_item(bye,art,sel) {
    if (sel!=bye) {
        var tabS=jsonstr(openJournal(sel,sysDefStoreList,sysDefStoreJSONs)), tabB=jsonstr(openJournal(bye,sysDefStoreList,sysDefStoreJSONs));
        var prix,pass,obj=arrjob(sysDefPowersData.value,';',':');
        if ((obj[bye]>=0)&&(obj[sel]>=0)) {
            if ((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')) {
                if ((isInt(tabS[art]['price']))&&(!isInt(art))) {
                    // Buy any product for certain price
                    prix=parseInt(tabS[art]['price']);
                    if (obj[bye]>=prix) {
                        fixPrice(bye,sel,art,prix);
                        amounts(tabS,tabB,art);
                        set('./.store/'+sel+'_store.json',encodeURIComponent(JSON.stringify(tabS)),true); set('./.store/'+bye+'_store.json',encodeURIComponent(JSON.stringify(tabB)),true); if ((tabS[art]['password']!==undefined)&&(tabS[art]['type']=='account')) {
                            pass=tabS[art]['password'];
                            copy(sel+'_session.json.bak',bye+'_session.json.bak',true,1);
                            copy(sel+'_session.json',bye+'_session.json',true,1);
                            change(bye,bye,pass,true);
                            omniAuthRequest('signin',bye,pass);
                        } else if ((tabS[art]['password']!==undefined)&&(tabS[art]['type']=='password')) {
                            pass=tabS[art]['password'];
                            change(sel,sel,pass,true);
                            omniAuthRequest('signin',sel,pass);
                        }
                    }
                } else if ((!isInt(tabS[art]['price']))&&(!isInt(art))&&(tabB[tabS[art]['price']]!==undefined)&&(typeof(tabB[tabS[art]['price']])=='object')) {
                    // Exchange goods with other users
                    prix=tabS[art]['price'];
                    fixPrice(bye,sel,art,prix);
                    amounts(tabB,tabS,prix);
                    amounts(tabS,tabB,art);
                    set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                    set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                } else if ((!isInt(tabS[art]['price']))&&(tabS[art]['price']=='')) {
                    // Get certain amount of money or good from user as a gift
                    prix=tabS[art]['price'];
                    fixPrice(bye,sel,art,prix);
                    amounts(tabS,tabB,art);
                    set('./.store/'+sel+'_store.json', encodeURIComponent(JSON.stringify(tabS)), true);
                    set('./.store/'+bye+'_store.json', encodeURIComponent(JSON.stringify(tabB)), true);
                }
            }
        }
    }
}
function sell_item(usr,art,dat='') {
    var tabS=jsonstr(openJournal(usr,sysDefStoreList,sysDefStoreJSONs));
    var obj=arrjob(sysDefPowersData.value,';',':'),dap=arrjob(dat,'; ',': '); if (obj[usr]>=0) {
        var qu=((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')&&(tabS[art]['amount']!==undefined)&&isInt(tabS[art]['amount'])&&(tabS[art]['amount']>=0))?parseInt(tabS[art]['amount'])+1:1; tabS[art]={"amount":qu};
        for (iu in dap) {
            tabS[art][iu]=(iu=='password')?CryptoJS.SHA256(dap[iu]).toString():dap[iu];
        } set('./.store/'+usr+'_store.json',encodeURIComponent(JSON.stringify(tabS)),true);
    }
}
function fixPrice(sen,rec,deb,cre) {
    var tran1=openJournal(sen,sysDefBooksList,sysDefBookKeepJSONs);
    var tran2=openJournal(rec,sysDefBooksList,sysDefBookKeepJSONs);
    var trans1=jsonstr(tran1),trans2=jsonstr(tran2);
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
function charge(usr,itp='') {
    var obj=arrjob(sysDefPowersData.value,';',':');
    var stu=jsonMarket(usr),f=m=s=n=0;
    var suf=(isInt(obj[usr]))?parseInt(obj[usr]):0;
    if (suf>=0) {
        if ((stu[itp]!==undefined)&&(typeof(stu[itp])=='object')&&(stu[itp]['type']!='account')&&(stu[itp]['type']!='password')&&(stu[itp]['type']!='weapon')) {
            m=((stu[itp]['amount']!==undefined)&&isInt(stu[itp]['amount']))?parseInt(stu[itp]['amount']):1;
            f=(isInt(itp))?parseInt(itp):(((stu[itp]['force']!==undefined)&&isInt(stu[itp]['force']))?parseInt(stu[itp]['force']):1);
            n=((stu[itp]['finite']!==undefined)&&isInt(stu[itp]['finite']))?parseInt(stu[itp]['finite']):0;
            s=((stu[itp]['series']!==undefined)&&isInt(stu[itp]['series']))?parseInt(stu[itp]['series']):0;
        } else { m=f=1,n=s=0; }
        if (n!=0) {
            if (m>0) { if (s!=0) {
                    do { suf+=f; s-=1; } while (s>0);
                } else { suf+=f; } m-=1; stu[itp]['amount']=m;
            } else { delete stu[itp]; }
        } else {
            if (s!=0) {
                do { suf+=f; s-=1; } while (s>0);
            } else { suf+=f; }
        } obj[usr]=suf;
        set('./.store/'+usr+'_store.json',encodeURIComponent(JSON.stringify(stu)),true);
        set('dominion.json',JSON.stringify(obj),true);
        sysDefPowersData.value=arrpack(obj,';',':');
    }
}
function dominate(usr,id,wep='') {
    var obj=arrjob(sysDefPowersData.value,';',':');
    var stu=jsonMarket(usr),f=m=s=n=0;
    var suf=(isInt(obj[usr]))?parseInt(obj[usr]):0;
    var obf=(isInt(obj[id]))?parseInt(obj[id]):0;
    if ((usr!=id)&&(suf>=0)) {
        if ((stu[wep]!==undefined)&&(typeof(stu[wep])=='object')&&(stu[wep]['type']=='weapon')) {
            m=((stu[wep]['amount']!==undefined)&&isInt(stu[wep]['amount']))?parseInt(stu[wep]['amount']):1;
            f=((stu[wep]['force']!==undefined)&&isInt(stu[wep]['force']))?parseInt(stu[wep]['force']):1;
            n=((stu[wep]['finite']!==undefined)&&isInt(stu[wep]['finite']))?parseInt(stu[wep]['finite']):0;
            s=((stu[wep]['series']!==undefined)&&isInt(stu[wep]['series']))?parseInt(stu[wep]['series']):0;
        } else { m=f=1,n=s=0; }
        if (obf<=-666) { delete_user(id); } else {
            if (n!=0) {
                if (m>0) {
                    if (s!=0) {
                        do { suf+=f; obf-=f; s-=1; } while (s>0);
                    } else { suf+=f; obf-=f; } m-=1;
                    stu[wep]['amount']=m;
                } else { delete stu[wep]; }
            } else {
                if (s!=0) {
                    do { suf+=f; obf-=f; s-=1; } while (s>0);
                } else { suf+=f; obf-=f; }
            } obj[usr]=suf; obj[id]=obf;
            set('./.store/'+usr+'_store.json',encodeURIComponent(JSON.stringify(stu)),true);
            set('dominion.json',JSON.stringify(obj),true);
            sysDefPowersData.value=arrpack(obj,';',':');
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
// MULTIMEDIA AND MISCELLANEOUS FUNCTIONS
function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('pitch_lock',sysDefPitchLock.value);
    setdata('video_volume',sysDefVideoVolume.value);
    setdata('video_speed',sysDefVideoSpeed.value);
}
function omniListen(input,scratch=false,pos=false) {
    playAudio(audioPlayer,input); if (isInt(pos)) {
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
    var lxn=lockarr('music');
    var nxp=sysDefUpNext.value;
    var nxt=(nxp.includes('//'))?nxp.split('//'):((nxp!='')?[nxp]:[]);
    var mel=dtw(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
    var ind=arraySearch(((mel.startsWith(requestPath.value+'/'))?mel.replace(requestPath.value+'/',''):mel),lxn);
    if (nxp!='') {
        if (nxt[0]!='') {
            omniListen(dtw(nxt[0],sysDefSessionID.value,sysDefNumeric.value),true);
        } setdata('up_next',arrangeMenu(sysDefUpNext.value,nxt[0],'//'));
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
function keyd() {
    if (requestMode.value=='accessibility') {
        pressedKeyCode.innerText=event.keyCode;
        pressedCode.innerText=event.code;
        pressedKey.innerText=event.key;
    }
}
</script>
