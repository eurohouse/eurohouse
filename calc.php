<?php
$content = file_get_contents('journal');
?>
<html>
<head>
<?php include 'incl.php'; ?>
<title>Calculator</title>
<link rel="shortcut icon" href="calc.png?rev=<?=time();?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="hgui.css?rev=<?=time();?>">
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/nerdamer.core.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/Algebra.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/Calculus.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nerdamer@latest/Solve.js"></script>
<script>
window.onload = function() {
  document.getElementById('console').focus();
}
function calculate() {
  var input = document.getElementById('console').value;
  if (input.toString().includes('x')) {
    var solve = nerdamer.solve(input, 'x');
    var output = eval(solve);
    document.getElementById('console').value = output;
    var history = document.getElementById('terminal').value;
    history = history + input + '; x=' + output + '&#13;&#10;';
  } else {
    var output = eval(input);
    document.getElementById('console').value = output;
    var history = document.getElementById('terminal').value;
    history = history + input + '=' + output + '&#13;&#10;';
  }
    document.getElementById('terminal').value = history;
}
function savehistory(content) {
  var encode = encodeURIComponent(content);
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.location.reload();
    }
  };
  xmlhttp.open("POST","journal.php?content="+encode,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<input id='console' type="text" style="width:100%;" value="" onkeydown="
if (event.keyCode == 13) {
  calculate();
  var contents = document.getElementById('terminal').value;
  savehistory(contents);
}">
<br>
<p align=center>
<input class='east' type='button' style="width:40%;" onclick="
calculate();
var contents = document.getElementById('terminal').value;
savehistory(contents);" value="=">
<input class='south' type='button' style="width:40%;" onclick="
var contents = '';
savehistory(contents);" value="X">
</p>
<textarea id='terminal' style="width:100%;height:50%;">
<?=$content;?>
</textarea>
</body>
</html>
