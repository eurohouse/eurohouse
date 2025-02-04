function hdiscore(lem=(65-2.5),lef=(65+2.5),mys=(15/2),eys=(18/2),gni=100) {
    var lei=((((lem+lef)/2)-20)/65);
    var ei=(((mys/15)+(eys/18))/2);
    var ii=((Math.log(gni)-Math.log(100))/Math.log(750));
    return superRound((lei*ei*ii)**(1/3));
}
function scores(sta) {
    var sto={'bind':'binding','call':'calling','auto':'automator','friend':'friendship','tool':'toolbox','ip':'visitors','powers':'dominion','locale':'i18n'};
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
                res+="<input type='button' style='width:34%;' value='@"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:32%;' value='"+af+"' onclick='navigator.clipboard.writeText(&#34;"+af+"&#34;);'>";
                res+="<input type='image' class='power' src='"+epr+"chain.png"+"' onclick='bind(&#34;"+rid+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true);'>";
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
                res+="<input type='button' style='width:24%;' value='@"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:42%;' value='"+af+"' onclick='navigator.clipboard.writeText(&#34;"+af+"&#34;);'>";
                res+="<input type='image' class='power' src='"+epr+"call.png"+"' onclick='call(&#34;"+rid+"&#34;,&#34;"+indi+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true);'>";
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
                res+="<input type='button' style='width:34%;' value='@"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:42%;' value='"+af+"' onclick='navigator.clipboard.writeText(&#34;"+af+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true);'>";
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
                res+="<input type='button' style='width:24%;' value='@"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:48%;' value='"+af+"' onclick='navigator.clipboard.writeText(&#34;"+af+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true);'>";
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
                    res+="<input type='button' style='width:26%;' value='@"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                    res+="<input type='button' style='width:30%;' value='"+ordered[indi]+"' onclick='navigator.clipboard.writeText(&#34;"+sortable[indi]+"&#34;);'>";
                    res+="<input type='button' style='width:23%;' value='"+em+"' onclick='navigator.clipboard.writeText(&#34;"+em+"&#34;);'>";
                    if (superuser()) {
                        res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true);'>";
                    } res+="<br>";
                }
            }
        }
    } else if (sta=='ip') {
        sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b['Country']-a['Country'])
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)&&(indi!='')) {
                af=jsonstr(sysDefLocaleData.value);
                if (af[sortable[indi]['Country']]!==undefined) {
                    res+="<input type='image' class='power' src='Flag."+sortable[indi]['Country']+".png"+"'>";
                } else {
                    res+="<input type='image' class='power' src='Flag.UN.png"+"'>";
                } res+="<input type='button' style='width:46%;' value='"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                at=getUserAvatar(sortable[indi]['Username']);
                res+="<input type='image' class='power' src='"+eax+at+".png"+"'>";
                res+="<input type='button' style='width:24%;' value='@"+sortable[indi]['Username']+"'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;visitors.json&#34;,true,true,&#34;; &#34;,&#34; &#34;);'>";
                } res+="<br>";
            }
        }
    } else if (sta=='locale') {
        for (et in obj) {
            obj[et]['$FMLA']={}; obj[et]['$DISP']={};
            if (obj[et]['Life Expectancy']!==undefined) {
                obj[et]['$FMLA']['%M']=obj[et]['Life Expectancy']['Male'];
                obj[et]['$FMLA']['%F']=obj[et]['Life Expectancy']['Female'];
                obj[et]['$DISP']['%M']=obj[et]['$FMLA']['%M'];
                obj[et]['$DISP']['%F']=obj[et]['$FMLA']['%F'];
            } else {
                obj[et]['$FMLA']['%M']=(35-2.5); obj[et]['$FMLA']['%F']=(35+2.5);
                obj[et]['$DISP']['%M']='N/A'; obj[et]['$DISP']['%F']='N/A';
            } if (obj[et]['School Years']!==undefined) {
                obj[et]['$FMLA']['%A']=withA=obj[et]['School Years']['Average'];
                obj[et]['$FMLA']['%E']=withE=obj[et]['School Years']['Expected'];
                obj[et]['$DISP']['%A']=obj[et]['$FMLA']['%A'];
                obj[et]['$DISP']['%E']=obj[et]['$FMLA']['%E'];
            } else {
                obj[et]['$FMLA']['%A']=(15/2); obj[et]['$FMLA']['%E']=(18/2);
                obj[et]['$DISP']['%A']='N/A'; obj[et]['$DISP']['%E']='N/A';
            } if (obj[et]['Gross National Income']!==undefined) {
                obj[et]['$FMLA']['%G']=withG=obj[et]['Gross National Income'];
                obj[et]['$DISP']['%G']=obj[et]['$FMLA']['%G'];
            } else {
                obj[et]['$FMLA']['%G']=100; obj[et]['$DISP']['%G']='N/A';
            } obj[et]['Human Development Index']=hdiscore(obj[et]['$FMLA']['%M'],obj[et]['$FMLA']['%F'],obj[et]['$FMLA']['%A'],obj[et]['$FMLA']['%E'],obj[et]['$FMLA']['%G']);
        } sortable=Object.fromEntries(
            Object.entries(obj).sort(([,a],[,b])=>b['Human Development Index']-a['Human Development Index'])
        ); for (indi in sortable) {
            if ((sortable[indi]!==undefined)&&(indi!='')) {
                res+="<input type='image' class='power' src='Flag."+indi+".png"+"'>";
                res+="<input type='button' style='width:15%;' value='"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:24%;' value='"+sortable[indi]['Human Development Index']+"' onclick='navigator.clipboard.writeText(&#34;"+sortable[indi]['Human Development Index']+"&#34;);'>";
                res+="<input type='button' style='width:40%;' value='$"+sortable[indi]['$DISP']['%G']+"' onclick='navigator.clipboard.writeText(&#34;"+sortable[indi]['$DISP']['%G']+"&#34;);'>";
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
                res+="<input type='button' style='width:24%;' value='@"+indi+"' onclick='navigator.clipboard.writeText(&#34;"+indi+"&#34;);'>";
                res+="<input type='button' style='width:54%;' value='"+sortable[indi]+"' onclick='navigator.clipboard.writeText(&#34;"+sortable[indi]+"&#34;);'>";
                if (superuser()) {
                    res+="<input type='image' class='power' src='"+epr+"delete.png"+"' onclick='remove_entry(&#34;"+indi+"&#34;,&#34;"+arr+"&#34;,&#34;"+eps+"&#34;,true);'>";
                } res+="<br>";
            }
        }
    } return res;
}
