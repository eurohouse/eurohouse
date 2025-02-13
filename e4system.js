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
    var arr=jsonFilter(str,mask);
    var ard=''; for (el in arr) {
        ard=el+'<br>'+arr[el]+'<br>'+ard;
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
            fu0="buy_item(&#34;"+usr+"&#34;,&#34;"+el+"&#34;,&#34;"+id+"&#34;);", fu1=(isInt(el))?"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":((eld['type']=='weapon')?"equip(&#34;"+id+"&#34;,&#34;"+el+"&#34;);":"charge(&#34;"+id+"&#34;,&#34;"+el+"&#34;);");
            arl+="<td><input type='button' style='width:80%;' onclick='"+((id!=usr)?fu0:fu1)+"' value='"+el+"'>";
            arl+="<input type='image' class='power' src='"+epr+"info.png"+"' onclick='omniPath(&#34;./.store/"+usr+"_store.json&#34;,&#34;"+el+"&#34;,&#34;false&#34;);'>";
            arl+="</td><td>"+eld['amount']+"</td><td>$"+eld['price']+"</td>"; ard=arl+"</tr>"+ard;
        }
    } return ard;
}
function formCur(val,cur) {
    var cve=(cur.includes('|'))?cur.split('|')[0]:cur;
    var delim=(cur.includes('|'))?cur.split('|')[1]:'';
    var res='',x=delimNum(parseInt(val),delim);
    if (cve.length==3) {
        if ((cve.charCodeAt(0)==94)&&(cve.charCodeAt(2)==95)) {
            res=cve.replaceAll('^','').replaceAll('_',' ')+x;
        } else if ((cve.charCodeAt(0)==95)&&(cve.charCodeAt(2)==94)) {
            res=x+cve.replaceAll('^','').replaceAll('_',' ');
        }
    } else if (cve.length==2) {
        if ((cve.charCodeAt(0)==94)&&(cve.charCodeAt(1)!=94)) {
            res=cve.replaceAll('^','')+x;
        } else if ((cve.charCodeAt(0)!=94)&&(cve.charCodeAt(1)==94)) {
            res=x+cve.replaceAll('^','');
        } else {
            res=String.fromCharCode(cve.charCodeAt(0))+x+String.fromCharCode(cve.charCodeAt(2));
        }
    } else { res=cve+x; } return res;
}
function jsonBookKeep(str,cur) {
    var arr=jsonstr(str),ard=arl='',arf={},eld=[];
    for (el in arr) {
        eld=arr[el].split(' | ');arf[el]=arr[el];
    } for (el in arf) {
        eld=arr[el].split(' | ');
        arl=(eld[5]=='ERR')?'<tr style="text-decoration:line-through;">':'<tr>';
        arl+='<td>@'+eld[1]+'</td>';
        arl+=(isInt(eld[2]))?'<td>'+formCur(eld[2],cur)+'</td>':'<td>'+eld[2]+'</td>';
        arl+=(isInt(eld[3]))?'<td>'+formCur(eld[3],cur)+'</td>':'<td>'+eld[3]+'</td>';
        arl+='<td>'+formCur(eld[4],cur)+'</td>';
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
function arrangeMenu(list,item,delim=',') {
    var arr=list.toString('').split(delim);
    if (arr.indexOf('')>-1) {
        arr.splice(arr.indexOf(''),1);
    } if (arr.indexOf(' ')>-1) {
        arr.splice(arr.indexOf(' '),1);
    } if (arr.indexOf(item)>-1) {
        arr.splice(arr.indexOf(item),1);
    } else { arr.push(item); }
    return finarr(arr).join(delim);
}
function isInMenu(list,item) {
    var arr=list.toString('').split(',');
    return (arr.indexOf(item)>-1);
}