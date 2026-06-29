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
function populateNestedWeatherTable(content) {
    const nestedTable=document.createElement('table');
    nestedTable.style.borderCollapse='collapse';
    nestedTable.style.width='100%';
    if (!notEmpty(content)) {
        return nestedTable;
    } for (idx in content) {
        const nestedRow=document.createElement('tr');
        const indexCell=document.createElement('td');
        indexCell.textContent=idx;
        indexCell.style.padding='4px';
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
    if (requestMode.value=='weather') {
        let vocEntry=localizedVocWord();
        const tableElem=document.getElementById('weatherTable');
        const tableBody=document.getElementById('weatherData');
	    tableElem.setAttribute('class','wrapper'); tableBody.innerHTML='';
        const existingTfoot=document.getElementById('weatherFoot');
        if (existingTfoot) { existingTfoot.remove(); }
        const locations=(sysDefLocations.value).split(', ');
        let count=locations.length;
        for (const location of locations) {
             const row=tableBody.insertRow(); try {
                const data=await getWeather(location); if (data) {
                    row.insertCell().textContent=data.resolvedAddress;
                    const isoCode=sysDefUnits.value; const nestedCell=row.insertCell();
                    if ((isoCode=='US')||(isoCode=='LR')||(isoCode=='MM')) {
			            nestedCell.appendChild(populateNestedWeatherTable({'🔥':`${data.days[0].tempmax}°F`,'🌡️':`${data.days[0].temp}°F`,'❄️':`${data.days[0].tempmin}°F`}));
                    } else if ((isoCode=='UN')||(isoCode=='EU')||(isoCode=='AQ')) {
			            nestedCell.appendChild(populateNestedWeatherTable({'🔥':`${data.days[0].tempmax}K`,'🌡️':`${data.days[0].temp}K`,'❄️':`${data.days[0].tempmin}K`}));
                    } else {
			            nestedCell.appendChild(populateNestedWeatherTable({'🔥':`${data.days[0].tempmax}°C`,'🌡️':`${data.days[0].temp}°C`,'❄️':`${data.days[0].tempmin}°C`}));
                    } nestedCell.style.textAlign='center';
        	        nestedCell.style.fontWeight='normal';
 		            row.insertCell().textContent=data.days[0].conditions;
                } else {
                    row.insertCell().textContent=location;
                    row.insertCell().colSpan=3;
                    row.insertCell().textContent='Error fetching data';
                } await sleep(1000);
            } catch (error) {
                console.error(`Error fetching weather for ${location}:`,error); row.insertCell().textContent=location;
                row.insertCell().colSpan=3;
                row.insertCell().textContent='Error fetching data';
            }
        } const tfoot=document.createElement('tfoot');
        tfoot.id='weatherFoot'; const footerRow=tfoot.insertRow();
        const footerCell=footerRow.insertCell(); footerCell.colSpan=3;
        footerCell.style.textAlign='center';
        footerCell.style.fontWeight='normal';
        footerCell.style.padding='10px';
        footerCell.textContent=`${vocEntry} ${count}`;
        tableElem.appendChild(tfoot);
    }
}
async function getWeather(location) {
    const isoCode=sysDefUnits.value; const apiKey='YCHEZC3SXT8YSGV5MHFJHFXCY';
    let response=null; try {
        if ((isoCode=='US')||(isoCode=='LR')||(isoCode=='MM')) {
            response=await fetch(`https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}?unitGroup=us&lang=en&key=${apiKey}`);
        } else if ((isoCode=='GB')||(isoCode=='UK')) {
            response=await fetch(`https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}?unitGroup=uk&lang=en&key=${apiKey}`);
        } else if ((isoCode=='UN')||(isoCode=='EU')||(isoCode=='AQ')) {
            response=await fetch(`https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}?unitGroup=base&lang=en&key=${apiKey}`);
        } else if ((isoCode=='AE')||(isoCode=='SA')||(isoCode=='IQ')||(isoCode=='IR')||(isoCode=='KW')||(isoCode=='QA')) {
            response=await fetch(`https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}?unitGroup=metric&lang=en&key=${apiKey}`);
        } else {
            response=await fetch(`https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}?unitGroup=metric&lang=${isoCode.toLowerCase()}&key=${apiKey}`);
        } if (!response.ok) {
            throw new Error('Error getting data');
        } return await response.json();
    } catch (error) {
        console.error('Error: ',error); return null;
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
function audioMediaInfo(playerObj,returnUrl=true) {
    const audioElement=(isObject(playerObj))?playerObj:document.getElementById(playerObj);
    let playingNow=EE2EE.decode(sysDefMelody.value,sysDefSessionID.value,sysDefNumeric.value);
    let audioUrl=''; if (audioElement) {
        if ((!audioElement.src)&&(!audioElement.currentSrc)) {
            audioUrl=(returnUrl)?(audioElement.src||audioElement.currentSrc):playingNow;
        } else {
            audioUrl=(returnUrl)?'':playingNow;
        }
    } else {
        audioUrl=(returnUrl)?'':playingNow;
    } return audioUrl;
}
function environmentInfo() {
    return `Now Playing: ${audioMediaInfo(audioPlayer,false)},
Audio Source URL: ${audioMediaInfo(audioPlayer,true)},
User Personal Title: ${localizedTitle(sysDefSessionID.value,'title')}
    `;
}
async function getBackgroundImageAsBase64() {
    try {
        const body=document.querySelector('body');
        const backgroundImage=window.getComputedStyle(body).getPropertyValue('background-image');
        const urlMatch=backgroundImage.match(/^url\(["']?(.*?)["']?\)$/);
        if (!urlMatch) {
            console.warn('Background image not found or invalid.');
            return null;
        } const imgUri=urlMatch[1];
        const response=await fetch(imgUri);
        if (!response.ok) {
            throw new Error(`Не удалось загрузить изображение: HTTP ${response.status}`);
        } const blob=await response.blob();
        const base64String=await convertBlobToBase64(blob);
        return base64String;
    } catch (error) {
        console.error('Error getting background image base64 code:',error);
        return null;
    }
}
async function getAudioFromPlayerAsBase64(playerId='audioPlayer') {
    try {
        audioUrl=audioMediaInfo(audioPlayer,true);
        const response=await fetch(audioUrl);
        if (!response.ok) {
            throw new Error(`Cannot load audio: HTTP ${response.status}`);
        } const blob=await response.blob();
        const base64String=await convertBlobToBase64(blob);
        return base64String;
    } catch (error) {
        console.error('Error getting audio from player:', error);
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
        const context={ imgUrl: '', audio: '' };
        const imageBase64=await getBackgroundImageAsBase64();
        if (imageBase64) { context.imgUrl=`data:image/png;base64,${imageBase64}`; }
        const audioBase64=await getAudioFromPlayerAsBase64();
        if (audioBase64) { context.audio=`data:audio/ogg;base64,${audioBase64}`; }
        return context;
    } catch (error) {
        console.error('Error in collectContextData:',error);
        return { imgUrl: '', audio: '' };
    }
}
function createUserMessage(input,options={}) {
    const content=[{ type: 'text', text: input }];
    if (notBlank(options.imgUrl)) {
        content.push({
            type: 'image_url',
            image_url: { url: options.imgUrl }
        });
    } if (notNull(options.imageData)) {
        content.push({
            type: 'image',
            image: options.imageData
        });
    } if (notNull(options.document)) {
        content.push({
            type: 'document',
            document_url: { url: options.document }
        });
    } if (notNull(options.audio)) {
        content.push({
            type: 'audio',
            audio_url: { url: options.audio }
        });
    } if (notNull(options.video)) {
        content.push({
            type: 'video',
            video_url: { url: options.video }
        });
    } return { role: 'user', content };
}

async function callOpenRouter(messages, maxRetries = 3) {
  let retries = 0;
  while (retries < maxRetries) {
    try {
      const response = await fetch('openrouter.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          // никаких Authorization, никаких ключей здесь
        },
        body: JSON.stringify({
          model: sysDefModel.value,
          messages: messages,
        }),
      });

      if (!response.ok) {
        const errorText = await response.text();
        if (response.status === 429 && retries < maxRetries - 1) {
          retries++;
          const retryAfter = parseInt(response.headers.get('Retry-After')) || 1000 * retries;
          await sleep(retryAfter);
          continue;
        }
        throw new Error(`API Error: ${response.status} - ${errorText}`);
      }

      const data = await response.json();
      return data.choices[0].message.content;
    } catch (error) {
      if (retries >= maxRetries - 1) throw error;
      await sleep(2000);
      retries++;
    }
  }
  throw new Error('Max retries exceeded');
}

/*async function callOpenRouter(messages,maxRetries=3) {
    const apiKey=EE2EE.decode(sysDefSecret.value,sysDefSessionID.value,sysDefNumeric.value);
    if (!apiKey||apiKey.trim()==='') {
        throw new Error('OpenRouter API key is missing or invalid. Please check your settings.');
    } let retries=0; while (retries<maxRetries) {
        try {
            const response=await fetch(`https://openrouter.ai/api/v1/chat/completions`,{
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${apiKey}`,
                    'Content-Type': 'application/json',
                    'HTTP-Referer': window.location.href,
                    'X-Title': 'Eurohouse UX/UI'
                },
                body: JSON.stringify({
                    model: sysDefModel.value,
                    messages: messages
                })
            }); if (!response.ok) {
                const errorText=await response.text();
                if (response.status===429&&retries<maxRetries-1) {
                    retries++; const retryAfter=parseInt(response.headers.get('Retry-After'))||(1000*retries);
                    await sleep(retryAfter); continue;
                } throw new Error(`API Error: ${response.status} - ${errorText}`);
            } const data=await response.json(); return data.choices[0].message.content;
        } catch (error) {
            if (retries>=maxRetries-1) throw error; await sleep(2000); retries++;
        }
    } throw new Error('Max retries exceeded');
}*/

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
        const reply=await callOpenRouter(historyArr);
        historyArr.push({role: 'assistant', content: reply});
        set(sysDefSessionID.value+'_files/artificial_intelligence.json',JSON.stringify(historyArr),'rw');
        return reply;
    } catch (error) { return input; }
}