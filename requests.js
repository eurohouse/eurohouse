function omniRequest(mode, sort, group, angle, input, output, args, lock, ref, path) {
    window.location.href = 'index.php?mode='+mode+'&sort='+sort+'&group='+group+'&angle='+angle+'&input='+input+'&output='+output+'&args='+args+'&lock='+lock+'&ref='+ref+'&path='+path;
}
function omniAuthRequest(auth, login, pass) {
    var cryptPass = CryptoJS.MD5(pass).toString();
    var form = document.createElement('form');
    form.method = 'POST'; form.action = window.location.href;
    var hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'auth';
    hiddenField.value = auth;
    form.appendChild(hiddenField);
    var hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'login';
    hiddenField.value = login;
    form.appendChild(hiddenField);
    var hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'password';
    hiddenField.value = cryptPass;
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
}
function uploadFile() {
    var formData = new FormData();
    formData.append('file', document.getElementById('filebrowser').files[0], document.getElementById('filebrowser').files[0].name);
    formData.append('path', requestPath.value);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            window.location.reload();
        }
    };
    request.open("POST", "", true);
    request.send(formData);
}
function omniGo(mode) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
function omniRef() {
    var currentMode = requestMode.value;
    var currentParent = sysDefParent.value;
    var currentRef = requestRef.value;
    return ref = (sysDefIsRef.value == 'true') ? currentRef : currentMode;
}
function omniBack(mode) {
    var currentMode = requestMode.value;
    var currentArgs = requestArgs.value;
    var currentPath = requestPath.value;
    var currentGroup = requestGroup.value;
    var changeMode = '', args = '', path = ''; group = '';
    if (currentMode == 'file_explorer' || currentMode == 'file_finder') {
        args = currentArgs, path = '', group = currentGroup;
        changeMode = ((currentPath == '') || (currentPath == '.')) ? mode : currentMode;
    } else if (currentMode == 'object_info') {
        args = '', path = currentPath, group = currentGroup;
        changeMode = (currentArgs != '') ? currentMode : mode;
    } else if (currentMode == 'browse_europedia') {
        args = currentArgs, path = currentPath, group = '';
        changeMode = (currentGroup != '') ? currentMode : mode;
    } else {
        args = '', path = '', group = '', changeMode = mode;
    }
    omniRequest(changeMode, requestSort.value, group, requestAngle.value, requestInput.value, requestOutput.value, args, requestLock.value, omniRef(), path);
}
function omniPath(input, args, lock) {
    omniRequest('object_info', requestSort.value, requestGroup.value, requestAngle.value, input, requestOutput.value, args, lock, omniRef(), requestPath.value);
}
function omniPathDir(path, mode) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), path);
}
function omniRead(mode, input, lock) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, input, requestOutput.value, requestArgs.value, lock, omniRef(), requestPath.value);
}
function omniLock(lock) {
    omniRequest(requestMode.value, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, lock, omniRef(), requestPath.value);
}
function omniDisp(mode, output, lock) {
    omniRequest(mode, requestSort.value, requestGroup.value, requestAngle.value, requestInput.value, output, requestArgs.value, lock, omniRef(), requestPath.value);
}
function omniRotate(angle) {
    omniRequest(requestMode.value, requestSort.value, requestGroup.value, angle, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
function omniSwitch(group) {
    omniRequest(requestMode.value, requestSort.value, group, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
function omniSort(sort) {
    omniRequest(requestMode.value, sort, requestGroup.value, requestAngle.value, requestInput.value, requestOutput.value, requestArgs.value, requestLock.value, omniRef(), requestPath.value);
}
