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
function omniAuthRequest(login,password) {
    var form=document.createElement('form');
    form.method='POST'; form.action=window.location.href;
    var hiddenField=document.createElement('input');
    hiddenField.type='hidden'; hiddenField.name='login';
    hiddenField.value=login; form.appendChild(hiddenField);
    var hiddenField=document.createElement('input');
    hiddenField.type='hidden'; hiddenField.name='password';
    hiddenField.value=password; form.appendChild(hiddenField);
    document.body.appendChild(form); form.submit();
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
    formData.append('file',filebrowser.files[0],filebrowser.files[0].name);
    formData.append('path',requestPath.value);
    var request=new XMLHttpRequest(); request.onreadystatechange=function() {
        if (request.readyState==XMLHttpRequest.DONE) { window.location.reload(); }
    }; request.open("POST","",true); request.send(formData);
}
function omniGo(mode) {
    var sort=requestSort.value; var group=requestGroup.value; var angle=requestAngle.value;
    var input=requestInput.value; var output=requestOutput.value;
    var args=requestArgs.value; var lock=requestLock.value; var path=requestPath.value;
    omniRequest(mode,sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniRef() {
    var currentMode=requestMode.value; var currentRef=requestRef.value;
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
    var res='',arr=[],str=''; if (path=='') { res='';
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
    } var sort=requestSort.value; var group=requestGroup.value;
    var angle=requestAngle.value; var input=requestInput.value;
    var output=requestOutput.value; var lock=requestLock.value;
    omniRequest(changeMode,sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniPath(input,args,lock) {
    var sort=requestSort.value; var group=requestGroup.value; var angle=requestAngle.value;
    var output=requestOutput.value; var path=requestPath.value;
    omniRequest('properties',sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniDir(path) {
    var sort=requestSort.value; var group=requestGroup.value; var angle=requestAngle.value;
    var input=requestInput.value; var output=requestOutput.value;
    var args=requestArgs.value; var lock=requestLock.value;
    omniRequest('file_manager',sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniRead(mode,input,lock) {
    var sort=requestSort.value; var group=requestGroup.value; var angle=requestAngle.value;
    var output=requestOutput.value; var args=requestArgs.value; var path=requestPath.value;
    omniRequest(mode,sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniGroup(group) {
    var sort=requestSort.value; var angle=requestAngle.value;
    var input=requestInput.value; var output=requestOutput.value;
    var args=requestArgs.value; var lock=requestLock.value; var path=requestPath.value;
    omniRequest('picture_gallery',sort,group,angle,input,output,args,lock,omniRef(),path);
}
function invertLockRequest() {
    var lock=(requestLock.value=='true')?'false':'true';
    var mode=requestMode.value; var sort=requestSort.value;
    var group=requestGroup.value; var angle=requestAngle.value;
    var input=requestInput.value; var output=requestOutput.value;
    var args=requestArgs.value; var path=requestPath.value;
    omniRequest(mode,sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniDisp(output) {
    var mode=requestMode.value; var sort=requestSort.value;
    var group=requestGroup.value; var angle=requestAngle.value;
    var input=requestInput.value; var args=requestArgs.value;
    var lock=requestLock.value; var path=requestPath.value;
    omniRequest('file_manager',sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniRotate(angle) {
    var mode=requestMode.value; var sort=requestSort.value;
    var group=requestGroup.value; var input=requestInput.value;
    var output=requestOutput.value; var args=requestArgs.value;
    var lock=requestLock.value; var path=requestPath.value;
    omniRequest(mode,sort,group,angle,input,output,args,lock,omniRef(),path);
}
function omniSort(sort) {
    var mode=requestMode.value; var sort=requestSort.value;
    var angle=requestAngle.value; var input=requestInput.value;
    var output=requestOutput.value; var args=requestArgs.value;
    var lock=requestLock.value; var path=requestPath.value;
    omniRequest('picture_gallery',sort,'',angle,input,output,args,lock,omniRef(),path);
}
