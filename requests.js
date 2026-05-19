function replacePackage(quid,quo,ord=0) {
    var toRem=quid.toString('').split(' ');
    var toSet=quo.toString('').split(' ');
    if (ord<0) {
        for (i=0; i<toSet.length; i++) {
            get(toSet[i],'i');
        } for (i=0; i<toRem.length; i++) {
            get('','u',toRem[i]);
        }
    } else {
        for (i=0; i<toRem.length; i++) {
            get('','u',toRem[i]);
        } for (i=0; i<toSet.length; i++) {
            get(toSet[i],'i');
        }
    }
}
function replaceRepo(quid,quo,ord=0) {
    var toRem=quid.toString('').split(' ');
    var toSet=quo.toString('').split(' ');
    if (ord<0) {
        for (i=0; i<toSet.length; i++) {
            get(toSet[i],'i','','raw');
        } for (i=0; i<toRem.length; i++) {
            get('','u',toRem[i],'raw');
        }
    } else {
        for (i=0; i<toRem.length; i++) {
            get('','u',toRem[i],'raw');
        } for (i=0; i<toSet.length; i++) {
            get(toSet[i],'i','','raw');
        }
    }
}
function uninstall(query) {
    for (i=0; i<query.split(' ').length; i++) {
        get('','u',query.split(' ')[i]);
    }
}
function terminate(query) {
    for (i=0; i<query.split(' ').length; i++) {
        get('','u',query.split(' ')[i],'raw');
    }
}
function omniRequest(mode,sort,group,angle,input,output,args,lock,ref,path) {
    window.location.href='index.php?mode='+mode+'&sort='+sort+'&group='+group+'&angle='+angle+'&input='+input+'&output='+output+'&args='+args+'&lock='+lock+'&ref='+ref+'&path='+path;
}
function omniAuthRequest(auth='signout',login='',pass='') {
    var form=document.createElement('form');
    form.method='POST'; form.action=window.location.href;
    var hiddenField=document.createElement('input');
    hiddenField.type='hidden'; hiddenField.name='auth';
    hiddenField.value=auth; form.appendChild(hiddenField);
    var hiddenField=document.createElement('input');
    hiddenField.type='hidden'; hiddenField.name='login';
    hiddenField.value=login; form.appendChild(hiddenField);
    var hiddenField=document.createElement('input');
    hiddenField.type='hidden'; hiddenField.name='password';
    hiddenField.value=pass; form.appendChild(hiddenField);
    document.body.appendChild(form); form.submit();
}
function omniSuggest() {
    var usersList=(sysDefUsersList.value).split(',');
    var curUser=usersList[rand(0,(usersList.length))];
    omniBoxAuthLogin.value=curUser; omniBoxAuthPass.value='';
    omniBoxAuthPass.focus();
}
function downloadFile(url,name) {
    fetch(url)
        .then(response=>{
            if (!response.ok) {
                throw new Error('Error loading file');
            } return response.blob();
        }).then(blob=>{
            const url=window.URL.createObjectURL(blob);
            const elem=document.createElement('a');
            elem.style.display='none';
            elem.href=url; elem.download=name;
            document.body.appendChild(elem);
            elem.click(); document.body.removeChild(elem);
            window.URL.revokeObjectURL(url);
        }).catch(error=>console.error('Something went wrong:',error));
}
function uploadFile() {
    var formData=new FormData();
    formData.append('file',document.getElementById('filebrowser').files[0],document.getElementById('filebrowser').files[0].name);
    formData.append('path',requestPath.value);
    var request=new XMLHttpRequest();
    request.onreadystatechange=function() {
        if (request.readyState==XMLHttpRequest.DONE) {
            window.location.reload();
        }
    }; request.open("POST","",true); request.send(formData);
}
function omniGo(mode) {
    omniRequest(mode,requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function omniRef() {
    var currentMode=requestMode.value;
    var currentRef=requestRef.value;
    return (sysDefIsRef.value=='true')?currentRef:currentMode;
}
function levelUp(path) {
    var res='/',arr=[],str='';
    if ((isPathRoot(path))||(isPathNull(path))) { res='./';
    } else if ((path.endsWith('/'))&&(path.split('/').length>1)) {
        arr=path.split('/'); arr.splice((arr.length-1),1);
        arr.splice((arr.length-1),1);
        str=arr.join('/'); res=(str!='')?str+'/':'/';
    } else if (!(path.endsWith('/'))&&(path.split('/').length>1)) {
        arr=path.split('/'); arr.splice((arr.length-1),1);
        str=arr.join('/'); res=(str!='')?str+'/':'/';
    } return res;
}
function treeUp(path) {
    var res='',arr=[],str='';
    if (path=='') { res='';
    } else if (!(path.includes('/'))) { res='';
    } else if ((path.includes('/'))&&(path.split('/').length>1)) {
        arr=path.split('/'); arr.splice((arr.length-1),1);
        str=arr.join('/'); res=(str!='')?str:'';
    } return res;
}
function isPathNull(path) { return ((path=='./')||(path=='')); }
function isPathRoot(path) { return ((path=='/')||(path=='//')); }
function omniBack(mode) {
    var currentMode=requestMode.value,currentArgs=requestArgs.value;
    var currentPath=requestPath.value,currentGroup=requestGroup.value;
    var changeMode='',args='',path='/',group='';
    if (currentMode=='file_manager') {
        args=currentArgs,path=levelUp(currentPath),group=currentGroup;
        changeMode=(isPathNull(currentPath))?mode:currentMode;
    } else if (currentMode=='properties') {
        args=treeUp(currentArgs),path=currentPath,group=currentGroup;
        changeMode=(currentArgs!='')?currentMode:mode;
    } else if (currentMode=='picture_gallery') {
        args=currentArgs; path=currentPath; group=treeUp(currentGroup);
        changeMode=(currentGroup!='')?currentMode:mode;
    } else {
        args=currentArgs; path=currentPath;
        group=currentGroup; changeMode=mode;
    } omniRequest(changeMode,requestSort.value,group,requestAngle.value,requestInput.value,requestOutput.value,args,requestLock.value,omniRef(),path);
}
function omniPath(input,args,lock) {
    omniRequest('properties',requestSort.value,requestGroup.value,requestAngle.value,input,requestOutput.value,args,lock,omniRef(),requestPath.value);
}
function omniDir(path) {
    omniRequest('file_manager',requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),path);
}
function omniRead(mode,input,lock) {
    omniRequest(mode,requestSort.value,requestGroup.value,requestAngle.value,input,requestOutput.value,requestArgs.value,lock,omniRef(),requestPath.value);
}
function omniGroup(group) {
    omniRequest('picture_gallery',requestSort.value,group,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function invertLockRequest() {
    var lock=(requestLock.value=='true')?'false':'true';
    omniRequest(requestMode.value,requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,lock,omniRef(),requestPath.value);
}
function omniDisp(output) {
    omniRequest('file_manager',requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,output,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function omniRotate(angle) {
    omniRequest('brigitte_bardot',requestSort.value,requestGroup.value,angle,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function omniSort(sort) {
    omniRequest('picture_gallery',sort,'',requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
