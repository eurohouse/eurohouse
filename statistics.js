function hdiscore(lem,lef,mysm,mysf,eysm,eysf,gnim,gnif) {
    var lei=((((lem+lef)/2)-20)/65);
    var ei=(((((mysm+mysf)/2)/15)+(((eysm+eysf)/2)/18))/2);
    var ii=((Math.log((gnim+gnif)/2)-Math.log(100))/Math.log(750));
    return superRound((lei*ei*ii)**(1/3));
}
function scores(sta) {
    var sto={'bind':'binding','call':'calling','auto':'automator','friend':'friendship','tool':'toolbox','ip':'visitors','powers':'dominion','hdi':'i18n'};
    var sti={'bind':'μ','call':'μ','auto':'μ','friend':'μ','tool':'μ','powers':'μ'},rid=sysDefSessionID.value;
    var ept=document.getElementById('sysDef'+ucfirst(sta)+'Data');
    var arr=ept.value,eps=sto[sta]+'.json',obj={};
    if (sti[sta]!==undefined) {
        if (sti[sta]=='μ') { obj=arrjob(arr,';',':'); }
    } else { obj=jsonstr(arr); }
    var res='',sortable={},ordered={};
    var dat=af={},at='',am=se=fo=ex=em=0;
    var epr=sysDefPrefix.value,eax=sysDefAvaPrefix.value;
    if (sta=='bind') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                af=(ordered[indi]!=indi)?"@"+ordered[indi]:"SELF";
                at=getUserAvatar(indi);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:35%;' value='@"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:34%;' value='"+af+"' onclick='clp(&#34;"+af+"&#34;);'>";
                res+="<input type='image' class='power' src='"+epr+"chain.png"+"' onclick='bind(&#34;"+rid+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='call') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                af=(ordered[indi]!=indi)?"INCOMING":"OUTGOING";
                at=getUserAvatar(indi);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:25%;' value='@"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:45%;' value='"+af+"' onclick='clp(&#34;"+af+"&#34;);'>";
                res+="<input type='image' class='power' src='"+epr+"call.png"+"' onclick='call(&#34;"+rid+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='auto') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                af=(ordered[indi]=='auto')?"AUTO":"MANUAL";
                at=getUserAvatar(indi);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:34%;' value='@"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:45%;' value='"+af+"' onclick='clp(&#34;"+af+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='friend') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                af=(ordered[indi]!='')?'@{'+ordered[indi]+'}':"NULL";
                at=getUserAvatar(indi);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:24%;' value='@"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:54%;' value='"+af+"' onclick='clp(&#34;"+af+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='tool') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                dat=jsonstr(openJournal(indi,sysDefStoreList,sysDefStoreJSONs));
                if ((dat[ordered[indi]]!==undefined)&&(typeof(dat[ordered[indi]])=='object')&&(ordered[indi]!='')) {
                    ex=((dat[ordered[indi]]['finite']!==undefined)&&(isInt(dat[ordered[indi]]['finite']))&&(dat[ordered[indi]]['finite']==1))?1:0;
                    am=((dat[ordered[indi]]['amount']!==undefined)&&(isInt(dat[ordered[indi]]['amount']))&&(dat[ordered[indi]]['amount']>0))?parseInt(dat[ordered[indi]]['amount']):0;
                    se=((dat[ordered[indi]]['series']!==undefined)&&(isInt(dat[ordered[indi]]['series']))&&(dat[ordered[indi]]['series']>1))?parseInt(dat[ordered[indi]]['series'])+'x':'x';
                    fo=((dat[ordered[indi]]['force']!==undefined)&&(isInt(dat[ordered[indi]]['force']))&&(dat[ordered[indi]]['force']>0))?parseInt(dat[ordered[indi]]['force']):0;
                    em=(ex!=0)?am+'/'+se+fo:se+fo;
                    at=getUserAvatar(indi);
                    res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                    res+="<input type='button' style='width:26%;' value='@"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                    res+="<input type='button' style='width:30%;' value='"+ordered[indi]+"' onclick='clp(&#34;"+ordered[indi]+"&#34;);'>";
                    res+="<input type='button' style='width:23%;' value='"+em+"' onclick='clp(&#34;"+em+"&#34;);'>";
                    if (superuser()) {
                        res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                    } res+="<br>";
                }
            }
        }
    } else if (sta=='ip') {
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>(a['Username']<b['Username'])?-1:((a['Username']>b['Username'])?1:0))
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)&&(indi!='')) {
                af=jsonstr(sysDefHdiData.value);
                if (af[sortable[indi]['Country']]!==undefined) {
                    res+="<input type='image' class='power' src='Flag."+sortable[indi]['Country']+".png"+"' onclick='clp(&#34;"+sortable[indi]['Country']+"&#34;);'>";
                } else {
                    res+="<input type='image' class='power' src='Flag.UN.png"+"' onclick='clp(&#34;"+sortable[indi]['Country']+"&#34;);'>";
                } res+="<input type='button' style='width:46%;' value='"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                at=getUserAvatar(sortable[indi]['Username']);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:24%;' value='@"+sortable[indi]['Username']+"' onclick='clp(&#34;"+sortable[indi]['Username']+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true,true);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='hdi') {
        for (et in obj) {
            var lem,lef,mysm,mysf,eysm,eysf,gnim,gnif;
            if (obj[et]['Life Expectancy']!==undefined) {
                lem=obj[et]['Life Expectancy']['Male'];
                lef=obj[et]['Life Expectancy']['Female'];
            } else {
                lem=70/2-2.5; lef=70/2+2.5;
            } if (obj[et]['School Years']!==undefined) {
                mysm=obj[et]['School Years']['Average']['Male'];
                mysf=obj[et]['School Years']['Average']['Female'];
                eysm=obj[et]['School Years']['Expected']['Male'];
                eysf=obj[et]['School Years']['Expected']['Female'];
            } else {
                mysm=15/2+2.5; mysf=15/2-2.5;
                eysm=18/2+2.5; eysf=18/2-2.5;
            } if (obj[et]['Gross National Income']!==undefined) {
                gnim=obj[et]['Gross National Income']['Male'];
                gnif=obj[et]['Gross National Income']['Female'];
            } else {
                gnim=10/5+2.5; gnif=10/5-2.5;
            } obj[et]['Human Development Index']=hdiscore(lem,lef,mysm,mysf,eysm,eysf,gnim,gnif);
            obj[et]['Gross National Income']['Both']=(gnim+gnif)/2;
        } sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b['Human Development Index']-a['Human Development Index'])
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)&&(indi!='')) {
                res+="<input type='image' class='power' src='Flag."+indi+".png"+"'>";
                res+="<input type='button' style='width:15%;' value='"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:24%;' value='"+sortable[indi]['Human Development Index']+"' onclick='clp(&#34;"+sortable[indi]['Human Development Index']+"&#34;);'>";
                res+="<input type='button' style='width:40%;' value='$"+sortable[indi]['Gross National Income']['Both']+"K' onclick='clp(&#34;"+sortable[indi]['Gross National Income']['Both']+"&#34;);'>";
                res+="<input type='image' class='power' src='"+epr+"info.png"+"' onclick='omniPath(&#34;i18n.json&#34;,&#34;"+indi+"&#34;,&#34;false&#34;);'><br>";
            }
        }
    } else if (sta=='powers') {
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                at=getUserAvatar(indi);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:24%;' value='@"+indi+"' onclick='clp(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:54%;' value='"+sortable[indi]+"' onclick='clp(&#34;"+sortable[indi]+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } return res;
}
