const chatGPTHistory=[];
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
async function populateWeatherTable() {
    if (requestMode.value=='weather') {
        let vocEntry=localizedVocWord();
        const tableElem=document.getElementById('weatherTable');
        const tableBody=document.getElementById('weatherData');
        tableBody.innerHTML='';
        const existingTfoot=document.getElementById('weatherFoot');
        if (existingTfoot) { existingTfoot.remove(); }
        const locations=(sysDefLocations.value).split(', ');
        let count=locations.length;
        for (const location of locations) {
             const row=tableBody.insertRow(); try {
                const data=await getWeather(location); if (data) {
                    row.insertCell().textContent=data.resolvedAddress;
                    row.insertCell().textContent=`${data.latitude}°${(data.latitude<0)?'S':'N'} ${data.longitude}°${(data.longitude<0)?'W':'E'}`;
                    if ((isoCode=='US')||(isoCode=='LR')||(isoCode=='MM')) {
                        row.insertCell().textContent=`${data.days[0].tempmin}°F ${data.days[0].temp}°F ${data.days[0].tempmax}°F`;
                    } else if ((isoCode=='UN')||(isoCode=='EU')||(isoCode=='AQ')) {
                        row.insertCell().textContent=`${data.days[0].tempmin}K ${data.days[0].temp}K ${data.days[0].tempmax}K`;
                    } else {
                        row.insertCell().textContent=`${data.days[0].tempmin}°C ${data.days[0].temp}°C ${data.days[0].tempmax}°C`;
                    } row.insertCell().textContent=`${data.days[0].cloudcover}%`;
                    row.insertCell().textContent=data.days[0].conditions;
                } else {
                    row.insertCell().textContent=location;
                    row.insertCell().colSpan=5;
                    row.insertCell().textContent='Error fetching data';
                }
            } catch (error) {
                console.error(`Error fetching weather for ${location}:`,error); row.insertCell().textContent=location;
                row.insertCell().colSpan=5;
                row.insertCell().textContent='Error fetching data';
            }
        } const tfoot=document.createElement('tfoot');
        tfoot.id='weatherFoot'; const footerRow=tfoot.insertRow();
        const footerCell=footerRow.insertCell(); footerCell.colSpan=5;
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
        };
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
async function collectContextData() {
    return (!isLocalhost())?($('body').css('background-image')).replace(/^url\(['"]?(.*?)['"]?\)$/i,'$1'):'';
}
function createUserMessage(input,imgUrl='') {
    const content=[{type: 'text', text: input}];
    if (notBlank(imgUrl)) content.push({type: 'image_url', image_url: { url: imgUrl }});
    return {role: 'user', content};
}
async function callChatGPT(messages) {
    const response=await fetch('https://api.mistral.ai/v1/chat/completions',{
        method: 'POST', headers: {
            'Authorization': `Bearer w4tLe7eSQemPew3Vqp8tkGzO35Yrb2sM`,
            'Content-Type': 'application/json'
        }, body: JSON.stringify({model: 'mistral-large-latest', messages: messages})
    }); if (!response.ok) {
        const errorText=await response.text();
        throw new Error(`API Error: ${response.status} - ${errorText}`);
    } const data=await response.json();
    return data.choices[0].message.content;
}
async function chatGPTAI(input) {
    try {
        let userContext=await collectContextData();
        let userContent; if (input.includes('https://github.com/')) {
            const repoUrls=input.match(/https:\/\/github\.com\/[^\s,.<>;"']+/g)||[];
            const allReposInfo=await analyzeMultipleRepositories(repoUrls);
            userContent=((utob(sysDefMelody.value)!="")&&(sysDefPlaying.value!=0))?createUserMessage(`${input}\n${utob(sysDefMelody.value)}\n${allReposInfo}`,userContext):createUserMessage(`${input}\n${allReposInfo}`,userContext);
        } else {
            userContent=((utob(sysDefMelody.value)!="")&&(sysDefPlaying.value!=0))?createUserMessage(`${input}\n${utob(sysDefMelody.value)}`,userContext):createUserMessage(input,userContext);
        } chatGPTHistory.push(userContent);
        if (chatGPTHistory.length>10) {
            chatGPTHistory=chatGPTHistory.slice(-10);
        } const reply=await callChatGPT(chatGPTHistory);
        chatGPTHistory.push({role: 'assistant', content: reply});
        return reply;
    } catch (error) {
        console.error('Sorry, an error occurred. Please try again.');
        return input;
    }
}