function scores(sta) {
    var sto={'bind':'binding','call':'calling','auto':'automator','tool':'toolbox','powers':'dominion','hdi':'i18n'};
    var sti={'bind':'μ','call':'μ','auto':'μ','tool':'μ','powers':'μ'},rid=sysDefSessionID.value;
    var ept=document.getElementById('sysDef'+ucfirst(sta)+'Data'),arr=ept.value,eps=sto[sta]+'.json',obj={}; if (sti[sta]!==undefined) {
        if (sti[sta]=='μ') { obj=strarr(arr,';',':');
        } else { obj=jsonarr(arr); }
    } else { obj=jsonarr(arr); }
    var res='',sortable={},ordered={};
    var dat=af={},at='',am=se=fo=ex=em=0;
    var epr=sysDefPrefix.value,eax=sysDefAva1Prefix.value;
    if (sta=='bind') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                af=(ordered[indi]!=indi)?"@"+ordered[indi]:"SELF";
                at=loadFile(indi+'_session.json','avatar');
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+eax+at+".png"+"' onclick='clip(&#34;"+at+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:35%;' value='@"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:34%;' value='"+af+"' onclick='clip(&#34;"+af+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"chain.png"+"' onclick='bind(&#34;"+rid+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='auto') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                af=(ordered[indi]=='auto')?"AUTO":"MANUAL";
                at=loadFile(indi+'_session.json','avatar');
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+eax+at+".png"+"' onclick='clip(&#34;"+at+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:34%;' value='@"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:45%;' value='"+af+"' onclick='clip(&#34;"+af+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='tool') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                dat=jsonarr(openJournal(indi,sysDefStoreJSONs));
                if ((dat[ordered[indi]]!==undefined)&&(typeof(dat[ordered[indi]])=='object')&&(ordered[indi]!='')) {
                    ex=((dat[ordered[indi]]['finite']!==undefined)&&(isInt(dat[ordered[indi]]['finite']))&&(dat[ordered[indi]]['finite']==1))?1:0;
                    am=((dat[ordered[indi]]['amount']!==undefined)&&(isInt(dat[ordered[indi]]['amount']))&&(dat[ordered[indi]]['amount']>0))?parseInt(dat[ordered[indi]]['amount']):0;
                    se=((dat[ordered[indi]]['series']!==undefined)&&(isInt(dat[ordered[indi]]['series']))&&(dat[ordered[indi]]['series']>1))?parseInt(dat[ordered[indi]]['series'])+'x':'x';
                    fo=((dat[ordered[indi]]['force']!==undefined)&&(isNum(dat[ordered[indi]]['force']))&&(dat[ordered[indi]]['force']>0))?parseFloat(dat[ordered[indi]]['force']):0;
                    em=(ex!=0)?am+'/'+se+fo:se+fo;
                    at=loadFile(indi+'_session.json','avatar');
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+eax+at+".png"+"' onclick='clip(&#34;"+at+"&#34;);'>";
                    res+="<input type='button' onmouseover='soundButton();' style='width:26%;' value='@"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                    res+="<input type='button' onmouseover='soundButton();' style='width:30%;' value='"+ordered[indi]+"' onclick='clip(&#34;"+ordered[indi]+"&#34;);'>";
                    res+="<input type='button' onmouseover='soundButton();' style='width:23%;' value='"+em+"' onclick='clip(&#34;"+em+"&#34;);'>";
                    if (superuser()) {
                        res+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                    } res+="<br>";
                }
            }
        }
    } else if (sta=='hdi') {
        for (et in obj) {
            var lem,lef,mysm,mysf,eysm,eysf,gnim,gnif;
            if ((obj[et]['Life Expectancy']!==undefined)&&(typeof(obj[et]['Life Expectancy'])=='object')) {
                lem=obj[et]['Life Expectancy']['Male'];
                lef=obj[et]['Life Expectancy']['Female'];
            } else { lem=32.5; lef=37.5; }
            if ((obj[et]['School Years']!==undefined)&&(typeof(obj[et]['School Years'])=='object')) {
                if ((obj[et]['School Years']['Average']!==undefined)&&(typeof(obj[et]['School Years']['Average'])=='object')) {
                    mysm=obj[et]['School Years']['Average']['Male'];
                    mysf=obj[et]['School Years']['Average']['Female'];
                } else { mysm=10; mysf=5; }
                if ((obj[et]['School Years']['Expected']!==undefined)&&(typeof(obj[et]['School Years']['Expected'])=='object')) {
                    eysm=obj[et]['School Years']['Expected']['Male'];
                    eysf=obj[et]['School Years']['Expected']['Female'];
                } else { eysm=11.5; eysf=6.5; }
            } else { mysm=10; mysf=5; eysm=11.5; eysf=6.5; }
            if ((obj[et]['Gross National Income']!==undefined)&&(typeof(obj[et]['Gross National Income'])=='object')) {
                gnim=obj[et]['Gross National Income']['Male'];
                gnif=obj[et]['Gross National Income']['Female'];
            } else { gnim=7500; gnif=2500; }
            var lei=((((lem+lef)/2)-20)/65),ei=(((((mysm+mysf)/2)/15)+(((eysm+eysf)/2)/18))/2),ii=((Math.log((gnim+gnif)/2)-Math.log(100))/Math.log(750));
            obj[et]['Human Development Index']=superRound((lei*ei*ii)**(1/3));
            obj[et]['Gross National Income']['Both']=superRound((gnim+gnif)/2);
        } sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b['Human Development Index']-a['Human Development Index'])
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)&&(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='Flag."+indi+".png"+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='"+sortable[indi]['Human Development Index']+"' onclick='clip(&#34;"+sortable[indi]['Human Development Index']+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:40%;' value='"+format_currency((parseFloat(sortable[indi]['Gross National Income']['Both'])*(calc(sysDefCurrencyPower.value))),4)+"' onclick='clip(&#34;"+sortable[indi]['Gross National Income']['Both']+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"info.png"+"' onclick='omniPath(&#34;i18n.json&#34;,&#34;"+indi+"&#34;,&#34;false&#34;);'><br>";
            }
        }
    } else if (sta=='powers') {
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                at=loadFile(indi+'_session.json','avatar');
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+eax+at+".png"+"' onclick='clip(&#34;"+at+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='@"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:54%;' value='"+format_currency(sortable[indi])+"' onclick='clip(&#34;"+sortable[indi]+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+epr+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;);'>";
                } res+="<br>";
            }
        }
    } return res;
}
