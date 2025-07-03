function administer(entry,mode='+') {
    if (superuser()) {
        var files={'bind':'binding','auto':'automator','tool':'toolbox','powers':'dominion','hdi':'i18n'};
        var sub={'bind':'i','auto':'manual|auto','tool':'e','powers':'n'},sum=qua=div=1;
        var tempObj=obj={},tempData=temp='';
        var counts=jsonarr(sysDefPowersData.value,';',':');
        if (notNull(sub[entry])) {
            tempObj=document.getElementById('sysDef'+ucfirst(entry)+'Data'),tempData=tempObj.value;
            obj=jsonarr(tempData);
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
                set(files[entry]+'.json',JSON.stringify(obj),'rw'); tempObj.value=arrjson(obj);
            }
        } else {
            for (temp in sub) {
                tempObj=document.getElementById('sysDef'+ucfirst(temp)+'Data'),tempData=tempObj.value;
                obj=jsonarr(tempData);
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
                    set(files[temp]+'.json',JSON.stringify(obj),'rw'); tempObj.value=arrjson(obj);
                }
            }
        }
    }
}
function highscore(mode) {
    var files={'bind':'binding.json','call':'calling.json','auto':'automator.json','tool':'toolbox.json','powers':'dominion.json','hdi':'i18n.json'};
    var objHTML={},objText='',obj={},res='',sortable={},ordered={},data={};
    var pm=sysDefPrefix.value,am=sysDefAva1Prefix.value;
    if (mode=='bind') {
        objHTML=sysDefBindData,objText=objHTML.value,obj=jsonarr(objText);
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:36%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:42%;' value='"+ordered[indi]+"' onclick='clip(&#34;"+ordered[indi]+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+((ordered[indi]!=indi)?"broke.png":"chain.png")+"' onclick='bind(&#34;"+sysDefSessionID.value+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+objText+"&#34;,&#34;"+files[mode]+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (mode=='auto') {
        objHTML=sysDefAutoData,objText=objHTML.value,obj=jsonarr(objText);
        ordered=Object.keys(obj).sort().reduce(
            (obd,key) => { obd[key]=obj[key]; return obd; }, {}
        ); for (indi in ordered) {
            if ((ordered[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:34%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:40%;' value='"+((ordered[indi]).toUpperCase())+"' onclick='clip(&#34;"+((ordered[indi]).toUpperCase())+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+((ordered[indi]=='auto')?"wheel.png":"steer.png")+"' onclick='automate(&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+objText+"&#34;,&#34;"+files[mode]+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (mode=='tool') {
        objHTML=sysDefToolData,objText=objHTML.value,obj=jsonarr(objText);
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
                        res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+objText+"&#34;,&#34;"+files[mode]+"&#34;);'>";
                    } res+="<br>";
                }
            }
        }
    } else if (mode=='hdi') {
        obj=jsonarr(sysDefHdiData.value); for (et in obj) {
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
        objHTML=sysDefPowersData,objText=objHTML.value,obj=jsonarr(objText);
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:50%;' value='"+format_currency(sortable[indi])+"' onclick='clip(&#34;"+sortable[indi]+"&#34;);'>";
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+((cancelled(ordered[indi]))?"hole.png":"heart.png")+"'>";
                if (superuser()) {
                    res+="<input type='image' class='power' onmouseover='soundButton();' src='"+pm+"trash.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+objText+"&#34;,&#34;"+files[mode]+"&#34;);'>";
                } res+="<br>";
            }
        }
    } else if (mode=='time') {
        objText=sysDefPublicUserData.value,obj=jsonarr(objText)['time'];
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:50%;' value='"+sortable[indi]+"' onclick='clip(&#34;"+sortable[indi]+"&#34;);'><br>";
            }
        }
    } else if (mode=='date') {
        objText=sysDefPublicUserData.value,obj=jsonarr(objText)['date'];
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:50%;' value='"+sortable[indi]+"' onclick='clip(&#34;"+sortable[indi]+"&#34;);'><br>";
            }
        }
    } else if (mode=='work') {
        objText=sysDefPublicUserData.value,obj=jsonarr(objText)['wh'];
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b-a)
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)||(indi!='')) {
                res+="<input type='image' class='power' onmouseover='soundButton();' src='"+am+timezoner(indi,'at')+".png"+"' onclick='clip(&#34;"+timezoner(indi,'at')+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:24%;' value='"+indi+"' onclick='clip(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' onmouseover='soundButton();' style='width:50%;' value='"+sortable[indi]+"' onclick='clip(&#34;"+sortable[indi]+"&#34;);'><br>";
            }
        }
    } return res;
}