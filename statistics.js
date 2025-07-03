function scores(mode) {
    var files={'bind':'binding','call':'calling','auto':'automator','tool':'toolbox','powers':'dominion','hdi':'i18n'};
    var micro=['bind','call','auto','tool','powers'];
    var dataObject=document.getElementById('sysDef'+ucfirst(mode)+'Data').value;
    var dataText=dataObject.value; var filename=files[mode]+'.json';
    var obj=(notNull(micro[mode]))?strarr(dataText,';',':'):jsonarr(dataText);
    var res='',sortable={},ordered={},data={};
    var pm=sysDefPrefix.value,am=sysDefAva1Prefix.value;
    if (mode=='bind') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:35%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:34%;' value='"+ordered[indi]+"' onclick='clip(&#34;"+ordered[indi]+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"chain.png"+"' onclick='bind(&#34;"+sysDefSessionID.value+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+dataText+"&#34;,&#34;"+filename+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (mode=='auto') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:34%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:45%;' value='"+((ordered[indi]).toUpperCase())+"' onclick='clip(&#34;"+((ordered[indi]).toUpperCase())+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+dataText+"&#34;,&#34;"+filename+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (mode=='tool') {
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                data=jsonarr(openJournal(indi,sysDefStoreJSONs));
                if ((data[ordered[indi]]!==undefined)&&(typeof(data[ordered[indi]])=='object')&&(ordered[indi]!='')) {
                    var finite=((data[ordered[indi]]['finite']!==undefined)&&(isInt(data[ordered[indi]]['finite']))&&(data[ordered[indi]]['finite']==1))?1:0;
                    var amount=((data[ordered[indi]]['amount']!==undefined)&&(isInt(data[ordered[indi]]['amount']))&&(data[ordered[indi]]['amount']>0))?parseInt(data[ordered[indi]]['amount']):0;
                    var series=((data[ordered[indi]]['series']!==undefined)&&(isInt(data[ordered[indi]]['series']))&&(data[ordered[indi]]['series']>1))?parseInt(data[ordered[indi]]['series'])+'x':'x';
                    var force=((data[ordered[indi]]['force']!==undefined)&&(isNum(data[ordered[indi]]['force']))&&(data[ordered[indi]]['force']>0))?parseFloat(data[ordered[indi]]['force']):0;
                    var toolTableau=(finite!=0)?amount+'/'+series+force:series+force;
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                    res+="<input type='button' onmouseover='soundButton();' style='width:26%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                    res+="<input type='button' onmouseover='soundButton();' style='width:30%;' value='"+ordered[indi]+"' onclick='clip(&#34;"+ordered[indi]+"&#34;);'>";
                    res+="<input type='button' onmouseover='soundButton();' style='width:23%;' value='"+toolTableau+"' onclick='clip(&#34;"+toolTableau+"&#34;);'>";
                    if (superuser()) {
                        res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+dataText+"&#34;,&#34;"+filename+"&#34;);'>";
                    } res+="<br>";
                }
            }
        }
    } else if (mode=='hdi') {
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
                res+="<input type='button' onmouseover='soundButton();' style='width:40%;' value='"+format_currency((parseFloat(sortable[indi]['Gross National Income']['Both'])),4)+"' onclick='clip(&#34;"+sortable[indi]['Gross National Income']['Both']+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"info.png"+"' onclick='omniPath(&#34;i18n.json&#34;,&#34;"+indi+"&#34;,&#34;false&#34;);'><br>";
            }
        }
    } else if (mode=='powers') {
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:54%;' value='"+format_currency(sortable[indi])+"' onclick='clip(&#34;"+sortable[indi]+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+dataText+"&#34;,&#34;"+filename+"&#34;);'>";
                } res+="<br>";
            }
        }
    } return res;
}
