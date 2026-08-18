function isLocalhost() {
    const hostname=window.location.hostname;
    return (hostname==='localhost'||hostname==='127.0.0.1'||hostname==='::1'||hostname.startsWith('192.168.')||hostname.startsWith('10.')||hostname.startsWith('172.'));
}
function isMobileUserAgent() {
    return (/Mobi|Android|iPhone/i.test(navigator.userAgent));
}
function isTouchDevice() {
    return (('ontouchstart' in window)||(navigator.maxTouchPoints>0));
}
function sleep(ms=1000) {
    return new Promise(resolve=>setTimeout(resolve,ms));
}
const MM_TO_INCHES=25.4; const HPA_TO_INHG=0.02953; const SLEEP_DELAY=1000;
function getUnitSystem(isoCode) {
    if (/^(US|LR|MM|GB|UK)$/.test(isoCode)) return 'imperial';
    if (/^(UN|EU|AQ)$/.test(isoCode)) return 'base';
    return 'metric';
}
function formatPressure(pressureHpa,unitSystem) {
    if (!pressureHpa&&pressureHpa!==0) return 'N/A';
    if (unitSystem==='imperial') {
        return `${(pressureHpa*HPA_TO_INHG).toFixed(2)} inHg`;
    } return `${Math.round(pressureHpa)} hPa`;
}
function buildTempObject(mainData,unitSystem) {
    const temps={}; if (mainData) {
        temps['🔥']=`${mainData.temp_max} ${(unitSystem==='imperial'||unitSystem==='us'||unitSystem==='uk')?'°F':((unitSystem==='base')?'K':'°C')}`;
        temps['🌡️']=`${mainData.temp} ${(unitSystem==='imperial'||unitSystem==='us'||unitSystem==='uk')?'°F':((unitSystem==='base')?'K':'°C')}`;
        temps['❄️']=`${mainData.temp_min} ${(unitSystem==='imperial'||unitSystem==='us'||unitSystem==='uk')?'°F':((unitSystem==='base')?'K':'°C')}`;
    } return temps;
}
function buildExtraOpenWeatherMapObject(mainData,cloudsData,totalPrecipMm,unitSystem) {
    return {
        '🧪': this.formatPressure(mainData.pressure,unitSystem),
        '💧': unitSystem==='imperial'?`${(totalPrecipMm/MM_TO_INCHES).toFixed(2)} in`:`${totalPrecipMm.toFixed(1)} mm`,
        '☁️': cloudsData?.all!=null?`${cloudsData.all}%`:'N/A'
    };
}
function populateNestedWeatherTable(content) {
    const nestedTable=document.createElement('table');
    nestedTable.style.borderCollapse='collapse';
    nestedTable.style.width='100%';
    if (!notEmpty(content)) { return nestedTable; }
    for (idx in content) {
        const nestedRow=document.createElement('tr');
        const indexCell=document.createElement('td');
        indexCell.textContent=idx; indexCell.style.padding='4px';
        indexCell.style.textAlign='center';
        nestedRow.appendChild(indexCell);
	const dataCell=document.createElement('td');
        dataCell.textContent=content[idx];
        dataCell.style.padding='4px';
	dataCell.style.textAlign='center';
        nestedRow.appendChild(dataCell);
        nestedTable.appendChild(nestedRow);
    } return nestedTable;
}
async function populateWeatherTable() {
    if (requestMode.value!=='weather') return;
    const vocEntry=localizedVocWord();
    const tableElem=document.getElementById('weatherTable');
    const tableBody=document.getElementById('weatherData');
    tableElem.className='wrapper'; tableBody.innerHTML='';
    const existingTfoot=document.getElementById('weatherFoot');
    if (existingTfoot) { existingTfoot.remove(); }
    const locations=(sysDefLocations.value).split(', ').map(l=>l.trim());
    const count=locations.length; const isoCode=sysDefUnits.value;
    const unitSystem=getUnitSystem(isoCode); for (let i=0; i<count; i++) {
        const location=locations[i]; const row=tableBody.insertRow();
        try {
            const data=await getWeatherFromProxy(location);
            if (data&&data.main) {
                row.insertCell().textContent=data.name||location;
                const temps=buildTempObject(data.main,unitSystem);
                const nestedCell=row.insertCell();
                nestedCell.appendChild(populateNestedWeatherTable(temps));
                nestedCell.style.textAlign='center'; nestedCell.style.fontWeight='normal';
                const rainNow=data.rain?.['3h']??0; const snowNow=data.snow?.['3h']??0;
                const hourlyPrecipMm=(data.hourly?.[0]?.rain?.['3h']??0)+(data.hourly?.[0]?.snow?.['3h']??0);
                const totalPrecipMm=Math.max((rainNow+snowNow),hourlyPrecipMm);
                const detailsCellOWM=row.insertCell();
		const extraOWM=buildExtraOpenWeatherMapObject(
                    data.main,data.clouds,totalPrecipMm,unitSystem
                ); detailsCellOWM.appendChild(populateNestedWeatherTable(extraOWM));
                detailsCellOWM.style.textAlign='center';
                detailsCellOWM.style.fontWeight='normal';
            } else {
                console.warn(`No weather data returned for ${location}. Response:`,data);
                row.insertCell().textContent=location; const errorCell=row.insertCell(); 
                errorCell.colSpan=2; errorCell.textContent='Error fetching data';
            }
        } catch (error) {
            console.error(`Critical exception fetching weather for ${location}:`,error);
            while (row.cells.length>0) { row.deleteCell(0); }
            row.insertCell().textContent=location; const finalErrorCell=row.insertCell();
            finalErrorCell.colSpan=2; finalErrorCell.textContent='Connection failed';
        } await sleep(SLEEP_DELAY);
    } const tfoot=document.createElement('tfoot'); tfoot.id='weatherFoot';
    const footerRow=tfoot.insertRow(); const footerCell=footerRow.insertCell();
    footerCell.colSpan=3; footerCell.style.textAlign='center';
    footerCell.style.fontWeight='normal'; footerCell.style.padding='10px';
    footerCell.textContent=`${vocEntry} ${count}`; tableElem.appendChild(tfoot);
}
async function getWeatherFromProxy(location) {
    try {
        const response=await fetch('weather_proxy.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                location: location,
                units: sysDefUnits.value
            })
        }); if (!response.ok) {
            console.error(`HTTP error! status: ${response.status}`); return null;
        } const data=await response.json(); if (data&&data.error) {
            console.error('API Error:',data.error); return null;
        } return data;
    } catch (error) {
        console.error('Network or parsing error:',error); return null;
    }
}
async function fetchGitHubContent(repoUrl) {
    try {
        const [owner,repo]=repoUrl.split('/').slice(-2);
        const response=await fetch(`https://api.github.com/repos/${owner}/${repo}`,{
            headers: { 'Accept': 'application/vnd.github.v3+json' }
        }); if (!response.ok) {
            throw new Error(`GitHub API Error: ${response.status}`);
        } const data=await response.json();
        return {
            name: data.name, owner: data.owner.login,
            description: data.description, stars: data.stargazers_count,
            forks: data.forks_count, language: data.language
        }; await sleep(500);
    } catch (error) {
        console.error('GitHub API Error: ',error); return null;
    }
}
async function analyzeMultipleRepositories(repoUrls) {
    try {
        const allReposInfo=await Promise.all(
            repoUrls.map(async(url)=>{
                const repoInfo=await fetchGitHubContent(url);
                if (repoInfo) {
                    return `Repository: ${repoInfo.name}
                    Owner: ${repoInfo.owner}
                    Description: ${repoInfo.description}
                    Stars: ${repoInfo.stars}
                    Forks: ${repoInfo.forks}
                    Language: ${repoInfo.language}`;
                } return null;
            })
        ); const validRepos=allReposInfo.filter(info=>info!==null);
        const combinedInfo=validRepos.join('\n\n---\n\n');
        return combinedInfo;
    } catch (error) {
        console.error('Error analyzing repositories: ',error);
        return null;
    }
}
function currentPlaying(playerObj) {
    const audioElement=(isObject(playerObj))?playerObj:document.getElementById(playerObj);
    return EE2EE.decode(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
}
function audioSourceURL(playerObj) {
    const audioElem=(isObject(playerObj))?playerObj:document.getElementById(playerObj);
    let audioUrl=''; if ((audioElem)&&(!isLocalhost())) {
        audioUrl=((audioElem.currentSrc!='')&&(!audioElem.paused))?audioElem.currentSrc:'';
    } else { audioUrl=''; } return audioUrl;
}
function environmentInfo() {
    return `Now Playing: ${currentPlaying(audioPlayer)}
Audio Source URL: ${audioSourceURL(audioPlayer)}
User Personal Title: ${localizedTitle(sysDefSessionID.value,'title')}`;
}
async function getBackgroundImageAsBase64() {
    try {
        const body=document.querySelector('body'); let result='';
        const backgroundImage=window.getComputedStyle(body).getPropertyValue('background-image');
        const urlMatch=backgroundImage.match(/^url\(["']?(.*?)["']?\)$/);
        if (!urlMatch) {
            console.warn('Background image not found or invalid.');
            return null;
        } const imgUrl=urlMatch[1]??''; if (imgUrl!='') {
	    const response=await fetch(imgUrl);
            if (!response.ok) {
                throw new Error(`Cannot load image: HTTP ${response.status}`);
            } const blob=await response.blob();
            const base64String=await convertBlobToBase64(blob);
            result=(sysDefBase64.value!=0)?base64String:imgUrl;
	} else { result=null; } return result;
    } catch (error) { return null; }
}
async function getAudioFromPlayerAsBase64(playerId='audioPlayer') {
    try {
        audioUrl=audioSourceURL(playerId);
	let result=''; if (audioUrl!='') {
	    const response=await fetch(audioUrl);
            if (!response.ok) {
                throw new Error(`Cannot load audio: HTTP ${response.status}`);
            } const blob=await response.blob();
            const base64String=await convertBlobToBase64(blob);
	    result=(sysDefBase64.value!=0)?base64String:audioUrl;
	} else {
	    result=null;
	} return result;
    } catch (error) {
        return null;
    }
}
function convertBlobToBase64(blob) {
    return new Promise((resolve,reject)=>{
        const reader=new FileReader();
        reader.onload=()=>{
            const base64String=reader.result.split(',')[1];
            resolve(base64String);
        }; reader.onerror=()=>reject(reader.error);
        reader.readAsDataURL(blob);
    });
}
async function collectContextData() {
    try {
        const context={ imgUrl: '', audioUrl: '' };
        const imageBase64=await getBackgroundImageAsBase64();
        if (imageBase64) { context.imgUrl=(sysDefBase64.value!=0)?`data:image/png;base64,${imageBase64}`:imageBase64; }
        const audioBase64=await getAudioFromPlayerAsBase64();
        if (audioBase64) { context.audioUrl=(sysDefBase64.value!=0)?`data:audio/ogg;base64,${audioBase64}`:audioBase64; }
        return context;
    } catch (error) {
        console.error('Error in collectContextData:',error);
        return { imgUrl: '', audioUrl: '' };
    }
}
function createUserMessage(input,options={}) {
    const content=[{ type: 'text', text: input }];
    if (notBlank(options.imgUrl)) {
        content.push({
            type: 'image_url',
            image_url: { url: options.imgUrl }
        });
    } if (notBlank(options.audioUrl)) {
        content.push({
            type: 'audio',
            audio_url: { url: options.audioUrl }
        });
    } return { role: 'user', content };
}
async function callAI(messages,maxRetries=3) {
    let retries=0; while (retries<maxRetries) {
        try {
            const response=await fetch('artificial_intelligence.php',{
                method: 'POST',
                headers: { 'Content-Type': 'application/json', },
                body: JSON.stringify({
                    model: sysDefModel.value,
                    messages: messages,
                }),
            }); if (!response.ok) {
                const errorText=await response.text();
                if (response.status===429&&retries<maxRetries-1) {
                    retries++;
                    const retryAfter=parseInt(response.headers.get('Retry-After'))||1000*retries;
                    await sleep(retryAfter); continue;
                } throw new Error(`API Error: ${response.status} - ${errorText}`);
            } const data=await response.json(); return data.choices[0].message.content;
        } catch (error) {
            if (retries>=maxRetries-1) throw error; await sleep(2000); retries++;
        }
    } throw new Error('Max retries exceeded');
}
async function AI(input) {
    try {
        let historyArr=jsonarr(loadFile(sysDefSessionID.value+'_files/artificial_intelligence.json'));
        let userContext=await collectContextData();
        let userContent; const envInfo=environmentInfo();
        if (input.includes('https://github.com/')) {
            const repoUrls=input.match(/https:\/\/github\.com\/[^\s,.<>;"']+/g)||[];
            const allReposInfo=await analyzeMultipleRepositories(repoUrls);
            userContent=createUserMessage(`${input}\n${allReposInfo}\n${envInfo}`,userContext);
        } else {
            userContent=createUserMessage(`${input}\n${envInfo}`,userContext);
        } historyArr.push(userContent);
        const reply=await callAI(historyArr);
        historyArr.push({role: 'assistant', content: reply});
        set(sysDefSessionID.value+'_files/artificial_intelligence.json',JSON.stringify(historyArr),'rw');
        return reply;
    } catch (error) { return input; }
}