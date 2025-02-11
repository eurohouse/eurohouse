function superuser() {
    return ((sysDefIsSession.value!=false)&&(sysDefSessionID.value=='root'));
}
function authstate() { return (sysDefIsSession.value!=false); }
function trigUserDel() {
    var dp=arrjob(sysDefPowersData.value,';',':');
    dp[sysDefSessionID.value]=-666;
    set('dominion.json',JSON.stringify(dp),true);
    sysDefPowersData.value=arrpack(dp,';',':');
}
function lockarr(ind) {
    return Object.values(jsonstr(sysDefLockData.value)[ind]);
}
function lockcount(ind) {
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
function clearJournal(num,obj,kw) {
    var msgarr=jsonstr(obj.value),nur,ras;
    var las=Object.keys(msgarr).length-1;
    if (isInt(num)) {
        nur=Math.abs(num);
        ras=(las-nur); if (num<0) {
            for (i=0; i<nur; i++) {
                if (msgarr[Object.keys(msgarr)[0]]!==undefined) { delete msgarr[Object.keys(msgarr)[0]]; }
            }
        } else {
            for (i=las; i>ras; i--) {
                if (msgarr[Object.keys(msgarr)[i]]!==undefined) { delete msgarr[Object.keys(msgarr)[i]]; }
            }
        }
    } else {
        nur=Math.abs(las);
        for (i=0; i<nur; i++) {
            if (msgarr[Object.keys(msgarr)[0]]!==undefined) {
                delete msgarr[Object.keys(msgarr)[0]];
            }
        }
    } set('./.'+kw+'/'+sysDefSessionID.value+'_'+kw+'.json',encodeURIComponent(JSON.stringify(msgarr)),true);
}
function openJournal(id,ob,oj) {
    var users=ob.value, jours=oj.value;
    var userArr=users.split(',');
    var userNum=arraySearch(id,userArr);
    return pager(jours,userNum);
}
function storeOpen(id) {
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    var hours=storeHours(id).split(',');
    return (hours.includes(userTimeNow(id)));
}
function userTimeNow(id) {
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    return (sysDefHoursNow.value).split(' ')[userNum];
}
function getUserAvatar(id) {
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    return (sysDefAvatarsNow.value).split(' ')[userNum];
}
function storeHours(id) {
    var userArr=(sysDefUsersList.value).split(',');
    var userNum=arraySearch(id,userArr);
    return pager(sysDefHoursActive.value,userNum);
}
function remove_entry(id,obj,name,cm=false,sp=false,dy=';',dx=':') {
    var dat={}; if (typeof(obj)=='object') {
        dat=(cm)?jsonstr(obj.value):arrjob((obj.value),dy,dx);
    } else {
        dat=(cm)?jsonstr(obj):arrjob((obj),dy,dx);
    } delete dat[id]; set(name,JSON.stringify(dat),true);
    if (sp) { del(id+'.json',true); del(id,true); }
    obj.value=(cm)?jsonarr(dat):arrpack(dat,dy,dx);
}
function delete_user(id) {
    unbind(sysDefSessionID.value);
    remove_entry(id,sysDefBindData,'binding.json');
    remove_entry(id,sysDefPowersData,'dominion.json');
    remove_entry(id,sysDefAutoData,'automator.json');
    remove_entry(id,sysDefFriendData,'friendship.json');
    remove_entry(id,sysDefToolData,'toolbox.json');
    remove_entry(id,sysDefCallData,'calling.json');
    del(id+'_session.json',true);
    del(id+'_session.json.bak',true);
    del(id+'_password',true);
    del(id+'_lock.json',true);
    del(id+'_lock.json.bak',true);
    del(id+'_metadata.json',true);
    del(id+'_metadata.json.bak',true);
    del('./.msgbox/'+id+'_msgbox.json',true);
    del('./.msgbox/'+id+'_msgbox.json.bak',true);
    del('./.book/'+id+'_book.json',true);
    del('./.book/'+id+'_book.json.bak',true);
    del('./.store/'+id+'_store.json',true);
    del('./.store/'+id+'_store.json.bak',true);
}
function transfer_entry(id,obj,name,seb=false) {
    var objData=arrjob(obj.value,';',':');
    objData[id]=(seb!==false)?id:objData[sysDefSessionID.value];
    if (sysDefSessionID.value!=id) {
        delete objData[sysDefSessionID.value];
    } set(name+'.json',JSON.stringify(objData),true);
    obj.value=arrpack(objData,';',':');
}
function rename_user(username,password) {
    unbind(sysDefSessionID.value);
    change(sysDefSessionID.value,username,CryptoJS.SHA256(password).toString(),true); if (sysDefSessionID.value!=username) {
        transfer_entry(username,sysDefBindData,'binding', true);
        transfer_entry(username,sysDefPowersData,'dominion');
        transfer_entry(username,sysDefAutoData,'automator');
        transfer_entry(username,sysDefFriendData,'friendship');
        transfer_entry(username,sysDefToolData,'toolbox');
        transfer_entry(username,sysDefCallData,'calling');
    }
}
function init_user(id,au='manual') {
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
    }
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
function administer(sta,act,fn) {
    if (superuser()) {
        var obj=document.getElementById('sysDef'+ucfirst(sta)+'Data'),arr=(obj!==null)?obj.value:';',sb=arr.slice(0,-1),ob=arrjob(sb,';',':'),sum=arrsum(Object.values(ob)),qua=Object.keys(ob).length;
        if ((sta=='bind')||(sta=='call')) {
            for (ib in ob) { ob[ib]=ib; }
        } else if (sta=='auto') {
            for (ib in ob) { ob[ib]=act; }
        } else if ((sta=='friend')||(sta=='tool')) {
            for (ib in ob) { ob[ib]=''; }
        } else {
            if ((act=='equal')||(act=='share')) {
                div=Math.round(sum/qua);
                for (ib in ob) { ob[ib]=parseInt(div); }
            } else if ((act=='total')||(act=='sum')) {
                for (ib in ob) { ob[ib]=parseInt(sum); }
            }
        } if (obj!==null) {
            set(fn+'.json',JSON.stringify(ob),true);
            obj.value=arrpack(ob,';',':');
        }
    }
}