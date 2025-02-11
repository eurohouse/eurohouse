function arrangePlay(cur,dl) {
    var dp=arrjob(sysDefPowersData.value,';',':');
    var db=arrjob(sysDefBindData.value,';',':');
    var da=arrjob(sysDefAutoData.value,';',':');
    sysDefAutoState.value=da[sysDefSessionID.value];
    $('#buttonAutomator').attr('src',sysDefPrefix.value+((sysDefAutoState.value=='auto')?'wheel.png':'steer.png')); var my=dp[sysDefSessionID.value],bl=pl='',ch='chain';
    if (my<=-666) {
        delete_user(sysDefSessionID.value);omniAuthRequest('signout','','');
    } ch=(arraySearch(sysDefSessionID.value,db)!=false)?((db[sysDefSessionID.value]!=sysDefSessionID.value)?'key':'lock'):((db[sysDefSessionID.value]!=sysDefSessionID.value)?'broke':'chain'),pl=formCur(my,cur,dl),bl=sysDefSessionID.value;
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