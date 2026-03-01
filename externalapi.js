const chatGPTHistory=[];
const chatGPTApiKey='w4tLe7eSQemPew3Vqp8tkGzO35Yrb2sM';
const weatherApiKey='YCHEZC3SXT8YSGV5MHFJHFXCY';
const chatGPTURL='https://api.mistral.ai/v1/chat/completions';
const chatGPTModel='mistral-large-latest';
const maxHistoryLength=10;
function latLongStr(lat=0,long=0) {
    var sLat=(lat<0)?'S':'N';
    var sLong=(long<0)?'W':'E';
    return lat+'°'+sLat+' '+long+'°'+sLong;
}
function tzOffsetStr(offs=0) {
    return 'UTC'+((offs<0)?'-':'+')+Math.abs(offs);
}
function tempStr(ave=0,min=0,max=0) {
    return ave+'°C ('+min+'°C~'+max+'°C)';
}
function curDateTimeStr(curDate,offs=0) {
    return curDate+' '+tzOffsetStr(offs);
}
function sunPositionStr(sunr,suns) {
    return sunr+'-'+suns;
}
async function populateWeatherTable() {
    if (requestMode.value=='weather') {
        const tableBody=document.getElementById('weatherData');
        tableBody.innerHTML=''; const locations=(sysDefLocations.value).split(', '); for (const location of locations) {
            try {
                const data=await getWeather(location);
                const row=tableBody.insertRow();
                if (data) {
                    row.insertCell().textContent=data.resolvedAddress;
                    row.insertCell().textContent=latLongStr(data.latitude,data.longitude);
                    row.insertCell().textContent=curDateTimeStr(data.days[0].datetime,data.tzoffset);
                    row.insertCell().textContent=tempStr(data.days[0].temp,data.days[0].tempmin,data.days[0].tempmax);
                    row.insertCell().textContent=`${data.days[0].precip} mm`;
                    row.insertCell().textContent=`${data.days[0].windspeed} km/h`;
                    row.insertCell().textContent=`${data.days[0].pressure} mmHg`;
                    row.insertCell().textContent=`${data.days[0].cloudcover}%`;
                    row.insertCell().textContent=sunPositionStr(data.days[0].sunrise,data.days[0].sunset);
                    row.insertCell().textContent=data.days[0].conditions;
                } else {
                    row.insertCell().textContent=location;
                    row.insertCell().colSpan=9;
                    row.insertCell().textContent='Error fetching data';
                }
            } catch (error) {
                console.error(`Error fetching weather for ${location}:`,error); row.insertCell().textContent=location;
                row.insertCell().colSpan=9;
                row.insertCell().textContent='Error fetching data';
            }
        }
    }
}
async function getWeather(location) {
    try {
        const response=await fetch(`https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/${location}?unitGroup=metric&key=${weatherApiKey}`);
        if (!response.ok) {
            throw new Error('Error getting data');
        } return await response.json();
    } catch (error) {
        console.error('Error: ',error); return null;
    }
}
async function fetchPageText(url) {
    try {
        const response=await fetch(`https://api.allorigins.win/get?url=${encodeURIComponent(url)}`); if (!response.ok) {
            throw new Error(`AllOriginsWin API Error: ${response.status}`);
        } const data=await response.json();
        const html=data.contents; const parser=new DOMParser();
        const doc=parser.parseFromString(html,'text/html');
        return doc.body.textContent||'';
    } catch (error) {
        console.error('Failed to fetch page:',error);
        return null;
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
            name: data.name,
            owner: data.owner.login,
            description: data.description,
            stars: data.stargazers_count,
            forks: data.forks_count,
            language: data.language
        };
    } catch (error) {
        console.error('GitHub API Error: ',error);
        return null;
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
async function chatGPTAI(input) {
    let reply; let image=($('body').css('background-image')).replace(/^url\(['"]?(.*?)['"]?\)$/i,'$1');
    try {
        if (input.includes('https://github.com/')) {
            const repoUrls=input.match(/https:\/\/github\.com\/[^\s]+/g)||[];
            const allReposInfo=await analyzeMultipleRepositories(repoUrls);
            chatGPTHistory.push({
                role: "user", content: [
                    {type: "text", text: `Analyze multiple Github repositories:\n${allReposInfo}`},
                    {type: "image_url", image_url: {url: image}}
                ]
            });
        } else if (input.includes('https://')) {
            const urls=input.match(/https?:\/\/[^\s]+/g)||[];
            if (urls.length===0) {
                throw new Error("No valid URLs found in input.");
            } const pageContents=[];
            for (const url of urls) {
                const text=await fetchPageText(url);
                if (text) {
                    pageContents.push(`Content from ${url}:\n${text.slice(0,20000)}`);
                } else {
                    pageContents.push(`Failed to fetch content from ${url}`);
                }
            } const combinedContent=pageContents.join('\n\n---\n\n');
            chatGPTHistory.push({
                role: "user", content: [
                    { type: "text", text: `Analyze the following web content. Provide:\n1. Main topic\n2. Tone (formal, casual, etc.)\n3. Key messages\n4. Potential issues\n\n${combinedContent}` },
                    { type: "image_url", image_url: {url: image}}
                ]
            });
        } else {
            chatGPTHistory.push({
                role: "user", content: [
                    {type: "text", text: input},
                    {type: "image_url", image_url: {url: image}}
                ]
            });
        } if (chatGPTHistory.length>maxHistoryLength) {
            chatGPTHistory.splice(0,chatGPTHistory.length-maxHistoryLength);
        } const response=await fetch(chatGPTURL,{
            method: "POST", headers: {
                "Authorization": `Bearer ${chatGPTApiKey}`,
                "Content-Type": "application/json"
            }, body: JSON.stringify({
                model: chatGPTModel,
                messages: chatGPTHistory.map(message=>({
                    role: message.role,
                    content: message.content
                }))
            })
        }); if (!response.ok) {
            throw new Error(`API Error: ${response.status} - ${await response.text()}`);
        } const data=await response.json();
        reply=data.choices[0].message.content;
        chatGPTHistory.push({ role: "assistant", content: reply });
    } catch (error) {
        console.error("Request Error: ",error.message);
        reply=input;
    } return reply;
}