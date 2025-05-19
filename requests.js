function omniRequest(mode,sort,group,angle,input,output,args,lock,ref,path) {
    window.location.href='index.php?mode='+mode+'&sort='+sort+'&group='+group+'&angle='+angle+'&input='+input+'&output='+output+'&args='+args+'&lock='+lock+'&ref='+ref+'&path='+path;
}
function omniAuthRequest(auth,login,pass) {
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
    var msgbox={},indexed=decyphered=pass='';
    omniBoxAuthLogin.value=curUser;
    if (getUserData(curUser,'pam')!=0) {
        msgbox=jsonarr(loadFile(curUser+'_msgbox.json'));
        indexed=msgbox[0];
        decyphered=demorse(indexed,curUser);
        console.log(decyphered);
        pass=decyphered.split(':')[1];
        omniBoxAuthPass.value=pass;
        console.log(pass);
    } else { omniBoxAuthPass.value=''; }
    omniBoxAuthPass.focus();
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
    var currentMode=requestMode.value,currentRef=requestRef.value;
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
    } else if (currentMode=='object_info') {
        args=treeUp(currentArgs),path=currentPath,group=currentGroup;
        changeMode=(currentArgs!='')?currentMode:mode;
    } else if (currentMode=='browse_europedia') {
        args=currentArgs,path=currentPath,group=treeUp(currentGroup);
        changeMode=(currentGroup!='')?currentMode:mode;
    } else {
        args=currentArgs,path=currentPath;
        group=currentGroup,changeMode=mode;
    } omniRequest(changeMode,requestSort.value,group,requestAngle.value,requestInput.value,requestOutput.value,args,requestLock.value,omniRef(),path);
}
function omniPath(input,args,lock) {
    omniRequest('object_info',requestSort.value,requestGroup.value,requestAngle.value,input,requestOutput.value,args,lock,omniRef(),requestPath.value);
}
function omniPathDir(path,mode) {
    omniRequest(mode,requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),path);
}
function omniRead(mode,input,lock) {
    omniRequest(mode,requestSort.value,requestGroup.value,requestAngle.value,input,requestOutput.value,requestArgs.value,lock,omniRef(),requestPath.value);
}
function omniReadGroup(mode,group) {
    omniRequest(mode,requestSort.value,group,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function omniLock(lock) {
    omniRequest(requestMode.value,requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,lock,omniRef(),requestPath.value);
}
function omniDisp(mode,output,lock) {
    omniRequest(mode,requestSort.value,requestGroup.value,requestAngle.value,requestInput.value,output,requestArgs.value,lock,omniRef(),requestPath.value);
}
function omniRotate(angle) {
    omniRequest(requestMode.value,requestSort.value,requestGroup.value,angle,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function omniSwitch(group) {
    omniRequest(requestMode.value,requestSort.value,group,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
function omniSort(sort) {
    omniRequest(requestMode.value,sort,requestGroup.value,requestAngle.value,requestInput.value,requestOutput.value,requestArgs.value,requestLock.value,omniRef(),requestPath.value);
}
