<script>
function isDarkMode() {
    return ((window.matchMedia)&&(window.matchMedia('(prefers-color-scheme: dark)').matches));
}
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
    set(sysDefSessionID.value+'_files/lock.json',JSON.stringify(obj),'rw'); <?php foreach ($locks as $key=>$value) {
        echo "lock".snakeToCamel($key).".value = obj['".$key."'];";
    } ?>
}
function setdata(ent,val) {
    var obj=userdata();obj[ent]=val;
    set(sysDefSessionID.value+'_files/session.json',JSON.stringify(obj),'rw'); <?php foreach ($settings['defaults'] as $key=>$value) {
        echo "sysDef".snakeToCamel($key).".value=obj['".$key."'];";
    } ?> if (ent=='audio_volume') { audioPlayer.volume=val; }
    if (ent=='audio_speed') { audioPlayer.playbackRate=val; }
    if (ent=='preserves_pitch') {
        audioPlayer.preservesPitch=(val!=0)?true:false;
    } if (requestMode.value=='sticky_notes') {
        if (ent=='numeric') { myNotesRad.value=val; }
    } if (requestMode.value=='media_player') {
        if (ent=='video_volume') { video.volume=val; }
        if (ent=='video_speed') { video.playbackRate=val; }
        if (ent=='preserves_pitch') {
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
    return ((sysDefIsSession.value!=false)&&(sysDefSessionID.value==sysDefSuperUserName.value));
}
function authstate() {
    return (sysDefIsSession.value!=false);
}
function cancelled(id) {
    var pwr=jsonarr(sysDefPowersData.value);
    var res=false; if ((pwr[id]!==undefined)&&(isNum(pwr[id]))) {
        res=(pwr[id]<0);
    } return res;
}
function enoughfor(id,prix) {
    var pwr=jsonarr(sysDefPowersData.value);
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
function finterm(term) {
    var arr=jsonarr(sysDefFinTerms.value),rep=res='';
    if ((term.startsWith('<'))&&(term.endsWith('>'))) {
        rep=term.replace('<','').replace('>','');
        res=(isLine(arr[term]))?arr[term]:arr['<start>'];
    } else { res=arr[term]; } return res;
}
function lockarr(id) {
    var objData=((jsonarr(sysDefLockData.value)!==undefined)&&(jsonarr(sysDefLockData.value)!==null))?jsonarr(sysDefLockData.value):{};
    var dataSel=Object.values(objData[id]||{});
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
        set('./'+sysDefSessionID.value+'_files/'+name+'.json',encodeURIComponent(JSON.stringify(resarr)),'rw');
    }
}
function openJournal(id,obj) {
    var resarr=(typeof(obj)=='object')?jsonarr(obj.value):jsonarr(obj);
    return (isObject(resarr[id]))?arrjson(resarr[id]):"{\"\":\"\"}";
}
function is_store_open(id) {
    return timezoner(id,'active_hours').split(',').includes(timezoner(id));
}
function timezoner(id,ent='hour') {
    var arr=jsonarr(sysDefPublicUserData.value);
    return ((notEmpty(arr[ent]))&&(notNull(arr[ent][id])))?arr[ent][id]:'';
}
function isInBackup(id) {
    var fsess=jsonarr(loadFile(id+'_files/session.json.sav'));
    var flock=jsonarr(loadFile(id+'_files/lock.json.sav'));
    return (isObject(fsess)&&isObject(flock));
}
function userBackup(id) {
    copy(id+'_files/session.json',id+'_files/session.json.sav','rw');
    copy(id+'_files/lock.json',id+'_files/lock.json.sav','rw');
    var fsess=jsonarr(loadFile(id+'_files/session.json.sav'));
    var flock=jsonarr(loadFile(id+'_files/lock.json.sav'));
}
function userRestore(id) {
    var fsess=flock={}; if (isInBackup(id)) {
        copy(id+'_files/session.json.sav',id+'_files/session.json','rw');
        copy(id+'_files/lock.json.sav',id+'_files/lock.json','rw');
        fsess=jsonarr(loadFile(id+'_files/session.json.sav'));
        for (idx in fsess) { setdata(idx,fsess[idx]); }
        flock=jsonarr(loadFile(id+'_files/lock.json.sav'));
        for (idx in flock) { setlock(idx,flock[idx]); }
        omniListen(demorse(fsess['melody'],id,fsess['numeric']),false,parseInt(fsess['current']));
    }
}
function remove_entry(id,obj,name) {
    var rawData=(isObject(obj))?obj.value:obj;
    var resarr=jsonarr(rawData);
    if (notNull(resarr[id])) {
        delete resarr[id]; set(name+'.json',JSON.stringify(resarr),'rw');
    } obj.value=arrjson(resarr);
}
function reset_entry(id,obj,name,mode='') {
    var rawData=(isObject(obj))?obj.value:obj;
    var resarr=jsonarr(rawData);
    if (!notNull(resarr[id])) {
        if (mode=='i') { resarr[id]=id;
        } else if (mode=='e') { resarr[id]='';
        } else if (mode=='n') { resarr[id]=0;
        } else if (mode=='a') { resarr[id]='auto';
        } else if (mode=='m') { resarr[id]='manual'; }
    } set(name+'.json',JSON.stringify(resarr),'rw');
    obj.value=arrjson(resarr);
}
function delete_user(id) {
    bind(sysDefSessionID.value,sysDefSessionID.value);
    bind(id,id); remove_entry(id,sysDefBindData,'binding');
    remove_entry(id,sysDefPowersData,'dominion');
    remove_entry(id,sysDefAutoData,'automator');
    remove_entry(id,sysDefToolData,'toolbox');
    del(id+'_files/lock.json.sav','rw');
    del(id+'_files/session.json.sav','rw');
    del(id+'_files/msgbox.json.bak','rw');
    del(id+'_files/book.json.bak','rw');
    del(id+'_files/store.json.bak','rw');
    del(id+'_files/msgbox.json','rw');
    del(id+'_files/book.json','rw');
    del(id+'_files/store.json','rw');
    del(id+'_files/lock.json.bak','rw');
    del(id+'_files/metadata.json.bak','rw');
    del(id+'_files/session.json.bak','rw');
    del(id+'_files/lock.json','rw');
    del(id+'_files/metadata.json','rw');
    del(id+'_files/session.json','rw');
    del(id+'_files/lock.json.bak','rw');
    del(id+'_files/metadata.json.bak','rw');
    del(id+'_files/session.json.bak','rw');
    del(id+'_files','rw');
}
function transfer_entry(id,to,obj,name,onlyAssignID=false) {
    var objData=jsonarr(obj.value);
    objData[to]=(onlyAssignID)?to:objData[id];
    if (id!=to) { delete objData[id]; }
    set(name+'.json',JSON.stringify(objData),'rw');
    obj.value=arrjson(objData);
}
function rename_user(id,to,pass,perm) {
    bind(id,id); bind(to,to); del(id+'_files/password','rw');
    set(to+'_files/password',CryptoJS.SHA256(pass).toString(),'rw');
    if (id!=to) {
        copy(id+'_files/lock.json',to+'_files/lock.json',perm);
        copy(id+'_files/metadata.json',to+'_files/metadata.json',perm);
        copy(id+'_files/session.json',to+'_files/session.json',perm);
        copy(id+'_files/msgbox.json',to+'_files/msgbox.json',perm);
        copy(id+'_files/book.json',to+'_files/book.json',perm);
        copy(id+'_files/store.json',to+'_files/store.json',perm);
        transfer_entry(id,to,sysDefBindData,'binding',true);
        transfer_entry(id,to,sysDefPowersData,'dominion');
        transfer_entry(id,to,sysDefAutoData,'automator');
        transfer_entry(id,to,sysDefToolData,'toolbox');
    }
}
function init_user(id,pass=null) {
    reset_entry(id,sysDefPowersData,'dominion','n');
    reset_entry(id,sysDefBindData,'binding','i');
    reset_entry(id,sysDefAutoData,'automator','m');
    reset_entry(id,sysDefToolData,'toolbox','e');
    var msgData=jsonarr(openJournal(id,sysDefMsgboxJSONs));
    if (!notNull(msgData)) {
        mkdir('./'+id+'_files','rw');
        set('./'+id+'_files/msgbox.json',JSON.stringify({}),'rw');
    } var bookData=jsonarr(openJournal(id,sysDefBookJSONs));
    if (!notNull(bookData)) {
        mkdir('./'+id+'_files','rw');
        set('./'+id+'_files/book.json',JSON.stringify({}),'rw');
    } var storeData=jsonarr(openJournal(id,sysDefStoreJSONs));
    if (!notNull(storeData)) {
        mkdir('./'+id+'_files','rw');
        set('./'+id+'_files/store.json',JSON.stringify({}),'rw');
    } if (isLine(pass)) { set(id+'_files/password',pass,'rw'); }
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
        fu0="clearJournal(&#39;"+enmorse(el,usr)+"&#39;,&#39;"+sysDefMyMsgboxData.value+"&#39;,&#39;msgbox&#39;);";
        fu1="clip(&#39;"+arr[el]+"&#39;);";
        ard="<p><input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='"+fu0+"'> "+el+" <input type='image' class='power' onmouseover='soundButton();' src='"+epr+"copy.png"+"' onclick='"+fu1+"'><br>"+arr[el]+"</p>"+ard;
    } return ard;
}
function activeHoursHTML(id) {
    var str=timezoner(id,'active_hours');
    var arr=(str.includes(','))?str.split(','):[str];
    var arl=res=''; if (str!='') {
        arl="<p align='center'>"; for (el in arr) {
            arl+="<input type='button' onmouseover='soundButton();' style='"+gradButton(id)+"' value='"+arr[el]+"'>";
        } res=arl+"</p>";
    } else { res=''; } return res;
}
function gradButton(id,elem='fore') {
    var res=''; if (elem=='fore') {
        if (timezoner(id,'gloss')!=0) {
            res="border-radius:"+timezoner(id,'border_radius')+";background:linear-gradient("+timezoner(id,'gradient_fore')+"deg, "+timezoner(id,'fore_color')+" 0%, "+timezoner(id,'arc_fore_color')+" 100%);font_color:"+timezoner(id,'fore_text_color')+";box-shadow:"+timezoner(id,'box_shadow')+";";
        } else {
            res="border-radius:"+timezoner(id,'border_radius')+";background-color:"+timezoner(id,'fore_color')+";font_color:"+timezoner(id,'fore_text_color')+";box-shadow:"+timezoner(id,'box_shadow')+";";
        }
    } else if (elem=='input') {
        if (timezoner(id,'gloss')!=0) {
            res="border-radius:"+timezoner(id,'text_border_radius')+";background:linear-gradient("+timezoner(id,'gradient_input')+"deg, "+timezoner(id,'input_color')+" 0%, "+timezoner(id,'arc_input_color')+" 100%);font_color:"+timezoner(id,'input_text_color')+";box-shadow:"+timezoner(id,'text_box_shadow')+";";
        } else {
            res="border-radius:"+timezoner(id,'text_border_radius')+";background-color:"+timezoner(id,'input_color')+";font_color:"+timezoner(id,'input_text_color')+";box-shadow:"+timezoner(id,'text_box_shadow')+";";
        }
    } else if (elem=='button') {
        if (timezoner(id,'gloss')!=0) {
            res="border-radius:"+timezoner(id,'border_radius')+";background:linear-gradient("+timezoner(id,'gradient_button')+"deg, "+timezoner(id,'fore_color')+" 0%, "+timezoner(id,'arc_fore_color')+" 100%);font_color:"+timezoner(id,'fore_text_color')+";box-shadow:"+timezoner(id,'box_shadow')+";";
        } else {
            res="border-radius:"+timezoner(id,'border_radius')+";background-color:"+timezoner(id,'fore_color')+";font_color:"+timezoner(id,'fore_text_color')+";box-shadow:"+timezoner(id,'box_shadow')+";";
        }
    } return res;
}
function statsIndicatorsHTML() {
    var arr={
        "bind":"chain","auto":"steer","tool":"parfum","powers":"money","hdi":"world","date":"calendar","time":"time","work":"settings"
    }; var arl=""; for (item in arr) {
        arl+="<input type='image' class='power' style='"+gradButton(sysDefSessionID.value,'button')+"' onmouseover='soundButton();' src='"+sysDefPrefix.value+arr[item]+".png"+"' onclick='setdata(&#34;stats&#34;,&#34;"+item+"&#34;);'>";
    } return arl;
}
function lockIndicatorsHTML() {
    var obj=((jsonarr(sysDefLockData.value)!==undefined)&&(jsonarr(sysDefLockData.value)!==null))?jsonarr(sysDefLockData.value):{},sel=Object.keys(obj||{});
    var icons=jsonarr(sysDefLockIcons.value),arl=""; for (item in sel) {
        arl+="<input type='image' class='power' style='"+gradButton(sysDefSessionID.value,'button')+"' onmouseover='soundButton();' src='"+sysDefPrefix.value+icons[sel[item]]+".png"+"' onclick='setdata(&#34;album&#34;,&#34;"+sel[item]+"&#34;);'>";
    } return arl;
}
function indexAvatars(id) {
    var obj=lockarr(id),arr=[]; for (idx in obj) {
        if ((id=='avatar')||(id=='pictogram')||(id=='reticle')) {
            arr.push(obj[idx].split('.')[1]);
        }
    } return arr;
}
function storeUsers() {
    var users=(sysDefUsersList.value).split(',');
    var usr=sysDefSessionID.value,arl=""; for (i=0; i<users.length; i++) {
        arl+="<input type='button' onmouseover='soundButton();' style='"+gradButton(users[i])+"' onclick='bind(&#34;"+usr+"&#34;,&#34;"+users[i]+"&#34;);' value='"+users[i]+"'>";
    } return arl;
}
function storeInventoryHTML(id) {
    var arr=jsonarr(openJournal(id,sysDefStoreJSONs));
    var ard=arl='',eld={},fu0=fu1='';
    var usr=sysDefSessionID.value,epr=sysDefPrefix.value;
    for (el in arr) {
        if ((arr[el]!==undefined)&&(typeof(arr[el])=='object')) {
            eld=arr[el],arl='<tr>';
            fu0="buy_item(&#34;"+usr+"&#34;,&#34;"+el+"&#34;,&#34;"+id+"&#34;);",fu1=(isNum(el))?"charge(&#34;"+id+"&#34;,&#34;"+parseFloat(el)+"&#34;);":(((eld['type']=='book')||(eld['type']=='text'))?"omniPath(&#34;./"+usr+"_files/store.json&#34;,&#34;"+el+"/contents&#34;,&#34;false&#34;);":((eld['type']=='weapon')?"equip(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);"));
            arl+="<td><input type='button' onmouseover='soundButton();' style='width:80%;"+gradButton(id)+"' onclick='"+((id!=usr)?fu0:fu1)+"' value='"+el+"'>";
            arl+="<input type='image' class='power' onmouseover='soundButton();' style='"+gradButton(id,'button')+"' src='"+epr+"info.png"+"' onclick='omniPath(&#34;./"+usr+"_files/store.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>";
            arl+="</td><td>"+eld['amount']+"</td><td>"+format_currency(eld['price'])+"</td>"; ard=arl+"</tr>"+ard;
        }
    } return ard;
}
function format_currency(val,mode=0) {
    var cur=sysDefCurrency.value,res=curSign=userSign=delim1=delimit1=delim2=delimit2='';
    var expr=sign=start=end=''; if (cur.length==8) {
        curSign=(cur.charAt(1)!='x')?(cur.charAt(1)):'';
        userSign=(cur.charAt(6)!='y')?(cur.charAt(6)):'';
        delim1=(cur.charAt(3)!=':')?(cur.charAt(3)):'';
        delimit1=(delim1=='_')?' ':delim1;
        delim2=(cur.charAt(4)!=':')?(cur.charAt(4)):'.';
        delimit2=(delim2=='_')?' ':delim2;
        expr=(isNum(mode))?format_number(val,mode,delimit1,delimit2):val; sign=(isNum(mode))?curSign:userSign;
        start=(isNum(mode))?0:5,end=(isNum(mode))?2:7;
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
function bookkeepingHTML(str) {
    var arr=jsonarr(str),ard=arl='',arf={},eld=[];
    if (notEmpty(arr)) {
        for (el in arr) {
            if (isLine(arr[el])&&arr[el].includes(' | ')) {
                eld=arr[el].split(' | ');
                arl=(eld[5]=='ERR')?'<tr style="text-decoration:line-through;">':'<tr>';
                arl+='<td>'+format_currency(eld[1],'')+'</td>';
                arl+=(isNum(eld[2]))?'<td>'+format_currency(eld[2])+'</td>':'<td>'+eld[2]+'</td>';
                arl+=(isNum(eld[3]))?'<td>'+format_currency(eld[3])+'</td>':'<td>'+eld[3]+'</td>';
                arl+='<td>'+format_currency(eld[4])+'</td>';
                ard=arl+'</tr>'+ard;
            }
        }
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
function seekBanner(req) {
    if (sysDefBanner.value!='') { setdata('banner',''); } else {
        var all=jsonarr(sysDefContentData.value);
        var nsfw=Object.keys(jsonarr(sysDefNSFWContentData.value));
        var safe=Object.keys(jsonarr(sysDefSafeContentData.value));
        var rqs=((req.includes(':'))&&(req.split(':').length==2))?req.split(':')[0]:req; var arr=[]; for (idx in all) {
            if (all[idx].toLowerCase().includes(rqs.toLowerCase())) {
                arr.push(idx);
            }
        } var rqt=((req.includes(':'))&&(req.split(':').length==2))?req.split(':')[1]:rand(0,arr.length); if ((req=='true')||(req==1)) { setdata('banner',nsfw[rand(0,nsfw.length)]);
        } else if ((req=='false')||(req==0)) {
            setdata('banner',safe[rand(0,safe.length)]);
        } else if (notEmpty(arr)) { setdata('banner',arr[rqt]);
        } else if (rqs=='') {
            setdata('banner',safe[rand(0,safe.length)]);
        } else { setdata('banner',nsfw[rand(0,nsfw.length)]); }
    }
}
function seekCode(req) {
    var macroses=(sysDefCodexBox.value).split('//');
    var ark,arv; if (req.includes(':')) {
        ark=req.split(':')[0],arv=req.split(':')[1];
    } else { ark=req,arv=''; }
    for (i=0; i<macroses.length; i++) {
        if (macroses[i].toLowerCase().includes(ark.toLowerCase())) {
            executeFile(macroses[i],arv); break;
        }
    }
}
function urlGetData(url,arg='') {
    var urlParts=url.split('?');
    var urlArgs=strarr(urlParts[1],'&','=');
    return (notNull(urlArgs[arg]))?urlArgs[arg]:'';
}
function seekMusic(req) {
    var mls=lockarr('music'),pls=arg=[],arj=ari=arc=itm='',sec=0;
    if (req.includes('://')) { omniListen(req,true,urlGetData(req,'sec'));
    } else if ((req.includes('/'))&&(req.split('/').length==2)) {
        arg=req.split('/'),arj=(isInt(arg[0]))?parseInt(arg[0]):arg[0];
        ari=(isInt(arg[0]))?'holylance98':'infofintech';
        if (arg[1].includes('?')) {
            itm=arg[1].split('?')[0],sec=arg[1].split('?')[1];
            arc='https://github.com/'+ari+'/'+arj+'/blob/main/'+itm+'?raw=true';
        } else {
            itm=arg[1],sec=0;
            arc='https://github.com/'+ari+'/'+arj+'/blob/main/'+itm+'?raw=true';
        } omniListen(arc,true,sec);
    } else {
        if ((req.includes('?'))&&(req.includes(':'))) {
            fln=req.split('?')[0],atr=req.split('?')[1];
            fli=atr.split(':')[0],fle=atr.split(':')[1];
            for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } if ((!isInt(fli))&&(fli=='*')) { fli=rand(0,pls.length-1); }
        } else if (req.includes('?')) {
            fln=req.split('?')[0],fli=req.split('?')[1],fle=0;
            for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } if ((!isInt(fli))&&(fli=='*')) { fli=rand(0,pls.length-1); }
        } else if (req.includes(':')) {
            fln=req.split(':')[0],fle=req.split(':')[1];
            for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } fli=rand(0,pls.length-1);
        } else {
            fln=req,fle=0; for (i=0; i<mls.length; i++) {
                if (mls[i].toLowerCase().includes(fln.toLowerCase())) {
                    pls.push(mls[i]);
                }
            } fli=rand(0,pls.length-1);
        } if (notEmpty(pls)) {
            omniListen(pls[fli],true,parseInt(fle));
        } else {
            omniListen(mls[rand(0,mls.length-1)],true,parseInt(fle));
        }
    }
}
function seekModel(arb) {
    arh=[]; if (arb.includes(':')) {
        ark=jsonarr(sysDefModelData.value);
        arg=arb.split(':'); for (idx in ark) {
            if (idx.toLowerCase().includes(arg[0].toLowerCase())) { arh.push(idx); }
        } omniGroup(arh[arg[1]]);
    } else if ((arb=='true')||(arb==1)) {
        arg=Object.keys(jsonarr(sysDefNSFWModelData.value));
        omniGroup(arg[rand(0,arg.length)]);
    } else if ((arb=='false')||(arb==0)) {
        arg=Object.keys(jsonarr(sysDefSafeModelData.value));
        omniGroup(arg[rand(0,arg.length)]);
    } else {
        ark=jsonarr(sysDefModelData.value);
        for (idx in ark) {
            if (idx.toLowerCase().includes(arb.toLowerCase())) {
                arh.push(idx);
            }
        } omniGroup(arh[rand(0,arh.length)]);
    }
}
function seekImage(arb) {
    ark=jsonarr(sysDefContentData.value);
    if ((arb.includes('.'))&&(arb.split('.').length==3)) {
        window.location.href=arb+'.png';
    } else if ((arb.includes(':'))&&(arb.split(':').length==2)) {
        arh=[]; arg=arb.split(':'); for (idx in ark) {
            if (ark[idx].toLowerCase().includes(arg[0].toLowerCase())) { arh.push(idx); }
        } window.location.href=arh[arg[1]];
    } else if ((arb=='true')||(arb==1)) {
        arg=Object.keys(jsonarr(sysDefNSFWContentData.value));
        window.location.href=arg[rand(0,arg.length)];
    } else if ((arb=='false')||(arb==0)) {
        arg=Object.keys(jsonarr(sysDefSafeContentData.value));
        window.location.href=arg[rand(0,arg.length)];
    } else {
        arh=[]; for (idx in ark) {
            if (ark[idx].toLowerCase().includes(arb.toLowerCase())) { arh.push(idx); }
        } window.location.href=arh[rand(0,arh.length)];
    }
}
function toIso8601(num) {
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
function bind(usr,id) {
    var obj=jsonarr(sysDefBindData.value);
    obj[usr]=id; set('binding.json',JSON.stringify(obj),'rw');
    sysDefBindData.value=arrjson(obj);
}
function equip(usr,tool='') {
    var obj=jsonarr(sysDefToolData.value);
    obj[usr]=tool; set('toolbox.json',JSON.stringify(obj),'rw');
    sysDefToolData.value=arrjson(obj);
}
function automate(usr) {
    var obj=jsonarr(sysDefAutoData.value);
    obj[usr]=(sysDefMyAutoState.value=='auto')?'manual':'auto';
    set('automator.json',JSON.stringify(obj),'rw');
    sysDefAutoData.value=arrjson(obj);
}
function localizedTitle(id,ent='title') {
    var mono=loadFile(id+'_files/session.json',ent);
    var lang=loadFile(id+'_files/session.json','units');
    var trans=loadFile(id+'_files/session.json',ent+'s');
    var tran=strarr(trans,';; ',':: ');
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
                            msgarr[enmorse(senT+' (@'+sen+') · '+toIso8601(Date.now()+j*1000)+' UTC',rec)]=enmorse(msglt,rec);
                        }
                    } else {
                        if (argv!==null) {
                            msglr.push('@'+usr);
                            for (idx in argv) {
                                req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+calc(req).toString()+']');
                            } msglt=msglr.join(' ');
                        } else { msglt=msg; }
                        msgarr[enmorse(senT+' (@'+sen+') · '+toIso8601(Date.now())+' UTC',rec)]=enmorse(msglt,rec);
                    } set('./'+rec+'_files/msgbox.json',(JSON.stringify(msgarr)),'rw');
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
                    msgarr[enmorse(usrT+' (@'+usr+') · '+toIso8601(Date.now()+j*1000)+' UTC',usr)]=enmorse(msglt,usr);
                }
            } else {
                if (argv!==null) {
                    msglr.push('@'+usr);
                    for (idx in argv) {
                        req=argv[idx].toString().replace('{','').replace('}',''); msglr.push('['+calc(req).toString()+']');
                    } msglt=msglr.join(' ');
                } else { msglt=msg; }
                msgarr[enmorse(usrT+' (@'+usr+') · '+toIso8601(Date.now())+' UTC',usr)]=enmorse(msglt,usr);
            } set('./'+usr+'_files/msgbox.json',(JSON.stringify(msgarr)),'rw');
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
        var prix,pass;
        if ((!cancelled(buyer))&&(!cancelled(seller))) {
            if ((tabS[art]!==undefined)&&(typeof(tabS[art])=='object')) {
                if ((isNum(tabS[art]['price']))&&(!isNum(art))) {
                    prix=parseFloat(tabS[art]['price']);
                    if (enoughfor(buyer,prix)) {
                        fixPrice(buyer,seller,art,prix);
                        amounts(tabS,tabB,art);
                        set('./'+seller+'_files/store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
                        set('./'+buyer+'_files/store.json',encodeURIComponent(JSON.stringify(tabB)),'rw');
                        if ((notNull(tabS[art]['password']))&&(tabS[art]['type']=='account')) {
                            rename_user(seller,buyer,tabS[art]['password'],seller); omniAuthRequest('signin',buyer,tabS[art]['password']);
                        } else if ((notNull(tabS[art]['password']))&&(tabS[art]['type']=='password')) {
                            rename_user(seller,seller,tabS[art]['password'],seller);
                            omniAuthRequest('signin',seller,tabS[art]['password']);
                        }
                    }
                } else if ((!isNum(tabS[art]['price']))&&(!isNum(art))&&(notNull(tabB[tabS[art]['price']]))&&(isObject(tabB[tabS[art]['price']]))) {
                    prix=tabS[art]['price']; fixPrice(buyer,seller,art,prix);
                    amounts(tabB,tabS,prix); amounts(tabS,tabB,art);
                    set('./'+seller+'_files/store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
                    set('./'+buyer+'_files/store.json',encodeURIComponent(JSON.stringify(tabB)),'rw');
                } else if ((!isNum(tabS[art]['price']))&&(tabS[art]['price']=='')) {
                    prix=tabS[art]['price']; fixPrice(buyer,seller,art,prix); amounts(tabS,tabB,art);
                    set('./'+seller+'_files/store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
                    set('./'+buyer+'_files/store.json',encodeURIComponent(JSON.stringify(tabB)),'rw');
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
        } set('./'+usr+'_files/store.json',encodeURIComponent(JSON.stringify(tabS)),'rw');
    }
}
function fixPrice(sen,rec,deb,cre) {
    var tran1=openJournal(sen,sysDefBookJSONs);
    var tran2=openJournal(rec,sysDefBookJSONs);
    var trans1=jsonarr(tran1),trans2=jsonarr(tran2);
    var stat=jsonarr(sysDefPowersData.value);
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
    trans1[toIso8601(Date.now())+' UTC']=(statDi<parseFloat(bal1))?sen+' | '+rec+' | '+statT+' | '+statDn+' | '+statDi+' | '+statDt : sen+' | '+rec+' | '+statDn+' | '+statT+' | '+statDi+' | '+statDt;
    trans2[toIso8601(Date.now())+' UTC']=(statCi<parseFloat(bal2))?rec+' | '+sen+' | '+statT+' | '+statCn+' | '+statCi+' | '+statCt : rec+' | '+sen+' | '+statCn+' | '+statT+' | '+statCi+' | '+statCt;
    if (!isNum(deb)&&!isNum(cre)) {
        trans1[toIso8601(Date.now())+' UTC']=sen+' | '+rec+' | '+statT+' | '+statK+' | '+statDi+' | '+statDt;
        trans2[toIso8601(Date.now())+' UTC']=rec+' | '+sen+' | '+statK+' | '+statT+' | '+statCi+' | '+statCt;
    } set('./'+sen+'_files/book.json',encodeURIComponent(JSON.stringify(trans1)),'rw');
    set('./'+rec+'_files/book.json',encodeURIComponent(JSON.stringify(trans2)),'rw');
    set('dominion.json',JSON.stringify(stat),'rw');
    sysDefPowersData.value=arrjson(stat);
}
function charge(usr,art='') {
    var powersData=jsonarr(sysDefPowersData.value);
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
        set('./'+usr+'_files/store.json',encodeURIComponent(JSON.stringify(userMarket)),'rw'); set('dominion.json',JSON.stringify(powersData),'rw');
        sysDefPowersData.value=arrjson(powersData);
    }
}
function dominate(usr,id,art='') {
    var powersData=jsonarr(sysDefPowersData.value);
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
            set('./'+usr+'_files/store.json',encodeURIComponent(JSON.stringify(userMarket)),'rw');
            set('dominion.json',JSON.stringify(powersData),'rw');
            sysDefPowersData.value=arrjson(powersData);
        }
    }
}
function replayVideo(obj) {
    obj.pause(); obj.load(); obj.play();
    setdata('preserves_pitch',sysDefPreservesPitch.value);
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
    setdata('preserves_pitch',sysDefPreservesPitch.value);
    setdata('audio_volume',sysDefAudioVolume.value);
    setdata('audio_speed',sysDefAudioSpeed.value);
}
function songIndex(mode='') {
    var music=lockarr('music'),playlist=sysDefPlaylist.value;
    var next=(playlist.includes(' | '))?playlist.split(' | '):((playlist!='')?[playlist]:[]),melody=demorse(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
    var index=arraySearch(((melody.startsWith(requestPath.value+'/'))?melody.replace(requestPath.value+'/',''):melody),music); if (playlist!='') {
        if (next[0]!='') {
            omniListen(demorse(next[0],sysDefSessionID.value,sysDefNumeric.value),true);
        } setdata('playlist',arrangeMenu(sysDefPlaylist.value,next[0],' | '));
    } else {
        if (mode=='next') {
            omniListen((((index>=(music.length-1))||(index===false))?music[0]:music[parseInt(index)+1]),true);
        } else if (mode=='prev') {
            omniListen((((index<=0)||(index===false))?music[music.length-1]:music[parseInt(index)-1]),true);
        } else if (mode=='random') {
            omniListen(music[rand(0,music.length)],true);
        } else { omniListen(melody,true); }
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
function omniEnter() {
    var arb=arc=ari=arj='';
    var obj=(authstate())?omniBox:omniBoxAuthLogin;
    var input=obj.value,itr=0,itd=0,arg=[],arh=[],ark={};
    var uid=sysDefSessionID.value;
    if (input.toLowerCase()=='reload') { window.location.reload();
    } else if (input.toLowerCase()=='refresh') { window.location.reload();
    } else if (input.toLowerCase()=='upload') {
        document.getElementById('filebrowser').click(); return false;
    } else if (input.toLowerCase()=='save') { userBackup(uid);
    } else if (input.toLowerCase()=='load') { userRestore(uid);
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
    } else if (input.toLowerCase()=='nsfw') { omniSort('nsfw');
    } else if (input.toLowerCase()=='safe') { omniSort('safe');
    } else if (input.toLowerCase()=='all') { omniSort('');
    } else if (input=='\\=') {
        obj.value='\\='+demorse(sysDefMelody.value,uid,sysDefNumeric.value);
    } else if ((input.startsWith('"'))&&(input.endsWith('"'))) {
        compose(sysDefSessionID.value,input.replace('"','').slice(0,-1));
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
        }} set('./'+uid+'_files/store.json',encodeURIComponent(JSON.stringify(ark)),'rw');
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
            set(quote(arg[0]),'',itd); window.location.reload();
        }
    } else if (input.startsWith('touch ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('touch ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            set(quote(arg[0]),quote(arg[1]),itd); window.location.reload();
        } else if (arg.length==1) {
            set(quote(arg[0]),'',itd); window.location.reload();
        }
    } else if (input.startsWith('encode ')) {
        arj=input.replace('encode ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==3) {
            obj.value="decode \""+enmorse(quote(arg[0]),quote(arg[1]),quote(arg[2]))+"\" \""+quote(arg[1])+"\" \""+quote(arg[2])+"\"";
        }
    } else if (input.startsWith('decode ')) {
        arj=input.replace('decode ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==3) {
            obj.value="encode \""+demorse(quote(arg[0]),quote(arg[1]),quote(arg[2]))+"\" \""+quote(arg[1])+"\" \""+quote(arg[2])+"\"";
        }
    } else if (input.startsWith('decbase ')) {
        arj=input.replace('decbase ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            obj.value="basedec \""+decbase(quote(arg[0]),quote(arg[1]))+"\" \""+quote(arg[1])+"\"";
        }
    } else if (input.startsWith('basedec ')) {
        arj=input.replace('basedec ','');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==2) {
            obj.value="decbase \""+basedec(quote(arg[0]),quote(arg[1]))+"\" \""+quote(arg[1])+"\"";
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
        if (arg.length==2) {
            obj.value=loadFile(quote(arg[0]),quote(arg[1]));
        } else {
            obj.value=loadFile(quote(arg[0]));
        }
    } else if (input.startsWith('obj ')) {
        itd=(superuser())?'rw':uid; arj=input.replace('obj ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length==4) {
            objDataWork(quote(arg[0]),quote(arg[1]),quote(arg[2]),quote(arg[3]),itd,'r');
        } else if (arg.length==3) {
            objDataWork(quote(arg[0]),quote(arg[1]),quote(arg[2]),'',itd,'r');
        } else { objDataWork(quote(arg[0]),quote(arg[1]),'','',itd,'r'); }
    } else if (input.startsWith('timezoner ')) {
        arj=input.replace('timezoner ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            obj.value=timezoner(quote(arg[0]),quote(arg[1]));
        } else { obj.value=timezoner(quote(arg[0])); }
    } else if (input.startsWith('tz ')) {
        arj=input.replace('tz ', '');
        arg=arj.match(/\"([^\"]+)\"|(\w+)/g);
        if (arg.length>1) {
            obj.value=timezoner(quote(arg[0]),quote(arg[1]));
        } else { obj.value=timezoner(quote(arg[0])); }
    } else if (input.startsWith('update ')) {
        getPkgSequence('get -i '+document.getElementById('updateChannel'+CryptoJS.MD5(input.replace('update ','')).toString()).value,'get ',0);
    } else if (input.startsWith('download ')) {
        getPkgSequence('get -i '+document.getElementById('downloadChannel'+CryptoJS.MD5(input.replace('download ','')).toString()).value,'get ',0);
    } else if (input.startsWith('clear ')) {
        clearJournal(input.replace('clear ',''),sysDefMyMsgboxData,'msgbox');
    } else if (input.startsWith('erase ')) {
        clearJournal(input.replace('erase ',''),sysDefMyBookData,'book');
    } else if (input.startsWith('deluser ')) {
        arb=input.replace('deluser ',''),itr=0;
        if (arb.includes(',')) {
            arj=arb.split(','); for (idx in arj) {
                if (superuser()) { delete_user(arj[idx]);
                } else { if (arj[idx]==uid) { itr++; delete_user(arj[idx]); }}
            }
        } else {
            if (superuser()) { delete_user(arb);
            } else { if (arb==uid) { itr++; delete_user(arb); }}
        } if (itr>0) { omniAuthRequest('signout','',''); }
    } else if (input.startsWith('admin ')) {
        arb=input.replace('admin ',''); if (arb.endsWith('-')) {
            arc=arb.replace('-',''); administer(arc,'-');
        } else if (arb.endsWith('+')) {
            arc=arb.replace('+',''); administer(arc,'+');
        }
    } else if (input.startsWith('get ')) {
        getPkgSequence(input,'get ',0);
    } else if (input.startsWith('git ')) {
        getPkgSequence(input,'git ',1);
    } else if (input.startsWith('#')) {
        setdata('find',input);
    } else if (input.startsWith('_')) {
        omniGo(input.replace('_',''));
    } else if (input.startsWith('=')) {
        window.location.href=input.slice(1);
    } else if (input.includes('@')) {
        if (input.startsWith('@')) {
            arb=input.replace('@',''); if (arb.includes(':')) {
                arg=arb.split(':'); arc=CryptoJS.SHA256(arg[1]).toString();
                omniAuthRequest('signin',arg[0],arc);
            } else {
                arc=CryptoJS.SHA256('').toString();
                omniAuthRequest('signin',arb,arc);
            }
        } else {
            arg=input.split('@'); if (arg[0].includes(':')) {
                arh=arg[0].split(':'); arc=CryptoJS.SHA256(arh[1]).toString();
                if (arg[1].includes('signin')) {
                    omniAuthRequest('signin',arh[0],arc);
                } else if (arg[1].includes('signup')) {
                    omniAuthRequest('signup',arh[0],arc);
                } else if (arg[1].includes('rename')) {
                    rename_user(uid,arh[0],arh[1],uid);
                    omniAuthRequest('signin',arh[0],arc);
                }
            } else {
                arc=CryptoJS.SHA256('').toString();
                if (arg[1].includes('signin')) {
                    omniAuthRequest('signin',arg[0],arc);
                } else if (arg[1].includes('signup')) {
                    omniAuthRequest('signup',arg[0],arc);
                } else if (arg[1].includes('rename')) {
                    rename_user(uid,arg[0],'',uid);
                    omniAuthRequest('signin',arg[0],arc);
                }
            }
        }
    } else if (input.startsWith('?')) { omniDisp(input.slice(1));
    } else if (input.endsWith('?')) { omniDisp(input.slice(0,-1));
    } else if (input.endsWith(';')) { obj.value=executeCode(input);
    } else if (input.match(/([\w|\d|\s]*)(?:\?)([\d|\*]*)/gi)) { seekMusic(input);
    } else if (input.match(/(\w*)(?:\:)(\w*)/gi)) { seekCode(input);
    } else if (input.endsWith('sec')) {
        arb=parseInt(input.slice(0,-3))+1;
        setdata('memo',(Math.round(Date.now()/1000)+parseInt(arb)));
    } else if (input.endsWith('min')) {
        arb=parseInt(input.slice(0,-3))*60+1;
        setdata('memo',(Math.round(Date.now()/1000)+parseInt(arb)));
    } else { obj.value=calc(input); } obj.focus();
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
            var codeExt=result.split(/\r?\n/),strd=strl=[],strs=''; if (str.includes(',')) {
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
</script>
